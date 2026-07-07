@extends('layouts.admin')

@section('title', 'Pesan Kontak')
@section('page-title', 'Pesan Kontak')

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
        min-width: 800px;
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
        gap: 6px;
        flex-wrap: wrap;
    }

    .search-wrapper input,
    .search-wrapper select {
        padding: 5px 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 12px;
        outline: none;
        height: 32px;
        transition: all 0.2s;
        background: white;
    }

    .search-wrapper input {
        width: 180px;
    }

    .search-wrapper select {
        width: 150px;
    }

    .search-wrapper input:focus,
    .search-wrapper select:focus {
        border-color: #1b4332;
        box-shadow: 0 0 0 2px rgba(27, 67, 50, 0.1);
    }

    .search-wrapper .btn {
        height: 32px;
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
        max-width: 500px;
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

    /* ── PAGINATION ── */
    .pagination-wrapper {
        padding: 12px 16px;
        border-top: 1px solid #e5e7eb;
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

        .search-wrapper input,
        .search-wrapper select {
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

        .search-wrapper input,
        .search-wrapper select {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }

        .search-wrapper input:focus,
        .search-wrapper select:focus {
            border-color: #d4a373;
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
    <i class="fas fa-envelope" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Pesan Kontak</span>
</div>

{{-- ── STATS ─────────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    @php
    $totalMessages = $messages->total();
    $todayMessages = $messages->filter(fn($m) => $m->created_at->isToday())->count();
    @endphp

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-envelope" style="color: #1b4332;"></i>
            Total Pesan
        </div>
        <div class="stat-value">{{ $totalMessages }}</div>
        <div class="stat-sub">Semua pesan masuk</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-calendar-day" style="color: #3b82f6;"></i>
            Hari Ini
        </div>
        <div class="stat-value" style="color: #3b82f6;">{{ $todayMessages }}</div>
        <div class="stat-sub">Pesan hari ini</div>
    </div>
</div>

{{-- ── CARD ─────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-inbox" style="color: #1b4332; margin-right:8px;"></i>
            Daftar Pesan Masuk
        </div>
        
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            {{-- Pencarian --}}
            <form action="{{ url()->current() }}" method="GET" class="search-wrapper">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari pesan..." 
                       style="padding:5px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:12px; width:160px; outline:none; height:32px;">
                
                <button type="submit" class="btn btn-secondary btn-sm" style="height:32px; padding:0 12px;">
                    <i class="fas fa-search"></i>
                </button>
                
                @if(request('search'))
                    <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm" style="height:32px; padding:0 12px;">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">#</th>
                    <th style="min-width:120px;">Nama</th>
                    <th style="min-width:150px;">Email</th>
                    <th>Pesan</th>
                    <th style="text-align:center; min-width:140px;">Tanggal</th>
                    <th class="no-sort" style="text-align:center; min-width:200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $index => $msg)
                <tr>
                    <td style="text-align:center; color:#6b7280;">{{ $messages->firstItem() + $index }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:50%; background:#e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-user" style="color:#6b7280; font-size:14px;"></i>
                            </div>
                            <span style="font-weight:500; color:#111827;">{{ $msg->name }}</span>
                        </div>
                    </td>
                    <td>
                        <a href="mailto:{{ $msg->email }}" style="color:#3b82f6; text-decoration:none; font-size:12px;">
                            <i class="fas fa-envelope" style="font-size:10px; margin-right:4px;"></i>
                            {{ $msg->email }}
                        </a>
                    </td>
                    <td>
                        <div style="font-size:13px; color:#4b5563; line-height:1.4; max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ Str::limit($msg->message, 50) }}
                        </div>
                    </td>
                    <td style="text-align:center; font-size:12px; color:#6b7280;">
                        <div>{{ $msg->created_at->format('d M Y') }}</div>
                        <div style="font-size:10px; color:#9ca3af;">{{ $msg->created_at->format('H:i') }}</div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            {{-- Tombol Detail --}}
                            <button type="button" class="btn btn-sm btn-edit"
                                onclick="openDetailMessage('{{ addslashes($msg->name) }}', '{{ addslashes($msg->email) }}', '{{ addslashes($msg->message) }}', '{{ $msg->created_at->format('d M Y H:i') }}')">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                            
                            {{-- Tombol Hapus --}}
                            <button type="button" class="btn btn-sm btn-delete"
                                onclick="confirmDeleteMessage({{ $msg->id }}, '{{ addslashes($msg->name) }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('search'))
                            Pesan "{{ request('search') }}" tidak ditemukan.
                        @else
                            <div class="empty-state">
                                <div class="icon">📭</div>
                                <h3>Belum Ada Pesan Masuk</h3>
                                <p>Pesan dari pelanggan akan muncul di sini.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($messages->hasPages())
    <div class="pagination-wrapper">
        {{ $messages->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- ── MODAL DETAIL ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-detail-message">
    <div class="modal" style="max-width: 520px;">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-envelope" style="color:#1b4332;"></i>
                Detail Pesan
            </div>
            <button class="modal-close" onclick="closeModal('modal-detail-message')">&times;</button>
        </div>
        <div class="modal-body">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label style="font-weight:600; color:#374151; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Nama</label>
                    <div style="padding:8px 12px; background:#f3f4f6; border-radius:6px; font-size:14px; font-weight:500; color:#111827;" id="detail-name">-</div>
                </div>
            </div>
            <div style="margin-top:12px;">
                <label style="font-weight:600; color:#374151; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Email</label>
                <div style="padding:8px 12px; background:#f3f4f6; border-radius:6px; font-size:14px; color:#3b82f6;" id="detail-email">-</div>
            </div>
            <div style="margin-top:12px;">
                <label style="font-weight:600; color:#374151; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Tanggal</label>
                <div style="padding:8px 12px; background:#f3f4f6; border-radius:6px; font-size:13px; color:#6b7280;" id="detail-date">-</div>
            </div>
            <div style="margin-top:12px;">
                <label style="font-weight:600; color:#374151; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Pesan</label>
                <div style="padding:12px; background:#f9fafb; border-radius:6px; font-size:14px; line-height:1.6; white-space:pre-wrap; min-height:80px; border:1px solid #e5e7eb; color:#1f2937;" id="detail-message">-</div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-detail-message')" style="border-radius:30px; padding:6px 20px; font-size:12px; cursor:pointer;">
                <i class="fas fa-times"></i> Tutup
            </button>
        </div>
    </div>
</div>

{{-- ── MODAL DELETE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-delete-message">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Pesan?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus pesan dari <strong id="delete-message-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;">Tindakan ini tidak dapat dibatalkan!</span>
            </div>
            <form id="delete-message-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-message')" style="border-radius:30px; padding:6px 16px; font-size:12px; cursor:pointer;">
                    Batal
                </button>
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
// ── MODAL FUNCTIONS ──
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

// ── DETAIL ──
function openDetailMessage(name, email, message, date) {
    document.getElementById('detail-name').textContent = name;
    document.getElementById('detail-email').textContent = email;
    document.getElementById('detail-message').textContent = message;
    document.getElementById('detail-date').textContent = date;
    
    openModal('modal-detail-message');
}

// ── DELETE ──
function confirmDeleteMessage(id, name) {
    document.getElementById('delete-message-form').action = '/admin/contacts/' + id;
    document.getElementById('delete-message-name').textContent = name;
    openModal('modal-delete-message');
}

// ── AUTO CLOSE TOAST ──
document.addEventListener('DOMContentLoaded', function() {
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
});

console.log('✅ Halaman Pesan Kontak siap digunakan!');
</script>
@endpush