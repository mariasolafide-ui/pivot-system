<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Category;
use App\Models\Menu;
use App\Models\VariantGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // ────────────────────────────────────────────────────────────────────
    // INDEX (Pencarian Lengkap: Nama, Harga, & Kategori + Statistik)
    // ────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        // Ambil keyword pencarian jika ada
        $search = $request->input('search');

        // Query menu utama dengan kondisi pencarian nama, harga, ATAU kategori
        $menus = Menu::with('category', 'variantGroups', 'addons')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('price', 'like', "%{$search}%")
                      // Mencari berdasarkan nama kategori di tabel relasi
                      ->orWhereHas('category', function($catQuery) use ($search) {
                          $catQuery->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(15);

        // Ambil data pendukung untuk Form Modal (Tambah/Edit)
        $categories    = Category::orderBy('name')->get();
        $variantGroups = VariantGroup::where('is_active', true)->with('variants')->orderBy('name')->get();
        $addons        = Addon::where('is_available', true)->orderBy('name')->get();

        // ── Kumpulan Data Statistik Card Terlaris ─────────────────────────
        $topMenuOverall = \App\Models\OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('menu_id')->orderByDesc('total_qty')->with('menu.category')->first();

        $topKopi = \App\Models\OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->where('categories.name', 'like', '%Kopi%')
            ->groupBy('order_items.menu_id')->orderByDesc('total_qty')->with('menu')->first();

        $topMakanan = \App\Models\OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->where('categories.name', 'like', '%Makanan%')
            ->groupBy('order_items.menu_id')->orderByDesc('total_qty')->with('menu')->first();

        $topMinuman = \App\Models\OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->whereIn('categories.name', ['Non-Kopi', 'Minuman Dingin'])
            ->groupBy('order_items.menu_id')->orderByDesc('total_qty')->with('menu')->first();

        return view('admin.menus.index', compact(
            'menus', 'categories', 'variantGroups', 'addons',
            'topMenuOverall', 'topKopi', 'topMakanan', 'topMinuman'
        ));
    }

    // ────────────────────────────────────────────────────────────────────
    // STORE (Tambah Menu Baru)
    // ────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'price'             => 'required|numeric|min:0',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:150',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available'      => 'nullable|boolean',
            'variant_group_ids' => 'nullable|array',
            'variant_group_ids.*' => 'exists:variant_groups,id',
            'addon_ids'         => 'nullable|array',
            'addon_ids.*'       => 'exists:addons,id',
        ]);

        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu = Menu::create($data);

        // Sync pivot — many-to-many
        $menu->variantGroups()->sync($request->input('variant_group_ids', []));
        $menu->addons()->sync($request->input('addon_ids', []));

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    // ────────────────────────────────────────────────────────────────────
    // UPDATE (Perbarui Menu)
    // ────────────────────────────────────────────────────────────────────
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'price'             => 'required|numeric|min:0',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:150',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available'      => 'nullable|boolean',
            'variant_group_ids'   => 'nullable|array',
            'variant_group_ids.*' => 'exists:variant_groups,id',
            'addon_ids'           => 'nullable|array',
            'addon_ids.*'         => 'exists:addons,id',
        ]);

        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($menu->image) Storage::disk('public')->delete($menu->image);
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        // Sync pivot — otomatis melacak perubahan item checkbox yang dipilih
        $menu->variantGroups()->sync($request->input('variant_group_ids', []));
        $menu->addons()->sync($request->input('addon_ids', []));

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    // ────────────────────────────────────────────────────────────────────
    // DESTROY (Hapus Menu beserta Gambar)
    // ────────────────────────────────────────────────────────────────────
    public function destroy(Menu $menu)
    {
        if ($menu->image) Storage::disk('public')->delete($menu->image);

        // Keterangan pivot otomatis terhapus karena cascadeOnDelete di migration
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus.');
    }

    // ────────────────────────────────────────────────────────────────────
    // TOGGLE AVAILABLE (Switch Status Ketersediaan Cepat)
    // ────────────────────────────────────────────────────────────────────
    public function toggle(Menu $menu)
    {
        $menu->update(['is_available' => !$menu->is_available]);
        $status = $menu->is_available ? 'tersedia' : 'tidak tersedia';
        return back()->with('success', "Menu \"{$menu->name}\" sekarang {$status}.");
    }

    // ────────────────────────────────────────────────────────────────────
    // EDIT DATA (Dipanggil AJAX Fetch saat Modal Edit Terbuka)
    // ────────────────────────────────────────────────────────────────────
    public function editData(Menu $menu)
    {
        $menu->load('variantGroups', 'addons');

        return response()->json([
            // Mengirimkan array ID yang saat ini aktif untuk menu tersebut
            'variant_group_ids' => $menu->variantGroups->pluck('id'),
            'addon_ids'         => $menu->addons->pluck('id'),
        ]);
    }
}