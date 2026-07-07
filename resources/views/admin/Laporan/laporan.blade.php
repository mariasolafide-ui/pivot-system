@extends('layouts.admin')
@section('title', 'Sistem Rekapitulasi Laporan - Pivot Cafe')
@section('page-title', 'Pusat Laporan & Rekapitulasi')

@section('content')

<style>
    :root {
        --cafe-green: #1b4332;
        --cafe-green-hover: #2d6a4f;
        --cafe-green-light: #e8f5e9;
        --accent-cokelat: #d4a373;
        --border-color: #e2e8f0;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --bg-light: #f8fafc;
    }

    /* ── BREADCRUMB ── */
    .breadcrumb-admin {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 16px;
        flex-wrap: wrap;
        padding: 4px 0;
    }
    .breadcrumb-admin a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-admin a:hover {
        color: #1b4332;
    }
    .breadcrumb-admin .separator {
        color: #d1d5db;
    }
    .breadcrumb-admin .current {
        color: #1b4332;
        font-weight: 600;
    }

    /* ── NAVIGASI BACK ── */
    .nav-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        padding: 8px 16px;
        border-radius: 50px;
        background: rgba(0,0,0,0.04);
        margin-bottom: 12px;
    }

    .nav-back:hover {
        background: rgba(0,0,0,0.08);
        color: #1b4332;
        transform: translateX(-4px);
    }

    .nav-back i {
        font-size: 14px;
    }

    /* ── TOMBOL KONSISTEN ── */
    .btn-edit {
        background: #3b82f6;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 4px 14px;
        font-size: 11px;
        height: 30px;
        border-radius: 30px !important;
        cursor: pointer;
        min-width: 55px;
        text-decoration: none;
    }
    .btn-edit:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        color: white;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 4px 14px;
        font-size: 11px;
        height: 30px;
        border-radius: 30px !important;
        cursor: pointer;
        min-width: 55px;
    }
    .btn-delete:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        color: white;
    }

    .btn-primary {
        background: #1b4332;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 8px 20px;
        font-size: 13px;
        height: 36px;
        border-radius: 30px !important;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-primary:hover {
        background: #2d6a4f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.35);
        color: white;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #4b5563;
        border: 1px solid #d1d5db;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 8px 20px;
        font-size: 13px;
        height: 36px;
        border-radius: 30px !important;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-1px);
    }

    .btn-success {
        background: #16a34a;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 8px 20px;
        font-size: 13px;
        height: 36px;
        border-radius: 30px !important;
        cursor: pointer;
    }
    .btn-success:hover {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
        color: white;
    }

    .btn-sm {
        padding: 4px 14px;
        font-size: 11px;
        height: 30px;
        border-radius: 30px !important;
        cursor: pointer;
    }

    .badge {
        padding: 4px 12px;
        font-size: 10px;
        font-weight: 600;
        border-radius: 30px;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-success {
        background: #dcfce7;
        color: #166534;
    }
    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    .badge-warning {
        background: #fef9c3;
        color: #854d0e;
    }
    .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }
    .badge-secondary {
        background: #f1f5f9;
        color: #475569;
    }

    /* ── FILTER PILLS ── */
    .filter-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .pill-btn {
        padding: 6px 16px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 30px;
        background: white;
        color: #6b7280;
        border: 1px solid #d1d5db;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        height: 34px;
    }
    .pill-btn:hover {
        border-color: #1b4332;
        color: #1b4332;
    }
    .pill-btn.active {
        background: #1b4332;
        color: white;
        border-color: #1b4332;
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.2);
    }

    /* ── CUSTOM RANGE ── */
    .custom-range-box {
        background: #fafafa;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
    }

    /* ── TAB NAVIGATION ── */
    .report-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
        overflow-x: auto;
        white-space: nowrap;
    }
    .tab-btn {
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
        background: none;
        border: none;
        color: #6b7280;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease;
        font-family: 'Outfit', sans-serif;
    }
    .tab-btn:hover {
        color: #1b4332;
    }
    .tab-btn.active {
        color: #1b4332;
        border-bottom-color: #1b4332;
    }

    /* ── CONTENT ── */
    .report-content { display: none; }
    .report-content.active { display: block; }

    /* ── CARD ── */
    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .card-header {
        padding: 14px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: #fafafa;
    }
    .card-title {
        font-size: 15px;
        font-weight: 700;
        color: #1b4332;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-body {
        padding: 20px;
    }

    /* ── TABLE ── */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table-responsive table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 600px;
    }
    .table-responsive th {
        background: #f8fafc;
        color: #374151;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
        padding: 10px 14px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }
    .table-responsive td {
        border-bottom: 1px solid #f3f4f6;
        padding: 10px 14px;
        vertical-align: middle;
    }
    .table-responsive tbody tr:hover {
        background-color: #f8fafc;
    }

    /* ── STATS GRID ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 16px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 4px solid #1b4332;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    .stat-label {
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-top: 4px;
    }

    /* ── STATUS BOX ── */
    .status-box-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }
    .status-box {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        text-align: center;
        border-top: 4px solid #1b4332;
    }
    .status-box .label {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-box .value {
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        margin-top: 4px;
    }

    /* ── CHART ── */
    .chart-container {
        position: relative;
        height: 280px;
        width: 100%;
    }

    /* ── SUMMARY BOX ── */
    .summary-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .summary-box .label {
        font-size: 13px;
        font-weight: 600;
        color: #166534;
    }
    .summary-box .value {
        font-size: 18px;
        font-weight: 700;
        color: #166534;
    }

    /* ── PRINT ── */
    .print-only { display: none; }

    @media print {
        .no-print, header, nav, .sidebar, .btn, .report-tabs, .filter-pills, .custom-range-box { display: none !important; }
        .print-only { display: block !important; }
        body { background: white !important; color: #000 !important; padding: 20px; }
        .card { border: 1px solid #e5e7eb !important; box-shadow: none !important; margin-bottom: 16px !important; }
        .report-content { display: none !important; }
        .report-content.active { display: block !important; }
        .table-responsive th { background: #f1f5f9 !important; }
        .stats-grid { page-break-inside: avoid; }
        .chart-container { height: 200px; }
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .filter-pills {
            flex-wrap: wrap;
        }
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
        .status-box-grid {
            grid-template-columns: 1fr 1fr;
        }
        .card-body {
            padding: 14px;
        }
        .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .report-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
        }
        .tab-btn {
            padding: 8px 14px;
            font-size: 12px;
        }
        .summary-box {
            flex-direction: column;
            text-align: center;
        }
        .breadcrumb-admin {
            font-size: 12px;
        }
        .nav-back {
            font-size: 13px;
            padding: 6px 14px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .status-box-grid {
            grid-template-columns: 1fr;
        }
        .stat-value {
            font-size: 20px;
        }
        .chart-container {
            height: 200px;
        }
        .breadcrumb-admin {
            font-size: 11px;
        }
        .nav-back {
            font-size: 12px;
            padding: 5px 12px;
        }
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme: dark) {
        .card {
            background: #1f2937;
            border-color: #374151;
        }
        .card-header {
            background: #111827;
            border-color: #374151;
        }
        .card-title {
            color: #f3f4f6;
        }
        .stat-card {
            background: #1f2937;
            border-color: #374151;
        }
        .stat-label {
            color: #9ca3af;
        }
        .stat-value {
            color: #f3f4f6;
        }
        .table-responsive th {
            background: #111827;
            color: #e5e7eb;
            border-color: #374151;
        }
        .table-responsive td {
            border-color: #374151;
            color: #e5e7eb;
        }
        .table-responsive tbody tr:hover {
            background-color: #111827;
        }
        .status-box {
            background: #1f2937;
            border-color: #374151;
        }
        .status-box .label {
            color: #9ca3af;
        }
        .status-box .value {
            color: #f3f4f6;
        }
        .custom-range-box {
            background: #111827;
            border-color: #374151;
        }
        .pill-btn {
            background: #1f2937;
            color: #9ca3af;
            border-color: #374151;
        }
        .pill-btn:hover {
            border-color: #d4a373;
            color: #d4a373;
        }
        .pill-btn.active {
            background: #1b4332;
            color: white;
            border-color: #1b4332;
        }
        .tab-btn {
            color: #9ca3af;
        }
        .tab-btn:hover {
            color: #d4a373;
        }
        .tab-btn.active {
            color: #d4a373;
            border-bottom-color: #d4a373;
        }
        .summary-box {
            background: #064e3b;
            border-color: #059669;
        }
        .summary-box .label {
            color: #86efac;
        }
        .summary-box .value {
            color: #86efac;
        }
        .nav-back {
            color: #9ca3af;
            background: rgba(255,255,255,0.06);
        }
        .nav-back:hover {
            background: rgba(255,255,255,0.1);
            color: #d4a373;
        }
        .breadcrumb-admin {
            color: #9ca3af;
        }
        .breadcrumb-admin a {
            color: #9ca3af;
        }
        .breadcrumb-admin a:hover {
            color: #d4a373;
        }
        .breadcrumb-admin .current {
            color: #d4a373;
        }
        .breadcrumb-admin .separator {
            color: #4b5563;
        }
    }
</style>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <span class="current">Laporan & Rekapitulasi</span>
</div>

{{-- ── KOP SURAT (PRINT) ── --}}
<div class="print-only" style="text-align: center; border-bottom: 3px double #1b4332; padding-bottom: 12px; margin-bottom: 25px;">
    <h2 style="margin: 0; font-size: 24px; color: #1b4332;">PIVOT CAFE</h2>
    <p style="margin: 4px 0; font-size: 12px; color: #4a5568;">Sistem Informasi Manajemen & Akuntansi Operasional Retail</p>
    <p style="margin: 0; font-size: 11px; font-style: italic; color: #718096;">Sleman, Daerah Istimewa Yogyakarta</p>
    <div id="print-title-sub" style="display:inline-block; background: #e8f5e9; color: #1b4332; font-weight:700; padding:4px 12px; border-radius:4px; margin-top:10px; font-size:12px; text-transform:uppercase;">
        Laporan Analisis Penjualan
    </div>
</div>

{{-- ── FILTER ── --}}
<div class="no-print">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <div class="filter-pills">
            <a href="{{ route('admin.laporan', ['range' => 'today']) }}" class="pill-btn {{ request('range') == 'today' ? 'active' : '' }}">
                <i class="fas fa-calendar-day"></i> Hari Ini
            </a>
            <a href="{{ route('admin.laporan', ['range' => '7_days']) }}" class="pill-btn {{ request('range') == '7_days' ? 'active' : '' }}">
                <i class="fas fa-calendar-week"></i> 7 Hari
            </a>
            <a href="{{ route('admin.laporan', ['range' => '30_days']) }}" class="pill-btn {{ request('range') == '30_days' ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> 30 Hari
            </a>
            <a href="{{ route('admin.laporan', ['range' => 'this_month']) }}" class="pill-btn {{ request('range') == 'this_month' ? 'active' : '' }}">
                <i class="fas fa-calendar"></i> Bulan Ini
            </a>
            <button onclick="toggleCustomRange()" class="pill-btn {{ request('range') == 'custom' ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i> Custom
            </button>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <button onclick="window.print()" class="btn btn-secondary btn-sm" style="height:34px;">
                <i class="fas fa-print"></i> Cetak PDF
            </button>
            <a href="{{ route('admin.laporan', ['range' => '7_days']) }}" class="btn btn-secondary btn-sm" style="height:34px;">
                <i class="fas fa-sync"></i> Reset
            </a>
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
            <button type="submit" class="btn btn-primary btn-sm" style="height:34px;">
                <i class="fas fa-sync"></i> Tampilkan
            </button>
            @if(request('range') == 'custom')
                <a href="{{ route('admin.laporan', ['range' => '7_days']) }}" class="btn btn-secondary btn-sm" style="height:34px;">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>
</div>

{{-- ── SUMMARY PERIODE ── --}}
<div class="summary-box no-print" style="margin-bottom:20px;">
    <div>
        <span class="label"><i class="fas fa-calendar-alt"></i> Periode Laporan:</span>
        <span style="font-size:13px; color:#166534; font-weight:600;">
            {{ isset($startDate) && $startDate ? $startDate->format('d F Y') : '-' }} - 
            {{ isset($endDate) && $endDate ? $endDate->format('d F Y') : '-' }}
        </span>
    </div>
    <div>
        <span class="label"><i class="fas fa-file-alt"></i> Total Transaksi:</span>
        <span class="value">{{ $totalOrdersCount ?? 0 }} Nota</span>
    </div>
</div>

{{-- ── STATS ── --}}
<div class="stats-grid">
    <div class="stat-card" style="border-left-color: #1b4332;">
        <div class="stat-label"><i class="fas fa-money-bill-wave" style="color:#1b4332;"></i> Total Omzet</div>
        <div class="stat-value" style="color:#1b4332;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #d4a373;">
        <div class="stat-label"><i class="fas fa-chart-line" style="color:#d4a373;"></i> Rata-rata Harian</div>
        <div class="stat-value" style="color:#b45309;">Rp {{ number_format($avgRevenue ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #3b82f6;">
        <div class="stat-label"><i class="fas fa-receipt" style="color:#3b82f6;"></i> Total Pesanan</div>
        <div class="stat-value" style="color:#3b82f6;">{{ $totalOrdersCount ?? 0 }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #16a34a;">
        <div class="stat-label"><i class="fas fa-check-circle" style="color:#16a34a;"></i> Selesai</div>
        <div class="stat-value" style="color:#16a34a;">{{ $orderStatuses['selesai'] ?? 0 }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #dc2626;">
        <div class="stat-label"><i class="fas fa-times-circle" style="color:#dc2626;"></i> Dibatalkan</div>
        <div class="stat-value" style="color:#dc2626;">{{ $orderStatuses['dibatalkan'] ?? 0 }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #f59e0b;">
        <div class="stat-label"><i class="fas fa-hourglass-half" style="color:#f59e0b;"></i> Rata-rata Item</div>
        <div class="stat-value" style="color:#f59e0b;">
            @php
                $totalItems = 0;
                foreach($salesReports ?? [] as $order) {
                    $totalItems += $order->items->count();
                }
                $avgItems = isset($totalOrdersCount) && $totalOrdersCount > 0 ? round($totalItems / $totalOrdersCount, 1) : 0;
            @endphp
            {{ $avgItems }}
        </div>
    </div>
</div>

{{-- ── TAB ── --}}
<div class="report-tabs no-print">
    <button class="tab-btn active" onclick="switchTab(event, 'tab-penjualan')">
        <i class="fas fa-chart-bar"></i> Ringkasan & Grafik
    </button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-menu')">
        <i class="fas fa-utensils"></i> Performa Menu
    </button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-transaksi')">
        <i class="fas fa-credit-card"></i> Riwayat Invoice
    </button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-status')">
        <i class="fas fa-tasks"></i> Alur Status
    </button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-rekap')">
        <i class="fas fa-file-invoice"></i> Rekapitulasi
    </button>
</div>

{{-- ── TAB 1: PENJUALAN ── --}}
<div id="tab-penjualan" class="report-content active">
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-chart-line" style="color:#1b4332;"></i> Visualisasi Tren Omzet</div>
            <span style="font-size:12px; color:#6b7280;">
                {{ isset($startDate) && $startDate ? $startDate->format('d M Y') : '-' }} - 
                {{ isset($endDate) && $endDate ? $endDate->format('d M Y') : '-' }}
            </span>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-list" style="color:#1b4332;"></i> Rincian Penjualan</div>
            <span style="font-size:12px; color:#6b7280;">{{ count($salesReports ?? []) }} transaksi</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Nota</th>
                        <th>Pelanggan</th>
                        <th>Meja</th>
                        <th style="text-align:right">Total</th>
                        <th style="text-align:center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesReports ?? [] as $report)
                    <tr>
                        <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                        <td style="font-weight:700; color:#1b4332;">#{{ $report->order_number ?? $report->id }}</td>
                        <td>{{ $report->customer_name }}</td>
                        <td>Meja {{ $report->table->number ?? '-' }}</td>
                        <td style="text-align:right; font-weight:700;">Rp {{ number_format($report->total, 0, ',', '.') }}</td>
                        <td style="text-align:center;">
                            <span class="badge {{ $report->payment_status === 'paid' ? 'badge-success' : 'badge-danger' }}">
                                {{ $report->payment_status === 'paid' ? 'Lunas' : 'Pending' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; color:#6b7280; padding:32px;">Tidak ada data penjualan pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── TAB 2: MENU ── --}}
<div id="tab-menu" class="report-content">
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-chart-pie" style="color:#1b4332;"></i> Grafik Distribusi Penjualan Menu</div>
            <span style="font-size:12px; color:#6b7280;">
                @if(isset($topMenus) && count($topMenus) > 0)
                    Top {{ min(count($topMenus), 5) }} menu terlaris
                @else
                    Belum ada data menu
                @endif
            </span>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; align-items:center;">
                <div style="position:relative; height:260px;">
                    <canvas id="menuChart"></canvas>
                </div>
                <div>
                    <table style="width:100%; font-size:13px;">
                        <thead>
                            <tr>
                                <th style="text-align:center; width:40px;">#</th>
                                <th>Menu</th>
                                <th style="text-align:center;">Qty</th>
                                <th style="text-align:right;">Omzet</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $rank = 1; @endphp
                            @if(isset($topMenus) && count($topMenus) > 0)
                                @foreach($topMenus as $menu)
                                <tr>
                                    <td style="text-align:center; font-weight:700; color:#d4a373;">{{ $rank++ }}</td>
                                    <td style="font-weight:500;">{{ $menu['name'] ?? 'Menu' }}</td>
                                    <td style="text-align:center; font-weight:600; color:#3b82f6;">{{ $menu['quantity'] ?? 0 }}</td>
                                    <td style="text-align:right; font-weight:600; color:#1b4332;">Rp {{ number_format($menu['revenue'] ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @else
                            <tr><td colspan="4" style="text-align:center; color:#6b7280; padding:16px;">Belum ada data menu.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── TAB 3: TRANSAKSI ── --}}
<div id="tab-transaksi" class="report-content">
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-credit-card" style="color:#1b4332;"></i> Riwayat Transaksi</div>
            <span style="font-size:12px; color:#6b7280;">{{ count($salesReports ?? []) }} transaksi</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Metode Bayar</th>
                        <th style="text-align:center">Status</th>
                        <th style="text-align:right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesReports ?? [] as $tx)
                    <tr>
                        <td style="font-family:monospace; font-size:12px;">#{{ $tx->id }}</td>
                        <td>{{ $tx->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $tx->customer_name }}</td>
                        <td><span class="badge badge-secondary">{{ $tx->payment_method ?? 'Tunai' }}</span></td>
                        <td style="text-align:center;">
                            <span class="badge {{ $tx->payment_status === 'paid' ? 'badge-success' : 'badge-danger' }}">
                                {{ $tx->payment_status === 'paid' ? 'Berhasil' : 'Tertunda' }}
                            </span>
                        </td>
                        <td style="text-align:right; font-weight:700; color:#1b4332;">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; color:#6b7280; padding:32px;">Tidak ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── TAB 4: STATUS ── --}}
<div id="tab-status" class="report-content">
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-tasks" style="color:#1b4332;"></i> Alur Penyelesaian Pesanan</div>
        </div>
        <div class="card-body">
            <div class="status-box-grid">
                <div class="status-box" style="border-top-color: #16a34a;">
                    <div class="label">Selesai</div>
                    <div class="value" style="color:#16a34a;">{{ $orderStatuses['selesai'] ?? 0 }}</div>
                </div>
                <div class="status-box" style="border-top-color: #3b82f6;">
                    <div class="label">Diproses</div>
                    <div class="value" style="color:#3b82f6;">{{ $orderStatuses['diproses'] ?? 0 }}</div>
                </div>
                <div class="status-box" style="border-top-color: #f59e0b;">
                    <div class="label">Menunggu</div>
                    <div class="value" style="color:#f59e0b;">{{ $orderStatuses['menunggu'] ?? 0 }}</div>
                </div>
                <div class="status-box" style="border-top-color: #dc2626;">
                    <div class="label">Dibatalkan</div>
                    <div class="value" style="color:#dc2626;">{{ $orderStatuses['dibatalkan'] ?? 0 }}</div>
                </div>
            </div>

            <div style="background:#f8fafc; border-radius:10px; padding:16px 20px; border:1px solid #e5e7eb;">
                <h4 style="font-size:14px; margin-bottom:6px; color:#1b4332;">💡 Analisis Efisiensi</h4>
                <p style="font-size:13px; color:#475569; margin:0; line-height:1.6;">
                    Dari total <strong>{{ $totalOrdersCount ?? 0 }}</strong> pesanan, tingkat penyelesaian mencapai 
                    <strong>{{ isset($totalOrdersCount) && $totalOrdersCount > 0 ? round(($orderStatuses['selesai'] ?? 0) / $totalOrdersCount * 100, 1) : 0 }}%</strong>. 
                    @if(isset($totalOrdersCount) && $totalOrdersCount > 0 && round(($orderStatuses['selesai'] ?? 0) / $totalOrdersCount * 100, 1) >= 80)
                        <span style="color:#16a34a;">✅ Operasional berjalan dengan baik.</span>
                    @elseif(isset($totalOrdersCount) && $totalOrdersCount > 0 && round(($orderStatuses['selesai'] ?? 0) / $totalOrdersCount * 100, 1) >= 60)
                        <span style="color:#f59e0b;">⚠️ Masih ada ruang untuk peningkatan.</span>
                    @else
                        <span style="color:#dc2626;">🔴 Perlu perhatian khusus untuk meningkatkan efisiensi.</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ── TAB 5: REKAPITULASI ── --}}
<div id="tab-rekap" class="report-content">
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-file-invoice" style="color:#1b4332;"></i> Rekapitulasi Laporan</div>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
                <div style="background:#f8fafc; border-radius:10px; padding:16px; border:1px solid #e5e7eb;">
                    <div style="font-size:12px; color:#6b7280;">Total Omzet</div>
                    <div style="font-size:22px; font-weight:700; color:#1b4332;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                </div>
                <div style="background:#f8fafc; border-radius:10px; padding:16px; border:1px solid #e5e7eb;">
                    <div style="font-size:12px; color:#6b7280;">Total Pesanan</div>
                    <div style="font-size:22px; font-weight:700; color:#1b4332;">{{ $totalOrdersCount ?? 0 }} Nota</div>
                </div>
                <div style="background:#f8fafc; border-radius:10px; padding:16px; border:1px solid #e5e7eb;">
                    <div style="font-size:12px; color:#6b7280;">Rata-rata per Transaksi</div>
                    <div style="font-size:22px; font-weight:700; color:#1b4332;">
                        Rp {{ number_format(isset($totalOrdersCount) && $totalOrdersCount > 0 ? ($totalRevenue ?? 0) / $totalOrdersCount : 0, 0, ',', '.') }}
                    </div>
                </div>
                <div style="background:#f8fafc; border-radius:10px; padding:16px; border:1px solid #e5e7eb;">
                    <div style="font-size:12px; color:#6b7280;">Total Item Terjual</div>
                    <div style="font-size:22px; font-weight:700; color:#1b4332;">
                        @php
                            $totalItemsSold = 0;
                            foreach($salesReports ?? [] as $order) {
                                $totalItemsSold += $order->items->sum('quantity');
                            }
                        @endphp
                        {{ number_format($totalItemsSold, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div style="background:#fef9c3; border:1px solid #fde68a; border-radius:10px; padding:16px 20px;">
                <h4 style="font-size:14px; margin-bottom:4px; color:#78350f;">📌 Ringkasan Eksekutif</h4>
                <p style="font-size:13px; color:#78350f; margin:0; line-height:1.6;">
                    Periode {{ isset($startDate) && $startDate ? $startDate->format('d M Y') : '-' }} - 
                    {{ isset($endDate) && $endDate ? $endDate->format('d M Y') : '-' }}:
                    Terjadi <strong>{{ $totalOrdersCount ?? 0 }}</strong> transaksi dengan total omzet 
                    <strong>Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</strong>.
                    Rata-rata per hari <strong>Rp {{ number_format($avgRevenue ?? 0, 0, ',', '.') }}</strong>.
                    Menu terlaris adalah <strong>{{ isset($topMenus) && count($topMenus) > 0 ? ($topMenus[0]['name'] ?? 'Belum ada data') : 'Belum ada data' }}</strong> 
                    dengan {{ isset($topMenus) && count($topMenus) > 0 ? ($topMenus[0]['quantity'] ?? 0) : 0 }} porsi terjual.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>

<script>
    // ── TOGGLE CUSTOM RANGE ──
    function toggleCustomRange() {
        const container = document.getElementById('custom-range-container');
        container.style.display = container.style.display === 'none' ? 'block' : 'none';
    }

    // ── SWITCH TAB ──
    function switchTab(evt, tabId) {
        document.querySelectorAll('.report-content').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');

        const subTitle = document.getElementById('print-title-sub');
        if (subTitle) subTitle.innerText = evt.currentTarget.innerText.trim();
    }

    // ── AUTO RESIZE CHART ──
    function resizeCharts() {
        const container = document.querySelector('.chart-container');
        if (container) {
            const width = container.clientWidth;
            const height = Math.min(width * 0.6, 300);
            container.style.height = Math.max(height, 200) + 'px';
        }
    }

    // ── INIT CHART ──
    document.addEventListener("DOMContentLoaded", function() {
        @php
            // Group sales by date
            $groupedSales = isset($salesReports) ? $salesReports->groupBy(function($item) {
                return $item->created_at->format('d M');
            }) : collect();
            $chartDates = $groupedSales->keys()->toArray();
            $chartTotals = $groupedSales->map(function($dayRecords) {
                return $dayRecords->where('payment_status', 'paid')->sum('total');
            })->values()->toArray();

            // Jika data kosong, tampilkan placeholder
            if (empty($chartDates)) {
                $chartDates = ['Tidak Ada Data'];
                $chartTotals = [0];
            }

            $menuLabels = [];
            $menuQuantities = [];
            $menuColors = ['#1b4332', '#2d6a4f', '#d4a373', '#3b82f6', '#f59e0b', '#dc2626', '#16a34a', '#8b5cf6'];
            
            if (isset($topMenus) && !empty($topMenus) && is_iterable($topMenus)) {
                $topMenusCollection = is_array($topMenus) ? collect($topMenus) : $topMenus;
                $i = 0;
                foreach($topMenusCollection->take(8) as $menu) {
                    $menuLabels[] = $menu['name'] ?? 'Unknown';
                    $menuQuantities[] = $menu['quantity'] ?? 0;
                    $i++;
                }
            }
            
            // Jika tidak ada data menu, tampilkan placeholder
            if (empty($menuLabels)) {
                $menuLabels = ['Belum Ada Data'];
                $menuQuantities = [1];
                $menuColors = ['#e5e7eb'];
            }
        @endphp

        const datesData = {!! json_encode($chartDates) !!};
        const revenueData = {!! json_encode($chartTotals) !!};
        const menuLabels = {!! json_encode($menuLabels) !!};
        const menuQtys = {!! json_encode($menuQuantities) !!};
        const menuColors = {!! json_encode($menuColors) !!};

        // ── REVENUE CHART ──
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: datesData,
                datasets: [{
                    label: 'Omzet (Rp)',
                    data: revenueData,
                    borderColor: '#1b4332',
                    backgroundColor: 'rgba(27, 67, 50, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#d4a373',
                    pointBorderColor: '#1b4332',
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#d4a373'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            font: { size: 10 },
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9 } }
                    }
                }
            }
        });

        // ── MENU CHART ──
        const ctxMenu = document.getElementById('menuChart').getContext('2d');
        new Chart(ctxMenu, {
            type: 'doughnut',
            data: {
                labels: menuLabels,
                datasets: [{
                    data: menuQtys,
                    backgroundColor: menuColors.slice(0, menuLabels.length),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 10,
                            font: { size: 10 },
                            usePointStyle: true
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // ── RESIZE ──
        setTimeout(resizeCharts, 100);
        window.addEventListener('resize', resizeCharts);
    });
</script>
@endpush