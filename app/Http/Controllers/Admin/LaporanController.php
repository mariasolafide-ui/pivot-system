<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\RetailProduct;
use App\Models\CafeTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ── Filter periode (default: Hari Ini) ──
        $range = $request->input('range', 'today');
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        if ($range === '7_days') {
            $startDate = now()->subDays(7)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($range === '30_days') {
            $startDate = now()->subDays(30)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($range === 'this_month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfDay();
        } elseif ($range === 'custom' && $request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        }

        // ── TRANSAKSI ──
        $orders = Order::with(['table', 'items.menu', 'items.retailProduct'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalOrders = $orders->count();
        $totalRevenue = $orders->where('payment_status', 'paid')
            ->whereNotIn('order_status', ['dibatalkan'])
            ->sum('total');
        $pendingOrders = $orders->where('payment_status', 'pending')->count();
        $canceledOrders = $orders->where('order_status', 'dibatalkan')->count();

        // ── MENU TERLARIS ──
        $topMenus = OrderItem::select(
                'order_items.menu_id',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->whereNotIn('orders.order_status', ['dibatalkan'])
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->with('menu.category')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->menu->name ?? 'Unknown',
                    'category' => $item->menu->category->name ?? '-',
                    'quantity' => $item->total_qty,
                    'revenue' => $item->total_revenue,
                ];
            });

        // ── KATEGORI ──
        $topCategories = Category::select(
                'categories.id',
                'categories.name',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->join('menus', 'menus.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->whereNotIn('orders.order_status', ['dibatalkan'])
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_qty')
            ->get();

        // ── FEEDBACK ──
        $feedbacks = Feedback::with('order')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $feedbackStats = [
            'total' => $feedbacks->count(),
            'rating_avg' => $feedbacks->avg('rating') ?? 0,
            'rating_5' => $feedbacks->where('rating', 5)->count(),
            'rating_4' => $feedbacks->where('rating', 4)->count(),
            'rating_3' => $feedbacks->where('rating', 3)->count(),
            'rating_1_2' => $feedbacks->whereIn('rating', [1, 2])->count(),
        ];

        // ── RETAIL ──
        $retailProducts = RetailProduct::withCount(['orderItems as terjual' => function($q) use ($startDate, $endDate) {
                $q->join('orders', 'orders.id', '=', 'order_items.order_id')
                  ->whereBetween('orders.created_at', [$startDate, $endDate])
                  ->where('orders.payment_status', 'paid')
                  ->whereNotIn('orders.order_status', ['dibatalkan']);
            }])
            ->orderBy('stock', 'asc')
            ->get();

        // ── STATUS MEJA ──
        $tableStatuses = CafeTable::orderBy('number')
            ->with(['orders' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->whereNotIn('order_status', ['selesai', 'dibatalkan'])
                  ->latest()
                  ->limit(1);
            }])
            ->get();

        // ── HITUNG RATA-RATA ──
        $daysCount = $orders->pluck('created_at')->map(function($date) {
            return $date->format('Y-m-d');
        })->unique()->count() ?: 1;
        $avgRevenue = $totalRevenue / $daysCount;

        $orderStatuses = [
            'selesai' => $orders->where('order_status', 'selesai')->count(),
            'diproses' => $orders->where('order_status', 'diproses')->count(),
            'menunggu' => $orders->where('order_status', 'menunggu')->count(),
            'dibatalkan' => $orders->where('order_status', 'dibatalkan')->count(),
        ];

        // ── DATA GRAFIK ──
        $dailySales = $orders->where('payment_status', 'paid')
            ->whereNotIn('order_status', ['dibatalkan'])
            ->groupBy(function($order) {
                return $order->created_at->format('d M');
            })
            ->map(function($dayOrders) {
                return $dayOrders->sum('total');
            });

        $chartLabels = $dailySales->keys()->toArray();
        $chartData = $dailySales->values()->toArray();

        if (empty($chartLabels)) {
            $chartLabels = ['Tidak Ada Data'];
            $chartData = [0];
        }

        // ── Data untuk grafik menu ──
        $menuLabels = [];
        $menuData = [];
        $menuColors = ['#1b4332', '#2d6a4f', '#d4a373', '#3b82f6', '#f59e0b', '#dc2626', '#16a34a', '#8b5cf6'];
        foreach ($topMenus->take(8) as $i => $menu) {
            $menuLabels[] = $menu['name'];
            $menuData[] = $menu['quantity'];
        }
        if (empty($menuLabels)) {
            $menuLabels = ['Belum Ada Data'];
            $menuData = [1];
            $menuColors = ['#e5e7eb'];
        }

        return view('admin.laporan.index', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'canceledOrders',
            'avgRevenue',
            'topMenus',
            'topCategories',
            'feedbacks',
            'feedbackStats',
            'retailProducts',
            'tableStatuses',
            'orderStatuses',
            'range',
            'startDate',
            'endDate',
            'chartLabels',
            'chartData',
            'menuLabels',
            'menuData',
            'menuColors'
        ));
    }

    public function exportExcel(Request $request)
    {
        $range = $request->input('range', 'today');
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        if ($range === '7_days') {
            $startDate = now()->subDays(7)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($range === '30_days') {
            $startDate = now()->subDays(30)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($range === 'this_month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfDay();
        } elseif ($range === 'custom' && $request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        }

        $orders = Order::with('table')->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
        $feedbacks = Feedback::with('order')->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
        $daysCount = $orders->pluck('created_at')->map(function($date) {
            return $date->format('Y-m-d');
        })->unique()->count() ?: 1;

        $topMenus = OrderItem::select('menus.name', 'categories.name as category', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->whereNotIn('orders.order_status', ['dibatalkan'])
            ->groupBy('menus.name', 'categories.name')
            ->orderByDesc('total_qty')
            ->limit(20)
            ->get();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('Pivot Cafe')->setTitle('Laporan Pivot Cafe');

        // ── Sheet 1: Ringkasan ──
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Ringkasan');
        $sheet->setCellValue('A1', 'LAPORAN PIVOT CAFE');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setName('Arial');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('A2', 'Periode: ' . $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'));
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'Total Pesanan');
        $sheet->setCellValue('B4', $orders->count());
        $sheet->setCellValue('C4', 'Nota');
        $sheet->setCellValue('A5', 'Total Omzet');
        $sheet->setCellValue('B5', $orders->where('payment_status', 'paid')->whereNotIn('order_status', ['dibatalkan'])->sum('total'));
        $sheet->setCellValue('C5', 'Rp');
        $sheet->setCellValue('A6', 'Rata-rata Harian');
        $sheet->setCellValue('B6', $orders->where('payment_status', 'paid')->whereNotIn('order_status', ['dibatalkan'])->sum('total') / max($daysCount, 1));
        $sheet->setCellValue('C6', 'Rp');
        $sheet->setCellValue('A7', 'Pesanan Pending');
        $sheet->setCellValue('B7', $orders->where('payment_status', 'pending')->count());
        $sheet->setCellValue('C7', 'Nota');
        $sheet->setCellValue('A8', 'Pesanan Dibatalkan');
        $sheet->setCellValue('B8', $orders->where('order_status', 'dibatalkan')->count());
        $sheet->setCellValue('C8', 'Nota');
        $sheet->setCellValue('A9', 'Total Feedback');
        $sheet->setCellValue('B9', $feedbacks->count());
        $sheet->setCellValue('C9', 'Ulasan');
        $sheet->setCellValue('A10', 'Rata-rata Rating');
        $sheet->setCellValue('B10', number_format($feedbacks->avg('rating') ?? 0, 1));
        $sheet->setCellValue('C10', '⭐');

        // ── Sheet 2: Transaksi ──
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Transaksi');
        $sheet2->setCellValue('A1', 'ID');
        $sheet2->setCellValue('B1', 'Tanggal');
        $sheet2->setCellValue('C1', 'Pelanggan');
        $sheet2->setCellValue('D1', 'Meja');
        $sheet2->setCellValue('E1', 'Status Bayar');
        $sheet2->setCellValue('F1', 'Status Order');
        $sheet2->setCellValue('G1', 'Total (Rp)');
        $sheet2->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet2->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getColumnDimension('A')->setWidth(10);
        $sheet2->getColumnDimension('B')->setWidth(18);
        $sheet2->getColumnDimension('C')->setWidth(25);
        $sheet2->getColumnDimension('D')->setWidth(12);
        $sheet2->getColumnDimension('E')->setWidth(15);
        $sheet2->getColumnDimension('F')->setWidth(15);
        $sheet2->getColumnDimension('G')->setWidth(18);

        $row = 2;
        foreach ($orders as $order) {
            $sheet2->setCellValue('A' . $row, $order->id);
            $sheet2->setCellValue('B' . $row, $order->created_at->format('d/m/Y H:i'));
            $sheet2->setCellValue('C' . $row, $order->customer_name);
            $sheet2->setCellValue('D' . $row, $order->table->number ?? '-');
            $sheet2->setCellValue('E' . $row, ucfirst($order->payment_status));
            $sheet2->setCellValue('F' . $row, ucfirst($order->order_status));
            $sheet2->setCellValue('G' . $row, $order->total);
            $sheet2->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $row++;
        }

        // ── Sheet 3: Menu Terlaris ──
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Menu Terlaris');
        $sheet3->setCellValue('A1', 'Menu');
        $sheet3->setCellValue('B1', 'Kategori');
        $sheet3->setCellValue('C1', 'Terjual');
        $sheet3->setCellValue('D1', 'Omzet (Rp)');
        $sheet3->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet3->getColumnDimension('A')->setWidth(30);
        $sheet3->getColumnDimension('B')->setWidth(20);
        $sheet3->getColumnDimension('C')->setWidth(15);
        $sheet3->getColumnDimension('D')->setWidth(20);

        $row = 2;
        foreach ($topMenus as $menu) {
            $sheet3->setCellValue('A' . $row, $menu->name);
            $sheet3->setCellValue('B' . $row, $menu->category);
            $sheet3->setCellValue('C' . $row, $menu->total_qty);
            $sheet3->setCellValue('D' . $row, $menu->total_revenue);
            $sheet3->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $row++;
        }

        // ── Sheet 4: Feedback ──
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Feedback');
        $sheet4->setCellValue('A1', 'Tanggal');
        $sheet4->setCellValue('B1', 'Order ID');
        $sheet4->setCellValue('C1', 'Rating');
        $sheet4->setCellValue('D1', 'Komentar');
        $sheet4->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet4->getColumnDimension('A')->setWidth(18);
        $sheet4->getColumnDimension('B')->setWidth(15);
        $sheet4->getColumnDimension('C')->setWidth(12);
        $sheet4->getColumnDimension('D')->setWidth(50);

        $row = 2;
        foreach ($feedbacks as $fb) {
            $sheet4->setCellValue('A' . $row, $fb->created_at->format('d/m/Y'));
            $sheet4->setCellValue('B' . $row, $fb->order_id);
            $sheet4->setCellValue('C' . $row, $fb->rating);
            $sheet4->setCellValue('D' . $row, $fb->comment);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Pivot_Cafe_' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.xlsx';

        return new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportPDF(Request $request)
    {
        $range = $request->input('range', 'today');
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        if ($range === '7_days') {
            $startDate = now()->subDays(7)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($range === '30_days') {
            $startDate = now()->subDays(30)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($range === 'this_month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfDay();
        } elseif ($range === 'custom' && $request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        }

        $orders = Order::with(['table', 'items.menu', 'items.retailProduct'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalOrders = $orders->count();
        $totalRevenue = $orders->where('payment_status', 'paid')->whereNotIn('order_status', ['dibatalkan'])->sum('total');

        $topMenus = OrderItem::select(
                'order_items.menu_id',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->whereNotIn('orders.order_status', ['dibatalkan'])
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->with('menu.category')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->menu->name ?? 'Unknown',
                    'category' => $item->menu->category->name ?? '-',
                    'quantity' => $item->total_qty,
                    'revenue' => $item->total_revenue,
                ];
            });

        $topCategories = Category::select(
                'categories.name',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->join('menus', 'menus.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->whereNotIn('orders.order_status', ['dibatalkan'])
            ->groupBy('categories.name')
            ->orderByDesc('total_qty')
            ->get();

        $feedbacks = Feedback::with('order')->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
        $feedbackStats = [
            'total' => $feedbacks->count(),
            'rating_avg' => $feedbacks->avg('rating') ?? 0,
            'rating_5' => $feedbacks->where('rating', 5)->count(),
            'rating_4' => $feedbacks->where('rating', 4)->count(),
            'rating_3' => $feedbacks->where('rating', 3)->count(),
            'rating_1_2' => $feedbacks->whereIn('rating', [1, 2])->count(),
        ];

        $retailProducts = RetailProduct::withCount(['orderItems as terjual' => function($q) use ($startDate, $endDate) {
                $q->join('orders', 'orders.id', '=', 'order_items.order_id')
                  ->whereBetween('orders.created_at', [$startDate, $endDate])
                  ->where('orders.payment_status', 'paid')
                  ->whereNotIn('orders.order_status', ['dibatalkan']);
            }])
            ->orderBy('stock', 'asc')
            ->get();

        $daysCount = $orders->pluck('created_at')->map(function($date) {
            return $date->format('Y-m-d');
        })->unique()->count() ?: 1;
        $avgRevenue = $totalRevenue / $daysCount;

        $orderStatuses = [
            'selesai' => $orders->where('order_status', 'selesai')->count(),
            'diproses' => $orders->where('order_status', 'diproses')->count(),
            'menunggu' => $orders->where('order_status', 'menunggu')->count(),
            'dibatalkan' => $orders->where('order_status', 'dibatalkan')->count(),
        ];

        $data = compact(
            'orders', 'totalOrders', 'totalRevenue', 'avgRevenue',
            'topMenus', 'topCategories', 'feedbacks', 'feedbackStats',
            'retailProducts', 'orderStatuses', 'startDate', 'endDate'
        );

        $pdf = Pdf::loadView('admin.laporan.pdf', $data);
        $pdf->setPaper('a4', 'landscape');

        $filename = 'Laporan_Pivot_Cafe_' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}