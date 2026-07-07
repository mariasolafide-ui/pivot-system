@extends('layouts.admin')

@section('title', 'Monitor Pesanan')
@section('page-title', 'Monitor Pesanan')

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

    :root {
        --pos-bg: #f8fafc;
        --pos-card-bg: #ffffff;
        --pos-text-main: #0f172a;
        --pos-text-muted: #64748b;
        --pos-border: #e2e8f0;
        --pos-brand-primary: #1b4332;
        --pos-brand-accent: #d4a373;
        --status-wait-bg: #fef3c7;
        --status-wait-text: #b45309;
        --status-process-bg: #dcfce7;
        --status-process-text: #15803d;
        --status-unpaid-bg: #fee2e2;
        --status-unpaid-text: #b91c1c;
        --status-paid-bg: #e0f2fe;
        --status-paid-text: #0369a1;
    }

    .pos-stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }
    .pos-stat-card {
        background: var(--pos-card-bg);
        border: 1px solid var(--pos-border);
        padding: 10px 14px;
        border-radius: 10px;
    }
    .pos-stat-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--pos-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .pos-stat-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--pos-text-main);
        margin-top: 2px;
    }

    /* ── GRID CARD ── */
    .monitor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 14px;
    }

    /* ── CARD DENGAN HEIGHT SAMA ── */
    .order-box-compact {
        background: var(--pos-card-bg);
        border: 1px solid var(--pos-border);
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%; /* ← PASTIKAN HEIGHT SAMA */
        min-height: 0;
    }
    .order-box-compact:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px -3px rgba(0, 0, 0, 0.05);
    }

    .order-box-compact.status-menunggu { border-left: 4px solid var(--pos-brand-accent); }
    .order-box-compact.status-diproses { border-left: 4px solid var(--pos-brand-primary); }

    /* ── BOX TOP ── */
    .box-top-section {
        padding: 12px 14px 8px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 4px;
    }
    .card-meja {
        font-weight: 900;
        font-size: 15px;
        color: var(--pos-text-main);
        letter-spacing: -0.3px;
        line-height: 1.2;
    }
    .card-customer {
        font-weight: 600;
        font-size: 11px;
        color: var(--pos-text-muted);
    }
    .card-badges {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 3px;
        flex-shrink: 0;
        margin-left: 8px;
    }
    .meta-badge-sm {
        font-size: 9px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 50px;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-status-menunggu { background: var(--status-wait-bg); color: var(--status-wait-text); }
    .badge-status-diproses { background: var(--status-process-bg); color: var(--status-process-text); }
    .badge-pay-pending { background: var(--status-unpaid-bg); color: var(--status-unpaid-text); }
    .badge-pay-paid { background: var(--status-paid-bg); color: var(--status-paid-text); }

    .card-trans-id {
        font-size: 9px;
        font-family: monospace;
        color: var(--pos-text-muted);
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 4px;
        margin-bottom: 6px;
    }

    /* ── ITEMS ── */
    .items-container {
        flex: 1;
        overflow: hidden;
    }
    .item-compact-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 11px;
        padding: 3px 0;
        color: var(--pos-text-main);
        border-bottom: 1px solid #f5f7fa;
    }
    .item-compact-row:last-child {
        border-bottom: none;
    }
    .item-qty-badge {
        font-weight: 800;
        color: var(--pos-brand-primary);
        background: #f1f5f9;
        padding: 1px 5px;
        border-radius: 4px;
        margin-right: 5px;
        font-size: 9px;
    }
    .item-name {
        font-weight: 500;
        font-size: 11px;
    }
    .item-price {
        font-weight: 700;
        color: var(--pos-text-main);
        font-size: 11px;
        flex-shrink: 0;
        margin-left: 8px;
    }
    .item-notes-mini {
        font-size: 9px;
        color: #c2410c;
        background: #fffbeb;
        padding: 1px 6px;
        border-radius: 4px;
        border: 1px solid #fef3c7;
        margin-top: 2px;
        display: inline-block;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .order-notes-mini {
        font-size: 10px;
        background: #f8fafc;
        border-radius: 4px;
        padding: 4px 8px;
        color: var(--pos-text-main);
        border: 1px solid var(--pos-border);
        margin-top: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .order-notes-mini strong {
        font-weight: 600;
    }

    /* ── BOX BOTTOM ── */
    .box-bottom-section {
        padding: 8px 14px 12px;
        background: #f8fafc;
        border-top: 1px solid var(--pos-border);
        flex-shrink: 0;
    }

    .meta-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 9px;
        color: var(--pos-text-muted);
        font-weight: 500;
        margin-bottom: 4px;
    }
    .meta-footer .payment-badge {
        font-weight: 700;
        background: #ffffff;
        border: 1px solid var(--pos-border);
        padding: 1px 6px;
        border-radius: 4px;
        font-size: 9px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 4px;
        border-top: 1px solid var(--pos-border);
        margin-bottom: 6px;
    }
    .total-label {
        font-size: 10px;
        font-weight: 700;
        color: var(--pos-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .total-value {
        font-size: 15px;
        font-weight: 900;
        color: var(--pos-text-main);
    }

    /* ── TOMBOL ── */
    .btn-compact {
        padding: 4px 10px;
        font-size: 10px;
        font-weight: 700;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: background 0.15s ease;
        white-space: nowrap;
        height: 28px;
    }
    .btn-flex { flex: 1; }
    .btn-compact-brand { background: var(--pos-brand-primary); color: #ffffff; }
    .btn-compact-brand:hover { background: #133024; }
    .btn-compact-danger { background: #ef4444; color: #ffffff; }
    .btn-compact-danger:hover { background: #dc2626; }
    .btn-compact-muted { background: #ffffff; color: var(--pos-text-main); border: 1px solid var(--pos-border); }
    .btn-compact-muted:hover { background: #f1f5f9; }
    .btn-compact-success { background: #16a34a; color: #ffffff; }
    .btn-compact-success:hover { background: #15803d; }

    .action-row {
        display: flex;
        gap: 4px;
        align-items: center;
        flex-wrap: wrap;
    }

    /* ── HEADER ── */
    .monitor-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        background: #ffffff;
        padding: 10px 16px;
        border-radius: 10px;
        border: 1px solid var(--pos-border);
    }
    .monitor-header-left h4 {
        margin: 0;
        font-weight: 800;
        color: var(--pos-text-main);
        font-size: 15px;
    }
    .monitor-header-left p {
        font-size: 11px;
        color: var(--pos-text-muted);
        margin: 1px 0 0 0;
    }
    .monitor-header-right {
        text-align: right;
    }
    .monitor-header-right .refresh-badge {
        font-size: 9px;
        background: #f1f5f9;
        color: var(--pos-text-muted);
        padding: 2px 10px;
        border-radius: 50px;
        font-weight: 600;
        display: inline-block;
    }
    .monitor-header-right .auto-refresh {
        font-size: 9px;
        color: var(--pos-text-muted);
        margin-top: 1px;
    }

    .empty-state {
        border: 2px dashed var(--pos-border);
        background: #ffffff;
        text-align: center;
        padding: 30px 20px;
        border-radius: 12px;
    }
    .empty-state p {
        font-weight: 600;
        color: var(--pos-text-muted);
        font-size: 13px;
    }

    /* ── MODAL ── */
    .modal-overlay-flat {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6); display: none; align-items: center; justify-content: center; z-index: 9999;
        backdrop-filter: blur(4px);
    }
    .modal-content-flat {
        background: #ffffff; padding: 20px 24px; border-radius: 16px; max-width: 380px; width: 90%;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }
    .modal-content-flat .modal-title {
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 6px;
        color: #ef4444;
    }
    .modal-content-flat .modal-desc {
        font-size: 12px;
        color: var(--pos-text-muted);
        margin-bottom: 16px;
        line-height: 1.5;
    }
    .modal-content-flat .modal-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    @media (max-width: 768px) {
        .monitor-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 12px;
        }
        .pos-stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
        .monitor-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
        .monitor-header-right {
            text-align: left;
            width: 100%;
        }
        .action-row .btn-compact {
            font-size: 9px;
            padding: 3px 8px;
            height: 24px;
        }
    }

    @media (max-width: 480px) {
        .monitor-grid {
            grid-template-columns: 1fr;
        }
        .pos-stats-container {
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .pos-stat-value {
            font-size: 17px;
        }
        .card-meja {
            font-size: 14px;
        }
        .total-value {
            font-size: 14px;
        }
        .action-row {
            flex-wrap: wrap;
        }
        .action-row .btn-compact {
            flex: 1;
            min-width: 50px;
            font-size: 9px;
            padding: 3px 6px;
            height: 22px;
        }
    }

    @media (prefers-color-scheme: dark) {
        .breadcrumb-admin { color: #9ca3af; }
        .breadcrumb-admin a { color: #9ca3af; }
        .breadcrumb-admin a:hover { color: #d4a373; }
        .breadcrumb-admin .current { color: #d4a373; }
        .breadcrumb-admin .separator { color: #4b5563; }
        .monitor-header { background: #1f2937; border-color: #374151; }
        .monitor-header-left h4 { color: #f3f4f6; }
        .monitor-header-left p { color: #9ca3af; }
        .monitor-header-right .refresh-badge { background: #374151; color: #9ca3af; }
        .monitor-header-right .auto-refresh { color: #9ca3af; }
        .order-box-compact { background: #1f2937; border-color: #374151; }
        .card-meja { color: #f3f4f6; }
        .card-customer { color: #9ca3af; }
        .card-trans-id { color: #9ca3af; border-color: #374151; }
        .item-compact-row { color: #e5e7eb; border-color: #374151; }
        .item-qty-badge { background: #374151; color: #d4a373; }
        .item-price { color: #f3f4f6; }
        .item-notes-mini { background: #422b00; border-color: #92400e; color: #fbbf24; }
        .order-notes-mini { background: #111827; border-color: #374151; color: #e5e7eb; }
        .box-bottom-section { background: #111827; border-color: #374151; }
        .total-row { border-color: #374151; }
        .total-label { color: #9ca3af; }
        .total-value { color: #f3f4f6; }
        .meta-footer { color: #9ca3af; }
        .meta-footer .payment-badge { background: #1f2937; border-color: #374151; color: #e5e7eb; }
        .btn-compact-muted { background: #1f2937; color: #e5e7eb; border-color: #374151; }
        .btn-compact-muted:hover { background: #374151; }
        .pos-stat-card { background: #1f2937; border-color: #374151; }
        .pos-stat-label { color: #9ca3af; }
        .pos-stat-value { color: #f3f4f6; }
        .modal-content-flat { background: #1f2937; }
        .modal-content-flat .modal-desc { color: #9ca3af; }
        .empty-state { background: #1f2937; border-color: #374151; }
        .empty-state p { color: #9ca3af; }
    }
</style>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <i class="fas fa-desktop" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Monitor Pesanan</span>
</div>

{{-- ── HEADER ── --}}
<div class="monitor-header">
    <div class="monitor-header-left">
        <h4>Live Order Monitor</h4>
        <p>Daftar antrean dapur &amp; meja kasir real-time</p>
    </div>
    <div class="monitor-header-right">
        <span class="refresh-badge" id="last-refresh">🔄 Terakhir: baru saja</span>
        <div class="auto-refresh">Auto-refresh 10 detik</div>
    </div>
</div>

{{-- ── STATS ── --}}
<div class="pos-stats-container">
    <div class="pos-stat-card">
        <div class="pos-stat-label">Menunggu</div>
        <div class="pos-stat-value" style="color:var(--pos-brand-accent);">{{ $orders->where('order_status', 'menunggu')->count() }}</div>
    </div>
    <div class="pos-stat-card">
        <div class="pos-stat-label">Diproses</div>
        <div class="pos-stat-value" style="color:var(--pos-brand-primary);">{{ $orders->where('order_status', 'diproses')->count() }}</div>
    </div>
    <div class="pos-stat-card">
        <div class="pos-stat-label">Belum Bayar</div>
        <div class="pos-stat-value" style="color:#ef4444;">{{ $orders->where('payment_status', 'pending')->count() }}</div>
    </div>
    <div class="pos-stat-card">
        <div class="pos-stat-label">Total Aktif</div>
        <div class="pos-stat-value">{{ $orders->count() }}</div>
    </div>
</div>

@if($orders->isEmpty())
    <div class="empty-state">
        <p>✅ Kondisi aman. Tidak ada antrean pesanan aktif saat ini.</p>
    </div>
@else
    <div class="monitor-grid">
        @foreach($orders as $order)
        @php
            $belumBayar = $order->payment_status === 'pending';
            $sudahBayar = $order->payment_status === 'paid';
            $tunai      = $order->payment_method === 'cash';
            $isMenunggu = $order->order_status === 'menunggu';
            $itemCount = $order->items->count();
        @endphp
        
        <div class="order-box-compact {{ $isMenunggu ? 'status-menunggu' : 'status-diproses' }}">
            
            <div class="box-top-section">
                {{-- Header --}}
                <div class="card-header-top">
                    <div>
                        <div class="card-meja">MEJA {{ $order->table->number }}</div>
                        <div class="card-customer">{{ $order->customer_name }}</div>
                    </div>
                    <div class="card-badges">
                        <span class="meta-badge-sm {{ $isMenunggu ? 'badge-status-menunggu' : 'badge-status-diproses' }}">
                            {{ $isMenunggu ? 'Menunggu' : 'Diproses' }}
                        </span>
                        <span class="meta-badge-sm {{ $sudahBayar ? 'badge-pay-paid' : 'badge-pay-pending' }}">
                            {{ $sudahBayar ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </div>
                </div>
                
                <div class="card-trans-id">#{{ $order->transaction_id }}</div>

                {{-- Items --}}
                <div class="items-container">
                    @foreach($order->items as $item)
                    @php
                        $itemName = $item->menu->name ?? $item->retailProduct->name ?? 'Produk tidak diketahui';
                    @endphp
                    <div class="item-compact-row">
                        <div style="display:flex; align-items:center; min-width:0; flex:1;">
                            <span class="item-qty-badge">{{ $item->quantity }}x</span>
                            <span class="item-name" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $itemName }}</span>
                        </div>
                        <span class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($item->notes)
                    <div class="item-notes-mini">💡 {{ $item->notes }}</div>
                    @endif
                    @endforeach
                </div>

                {{-- Order Notes --}}
                @if($order->notes)
                <div class="order-notes-mini">
                    <strong>Catatan:</strong> {{ $order->notes }}
                </div>
                @endif
            </div>

            {{-- Bottom --}}
            <div class="box-bottom-section">
                <div class="meta-footer">
                    <span>🕒 {{ $order->created_at->diffForHumans() }}</span>
                    <span class="payment-badge">{{ $tunai ? '💵 Tunai' : '📱 QRIS' }}</span>
                </div>

                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>

                <div class="action-row">
                    @if($belumBayar && in_array($order->order_status, ['menunggu', 'diproses']))
                        @if($tunai)
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-compact btn-compact-brand btn-flex">Bayar</a>
                        @else
                            <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" style="flex:1; display:flex">
                                @csrf
                                <button type="submit" class="btn-compact btn-compact-brand btn-flex">Konfirmasi QRIS</button>
                            </form>
                        @endif
                    @endif

                    @if($sudahBayar && $order->order_status === 'diproses')
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" style="flex:1; display:flex">
                        @csrf
                        <input type="hidden" name="order_status" value="selesai">
                        <button type="submit" class="btn-compact btn-compact-success btn-flex">Selesai</button>
                    </form>
                    @endif

                    @if($belumBayar && in_array($order->order_status, ['menunggu', 'diproses']) && $order->payment_method === 'cash')
                    <button type="button" class="btn-compact btn-compact-danger"
                        onclick="batalkanPesanan('{{ route('admin.orders.status', $order) }}', '{{ $order->transaction_id }}')">
                        Batal
                    </button>
                    @endif

                    <a href="{{ route('admin.orders.show', $order) }}" class="btn-compact btn-compact-muted">Detail</a>
                </div>
            </div>

        </div>
        @endforeach
    </div>
@endif

{{-- ── MODAL ── --}}
<div class="modal-overlay-flat" id="modal-batalkan" style="display:none;">
    <div class="modal-content-flat">
        <div class="modal-title">Batalkan Transaksi</div>
        <div class="modal-desc" id="batalkan-desc">
            Apakah Anda yakin ingin membatalkan transaksi ini?
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-compact btn-compact-muted" onclick="closeModalCustom()">Kembali</button>
            <form id="batalkan-form" method="POST" style="display:inline">
                @csrf
                <input type="hidden" name="order_status" value="dibatalkan">
                <button type="submit" class="btn-compact btn-compact-danger">Ya, Batalkan</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let monitorTimer = setTimeout(function() { location.reload(); }, 10000);
    document.getElementById('last-refresh').textContent = '🔄 Terakhir: ' + new Date().toLocaleTimeString('id-ID');

    function batalkanPesanan(action, trxId) {
        clearTimeout(monitorTimer);
        document.getElementById('batalkan-desc').innerHTML =
            'Anda akan membatalkan pesanan <strong>' + trxId + '</strong>. Tindakan ini akan mengosongkan status meja kembali.';
        document.getElementById('batalkan-form').action = action;
        document.getElementById('modal-batalkan').style.display = 'flex';
    }

    function closeModalCustom() {
        document.getElementById('modal-batalkan').style.display = 'none';
        monitorTimer = setTimeout(function() { location.reload(); }, 10000);
    }
</script>
@endpush