<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Models\CafeTable;
use App\Models\Menu; // ← TAMBAHKAN INI
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
   public function show(string $qrToken)
{
    $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
    $cart = session('cart_' . $table->id, []);

    if (empty($cart)) {
        return redirect()->route('customer.menu', $qrToken)
            ->with('error', 'Keranjang kosong.');
    }

    // Ambil kategori dari menu di keranjang
    $categoryIdsInCart = collect($cart)
        ->pluck('menu_id')
        ->filter()
        ->map(function($menuId) {
            $menu = Menu::find($menuId);
            return $menu ? $menu->category_id : null;
        })
        ->filter()
        ->unique()
        ->toArray();

    $subtotal = collect($cart)->sum(fn($item) => $item['unit_price'] * $item['quantity']);

    $today = Carbon::today();
    
    // Ambil semua promo aktif dan tambahkan info eligibility
    $promos = Promo::where('is_active', true)
        ->where('valid_from', '<=', $today)
        ->where('valid_until', '>=', $today)
        ->with('category')
        ->get()
        ->map(function($promo) use ($subtotal, $categoryIdsInCart) {
            // Tambahkan properti eligibility ke setiap promo
            $isEligible = true;
            $reason = '';
            
            // Cek minimal belanja
            if ($subtotal < $promo->min_order) {
                $isEligible = false;
                $reason = 'Min. belanja Rp ' . number_format($promo->min_order, 0, ',', '.');
            }
            
            // Cek kategori (jika ada)
            if ($isEligible && $promo->category_id !== null) {
                if (!in_array($promo->category_id, $categoryIdsInCart)) {
                    $isEligible = false;
                    $reason = 'Khusus: ' . ($promo->category ? $promo->category->name : '');
                }
            }
            
            $promo->is_eligible = $isEligible;
            $promo->ineligibility_reason = $reason;
            
            return $promo;
        });

    return view('customer.checkout', compact('table', 'cart', 'promos', 'subtotal'));
}

public function store(CheckoutRequest $request, string $qrToken)
{
    $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
    $cart = session('cart_' . $table->id, []);

    if (empty($cart)) {
        return redirect()->route('customer.menu', $qrToken)
            ->with('error', 'Keranjang kosong.');
    }

    // Calculate subtotal
    $subtotal = collect($cart)->sum(fn($item) => $item['unit_price'] * $item['quantity']);
    $discount = 0;
    $promoId = null;

    // Validate promo
    if ($request->filled('promo_code')) {
        $today = Carbon::today();
        $promo = Promo::where('code', $request->promo_code)
            ->where('is_active', true)
            ->where('valid_from', '<=', $today)
            ->where('valid_until', '>=', $today)
            ->with('category')
            ->first();

        if (!$promo) {
            return back()->withErrors(['promo_code' => 'Kode promo tidak valid atau sudah kadaluarsa.'])
                ->withInput();
        }

        // Cek minimal belanja
        if ($subtotal < $promo->min_order) {
            return back()->withErrors(['promo_code' => 'Minimal belanja Rp ' . number_format($promo->min_order, 0, ',', '.') . ' untuk promo ini.'])
                ->withInput();
        }

        // Cek kategori
        if ($promo->category_id) {
            $categoryIdsInCart = collect($cart)
                ->pluck('menu_id')
                ->filter()
                ->map(function($menuId) {
                    $menu = Menu::find($menuId);
                    return $menu ? $menu->category_id : null;
                })
                ->filter()
                ->unique()
                ->toArray();

            if (!in_array($promo->category_id, $categoryIdsInCart)) {
                return back()->withErrors(['promo_code' => 'Promo ini hanya berlaku untuk kategori "' . $promo->category->name . '".'])
                    ->withInput();
            }
        }

        $discount = $promo->calculateDiscount($subtotal);
        $promoId = $promo->id;
    }

    $total = $subtotal - $discount;

    // Generate transaction ID
    $transactionId = 'TRX-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

    try {
        DB::beginTransaction();

        // 🔥 PERBAIKAN: QRIS dan Cash beda pesan
        if ($request->payment_method === 'qris') {
            $paymentStatus = 'paid';
            $successMsg = 'Pembayaran QRIS berhasil! Pesanan Anda sedang diproses.';
        } else {
            $paymentStatus = 'pending';
            $successMsg = 'Pesanan berhasil dibuat. Silakan lakukan pembayaran ke kasir.';
        }

        $order = Order::create([
            'transaction_id' => $transactionId,
            'table_id'       => $table->id,
            'customer_name'  => $request->customer_name,
            'promo_id'       => $promoId,
            'subtotal'       => $subtotal,
            'discount'       => $discount,
            'total'          => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => $paymentStatus,
            'order_status'   => 'menunggu',
            'notes'          => $request->notes,
        ]);

        // LOOP CART
        foreach ($cart as $cartKey => $item) {
            $isRetail = isset($item['is_retail']) && $item['is_retail'] === true;

            $orderItemData = [
                'order_id'   => $order->id,
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal'   => $item['unit_price'] * $item['quantity'],
                'notes'      => $item['notes'] ?? null,
            ];

            if ($isRetail) {
                $orderItemData['retail_product_id'] = $item['retail_product_id'];
                $orderItemData['menu_id'] = null;
                $orderItemData['variant_id'] = null;
                $orderItemData['variant_name'] = null;
                $orderItemData['addon_ids'] = null;
                $orderItemData['addon_names'] = null;
            } else {
                $orderItemData['menu_id'] = $item['menu_id'];
                $orderItemData['retail_product_id'] = null;
                $orderItemData['variant_id'] = $item['variant_id'] ?? null;
                $orderItemData['variant_name'] = $item['variant_name'] ?? null;
                $orderItemData['addon_ids'] = isset($item['addon_ids']) ? json_encode($item['addon_ids']) : null;
                $orderItemData['addon_names'] = $item['addon_names'] ?? null;
            }

            OrderItem::create($orderItemData);
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
    }

    // Clear cart
    session()->forget('cart_' . $table->id);
    session(['last_transaction_id' => $transactionId]);

    // Track active transactions
    $activeTrxs = session('active_transactions', []);
    if (!in_array($transactionId, $activeTrxs)) {
        $activeTrxs[] = $transactionId;
        session(['active_transactions' => $activeTrxs]);
    }

    return redirect()->route('customer.status', $transactionId)
        ->with('success', $successMsg);
}
}