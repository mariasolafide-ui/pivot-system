{{-- resources/views/admin/waiter-calls/index.blade.php --}}

@extends('layouts.admin')
@section('title', 'Waiter Calls')
@section('page-title', 'Panggilan Pelayan')

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
    .btn-success {
        background: #16a34a;
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
    .btn-success:hover {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
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
        max-width: 400px;
    }

    .modal-sm {
        max-width: 400px;
    }

    .modal-body {
        padding: 24px;
        overflow-y: auto;
        max-height: calc(90vh - 130px);
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
    <i class="fas fa-bell" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Panggilan Pelayan</span>
</div>

{{-- ── STATS ─────────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    @php
    $totalCalls = $calls->total();
    $pendingCalls = $calls->filter(fn($c) => $c->status === 'pending')->count();
    $todayCalls = $calls->filter(fn($c) => $c->created_at->isToday())->count();
    $completedCalls = $calls->filter(fn($c) => $c->status === 'done')->count();
    @endphp

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-bell" style="color: #1b4332;"></i>
            Total Panggilan
        </div>
        <div class="stat-value">{{ $totalCalls }}</div>
        <div class="stat-sub">Semua panggilan</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-clock" style="color: #f59e0b;"></i>
            Menunggu
        </div>
        <div class="stat-value" style="color: #f59e0b;">{{ $pendingCalls }}</div>
        <div class="stat-sub">Belum ditangani</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-calendar-day" style="color: #3b82f6;"></i>
            Hari Ini
        </div>
        <div class="stat-value" style="color: #3b82f6;">{{ $todayCalls }}</div>
        <div class="stat-sub">Panggilan hari ini</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-check-circle" style="color: #16a34a;"></i>
            Selesai
        </div>
        <div class="stat-value" style="color: #16a34a;">{{ $completedCalls }}</div>
        <div class="stat-sub">Sudah ditangani</div>
    </div>
</div>

{{-- ── CARD ─────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-bell" style="color: #f59e0b; margin-right:8px;"></i>
            Semua Panggilan Pelayan
        </div>
        
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <span style="font-size:12px; color:#6b7280; background:#f3f4f6; padding:4px 12px; border-radius:30px;">
                <i class="fas fa-sync-alt fa-fw"></i> Auto-refresh 10s
            </span>
            
            {{-- Filter Status --}}
            <form action="{{ url()->current() }}" method="GET" style="display:flex; align-items:center; gap:4px; margin:0;">
                <select name="status" style="padding:5px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:12px; height:32px; outline:none; background:white;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Selesai</option>
                </select>
                <button type="submit" class="btn btn-secondary btn-sm" style="height:32px;">
                    <i class="fas fa-filter"></i>
                </button>
                @if(request('status'))
                    <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm" style="height:32px;">
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
                    <th>Meja</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th class="no-sort" style="text-align:center; min-width:180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calls as $index => $call)
                <tr>
                    <td style="text-align:center; color:#6b7280;">{{ $calls->firstItem() + $index }}</td>
                    <td style="font-weight:600;">
                        <i class="fas fa-chair" style="color:#1b4332;margin-right:6px;"></i>
                        Meja {{ $call->table->number }}
                    </td>
                    <td>
                        @if($call->status === 'pending')
                            <span class="badge badge-warning">
                                <i class="fas fa-clock" style="font-size:10px;"></i> Menunggu
                            </span>
                        @elseif($call->status === 'done')
                            <span class="badge badge-success">
                                <i class="fas fa-check" style="font-size:10px;"></i> Selesai
                            </span>
                        @endif
                    </td>
                    <td style="font-size:12px;">
                        <i class="far fa-calendar-alt" style="margin-right:4px;"></i>
                        {{ $call->created_at->format('d/m/Y H:i') }}
                        <span style="color:#6b7280;font-size:10px;">
                            ({{ $call->created_at->diffForHumans() }})
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            @if($call->status === 'pending')
                                <form action="{{ route('admin.waiter-calls.done', $call) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                </form>
                            @endif
                            
                            <button type="button" class="btn btn-sm btn-delete"
                                onclick="confirmDeleteCall({{ $call->id }}, 'Meja {{ $call->table->number }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('status'))
                            Tidak ada panggilan dengan status "{{ request('status') }}".
                        @else
                            <div class="empty-state">
                                <div class="icon">🔔</div>
                                <h3>Belum Ada Panggilan Pelayan</h3>
                                <p>Panggilan dari pelanggan akan muncul di sini secara real-time.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($calls->hasPages())
    <div class="pagination-wrapper">
        {{ $calls->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- ── MODAL DELETE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-delete-call">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Panggilan?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus panggilan dari <strong id="delete-call-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;">Tindakan ini tidak dapat dibatalkan!</span>
            </div>
            <form id="delete-call-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-call')" style="border-radius:30px; background:#f3f4f6; color:#4b5563; border:1px solid #d1d5db; padding:5px 16px; font-size:12px; cursor:pointer;">
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

// ── DELETE ──
function confirmDeleteCall(id, tableName) {
    document.getElementById('delete-call-form').action = '/admin/waiter-calls/' + id;
    document.getElementById('delete-call-name').textContent = tableName;
    openModal('modal-delete-call');
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

// ── AUTO REFRESH ──
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

// ── INIT ──
document.addEventListener('DOMContentLoaded', function() {
    startAutoRefresh();

    @if(session('success'))
        showToast('success', 'Berhasil', @json(session('success')));
    @endif

    @if(session('error'))
        showToast('error', 'Gagal', @json(session('error')));
    @endif
});

console.log('✅ Halaman Waiter Calls siap digunakan!');
</script>
@endpush