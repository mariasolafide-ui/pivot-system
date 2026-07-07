<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use App\Models\Category;
use App\Models\Menu;
use App\Models\RetailProduct;
use App\Models\OrderItem;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request, string $qrToken)
    {
        // 1. Validasi Meja berdasarkan QR Token dan Simpan ke Session
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        session(['table_id' => $table->id, 'table_number' => $table->number, 'qr_token' => $qrToken]);

        // 2. Ambil Data Kategori, Pilihan Kategori Aktif, dan Kata Kunci Pencarian
        $categories       = Category::orderBy('name')->get();
        $selectedCategory = $request->get('category');
        $search           = $request->get('search');

        // 3. Inisialisasi awal pagination kosong (mencegah error jika query gagal)
        $menus          = Menu::whereRaw('1 = 0')->paginate(9);
        $retailProducts = RetailProduct::whereRaw('1 = 0')->paginate(8);

        // 4. Logika Pemisahan Tampilan: Produk Retail vs Menu Reguler Kafe
        if ($selectedCategory === 'retail-products') {
            $retailQuery = RetailProduct::where('is_available', true);
            
            // Pencarian Fleksibel Produk Retail: Nama, Deskripsi, dan Harga
            if ($search) {
                $retailQuery->where(function($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%')
                          ->orWhere('price', 'like', '%' . $search . '%');
                });
            }
            
            $retailProducts = $retailQuery->paginate(8)->withQueryString();
        } else {
            $menuQuery = Menu::with('category')->where('is_available', true);
            
            // Filter Berdasarkan Kategori Menu Reguler (jika dipilih)
            if ($selectedCategory) {
                $menuQuery->whereHas('category', fn($q) => $q->where('slug', $selectedCategory));
            }
            
            // Pencarian Fleksibel Menu Reguler: Nama, Deskripsi, Kategori, dan Harga
            if ($search) {
                $menuQuery->where(function($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%')
                          ->orWhere('price', 'like', '%' . $search . '%')
                          ->orWhereHas('category', function($q) use ($search) {
                              $q->where('name', 'like', '%' . $search . '%');
                          });
                });
            }
            
            $menus = $menuQuery->paginate(9)->withQueryString();
        }

        // 5. Mengambil Data Menu Terlaris (Best Seller) berdasarkan Kuantitas OrderItem
        $bestSellerIds = OrderItem::selectRaw('menu_id, SUM(quantity) as total_qty')
            ->groupBy('menu_id')->orderByDesc('total_qty')->limit(3)->pluck('menu_id');

        $bestSellers = Menu::whereIn('id', $bestSellerIds)->where('is_available', true)
            ->get()->sortBy(fn($m) => $bestSellerIds->search($m->id));

        // 6. Mengambil Data Voucher Promo yang Masih Aktif Hari Ini
        $today  = Carbon::today();
        $promos = Promo::where('is_active', true)
            ->where('valid_from', '<=', $today)->where('valid_until', '>=', $today)->get();

        // 7. Mengambil Data Keranjang Belanja Sementara dari Session Meja Terkait
        $cart = session('cart_' . $table->id, []);

        // 8. Teaser Tambahan Produk Retail untuk Ditampilkan di Sisi Bawah/Samping Menu
        $retailTeaser = RetailProduct::where('is_available', true)
            ->where('stock', '>', 0)->latest()->limit(2)->get();

        // 9. Kirim Semua Variabel ke View customer/menu.blade.php
        return view('customer.menu', compact(
            'table', 'categories', 'menus', 'retailProducts', 'bestSellers',
            'promos', 'cart', 'selectedCategory', 'search', 'retailTeaser'
        ));
    }

    public function show(string $qrToken, Menu $menu)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        return view('customer.menu-detail', compact('table', 'menu'));
    }

    public function showRetail(string $qrToken, RetailProduct $retailProduct)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        return view('customer.retail-detail', compact('table', 'retailProduct'));
    }

    /**
     * Dipanggil via fetch() dari modal add-cart.
     * Varian diambil dari variantGroups (many-to-many global).
     */
    public function getOptions(string $qrToken, Menu $menu)
    {
        $menu->load([
            'variantGroups' => function ($q) {
                $q->with(['variants' => function ($q2) {
                    $q2->where('is_available', true)
                       ->orderByDesc('is_default')
                       ->orderBy('extra_price');
                }]);
            },
            'addons' => function ($q) {
                $q->where('is_available', true)->orderBy('price');
            },
        ]);

        $variantGroups = $menu->variantGroups->map(function ($group) {
            return [
                'group_id'   => $group->id,
                'group_name' => $group->name,
                'variants'   => $group->variants->map(fn($v) => [
                    'id'          => $v->id,
                    'name'        => $v->name,
                    'extra_price' => (int) $v->extra_price,
                    'is_default'  => (bool) $v->is_default,
                ])->values(),
            ];
        })->values();

        $addons = $menu->addons->map(fn($a) => [
            'id'    => $a->id,
            'name'  => $a->name,
            'price' => (int) $a->price,
        ])->values();

        return response()->json([
            'base_price'     => (float) $menu->price,
            'variant_groups' => $variantGroups,
            'addons'         => $addons,
        ]);
    }
}