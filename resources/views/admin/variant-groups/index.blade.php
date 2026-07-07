@extends('layouts.admin')
@section('title', 'Kelola Grup Varian')
@section('page-title', 'Kelola Grup Varian')

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

    /* ── BUTTON BULAT KONSISTEN ── */
    .btn-edit, .btn-delete, .btn-toggle-on, .btn-toggle-off, .btn-primary, .btn-secondary, .btn-danger {
        border-radius: 30px !important;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        font-family: 'Outfit', sans-serif;
        font-weight: 500;
    }

    .btn-edit {
        background: #3b82f6;
        color: white;
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
    }
    .btn-delete:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        color: white;
    }

    .btn-toggle-on {
        background: #f59e0b;
        color: white;
    }
    .btn-toggle-on:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
        color: white;
    }

    .btn-toggle-off {
        background: #16a34a;
        color: white;
    }
    .btn-toggle-off:hover {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
        color: white;
    }

    .btn-primary {
        background: #1b4332;
        color: white;
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
        border: 1px solid #e5e7eb;
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }
    .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        color: white;
    }

    .btn-sm {
        padding: 4px 12px;
        font-size: 11px;
        height: 28px;
        border-radius: 30px !important;
    }

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        color: #1b4332;
        margin: 0;
    }
    .page-header p {
        color: #6b7280;
        margin: 2px 0 0 0;
        font-size: 13px;
    }

    /* ── VARIANT GROUP CARD ── */
    .variant-group-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 16px;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .variant-group-card:hover {
        border-color: #d4a373;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .variant-group-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f3f4f6;
    }

    .variant-group-name {
        font-weight: 600;
        font-size: 16px;
        color: #1b4332;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .variant-group-name .badge-count {
        font-size: 11px;
        background: #e8f5e9;
        color: #1b4332;
        padding: 2px 10px;
        border-radius: 20px;
        font-weight: 500;
    }
    .variant-group-name .status-badge {
        font-size: 10px;
        padding: 2px 10px;
        border-radius: 20px;
        font-weight: 600;
    }
    .variant-group-name .status-badge.active {
        background: #dcfce7;
        color: #166534;
    }
    .variant-group-name .status-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .variant-group-actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    /* ── VARIANT LIST ── */
    .variant-list {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 14px;
    }

    .variant-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 14px;
        background: #f9fafb;
        border-radius: 8px;
        border: 1px solid #f3f4f6;
        transition: all 0.2s ease;
        flex-wrap: wrap;
        gap: 6px;
    }
    .variant-item:hover {
        background: #f3f4f6;
    }
    .variant-item.default {
        background: #f0fdf4;
        border-color: #86efac;
    }
    .variant-item.default:hover {
        background: #dcfce7;
    }

    .variant-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .variant-name {
        font-size: 14px;
        font-weight: 500;
        color: #111827;
    }
    .variant-price {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }
    .variant-default-badge {
        font-size: 9px;
        background: #1b4332;
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .variant-actions {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }
    .variant-actions .btn {
        font-size: 10px;
        padding: 3px 10px;
        height: 24px;
        border-radius: 30px !important;
    }

    /* ── ADD VARIANT FORM ── */
    .add-variant-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: flex-end;
        padding-top: 14px;
        border-top: 1px dashed #e5e7eb;
        margin-top: 4px;
    }
    .add-variant-form .form-group {
        flex: 1;
        min-width: 120px;
    }
    .add-variant-form label {
        font-size: 10px;
        font-weight: 600;
        color: #6b7280;
        display: block;
        margin-bottom: 3px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .add-variant-form input {
        padding: 6px 12px;
        font-size: 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        width: 100%;
        font-family: 'Outfit', sans-serif;
        transition: all 0.2s ease;
        background: white;
    }
    .add-variant-form input:focus {
        outline: none;
        border-color: #1b4332;
        box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.08);
    }
    .add-variant-form input.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }
    .add-variant-form .field-error {
        font-size: 10px;
        color: #dc2626;
        margin-top: 3px;
        display: none;
    }
    .add-variant-form .field-error.show {
        display: block;
    }
    .add-variant-form .checkbox-group {
        display: flex;
        align-items: center;
        gap: 6px;
        padding-top: 6px;
    }
    .add-variant-form .checkbox-group input[type="checkbox"] {
        width: auto;
        margin: 0;
        accent-color: #1b4332;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }
    .add-variant-form .checkbox-group label {
        margin: 0;
        cursor: pointer;
        font-size: 12px;
        text-transform: none;
        letter-spacing: 0;
        color: #374151;
    }
    .add-variant-form .form-group:last-child {
        min-width: auto;
        flex: 0;
    }
    .add-variant-form .form-group:last-child .btn {
        height: 36px;
        padding: 0 18px;
        font-size: 13px;
        border-radius: 30px !important;
    }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #9ca3af;
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        max-width: 700px;
        margin: 0 auto;
    }
    .empty-state .icon {
        font-size: 40px;
        margin-bottom: 12px;
        opacity: 0.4;
    }
    .empty-state h3 {
        font-size: 18px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .empty-state p {
        font-size: 14px;
        max-width: 400px;
        margin: 0 auto 20px;
        color: #6b7280;
        line-height: 1.6;
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
        backdrop-filter: blur(4px);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .modal-backdrop.open {
        display: flex;
    }
    .modal {
        background: white;
        border-radius: 16px;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        width: 100%;
        max-width: 480px;
        animation: modalIn 0.25s ease;
    }
    @keyframes modalIn {
        from { opacity:0; transform:scale(0.95) translateY(10px); }
        to { opacity:1; transform:scale(1) translateY(0); }
    }
    .modal-sm { max-width: 400px; }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #fafafa;
    }
    .modal-title {
        font-size: 17px;
        font-weight: 700;
        color: #111827;
        font-family: 'Playfair Display', serif;
    }
    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #6b7280;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
        transition: transform 0.2s;
    }
    .modal-close:hover {
        color: #111827;
        transform: rotate(90deg);
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
        border-radius: 0 0 16px 16px;
        flex-wrap: wrap;
    }
    .modal-footer .btn {
        padding: 8px 20px;
        height: 36px;
        border-radius: 30px !important;
        font-size: 13px;
    }

    .modal-variant-group .form-group {
        margin-bottom: 14px;
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
        padding: 8px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Outfit', sans-serif;
        transition: all 0.2s ease;
        background: white;
    }
    .modal-variant-group input:focus {
        outline: none;
        border-color: #1b4332;
        box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.08);
    }
    .modal-variant-group input.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
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

    /* ── ERROR SUMMARY ── */
    .error-summary {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 20px;
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

    /* ── DELETE MODAL BODY ── */
    .delete-modal-body {
        text-align: center;
        padding: 28px 24px;
    }
    .delete-modal-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }
    .delete-modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #1b4332;
        margin-bottom: 4px;
        font-family: 'Playfair Display', serif;
    }
    .delete-modal-desc {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 18px;
        line-height: 1.6;
    }
    .delete-modal-desc strong {
        color: #1b4332;
    }
    .delete-modal-desc .warning {
        color: #dc2626;
        font-size: 12px;
    }
    .delete-modal-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .delete-modal-actions .btn {
        padding: 8px 20px;
        height: 36px;
        border-radius: 30px !important;
        font-size: 13px;
        min-width: 100px;
        justify-content: center;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 992px) {
        .variant-group-card { padding: 16px 18px; }
        .add-variant-form .form-group { min-width: 100px; }
    }

    @media (max-width: 768px) {
        .variant-group-card { padding: 14px 16px; }
        .variant-group-header { flex-direction: column; align-items: flex-start; gap: 8px; }
        .variant-group-actions { width: 100%; justify-content: flex-start; }
        .variant-item { flex-direction: column; align-items: flex-start; padding: 10px 12px; }
        .variant-info { width: 100%; }
        .variant-actions { width: 100%; justify-content: flex-start; }
        .variant-actions .btn { flex: 1; justify-content: center; }
        .add-variant-form { flex-direction: column; gap: 8px; }
        .add-variant-form .form-group { min-width: 100%; width: 100%; }
        .add-variant-form .form-group:last-child { flex: 1; width: 100%; }
        .add-variant-form .form-group:last-child .btn { width: 100%; justify-content: center; }
        .add-variant-form .checkbox-group { padding-top: 0; }
        .page-header { flex-direction: column; align-items: flex-start; }
        .page-header h2 { font-size: 20px; }
        .page-header .btn { width: 100%; justify-content: center; }
        .modal { max-width: 95% !important; margin: 10px; }
        .modal-body { padding: 16px; }
        .modal-footer { flex-direction: column; gap: 6px; }
        .modal-footer .btn { width: 100%; justify-content: center; }
        .delete-modal-actions { flex-direction: column; }
        .delete-modal-actions .btn { width: 100%; }
        .nav-back { font-size: 12px; padding: 6px 14px; }
        .breadcrumb-admin { font-size: 12px; }
        .empty-state { padding: 30px 16px; }
        .empty-state .icon { font-size: 32px; }
        .empty-state h3 { font-size: 16px; }
        .empty-state p { font-size: 13px; }
    }

    @media (max-width: 480px) {
        .variant-group-card { padding: 10px 12px; margin-bottom: 12px; }
        .variant-group-name { font-size: 14px; gap: 4px; }
        .variant-group-name .badge-count { font-size: 10px; padding: 1px 8px; }
        .variant-item { padding: 8px 10px; }
        .variant-name { font-size: 13px; }
        .variant-price { font-size: 12px; }
        .variant-default-badge { font-size: 8px; padding: 1px 8px; }
        .add-variant-form input { font-size: 12px; padding: 5px 10px; }
        .add-variant-form label { font-size: 9px; }
        .add-variant-form .checkbox-group label { font-size: 11px; }
        .add-variant-form .form-group:last-child .btn { font-size: 12px; height: 32px; }
        .page-header h2 { font-size: 18px; }
        .page-header p { font-size: 12px; }
        .modal-title { font-size: 16px; }
        .modal-variant-group label { font-size: 11px; }
        .modal-variant-group input { font-size: 13px; padding: 6px 12px; }
        .breadcrumb-admin { font-size: 11px; }
        .empty-state .icon { font-size: 28px; }
        .empty-state h3 { font-size: 15px; }
        .empty-state p { font-size: 12px; }
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme: dark) {
        .variant-group-card {
            background: #1f2937;
            border-color: #374151;
        }
        .variant-group-card:hover {
            border-color: #d4a373;
        }
        .variant-group-name {
            color: #f3f4f6;
        }
        .variant-group-name .badge-count {
            background: #374151;
            color: #e5e7eb;
        }
        .variant-group-header {
            border-color: #374151;
        }
        .variant-item {
            background: #111827;
            border-color: #374151;
        }
        .variant-item:hover {
            background: #1f2937;
        }
        .variant-item.default {
            background: #064e3b;
            border-color: #059669;
        }
        .variant-item.default:hover {
            background: #065f46;
        }
        .variant-name {
            color: #f3f4f6;
        }
        .variant-price {
            color: #9ca3af;
        }
        .variant-default-badge {
            background: #1b4332;
            color: #f3f4f6;
        }
        .add-variant-form {
            border-color: #374151;
        }
        .add-variant-form input {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }
        .add-variant-form input:focus {
            border-color: #d4a373;
            box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.15);
        }
        .add-variant-form input.is-invalid {
            border-color: #dc2626;
            background: #1f1414;
        }
        .add-variant-form label {
            color: #9ca3af;
        }
        .add-variant-form .checkbox-group label {
            color: #e5e7eb;
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
            background: #111827;
            border-color: #374151;
        }
        .modal-title {
            color: #f3f4f6;
        }
        .modal-footer {
            background: #111827;
            border-color: #374151;
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
            box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.15);
        }
        .modal-variant-group input.is-invalid {
            border-color: #dc2626;
            background: #1f1414;
        }
        .delete-modal-title {
            color: #f3f4f6;
        }
        .delete-modal-desc {
            color: #9ca3af;
        }
        .nav-back {
            color: #9ca3af;
            background: rgba(255,255,255,0.05);
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
    }
