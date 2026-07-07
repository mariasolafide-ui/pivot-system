<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WaiterCall;
use App\Models\Category;
use App\Models\CafeTable;  // ← Tambahkan use ini
use App\Models\RetailProduct; // ← Tambahkan untuk retail products
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ── Filter periode pemasukan ──────────────────────────────
        $period = $request->get('period', '1'); // ← Ubah default dari 30 ke 1 (Hari Ini)

        if ($period === 'custom') {
            $startDate = $request->filled('start_date')
                ? Carbon::parse($request->start_date)->startOfDay()
                : Carbon::now()->subDays(30)->startOfDay();
            $endDate = $request->filled('end_date')
                ? Carbon::parse($request->end_date)->endOfDay()
                : Carbon::now()->endOfDay();
        } elseif ($period === '7') {
            $startDate = Carbon::now()->subDays(7)->startOfDay();
            $endDate   = Carbon::now()->endOfDay();
        } elseif ($period === '1') {
            $startDate = Carbon::today()->startOfDay();
            $endDate   = Carbon::today()->endOfDay();
        } elseif ($period === '30') {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate   = Carbon::now()->endOfDay();
        } else {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate   = Carbon::now()->endOfDay();
        }

        // ── Statistik pemasukan ───────────────────────────────────
        $revenueQuery = Order::where('payment_status', 'paid')
            ->whereNotIn('order_status', ['dibatalkan'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalRevenue = (clone $revenueQuery)->sum('total');
        $totalOrders  = (clone $revenueQuery)->count();

        $todayRevenue = Order::where('payment_status', 'paid')
            ->whereNotIn('order_status', ['dibatalkan'])
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        // ── Stat cards real-time ──────────────────────────────────
        $activeOrders       = Order::whereIn('order_status', ['menunggu', 'diproses'])->count();
        $pendingPayments    = Order::where('payment_status', 'pending')
            ->whereNotIn('order_status', ['dibatalkan'])->count();
        $pendingWaiterCalls = WaiterCall::where('status', 'pending')->count();
        $waiterCalls        = WaiterCall::with('table')->where('status', 'pending')->latest()->get();

        // ── Produk Retail untuk Stok Menipis ──────────────────────
        $retailProducts = RetailProduct::orderBy('stock', 'asc')->get();

        // ── Menu terlaris (all time, top 1 per kategori utama) ────
        // Top menu keseluruhan
        $topMenuOverall = OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->with('menu.category')
            ->first();

        // Top menu kategori Kopi
        $topKopi = OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->where('categories.name', 'like', '%Kopi%')
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        // Top menu Makanan
        $topMakanan = OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->where('categories.name', 'like', '%Makanan%')
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        // Top menu Minuman (non-kopi + minuman dingin)
        $topMinuman = OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->whereIn('categories.name', ['Non-Kopi', 'Minuman Dingin'])
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        // ── Peringkat kategori terlaris ───────────────────────────
        $topCategories = Category::select('categories.id', 'categories.name',
                DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id') // ← Tambahkan join orders
            ->where('orders.payment_status', 'paid') // ← Filter hanya yang sudah dibayar
            ->whereNotIn('orders.order_status', ['dibatalkan']) // ← Filter tidak batal
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_qty')
            ->limit(5) // ← Batasi 5 kategori teratas
            ->get();

        // ── Peringkat menu terlaris (top 10 gabungan semua kategori) ──
        $topMenus = OrderItem::select('order_items.menu_id',
                DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id') // ← Tambahkan join orders
            ->where('orders.payment_status', 'paid') // ← Filter hanya yang sudah dibayar
            ->whereNotIn('orders.order_status', ['dibatalkan']) // ← Filter tidak batal
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->with('menu.category')
            ->get();

        // ── Status per meja ───────────────────────────────────────
        $tableStatuses = CafeTable::orderBy('number')
            ->with(['orders' => function ($q) {
                $q->whereNotIn('order_status', ['selesai', 'dibatalkan'])
                  ->latest()
                  ->limit(1);
            }])
            ->get();

        // ── Data Jurnal Buku Transaksi Masuk ──────────────────────
        $transactions = Order::with('table')
            ->where('payment_status', 'paid')
            ->whereNotIn('order_status', ['dibatalkan'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->limit(20) // ← Batasi untuk performa
            ->get();

        // ── Cek apakah user mengklik tombol cetak laporan ────────
        if ($request->has('print_mode')) {
            return view('admin.report', compact(
                'activeOrders', 'pendingPayments', 'pendingWaiterCalls', 'waiterCalls',
                'totalRevenue', 'totalOrders', 'todayRevenue',
                'period', 'startDate', 'endDate',
                'topMenuOverall', 'topKopi', 'topMakanan', 'topMinuman',
                'topCategories', 'topMenus',
                'tableStatuses', 'transactions', 'retailProducts'
            ));
        }

        // ── Tampilkan dashboard ──────────────────────────────────
        return view('admin.dashboard', compact(
            'activeOrders', 'pendingPayments', 'pendingWaiterCalls', 'waiterCalls',
            'totalRevenue', 'totalOrders', 'todayRevenue',
            'period', 'startDate', 'endDate',
            'topMenuOverall', 'topKopi', 'topMakanan', 'topMinuman',
            'topCategories', 'topMenus',
            'tableStatuses', 'transactions', 'retailProducts'
        ));
    }

    public function notificationsPeek()
    {
        $pendingOrders = Order::with('table')
            ->where('order_status', 'menunggu')
            ->latest()
            ->get()
            ->map(fn($order) => [
                'id' => $order->id,
                'transaction_id' => $order->transaction_id,
                'table_number' => $order->table?->number,
                'customer_name' => $order->customer_name,
                'total' => (float) $order->total,
                'created_at_diff' => $order->created_at->diffForHumans(),
                'url' => route('admin.orders.show', $order->id)
            ]);

        $pendingWaiterCalls = WaiterCall::with('table')
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(fn($call) => [
                'id' => $call->id,
                'table_number' => $call->table?->number,
                'created_at_diff' => $call->created_at->diffForHumans(),
                'done_url' => route('admin.waiter-calls.done', $call->id),
                'url' => route('admin.waiter-calls.index')
            ]);

        return response()->json([
            'orders' => $pendingOrders,
            'waiter_calls' => $pendingWaiterCalls,
        ]);
    }

    // public function laporan(Request $request)
    // {
    //     $range = $request->input('range', '7_days');
    //     $startDate = now()->subDays(7)->startOfDay();
    //     $endDate = now()->endOfDay();

    //     if ($range === 'today') {
    //         $startDate = now()->startOfDay();
    //     } elseif ($range === '30_days') {
    //         $startDate = now()->subDays(30)->startOfDay();
    //     } elseif ($range === 'custom' && $request->filled('start_date') && $request->filled('end_date')) {
    //         $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
    //         $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
    //     }

    //     // Ambil data laporan
    //     $salesReports = Order::with(['items.menu', 'table'])
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->get();

    //     // Hitung seluruh pesanan yang tidak dibatalkan
    //     $totalOrdersCount = $salesReports->whereNotIn('order_status', ['dibatalkan'])->count();

    //     // Total pendapatan
    //     $totalRevenue = $salesReports->where('payment_status', 'paid')
    //         ->whereNotIn('order_status', ['dibatalkan']) 
    //         ->sum('total');

    //     // Menghitung jumlah hari yang unik untuk rata-rata pendapatan
    //     $daysCount = $salesReports->pluck('created_at')->map(function ($date) {
    //         return $date->format('Y-m-d'); 
    //     })->unique()->count() ?: 1;

    //     $avgRevenue = $totalRevenue / $daysCount;

    //     // Kelompokkan menu terlaris
    //     $topMenus = collect();
    //     foreach ($salesReports->where('payment_status', 'paid')->whereNotIn('order_status', ['dibatalkan']) as $order) {
    //         foreach ($order->items as $item) {
    //             if ($item->menu) {
    //                 $menuId = $item->menu->id;
    //                 if (!$topMenus->has($menuId)) {
    //                     $topMenus->put($menuId, [
    //                         'name' => $item->menu->name,
    //                         'quantity' => 0,
    //                         'revenue' => 0,
    //                     ]);
    //                 }
    //                 $current = $topMenus->get($menuId);
    //                 $current['quantity'] += $item->quantity;
    //                 $current['revenue'] += $item->quantity * $item->price;
    //                 $topMenus->put($menuId, $current);
    //             }
    //         }
    //     }
    //     $topMenus = $topMenus->sortByDesc('quantity')->take(5);

    //     // Menghitung status pesanan
    //     $orderStatuses = [
    //         'selesai' => $salesReports->where('order_status', 'selesai')->count(),
    //         'diproses' => $salesReports->where('order_status', 'diproses')->count(),
    //         'menunggu' => $salesReports->where('order_status', 'menunggu')->count(),
    //         'batal' => $salesReports->where('order_status', 'dibatalkan')->count(), 
    //     ];

    //     return view('admin.Laporan.laporan', compact(
    //         'salesReports',
    //         'totalOrdersCount', 
    //         'totalRevenue',
    //         'avgRevenue',
    //         'topMenus',
    //         'orderStatuses',
    //         'range',
    //         'startDate',
    //         'endDate'
    //     ));
    // }
}