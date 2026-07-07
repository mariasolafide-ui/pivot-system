@extends('layouts.admin')
@section('title', 'Dashboard Pivot Cafe')
@section('page-title', 'Dashboard')

@section('content')

<style>
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
    .breadcrumb-admin .current {
        color: #1b4332;
        font-weight: 600;
    }

    /* ── VARIABEL WARNA ── */
    :root {
        --cafe-green: #1b4332;
        --cafe-green-hover: #2d6a4f;
        --cafe-green-light: #e8f5e9;
        --accent-cokelat: #d4a373;
        --accent-cokelat-hover: #bc8a5f;
        --accent-light: #faedcd;
        --text-dark: #2d3748;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
        --shadow-hover: 0 4px 12px rgba(0,0,0,0.08);
        --radius: 12px;
        --success: #16a34a;
        --danger: #dc2626;
        --warning: #f59e0b;
        --info: #3b82f6;
    }

    /* ── ALERT / VALIDATION MESSAGES ── */
    .alert {
        padding: 14px 20px;
        border-radius: var(--radius);
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border: 1px solid transparent;
        animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #166534;
    }

    .alert-success i {
        color: var(--success);
    }

    .alert-danger {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    .alert-danger i {
        color: var(--danger);
    }

    .alert-warning {
        background: #fffbeb;
        border-color: #fde68a;
        color: #78350f;
    }

    .alert-warning i {
        color: var(--warning);
    }

    .alert-info {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1e40af;
    }

    .alert-info i {
        color: var(--info);
    }

    .alert-icon {
        font-size: 20px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .alert-message {
        font-size: 13px;
        opacity: 0.9;
    }

    .alert-close {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
        color: inherit;
        opacity: 0.5;
        transition: opacity 0.3s;
        padding: 0 4px;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* ── STATS GRID ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 18px 20px;
        box-shadow: var(--shadow-sm);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--accent-cokelat);
        opacity: 0.3;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .stat-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #718096;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.2;
    }

    .stat-sub {
        font-size: 12px;
        color: #718096;
        margin-top: 4px;
    }

    /* ── CARDS ── */
    .card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
        overflow: hidden;
        transition: box-shadow 0.25s ease;
    }

    .card:hover {
        box-shadow: var(--shadow-hover);
    }

    .card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
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
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-body {
        padding: 20px;
    }

    /* ── BADGES ── */
    .badge {
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 30px;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-warning {
        background: var(--accent-light);
        color: #b58253;
        border: 1px solid var(--accent-cokelat);
    }
    .badge-success {
        background: var(--cafe-green-light);
        color: var(--cafe-green);
    }
    .badge-danger {
        background: #fee2e2;
        color: #b91c1c;
    }
    .badge-info {
        background: #e0f2fe;
        color: #0369a1;
    }
    .badge-secondary {
        background: #f1f5f9;
        color: #475569;
    }

    /* ── BUTTONS ── */
    .btn {
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 500;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        font-family: 'Outfit', sans-serif;
    }

    .btn-sm {
        padding: 6px 14px;
        font-size: 12px;
    }

    .btn-primary {
        background: var(--cafe-green);
        color: white;
    }
    .btn-primary:hover {
        background: var(--cafe-green-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.2);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #4b5563;
        border-color: #e5e7eb;
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-1px);
    }

    .btn-accent {
        background: var(--accent-cokelat);
        color: white;
    }
    .btn-accent:hover {
        background: var(--accent-cokelat-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(212, 163, 115, 0.3);
    }

    /* ── TABLES ── */
    .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 600px;
    }

    th {
        background: #f8fafc;
        color: var(--text-dark);
        font-weight: 600;
        border-bottom: 2px solid var(--border-color);
        padding: 10px 14px;
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }

    td {
        border-bottom: 1px solid var(--border-color);
        padding: 10px 14px;
        vertical-align: middle;
    }

    tbody tr {
        transition: background-color 0.15s;
    }
    tbody tr:hover {
        background-color: #f8fafc;
    }

    /* ── FILTER BUTTONS ── */
    .filter-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group .btn {
        font-size: 12px;
        padding: 5px 14px;
    }

    /* ── CUSTOM DATE FORM ── */
    #custom-date-form {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        background: #fafafa;
    }

    #custom-date-form form {
        display: flex;
        gap: 12px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    #custom-date-form label {
        font-size: 12px;
        font-weight: 600;
        display: block;
        margin-bottom: 4px;
        color: var(--text-dark);
    }

    #custom-date-form input[type="date"] {
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 13px;
        padding: 6px 10px;
        background: white;
        font-family: 'Outfit', sans-serif;
    }

    #custom-date-form input[type="date"]:focus {
        outline: none;
        border-color: var(--cafe-green);
        box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.1);
    }

    .form-error {
        color: var(--danger);
        font-size: 12px;
        margin-top: 4px;
        display: none;
    }

    .form-error.show {
        display: block;
    }

    input.is-invalid {
        border-color: var(--danger) !important;
    }

    /* ── SUMMARY BOX ── */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .summary-box {
        border-radius: var(--radius);
        padding: 18px 20px;
        transition: transform 0.2s ease;
    }

    .summary-box:hover {
        transform: translateY(-2px);
    }

    .summary-box .label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 4px;
    }

    .summary-box .value {
        font-size: 26px;
        font-weight: 700;
        line-height: 1.2;
    }

    .summary-box .sub {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    .summary-green {
        background: var(--cafe-green-light);
        border: 1px solid #bbf7d0;
    }
    .summary-green .label { color: var(--cafe-green); }
    .summary-green .value { color: var(--cafe-green); }

    .summary-cream {
        background: #fdfbf7;
        border: 1px solid var(--accent-cokelat);
    }
    .summary-cream .label { color: #b58253; }
    .summary-cream .value { color: var(--text-dark); }

    /* ── RESPONSIVE ── */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stat-value {
            font-size: 22px;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-group {
            width: 100%;
            justify-content: flex-start;
        }

        #custom-date-form form {
            flex-direction: column;
            align-items: stretch;
        }

        #custom-date-form input[type="date"] {
            width: 100%;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .summary-box .value {
            font-size: 22px;
        }

        table {
            font-size: 12px;
            min-width: 500px;
        }

        th, td {
            padding: 8px 10px;
        }

        .alert {
            padding: 12px 16px;
            font-size: 13px;
        }
        .breadcrumb-admin {
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .stat-card {
            padding: 14px 16px;
        }

        .stat-value {
            font-size: 20px;
        }

        .stat-label {
            font-size: 10px;
        }

        .card-header {
            padding: 12px 16px;
        }

        .card-body {
            padding: 14px 16px;
        }

        .card-title {
            font-size: 14px;
        }

        .btn {
            font-size: 12px;
            padding: 6px 12px;
        }

        .btn-sm {
            font-size: 11px;
            padding: 4px 10px;
        }

        table {
            font-size: 11px;
            min-width: 400px;
        }

        th, td {
            padding: 6px 8px;
        }

        .alert {
            padding: 10px 14px;
            font-size: 12px;
            flex-direction: column;
            align-items: flex-start;
        }

        .alert-icon {
            font-size: 18px;
        }
        .breadcrumb-admin {
            font-size: 11px;
        }
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme: dark) {
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
        .stat-sub {
            color: #9ca3af;
        }
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
        .card-body {
            background: #1f2937;
        }
        th {
            background: #111827;
            color: #e5e7eb;
            border-color: #374151;
        }
        td {
            border-color: #374151;
            color: #e5e7eb;
        }
        tbody tr:hover {
            background-color: #111827;
        }
        .summary-green {
            background: #064e3b;
            border-color: #059669;
        }
        .summary-green .label { color: #86efac; }
        .summary-green .value { color: #86efac; }
        .summary-cream {
            background: #1f2937;
            border-color: #374151;
        }
        .summary-cream .label { color: #d4a373; }
        .summary-cream .value { color: #f3f4f6; }
        .alert-success {
            background: #064e3b;
            border-color: #059669;
            color: #86efac;
        }
        .alert-danger {
            background: #7f1d1d;
            border-color: #991b1b;
            color: #fca5a5;
        }
        .alert-warning {
            background: #422b00;
            border-color: #92400e;
            color: #fbbf24;
        }
        .alert-info {
            background: #1e3a5f;
            border-color: #0369a1;
            color: #93c5fd;
        }
        #custom-date-form {
            background: #111827;
            border-color: #374151;
        }
        #custom-date-form label {
            color: #e5e7eb;
        }
        #custom-date-form input[type="date"] {
            background: #1f2937;
            border-color: #374151;
            color: #f3f4f6;
        }
        #custom-date-form input[type="date"]:focus {
            border-color: #d4a373;
        }
        .badge-secondary {
            background: #374151;
            color: #e5e7eb;
        }
        .breadcrumb-admin {
            color: #9ca3af;
        }
        .breadcrumb-admin .current {
            color: #d4a373;
        }
    }

    /* ── PRINT ── */
    @media print {
        .no-print { display: none !important; }
        .stat-card { box-shadow: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd; }
        .alert { border: 1px solid #ddd; background: #f9f9f9 !important; }
        .breadcrumb-admin { display: none !important; }
    }
</style>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <i class="fas fa-home" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Dashboard</span>
</div>

{{-- ── ALERT / VALIDATION MESSAGES ── --}}

{{-- Success Alert --}}
@if(session('success'))
<div class="alert alert-success" role="alert">
    <i class="fas fa-check-circle alert-icon"></i>
    <div class="alert-content">
        <div class="alert-title">Berhasil!</div>
        <div class="alert-message">{{ session('success') }}</div>
    </div>
    <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

{{-- Error Alert --}}
@if(session('error'))
<div class="alert alert-danger" role="alert">
    <i class="fas fa-exclamation-circle alert-icon"></i>
    <div class="alert-content">
        <div class="alert-title">Gagal!</div>
        <div class="alert-message">{{ session('error') }}</div>
    </div>
    <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

{{-- Warning Alert --}}
@if(session('warning'))
<div class="alert alert-warning" role="alert">
    <i class="fas fa-exclamation-triangle alert-icon"></i>
    <div class="alert-content">
        <div class="alert-title">Peringatan!</div>
        <div class="alert-message">{{ session('warning') }}</div>
    </div>
    <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

{{-- Info Alert --}}
@if(session('info'))
<div class="alert alert-info" role="alert">
    <i class="fas fa-info-circle alert-icon"></i>
    <div class="alert-content">
        <div class="alert-title">Informasi</div>
        <div class="alert-message">{{ session('info') }}</div>
    </div>
    <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

{{-- Validation Errors --}}
@if($errors->any())
<div class="alert alert-danger" role="alert">
    <i class="fas fa-times-circle alert-icon"></i>
    <div class="alert-content">
        <div class="alert-title">Validasi Gagal!</div>
        <div class="alert-message">
            Terdapat {{ $errors->count() }} kesalahan pada formulir:
            <ul style="margin-top: 6px; padding-left: 20px; list-style: disc;">
                @foreach($errors->all() as $error)
                    <li style="font-size: 13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

{{-- ── STAT CARDS ── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">📋 Pesanan Aktif</div>
        <div class="stat-value" style="color: #b58253;">{{ $activeOrders ?? 0 }}</div>
        <div class="stat-sub">Menunggu & Diproses</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">⏳ Pembayaran Pending</div>
        <div class="stat-value" style="color: #6b7280;">{{ $pendingPayments ?? 0 }}</div>
        <div class="stat-sub">Belum dikonfirmasi</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">🔔 Panggilan Pelayan</div>
        <div class="stat-value" style="{{ ($pendingWaiterCalls ?? 0) > 0 ? 'color:#dc2626;' : 'color: var(--cafe-green);' }}">
            {{ $pendingWaiterCalls ?? 0 }}
        </div>
        <div class="stat-sub">Menunggu respons</div>
    </div>

    {{-- PERBAIKAN: judul diubah menjadi "Stok Produk Menipis" --}}
    <div class="stat-card" style="border-left: 4px solid #dc2626;">
        <div class="stat-label" style="color: #dc2626;">⚠️ Stok Produk Menipis</div>
        <div class="stat-value" style="color: #dc2626;">
            {{ isset($retailProducts) ? $retailProducts->where('stock', '<=', 5)->count() : 0 }}
        </div>
        <div class="stat-sub">Stok di bawah 5 pcs</div>
    </div>

    <div class="stat-card" style="border-left: 4px solid var(--cafe-green);">
        <div class="stat-label" style="color: var(--cafe-green)">💰 Pemasukan Hari Ini</div>
        <div class="stat-value" style="color: var(--cafe-green); font-size: 22px;">
            Rp {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}
        </div>
        <div class="stat-sub">Order lunas hari ini</div>
    </div>
</div>

{{-- ── RINGKASAN PEMASUKAN ── --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">📊 Ringkasan Pemasukan & Aktivitas Kafe</div>
            <div style="font-size:12px;color:#718096;margin-top:4px;" class="no-print">
                Menampilkan data berdasarkan periode yang dipilih
            </div>
        </div>
        <div class="filter-group no-print">
            <a href="{{ route('admin.dashboard', ['period' => '1']) }}" 
               class="btn btn-sm {{ ($period ?? '1') === '1' ? 'btn-primary' : 'btn-secondary' }}">
                Hari Ini
            </a>
            <a href="{{ route('admin.dashboard', ['period' => '7']) }}" 
               class="btn btn-sm {{ ($period ?? '1') === '7' ? 'btn-primary' : 'btn-secondary' }}">
                7 Hari
            </a>
            <a href="{{ route('admin.dashboard', ['period' => '30']) }}" 
               class="btn btn-sm {{ ($period ?? '1') === '30' ? 'btn-primary' : 'btn-secondary' }}">
                30 Hari
            </a>
            <button type="button" class="btn btn-sm {{ ($period ?? '1') === 'custom' ? 'btn-primary' : 'btn-secondary' }}" 
                    onclick="toggleCustomDate()">
                <i class="fas fa-calendar-alt"></i> Custom
            </button>
        </div>
    </div>
    
    {{-- Custom Date Form --}}
    <div id="custom-date-form" style="{{ ($period ?? '1') === 'custom' ? '' : 'display:none' }};">
        <form method="GET" action="{{ route('admin.dashboard') }}" id="customDateForm">
            <input type="hidden" name="period" value="custom">
            <div>
                <label for="start_date">Dari Tanggal</label>
                <input type="date" 
                       id="start_date" 
                       name="start_date" 
                       value="{{ ($period ?? '1') === 'custom' && isset($startDate) ? $startDate->format('Y-m-d') : '' }}"
                       class="{{ $errors->has('start_date') ? 'is-invalid' : '' }}">
                <div class="form-error {{ $errors->has('start_date') ? 'show' : '' }}">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('start_date') }}
                </div>
            </div>
            <div>
                <label for="end_date">Sampai Tanggal</label>
                <input type="date" 
                       id="end_date" 
                       name="end_date" 
                       value="{{ ($period ?? '1') === 'custom' && isset($endDate) ? $endDate->format('Y-m-d') : '' }}"
                       class="{{ $errors->has('end_date') ? 'is-invalid' : '' }}">
                <div class="form-error {{ $errors->has('end_date') ? 'show' : '' }}">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('end_date') }}
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" id="applyFilterBtn">
                <i class="fas fa-check"></i> Terapkan
            </button>
            @if(($period ?? '1') === 'custom')
                <a href="{{ route('admin.dashboard', ['period' => '1']) }}" 
                   class="btn btn-secondary btn-sm">
                    <i class="fas fa-undo"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <div class="card-body">
        <div class="summary-grid">
            <div class="summary-box summary-green">
                <div class="label">Total Pendapatan Bersih</div>
                <div class="value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                <div class="sub">Akumulasi transaksi sukses</div>
            </div>
            <div class="summary-box summary-cream">
                <div class="label">Volume Transaksi Sukses</div>
                <div class="value">
                    {{ number_format($totalOrders ?? 0, 0, ',', '.') }} 
                    <span style="font-size:16px;font-weight:400;color:#b58253;">Nota</span>
                </div>
                <div class="sub">Jumlah nota berhasil terbit</div>
            </div>
        </div>
    </div>
</div>

{{-- ── KATEGORI & MENU TERLARIS ── --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:20px;margin-bottom:24px;">
    <div class="card" style="margin-bottom:0;">
        <div class="card-header">
            <div class="card-title">📊 Kategori Terlaris</div>
            @if(isset($topCategories) && $topCategories->count() > 0)
                <span class="badge badge-secondary">{{ $topCategories->count() }} Kategori</span>
            @endif
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:50px;text-align:center;">#</th>
                        <th>Kategori</th>
                        <th style="text-align:right;">Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($topCategories ?? []) as $i => $cat)
                    <tr>
                        <td style="text-align:center;font-weight:700;color:var(--cafe-green);">
                            {{ $i + 1 }}
                        </td>
                        <td style="font-weight:600;">{{ $cat->name }}</td>
                        <td style="text-align:right;font-weight:700;color:var(--cafe-green);">
                            {{ number_format($cat->total_qty, 0, ',', '.') }} item
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center;color:#9ca3af;padding:24px;">
                            <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;opacity:0.5;"></i>
                            Belum ada data transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PERBAIKAN: Menu Terlaris – nama menu tampil dengan aman --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header">
            <div class="card-title">🔥 Menu Terlaris</div>
            @if(isset($topMenus) && $topMenus->count() > 0)
                <span class="badge badge-secondary">{{ $topMenus->count() }} Menu</span>
            @endif
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:50px;text-align:center;">#</th>
                        <th>Menu</th>
                        <th style="text-align:right;">Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($topMenus ?? []) as $i => $item)
                        <tr>
                            <td style="text-align:center;font-weight:700;color:var(--cafe-green);">
                                {{ $i + 1 }}
                            </td>
                            <td>
                                <div style="font-weight:600;font-size:13px;">
                                    {{ $item->menu->name ?? 'Menu Tidak Diketahui' }}
                                </div>
                                <div style="font-size:11px;color:#9ca3af;margin-top:2px;">
                                    {{ optional($item->menu->category)->name ?? '' }}
                                </div>
                            </td>
                            <td style="text-align:right;font-weight:700;color:var(--cafe-green);">
                                {{ number_format($item->total_qty ?? 0, 0, ',', '.') }} porsi
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align:center;color:#9ca3af;padding:24px;">
                                <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;opacity:0.5;"></i>
                                Belum ada data transaksi
                            </td>
                        </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── PRODUK RETAIL ── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">📦 Produk Kopi Retail</div>
        <span class="badge badge-secondary no-print">
            {{ isset($retailProducts) ? $retailProducts->count() : 0 }} produk
        </span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:50px;text-align:center;">#</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th style="text-align:center;">Stok</th>
                    <th style="text-align:right;">Omzet</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($retailProducts ?? []) as $index => $prod)
                <tr>
                    <td style="text-align:center;">{{ $index + 1 }}</td>
                    <td style="font-weight:600;">{{ $prod->name }}</td>
                    <td>Rp {{ number_format($prod->price, 0, ',', '.') }}</td>
                    <td style="text-align:center;">
                        <span class="badge {{ $prod->stock <= 3 ? 'badge-danger' : 'badge-success' }}">
                            {{ $prod->stock }} Pcs
                        </span>
                        @if($prod->stock <= 3)
                            <span style="display:block;font-size:10px;color:#dc2626;margin-top:2px;">
                                <i class="fas fa-exclamation-triangle"></i> Segera restock!
                            </span>
                        @endif
                    </td>
                    <td style="text-align:right;font-weight:700;color:var(--cafe-green);">
                        @php
                            $terjual = \App\Models\OrderItem::where('retail_product_id', $prod->id)->sum('quantity');
                        @endphp
                        Rp {{ number_format($terjual * $prod->price, 0, ',', '.') }}
                        <small style="display:block;font-size:10px;color:#718096;font-weight:400;">
                            Terjual: {{ $terjual }} Pcs
                        </small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#9ca3af;padding:24px;">
                        <i class="fas fa-box-open" style="font-size:24px;display:block;margin-bottom:8px;opacity:0.5;"></i>
                        Belum ada produk retail
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── STATUS MEJA ── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">🪑 Live Status Meja</div>
        <span style="font-size:12px;background:#f3f4f6;padding:4px 10px;border-radius:6px;color:#6b7280;" class="no-print">
            🔄 Auto-refresh 10s
        </span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Meja</th>
                    <th>Status</th>
                    <th>Pelanggan</th>
                    <th>Status Pesanan</th>
                    <th>Status Bayar</th>
                    <th style="text-align:right;">Total</th>
                    <th class="no-print" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($tableStatuses ?? []) as $table)
                @php $order = $table->orders->first(); @endphp
                <tr>
                    <td style="font-weight:700;color:var(--cafe-green);">
                        Meja {{ $table->number }}
                    </td>
                    <td>
                        @if($order)
                            <span class="badge badge-warning">Terisi</span>
                        @else
                            <span class="badge badge-success">Kosong</span>
                        @endif
                    </td>
                    <td style="font-weight:500;">{{ $order?->customer_name ?? '—' }}</td>
                    <td>
                        @if($order)
                            @if($order->order_status === 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($order->order_status === 'diproses')
                                <span class="badge badge-info">Diproses</span>
                            @elseif($order->order_status === 'selesai')
                                <span class="badge badge-success">Selesai</span>
                            @endif
                        @else
                            <span style="color:#9ca3af;font-size:12px;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($order)
                            @if($order->payment_status === 'paid')
                                <span class="badge badge-success">Lunas</span>
                            @else
                                <span class="badge badge-danger">Belum Bayar</span>
                            @endif
                        @else
                            <span style="color:#9ca3af;font-size:12px;">—</span>
                        @endif
                    </td>
                    <td style="text-align:right;font-weight:600;">
                        @if($order)
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        @else
                            <span style="color:#9ca3af;font-size:12px;">—</span>
                        @endif
                    </td>
                    <td class="no-print" style="text-align:center;">
                        @if($order)
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        @else
                            <span style="color:#9ca3af;font-size:11px;font-style:italic;">Standby</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#9ca3af;padding:24px;">
                        <i class="fas fa-chair" style="font-size:24px;display:block;margin-bottom:8px;opacity:0.5;"></i>
                        Belum ada data meja
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── FOOTER WELCOME ── --}}
<div class="card no-print">
    <div class="card-body">
        <p style="color:#6b7280;font-size:13px;margin:0;text-align:center;">
            <i class="fas fa-coffee" style="color:var(--accent-cokelat);margin-right:8px;"></i>
            Halaman ini menampilkan rekapitulasi data Pivot Cafe. 
            Gunakan filter di atas untuk mengubah periode pelaporan.
        </p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── TOGGLE CUSTOM DATE ──
    function toggleCustomDate() {
        const el = document.getElementById('custom-date-form');
        if (el.style.display === 'none') {
            el.style.display = 'block';
            setTimeout(() => {
                const firstInput = el.querySelector('input');
                if (firstInput) firstInput.focus();
            }, 100);
        } else {
            el.style.display = 'none';
        }
    }

    // ── VALIDASI CUSTOM DATE FORM ──
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('customDateForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const startDate = document.getElementById('start_date');
                const endDate = document.getElementById('end_date');
                let isValid = true;

                document.querySelectorAll('.form-error').forEach(el => el.classList.remove('show'));
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                if (!startDate.value) {
                    showError(startDate, 'Tanggal mulai harus diisi');
                    isValid = false;
                }

                if (!endDate.value) {
                    showError(endDate, 'Tanggal akhir harus diisi');
                    isValid = false;
                }

                if (startDate.value && endDate.value) {
                    const start = new Date(startDate.value);
                    const end = new Date(endDate.value);
                    if (start > end) {
                        showError(endDate, 'Tanggal akhir harus lebih besar dari tanggal mulai');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    const firstError = document.querySelector('.form-error.show');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    const btn = document.getElementById('applyFilterBtn');
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                    btn.disabled = true;
                }
            });
        }

        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });

        function validateField(input) {
            const errorEl = input.parentElement.querySelector('.form-error');
            if (!errorEl) return;

            if (!input.value) {
                showError(input, input.id === 'start_date' ? 'Tanggal mulai harus diisi' : 'Tanggal akhir harus diisi');
                return false;
            }

            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);
                if (start > end) {
                    showError(endDate, 'Tanggal akhir harus lebih besar dari tanggal mulai');
                    return false;
                }
            }

            input.classList.remove('is-invalid');
            errorEl.classList.remove('show');
            return true;
        }

        function showError(input, message) {
            const errorEl = input.parentElement.querySelector('.form-error');
            if (errorEl) {
                input.classList.add('is-invalid');
                errorEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + message;
                errorEl.classList.add('show');
            }
        }

        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease, transform 0.3s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 500);
            }, 8000);
        });
    });

    let refreshTimer;
    function startAutoRefresh() {
        clearTimeout(refreshTimer);
        refreshTimer = setTimeout(function() {
            location.reload();
        }, 10000);
    }

    document.addEventListener('click', function() {
        clearTimeout(refreshTimer);
        startAutoRefresh();
    });

    document.addEventListener('keydown', function() {
        clearTimeout(refreshTimer);
        startAutoRefresh();
    });

    startAutoRefresh();

    console.log('✅ Dashboard Pivot Cafe loaded');
    console.log('📋 Validasi form siap digunakan');
</script>
@endpush