</style>

{{-- ── NAVIGASI BACK ── --}}
<a href="{{ route('admin.menus.index') }}" class="nav-back">
    <i class="fas fa-arrow-left"></i> Kembali ke Manajemen Menu
</a>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <a href="{{ route('admin.menus.index') }}">
        <i class="fas fa-utensils"></i> Manajemen Menu
    </a>
    <span class="separator">/</span>
    <span class="current">Kelola Grup Varian</span>
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
<div class="page-header">
    <div>
        <h2>📦 Grup Varian</h2>
        <p>Kelola varian untuk menu (Ukuran, Level, Suhu, dll)</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="openCreateGroupModal()">
        <i class="fas fa-plus"></i> Buat Grup
    </button>
</div>

{{-- ── LIST GRUP VARIAN ── --}}
@if(isset($groups) && $groups->count() > 0)

    @foreach($groups as $group)
    <div class="variant-group-card">
        {{-- HEADER --}}
        <div class="variant-group-header">
            <div class="variant-group-name">
                {{ $group->name }}
                <span class="badge-count">{{ $group->variants->count() }}</span>
                <span class="status-badge {{ $group->is_active ? 'active' : 'inactive' }}">
                    {{ $group->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="variant-group-actions">
                <form action="{{ route('admin.variant-groups.toggle', $group) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm {{ $group->is_active ? 'btn-toggle-on' : 'btn-toggle-off' }}">
                        <i class="fas {{ $group->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                        {{ $group->is_active ? 'Nonaktif' : 'Aktif' }}
                    </button>
                </form>
                <button type="button" class="btn btn-sm btn-edit" onclick="editGroup({{ $group->id }}, '{{ addslashes($group->name) }}')">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-delete" onclick="confirmDeleteGroup({{ $group->id }}, '{{ addslashes($group->name) }}')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>

        {{-- LIST VARIAN --}}
        <div class="variant-list">
            @forelse($group->variants as $variant)
            <div class="variant-item {{ $variant->is_default ? 'default' : '' }}">
                <div class="variant-info">
                    <span class="variant-name">{{ $variant->name }}</span>
                    <span class="variant-price">+Rp {{ number_format($variant->extra_price, 0, ',', '.') }}</span>
                    @if($variant->is_default)
                        <span class="variant-default-badge">Default</span>
                    @endif
                </div>
                <div class="variant-actions">
                    @if(!$variant->is_default)
                        <form action="{{ route('admin.variant-groups.variants.default', [$group, $variant]) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-secondary" title="Jadikan default">
                                <i class="fas fa-star"></i> Default
                            </button>
                        </form>
                    @endif
                    <button type="button" class="btn btn-sm btn-delete" onclick="confirmDeleteVariant({{ $group->id }}, {{ $variant->id }}, '{{ addslashes($variant->name) }}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @empty
            <div style="text-align:center; color:#9ca3af; font-size:13px; padding:16px 0;">
                <i class="fas fa-inbox" style="display:block; font-size:20px; margin-bottom:4px; opacity:0.4;"></i>
                Belum ada opsi
            </div>
            @endforelse
        </div>

        {{-- FORM TAMBAH VARIAN --}}
        <form class="add-variant-form" action="{{ route('admin.variant-groups.variants.store', $group) }}" method="POST" id="form-variant-{{ $group->id }}">
            @csrf
            <div class="form-group">
                <label>Nama Opsi</label>
                <input type="text" name="name" placeholder="Contoh: Large" required>
                <div class="field-error" id="variant-name-error-{{ $group->id }}">Nama opsi wajib diisi</div>
            </div>
            <div class="form-group">
                <label>Harga Tambahan</label>
                <input type="number" name="extra_price" value="0" min="0" step="500" placeholder="0">
                <div class="field-error" id="variant-price-error-{{ $group->id }}">Harga minimal Rp 0</div>
            </div>
            <div class="form-group" style="min-width: 80px;">
                <div class="checkbox-group">
                    <input type="checkbox" name="is_default" value="1" id="default-{{ $group->id }}">
                    <label for="default-{{ $group->id }}">Default</label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
        </form>
    </div>
    @endforeach

@else
    <div class="empty-state">
        <div class="icon">📂</div>
        <h3>Belum Ada Grup Varian</h3>
        <p>Grup varian digunakan untuk opsi pilihan seperti ukuran, level kepedasan, suhu, dan lainnya.</p>
        <button type="button" class="btn btn-primary" onclick="openCreateGroupModal()">
            <i class="fas fa-plus"></i> Buat Grup Pertama
        </button>
    </div>
@endif

{{-- ── MODAL CREATE GROUP ── --}}
<div class="modal-backdrop" id="modal-create-group">
    <div class="modal modal-sm modal-variant-group">
        <div class="modal-header">
            <div class="modal-title">Buat Grup Varian</div>
            <button class="modal-close" onclick="closeModal('modal-create-group')">×</button>
        </div>
        <form action="{{ route('admin.variant-groups.store') }}" method="POST" id="form-create-group">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Grup <span class="required">*</span></label>
                    <input type="text" name="name" id="create-group-name" placeholder="Contoh: Ukuran, Level Pedas, Suhu" required>
                    <div class="field-error" id="create-group-name-error">Nama grup wajib diisi</div>
                    <div class="field-error" id="create-group-name-duplicate" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i> Nama grup <strong id="create-duplicate-name"></strong> sudah terdaftar
                    </div>
                    <div class="field-success" id="create-group-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama grup tersedia
                    </div>
                </div>
                <div style="font-size:11px; color:#6b7280; margin-top:6px;">
                    <i class="fas fa-info-circle"></i> Grup akan aktif setelah dibuat.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-group')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-create-group">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT GROUP ── --}}
<div class="modal-backdrop" id="modal-edit-group">
    <div class="modal modal-sm modal-variant-group">
        <div class="modal-header">
            <div class="modal-title">Edit Grup Varian</div>
            <button class="modal-close" onclick="closeModal('modal-edit-group')">×</button>
        </div>
        <form id="edit-group-form" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Grup <span class="required">*</span></label>
                    <input type="text" name="name" id="edit-group-name" required>
                    <div class="field-error" id="edit-group-name-error">Nama grup wajib diisi</div>
                    <div class="field-error" id="edit-group-name-duplicate" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i> Nama grup <strong id="edit-duplicate-name"></strong> sudah terdaftar
                    </div>
                    <div class="field-success" id="edit-group-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama grup tersedia
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-group')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-edit-group">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── DELETE CONFIRMATION GROUP ── --}}
<div class="modal-backdrop" id="modal-delete-group">
    <div class="modal modal-sm">
        <div class="delete-modal-body">
            <div class="delete-modal-icon">🗑️</div>
            <div class="delete-modal-title">Hapus Grup?</div>
            <div class="delete-modal-desc">
                Hapus grup <strong id="delete-group-name"></strong>?
                <br><span class="warning">Semua opsi di dalamnya akan terhapus!</span>
            </div>
            <div class="delete-modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-delete-group')">Batal</button>
                <form id="delete-group-form" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── DELETE CONFIRMATION VARIANT ── --}}
