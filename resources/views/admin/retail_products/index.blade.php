@extends('layouts.admin')
@section('title', 'Retail Products')
@section('page-title', 'Kelola Produk Ritel')

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

    /* ── SAME STYLES AS BEFORE ── */
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
        border-radius: 30px;
    }
    .btn-edit:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
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
        border-radius: 30px;
    }
    .btn-delete:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
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
        padding: 4px 14px;
        font-size: 11px;
        height: 30px;
        border-radius: 30px;
    }
    .btn-primary:hover {
        background: #2d6a4f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.35);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #4b5563;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 4px 14px;
        font-size: 11px;
        height: 30px;
        border-radius: 30px;
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .btn-sm {
        padding: 4px 14px;
        font-size: 11px;
        height: 30px;
        border-radius: 30px;
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

    .badge-secondary {
        background: #f1f5f9;
        color: #475569;
    }

    .badge-warning {
        background: #fef9c3;
        color: #854d0e;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    .action-buttons .btn {
        flex: 1;
        min-width: 60px;
        font-size: 10px;
        padding: 4px 10px;
        height: 26px;
        border-radius: 30px;
        justify-content: center;
    }

    .action-buttons .btn i {
        font-size: 11px;
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
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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
        min-width: 500px;
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

    .pagination-wrapper nav {
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper ul {
        display: flex;
        gap: 4px;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .pagination-wrapper li a,
    .pagination-wrapper li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 6px;
        font-size: 13px;
        text-decoration: none;
        color: #4b5563;
        border: 1px solid #e5e7eb;
        background: white;
        transition: all 0.2s;
    }

    .pagination-wrapper li a:hover {
        background: #f3f4f6;
        border-color: #d4a373;
    }

    .pagination-wrapper li.active span {
        background: #1b4332;
        color: white;
        border-color: #1b4332;
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
        max-width: 560px;
    }

    .modal-md {
        max-width: 560px;
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
        border-radius: 30px;
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
    .form-group textarea {
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
    .form-group textarea:focus {
        border-color: #1b4332;
        box-shadow: 0 0 0 2px rgba(27, 67, 50, 0.1);
    }

    .form-group input.is-invalid,
    .form-group textarea.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }

    .form-group input.is-valid,
    .form-group textarea.is-valid {
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

    .grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
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
        .action-buttons {
            flex-wrap: wrap;
        }
        .action-buttons .btn {
            flex: 1 1 calc(50% - 4px);
            min-width: 60px;
            font-size: 10px;
            padding: 3px 8px;
            height: 24px;
            border-radius: 30px;
        }
        .action-buttons .btn i {
            font-size: 10px;
        }
        .table-wrap table {
            font-size: 12px;
            min-width: 400px;
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
            border-radius: 30px;
        }
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
        .grid-3 {
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
            min-width: 320px;
        }
        th, td {
            padding: 6px 8px;
        }
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        .action-buttons .btn {
            width: 100%;
            flex: none;
            font-size: 9px;
            padding: 3px 8px;
            height: 24px;
            min-width: 50px;
            border-radius: 30px;
        }
        .action-buttons .btn i {
            font-size: 10px;
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
            border-radius: 30px;
        }
        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .stat-value {
            font-size: 20px;
        }
        .grid-3 {
            grid-template-columns: 1fr;
        }
        .breadcrumb-admin {
            font-size: 11px;
        }
        .nav-back {
            font-size: 12px;
            padding: 5px 12px;
        }
    }

    @media (prefers-color-scheme: dark) {
        .card {
            background: #1f2937;
            border-color: #374151;
        }
        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
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
        .form-group input,
        .form-group textarea {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #d4a373;
        }
        .form-group input.is-invalid,
        .form-group textarea.is-invalid {
            border-color: #dc2626;
            background: #1f1414;
        }
        .form-group input.is-valid,
        .form-group textarea.is-valid {
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
        .pagination-wrapper li a,
        .pagination-wrapper li span {
            background: #1f2937;
            border-color: #374151;
            color: #e5e7eb;
        }
        .pagination-wrapper li a:hover {
            background: #111827;
        }
        .pagination-wrapper li.active span {
            background: #1b4332;
            border-color: #1b4332;
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
    <i class="fas fa-box" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Kelola Produk Ritel</span>
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

{{-- ── STATS ─────────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    @php
    $totalStock = $products->sum('stock');
    $lowStock = $products->where('stock', '<=', 5)->count();
    $totalValue = $products->sum(function($p) { return $p->price * $p->stock; });
    $mostStock = $products->sortByDesc('stock')->first();
    @endphp

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-box" style="color: #1b4332;"></i>
            Total Produk
        </div>
        <div class="stat-value">{{ $products->total() }}</div>
        <div class="stat-sub">Produk terdaftar</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-cubes" style="color: #d4a373;"></i>
            Total Stok
        </div>
        <div class="stat-value">{{ number_format($totalStock, 0, ',', '.') }}</div>
        <div class="stat-sub">Seluruh produk</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-arrow-up" style="color: #16a34a;"></i>
            Stok Terbanyak
        </div>
        <div class="stat-value">{{ $mostStock ? $mostStock->name : '-' }}</div>
        <div class="stat-sub">{{ $mostStock ? $mostStock->stock . ' pcs' : '' }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-arrow-down" style="color: #dc2626;"></i>
            Stok Tersedikit
        </div>
        <div class="stat-value" style="color: {{ $lowStock > 0 ? '#dc2626' : '#16a34a' }};">
            {{ $lowStock }}
        </div>
        <div class="stat-sub">Produk dengan stok di bawah 5 pcs</div>
    </div>
</div>

{{-- ── CARD ─────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="card-title" style="margin:0;">
            <i class="fas fa-mug-hot" style="color:#1b4332; margin-right:8px;"></i>
            Daftar Produk Ritel
        </div>
        
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <form action="{{ url()->current() }}" method="GET" style="display:flex; align-items:center; gap:4px; margin:0;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari produk..." 
                       style="padding:5px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:12px; width:160px; outline:none; height:32px;">
                <button type="submit" class="btn btn-secondary btn-sm" style="height:32px; border-radius:30px;">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm" style="height:32px; border-radius:30px;">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>

            <button type="button" class="btn btn-primary btn-sm" onclick="openCreateRetail()" style="border-radius:30px;">
                <i class="fas fa-plus"></i> Tambah Produk
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width:70px; text-align:center;">Foto</th>
                    <th>Nama Produk</th>
                    <th style="text-align:center;">Berat</th>
                    <th style="text-align:right;">Harga</th>
                    <th style="text-align:center;">Stok</th>
                    <th style="text-align:center;">Status</th>
                    <th class="no-sort" style="text-align:center; min-width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td style="text-align:center;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                 style="width:44px; height:44px; object-fit:cover; border-radius:6px; border:1px solid #e5e7eb;">
                        @else
                            <span style="font-size:11px; color:#9ca3af;">No Image</span>
                        @endif
                    </td>
                    <td style="font-weight:500;">
                        <i class="fas fa-coffee" style="color:#1b4332;margin-right:6px;font-size:13px;"></i>
                        {{ $product->name }}
                    </td>
                    <td style="text-align:center; color:#6b7280; font-size:12px;">
                        {{ $product->weight ?? 0 }} gr
                    </td>
                    <td style="text-align:right; font-weight:500;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td style="text-align:center;">
                        <span class="badge {{ $product->stock <= 3 ? 'badge-danger' : 'badge-success' }}">
                            {{ $product->stock }} Pcs
                        </span>
                    </td>
                    <td style="text-align:center;">
                        @if($product->is_available && $product->stock > 0)
                            <span class="badge badge-success">Tersedia</span>
                        @else
                            <span class="badge badge-secondary">Habis</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:4px; justify-content:center; flex-wrap:wrap;">
                            <button type="button" class="btn btn-sm btn-edit" onclick="openEditRetail({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }}, '{{ addslashes($product->description) }}', '{{ $product->image ? asset('storage/' . $product->image) : '' }}', {{ $product->weight ?? 0 }})" style="border-radius:30px;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-delete" onclick="confirmDeleteRetail({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->stock }})" style="border-radius:30px;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('search'))
                            Produk "{{ request('search') }}" tidak ditemukan.
                        @else
                            <div class="empty-state">
                                <div class="icon">☕</div>
                                <h3>Belum Ada Produk Ritel</h3>
                                <p>Klik tombol "Tambah Produk" untuk menambahkan kopi instan atau produk bungkusan.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
    <div class="pagination-wrapper">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- ── MODAL CREATE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-retail">
    <div class="modal modal-md">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-plus-circle" style="color:#1b4332;margin-right:8px;"></i>
                Tambah Produk Ritel
            </div>
            <button class="modal-close" onclick="closeModal('modal-create-retail')">×</button>
        </div>
        <form id="form-create-retail" action="{{ route('admin.retail-products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Produk <span class="required">*</span></label>
                    <input type="text" name="name" id="create-retail-name" placeholder="Contoh: Kopi Instan Premium" required minlength="3">
                    <div class="field-error" id="create-retail-name-error">Nama produk wajib diisi (minimal 3 karakter)</div>
                    <div class="field-error" id="create-retail-name-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nama produk sudah terdaftar
                    </div>
                    <div class="field-success" id="create-retail-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama produk tersedia
                    </div>
                </div>
                
                <div class="grid-3">
                    <div class="form-group">
                        <label>Berat (Gram) <span class="required">*</span></label>
                        <input type="number" name="weight" id="create-retail-weight" min="0" required>
                        <div class="field-error" id="create-retail-weight-error">Berat wajib diisi (minimal 0)</div>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp) <span class="required">*</span></label>
                        <input type="number" name="price" id="create-retail-price" min="0" step="500" required>
                        <div class="field-error" id="create-retail-price-error">Harga wajib diisi (minimal 0)</div>
                    </div>
                    <div class="form-group">
                        <label>Stok <span class="required">*</span></label>
                        <input type="number" name="stock" id="create-retail-stock" min="0" required>
                        <div class="field-error" id="create-retail-stock-error">Stok wajib diisi (minimal 0)</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi <span class="required">*</span></label>
                    <textarea name="description" id="create-retail-desc" rows="3" placeholder="Jelaskan detail produk..." required minlength="10"></textarea>
                    <div class="field-error" id="create-retail-desc-error">Deskripsi wajib diisi (minimal 10 karakter)</div>
                </div>

                <div class="form-group">
                    <label>Foto Produk <span class="required">*</span></label>
                    <input type="file" name="image" id="create-retail-image" accept=".jpg,.jpeg,.png" required>
                    <div class="field-error" id="create-retail-image-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Foto wajib diupload (JPG/PNG, maksimal 2MB)
                    </div>
                    <div class="form-hint">Format: JPG, JPEG, PNG • Maksimal 2MB</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-create-retail')" style="border-radius:30px;">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-create-retail" style="border-radius:30px;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-retail">
    <div class="modal modal-md">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-edit" style="color:#3b82f6;margin-right:8px;"></i>
                Edit Produk Ritel
            </div>
            <button class="modal-close" onclick="closeModal('modal-edit-retail')">×</button>
        </div>
        <form id="form-edit-retail" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Produk <span class="required">*</span></label>
                    <input type="text" name="name" id="edit-retail-name" required minlength="3">
                    <div class="field-error" id="edit-retail-name-error">Nama produk wajib diisi (minimal 3 karakter)</div>
                    <div class="field-error" id="edit-retail-name-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nama produk sudah terdaftar
                    </div>
                    <div class="field-success" id="edit-retail-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama produk tersedia
                    </div>
                </div>
                
                <div class="grid-3">
                    <div class="form-group">
                        <label>Berat (Gram) <span class="required">*</span></label>
                        <input type="number" name="weight" id="edit-retail-weight" min="0" required>
                        <div class="field-error" id="edit-retail-weight-error">Berat wajib diisi (minimal 0)</div>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp) <span class="required">*</span></label>
                        <input type="number" name="price" id="edit-retail-price" min="0" step="500" required>
                        <div class="field-error" id="edit-retail-price-error">Harga wajib diisi (minimal 0)</div>
                    </div>
                    <div class="form-group">
                        <label>Stok <span class="required">*</span></label>
                        <input type="number" name="stock" id="edit-retail-stock" min="0" required>
                        <div class="field-error" id="edit-retail-stock-error">Stok wajib diisi (minimal 0)</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi <span class="required">*</span></label>
                    <textarea name="description" id="edit-retail-desc" rows="3" placeholder="Detail produk..." required minlength="10"></textarea>
                    <div class="field-error" id="edit-retail-desc-error">Deskripsi wajib diisi (minimal 10 karakter)</div>
                </div>

                <div class="form-group">
                    <label>Foto Saat Ini</label>
                    <div id="edit-retail-image-preview" style="margin-bottom:8px;"></div>
                    <label>Ganti Foto</label>
                    <input type="file" name="image" id="edit-retail-image" accept=".jpg,.jpeg,.png">
                    <div class="field-error" id="edit-retail-image-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Format JPG/PNG, maksimal 2MB
                    </div>
                    <div class="form-hint">Format: JPG, JPEG, PNG • Maksimal 2MB • Kosongkan jika tidak ingin mengubah</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-edit-retail')" style="border-radius:30px;">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-edit-retail" style="border-radius:30px;">
                    <i class="fas fa-save"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL DELETE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-delete-retail">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Produk?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus produk <strong id="delete-retail-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;" id="delete-retail-warning"></span>
            </div>
            <form id="delete-retail-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-retail')" style="border-radius:30px;">Batal</button>
                <button type="submit" class="btn btn-delete btn-sm" style="border-radius:30px;">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── DATA PRODUK EXISTING ──
const existingProducts = @json($products->pluck('name')->map(function($name) { 
    return strtolower($name); 
})->toArray() ?? []);

const productData = @json($products->map(function($p) {
    return ['id' => $p->id, 'name' => strtolower($p->name)];
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

// ── CREATE ──
function openCreateRetail() {
    document.getElementById('form-create-retail').reset();
    document.getElementById('create-retail-name').classList.remove('is-invalid', 'is-valid');
    document.getElementById('create-retail-name-error').classList.remove('show');
    document.getElementById('create-retail-name-unique-error').style.display = 'none';
    document.getElementById('create-retail-name-valid').style.display = 'none';
    document.getElementById('create-retail-weight').classList.remove('is-invalid');
    document.getElementById('create-retail-weight-error').classList.remove('show');
    document.getElementById('create-retail-price').classList.remove('is-invalid');
    document.getElementById('create-retail-price-error').classList.remove('show');
    document.getElementById('create-retail-stock').classList.remove('is-invalid');
    document.getElementById('create-retail-stock-error').classList.remove('show');
    document.getElementById('create-retail-desc').classList.remove('is-invalid');
    document.getElementById('create-retail-desc-error').classList.remove('show');
    document.getElementById('create-retail-image-error').style.display = 'none';
    openModal('modal-create-retail');
    setTimeout(function() {
        document.getElementById('create-retail-name').focus();
    }, 100);
}

// ── EDIT ──
function openEditRetail(id, name, price, stock, description, imageUrl, weight) {
    document.getElementById('form-edit-retail').action = '/admin/retail-products/' + id;
    document.getElementById('form-edit-retail').dataset.editId = id;
    document.getElementById('edit-retail-name').value = name;
    document.getElementById('edit-retail-price').value = price;
    document.getElementById('edit-retail-stock').value = stock;
    document.getElementById('edit-retail-weight').value = weight || 0;
    document.getElementById('edit-retail-desc').value = description || '';
    
    document.getElementById('edit-retail-name').classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-retail-name-error').classList.remove('show');
    document.getElementById('edit-retail-name-unique-error').style.display = 'none';
    document.getElementById('edit-retail-name-valid').style.display = 'none';
    document.getElementById('edit-retail-weight').classList.remove('is-invalid');
    document.getElementById('edit-retail-weight-error').classList.remove('show');
    document.getElementById('edit-retail-price').classList.remove('is-invalid');
    document.getElementById('edit-retail-price-error').classList.remove('show');
    document.getElementById('edit-retail-stock').classList.remove('is-invalid');
    document.getElementById('edit-retail-stock-error').classList.remove('show');
    document.getElementById('edit-retail-desc').classList.remove('is-invalid');
    document.getElementById('edit-retail-desc-error').classList.remove('show');
    document.getElementById('edit-retail-image-error').style.display = 'none';
    
    const previewContainer = document.getElementById('edit-retail-image-preview');
    if (imageUrl) {
        previewContainer.innerHTML = `<img src="${imageUrl}" style="max-height:80px; border-radius:6px; border:1px solid #e5e7eb;">`;
    } else {
        previewContainer.innerHTML = `<span style="font-size:12px;color:#9ca3af;">Belum ada foto</span>`;
    }
    
    openModal('modal-edit-retail');
    setTimeout(function() {
        document.getElementById('edit-retail-name').focus();
    }, 100);
}

// ── DELETE ──
function confirmDeleteRetail(id, name, stock) {
    document.getElementById('delete-retail-form').action = '/admin/retail-products/' + id;
    document.getElementById('delete-retail-name').textContent = name;
    
    const warning = document.getElementById('delete-retail-warning');
    if (stock > 0) {
        warning.textContent = '⚠️ Produk ini memiliki stok ' + stock + ' pcs. Semua data akan terhapus!';
        warning.style.display = 'block';
    } else {
        warning.textContent = 'Tindakan ini tidak dapat dibatalkan!';
        warning.style.display = 'block';
    }
    
    openModal('modal-delete-retail');
}

// ── CEK DUPLIKAT ──
function checkProductName(input, isEdit = false) {
    const name = input.value.trim().toLowerCase();
    const uniqueError = input.parentElement.querySelector('.field-error:last-child');
    const validMsg = input.parentElement.querySelector('.field-success');
    const defaultError = input.parentElement.querySelector('.field-error:first-child');
    
    input.classList.remove('is-invalid', 'is-valid');
    if (uniqueError) uniqueError.style.display = 'none';
    if (validMsg) validMsg.style.display = 'none';
    if (defaultError) defaultError.classList.remove('show');
    
    if (!name || name.length < 3) {
        if (defaultError) {
            defaultError.textContent = 'Nama produk wajib diisi (minimal 3 karakter)';
            defaultError.classList.add('show');
        }
        input.classList.add('is-invalid');
        return false;
    }
    
    let isDuplicate = false;
    if (isEdit) {
        const editId = parseInt(document.getElementById('form-edit-retail')?.dataset.editId || 0);
        const otherProducts = productData.filter(item => item.id !== editId).map(item => item.name);
        isDuplicate = otherProducts.includes(name);
    } else {
        isDuplicate = existingProducts.includes(name);
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

// ── INIT ──
document.addEventListener('DOMContentLoaded', function() {
    // Validasi duplikat create
    const createName = document.getElementById('create-retail-name');
    if (createName) {
        createName.addEventListener('input', function() { checkProductName(this, false); });
        createName.addEventListener('blur', function() { checkProductName(this, false); });
    }

    // Validasi duplikat edit
    const editName = document.getElementById('edit-retail-name');
    if (editName) {
        editName.addEventListener('input', function() { checkProductName(this, true); });
        editName.addEventListener('blur', function() { checkProductName(this, true); });
    }

    // ── SUBMIT CREATE ──
    document.getElementById('form-create-retail')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('create-retail-name');
        const weightInput = document.getElementById('create-retail-weight');
        const priceInput = document.getElementById('create-retail-price');
        const stockInput = document.getElementById('create-retail-stock');
        const descInput = document.getElementById('create-retail-desc');
        const imageInput = document.getElementById('create-retail-image');
        const btn = document.getElementById('btn-create-retail');
        let isValid = true;

        // Reset errors
        nameInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('create-retail-name-error').classList.remove('show');
        document.getElementById('create-retail-name-unique-error').style.display = 'none';
        document.getElementById('create-retail-name-valid').style.display = 'none';
        
        weightInput.classList.remove('is-invalid');
        document.getElementById('create-retail-weight-error').classList.remove('show');
        
        priceInput.classList.remove('is-invalid');
        document.getElementById('create-retail-price-error').classList.remove('show');
        
        stockInput.classList.remove('is-invalid');
        document.getElementById('create-retail-stock-error').classList.remove('show');
        
        descInput.classList.remove('is-invalid');
        document.getElementById('create-retail-desc-error').classList.remove('show');
        
        document.getElementById('create-retail-image-error').style.display = 'none';

        // Validate name (min 3 chars)
        if (!nameInput.value.trim() || nameInput.value.trim().length < 3) {
            document.getElementById('create-retail-name-error').textContent = 'Nama produk wajib diisi (minimal 3 karakter)';
            document.getElementById('create-retail-name-error').classList.add('show');
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const isDuplicate = existingProducts.includes(nameInput.value.trim().toLowerCase());
            if (isDuplicate) {
                document.getElementById('create-retail-name-unique-error').style.display = 'block';
                nameInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        // Validate weight
        if (weightInput.value === '' || weightInput.value === null || parseFloat(weightInput.value) < 0) {
            document.getElementById('create-retail-weight-error').textContent = 'Berat wajib diisi (minimal 0)';
            document.getElementById('create-retail-weight-error').classList.add('show');
            weightInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate price
        if (priceInput.value === '' || priceInput.value === null || parseFloat(priceInput.value) < 0) {
            document.getElementById('create-retail-price-error').textContent = 'Harga wajib diisi (minimal 0)';
            document.getElementById('create-retail-price-error').classList.add('show');
            priceInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate stock
        if (stockInput.value === '' || stockInput.value === null || parseFloat(stockInput.value) < 0) {
            document.getElementById('create-retail-stock-error').textContent = 'Stok wajib diisi (minimal 0)';
            document.getElementById('create-retail-stock-error').classList.add('show');
            stockInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate description (min 10 chars)
        if (!descInput.value.trim() || descInput.value.trim().length < 10) {
            document.getElementById('create-retail-desc-error').textContent = 'Deskripsi wajib diisi (minimal 10 karakter)';
            document.getElementById('create-retail-desc-error').classList.add('show');
            descInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate image (required)
        if (!imageInput.files || imageInput.files.length === 0) {
            document.getElementById('create-retail-image-error').textContent = 'Foto wajib diupload';
            document.getElementById('create-retail-image-error').style.display = 'block';
            imageInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const file = imageInput.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                document.getElementById('create-retail-image-error').textContent = 'Format gambar harus JPG atau PNG';
                document.getElementById('create-retail-image-error').style.display = 'block';
                imageInput.classList.add('is-invalid');
                isValid = false;
            } else if (file.size > 2 * 1024 * 1024) {
                document.getElementById('create-retail-image-error').textContent = 'Ukuran gambar maksimal 2MB';
                document.getElementById('create-retail-image-error').style.display = 'block';
                imageInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#modal-create-retail .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // ── SUBMIT EDIT ──
    document.getElementById('form-edit-retail')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('edit-retail-name');
        const weightInput = document.getElementById('edit-retail-weight');
        const priceInput = document.getElementById('edit-retail-price');
        const stockInput = document.getElementById('edit-retail-stock');
        const descInput = document.getElementById('edit-retail-desc');
        const imageInput = document.getElementById('edit-retail-image');
        const btn = document.getElementById('btn-edit-retail');
        const editId = parseInt(this.dataset.editId || 0);
        let isValid = true;

        // Reset errors
        nameInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('edit-retail-name-error').classList.remove('show');
        document.getElementById('edit-retail-name-unique-error').style.display = 'none';
        document.getElementById('edit-retail-name-valid').style.display = 'none';
        
        weightInput.classList.remove('is-invalid');
        document.getElementById('edit-retail-weight-error').classList.remove('show');
        
        priceInput.classList.remove('is-invalid');
        document.getElementById('edit-retail-price-error').classList.remove('show');
        
        stockInput.classList.remove('is-invalid');
        document.getElementById('edit-retail-stock-error').classList.remove('show');
        
        descInput.classList.remove('is-invalid');
        document.getElementById('edit-retail-desc-error').classList.remove('show');
        
        document.getElementById('edit-retail-image-error').style.display = 'none';

        // Validate name (min 3 chars)
        if (!nameInput.value.trim() || nameInput.value.trim().length < 3) {
            document.getElementById('edit-retail-name-error').textContent = 'Nama produk wajib diisi (minimal 3 karakter)';
            document.getElementById('edit-retail-name-error').classList.add('show');
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const name = nameInput.value.trim().toLowerCase();
            const isDuplicate = productData.some(item => item.name === name && item.id !== editId);
            if (isDuplicate) {
                document.getElementById('edit-retail-name-unique-error').style.display = 'block';
                nameInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        // Validate weight
        if (weightInput.value === '' || weightInput.value === null || parseFloat(weightInput.value) < 0) {
            document.getElementById('edit-retail-weight-error').textContent = 'Berat wajib diisi (minimal 0)';
            document.getElementById('edit-retail-weight-error').classList.add('show');
            weightInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate price
        if (priceInput.value === '' || priceInput.value === null || parseFloat(priceInput.value) < 0) {
            document.getElementById('edit-retail-price-error').textContent = 'Harga wajib diisi (minimal 0)';
            document.getElementById('edit-retail-price-error').classList.add('show');
            priceInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate stock
        if (stockInput.value === '' || stockInput.value === null || parseFloat(stockInput.value) < 0) {
            document.getElementById('edit-retail-stock-error').textContent = 'Stok wajib diisi (minimal 0)';
            document.getElementById('edit-retail-stock-error').classList.add('show');
            stockInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate description (min 10 chars)
        if (!descInput.value.trim() || descInput.value.trim().length < 10) {
            document.getElementById('edit-retail-desc-error').textContent = 'Deskripsi wajib diisi (minimal 10 karakter)';
            document.getElementById('edit-retail-desc-error').classList.add('show');
            descInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate image (optional)
        if (imageInput.files && imageInput.files.length > 0) {
            const file = imageInput.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                document.getElementById('edit-retail-image-error').textContent = 'Format gambar harus JPG atau PNG';
                document.getElementById('edit-retail-image-error').style.display = 'block';
                imageInput.classList.add('is-invalid');
                isValid = false;
            } else if (file.size > 2 * 1024 * 1024) {
                document.getElementById('edit-retail-image-error').textContent = 'Ukuran gambar maksimal 2MB';
                document.getElementById('edit-retail-image-error').style.display = 'block';
                imageInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#modal-edit-retail .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // ── SEARCH LIVE ──
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
            openModal('modal-edit-retail');
        @else
            openModal('modal-create-retail');
        @endif
    @endif
});

console.log('✅ Halaman Produk Ritel siap digunakan!');
</script>
@endpush