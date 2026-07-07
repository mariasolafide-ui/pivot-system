@extends('layouts.admin')
@section('title', 'Feedback')
@section('page-title', 'Feedback Pelanggan')

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
        max-width: 480px;
    }

    .modal-sm {
        max-width: 400px;
    }

    .modal-body {
        padding: 24px 20px;
        overflow-y: auto;
        max-height: calc(90vh - 130px);
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
        .modal {
            background: #1f2937;
        }
    }
</style>

{{-- ── BREADCRUMB (DI BAWAH BACK LINK) ── --}}
<div class="breadcrumb-admin">
    <i class="fas fa-comment-dots" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Feedback</span>
</div>

{{-- ── STATS ─────────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    @php
    $totalFeedbacks = $feedbacks->total();
    $avgRating = $feedbacks->avg('rating') ?? 0;
    $rating5 = $feedbacks->filter(fn($f) => $f->rating == 5)->count();
    $rating4 = $feedbacks->filter(fn($f) => $f->rating == 4)->count();
    @endphp

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-comment-dots" style="color: #1b4332;"></i>
            Total Feedback
        </div>
        <div class="stat-value">{{ $totalFeedbacks }}</div>
        <div class="stat-sub">Feedback terkirim</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-star" style="color: #d97706;"></i>
            Rating Rata-rata
        </div>
        <div class="stat-value" style="color: #d97706;">{{ number_format($avgRating, 1) }}</div>
        <div class="stat-sub">Dari 5 bintang</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-star" style="color: #16a34a;"></i>
            Rating 5 Bintang
        </div>
        <div class="stat-value" style="color: #16a34a;">{{ $rating5 }}</div>
        <div class="stat-sub">Sangat puas</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <i class="fas fa-star" style="color: #3b82f6;"></i>
            Rating 4 Bintang
        </div>
        <div class="stat-value" style="color: #3b82f6;">{{ $rating4 }}</div>
        <div class="stat-sub">Puas</div>
    </div>
</div>

{{-- ── CARD ─────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-star" style="color: #d97706; margin-right:8px;"></i>
            Semua Feedback
        </div>
        
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            {{-- Pencarian --}}
            <form action="{{ url()->current() }}" method="GET" style="display:flex; align-items:center; gap:4px; margin:0;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari pelanggan..." 
                       style="padding:5px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:12px; width:160px; outline:none; height:32px;">
                <button type="submit" class="btn btn-secondary btn-sm" style="height:32px; border-radius:30px; background:#f3f4f6; color:#4b5563; border:1px solid #d1d5db; padding:5px 16px; font-size:12px; cursor:pointer;">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm" style="height:32px; border-radius:30px; background:#f3f4f6; color:#4b5563; border:1px solid #d1d5db; padding:5px 16px; font-size:12px; cursor:pointer;">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">#</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Pesanan</th>
                    <th>Meja</th>
                    <th>Tanggal</th>
                    <th class="no-sort" style="text-align:center; min-width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $index => $fb)
                <tr>
                    <td style="text-align:center; color:#6b7280;">{{ $feedbacks->firstItem() + $index }}</td>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color:{{ $i <= $fb->rating ? '#d97706' : '#d7d7d7' }}">&#9733;</span>
                        @endfor
                        <span style="font-size:12px;color:#6b7280;margin-left:4px">({{ $fb->rating }}/5)</span>
                    </td>
                    <td style="max-width:200px">{{ $fb->comment ?? '—' }}</td>
                    <td style="font-size:12px;font-family:monospace">
                        <a href="{{ route('admin.orders.show', $fb->order) }}" style="color:#1b4332;text-decoration:none;">
                            <i class="fas fa-receipt" style="font-size:10px;"></i>
                            {{ $fb->order->transaction_id }}
                        </a>
                        <!-- Tambahan kecil agar admin tahu nama pelanggan yang dicari -->
                        <div style="font-size:11px; color:#6b7280; font-family:sans-serif; margin-top:2px;">
                            Asal: {{ $fb->order->customer_name }}
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-secondary">
                            <i class="fas fa-chair" style="font-size:10px;"></i>
                            Meja {{ $fb->order->table->number }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#6b7280;">
                        <i class="far fa-calendar-alt" style="margin-right:4px;"></i>
                        {{ $fb->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-sm btn-delete"
                                onclick="confirmDeleteFeedback({{ $fb->id }}, '{{ addslashes($fb->order->transaction_id) }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('search'))
                            Feedback "{{ request('search') }}" tidak ditemukan.
                        @else
                            <div class="empty-state">
                                <div class="icon">💬</div>
                                <h3>Belum Ada Feedback</h3>
                                <p>Feedback dari pelanggan akan muncul di sini setelah mereka memberikan penilaian.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($feedbacks->hasPages())
    <div class="pagination-wrapper" style="padding:12px 16px; border-top:1px solid #e5e7eb;">
        {{ $feedbacks->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- ── MODAL DELETE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-delete-feedback">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Feedback?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus feedback dari pesanan <strong id="delete-feedback-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;">Tindakan ini tidak dapat dibatalkan!</span>
            </div>
            <form id="delete-feedback-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-feedback')" style="border-radius:30px; background:#f3f4f6; color:#4b5563; border:1px solid #d1d5db; padding:5px 16px; font-size:12px; cursor:pointer;">
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
function confirmDeleteFeedback(id, transactionId) {
    document.getElementById('delete-feedback-form').action = '/admin/feedback/' + id;
    document.getElementById('delete-feedback-name').textContent = transactionId;
    openModal('modal-delete-feedback');
}

// ── TOAST ──
function showToast(type, title, message) {
    const container = document.getElementById('toast-container');
    if (!container) return;
    
    // Hapus semua toast yang ada (CEGAH DOUBLE)
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
});

console.log('✅ Halaman Feedback siap digunakan!');
</script>
@endpush