<div class="modal-backdrop" id="modal-delete-variant">
    <div class="modal modal-sm">
        <div class="delete-modal-body">
            <div class="delete-modal-icon">🗑️</div>
            <div class="delete-modal-title">Hapus Opsi?</div>
            <div class="delete-modal-desc">
                Hapus opsi <strong id="delete-variant-name"></strong>?
                <br><span class="warning">Tindakan ini tidak dapat dibatalkan!</span>
            </div>
            <div class="delete-modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-delete-variant')">Batal</button>
                <form id="delete-variant-form" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── DATA GROUP EXISTING ──
const groupData = @json($groups->map(fn($g) => ['id' => $g->id, 'name' => strtolower($g->name)])->toArray() ?? []);

// ── FUNGSI CEK DUPLIKAT ──
function checkDuplicateGroupName(input, editId = null) {
    const name = input.value.trim();
    const nameLower = name.toLowerCase();

    const errorRequired = document.getElementById(input.id + '-error');
    const duplicateError = document.getElementById(input.id + '-duplicate');
    const validEl = document.getElementById(input.id + '-valid');
    const duplicateNameSpan = duplicateError ? duplicateError.querySelector('strong') : null;

    input.classList.remove('is-invalid', 'is-valid');
    if (errorRequired) errorRequired.classList.remove('show');
    if (duplicateError) duplicateError.style.display = 'none';
    if (validEl) validEl.classList.remove('show');

    if (!name) {
        if (errorRequired) errorRequired.classList.add('show');
        input.classList.add('is-invalid');
        return false;
    }

    let isDuplicate = false;
    if (editId) {
        const otherGroups = groupData.filter(item => item.id !== editId).map(item => item.name);
        isDuplicate = otherGroups.includes(nameLower);
    } else {
        isDuplicate = groupData.some(item => item.name === nameLower);
    }

    if (isDuplicate) {
        input.classList.add('is-invalid');
        if (duplicateError) {
            if (duplicateNameSpan) duplicateNameSpan.textContent = name;
            duplicateError.style.display = 'flex';
        }
        return false;
    }

    input.classList.add('is-valid');
    if (validEl) validEl.classList.add('show');
    return true;
}

