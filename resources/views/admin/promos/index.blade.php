@extends('layouts.admin')
@section('title', 'Kelola Promo')
@section('page-title', 'Kelola Promo')

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
        background: #1b4332;
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
    .badge-secondary {
        background: #f1f5f9;
        color: #475569;
    }

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

    .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table-wrap table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 900px;
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
    .table-wrap tbody tr:hover {
        background-color: #f8fafc;
    }

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
        max-width: 560px;
    }
    .modal-md {
        max-width: 560px;
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
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color .2s;
        outline: none;
        font-family: 'Outfit', sans-serif;
    }
    .form-group input:focus,
    .form-group select:focus {
        border-color: #1b4332;
        box-shadow: 0 0 0 2px rgba(27, 67, 50, 0.1);
    }
    .form-group input.is-invalid,
    .form-group select.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }
    .form-group input.is-valid,
    .form-group select.is-valid {
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

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

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

    .pagination-wrapper {
        padding: 12px 16px;
        border-top: 1px solid #e5e7eb;
    }

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
            min-width: 600px;
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
        .grid-2 {
            grid-template-columns: 1fr;
        }
        .breadcrumb-admin {
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .table-wrap table {
            font-size: 11px;
            min-width: 450px;
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
    }

    @media (prefers-color-scheme: dark) {
        .card { background: #1f2937; border-color: #374151; }
        .card-header { background: #111827; border-color: #374151; }
        .card-title { color: #f3f4f6; }
        .stat-card { background: #1f2937; border-color: #374151; }
        .stat-label { color: #9ca3af; }
        .stat-value { color: #f3f4f6; }
        .stat-sub { color: #9ca3af; }
        .table-wrap th { background: #111827; color: #e5e7eb; border-color: #374151; }
        .table-wrap td { border-color: #374151; color: #e5e7eb; }
        .table-wrap tbody tr:hover { background-color: #111827; }
        .modal { background: #1f2937; }
        .modal-header { background: #1f2937; border-color: #374151; }
        .modal-title { color: #f3f4f6; }
        .modal-footer { background: #1f2937; border-color: #374151; }
        .form-group label { color: #e5e7eb; }
        .form-group input, .form-group select { background: #111827; border-color: #374151; color: #f3f4f6; }
        .form-group input:focus, .form-group select:focus { border-color: #d4a373; }
        .form-group input.is-invalid, .form-group select.is-invalid { border-color: #dc2626; background: #1f1414; }
        .form-group input.is-valid, .form-group select.is-valid { border-color: #16a34a; background: #064e3b; }
        .error-summary { background: #1f1414; border-color: #dc2626; }
        .error-summary .error-title { color: #fca5a5; }
        .error-summary ul { color: #fca5a5; }
        .search-wrapper input { background: #111827; border-color: #374151; color: #f3f4f6; }
        .search-wrapper input:focus { border-color: #d4a373; }
        .empty-state h3 { color: #f3f4f6; }
        .empty-state p { color: #9ca3af; }
        .nav-back { color: #9ca3af; background: rgba(255,255,255,0.06); }
        .nav-back:hover { background: rgba(255,255,255,0.1); color: #d4a373; }
        .breadcrumb-admin { color: #9ca3af; }
        .breadcrumb-admin a { color: #9ca3af; }
        .breadcrumb-admin a:hover { color: #d4a373; }
        .breadcrumb-admin .current { color: #d4a373; }
        .breadcrumb-admin .separator { color: #4b5563; }
    }
</style>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <i class="fas fa-ticket" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Kelola Promo</span>
</div>

{{-- ── ERROR SUMMARY ── --}}
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

{{-- ── STATS ── --}}
<div class="stats-grid">
    @php
    $totalPromos = $promos->total();
    $activePromos = $promos->filter(function($p) { return $p->is_active && $p->isValid(); })->count();
    $expiredPromos = $promos->filter(function($p) { return !$p->isValid() && $p->is_active; })->count();
    $inactivePromos = $promos->filter(function($p) { return !$p->is_active; })->count();
    @endphp

    <div class="stat-card">
        <div class="stat-label"><i class="fas fa-tags" style="color: #1b4332;"></i> Total Promo</div>
        <div class="stat-value">{{ $totalPromos }}</div>
        <div class="stat-sub">Promo terdaftar</div>
    </div>

    <div class="stat-card">
        <div class="stat-label"><i class="fas fa-check-circle" style="color: #16a34a;"></i> Aktif</div>
        <div class="stat-value" style="color: #16a34a;">{{ $activePromos }}</div>
        <div class="stat-sub">Promo sedang berjalan</div>
    </div>

    <div class="stat-card">
        <div class="stat-label"><i class="fas fa-clock" style="color: #f59e0b;"></i> Kadaluarsa</div>
        <div class="stat-value" style="color: #f59e0b;">{{ $expiredPromos }}</div>
        <div class="stat-sub">Promo sudah habis masa berlaku</div>
    </div>

    <div class="stat-card">
        <div class="stat-label"><i class="fas fa-pause-circle" style="color: #6b7280;"></i> Nonaktif</div>
        <div class="stat-value">{{ $inactivePromos }}</div>
        <div class="stat-sub">Promo dimatikan</div>
    </div>
</div>

{{-- ── CARD ── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-gift" style="color: #1b4332; margin-right:8px;"></i>
            Daftar Promo
        </div>
        
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <form action="{{ url()->current() }}" method="GET" style="display:flex; align-items:center; gap:4px; margin:0;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari promo..." 
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

            <button type="button" class="btn btn-primary btn-sm" onclick="openCreatePromo()">
                <i class="fas fa-plus"></i> Tambah Promo
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">#</th>
                    <th>Kode</th>
                    <th>Deskripsi</th>
                    <th style="text-align:center;">Tipe</th>
                    <th style="text-align:center;">Nilai</th>
                    <th style="text-align:center;">Min Order</th>
                    <th style="text-align:center;">Kategori</th>
                    <th style="text-align:center;">Berlaku</th>
                    <th style="text-align:center;">Status</th>
                    <th class="no-sort" style="text-align:center; min-width:130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $index => $promo)
                <tr>
                    <td style="text-align:center; color:#6b7280;">{{ $promos->firstItem() + $index }}</td>
                    <td style="font-weight:600;font-family:monospace;font-size:13px;">
                        <i class="fas fa-ticket-alt" style="color:#1b4332;margin-right:6px;"></i>
                        {{ $promo->code }}
                    </td>
                    <td>{{ Str::limit($promo->description, 30) }}</td>
                    <td style="text-align:center;">
                        <span class="badge {{ $promo->discount_type === 'percent' ? 'badge-success' : 'badge-warning' }}">
                            {{ $promo->discount_type === 'percent' ? 'Persen' : 'Nominal' }}
                        </span>
                    </td>
                    <td style="text-align:center;font-weight:500;">
                        @if($promo->discount_type === 'percent')
                            {{ $promo->discount_value }}%
                        @else
                            Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @if($promo->min_order > 0)
                            Rp {{ number_format($promo->min_order, 0, ',', '.') }}
                        @else
                            <span style="color:#9ca3af;">-</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        {{ $promo->category ? $promo->category->name : 'Semua' }}
                    </td>
                    <td style="text-align:center;font-size:12px;color:#6b7280;">
                        {{ $promo->valid_from->format('d/m/Y') }}
                        <i class="fas fa-arrow-right" style="margin:0 4px;font-size:10px;"></i>
                        {{ $promo->valid_until->format('d/m/Y') }}
                    </td>
                    <td style="text-align:center;">
                        @if($promo->is_active && $promo->isValid())
                            <span class="badge badge-success">Aktif</span>
                        @elseif(!$promo->is_active)
                            <span class="badge badge-secondary">Nonaktif</span>
                        @else
                            <span class="badge badge-danger">Kadaluarsa</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-sm btn-edit"
                                onclick="openEditPromo(
                                    {{ $promo->id }},
                                    '{{ addslashes($promo->code) }}',
                                    '{{ addslashes($promo->description) }}',
                                    '{{ $promo->discount_type }}',
                                    {{ $promo->discount_value }},
                                    {{ $promo->is_active ? 'true' : 'false' }},
                                    '{{ $promo->valid_from->format('Y-m-d') }}',
                                    '{{ $promo->valid_until->format('Y-m-d') }}',
                                    {{ $promo->min_order ?? 0 }},
                                    {{ $promo->category_id ?? 'null' }}
                                )">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-delete"
                                onclick="confirmDeletePromo({{ $promo->id }}, '{{ addslashes($promo->code) }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('search'))
                            Promo "{{ request('search') }}" tidak ditemukan.
                        @else
                            <div class="empty-state">
                                <div class="icon">🎁</div>
                                <h3>Belum Ada Promo</h3>
                                <p>Klik tombol "Tambah Promo" untuk menambahkan promo pertama.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($promos->hasPages())
    <div class="pagination-wrapper">
        {{ $promos->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- ── MODAL CREATE ── --}}
<div class="modal-backdrop" id="modal-create-promo">
    <div class="modal modal-md">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-plus-circle" style="color:#1b4332;"></i>
                Tambah Promo
            </div>
            <button class="modal-close" onclick="closeModal('modal-create-promo')">×</button>
        </div>
        <form id="form-create-promo" action="{{ route('admin.promos.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Promo <span class="required">*</span></label>
                    <input type="text" name="code" id="create-promo-code" placeholder="Contoh: HEMAT10" required style="text-transform:uppercase;">
                    <div class="field-error" id="create-promo-code-error">Kode promo wajib diisi (minimal 3 karakter)</div>
                    <div class="field-error" id="create-promo-code-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Kode promo sudah terdaftar
                    </div>
                    <div class="field-success" id="create-promo-code-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Kode promo tersedia
                    </div>
                    <div class="form-hint">Minimal 3 karakter, huruf kapital otomatis</div>
                </div>

                <div class="form-group">
                    <label>Deskripsi <span class="required">*</span></label>
                    <input type="text" name="description" id="create-promo-desc" placeholder="Deskripsi singkat promo" required minlength="5">
                    <div class="field-error" id="create-promo-desc-error">Deskripsi wajib diisi (minimal 5 karakter)</div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Tipe Diskon <span class="required">*</span></label>
                        <select name="discount_type" id="create-promo-type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="percent">Persen (%)</option>
                            <option value="fixed">Nominal (Rp)</option>
                        </select>
                        <div class="field-error" id="create-promo-type-error">Tipe diskon wajib dipilih</div>
                    </div>
                    <div class="form-group">
                        <label>Nilai Diskon <span class="required">*</span></label>
                        <input type="number" name="discount_value" id="create-promo-value" min="0" step="0.01" required>
                        <div class="field-error" id="create-promo-value-error">Nilai diskon wajib diisi (minimal 0)</div>
                    </div>
                </div>

                {{-- 🔥 FIELD MIN ORDER & KATEGORI --}}
                <div class="grid-2">
                    <div class="form-group">
                        <label>Minimal Belanja</label>
                        <input type="number" name="min_order" id="create-promo-min-order" 
                               class="form-control" min="0" step="100" 
                               placeholder="0 (tanpa minimal)" value="0">
                        <div class="form-hint">Minimal total belanja agar promo berlaku.</div>
                    </div>
                    <div class="form-group">
                        <label>Berlaku Untuk Kategori</label>
                        <select name="category_id" id="create-promo-category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-hint">Pilih kategori yang mendapatkan promo. Kosongkan untuk semua menu.</div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Berlaku Dari <span class="required">*</span></label>
                        <input type="date" name="valid_from" id="create-promo-from" required>
                        <div class="field-error" id="create-promo-from-error">Tanggal mulai wajib diisi</div>
                    </div>
                    <div class="form-group">
                        <label>Berlaku Sampai <span class="required">*</span></label>
                        <input type="date" name="valid_until" id="create-promo-until" required>
                        <div class="field-error" id="create-promo-until-error">Tanggal selesai wajib diisi</div>
                        <div class="field-error" id="create-promo-until-invalid" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                            <i class="fas fa-exclamation-circle"></i> Tanggal selesai harus setelah tanggal mulai
                        </div>
                    </div>
                </div>

                <div class="form-group" style="display:flex;align-items:center;gap:10px;">
                    <input type="checkbox" name="is_active" value="1" id="create-promo-active" checked style="width:auto;">
                    <label for="create-promo-active" style="margin:0;cursor:pointer;">Aktif</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-promo')">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary" id="btn-create-promo">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ── --}}
<div class="modal-backdrop" id="modal-edit-promo">
    <div class="modal modal-md">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-edit" style="color:#3b82f6;"></i>
                Edit Promo
            </div>
            <button class="modal-close" onclick="closeModal('modal-edit-promo')">×</button>
        </div>
        <form id="form-edit-promo" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Promo <span class="required">*</span></label>
                    <input type="text" name="code" id="edit-promo-code" required style="text-transform:uppercase;">
                    <div class="field-error" id="edit-promo-code-error">Kode promo wajib diisi (minimal 3 karakter)</div>
                    <div class="field-error" id="edit-promo-code-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Kode promo sudah terdaftar
                    </div>
                    <div class="field-success" id="edit-promo-code-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Kode promo tersedia
                    </div>
                    <div class="form-hint">Minimal 3 karakter, huruf kapital otomatis</div>
                </div>

                <div class="form-group">
                    <label>Deskripsi <span class="required">*</span></label>
                    <input type="text" name="description" id="edit-promo-desc" required minlength="5">
                    <div class="field-error" id="edit-promo-desc-error">Deskripsi wajib diisi (minimal 5 karakter)</div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Tipe Diskon <span class="required">*</span></label>
                        <select name="discount_type" id="edit-promo-type" required>
                            <option value="percent">Persen (%)</option>
                            <option value="fixed">Nominal (Rp)</option>
                        </select>
                        <div class="field-error" id="edit-promo-type-error">Tipe diskon wajib dipilih</div>
                    </div>
                    <div class="form-group">
                        <label>Nilai Diskon <span class="required">*</span></label>
                        <input type="number" name="discount_value" id="edit-promo-value" min="0" step="0.01" required>
                        <div class="field-error" id="edit-promo-value-error">Nilai diskon wajib diisi (minimal 0)</div>
                    </div>
                </div>

                {{-- 🔥 FIELD MIN ORDER & KATEGORI --}}
                <div class="grid-2">
                    <div class="form-group">
                        <label>Minimal Belanja</label>
                        <input type="number" name="min_order" id="edit-promo-min-order" 
                               class="form-control" min="0" step="100" 
                               placeholder="0 (tanpa minimal)" value="0">
                        <div class="form-hint">Minimal total belanja agar promo berlaku.</div>
                    </div>
                    <div class="form-group">
                        <label>Berlaku Untuk Kategori</label>
                        <select name="category_id" id="edit-promo-category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ isset($promo) && $promo->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-hint">Pilih kategori yang mendapatkan promo. Kosongkan untuk semua menu.</div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Berlaku Dari <span class="required">*</span></label>
                        <input type="date" name="valid_from" id="edit-promo-from" required>
                        <div class="field-error" id="edit-promo-from-error">Tanggal mulai wajib diisi</div>
                    </div>
                    <div class="form-group">
                        <label>Berlaku Sampai <span class="required">*</span></label>
                        <input type="date" name="valid_until" id="edit-promo-until" required>
                        <div class="field-error" id="edit-promo-until-error">Tanggal selesai wajib diisi</div>
                        <div class="field-error" id="edit-promo-until-invalid" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                            <i class="fas fa-exclamation-circle"></i> Tanggal selesai harus setelah tanggal mulai
                        </div>
                    </div>
                </div>

                <div class="form-group" style="display:flex;align-items:center;gap:10px;">
                    <input type="checkbox" name="is_active" value="1" id="edit-promo-active" style="width:auto;">
                    <label for="edit-promo-active" style="margin:0;cursor:pointer;">Aktif</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-promo')">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary" id="btn-edit-promo">
                    <i class="fas fa-save"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL DELETE ── --}}
<div class="modal-backdrop" id="modal-delete-promo">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Promo?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus promo <strong id="delete-promo-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;">Tindakan ini tidak dapat dibatalkan!</span>
            </div>
            <form id="delete-promo-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-promo')">
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
// ── DATA PROMO EXISTING ──
const existingPromos = @json($promos->pluck('code')->map(function($code) { 
    return strtoupper($code); 
})->toArray() ?? []);

const promoData = @json($promos->map(function($p) {
    return ['id' => $p->id, 'code' => strtoupper($p->code)];
})->toArray() ?? []);

const categoriesData = @json($categories->map(function($c) {
    return ['id' => $c->id, 'name' => $c->name];
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
function openCreatePromo() {
    document.getElementById('form-create-promo').reset();
    document.getElementById('create-promo-code').classList.remove('is-invalid', 'is-valid');
    document.getElementById('create-promo-code-error').classList.remove('show');
    document.getElementById('create-promo-code-unique-error').style.display = 'none';
    document.getElementById('create-promo-code-valid').style.display = 'none';
    document.getElementById('create-promo-desc').classList.remove('is-invalid', 'is-valid');
    document.getElementById('create-promo-desc-error').classList.remove('show');
    document.getElementById('create-promo-type').classList.remove('is-invalid');
    document.getElementById('create-promo-type-error').classList.remove('show');
    document.getElementById('create-promo-value').classList.remove('is-invalid');
    document.getElementById('create-promo-value-error').classList.remove('show');
    document.getElementById('create-promo-min-order').value = 0;
    document.getElementById('create-promo-category').value = '';
    document.getElementById('create-promo-from').classList.remove('is-invalid');
    document.getElementById('create-promo-from-error').classList.remove('show');
    document.getElementById('create-promo-until').classList.remove('is-invalid');
    document.getElementById('create-promo-until-error').classList.remove('show');
    document.getElementById('create-promo-until-invalid').style.display = 'none';
    document.getElementById('create-promo-active').checked = true;
    openModal('modal-create-promo');
    setTimeout(function() {
        document.getElementById('create-promo-code').focus();
    }, 100);
}

// ── EDIT ──
function openEditPromo(id, code, desc, type, value, isActive, validFrom, validUntil, minOrder, categoryId) {
    document.getElementById('form-edit-promo').action = '/admin/promos/' + id;
    document.getElementById('form-edit-promo').dataset.editId = id;
    document.getElementById('edit-promo-code').value = code;
    document.getElementById('edit-promo-desc').value = desc;
    document.getElementById('edit-promo-type').value = type;
    document.getElementById('edit-promo-value').value = value;
    document.getElementById('edit-promo-min-order').value = minOrder || 0;
    document.getElementById('edit-promo-category').value = categoryId || '';
    document.getElementById('edit-promo-from').value = validFrom;
    document.getElementById('edit-promo-until').value = validUntil;
    document.getElementById('edit-promo-active').checked = isActive;
    
    document.getElementById('edit-promo-code').classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-promo-code-error').classList.remove('show');
    document.getElementById('edit-promo-code-unique-error').style.display = 'none';
    document.getElementById('edit-promo-code-valid').style.display = 'none';
    document.getElementById('edit-promo-desc').classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-promo-desc-error').classList.remove('show');
    document.getElementById('edit-promo-type').classList.remove('is-invalid');
    document.getElementById('edit-promo-type-error').classList.remove('show');
    document.getElementById('edit-promo-value').classList.remove('is-invalid');
    document.getElementById('edit-promo-value-error').classList.remove('show');
    document.getElementById('edit-promo-from').classList.remove('is-invalid');
    document.getElementById('edit-promo-from-error').classList.remove('show');
    document.getElementById('edit-promo-until').classList.remove('is-invalid');
    document.getElementById('edit-promo-until-error').classList.remove('show');
    document.getElementById('edit-promo-until-invalid').style.display = 'none';
    
    openModal('modal-edit-promo');
    setTimeout(function() {
        document.getElementById('edit-promo-code').focus();
    }, 100);
}

// ── DELETE ──
function confirmDeletePromo(id, code) {
    document.getElementById('delete-promo-form').action = '/admin/promos/' + id;
    document.getElementById('delete-promo-name').textContent = code;
    openModal('modal-delete-promo');
}

// ── CEK DUPLIKAT ──
function checkPromoCode(input, isEdit = false) {
    const code = input.value.trim().toUpperCase();
    const uniqueError = input.parentElement.querySelector('.field-error:last-child');
    const validMsg = input.parentElement.querySelector('.field-success');
    const defaultError = input.parentElement.querySelector('.field-error:first-child');
    
    input.classList.remove('is-invalid', 'is-valid');
    if (uniqueError) uniqueError.style.display = 'none';
    if (validMsg) validMsg.style.display = 'none';
    if (defaultError) defaultError.classList.remove('show');
    
    if (!code || code.length < 3) {
        if (defaultError) {
            defaultError.textContent = 'Kode promo wajib diisi (minimal 3 karakter)';
            defaultError.classList.add('show');
        }
        input.classList.add('is-invalid');
        return false;
    }
    
    let isDuplicate = false;
    if (isEdit) {
        const editId = parseInt(document.getElementById('form-edit-promo')?.dataset.editId || 0);
        const otherPromos = promoData.filter(item => item.id !== editId).map(item => item.code);
        isDuplicate = otherPromos.includes(code);
    } else {
        isDuplicate = existingPromos.includes(code);
    }
    
    if (isDuplicate) {
        input.classList.add('is-invalid');
        if (uniqueError) uniqueError.style.display = 'block';
        return false;
    }
    
    input.classList.add('is-valid');
    if (validMsg) validMsg.style.display = 'block';
    return true;
}

// ── CEK TANGGAL ──
function checkDates(fromId, untilId, errorId) {
    const fromInput = document.getElementById(fromId);
    const untilInput = document.getElementById(untilId);
    const errorEl = document.getElementById(errorId);
    
    if (fromInput.value && untilInput.value) {
        const from = new Date(fromInput.value);
        const until = new Date(untilInput.value);
        
        if (until <= from) {
            errorEl.style.display = 'block';
            untilInput.classList.add('is-invalid');
            return false;
        } else {
            errorEl.style.display = 'none';
            untilInput.classList.remove('is-invalid');
            return true;
        }
    }
    return true;
}

// ── TOAST ──
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

// ── INIT ──
document.addEventListener('DOMContentLoaded', function() {
    // ── Validasi duplikat create ──
    const createCode = document.getElementById('create-promo-code');
    if (createCode) {
        createCode.addEventListener('input', function() { 
            this.value = this.value.toUpperCase();
            checkPromoCode(this, false); 
        });
        createCode.addEventListener('blur', function() { 
            this.value = this.value.toUpperCase();
            checkPromoCode(this, false); 
        });
    }

    // ── Validasi duplikat edit ──
    const editCode = document.getElementById('edit-promo-code');
    if (editCode) {
        editCode.addEventListener('input', function() { 
            this.value = this.value.toUpperCase();
            checkPromoCode(this, true); 
        });
        editCode.addEventListener('blur', function() { 
            this.value = this.value.toUpperCase();
            checkPromoCode(this, true); 
        });
    }

    // ── Validasi tanggal create ──
    const createFrom = document.getElementById('create-promo-from');
    const createUntil = document.getElementById('create-promo-until');
    if (createFrom && createUntil) {
        createFrom.addEventListener('change', function() {
            checkDates('create-promo-from', 'create-promo-until', 'create-promo-until-invalid');
        });
        createUntil.addEventListener('change', function() {
            checkDates('create-promo-from', 'create-promo-until', 'create-promo-until-invalid');
        });
    }

    // ── Validasi tanggal edit ──
    const editFrom = document.getElementById('edit-promo-from');
    const editUntil = document.getElementById('edit-promo-until');
    if (editFrom && editUntil) {
        editFrom.addEventListener('change', function() {
            checkDates('edit-promo-from', 'edit-promo-until', 'edit-promo-until-invalid');
        });
        editUntil.addEventListener('change', function() {
            checkDates('edit-promo-from', 'edit-promo-until', 'edit-promo-until-invalid');
        });
    }

    // ── SUBMIT CREATE ──
    document.getElementById('form-create-promo')?.addEventListener('submit', function(e) {
        const codeInput = document.getElementById('create-promo-code');
        const descInput = document.getElementById('create-promo-desc');
        const typeInput = document.getElementById('create-promo-type');
        const valueInput = document.getElementById('create-promo-value');
        const minOrderInput = document.getElementById('create-promo-min-order');
        const fromInput = document.getElementById('create-promo-from');
        const untilInput = document.getElementById('create-promo-until');
        const btn = document.getElementById('btn-create-promo');
        let isValid = true;

        // ── Reset errors ──
        codeInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('create-promo-code-error').classList.remove('show');
        document.getElementById('create-promo-code-unique-error').style.display = 'none';
        document.getElementById('create-promo-code-valid').style.display = 'none';
        
        descInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('create-promo-desc-error').classList.remove('show');
        
        typeInput.classList.remove('is-invalid');
        document.getElementById('create-promo-type-error').classList.remove('show');
        
        valueInput.classList.remove('is-invalid');
        document.getElementById('create-promo-value-error').classList.remove('show');
        
        minOrderInput.classList.remove('is-invalid');
        
        fromInput.classList.remove('is-invalid');
        document.getElementById('create-promo-from-error').classList.remove('show');
        
        untilInput.classList.remove('is-invalid');
        document.getElementById('create-promo-until-error').classList.remove('show');
        document.getElementById('create-promo-until-invalid').style.display = 'none';

        // ── Validate code ──
        const code = codeInput.value.trim().toUpperCase();
        if (!code || code.length < 3) {
            document.getElementById('create-promo-code-error').textContent = 'Kode promo wajib diisi (minimal 3 karakter)';
            document.getElementById('create-promo-code-error').classList.add('show');
            codeInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const isDuplicate = existingPromos.includes(code);
            if (isDuplicate) {
                document.getElementById('create-promo-code-unique-error').style.display = 'block';
                codeInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        // ── Validate description ──
        if (!descInput.value.trim() || descInput.value.trim().length < 5) {
            document.getElementById('create-promo-desc-error').textContent = 'Deskripsi wajib diisi (minimal 5 karakter)';
            document.getElementById('create-promo-desc-error').classList.add('show');
            descInput.classList.add('is-invalid');
            isValid = false;
        }

        // ── Validate type ──
        if (!typeInput.value) {
            document.getElementById('create-promo-type-error').classList.add('show');
            typeInput.classList.add('is-invalid');
            isValid = false;
        }

        // ── Validate value ──
        const value = parseFloat(valueInput.value);
        if (isNaN(value) || value < 0) {
            document.getElementById('create-promo-value-error').textContent = 'Nilai diskon wajib diisi (minimal 0)';
            document.getElementById('create-promo-value-error').classList.add('show');
            valueInput.classList.add('is-invalid');
            isValid = false;
        }

        // ── Validate min order ──
        const minOrder = parseFloat(minOrderInput.value);
        if (isNaN(minOrder) || minOrder < 0) {
            minOrderInput.classList.add('is-invalid');
            isValid = false;
        }

        // ── Validate dates ──
        if (!fromInput.value) {
            document.getElementById('create-promo-from-error').classList.add('show');
            fromInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!untilInput.value) {
            document.getElementById('create-promo-until-error').classList.add('show');
            untilInput.classList.add('is-invalid');
            isValid = false;
        } else if (fromInput.value && untilInput.value) {
            const from = new Date(fromInput.value);
            const until = new Date(untilInput.value);
            if (until <= from) {
                document.getElementById('create-promo-until-invalid').style.display = 'block';
                untilInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#modal-create-promo .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // ── SUBMIT EDIT ──
    document.getElementById('form-edit-promo')?.addEventListener('submit', function(e) {
        const codeInput = document.getElementById('edit-promo-code');
        const descInput = document.getElementById('edit-promo-desc');
        const typeInput = document.getElementById('edit-promo-type');
        const valueInput = document.getElementById('edit-promo-value');
        const minOrderInput = document.getElementById('edit-promo-min-order');
        const fromInput = document.getElementById('edit-promo-from');
        const untilInput = document.getElementById('edit-promo-until');
        const btn = document.getElementById('btn-edit-promo');
        const editId = parseInt(this.dataset.editId || 0);
        let isValid = true;

        // ── Reset errors ──
        codeInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('edit-promo-code-error').classList.remove('show');
        document.getElementById('edit-promo-code-unique-error').style.display = 'none';
        document.getElementById('edit-promo-code-valid').style.display = 'none';
        
        descInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('edit-promo-desc-error').classList.remove('show');
        
        typeInput.classList.remove('is-invalid');
        document.getElementById('edit-promo-type-error').classList.remove('show');
        
        valueInput.classList.remove('is-invalid');
        document.getElementById('edit-promo-value-error').classList.remove('show');
        
        minOrderInput.classList.remove('is-invalid');
        
        fromInput.classList.remove('is-invalid');
        document.getElementById('edit-promo-from-error').classList.remove('show');
        
        untilInput.classList.remove('is-invalid');
        document.getElementById('edit-promo-until-error').classList.remove('show');
        document.getElementById('edit-promo-until-invalid').style.display = 'none';

        // ── Validate code ──
        const code = codeInput.value.trim().toUpperCase();
        if (!code || code.length < 3) {
            document.getElementById('edit-promo-code-error').textContent = 'Kode promo wajib diisi (minimal 3 karakter)';
            document.getElementById('edit-promo-code-error').classList.add('show');
            codeInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const isDuplicate = promoData.some(item => item.code === code && item.id !== editId);
            if (isDuplicate) {
                document.getElementById('edit-promo-code-unique-error').style.display = 'block';
                codeInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        // ── Validate description ──
        if (!descInput.value.trim() || descInput.value.trim().length < 5) {
            document.getElementById('edit-promo-desc-error').textContent = 'Deskripsi wajib diisi (minimal 5 karakter)';
            document.getElementById('edit-promo-desc-error').classList.add('show');
            descInput.classList.add('is-invalid');
            isValid = false;
        }

        // ── Validate type ──
        if (!typeInput.value) {
            document.getElementById('edit-promo-type-error').classList.add('show');
            typeInput.classList.add('is-invalid');
            isValid = false;
        }

        // ── Validate value ──
        const value = parseFloat(valueInput.value);
        if (isNaN(value) || value < 0) {
            document.getElementById('edit-promo-value-error').textContent = 'Nilai diskon wajib diisi (minimal 0)';
            document.getElementById('edit-promo-value-error').classList.add('show');
            valueInput.classList.add('is-invalid');
            isValid = false;
        }

        // ── Validate min order ──
        const minOrder = parseFloat(minOrderInput.value);
        if (isNaN(minOrder) || minOrder < 0) {
            minOrderInput.classList.add('is-invalid');
            isValid = false;
        }

        // ── Validate dates ──
        if (!fromInput.value) {
            document.getElementById('edit-promo-from-error').classList.add('show');
            fromInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!untilInput.value) {
            document.getElementById('edit-promo-until-error').classList.add('show');
            untilInput.classList.add('is-invalid');
            isValid = false;
        } else if (fromInput.value && untilInput.value) {
            const from = new Date(fromInput.value);
            const until = new Date(untilInput.value);
            if (until <= from) {
                document.getElementById('edit-promo-until-invalid').style.display = 'block';
                untilInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#modal-edit-promo .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // ── AUTO CLOSE ERROR SUMMARY ──
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

    // ── TOAST DARI SESSION ──
    @if(session('success'))
        showToast('success', 'Berhasil', @json(session('success')));
    @endif

    @if(session('error'))
        showToast('error', 'Gagal', @json(session('error')));
    @endif

    // ── RE-OPEN MODAL IF VALIDATION FAILED ──
    @if($errors->any())
        @if(old('_method') === 'PUT')
            openModal('modal-edit-promo');
        @else
            openModal('modal-create-promo');
        @endif
    @endif
});

console.log('✅ Halaman Kelola Promo siap digunakan!');
</script>
@endpush