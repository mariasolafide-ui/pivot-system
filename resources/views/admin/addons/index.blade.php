@extends('layouts.admin')
@section('title', 'Master Addon / Topping')
@section('page-title', 'Master Addon / Topping')

@section('content')

<style>
    /* ── BREADCRUMB ── */
    .breadcrumb-admin {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 20px;
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

    /* ── NAVIGASI BACK (DI ATAS BREADCRUMB) ── */
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
    }
    .btn-delete:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
    }

    .btn-toggle-on {
        background: #f59e0b;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
    }
    .btn-toggle-on:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
    }

    .btn-toggle-off {
        background: #16a34a;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
    }
    .btn-toggle-off:hover {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
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
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    /* ── LAYOUT ── */
    .addon-container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
        align-items: start;
    }

    .addon-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }

    .addon-card:hover {
        border-color: #d4a373;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .addon-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 10px;
    }

    .addon-name {
        font-weight: 600;
        font-size: 15px;
        color: #1b4332;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .addon-actions {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }

    .addon-actions .btn {
        font-size: 10px;
        padding: 3px 8px;
        height: 28px;
        border-radius: 6px;
    }

    /* ── FORM CARD ── */
    .form-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        position: sticky;
        top: 80px;
    }

    .form-card .card-header {
        padding: 14px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #fafafa;
    }

    .form-card .card-header .card-title {
        font-size: 15px;
        font-weight: 700;
        color: #1b4332;
        margin: 0;
    }

    .form-card .card-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        display: block;
        margin-bottom: 4px;
    }

    .form-group label .required {
        color: #dc2626;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        font-family: 'Outfit', sans-serif;
        transition: all 0.2s ease;
    }

    .form-group input:focus {
        outline: none;
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

    .form-group .field-error {
        font-size: 11px;
        color: #dc2626;
        margin-top: 4px;
        display: none;
    }

    .form-group .field-error.show {
        display: block;
    }

    .form-group .field-success {
        font-size: 11px;
        color: #16a34a;
        margin-top: 4px;
        display: none;
    }

    .form-group .field-success.show {
        display: block;
    }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .empty-state .icon {
        font-size: 32px;
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
        max-width: 350px;
        margin: 0 auto 16px;
        color: #6b7280;
    }

    /* ── MODAL ── */
    .modal-sm {
        max-width: 400px;
    }

    .modal-variant-group .form-group {
        margin-bottom: 12px;
    }

    .modal-variant-group label {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        display: block;
        margin-bottom: 4px;
    }

    .modal-variant-group label .required {
        color: #dc2626;
    }

    .modal-variant-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        font-family: 'Outfit', sans-serif;
        transition: all 0.2s ease;
    }

    .modal-variant-group input:focus {
        outline: none;
        border-color: #1b4332;
        box-shadow: 0 0 0 2px rgba(27, 67, 50, 0.1);
    }

    .modal-variant-group input.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }

    .modal-variant-group input.is-valid {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .modal-variant-group .field-error {
        font-size: 11px;
        color: #dc2626;
        margin-top: 4px;
        display: none;
    }

    .modal-variant-group .field-error.show {
        display: block;
    }

    .modal-variant-group .field-success {
        font-size: 11px;
        color: #16a34a;
        margin-top: 4px;
        display: none;
    }

    .modal-variant-group .field-success.show {
        display: block;
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

    /* ── TABLE WRAP ── */
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

    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-block {
        width: 100%;
        justify-content: center;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 992px) {
        .addon-container {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-card {
            position: static;
        }

        .addon-card {
            padding: 14px 16px;
        }
    }

    @media (max-width: 768px) {
        .addon-card {
            padding: 12px 14px;
            margin-bottom: 10px;
        }

        .addon-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .addon-name {
            font-size: 14px;
            width: 100%;
        }

        .addon-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .addon-actions .btn {
            font-size: 10px;
            padding: 3px 8px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .page-header h2 {
            font-size: 20px;
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
        }

        .empty-state {
            padding: 30px 16px;
        }

        .empty-state .icon {
            font-size: 28px;
        }

        .empty-state h3 {
            font-size: 15px;
        }

        .empty-state p {
            font-size: 12px;
        }

        .nav-back {
            font-size: 13px;
            padding: 6px 14px;
        }

        .breadcrumb-admin {
            font-size: 12px;
        }

        .table-wrap table {
            font-size: 12px;
            min-width: 400px;
        }

        .table-wrap th,
        .table-wrap td {
            padding: 8px 10px;
        }

        .form-card .card-body {
            padding: 16px;
        }
    }

    @media (max-width: 480px) {
        .addon-card {
            padding: 10px 12px;
            margin-bottom: 8px;
        }

        .addon-name {
            font-size: 13px;
        }

        .addon-actions .btn {
            font-size: 9px;
            padding: 2px 6px;
        }

        .page-header h2 {
            font-size: 18px;
        }

        .page-header p {
            font-size: 12px;
        }

        .modal-title {
            font-size: 15px;
        }

        .modal-variant-group label {
            font-size: 11px;
        }

        .modal-variant-group input {
            font-size: 12px;
            padding: 6px 10px;
        }

        .modal-footer .btn {
            font-size: 12px;
            padding: 6px 12px;
        }

        .empty-state {
            padding: 24px 12px;
        }

        .empty-state .icon {
            font-size: 24px;
        }

        .empty-state h3 {
            font-size: 14px;
        }

        .empty-state p {
            font-size: 11px;
        }

        .nav-back {
            font-size: 12px;
            padding: 5px 12px;
        }

        .breadcrumb-admin {
            font-size: 11px;
        }

        .table-wrap table {
            font-size: 11px;
            min-width: 320px;
        }

        .table-wrap th,
        .table-wrap td {
            padding: 6px 8px;
        }

        .form-card .card-body {
            padding: 12px;
        }

        .form-group input {
            font-size: 12px;
            padding: 6px 10px;
        }
    }

    @media (max-width: 768px) and (orientation: landscape) {
        .addon-container {
            grid-template-columns: 1fr 1fr;
        }

        .form-card {
            position: static;
        }

        .addon-header {
            flex-direction: row;
            align-items: center;
        }

        .addon-actions {
            width: auto;
        }

        .addon-actions .btn {
            width: auto;
        }
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme: dark) {
        .addon-card {
            background: #1f2937;
            border-color: #374151;
        }

        .addon-card:hover {
            border-color: #d4a373;
        }

        .addon-name {
            color: #f3f4f6;
        }

        .form-card {
            background: #1f2937;
            border-color: #374151;
        }

        .form-card .card-header {
            background: #111827;
            border-color: #374151;
        }

        .form-card .card-header .card-title {
            color: #f3f4f6;
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
            box-shadow: 0 0 0 2px rgba(212, 163, 115, 0.2);
        }

        .form-group input.is-invalid {
            border-color: #dc2626;
            background: #1f1414;
        }

        .form-group input.is-valid {
            border-color: #16a34a;
            background: #064e3b;
        }

        .empty-state {
            background: #1f2937;
            border-color: #374151;
        }

        .empty-state h3 {
            color: #f3f4f6;
        }

        .empty-state p {
            color: #9ca3af;
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

        .modal-variant-group label {
            color: #e5e7eb;
        }

        .modal-variant-group input {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }

        .modal-variant-group input:focus {
            border-color: #d4a373;
        }

        .modal-variant-group input.is-invalid {
            border-color: #dc2626;
            background: #1f1414;
        }

        .modal-variant-group input.is-valid {
            border-color: #16a34a;
            background: #064e3b;
        }

        .modal-footer {
            background: #1f2937;
            border-color: #374151;
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
    }
</style>

{{-- ── BACK LINK (DI ATAS BREADCRUMB) ── --}}
<a href="{{ route('admin.menus.index') }}" class="nav-back">
    <i class="fas fa-arrow-left"></i> Kembali ke Manajemen Menu
</a>

{{-- ── BREADCRUMB (DI BAWAH BACK LINK) ── --}}
<div class="breadcrumb-admin">
    <a href="{{ route('admin.menus.index') }}">
        <i class="fas fa-utensils"></i> Manajemen Menu
    </a>
    <span class="separator">/</span>
    <span class="current">Master Addon / Topping</span>
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

{{-- ── HEADER ── --}}
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
    <div>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 24px; color: #1b4332; margin: 0;">
            ➕ Master Addon / Topping
        </h2>
        <p style="color: #6b7280; margin: 2px 0 0 0; font-size: 13px;">
            Kelola addon yang bisa digunakan untuk semua menu
        </p>
    </div>
</div>

{{-- ── CONTENT ── --}}
<div class="addon-container">

    {{-- ── FORM TAMBAH ADDON ── --}}
    <div class="form-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-plus-circle" style="color: #d4a373;"></i> Tambah Addon Baru
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.addons.store') }}" method="POST" id="form-create-addon">
                @csrf
                <div class="form-group">
                    <label>Nama Addon <span class="required">*</span></label>
                    <input type="text" name="name" id="create-addon-name" placeholder="Contoh: Extra Shot" required>
                    <div class="field-error" id="create-addon-name-error">Nama addon wajib diisi</div>
                    <div class="field-error" id="create-addon-name-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nama addon sudah terdaftar
                    </div>
                    <div class="field-success" id="create-addon-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama addon tersedia
                    </div>
                </div>
                <div class="form-group">
                    <label>Harga (Rp) <span class="required">*</span></label>
                    <input type="number" name="price" id="create-addon-price" value="0" min="0" step="500" required>
                    <div class="field-error" id="create-addon-price-error">Harga minimal Rp 0</div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" id="btn-create-addon">
                    <i class="fas fa-plus"></i> Tambah Addon
                </button>
            </form>
        </div>
    </div>

    {{-- ── DAFTAR ADDON ── --}}
    <div>
        @if(isset($addons) && $addons->count() > 0)
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div class="card-title" style="margin:0;">
                        <i class="fas fa-list" style="color: #d4a373;"></i> Daftar Addon
                    </div>
                    <span style="font-size:12px; color:#6b7280;">
                        <i class="fas fa-hashtag"></i> {{ $addons->count() }} addon
                    </span>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Addon</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th style="min-width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addons as $addon)
                            <tr>
                                <td style="font-weight:500;">{{ $addon->name }}</td>
                                <td>Rp {{ number_format($addon->price, 0, ',', '.') }}</td>
                                <td>
                                    @if($addon->is_available)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex; gap:4px; flex-wrap:wrap;">
                                        {{-- Tombol Toggle --}}
                                        <form action="{{ route('admin.addons.toggle', $addon) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $addon->is_available ? 'btn-toggle-on' : 'btn-toggle-off' }}">
                                                <i class="fas {{ $addon->is_available ? 'fa-pause' : 'fa-play' }}"></i>
                                                {{ $addon->is_available ? 'Nonaktif' : 'Aktif' }}
                                            </button>
                                        </form>
                                        
                                        {{-- Tombol Edit --}}
                                        <button type="button" class="btn btn-sm btn-edit" onclick="openEditAddon({{ $addon->id }}, '{{ addslashes($addon->name) }}', {{ $addon->price }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        
                                        {{-- Tombol Hapus --}}
                                        <button type="button" class="btn btn-sm btn-delete" onclick="confirmDeleteAddon({{ $addon->id }}, '{{ addslashes($addon->name) }}')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- ── EMPTY STATE ── --}}
            <div class="empty-state">
                <div class="icon">🍯</div>
                <h3>Belum Ada Addon</h3>
                <p>Addon digunakan untuk topping atau tambahan seperti Extra Shot, Jelly, Ice Cream, dan lainnya.</p>
                <p style="font-size:12px; color:#9ca3af; margin-top:8px;">
                    <i class="fas fa-arrow-left"></i> Gunakan form di sebelah kiri untuk menambahkan addon pertama.
                </p>
            </div>
        @endif
    </div>

</div>

{{-- ── MODAL CREATE ADDON ── --}}
<div class="modal-backdrop" id="modal-create-addon">
    <div class="modal modal-sm modal-variant-group">
        <div class="modal-header">
            <div class="modal-title">Tambah Addon Baru</div>
            <button class="modal-close" onclick="closeModal('modal-create-addon')">×</button>
        </div>
        <form action="{{ route('admin.addons.store') }}" method="POST" id="form-create-addon-modal">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Addon <span class="required">*</span></label>
                    <input type="text" name="name" id="modal-create-addon-name" placeholder="Contoh: Extra Shot" required>
                    <div class="field-error" id="modal-create-addon-name-error">Nama addon wajib diisi</div>
                    <div class="field-error" id="modal-create-addon-name-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nama addon sudah terdaftar
                    </div>
                    <div class="field-success" id="modal-create-addon-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama addon tersedia
                    </div>
                </div>
                <div class="form-group">
                    <label>Harga (Rp) <span class="required">*</span></label>
                    <input type="number" name="price" id="modal-create-addon-price" value="0" min="0" step="500" required>
                    <div class="field-error" id="modal-create-addon-price-error">Harga minimal Rp 0</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-create-addon')">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-modal-create-addon">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ADDON ── --}}
<div class="modal-backdrop" id="modal-edit-addon">
    <div class="modal modal-sm modal-variant-group">
        <div class="modal-header">
            <div class="modal-title">Edit Addon</div>
            <button class="modal-close" onclick="closeModal('modal-edit-addon')">×</button>
        </div>
        <form id="form-edit-addon" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Addon <span class="required">*</span></label>
                    <input type="text" name="name" id="edit-addon-name" required>
                    <div class="field-error" id="edit-addon-name-error">Nama addon wajib diisi</div>
                    <div class="field-error" id="edit-addon-name-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nama addon sudah terdaftar
                    </div>
                    <div class="field-success" id="edit-addon-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama addon tersedia
                    </div>
                </div>
                <div class="form-group">
                    <label>Harga (Rp) <span class="required">*</span></label>
                    <input type="number" name="price" id="edit-addon-price" min="0" step="500" required>
                    <div class="field-error" id="edit-addon-price-error">Harga minimal Rp 0</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-edit-addon')">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-edit-addon">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── DELETE CONFIRMATION ── --}}
<div class="modal-backdrop" id="modal-delete-addon">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Addon?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus addon <strong id="delete-addon-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;">Tindakan ini tidak dapat dibatalkan!</span>
            </div>
            <form id="delete-addon-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-addon')">Batal</button>
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
// ── DATA ADDON EXISTING ──
const existingAddons = @json($addons->pluck('name')->map(function($name) { 
    return strtolower($name); 
})->toArray() ?? []);

const addonData = @json($addons->map(function($addon) {
    return ['id' => $addon->id, 'name' => strtolower($addon->name)];
})->toArray() ?? []);

// ── MODAL FUNCTIONS ──
function openCreateAddonModal() {
    document.getElementById('modal-create-addon').classList.add('open');
    document.body.style.overflow = 'hidden';
    document.getElementById('form-create-addon-modal').reset();
    document.getElementById('modal-create-addon-name').classList.remove('is-invalid', 'is-valid');
    document.getElementById('modal-create-addon-name-error').classList.remove('show');
    document.getElementById('modal-create-addon-name-unique-error').style.display = 'none';
    document.getElementById('modal-create-addon-name-valid').style.display = 'none';
    document.getElementById('modal-create-addon-price').classList.remove('is-invalid');
    document.getElementById('modal-create-addon-price-error').classList.remove('show');
}

function openEditAddon(id, name, price) {
    const form = document.getElementById('form-edit-addon');
    form.action = '/admin/addons/' + id;
    document.getElementById('edit-addon-name').value = name;
    document.getElementById('edit-addon-price').value = price;
    document.getElementById('edit-addon-name').classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-addon-name-error').classList.remove('show');
    document.getElementById('edit-addon-name-unique-error').style.display = 'none';
    document.getElementById('edit-addon-name-valid').style.display = 'none';
    document.getElementById('edit-addon-price').classList.remove('is-invalid');
    document.getElementById('edit-addon-price-error').classList.remove('show');
    document.getElementById('form-edit-addon').dataset.editId = id;
    document.getElementById('modal-edit-addon').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function confirmDeleteAddon(id, name) {
    const form = document.getElementById('delete-addon-form');
    form.action = '/admin/addons/' + id;
    document.getElementById('delete-addon-name').textContent = name;
    document.getElementById('modal-delete-addon').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

// ── CEK DUPLIKAT ──
function checkAddonName(input, isEdit = false) {
    const name = input.value.trim().toLowerCase();
    const uniqueError = input.parentElement.querySelector('.field-error:last-child');
    const validMsg = input.parentElement.querySelector('.field-success');
    const defaultError = input.parentElement.querySelector('.field-error:first-child');
    
    input.classList.remove('is-invalid', 'is-valid');
    if (uniqueError) uniqueError.style.display = 'none';
    if (validMsg) validMsg.style.display = 'none';
    if (defaultError) defaultError.classList.remove('show');
    
    if (!name) {
        if (defaultError) defaultError.classList.add('show');
        input.classList.add('is-invalid');
        return false;
    }
    
    let isDuplicate = false;
    if (isEdit) {
        const editId = parseInt(document.getElementById('form-edit-addon')?.dataset.editId || 0);
        const otherAddons = addonData.filter(item => item.id !== editId).map(item => item.name);
        isDuplicate = otherAddons.includes(name);
    } else {
        isDuplicate = existingAddons.includes(name);
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
                if (toast.parentNode) toast.remove();
            }, 300);
        }
    }, 4000);
}

// ── INIT ──
document.addEventListener('DOMContentLoaded', function() {
    // Validasi duplikat create
    const createName = document.getElementById('create-addon-name');
    if (createName) {
        createName.addEventListener('input', function() { checkAddonName(this, false); });
        createName.addEventListener('blur', function() { checkAddonName(this, false); });
    }

    // Validasi duplikat edit
    const editName = document.getElementById('edit-addon-name');
    if (editName) {
        editName.addEventListener('input', function() { checkAddonName(this, true); });
        editName.addEventListener('blur', function() { checkAddonName(this, true); });
    }

    // Validasi modal create
    const modalCreateName = document.getElementById('modal-create-addon-name');
    if (modalCreateName) {
        modalCreateName.addEventListener('input', function() { checkAddonName(this, false); });
        modalCreateName.addEventListener('blur', function() { checkAddonName(this, false); });
    }

    // Submit create
    document.getElementById('form-create-addon')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('create-addon-name');
        const priceInput = document.getElementById('create-addon-price');
        const priceError = document.getElementById('create-addon-price-error');
        const btn = document.getElementById('btn-create-addon');
        let isValid = true;

        nameInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('create-addon-name-error').classList.remove('show');
        document.getElementById('create-addon-name-unique-error').style.display = 'none';
        document.getElementById('create-addon-name-valid').style.display = 'none';
        priceInput.classList.remove('is-invalid');
        priceError.classList.remove('show');

        if (!nameInput.value.trim()) {
            document.getElementById('create-addon-name-error').classList.add('show');
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const isDuplicate = existingAddons.includes(nameInput.value.trim().toLowerCase());
            if (isDuplicate) {
                document.getElementById('create-addon-name-unique-error').style.display = 'block';
                nameInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        const price = parseFloat(priceInput.value);
        if (isNaN(price) || price < 0) {
            priceInput.classList.add('is-invalid');
            priceError.classList.add('show');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#form-create-addon .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // Submit modal create
    document.getElementById('form-create-addon-modal')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('modal-create-addon-name');
        const priceInput = document.getElementById('modal-create-addon-price');
        const priceError = document.getElementById('modal-create-addon-price-error');
        const btn = document.getElementById('btn-modal-create-addon');
        let isValid = true;

        nameInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('modal-create-addon-name-error').classList.remove('show');
        document.getElementById('modal-create-addon-name-unique-error').style.display = 'none';
        document.getElementById('modal-create-addon-name-valid').style.display = 'none';
        priceInput.classList.remove('is-invalid');
        priceError.classList.remove('show');

        if (!nameInput.value.trim()) {
            document.getElementById('modal-create-addon-name-error').classList.add('show');
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const isDuplicate = existingAddons.includes(nameInput.value.trim().toLowerCase());
            if (isDuplicate) {
                document.getElementById('modal-create-addon-name-unique-error').style.display = 'block';
                nameInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        const price = parseFloat(priceInput.value);
        if (isNaN(price) || price < 0) {
            priceInput.classList.add('is-invalid');
            priceError.classList.add('show');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#modal-create-addon .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // Submit edit
    document.getElementById('form-edit-addon')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('edit-addon-name');
        const priceInput = document.getElementById('edit-addon-price');
        const priceError = document.getElementById('edit-addon-price-error');
        const btn = document.getElementById('btn-edit-addon');
        const editId = parseInt(this.dataset.editId || 0);
        let isValid = true;

        nameInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('edit-addon-name-error').classList.remove('show');
        document.getElementById('edit-addon-name-unique-error').style.display = 'none';
        document.getElementById('edit-addon-name-valid').style.display = 'none';
        priceInput.classList.remove('is-invalid');
        priceError.classList.remove('show');

        if (!nameInput.value.trim()) {
            document.getElementById('edit-addon-name-error').classList.add('show');
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const name = nameInput.value.trim().toLowerCase();
            const isDuplicate = addonData.some(item => item.name === name && item.id !== editId);
            if (isDuplicate) {
                document.getElementById('edit-addon-name-unique-error').style.display = 'block';
                nameInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        const price = parseFloat(priceInput.value);
        if (isNaN(price) || price < 0) {
            priceInput.classList.add('is-invalid');
            priceError.classList.add('show');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#modal-edit-addon .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // Auto close error summary
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
});

console.log('✅ Halaman Master Addon siap digunakan!');
</script>
@endpush