// ── MODAL FUNCTIONS ──
function openCreateGroupModal() {
    document.getElementById('modal-create-group').classList.add('open');
    document.body.style.overflow = 'hidden';
    document.getElementById('form-create-group').reset();
    const nameInput = document.getElementById('create-group-name');
    nameInput.classList.remove('is-invalid', 'is-valid');
    document.getElementById('create-group-name-error').classList.remove('show');
    document.getElementById('create-group-name-duplicate').style.display = 'none';
    document.getElementById('create-group-name-valid').classList.remove('show');
}

function editGroup(id, name) {
    const form = document.getElementById('edit-group-form');
    form.action = '/admin/variant-groups/' + id;
    document.getElementById('edit-group-name').value = name;
    const nameInput = document.getElementById('edit-group-name');
    nameInput.classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-group-name-error').classList.remove('show');
    document.getElementById('edit-group-name-duplicate').style.display = 'none';
    document.getElementById('edit-group-name-valid').classList.remove('show');
    document.getElementById('modal-edit-group').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function confirmDeleteGroup(id, name) {
    const form = document.getElementById('delete-group-form');
    form.action = '/admin/variant-groups/' + id;
    document.getElementById('delete-group-name').textContent = name;
    document.getElementById('modal-delete-group').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function confirmDeleteVariant(groupId, variantId, name) {
    const form = document.getElementById('delete-variant-form');
    form.action = '/admin/variant-groups/' + groupId + '/variants/' + variantId;
    document.getElementById('delete-variant-name').textContent = name;
    document.getElementById('modal-delete-variant').classList.add('open');
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
                if (toast.parentNode) toast.remove();
            }, 300);
        }
    }, 4000);
}

