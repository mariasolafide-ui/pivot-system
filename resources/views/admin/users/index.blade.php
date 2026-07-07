@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

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

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
    }
    .role-admin { background: #dbeafe; color: #1e40af; }
    .role-kasir { background: #dcfce7; color: #166534; }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #0e6446;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
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
        min-width: 600px;
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
        padding: 4px 10px;
        border-radius: 30px !important;
        font-weight: 500;
        white-space: nowrap;
        height: 28px;
        min-width: 50px;
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
            padding: 3px 8px;
            height: 26px;
            min-width: 45px;
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
        max-width: 440px;
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

    .form-divider {
        border-top: 1px solid #e5e7eb;
        padding-top: 14px;
        margin-top: 4px;
    }

    .form-divider .hint {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 10px;
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

    /* ── TOAST ── */
    .toast-notification {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 99999;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideUp 0.3s ease;
        max-width: 400px;
        font-size: 14px;
    }

    .toast-success {
        background: #0e6446;
        color: white;
    }

    .toast-error {
        background: #dc2626;
        color: white;
    }

    .toast-close {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        margin-left: 6px;
        opacity: 0.8;
        padding: 0 4px;
    }

    .toast-close:hover {
        opacity: 1;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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

        .stats-grid {
            grid-template-columns: 1fr 1fr;
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
        .breadcrumb-admin {
            font-size: 12px;
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

        .form-group label {
            color: #e5e7eb;
        }

        .form-group input,
        .form-group select {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #d4a373;
        }

        .form-group input.is-invalid,
        .form-group select.is-invalid {
            border-color: #dc2626;
            background: #1f1414;
        }

        .form-group input.is-valid,
        .form-group select.is-valid {
            border-color: #16a34a;
            background: #064e3b;
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

        .user-avatar {
            background: #1b4332;
        }

        .role-admin { background: #1e3a5f; color: #dbeafe; }
        .role-kasir { background: #065f46; color: #dcfce7; }
        .breadcrumb-admin {
            color: #9ca3af;
        }
        .breadcrumb-admin .current {
            color: #d4a373;
        }
    }
</style>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <i class="fas fa-user-gear" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Manajemen User</span>
</div>

{{-- ── STATS ─────────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    @php
    $totalUsers = $users->count();
    $adminCount = $users->where('role', 'admin')->count();
    $kasirCount = $users->where('role', 'kasir')->count();
    @endphp

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-users" style="color: #1b4332;"></i>
            Total User
        </div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-sub">Semua user terdaftar</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-user-shield" style="color: #3b82f6;"></i>
            Admin
        </div>
        <div class="stat-value" style="color: #3b82f6;">{{ $adminCount }}</div>
        <div class="stat-sub">Manajemen</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-user-tie" style="color: #16a34a;"></i>
            Kasir
        </div>
        <div class="stat-value" style="color: #16a34a;">{{ $kasirCount }}</div>
        <div class="stat-sub">Operasional</div>
    </div>
</div>

{{-- ── CARD ─────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-users-cog" style="color: #1b4332; margin-right:8px;"></i>
            Daftar User Terdaftar
        </div>
        
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            {{-- Pencarian --}}
            <form action="{{ url()->current() }}" method="GET" style="display:flex; align-items:center; gap:4px; margin:0;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari user..." 
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

            <button type="button" class="btn btn-primary btn-sm" onclick="openCreateUser()">
                <i class="fas fa-plus"></i> Tambah User
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:44px; text-align:center;">#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th style="text-align:center;">Role</th>
                    <th style="text-align:center;">Bergabung</th>
                    <th class="no-sort" style="text-align:center; min-width:130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td style="text-align:center; color:#6b7280;">{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-weight:500; color:#111827;">{{ $user->name }}</div>
                                @if($user->id === auth('admin')->id())
                                    <div style="font-size:10px; color:#0e6446; font-weight:600;">
                                        <i class="fas fa-user-check"></i> Anda
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px; color:#6b7280;">
                        <i class="fas fa-envelope" style="font-size:10px; margin-right:4px; color:#3b82f6;"></i>
                        {{ $user->email }}
                    </td>
                    <td style="text-align:center;">
                        <span class="role-badge role-{{ $user->role }}">
                            <i class="fas {{ $user->role == 'admin' ? 'fa-user-shield' : 'fa-cash-register' }}"></i>
                            {{ $user->role_label }}
                        </span>
                    </td>
                    <td style="text-align:center; font-size:12px; color:#6b7280;">
                        <i class="far fa-calendar-alt" style="margin-right:4px;"></i>
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-sm btn-edit"
                                onclick="openEditUser(
                                    {{ $user->id }},
                                    '{{ addslashes($user->name) }}',
                                    '{{ addslashes($user->email) }}',
                                    '{{ $user->role }}'
                                )">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            @if($user->id !== auth('admin')->id())
                            <button type="button" class="btn btn-sm btn-delete"
                                onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            @else
                                <span style="font-size:10px; color:#9ca3af; padding:4px 8px; background:#f3f4f6; border-radius:30px;">
                                    <i class="fas fa-lock"></i> Aktif
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('search'))
                            User "{{ request('search') }}" tidak ditemukan.
                        @else
                            <div class="empty-state">
                                <div class="icon">👤</div>
                                <h3>Belum Ada User</h3>
                                <p>Klik tombol "Tambah User" untuk menambahkan user pertama.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL CREATE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-user">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-plus-circle" style="color:#0e6446;"></i>
                Tambah User Baru
            </div>
            <button class="modal-close" onclick="closeModal('modal-create-user')">×</button>
        </div>
        <form id="form-create-user" action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama <span class="required">*</span></label>
                    <input type="text" name="name" id="create-user-name" placeholder="Nama lengkap" required minlength="3">
                    <div class="field-error" id="create-user-name-error">Nama wajib diisi (minimal 3 karakter)</div>
                </div>
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" id="create-user-email" placeholder="email@domain.com" required>
                    <div class="field-error" id="create-user-email-error">Email wajib diisi dengan format yang valid</div>
                    <div class="field-error" id="create-user-email-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Email sudah terdaftar
                    </div>
                    <div class="field-success" id="create-user-email-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Email tersedia
                    </div>
                </div>
                <div class="form-group">
                    <label>Role <span class="required">*</span></label>
                    <select name="role" id="create-user-role" required>
                        <option value="">Pilih Role</option>
                        @foreach(\App\Models\Admin::$roles as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="field-error" id="create-user-role-error">Role wajib dipilih</div>
                </div>
                <div class="form-group">
                    <label>Password <span class="required">*</span></label>
                    <input type="password" name="password" id="create-user-password" placeholder="Minimal 6 karakter" required minlength="6">
                    <div class="field-error" id="create-user-password-error">Password wajib diisi (minimal 6 karakter)</div>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label>Konfirmasi Password <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" id="create-user-password-confirm" placeholder="Ulangi password" required>
                    <div class="field-error" id="create-user-password-confirm-error">Konfirmasi password tidak cocok</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-create-user')">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-create-user">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-user">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-edit" style="color:#3b82f6;"></i>
                Edit User
            </div>
            <button class="modal-close" onclick="closeModal('modal-edit-user')">×</button>
        </div>
        <form id="form-edit-user" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama <span class="required">*</span></label>
                    <input type="text" name="name" id="edit-user-name" required minlength="3">
                    <div class="field-error" id="edit-user-name-error">Nama wajib diisi (minimal 3 karakter)</div>
                </div>
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" id="edit-user-email" required>
                    <div class="field-error" id="edit-user-email-error">Email wajib diisi dengan format yang valid</div>
                    <div class="field-error" id="edit-user-email-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Email sudah terdaftar
                    </div>
                    <div class="field-success" id="edit-user-email-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Email tersedia
                    </div>
                </div>
                <div class="form-group">
                    <label>Role <span class="required">*</span></label>
                    <select name="role" id="edit-user-role" required>
                        @foreach(\App\Models\Admin::$roles as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="field-error" id="edit-user-role-error">Role wajib dipilih</div>
                </div>
                <div class="form-divider">
                    <div class="hint">
                        <i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengubah password.
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" id="edit-user-password" placeholder="Minimal 6 karakter" minlength="6">
                        <div class="field-error" id="edit-user-password-error">Password minimal 6 karakter</div>
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="edit-user-password-confirm" placeholder="Ulangi password baru">
                        <div class="field-error" id="edit-user-password-confirm-error">Konfirmasi password tidak cocok</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-edit-user')">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-edit-user">
                    <i class="fas fa-save"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL DELETE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-delete-user">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus User?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus user <strong id="delete-user-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;">Tindakan ini tidak dapat dibatalkan!</span>
            </div>
            <form id="delete-user-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-user')">
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
// ── DATA USER EXISTING ──
const existingUsers = @json($users->pluck('email')->map(function($email) { 
    return strtolower($email); 
})->toArray() ?? []);

const userData = @json($users->map(function($u) {
    return ['id' => $u->id, 'email' => strtolower($u->email)];
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
function openCreateUser() {
    document.getElementById('form-create-user').reset();
    document.getElementById('create-user-name').classList.remove('is-invalid', 'is-valid');
    document.getElementById('create-user-name-error').classList.remove('show');
    document.getElementById('create-user-email').classList.remove('is-invalid', 'is-valid');
    document.getElementById('create-user-email-error').classList.remove('show');
    document.getElementById('create-user-email-unique-error').style.display = 'none';
    document.getElementById('create-user-email-valid').style.display = 'none';
    document.getElementById('create-user-role').classList.remove('is-invalid');
    document.getElementById('create-user-role-error').classList.remove('show');
    document.getElementById('create-user-password').classList.remove('is-invalid');
    document.getElementById('create-user-password-error').classList.remove('show');
    document.getElementById('create-user-password-confirm').classList.remove('is-invalid');
    document.getElementById('create-user-password-confirm-error').classList.remove('show');
    openModal('modal-create-user');
    setTimeout(function() {
        document.getElementById('create-user-name').focus();
    }, 100);
}

// ── EDIT ──
function openEditUser(id, name, email, role) {
    document.getElementById('form-edit-user').action = '/admin/users/' + id;
    document.getElementById('form-edit-user').dataset.editId = id;
    document.getElementById('edit-user-name').value = name;
    document.getElementById('edit-user-email').value = email;
    document.getElementById('edit-user-role').value = role;
    document.getElementById('edit-user-password').value = '';
    document.getElementById('edit-user-password-confirm').value = '';
    
    document.getElementById('edit-user-name').classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-user-name-error').classList.remove('show');
    document.getElementById('edit-user-email').classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-user-email-error').classList.remove('show');
    document.getElementById('edit-user-email-unique-error').style.display = 'none';
    document.getElementById('edit-user-email-valid').style.display = 'none';
    document.getElementById('edit-user-role').classList.remove('is-invalid');
    document.getElementById('edit-user-role-error').classList.remove('show');
    document.getElementById('edit-user-password').classList.remove('is-invalid');
    document.getElementById('edit-user-password-error').classList.remove('show');
    document.getElementById('edit-user-password-confirm').classList.remove('is-invalid');
    document.getElementById('edit-user-password-confirm-error').classList.remove('show');
    
    openModal('modal-edit-user');
    setTimeout(function() {
        document.getElementById('edit-user-name').focus();
    }, 100);
}

// ── DELETE ──
function confirmDeleteUser(id, name) {
    document.getElementById('delete-user-form').action = '/admin/users/' + id;
    document.getElementById('delete-user-name').textContent = name;
    openModal('modal-delete-user');
}

// ── CEK DUPLIKAT EMAIL ──
function checkUserEmail(input, isEdit = false) {
    const email = input.value.trim().toLowerCase();
    const uniqueError = input.parentElement.querySelector('.field-error:last-child');
    const validMsg = input.parentElement.querySelector('.field-success');
    const defaultError = input.parentElement.querySelector('.field-error:first-child');
    
    input.classList.remove('is-invalid', 'is-valid');
    if (uniqueError) uniqueError.style.display = 'none';
    if (validMsg) validMsg.style.display = 'none';
    if (defaultError) defaultError.classList.remove('show');
    
    if (!email || !email.includes('@') || !email.includes('.')) {
        if (defaultError) {
            defaultError.textContent = 'Email wajib diisi dengan format yang valid';
            defaultError.classList.add('show');
        }
        input.classList.add('is-invalid');
        return false;
    }
    
    let isDuplicate = false;
    if (isEdit) {
        const editId = parseInt(document.getElementById('form-edit-user')?.dataset.editId || 0);
        const otherUsers = userData.filter(item => item.id !== editId).map(item => item.email);
        isDuplicate = otherUsers.includes(email);
    } else {
        isDuplicate = existingUsers.includes(email);
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

// ── CEK PASSWORD ──
function checkPasswordMatch(passwordId, confirmId, errorId) {
    const password = document.getElementById(passwordId);
    const confirm = document.getElementById(confirmId);
    const error = document.getElementById(errorId);
    
    if (confirm.value && password.value !== confirm.value) {
        error.classList.add('show');
        confirm.classList.add('is-invalid');
        return false;
    } else {
        error.classList.remove('show');
        confirm.classList.remove('is-invalid');
        return true;
    }
}

// ── INIT ──
document.addEventListener('DOMContentLoaded', function() {
    // Validasi email create
    const createEmail = document.getElementById('create-user-email');
    if (createEmail) {
        createEmail.addEventListener('input', function() { checkUserEmail(this, false); });
        createEmail.addEventListener('blur', function() { checkUserEmail(this, false); });
    }

    // Validasi email edit
    const editEmail = document.getElementById('edit-user-email');
    if (editEmail) {
        editEmail.addEventListener('input', function() { checkUserEmail(this, true); });
        editEmail.addEventListener('blur', function() { checkUserEmail(this, true); });
    }

    // Validasi password create
    const createPass = document.getElementById('create-user-password');
    const createConfirm = document.getElementById('create-user-password-confirm');
    if (createPass && createConfirm) {
        createPass.addEventListener('input', function() {
            checkPasswordMatch('create-user-password', 'create-user-password-confirm', 'create-user-password-confirm-error');
        });
        createConfirm.addEventListener('input', function() {
            checkPasswordMatch('create-user-password', 'create-user-password-confirm', 'create-user-password-confirm-error');
        });
    }

    // Validasi password edit
    const editPass = document.getElementById('edit-user-password');
    const editConfirm = document.getElementById('edit-user-password-confirm');
    if (editPass && editConfirm) {
        editPass.addEventListener('input', function() {
            checkPasswordMatch('edit-user-password', 'edit-user-password-confirm', 'edit-user-password-confirm-error');
        });
        editConfirm.addEventListener('input', function() {
            checkPasswordMatch('edit-user-password', 'edit-user-password-confirm', 'edit-user-password-confirm-error');
        });
    }

    // Submit create
    document.getElementById('form-create-user')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('create-user-name');
        const emailInput = document.getElementById('create-user-email');
        const roleInput = document.getElementById('create-user-role');
        const passInput = document.getElementById('create-user-password');
        const confirmInput = document.getElementById('create-user-password-confirm');
        const btn = document.getElementById('btn-create-user');
        let isValid = true;

        nameInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('create-user-name-error').classList.remove('show');
        
        emailInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('create-user-email-error').classList.remove('show');
        document.getElementById('create-user-email-unique-error').style.display = 'none';
        document.getElementById('create-user-email-valid').style.display = 'none';
        
        roleInput.classList.remove('is-invalid');
        document.getElementById('create-user-role-error').classList.remove('show');
        
        passInput.classList.remove('is-invalid');
        document.getElementById('create-user-password-error').classList.remove('show');
        
        confirmInput.classList.remove('is-invalid');
        document.getElementById('create-user-password-confirm-error').classList.remove('show');

        // Validate name
        if (!nameInput.value.trim() || nameInput.value.trim().length < 3) {
            document.getElementById('create-user-name-error').textContent = 'Nama wajib diisi (minimal 3 karakter)';
            document.getElementById('create-user-name-error').classList.add('show');
            nameInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate email
        const email = emailInput.value.trim().toLowerCase();
        if (!email || !email.includes('@') || !email.includes('.')) {
            document.getElementById('create-user-email-error').textContent = 'Email wajib diisi dengan format yang valid';
            document.getElementById('create-user-email-error').classList.add('show');
            emailInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const isDuplicate = existingUsers.includes(email);
            if (isDuplicate) {
                document.getElementById('create-user-email-unique-error').style.display = 'block';
                emailInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        // Validate role
        if (!roleInput.value) {
            document.getElementById('create-user-role-error').classList.add('show');
            roleInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate password
        if (!passInput.value || passInput.value.length < 6) {
            document.getElementById('create-user-password-error').textContent = 'Password wajib diisi (minimal 6 karakter)';
            document.getElementById('create-user-password-error').classList.add('show');
            passInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate password confirm
        if (passInput.value && confirmInput.value && passInput.value !== confirmInput.value) {
            document.getElementById('create-user-password-confirm-error').classList.add('show');
            confirmInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#modal-create-user .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // Submit edit
    document.getElementById('form-edit-user')?.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('edit-user-name');
        const emailInput = document.getElementById('edit-user-email');
        const roleInput = document.getElementById('edit-user-role');
        const passInput = document.getElementById('edit-user-password');
        const confirmInput = document.getElementById('edit-user-password-confirm');
        const btn = document.getElementById('btn-edit-user');
        const editId = parseInt(this.dataset.editId || 0);
        let isValid = true;

        nameInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('edit-user-name-error').classList.remove('show');
        
        emailInput.classList.remove('is-invalid', 'is-valid');
        document.getElementById('edit-user-email-error').classList.remove('show');
        document.getElementById('edit-user-email-unique-error').style.display = 'none';
        document.getElementById('edit-user-email-valid').style.display = 'none';
        
        roleInput.classList.remove('is-invalid');
        document.getElementById('edit-user-role-error').classList.remove('show');
        
        passInput.classList.remove('is-invalid');
        document.getElementById('edit-user-password-error').classList.remove('show');
        
        confirmInput.classList.remove('is-invalid');
        document.getElementById('edit-user-password-confirm-error').classList.remove('show');

        // Validate name
        if (!nameInput.value.trim() || nameInput.value.trim().length < 3) {
            document.getElementById('edit-user-name-error').textContent = 'Nama wajib diisi (minimal 3 karakter)';
            document.getElementById('edit-user-name-error').classList.add('show');
            nameInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate email
        const email = emailInput.value.trim().toLowerCase();
        if (!email || !email.includes('@') || !email.includes('.')) {
            document.getElementById('edit-user-email-error').textContent = 'Email wajib diisi dengan format yang valid';
            document.getElementById('edit-user-email-error').classList.add('show');
            emailInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const isDuplicate = userData.some(item => item.email === email && item.id !== editId);
            if (isDuplicate) {
                document.getElementById('edit-user-email-unique-error').style.display = 'block';
                emailInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        // Validate role
        if (!roleInput.value) {
            document.getElementById('edit-user-role-error').classList.add('show');
            roleInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate password (optional, only if filled)
        if (passInput.value && passInput.value.length < 6) {
            document.getElementById('edit-user-password-error').textContent = 'Password minimal 6 karakter';
            document.getElementById('edit-user-password-error').classList.add('show');
            passInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate password confirm
        if (passInput.value && confirmInput.value && passInput.value !== confirmInput.value) {
            document.getElementById('edit-user-password-confirm-error').classList.add('show');
            confirmInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('#modal-edit-user .is-invalid');
            if (firstError) firstError.focus();
            return false;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;
    });

    // ── AUTO CLOSE TOAST ──
    const toasts = document.querySelectorAll('.toast-notification');
    toasts.forEach(function(toast) {
        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(function() {
                if (toast.parentElement) toast.remove();
            }, 300);
        }, 3000);
    });

    // ── RE-OPEN MODAL IF VALIDATION FAILED ──
    @if($errors->any())
        @if(old('_method') === 'PUT')
            openModal('modal-edit-user');
        @else
            openModal('modal-create-user');
        @endif
    @endif
});

console.log('✅ Halaman Manajemen User siap digunakan!');
</script>
@endpush