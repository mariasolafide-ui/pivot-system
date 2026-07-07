@extends('layouts.admin')
@section('title', 'Laporan & Rekapitulasi - Pivot Cafe')
@section('page-title', 'Laporan & Rekapitulasi')

@section('content')

<style>
    :root { --cafe-green: #1b4332; --accent-cokelat: #d4a373; --border-color: #e2e8f0; --text-dark: #1e293b; }
    .breadcrumb-admin { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6b7280; margin-bottom: 16px; flex-wrap: wrap; padding: 4px 0; }
    .breadcrumb-admin .current { color: #1b4332; font-weight: 600; }
    .filter-pills { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
    .pill-btn { padding: 6px 16px; font-size: 12px; font-weight: 600; border-radius: 30px; background: white; color: #6b7280; border: 1px solid #d1d5db; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; height: 34px; }
    .pill-btn:hover { border-color: #1b4332; color: #1b4332; }
    .pill-btn.active { background: #1b4332; color: white; border-color: #1b4332; box-shadow: 0 4px 12px rgba(27,67,50,0.2); }
    .custom-range-box { background: #fafafa; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 16px; margin-bottom: 24px; }
    .report-tabs { display: flex; gap: 4px; margin-bottom: 24px; border-bottom: 1px solid #e5e7eb; overflow-x: auto; white-space: nowrap; }
    .tab-btn { padding: 10px 20px; font-size: 13px; font-weight: 600; background: none; border: none; color: #6b7280; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.2s ease; font-family: 'Outfit', sans-serif; }
    .tab-btn:hover { color: #1b4332; }
    .tab-btn.active { color: #1b4332; border-bottom-color: #1b4332; }
    .report-content { display: none; }
    .report-content.active { display: block; }
    .card { background: white; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px; }
    .card-header { padding: 14px 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: #fafafa; }
    .card-title { font-size: 15px; font-weight: 700; color: #1b4332; margin: 0; display: flex; align-items: center; gap: 8px; }
    .card-body { padding: 20px; }
    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .table-responsive table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 600px; }
    .table-responsive th { background: #f8fafc; color: #374151; font-weight: 600; border-bottom: 2px solid #e5e7eb; padding: 10px 14px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.03em; white-space: nowrap; }
    .table-responsive td { border-bottom: 1px solid #f3f4f6; padding: 10px 14px; vertical-align: middle; }
    .table-responsive tbody tr:hover { background-color: #f8fafc; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .stat-card { background: white; border-radius: 12px; padding: 16px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; transition: transform 0.2s ease, box-shadow 0.2s ease; border-left: 4px solid #1b4332; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .stat-label { font-size: 12px; font-weight: 500; color: #6b7280; display: flex; align-items: center; gap: 6px; }
    .stat-value { font-size: 24px; font-weight: 700; color: #111827; margin-top: 4px; }
    .badge { padding: 4px 12px; font-size: 10px; font-weight: 600; border-radius: 30px; display: inline-block; white-space: nowrap; }
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-warning { background: #fef9c3; color: #854d0e; }
    .badge-info { background: #dbeafe; color: #1e40af; }
    .badge-secondary { background: #f1f5f9; color: #475569; }
    .btn { padding: 8px 16px; font-size: 13px; font-weight: 500; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; font-family: 'Outfit', sans-serif; }
    .btn-sm { padding: 6px 14px; font-size: 12px; height: 34px; }
    .btn-primary { background: #1b4332; color: white; }
    .btn-primary:hover { background: #2d6a4f; transform: translateY(-1px); }
    .btn-success { background: #16a34a; color: white; }
    .btn-success:hover { background: #15803d; transform: translateY(-1px); }
    .btn-danger { background: #dc2626; color: white; }
    .btn-danger:hover { background: #b91c1c; transform: translateY(-1px); }
    .btn-secondary { background: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; }
    .btn-secondary:hover { background: #e5e7eb; color: #1f2937; }
    .btn-warning { background: #f59e0b; color: white; }
    .btn-warning:hover { background: #d97706; transform: translateY(-1px); }
    .status-box-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 20px; }
    .status-box { background: white; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px 16px; text-align: center; border-top: 4px solid #1b4332; }
    .status-box .label { font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
    .status-box .value { font-size: 22px; font-weight: 700; color: #111827; margin-top: 4px; }
    .chart-container { position: relative; height: 280px; width: 100%; }

    /* ── MODAL ── */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 9999; display: none; align-items: center; justify-content: center; padding: 20px; }
    .modal-overlay.show { display: flex; }
    .modal-box { background: white; border-radius: 16px; max-width: 500px; width: 100%; padding: 32px 28px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: modalIn 0.3s ease; }
    @keyframes modalIn { from { transform: scale(0.9) translateY(20px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }
    .modal-icon { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px; }
    .modal-icon.excel { background: #e8f5e9; color: #16a34a; }
    .modal-icon.pdf { background: #fef2f2; color: #dc2626; }
    .modal-title { text-align: center; font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-family: 'Playfair Display', serif; }
    .modal-desc { text-align: center; font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.6; }
    .modal-actions { display: flex; gap: 12px; justify-content: center; }
    .modal-actions .btn { min-width: 120px; justify-content: center; }

    .print-only { display: none; }
    @media print { .no-print, header, nav, .sidebar, .btn, .report-tabs, .filter-pills, .custom-range-box, .modal-overlay { display: none !important; } .print-only { display: block !important; } body { background: white !important; color: #000 !important; } .card { border: 1px solid #ddd !important; box-shadow: none !important; } .report-content { display: block !important; } .table-responsive th { background: #f1f5f9 !important; } }
    @media (max-width:768px) { .stats-grid { grid-template-columns: 1fr 1fr; } .status-box-grid { grid-template-columns: 1fr 1fr; } .filter-pills { flex-wrap: wrap; } .report-tabs { overflow-x: auto; } .tab-btn { padding: 8px 14px; font-size: 12px; } .card-header { flex-direction: column; align-items: flex-start; } .modal-box { margin: 20px; padding: 24px 20px; } }
    @media (max-width:480px) { .stats-grid { grid-template-columns: 1fr; } .status-box-grid { grid-template-columns: 1fr; } .stat-value { font-size: 20px; } .modal-actions { flex-direction: column; align-items: center; } .modal-actions .btn { width: 100%; } }
</style>

{{-- BREADCRUMB --}}
<div class="breadcrumb-admin"><span class="current">Laporan & Rekapitulasi</span></div>

{{-- KOP SURAT PRINT --}}
<div class="print-only" style="text-align:center; border-bottom:3px double #1b4332; padding-bottom:12px; margin-bottom:25px;">
    <h2 style="margin:0; font-size:24px; color:#1b4332;">PIVOT CAFE</h2>
    <p style="margin:4px 0; font-size:12px; color:#4a5568;">Sistem Informasi Manajemen & Akuntansi Operasional Retail</p>
    <p style="margin:0; font-size:11px; font-style:italic; color:#718096;">Sleman, Daerah Istimewa Yogyakarta</p>
    <div id="print-title-sub" style="display:inline-block; background:#e8f5e9; color:#1b4332; font-weight:700; padding:4px 12px; border-radius:4px; margin-top:10px; font-size:12px; text-transform:uppercase;">Laporan Analisis Penjualan</div>
</div>

{{-- FILTER --}}
<div class="no-print">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:12px;">
        <div class="filter-pills">
            <a href="{{ route('admin.laporan', ['range' => 'today']) }}" class="pill-btn {{ request('range', 'today') == 'today' ? 'active' : '' }}"><i class="fas fa-calendar-day"></i> Hari Ini</a>
            <a href="{{ route('admin.laporan', ['range' => '7_days']) }}" class="pill-btn {{ request('range') == '7_days' ? 'active' : '' }}"><i class="fas fa-calendar-week"></i> 7 Hari</a>
            <a href="{{ route('admin.laporan', ['range' => '30_days']) }}" class="pill-btn {{ request('range') == '30_days' ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> 30 Hari</a>
            <a href="{{ route('admin.laporan', ['range' => 'this_month']) }}" class="pill-btn {{ request('range') == 'this_month' ? 'active' : '' }}"><i class="fas fa-calendar"></i> Bulan Ini</a>
            <button onclick="toggleCustomRange()" class="pill-btn {{ request('range') == 'custom' ? 'active' : '' }}"><i class="fas fa-sliders-h"></i> Custom</button>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <button onclick="openModal('excel')" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
            <button onclick="openModal('pdf')" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
            <button onclick="window.print()" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i> Cetak</button>
        </div>
    </div>

    {{-- Custom Range --}}
    <div id="custom-range-container" class="custom-range-box" style="display: {{ request('range') == 'custom' ? 'block' : 'none' }}">
        <form method="GET" action="{{ route('admin.laporan') }}" style="display:flex; flex-wrap:wrap; gap:16px; align-items:flex-end;">
            <input type="hidden" name="range" value="custom">
            <div>
                <label style="font-size:11px; font-weight:700; text-transform:uppercase; color:#6b7280; display:block; margin-bottom:4px;">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ isset($startDate) && $startDate ? $startDate->format('Y-m-d') : '' }}" style="border:1px solid #d1d5db; border-radius:6px; padding:6px 12px; font-size:13px; height:34px; background:white;">
            </div>
            <div>
                <label style="font-size:11px; font-weight:700; text-transform:uppercase; color:#6b7280; display:block; margin-bottom:4px;">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ isset($endDate) && $endDate ? $endDate->format('Y-m-d') : '' }}" style="border:1px solid #d1d5db; border-radius:6px; padding:6px 12px; font-size:13px; height:34px; background:white;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-sync"></i> Tampilkan</button>
            @if(request('range') == 'custom')
                <a href="{{ route('admin.laporan', ['range' => 'today']) }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- PERIODE --}}
<div class="summary-box" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
    <div><span style="font-size:13px; font-weight:600; color:#166534;"><i class="fas fa-calendar-alt"></i> Periode Laporan:</span>
        <span style="font-size:13px; color:#166534; font-weight:600;">{{ isset($startDate) && $startDate ? $startDate->format('d F Y') : '-' }} - {{ isset($endDate) && $endDate ? $endDate->format('d F Y') : '-' }}</span>
    </div>
    <div><span style="font-size:13px; font-weight:600; color:#166534;"><i class="fas fa-file-alt"></i> Total Transaksi:</span>
        <span style="font-size:16px; font-weight:700; color:#166534;">{{ $totalOrders ?? 0 }} Nota</span>
    </div>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card" style="border-left-color:#1b4332;"><div class="stat-label"><i class="fas fa-money-bill-wave" style="color:#1b4332;"></i> Total Omzet</div><div class="stat-value" style="color:#1b4332;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div></div>
    <div class="stat-card" style="border-left-color:#d4a373;"><div class="stat-label"><i class="fas fa-chart-line" style="color:#d4a373;"></i> Rata-rata Harian</div><div class="stat-value" style="color:#b45309;">Rp {{ number_format($avgRevenue ?? 0, 0, ',', '.') }}</div></div>
    <div class="stat-card" style="border-left-color:#3b82f6;"><div class="stat-label"><i class="fas fa-receipt" style="color:#3b82f6;"></i> Total Pesanan</div><div class="stat-value" style="color:#3b82f6;">{{ $totalOrders ?? 0 }}</div></div>
    <div class="stat-card" style="border-left-color:#16a34a;"><div class="stat-label"><i class="fas fa-check-circle" style="color:#16a34a;"></i> Selesai</div><div class="stat-value" style="color:#16a34a;">{{ $orderStatuses['selesai'] ?? 0 }}</div></div>
    <div class="stat-card" style="border-left-color:#dc2626;"><div class="stat-label"><i class="fas fa-times-circle" style="color:#dc2626;"></i> Dibatalkan</div><div class="stat-value" style="color:#dc2626;">{{ $orderStatuses['dibatalkan'] ?? 0 }}</div></div>
    <div class="stat-card" style="border-left-color:#f59e0b;"><div class="stat-label"><i class="fas fa-hourglass-half" style="color:#f59e0b;"></i> Pending</div><div class="stat-value" style="color:#f59e0b;">{{ $pendingOrders ?? 0 }}</div></div>
</div>

{{-- TABS --}}
<div class="report-tabs no-print">
    <button class="tab-btn active" onclick="switchTab(event, 'tab-omzet')"><i class="fas fa-chart-line"></i> Omzet</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-transaksi')"><i class="fas fa-receipt"></i> Transaksi</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-menu')"><i class="fas fa-utensils"></i> Menu</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-kategori')"><i class="fas fa-tags"></i> Kategori</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-feedback')"><i class="fas fa-comment-dots"></i> Feedback</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-retail')"><i class="fas fa-box"></i> Retail</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-status')"><i class="fas fa-tasks"></i> Status</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-rekap')"><i class="fas fa-file-invoice"></i> Rekap</button>
</div>

{{-- TAB OMSET & GRAFIK --}}
<div id="tab-omzet" class="report-content active">
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-chart-line" style="color:#1b4332;"></i> Grafik Omzet Harian</div>
            <span style="font-size:12px; color:#6b7280;">Periode {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</span>
        </div>
        <div class="card-body">
            <div class="chart-container"><canvas id="revenueChart"></canvas></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-chart-pie" style="color:#1b4332;"></i> Distribusi Penjualan Menu</div>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; align-items:center;">
                <div style="position:relative; height:260px;"><canvas id="menuChart"></canvas></div>
                <div>
                    <table style="width:100%; font-size:13px;">
                        <thead><tr><th style="text-align:center; width:40px;">#</th><th>Menu</th><th style="text-align:center;">Qty</th><th style="text-align:right;">Omzet</th></tr></thead>
                        <tbody>
                            @php $rank=1; @endphp
                            @forelse($topMenus ?? [] as $menu)
                            <tr><td style="text-align:center; font-weight:700; color:#d4a373;">{{ $rank++ }}</td><td style="font-weight:500;">{{ $menu['name'] }}</td><td style="text-align:center; font-weight:600; color:#3b82f6;">{{ $menu['quantity'] }}</td><td style="text-align:right; font-weight:600; color:#1b4332;">Rp {{ number_format($menu['revenue'], 0, ',', '.') }}</td></tr>
                            @empty
                            <tr><td colspan="4" style="text-align:center; color:#6b7280; padding:16px;">Belum ada data menu.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TAB 2: TRANSAKSI --}}
<div id="tab-transaksi" class="report-content">
    <div class="card"><div class="card-header"><div class="card-title"><i class="fas fa-receipt" style="color:#1b4332;"></i> Riwayat Transaksi</div><span style="font-size:12px; color:#6b7280;">{{ $orders->count() }} transaksi</span></div>
        <div class="table-responsive"><table><thead><tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Meja</th><th style="text-align:center">Status Bayar</th><th style="text-align:center">Status Order</th><th style="text-align:right">Total</th></tr></thead>
            <tbody>@forelse($orders as $tx)<tr><td style="font-family:monospace;">#{{ $tx->id }}</td><td>{{ $tx->created_at->format('d/m/Y H:i') }}</td><td>{{ $tx->customer_name }}</td><td>Meja {{ $tx->table->number ?? '-' }}</td><td style="text-align:center;"><span class="badge {{ $tx->payment_status === 'paid' ? 'badge-success' : 'badge-danger' }}">{{ $tx->payment_status === 'paid' ? 'Lunas' : 'Pending' }}</span></td><td style="text-align:center;"><span class="badge {{ $tx->order_status === 'selesai' ? 'badge-success' : ($tx->order_status === 'dibatalkan' ? 'badge-danger' : 'badge-warning') }}">{{ ucfirst($tx->order_status) }}</span></td><td style="text-align:right; font-weight:700; color:#1b4332;">Rp {{ number_format($tx->total, 0, ',', '.') }}</td></tr>@empty<tr><td colspan="7" style="text-align:center; color:#6b7280; padding:32px;">Tidak ada transaksi.</td></tr>@endforelse</tbody>
        </table></div>
    </div>
</div>

{{-- TAB 3: MENU --}}
<div id="tab-menu" class="report-content">
    <div class="card"><div class="card-header"><div class="card-title"><i class="fas fa-utensils" style="color:#1b4332;"></i> Top 10 Menu Terlaris</div></div>
        <div class="table-responsive"><table><thead><tr><th style="width:40px;">#</th><th>Nama Menu</th><th>Kategori</th><th style="text-align:center;">Terjual</th><th style="text-align:right;">Omzet</th></tr></thead>
            <tbody>@php $rank=1; @endphp @forelse($topMenus ?? [] as $menu)<tr><td style="text-align:center; font-weight:700; color:#d4a373;">{{ $rank++ }}</td><td style="font-weight:600;">{{ $menu['name'] }}</td><td>{{ $menu['category'] }}</td><td style="text-align:center; font-weight:700;">{{ $menu['quantity'] }}</td><td style="text-align:right; font-weight:700; color:#1b4332;">Rp {{ number_format($menu['revenue'], 0, ',', '.') }}</td></tr>@empty<tr><td colspan="5" style="text-align:center; color:#6b7280; padding:32px;">Belum ada data.</td></tr>@endforelse</tbody>
        </table></div>
    </div>
</div>

{{-- TAB 4: KATEGORI --}}
<div id="tab-kategori" class="report-content">
    <div class="card"><div class="card-header"><div class="card-title"><i class="fas fa-tags" style="color:#1b4332;"></i> Performa Kategori</div></div>
        <div class="table-responsive"><table><thead><tr><th style="width:40px;">#</th><th>Kategori</th><th style="text-align:center;">Terjual</th><th style="text-align:right;">Omzet</th><th style="text-align:center;">Kontribusi</th></tr></thead>
            <tbody>@php $rank=1; $totalQty = $topCategories->sum('total_qty'); @endphp @forelse($topCategories ?? [] as $cat)<tr><td style="text-align:center; font-weight:700; color:#d4a373;">{{ $rank++ }}</td><td style="font-weight:600;">{{ $cat->name }}</td><td style="text-align:center; font-weight:700;">{{ $cat->total_qty }}</td><td style="text-align:right; font-weight:700; color:#1b4332;">Rp {{ number_format($cat->total_revenue, 0, ',', '.') }}</td><td style="text-align:center;">@php $persen = $totalQty > 0 ? round($cat->total_qty / $totalQty * 100, 1) : 0; @endphp <span class="badge badge-info">{{ $persen }}%</span></td></tr>@empty<tr><td colspan="5" style="text-align:center; color:#6b7280; padding:32px;">Belum ada data.</td></tr>@endforelse</tbody>
        </table></div>
    </div>
</div>

{{-- TAB 5: FEEDBACK --}}
<div id="tab-feedback" class="report-content">
    <div class="stats-grid" style="grid-template-columns: repeat(5, 1fr);">
        <div class="stat-card" style="border-left-color:#3b82f6;"><div class="stat-label">Total Feedback</div><div class="stat-value">{{ $feedbackStats['total'] ?? 0 }}</div></div>
        <div class="stat-card" style="border-left-color:#16a34a;"><div class="stat-label">⭐ Rata-rata</div><div class="stat-value">{{ number_format($feedbackStats['rating_avg'] ?? 0, 1) }}</div></div>
        <div class="stat-card" style="border-left-color:#16a34a;"><div class="stat-label">⭐ 5 Bintang</div><div class="stat-value">{{ $feedbackStats['rating_5'] ?? 0 }}</div></div>
        <div class="stat-card" style="border-left-color:#f59e0b;"><div class="stat-label">⭐ 3-4 Bintang</div><div class="stat-value">{{ ($feedbackStats['rating_4'] ?? 0) + ($feedbackStats['rating_3'] ?? 0) }}</div></div>
        <div class="stat-card" style="border-left-color:#dc2626;"><div class="stat-label">⭐ 1-2 Bintang</div><div class="stat-value">{{ $feedbackStats['rating_1_2'] ?? 0 }}</div></div>
    </div>
    <div class="card"><div class="card-header"><div class="card-title"><i class="fas fa-comment-dots" style="color:#1b4332;"></i> Daftar Feedback</div></div>
        <div class="table-responsive"><table><thead><tr><th>Tanggal</th><th>Order</th><th style="text-align:center;">Rating</th><th>Komentar</th></tr></thead>
            <tbody>@forelse($feedbacks ?? [] as $fb)<tr><td>{{ $fb->created_at->format('d/m/Y H:i') }}</td><td>#{{ $fb->order_id }}</td><td style="text-align:center;"><span class="badge {{ $fb->rating >= 4 ? 'badge-success' : ($fb->rating >= 3 ? 'badge-warning' : 'badge-danger') }}">⭐ {{ $fb->rating }}</span></td><td>{{ $fb->comment ?: 'Tidak ada komentar' }}</td></tr>@empty<tr><td colspan="4" style="text-align:center; color:#6b7280; padding:32px;">Belum ada feedback.</td></tr>@endforelse</tbody>
        </table></div>
    </div>
</div>

{{-- TAB 6: RETAIL --}}
<div id="tab-retail" class="report-content">
    <div class="card"><div class="card-header"><div class="card-title"><i class="fas fa-box" style="color:#1b4332;"></i> Stok & Penjualan Retail</div></div>
        <div class="table-responsive"><table><thead><tr><th>#</th><th>Nama Produk</th><th style="text-align:center;">Stok</th><th style="text-align:center;">Terjual</th><th style="text-align:right;">Harga</th><th style="text-align:right;">Omzet</th></tr></thead>
            <tbody>@php $rank=1; @endphp @forelse($retailProducts ?? [] as $prod)<tr><td style="text-align:center;">{{ $rank++ }}</td><td style="font-weight:600;">{{ $prod->name }}</td><td style="text-align:center;"><span class="badge {{ $prod->stock <= 3 ? 'badge-danger' : 'badge-success' }}">{{ $prod->stock }}</span></td><td style="text-align:center;">{{ $prod->terjual ?? 0 }}</td><td style="text-align:right;">Rp {{ number_format($prod->price, 0, ',', '.') }}</td><td style="text-align:right; font-weight:700; color:#1b4332;">Rp {{ number_format(($prod->terjual ?? 0) * $prod->price, 0, ',', '.') }}</td></tr>@empty<tr><td colspan="6" style="text-align:center; color:#6b7280; padding:32px;">Belum ada produk retail.</td></tr>@endforelse</tbody>
        </table></div>
    </div>
</div>

{{-- TAB 7: STATUS --}}
<div id="tab-status" class="report-content">
    <div class="card"><div class="card-header"><div class="card-title"><i class="fas fa-tasks" style="color:#1b4332;"></i> Alur Penyelesaian Pesanan</div></div>
        <div class="card-body">
            <div class="status-box-grid">
                <div class="status-box" style="border-top-color:#16a34a;"><div class="label">Selesai</div><div class="value" style="color:#16a34a;">{{ $orderStatuses['selesai'] ?? 0 }}</div></div>
                <div class="status-box" style="border-top-color:#3b82f6;"><div class="label">Diproses</div><div class="value" style="color:#3b82f6;">{{ $orderStatuses['diproses'] ?? 0 }}</div></div>
                <div class="status-box" style="border-top-color:#f59e0b;"><div class="label">Menunggu</div><div class="value" style="color:#f59e0b;">{{ $orderStatuses['menunggu'] ?? 0 }}</div></div>
                <div class="status-box" style="border-top-color:#dc2626;"><div class="label">Dibatalkan</div><div class="value" style="color:#dc2626;">{{ $orderStatuses['dibatalkan'] ?? 0 }}</div></div>
            </div>
            <div style="background:#f8fafc; border-radius:10px; padding:16px 20px; border:1px solid #e5e7eb;">
                <h4 style="font-size:14px; margin-bottom:6px; color:#1b4332;">💡 Analisis Efisiensi</h4>
                <p style="font-size:13px; color:#475569; margin:0; line-height:1.6;">
                    Dari total <strong>{{ $totalOrders ?? 0 }}</strong> pesanan, tingkat penyelesaian mencapai <strong>{{ isset($totalOrders) && $totalOrders > 0 ? round(($orderStatuses['selesai'] ?? 0) / $totalOrders * 100, 1) : 0 }}%</strong>.
                    @if(isset($totalOrders) && $totalOrders > 0 && round(($orderStatuses['selesai'] ?? 0) / $totalOrders * 100, 1) >= 80)<span style="color:#16a34a;">✅ Operasional berjalan dengan baik.</span>
                    @elseif(isset($totalOrders) && $totalOrders > 0 && round(($orderStatuses['selesai'] ?? 0) / $totalOrders * 100, 1) >= 60)<span style="color:#f59e0b;">⚠️ Masih ada ruang untuk peningkatan.</span>
                    @else<span style="color:#dc2626;">🔴 Perlu perhatian khusus untuk meningkatkan efisiensi.</span>@endif
                </p>
            </div>
        </div>
    </div>
</div>

{{-- TAB 8: REKAP --}}
<div id="tab-rekap" class="report-content">
    <div class="card"><div class="card-header"><div class="card-title"><i class="fas fa-file-invoice" style="color:#1b4332;"></i> Rekapitulasi Laporan</div></div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
                <div style="background:#f8fafc; border-radius:10px; padding:16px; border:1px solid #e5e7eb;"><div style="font-size:12px; color:#6b7280;">Total Omzet</div><div style="font-size:22px; font-weight:700; color:#1b4332;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div></div>
                <div style="background:#f8fafc; border-radius:10px; padding:16px; border:1px solid #e5e7eb;"><div style="font-size:12px; color:#6b7280;">Total Pesanan</div><div style="font-size:22px; font-weight:700; color:#1b4332;">{{ $totalOrders ?? 0 }} Nota</div></div>
                <div style="background:#f8fafc; border-radius:10px; padding:16px; border:1px solid #e5e7eb;"><div style="font-size:12px; color:#6b7280;">Rata-rata per Transaksi</div><div style="font-size:22px; font-weight:700; color:#1b4332;">Rp {{ number_format(isset($totalOrders) && $totalOrders > 0 ? ($totalRevenue ?? 0) / $totalOrders : 0, 0, ',', '.') }}</div></div>
                <div style="background:#f8fafc; border-radius:10px; padding:16px; border:1px solid #e5e7eb;"><div style="font-size:12px; color:#6b7280;">Total Item Terjual</div><div style="font-size:22px; font-weight:700; color:#1b4332;">@php $totalItemsSold=0; foreach($orders ?? [] as $order){ $totalItemsSold += $order->items->sum('quantity'); } @endphp {{ number_format($totalItemsSold, 0, ',', '.') }}</div></div>
            </div>
            <div style="background:#fef9c3; border:1px solid #fde68a; border-radius:10px; padding:16px 20px;">
                <h4 style="font-size:14px; margin-bottom:4px; color:#78350f;">📌 Ringkasan Eksekutif</h4>
                <p style="font-size:13px; color:#78350f; margin:0; line-height:1.6;">
                    Periode {{ isset($startDate) && $startDate ? $startDate->format('d M Y') : '-' }} - {{ isset($endDate) && $endDate ? $endDate->format('d M Y') : '-' }}:
                    Terjadi <strong>{{ $totalOrders ?? 0 }}</strong> transaksi dengan total omzet <strong>Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</strong>.
                    Rata-rata per hari <strong>Rp {{ number_format($avgRevenue ?? 0, 0, ',', '.') }}</strong>.
                    Menu terlaris adalah <strong>{{ isset($topMenus) && count($topMenus) > 0 ? ($topMenus[0]['name'] ?? 'Belum ada data') : 'Belum ada data' }}</strong> dengan {{ isset($topMenus) && count($topMenus) > 0 ? ($topMenus[0]['quantity'] ?? 0) : 0 }} porsi terjual.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ── MODAL KONFIRMASI DOWNLOAD ── --}}
<div class="modal-overlay" id="downloadModal">
    <div class="modal-box">
        <div class="modal-icon" id="modalIcon"><i class="fas fa-file-excel"></i></div>
        <div class="modal-title" id="modalTitle">Download Laporan</div>
        <div class="modal-desc" id="modalDesc">Apakah Anda yakin ingin mendownload laporan ini?</div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeModal()"><i class="fas fa-times"></i> Batal</button>
            <a href="#" id="downloadLink" class="btn btn-success"><i class="fas fa-download"></i> Download</a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let revenueChart, menuChart;

    function toggleCustomRange() {
        const container = document.getElementById('custom-range-container');
        container.style.display = container.style.display === 'none' ? 'block' : 'none';
    }

    function switchTab(evt, tabId) {
        document.querySelectorAll('.report-content').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');
        setTimeout(resizeCharts, 100);
    }

    function resizeCharts() {
        if (revenueChart) revenueChart.resize();
        if (menuChart) menuChart.resize();
    }

    // ── MODAL ──
    function openModal(type) {
        const modal = document.getElementById('downloadModal');
        const icon = document.getElementById('modalIcon');
        const title = document.getElementById('modalTitle');
        const desc = document.getElementById('modalDesc');
        const link = document.getElementById('downloadLink');

        const query = window.location.search;
        const baseUrl = window.location.origin + window.location.pathname;

        if (type === 'excel') {
            icon.className = 'modal-icon excel';
            icon.innerHTML = '<i class="fas fa-file-excel"></i>';
            title.textContent = 'Download Laporan Excel';
            desc.textContent = 'Laporan akan diunduh dalam format .xlsx dengan 4 sheet (Ringkasan, Transaksi, Menu Terlaris, Feedback).';
            link.className = 'btn btn-success';
            link.innerHTML = '<i class="fas fa-file-excel"></i> Download Excel';
            link.href = '{{ route("admin.laporan.export-excel") }}' + query;
        } else {
            icon.className = 'modal-icon pdf';
            icon.innerHTML = '<i class="fas fa-file-pdf"></i>';
            title.textContent = 'Download Laporan PDF';
            desc.textContent = 'Laporan akan diunduh dalam format .pdf dengan layout A4 landscape, kop surat, dan tabel rapi.';
            link.className = 'btn btn-danger';
            link.innerHTML = '<i class="fas fa-file-pdf"></i> Download PDF';
            link.href = '{{ route("admin.laporan.export-pdf") }}' + query;
        }

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('downloadModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    // ── CHART ──
    document.addEventListener('DOMContentLoaded', function() {
        const labels = @json($chartLabels ?? ['Tidak Ada Data']);
        const data = @json($chartData ?? [0]);
        const menuLabels = @json($menuLabels ?? ['Belum Ada Data']);
        const menuData = @json($menuData ?? [1]);
        const menuColors = @json($menuColors ?? ['#e5e7eb']);

        // Revenue Chart
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        revenueChart = new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet (Rp)',
                    data: data,
                    borderColor: '#1b4332',
                    backgroundColor: 'rgba(27, 67, 50, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#d4a373',
                    pointBorderColor: '#1b4332',
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: function(ctx) { return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID'); } } }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 10 }, callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } } },
                    x: { grid: { display: false }, ticks: { font: { size: 9 } } }
                }
            }
        });

        // Menu Chart
        const ctxMenu = document.getElementById('menuChart').getContext('2d');
        menuChart = new Chart(ctxMenu, {
            type: 'doughnut',
            data: {
                labels: menuLabels,
                datasets: [{ data: menuData, backgroundColor: menuColors, borderWidth: 2, borderColor: '#ffffff' }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, padding: 10, font: { size: 10 }, usePointStyle: true } }
                },
                cutout: '65%'
            }
        });

        setTimeout(resizeCharts, 200);
        window.addEventListener('resize', resizeCharts);

        // ── CLICK OUTSIDE MODAL ──
        document.getElementById('downloadModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
    });
</script>
@endpush