// ── INIT ──
document.addEventListener('DOMContentLoaded', function() {
    // ── VALIDASI CREATE GROUP ──
    const createName = document.getElementById('create-group-name');
    if (createName) {
        createName.addEventListener('input', function() {
            checkDuplicateGroupName(this);
        });
        createName.addEventListener('blur', function() {
            checkDuplicateGroupName(this);
        });
    }

    // ── VALIDASI EDIT GROUP ──
    const editName = document.getElementById('edit-group-name');
    if (editName) {
        editName.addEventListener('input', function() {
            const form = document.getElementById('edit-group-form');
            const match = form.action.match(/\/admin\/variant-groups\/(\d+)/);
            const editId = match ? parseInt(match[1]) : null;
            checkDuplicateGroupName(this, editId);
        });
        editName.addEventListener('blur', function() {
            const form = document.getElementById('edit-group-form');
            const match = form.action.match(/\/admin\/variant-groups\/(\d+)/);
            const editId = match ? parseInt(match[1]) : null;
            checkDuplicateGroupName(this, editId);
        });
    }

    // ── SUBMIT CREATE ──
    document.getElementById('form-create-group')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('create-group-name');
        const btn = document.getElementById('btn-create-group');

        if (!checkDuplicateGroupName(nameInput)) {
            e.preventDefault();
            nameInput.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // ── SUBMIT EDIT ──
    document.getElementById('edit-group-form')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('edit-group-name');
        const btn = document.getElementById('btn-edit-group');
        const match = this.action.match(/\/admin\/variant-groups\/(\d+)/);
        const editId = match ? parseInt(match[1]) : null;

        if (!checkDuplicateGroupName(nameInput, editId)) {
            e.preventDefault();
            nameInput.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // ── VALIDASI TAMBAH VARIAN ──
    document.querySelectorAll('.add-variant-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const groupId = this.id.replace('form-variant-', '');
            const nameInput = this.querySelector('input[name="name"]');
            const priceInput = this.querySelector('input[name="extra_price"]');
            const nameError = document.getElementById('variant-name-error-' + groupId);
            const priceError = document.getElementById('variant-price-error-' + groupId);
            let isValid = true;

            nameInput.classList.remove('is-invalid');
            nameError.classList.remove('show');
            priceInput.classList.remove('is-invalid');
            priceError.classList.remove('show');

            if (!nameInput.value.trim()) {
                nameInput.classList.add('is-invalid');
                nameError.classList.add('show');
                isValid = false;
            }

            const price = parseFloat(priceInput.value);
            if (isNaN(price) || price < 0) {
                priceInput.classList.add('is-invalid');
                priceError.classList.add('show');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                const firstError = this.querySelector('.is-invalid');
                if (firstError) firstError.focus();
            }
        });
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

    // ── SESSION TOAST ──
    @if(session('success'))
        showToast('success', 'Berhasil', @json(session('success')));
    @endif

    @if(session('error'))
        showToast('error', 'Gagal', @json(session('error')));
    @endif
});

console.log('✅ Halaman Kelola Grup Varian siap digunakan!');
</script>
@endpush