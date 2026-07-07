@extends('layouts.admin')
@section('title', 'Kelola Meja')
@section('page-title', 'Kelola Meja')

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

    /* ── TOMBOL KONSISTEN SAMA SEPERTI CATEGORIES ── */
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
        background: #0e6446;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 5px 16px;
        font-size: 12px;
        height: 32px;
        border-radius: 30px !important;
        cursor: pointer;
    }
    .btn-primary:hover {
        background: #1b7a5a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 100, 70, 0.35);
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
        padding: 5px 16px;
        font-size: 12px;
        height: 32px;
        border-radius: 30px !important;
        cursor: pointer;
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-1px);
    }

    .btn-sm {
        padding: 4px 14px;
        font-size: 11px;
        height: 30px;
        border-radius: 30px !important;
        cursor: pointer;
    }

    /* ── ACTION WRAPPER ── */
    .action-buttons {
        display: flex;
        gap: 4px;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: center;
    }

    .action-buttons .btn {
        flex: 0 0 auto;
        font-size: 11px;
        padding: 4px 14px;
        border-radius: 30px !important;
        font-weight: 500;
        white-space: nowrap;
        height: 30px;
        min-width: 55px;
        cursor: pointer;
    }

    .action-buttons .btn i {
        font-size: 11px;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-wrap: wrap;
        }
        .action-buttons .btn {
            flex: 0 0 auto;
            font-size: 10px;
            padding: 3px 10px;
            height: 26px;
            min-width: 50px;
            border-radius: 30px !important;
        }
    }

    @media (max-width: 480px) {
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        .action-buttons .btn {
            width: 100%;
            flex: none;
            font-size: 10px;
            padding: 4px 10px;
            height: 28px;
            justify-content: center;
            border-radius: 30px !important;
        }
    }

    /* ── BADGE ── */
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

    .badge-warning {
        background: #fef9c3;
        color: #854d0e;
    }

    .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
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

    .stat-sub {
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
    }

    /* ── CARD ── */
    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .card-header {
        padding: 16px 20px;
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

    /* ── TABLE ── */
    .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-wrap table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 700px;
    }

    .table-wrap th {
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

    .table-wrap td {
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 14px;
        vertical-align: middle;
    }

    .table-wrap tbody tr {
        transition: background-color 0.15s;
    }

    .table-wrap tbody tr:hover {
        background-color: #f8fafc;
    }

    /* ── SEARCH ── */
    .search-wrapper {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .search-wrapper input {
        padding: 5px 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 12px;
        width: 160px;
        outline: none;
        height: 32px;
        transition: all 0.2s;
    }

    .search-wrapper input:focus {
        border-color: #1b4332;
        box-shadow: 0 0 0 2px rgba(27, 67, 50, 0.1);
    }

    .search-wrapper .btn {
        height: 32px;
    }

    /* ── MODAL ── */
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-backdrop.open {
        display: flex;
    }

    .modal {
        background: white;
        border-radius: 12px;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        width: 95%;
        max-width: 480px;
    }

    .modal-sm {
        max-width: 400px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #fafafa;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #6b7280;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
    }

    .modal-close:hover {
        color: #111827;
    }

    .modal-body {
        padding: 24px;
        overflow-y: auto;
        max-height: calc(90vh - 130px);
    }

    .modal-footer {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
        background: #fafafa;
        border-radius: 0 0 12px 12px;
    }

    .modal-footer .btn {
        font-size: 12px;
        padding: 6px 16px;
        height: 34px;
        border-radius: 30px !important;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        display: block;
        font-size: 13px;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color .2s;
        outline: none;
        font-family: 'Outfit', sans-serif;
    }

    .form-group input:focus {
        border-color: #1b4332;
        box-shadow: 0 0 0 2px rgba(27, 67, 50, 0.1);
    }

    .form-group input.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }

    .form-group input.is-valid {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .form-group .required {
        color: #dc2626;
    }

    .form-group .field-error {
        color: #dc2626;
        font-size: 11px;
        margin-top: 4px;
        display: none;
    }

    .form-group .field-error.show {
        display: block;
    }

    .form-group .field-success {
        color: #16a34a;
        font-size: 11px;
        margin-top: 4px;
        display: none;
    }

    .form-group .field-success.show {
        display: block;
    }

    .form-group .form-hint {
        font-size: 11px;
        color: #6b7280;
        margin-top: 4px;
    }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }

    .empty-state .icon {
        font-size: 40px;
        margin-bottom: 8px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }

    .empty-state p {
        font-size: 13px;
        color: #6b7280;
    }

    /* ── ALERT / ERROR SUMMARY (dipakai untuk validasi, success, & error) ── */
    .error-summary {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
        display: none;
    }

    .error-summary.show {
        display: block;
    }

    .error-summary .error-title {
        font-weight: 600;
        color: #991b1b;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .error-summary ul {
        margin: 4px 0 0 20px;
        color: #991b1b;
        font-size: 12px;
    }

    /* ── PAGINATION ── */
    .pagination-wrapper {
        padding: 12px 16px;
        border-top: 1px solid #e5e7eb;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-wrapper {
            width: 100%;
        }

        .search-wrapper input {
            flex: 1;
            width: 100%;
        }

        .table-wrap table {
            font-size: 12px;
            min-width: 500px;
        }

        th, td {
            padding: 8px 10px;
        }

        .modal {
            max-width: 95% !important;
            margin: 10px;
        }

        .modal-body {
            padding: 16px;
        }

        .modal-footer {
            flex-direction: column;
            gap: 6px;
        }

        .modal-footer .btn {
            width: 100%;
            justify-content: center;
            border-radius: 30px !important;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
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
        .table-wrap table {
            font-size: 11px;
            min-width: 400px;
        }

        th, td {
            padding: 6px 8px;
        }

        .card-header {
            padding: 12px 16px;
        }

        .card-title {
            font-size: 14px;
        }

        .modal-title {
            font-size: 15px;
        }

        .modal-footer .btn {
            font-size: 12px;
            padding: 6px 12px;
            height: 30px;
            border-radius: 30px !important;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .stat-value {
            font-size: 20px;
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

        .stat-sub {
            color: #9ca3af;
        }

        .table-wrap th {
            background: #111827;
            color: #e5e7eb;
            border-color: #374151;
        }

        .table-wrap td {
            border-color: #374151;
            color: #e5e7eb;
        }

        .table-wrap tbody tr:hover {
            background-color: #111827;
        }

        .modal {
            background: #1f2937;
        }

        .modal-header {
            background: #1f2937;
            border-color: #374151;
        }

        .modal-title {
            color: #f3f4f6;
        }

        .modal-footer {
            background: #1f2937;
            border-color: #374151;
        }

        .form-group label {
            color: #e5e7eb;
        }

        .form-group input {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }

        .form-group input:focus {
            border-color: #d4a373;
        }

        .form-group input.is-invalid {
            border-color: #dc2626;
            background: #1f1414;
        }

        .form-group input.is-valid {
            border-color: #16a34a;
            background: #064e3b;
        }

        .error-summary {
            background: #1f1414;
            border-color: #dc2626;
        }

        .error-summary .error-title {
            color: #fca5a5;
        }

        .error-summary ul {
            color: #fca5a5;
        }

        .search-wrapper input {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }

        .search-wrapper input:focus {
            border-color: #d4a373;
        }

        .empty-state h3 {
            color: #f3f4f6;
        }

        .empty-state p {
            color: #9ca3af;
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
    <i class="fas fa-chair" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Kelola Meja</span>
</div>

{{-- ── ERROR SUMMARY (khusus validasi form, sama seperti halaman promo) ── --}}
@if($errors->any())
<div class="error-summary show" id="error-summary">
    <div class="error-title">
        <i class="fas fa-exclamation-circle"></i> Terdapat kesalahan pada formulir:
    </div>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ── STATS ─────────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    @php
    $totalTables = $tables->total();
    $availableTables = $tables->filter(function($table) {
        return !$table->orders->first() || 
               !in_array($table->orders->first()?->order_status, ['menunggu', 'diproses']);
    })->count();
    $occupiedTables = $totalTables - $availableTables;
    $hasOrder = $tables->filter(function($table) {
        return $table->orders->isNotEmpty();
    })->count();
    @endphp

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-chair" style="color: #1b4332;"></i>
            Total Meja
        </div>
        <div class="stat-value">{{ $totalTables }}</div>
        <div class="stat-sub">Meja terdaftar</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-check-circle" style="color: #16a34a;"></i>
            Meja Kosong
        </div>
        <div class="stat-value" style="color: #16a34a;">{{ $availableTables }}</div>
        <div class="stat-sub">Tersedia untuk pelanggan</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-users" style="color: #f59e0b;"></i>
            Meja Terisi
        </div>
        <div class="stat-value" style="color: #f59e0b;">{{ $occupiedTables }}</div>
        <div class="stat-sub">Sedang digunakan</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-clipboard-list" style="color: #3b82f6;"></i>
            Meja dengan Order
        </div>
        <div class="stat-value">{{ $hasOrder }}</div>
        <div class="stat-sub">Memiliki pesanan aktif</div>
    </div>
</div>

{{-- ── CARD ─────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-table" style="color: #1b4332; margin-right:8px;"></i>
            Daftar Meja
        </div>
        
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            {{-- Pencarian --}}
            <form action="{{ url()->current() }}" method="GET" style="display:flex; align-items:center; gap:4px; margin:0;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari meja..." 
                       style="padding:5px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:12px; width:160px; outline:none; height:32px;">
                <button type="submit" class="btn btn-secondary btn-sm" style="height:32px;">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm" style="height:32px;">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>

            <button type="button" class="btn btn-primary btn-sm" onclick="openCreateTable()">
                <i class="fas fa-plus"></i> Tambah Meja
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">#</th>
                    <th>No. Meja</th>
                    <th style="text-align:center;">Status</th>
                    <th>Pelanggan</th>
                    <th>QR Token</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tables as $index => $table)
                @php $activeOrder = $table->orders->first(); @endphp
                <tr>
                    <td style="text-align:center; color:#6b7280;">{{ $tables->firstItem() + $index }}</td>
                    <td style="font-weight:600;font-size:15px;">
                        <i class="fas fa-chair" style="color:#1b4332;margin-right:6px;"></i>
                        Meja {{ $table->number }}
                    </td>
                    <td style="text-align:center;">
                        @if($activeOrder)
                            @if($activeOrder->order_status === 'menunggu')
                                <span class="badge badge-warning">🕐 Menunggu</span>
                            @elseif($activeOrder->order_status === 'diproses')
                                <span class="badge badge-info">⚙️ Diproses</span>
                            @else
                                <span class="badge badge-success">✅ Selesai</span>
                            @endif
                        @else
                            <span class="badge badge-success">🟢 Kosong</span>
                        @endif
                    </td>
                    <td style="font-size:13px;">
                        @if($activeOrder)
                            <a href="{{ route('admin.orders.show', $activeOrder) }}" style="color:#0e6446;font-weight:500;text-decoration:none;">
                                <i class="fas fa-user"></i> {{ $activeOrder->customer_name }}
                            </a>
                        @else
                            <span style="color:#9ca3af">—</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('customer.home', $table) }}" target="_blank" 
                           style="font-size:11px;font-family:monospace;color:#0e6446;text-decoration:none;font-weight:500;display:inline-block;padding:4px 8px;background:#f0fdf4;border-radius:4px;border:1px solid #d1fae5;">
                            {{ Str::limit($table->qr_token, 16) }}
                            <i class="fas fa-external-link-alt" style="font-size:10px;margin-left:4px;"></i>
                        </a>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.tables.qr', $table) }}" class="btn btn-primary btn-sm" style="background:#d4a373;border-color:#d4a373;min-width:50px;">
                                <i class="fas fa-qrcode"></i> QR
                            </a>
                            <button type="button" class="btn btn-sm btn-edit" onclick="openEditTable({{ $table->id }}, {{ $table->number }})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-delete" onclick="confirmDeleteTable({{ $table->id }}, {{ $table->number }}, {{ $activeOrder ? 1 : 0 }})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('search'))
                            Meja "{{ request('search') }}" tidak ditemukan.
                        @else
                            <div class="empty-state">
                                <div class="icon">🪑</div>
                                <h3>Belum Ada Meja</h3>
                                <p>Klik tombol "Tambah Meja" untuk menambahkan meja pertama.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($tables->hasPages())
    <div class="pagination-wrapper">
        {{ $tables->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- ── MODAL CREATE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-table">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-plus-circle" style="color:#0e6446;"></i>
                Tambah Meja
            </div>
            <button class="modal-close" onclick="closeModal('modal-create-table')">×</button>
        </div>
        <form id="form-create-table" action="{{ route('admin.tables.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nomor Meja <span class="required">*</span></label>
                    <input type="number" name="number" id="create-table-number" min="1" placeholder="Contoh: 11" required>
                    <div class="field-error" id="create-table-number-error">Nomor meja wajib diisi (minimal 1)</div>
                    <div class="field-error" id="create-table-number-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nomor meja sudah terdaftar
                    </div>
                    <div class="field-success" id="create-table-number-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nomor meja tersedia
                    </div>
                </div>
                <div class="form-hint" style="font-size:11px;color:#6b7280;margin-top:8px;">
                    <i class="fas fa-info-circle"></i> QR token akan dibuat otomatis.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-create-table')">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-create-table">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-table">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-edit" style="color:#3b82f6;"></i>
                Edit Meja
            </div>
            <button class="modal-close" onclick="closeModal('modal-edit-table')">×</button>
        </div>
        <form id="form-edit-table" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nomor Meja <span class="required">*</span></label>
                    <input type="number" name="number" id="edit-table-number" min="1" required>
                    <div class="field-error" id="edit-table-number-error">Nomor meja wajib diisi (minimal 1)</div>
                    <div class="field-error" id="edit-table-number-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nomor meja sudah terdaftar
                    </div>
                    <div class="field-success" id="edit-table-number-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nomor meja tersedia
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-edit-table')">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-edit-table">
                    <i class="fas fa-save"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL DELETE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-delete-table">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Meja?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus <strong id="delete-table-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;" id="delete-table-warning"></span>
            </div>
            <form id="delete-table-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-table')">
                    Batal
                </button>
                <button type="submit" class="btn btn-delete btn-sm">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── DATA MEJA EXISTING ──
const existingTables = @json($tables->pluck('number')->map(function($num) { 
    return (int) $num; 
})->toArray() ?? []);

const tableData = @json($tables->map(function($t) {
    return ['id' => $t->id, 'number' => (int) $t->number];
})->toArray() ?? []);

// ── MODAL FUNCTIONS ──
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

// ── CREATE ──
function openCreateTable() {
    document.getElementById('form-create-table').reset();
    document.getElementById('create-table-number').classList.remove('is-invalid', 'is-valid');
    document.getElementById('create-table-number-error').classList.remove('show');
    document.getElementById('create-table-number-unique-error').style.display = 'none';
    document.getElementById('create-table-number-valid').style.display = 'none';
    openModal('modal-create-table');
    setTimeout(function() {
        document.getElementById('create-table-number').focus();
    }, 100);
}

// ── EDIT ──
function openEditTable(id, number) {
    document.getElementById('form-edit-table').action = '/admin/tables/' + id;
    document.getElementById('form-edit-table').dataset.editId = id;
    document.getElementById('edit-table-number').value = number;
    document.getElementById('edit-table-number').classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-table-number-error').classList.remove('show');
    document.getElementById('edit-table-number-unique-error').style.display = 'none';
    document.getElementById('edit-table-number-valid').style.display = 'none';
    openModal('modal-edit-table');
    setTimeout(function() {
        document.getElementById('edit-table-number').focus();
    }, 100);
}

// ── DELETE ──
function confirmDeleteTable(id, number, hasOrder) {
    document.getElementById('delete-table-form').action = '/admin/tables/' + id;
    document.getElementById('delete-table-name').textContent = 'Meja ' + number;
    
    const warning = document.getElementById('delete-table-warning');
    if (hasOrder > 0) {
        warning.textContent = '⚠️ Meja ini memiliki pesanan aktif. Semua data akan terhapus!';
        warning.style.display = 'block';
    } else {
        warning.textContent = 'Tindakan ini tidak dapat dibatalkan!';
        warning.style.display = 'block';
    }
    
    openModal('modal-delete-table');
}

// ── CEK DUPLIKAT ──
function checkTableNumber(input, isEdit = false) {
    const number = parseInt(input.value.trim());
    
    // Ambil elemen-elemen yang dibutuhkan berdasarkan ID
    const errorDefault = document.getElementById(input.id + '-error');
    const errorUnique = document.getElementById(input.id + '-unique-error');
    const successMsg = document.getElementById(input.id + '-valid');
    
    // Reset semua status
    input.classList.remove('is-invalid', 'is-valid');
    if (errorDefault) errorDefault.classList.remove('show');
    if (errorUnique) errorUnique.style.display = 'none';
    if (successMsg) successMsg.style.display = 'none';
    
    // Jika kosong atau invalid
    if (isNaN(number) || number < 1) {
        input.classList.add('is-invalid');
        if (errorDefault) errorDefault.classList.add('show');
        return false;
    }
    
    // Cek duplikat
    let isDuplicate = false;
    if (isEdit) {
        const editId = parseInt(document.getElementById('form-edit-table')?.dataset.editId || 0);
        const otherTables = tableData.filter(item => item.id !== editId).map(item => item.number);
        isDuplicate = otherTables.includes(number);
    } else {
        isDuplicate = existingTables.includes(number);
    }
    
    if (isDuplicate) {
        input.classList.add('is-invalid');
        if (errorUnique) errorUnique.style.display = 'block';
        if (successMsg) successMsg.style.display = 'none';
        return false;
    } else {
        input.classList.add('is-valid');
        if (successMsg) successMsg.style.display = 'block';
        if (errorUnique) errorUnique.style.display = 'none';
        return true;
    }
}

// ── INIT ──
document.addEventListener('DOMContentLoaded', function() {
    // CREATE
    const createInput = document.getElementById('create-table-number');
    if (createInput) {
        createInput.addEventListener('input', function() {
            checkTableNumber(this, false);
        });
        createInput.addEventListener('focus', function() {
            this.classList.remove('is-invalid', 'is-valid');
            document.getElementById('create-table-number-error').classList.remove('show');
            document.getElementById('create-table-number-unique-error').style.display = 'none';
            document.getElementById('create-table-number-valid').style.display = 'none';
        });
    }
    
    // EDIT
    const editInput = document.getElementById('edit-table-number');
    if (editInput) {
        editInput.addEventListener('input', function() {
            checkTableNumber(this, true);
        });
        editInput.addEventListener('focus', function() {
            this.classList.remove('is-invalid', 'is-valid');
            document.getElementById('edit-table-number-error').classList.remove('show');
            document.getElementById('edit-table-number-unique-error').style.display = 'none';
            document.getElementById('edit-table-number-valid').style.display = 'none';
        });
    }

    // ── SUBMIT CREATE ──
    document.getElementById('form-create-table')?.addEventListener('submit', function(e) {
        const input = document.getElementById('create-table-number');
        const btn = document.getElementById('btn-create-table');
        let isValid = true;

        // Reset semua
        input.classList.remove('is-invalid', 'is-valid');
        document.getElementById('create-table-number-error').classList.remove('show');
        document.getElementById('create-table-number-unique-error').style.display = 'none';
        document.getElementById('create-table-number-valid').style.display = 'none';

        const number = parseInt(input.value.trim());
        if (isNaN(number) || number < 1) {
            document.getElementById('create-table-number-error').classList.add('show');
            input.classList.add('is-invalid');
            isValid = false;
        } else if (existingTables.includes(number)) {
            document.getElementById('create-table-number-unique-error').style.display = 'block';
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.add('is-valid');
            document.getElementById('create-table-number-valid').style.display = 'block';
        }

        if (!isValid) {
            e.preventDefault();
            input.focus();
            return false;
        }

        btn.textContent = 'Menyimpan...';
        btn.disabled = true;
    });

    // ── SUBMIT EDIT ──
    document.getElementById('form-edit-table')?.addEventListener('submit', function(e) {
        const input = document.getElementById('edit-table-number');
        const btn = document.getElementById('btn-edit-table');
        const editId = parseInt(this.dataset.editId || 0);
        let isValid = true;

        // Reset semua
        input.classList.remove('is-invalid', 'is-valid');
        document.getElementById('edit-table-number-error').classList.remove('show');
        document.getElementById('edit-table-number-unique-error').style.display = 'none';
        document.getElementById('edit-table-number-valid').style.display = 'none';

        const number = parseInt(input.value.trim());
        if (isNaN(number) || number < 1) {
            document.getElementById('edit-table-number-error').classList.add('show');
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            const isDuplicate = tableData.some(item => 
                item.number === number && item.id !== editId
            );
            if (isDuplicate) {
                document.getElementById('edit-table-number-unique-error').style.display = 'block';
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.add('is-valid');
                document.getElementById('edit-table-number-valid').style.display = 'block';
            }
        }

        if (!isValid) {
            e.preventDefault();
            input.focus();
            return false;
        }

        btn.textContent = 'Menyimpan...';
        btn.disabled = true;
    });

    // ── SEARCH FILTER ──
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('table.sortable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }

    // ── TOAST (identik dengan halaman promo, pakai #toast-container dari layout) ──
    function showToast(type, title, message) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        container.innerHTML = '';

        const isSuccess = type === 'success';
        const borderColor = isSuccess ? '#16a34a' : '#dc2626';
        const icon = isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle';

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.style.borderLeftColor = borderColor;
        toast.innerHTML = `
            <i class="fas ${icon}" style="color: ${borderColor}; font-size: 18px;"></i>
            <div>
                <div style="font-weight: 600; font-size: 14px;">${title}</div>
                <div style="font-size: 13px; color: #6b7280;">${message}</div>
            </div>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 4000);
    }

    // ── AUTO CLOSE ERROR SUMMARY (khusus validasi) ──
    const errorSummary = document.getElementById('error-summary');
    if (errorSummary) {
        setTimeout(function() {
            errorSummary.style.transition = 'opacity 0.5s ease';
            errorSummary.style.opacity = '0';
            setTimeout(function() {
                errorSummary.style.display = 'none';
            }, 500);
        }, 5000);
    }

    // ── TOAST DARI SESSION (success/error, sama seperti halaman promo) ──
    @if(session('success'))
        showToast('success', 'Berhasil', @json(session('success')));
    @endif

    @if(session('error'))
        showToast('error', 'Gagal', @json(session('error')));
    @endif

    // ── RE-OPEN MODAL IF VALIDATION FAILED ──
    @if($errors->any())
        @if(old('_method') === 'PUT')
            openModal('modal-edit-table');
        @else
            openModal('modal-create-table');
        @endif
    @endif
});

console.log('✅ Halaman Kelola Meja siap digunakan!');
</script>
@endpush