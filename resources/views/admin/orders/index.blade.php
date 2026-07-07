@extends('layouts.admin')
@section('title', 'Riwayat Pesanan')
@section('page-title', 'Riwayat Pesanan')

@section('content')

<style>
    .breadcrumb-admin {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 20px;
        flex-wrap: wrap;
        padding: 8px 0;
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
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-warning { background: #fef9c3; color: #854d0e; }
    .badge-info { background: #dbeafe; color: #1e40af; }
    .badge-secondary { background: #f1f5f9; color: #475569; }

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

    .filter-wrapper {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: flex-end;
        padding: 12px 20px;
        background: #fafafa;
        border-bottom: 1px solid #e5e7eb;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .filter-group label {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .filter-group input,
    .filter-group select {
        padding: 5px 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 12px;
        height: 32px;
        outline: none;
        background: white;
        transition: all 0.2s;
        min-width: 150px;
    }
    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #1b4332;
        box-shadow: 0 0 0 2px rgba(27, 67, 50, 0.1);
    }
    .filter-actions {
        display: flex;
        gap: 6px;
        align-items: center;
        padding-bottom: 2px;
    }
    .filter-actions .btn {
        height: 32px;
    }

    .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table-wrap table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 1100px;
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

    .btn-print-disabled {
        background: #9ca3af;
        color: white;
        border-radius: 30px;
        padding: 4px 10px;
        font-size: 10px;
        height: 26px;
        cursor: not-allowed;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        opacity: 0.6;
        pointer-events: none;
        text-decoration: none;
        min-width: 50px;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .card-header { flex-direction: column; align-items: flex-start; }
        .filter-wrapper { flex-direction: column; align-items: stretch; }
        .filter-group input, .filter-group select { min-width: 100%; }
        .filter-actions { flex-wrap: wrap; }
        .table-wrap table { font-size: 12px; min-width: 700px; }
        th, td { padding: 8px 10px; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .breadcrumb-admin { font-size: 12px; }
        .action-buttons { flex-wrap: wrap; }
        .action-buttons .btn { flex: 0 0 auto; font-size: 10px; padding: 3px 8px; height: 26px; min-width: 45px; border-radius: 30px !important; }
    }

    @media (max-width: 480px) {
        .table-wrap table { font-size: 11px; min-width: 500px; }
        th, td { padding: 6px 8px; }
        .card-header { padding: 12px 16px; }
        .card-title { font-size: 14px; }
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
        .stat-value { font-size: 20px; }
        .breadcrumb-admin { font-size: 11px; }
        .action-buttons { flex-direction: column; width: 100%; }
        .action-buttons .btn { width: 100%; flex: none; font-size: 10px; padding: 4px 10px; height: 28px; justify-content: center; border-radius: 30px !important; }
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }
    .empty-state .icon { font-size: 40px; margin-bottom: 8px; opacity: 0.5; }
    .empty-state h3 { font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 4px; }
    .empty-state p { font-size: 13px; color: #6b7280; }

    .pagination-wrapper {
        padding: 12px 16px;
        border-top: 1px solid #e5e7eb;
    }

    @media (prefers-color-scheme: dark) {
        .card { background: #1f2937; border-color: #374151; }
        .card-header { background: #111827; border-color: #374151; }
        .card-title { color: #f3f4f6; }
        .stat-card { background: #1f2937; border-color: #374151; }
        .stat-label { color: #9ca3af; }
        .stat-value { color: #f3f4f6; }
        .stat-sub { color: #9ca3af; }
        .filter-wrapper { background: #111827; border-color: #374151; }
        .filter-group label { color: #9ca3af; }
        .filter-group input, .filter-group select { background: #1f2937; border-color: #374151; color: #f3f4f6; }
        .filter-group input:focus, .filter-group select:focus { border-color: #d4a373; }
        .table-wrap th { background: #111827; color: #e5e7eb; border-color: #374151; }
        .table-wrap td { border-color: #374151; color: #e5e7eb; }
        .table-wrap tbody tr:hover { background-color: #111827; }
        .empty-state h3 { color: #f3f4f6; }
        .empty-state p { color: #9ca3af; }
        .breadcrumb-admin { color: #9ca3af; }
        .breadcrumb-admin a { color: #9ca3af; }
        .breadcrumb-admin a:hover { color: #d4a373; }
        .breadcrumb-admin .current { color: #d4a373; }
        .breadcrumb-admin .separator { color: #4b5563; }
    }
</style>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <i class="fas fa-history" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Riwayat Pesanan</span>
</div>

{{-- ── STATS ── --}}
<div class="stats-grid">
    @php
    $allOrders = \App\Models\Order::get();
    $totalOrders = $allOrders->count();
    $totalRevenue = $allOrders->sum('total');
    $completedOrders = $allOrders->where('order_status', 'selesai')->count();
    $pendingOrders = $allOrders->where('order_status', 'menunggu')->count();
    @endphp

    <div class="stat-card">
        <div class="stat-label"><i class="fas fa-receipt" style="color: #1b4332;"></i> Total Pesanan</div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-sub">Semua pesanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-label"><i class="fas fa-money-bill-wave" style="color: #16a34a;"></i> Total Pendapatan</div>
        <div class="stat-value" style="color: #16a34a;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-sub">Total semua pesanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-label"><i class="fas fa-check-circle" style="color: #3b82f6;"></i> Selesai</div>
        <div class="stat-value" style="color: #3b82f6;">{{ $completedOrders }}</div>
        <div class="stat-sub">Pesanan selesai</div>
    </div>
    <div class="stat-card">
        <div class="stat-label"><i class="fas fa-clock" style="color: #f59e0b;"></i> Menunggu</div>
        <div class="stat-value" style="color: #f59e0b;">{{ $pendingOrders }}</div>
        <div class="stat-sub">Pesanan pending</div>
    </div>
</div>

{{-- ── CARD ── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-history" style="color: #1b4332; margin-right:8px;"></i>
            Riwayat Pesanan
        </div>
    </div>

    <div class="filter-wrapper">
        <form method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; width:100%;">
            <div class="filter-group">
                <label><i class="fas fa-search"></i> Cari</label>
                <input type="text" name="search" placeholder="ID atau Pelanggan..." value="{{ request('search') }}" style="min-width:180px;">
            </div>

            <div class="filter-group">
                <label><i class="fas fa-tag"></i> Status Pesanan</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                </select>
            </div>

            <div class="filter-group">
                <label><i class="fas fa-credit-card"></i> Status Bayar</label>
                <select name="payment_status">
                    <option value="">Semua</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>✅ Lunas</option>
                    <option value="dibatalkan" {{ request('payment_status') == 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                </select>
            </div>

            <div class="filter-group">
                <label><i class="fas fa-wallet"></i> Metode</label>
                <select name="payment_method">
                    <option value="">Semua</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>💵 Tunai</option>
                    <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>📱 QRIS</option>
                </select>
            </div>

            <div class="filter-group">
                <label><i class="fas fa-calendar-alt"></i> Dari</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-calendar-alt"></i> Sampai</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}">
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
                @if(request('search') || request('status') || request('payment_status') || request('payment_method') || request('start_date') || request('end_date'))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">#</th>
                    <th>ID Transaksi</th>
                    <th>Meja</th>
                    <th>Pelanggan</th>
                    <th style="text-align:right;">Total</th>
                    <th style="text-align:center;">Pembayaran</th>
                    <th style="text-align:center;">Status Bayar</th>
                    <th style="text-align:center;">Status Pesanan</th>
                    <th style="text-align:center;">Tanggal</th>
                    <th class="no-sort" style="text-align:center; min-width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr>
                    <td style="text-align:center; color:#6b7280;">{{ $orders->firstItem() + $index }}</td>
                    <td>
                        <span style="font-family:monospace; font-size:11px; background:#f3f4f6; padding:2px 8px; border-radius:4px; color:#374151;">
                            {{ $order->transaction_id }}
                        </span>
                    </td>
                    <td><i class="fas fa-chair" style="color:#1b4332; font-size:12px; margin-right:4px;"></i> Meja {{ $order->table->number }}</td>
                    <td><i class="fas fa-user" style="color:#6b7280; font-size:12px; margin-right:4px;"></i> {{ $order->customer_name }}</td>
                    <td style="text-align:right; font-weight:600; color:#1b4332;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td style="text-align:center; font-size:12px;">
                        @if($order->payment_method === 'cash')
                            <span class="badge badge-secondary"><i class="fas fa-money-bill"></i> Tunai</span>
                        @elseif($order->payment_method === 'qris')
                            <span class="badge badge-info"><i class="fas fa-qrcode"></i> QRIS</span>
                        @else
                            <span class="badge badge-secondary">-</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @if($order->payment_status === 'paid')
                            <span class="badge badge-success"><i class="fas fa-check"></i> Lunas</span>
                        @elseif($order->payment_status === 'dibatalkan')
                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Dibatalkan</span>
                        @else
                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Belum Bayar</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @if($order->order_status === 'selesai')
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @elseif($order->order_status === 'dibatalkan')
                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Dibatalkan</span>
                        @elseif($order->order_status === 'diproses')
                            <span class="badge badge-info"><i class="fas fa-spinner"></i> Diproses</span>
                        @else
                            <span class="badge badge-warning"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                        @endif
                    </td>
                    <td style="text-align:center; font-size:12px; color:#6b7280;">
                        <div>{{ $order->created_at->format('d M Y') }}</div>
                        <div style="font-size:10px; color:#9ca3af;">{{ $order->created_at->format('H:i') }}</div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm" style="background:#3b82f6; color:white; border-radius:30px; padding:4px 10px; font-size:10px; height:26px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:4px;">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            
                            {{-- 🔥 PERBAIKAN: Cetak HANYA jika payment_status === 'paid' --}}
                            @if($order->payment_status === 'paid')
                                <a href="{{ route('admin.orders.print', $order) }}" class="btn btn-sm" style="background:#d4a373; color:white; border-radius:30px; padding:4px 10px; font-size:10px; height:26px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:4px;">
                                    <i class="fas fa-print"></i> Cetak
                                </a>
                            @else
                                <span class="btn-print-disabled">
                                    <i class="fas fa-print"></i> Cetak
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('search') || request('status') || request('payment_status') || request('payment_method') || request('start_date') || request('end_date'))
                            <div class="empty-state">
                                <div class="icon">🔍</div>
                                <h3>Tidak Ditemukan</h3>
                                <p>Tidak ada pesanan dengan filter yang dipilih. Coba ubah kriteria pencarian.</p>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="icon">📋</div>
                                <h3>Belum Ada Pesanan</h3>
                                <p>Pesanan akan muncul di sini setelah pelanggan melakukan pemesanan.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
    <div class="pagination-wrapper">
        {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- ── TOAST ── --}}
@if(session('success'))
<div class="toast-notification toast-success" id="toast-success" style="position:fixed;bottom:24px;right:24px;z-index:99999;padding:12px 20px;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,0.15);display:flex;align-items:center;gap:10px;animation:slideUp 0.3s ease;max-width:400px;font-size:14px;background:#0e6446;color:white;">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
    <button class="toast-close" onclick="this.parentElement.remove()" style="background:none;border:none;color:white;font-size:18px;cursor:pointer;margin-left:6px;opacity:0.8;padding:0 4px;">&times;</button>
</div>
@endif

@if(session('error'))
<div class="toast-notification toast-error" id="toast-error" style="position:fixed;bottom:24px;right:24px;z-index:99999;padding:12px 20px;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,0.15);display:flex;align-items:center;gap:10px;animation:slideUp 0.3s ease;max-width:400px;font-size:14px;background:#dc2626;color:white;">
    <i class="fas fa-exclamation-circle"></i>
    <span>{{ session('error') }}</span>
    <button class="toast-close" onclick="this.parentElement.remove()" style="background:none;border:none;color:white;font-size:18px;cursor:pointer;margin-left:6px;opacity:0.8;padding:0 4px;">&times;</button>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toast-notification').forEach(function(toast) {
        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(function() { if (toast.parentElement) toast.remove(); }, 300);
        }, 3000);
    });

    document.querySelectorAll('select[name="status"], select[name="payment_status"], select[name="payment_method"]').forEach(function(select) {
        select.addEventListener('change', function() { this.closest('form').submit(); });
    });
    document.querySelectorAll('input[type="date"]').forEach(function(input) {
        input.addEventListener('change', function() { this.closest('form').submit(); });
    });
});
</script>
@endpush