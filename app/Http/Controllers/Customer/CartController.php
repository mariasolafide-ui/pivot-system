<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\CafeTable;
use App\Models\Menu;
use App\Models\MenuVariant;
use App\Models\RetailProduct;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCartKey(int $tableId): string
    {
        return 'cart_' . $tableId;
    }

    public function add(Request $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();

        $request->validate([
            'menu_id'           => 'nullable|required_without:retail_product_id|exists:menus,id',
            'retail_product_id' => 'nullable|required_without:menu_id|exists:retail_products,id',
            'quantity'          => 'required|integer|min:1',
            'notes'             => 'nullable|string|max:255',
            'variant_id'        => 'nullable|exists:menu_variants,id',
            'addon_ids'         => 'nullable|array',
            'addon_ids.*'       => 'exists:addons,id',
        ]);

        $cartKey = $this->getCartKey($table->id);
        $cart    = session($cartKey, []);
        $notes   = $request->input('notes');
        $itemName = '';

        // ── PRODUK RETAIL ──────────────────────────────────────────────
        if ($request->filled('retail_product_id')) {
            $retail = RetailProduct::findOrFail($request->retail_product_id);

            if (!$retail->is_available || $retail->stock < 1) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Produk retail tidak tersedia.'
                    ], 400);
                }
                return back()->with('error', 'Produk retail tidak tersedia.');
            }

            $qty = min((int) $request->quantity, $retail->stock);
            $itemKey = 'retail_' . $retail->id . '_' . md5($notes ?? '');
            $itemName = $retail->name;

            if (isset($cart[$itemKey])) {
                $cart[$itemKey]['quantity'] += $qty;
            } else {
                $cart[$itemKey] = [
                    'retail_product_id' => $retail->id,
                    'name'              => $retail->name,
                    'quantity'          => $qty,
                    'unit_price'        => (float) $retail->price,
                    'notes'             => $notes,
                    'is_retail'         => true,
                ];
            }

            session([$cartKey => $cart]);
            $cartCount = collect(session($cartKey, []))->sum('quantity');

            $msg = "\"{$retail->name}\" ditambahkan ke keranjang.";
            session()->flash('success', $msg);

            // Jika request AJAX tapi dari tombol menu langsung yang tidak memicu notif,
            // kita bisa mengaturnya via header, atau jika ragu, biarkan redirect bawaan bekerja.
            if ($request->ajax() && !$request->has('from_menu_page')) {
                return response()->json([
                    'success' => true,
                    'message' => $msg,
                    'cart_count' => $cartCount
                ]);
            }
            return back();
        }

        // ── MENU KAFE ──────────────────────────────────────────────────
        $menu = Menu::with(['variantGroups.variants', 'addons'])->findOrFail($request->menu_id);

        if (!$menu->is_available) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak tersedia.'
                ], 400);
            }
            return back()->with('error', 'Menu tidak tersedia.');
        }

        $finalPrice  = (float) $menu->price;
        $variantName = null;
        $addonIds    = [];
        $addonNames  = null;
        $itemName = $menu->name;

        if ($request->filled('variant_id')) {
            $allVariants = $menu->variantGroups->flatMap(fn($g) => $g->variants);
            $variant     = $allVariants->firstWhere('id', $request->variant_id);

            if ($variant) {
                $finalPrice  += (float) $variant->extra_price;
                $variantName  = $variant->name;
            }
        }

        if ($request->filled('addon_ids')) {
            $menuAddonIds   = $menu->addons->pluck('id')->toArray();
            $validAddonIds  = array_intersect($request->addon_ids, $menuAddonIds);

            if (!empty($validAddonIds)) {
                $selectedAddons = $menu->addons->whereIn('id', $validAddonIds);
                foreach ($selectedAddons as $addon) {
                    $finalPrice += (float) $addon->price;
                    $addonIds[]  = $addon->id;
                }
                $addonNames = $selectedAddons->pluck('name')->join(', ');
            }
        }

        $itemKey = $menu->id
            . '_v' . ($request->variant_id ?? '0')
            . '_a' . implode('-', $addonIds)
            . '_'  . md5($notes ?? '');

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += (int) $request->quantity;
        } else {
            $cart[$itemKey] = [
                'menu_id'      => $menu->id,
                'name'         => $menu->name,
                'quantity'     => (int) $request->quantity,
                'unit_price'   => $finalPrice,
                'notes'        => $notes,
                'variant_id'   => $request->variant_id ?? null,
                'variant_name' => $variantName,
                'addon_ids'    => $addonIds ?: null,
                'addon_names'  => $addonNames,
                'is_retail'    => false,
            ];
        }

        session([$cartKey => $cart]);
        $cartCount = collect(session($cartKey, []))->sum('quantity');

        $msg = "\"{$menu->name}\" ditambahkan ke keranjang.";
        session()->flash('success', $msg);

        // MODIFIKASI DISINI: Jika request dikirim dari tombol cepat halaman menu,
        // kita instruksikan browser untuk reload halaman agar notifikasi bawaan Blade muncul.
        if ($request->ajax() && !$request->has('from_menu_page')) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'cart_count' => $cartCount
            ]);
        }

        return back();
    }

    public function update(Request $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        $request->validate([
            'item_key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartKey = $this->getCartKey($table->id);
        $cart    = session($cartKey, []);
        $itemKey = $request->item_key;

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] = (int) $request->quantity;
            session([$cartKey => $cart]);
        }

        $cartCount = collect(session($cartKey, []))->sum('quantity');

        $msg = 'Keranjang diperbarui.';
        session()->flash('success', $msg);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'cart_count' => $cartCount
            ]);
        }

        return back();
    }

    public function remove(Request $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        $request->validate(['item_key' => 'required|string']);

        $cartKey = $this->getCartKey($table->id);
        $cart    = session($cartKey, []);
        $itemKey = $request->item_key;

        unset($cart[$itemKey]);
        session([$cartKey => $cart]);

        $cartCount = collect(session($cartKey, []))->sum('quantity');

        $msg = 'Item dihapus dari keranjang.';
        session()->flash('success', $msg);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'cart_count' => $cartCount
            ]);
        }

        return back();
    }

    public function clear(string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        session()->forget('cart_' . $table->id);
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    
}