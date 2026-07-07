@extends('layouts.admin')

@section('title', 'Detail Pesanan - ' . $order->transaction_id)
@section('page-title', 'Detail Pesanan')

@section('content')

<style>
    .back-link-detail-admin {
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
    .back-link-detail-admin:hover {
        background: rgba(0,0,0,0.08);
        color: #1b4332;
        transform: translateX(-4px);
    }

    .breadcrumb-admin-detail {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 20px;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .breadcrumb-admin-detail a { color: #6b7280; text-decoration: none; transition: color .2s; }
    .breadcrumb-admin-detail a:hover { color: #1b4332; }
    .breadcrumb-admin-detail .separator { color: #d1d5db; }
    .breadcrumb-admin-detail .current { color: #1b4332; font-weight: 600; }

    .btn-print {
        background: #0e6446;
        color: white;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        padding: 8px 22px;
        font-size: 13px;
        font-weight: 600;
        height: 36px;
        border-radius: 30px !important;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(14, 100, 70, 0.25);
    }
    .btn-print:hover {
        background: #1b7a5a;
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(14, 100, 70, 0.4);
        color: white;
    }
    .btn-print:active { transform: translateY(-1px) scale(0.97); box-shadow: 0 4px 12px rgba(14, 100, 70, 0.3); }
    .btn-print i { font-size: 14px; transition: transform 0.3s ease; }
    .btn-print:hover i { transform: scale(1.15); }

    .btn-print-disabled {
        background: #9ca3af;
        color: white;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        padding: 8px 22px;
        font-size: 13px;
        font-weight: 600;
        height: 36px;
        border-radius: 30px !important;
        cursor: not-allowed;
        text-decoration: none;
        opacity: 0.6;
        pointer-events: none;
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
        text-decoration: none;
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
        padding: 8px 20px;
        font-size: 13px;
        height: 36px;
        border-radius: 30px !important;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-primary:hover {
        background: #1b7a5a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 100, 70, 0.35);
        color: white;
    }

    .btn-success {
        background: #16a34a;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        padding: 8px 20px;
        font-size: 13px;
        height: 36px;
        border-radius: 30px !important;
        cursor: pointer;
    }
    .btn-success:hover {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
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
        padding: 8px 20px;
        font-size: 13px;
        height: 36px;
        border-radius: 30px !important;
        cursor: pointer;
        text-decoration: none;
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

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .order-header .title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        color: #1b4332;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .order-header .title .order-id {
        font-size: 12px;
        font-family: monospace;
        background: #f3f4f6;
        padding: 4px 12px;
        border-radius: 30px;
        color: #6b7280;
        font-weight: 400;
    }
    .order-header .actions { display: flex; gap: 8px; }

    .detail-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }

    .detail-box {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .detail-box-header {
        padding: 12px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }
    .detail-box-title {
        font-size: 14px;
        font-weight: 600;
        color: #1b4332;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }
    .detail-box-body { padding: 16px 20px; }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2px 24px;
    }
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: 13px;
        align-items: center;
    }
    .info-item:last-child { border-bottom: none; }
    .info-item .label { color: #6b7280; font-weight: 500; font-size: 12px; }
    .info-item .value { color: #1a1a1a; font-weight: 600; font-size: 13px; text-align: right; }
    .info-item .value .badge { font-size: 10px; padding: 3px 10px; }
    .info-item.notes-item { grid-column: 1 / -1; align-items: flex-start; }
    .info-item.notes-item .value { font-weight: 500; color: #f59e0b; text-align: right; font-size: 12px; }

    .table-wrap-order { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .table-order {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .table-order th {
        background: #f8fafc;
        color: #6b7280;
        font-weight: 600;
        text-align: left;
        padding: 10px 14px;
        border-bottom: 2px solid #e5e7eb;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }
    .table-order td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1a1a1a;
        vertical-align: middle;
    }
    .table-order tfoot td {
        padding: 10px 14px;
        border-bottom: none;
        background: #fafafa;
        font-weight: 600;
    }
    .table-order tfoot .total-row td {
        border-top: 2px solid #1b4332;
        font-size: 15px;
        color: #1b4332;
        padding: 12px 14px;
    }

    .variant-addon-badge {
        font-size: 9px;
        padding: 2px 8px;
        margin: 2px 2px 0 0;
        display: inline-block;
        border-radius: 30px;
        background: #f3f4f6;
        color: #4b5563;
        border: 1px solid #e5e7eb;
    }

    .form-flat-group { margin-bottom: 14px; }
    .form-flat-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }
    .form-flat-group input,
    .form-flat-group select {
        width: 100%;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 13px;
        color: #1a1a1a;
        background: #ffffff;
        outline: none;
        font-family: 'Outfit', sans-serif;
        transition: all 0.2s;
    }
    .form-flat-group input:focus,
    .form-flat-group select:focus {
        border-color: #1b4332;
        box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.08);
    }

    .cash-change-box {
        display: flex;
        justify-content: space-between;
        padding: 10px 14px;
        background: #f8fafc;
        border-radius: 8px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 14px;
        border: 1px solid #e5e7eb;
    }
    .cash-change-box .change-value { color: #1b4332; font-size: 16px; font-weight: 700; }

    .alert-pending {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
    }
    .alert-pending .title {
        font-size: 12px;
        font-weight: 600;
        color: #854d0e;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .alert-pending .amount { font-size: 13px; color: #78350f; margin-top: 4px; }

    .status-done-box {
        text-align: center;
        padding: 30px 20px;
    }
    .status-done-box .icon { font-size: 44px; margin-bottom: 8px; }
    .status-done-box .title { font-size: 15px; font-weight: 600; color: #1b4332; }
    .status-done-box .sub { font-size: 12px; color: #6b7280; margin-top: 4px; }

    .feedback-rating {
        font-size: 22px;
        line-height: 1.2;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .feedback-rating .star-filled { color: #f59e0b; }
    .feedback-rating .star-empty { color: #e2e8f0; }
    .feedback-rating .score { font-size: 12px; color: #6b7280; margin-left: 8px; }
    .feedback-comment {
        font-size: 13px;
        color: #4b5563;
        margin: 10px 0 0;
        line-height: 1.6;
        font-style: italic;
        background: #f9fafb;
        padding: 12px 16px;
        border-radius: 8px;
        border-left: 3px solid #f59e0b;
    }

    @media (max-width: 768px) {
        .order-header { flex-direction: column; align-items: flex-start; }
        .order-header .actions { width: 100%; }
        .order-header .actions .btn-print,
        .order-header .actions .btn-print-disabled { width: 100%; justify-content: center; }
        .detail-container { grid-template-columns: 1fr; }
        .info-grid { grid-template-columns: 1fr; }
        .info-item.notes-item { grid-column: 1; }
        .detail-box-header { flex-direction: column; align-items: flex-start; }
        .btn-primary, .btn-success, .btn-secondary { width: 100%; justify-content: center; }
        .table-order { font-size: 12px; min-width: 450px; }
        .table-order th, .table-order td { padding: 8px 10px; }
        .detail-box-body { padding: 14px; }
        .back-link-detail-admin { font-size: 13px; padding: 6px 14px; }
        .breadcrumb-admin-detail { font-size: 12px; }
        .side-action-column { grid-row: 2; }
    }

    @media (max-width: 480px) {
        .detail-box-body { padding: 12px; }
        .detail-box-header { padding: 10px 14px; }
        .detail-box-title { font-size: 13px; }
        .table-order { font-size: 11px; min-width: 350px; }
        .table-order th, .table-order td { padding: 6px 8px; }
        .info-item { font-size: 12px; }
        .info-item .label { font-size: 11px; }
        .info-item .value { font-size: 12px; }
        .cash-change-box { font-size: 12px; padding: 8px 12px; }
        .cash-change-box .change-value { font-size: 14px; }
        .feedback-rating { font-size: 18px; }
        .order-header .title { font-size: 18px; }
        .order-header .title .order-id { font-size: 10px; }
        .back-link-detail-admin { font-size: 12px; padding: 5px 12px; }
        .breadcrumb-admin-detail { font-size: 11px; }
    }

    @media (prefers-color-scheme: dark) {
        .detail-box { background: #1f2937; border-color: #374151; }
        .detail-box-header { background: #111827; border-color: #374151; }
        .detail-box-title { color: #f3f4f6; }
        .info-item { border-color: #374151; }
        .info-item .label { color: #9ca3af; }
        .info-item .value { color: #f3f4f6; }
        .table-order th { background: #111827; color: #9ca3af; border-color: #374151; }
        .table-order td { border-color: #374151; color: #f3f4f6; }
        .table-order tfoot td { background: #111827; }
        .form-flat-group input, .form-flat-group select { background: #111827; border-color: #374151; color: #f3f4f6; }
        .form-flat-group input:focus, .form-flat-group select:focus { border-color: #d4a373; }
        .form-flat-group label { color: #e5e7eb; }
        .back-link-detail-admin { color: #9ca3af; background: rgba(255,255,255,0.06); }
        .back-link-detail-admin:hover { background: rgba(255,255,255,0.1); color: #d4a373; }
        .cash-change-box { background: #111827; border-color: #374151; color: #9ca3af; }
        .cash-change-box .change-value { color: #d4a373; }
        .alert-pending { background: #1f1a0a; border-color: #854d0e; }
        .alert-pending .title { color: #f59e0b; }
        .alert-pending .amount { color: #fbbf24; }
        .status-done-box .title { color: #f3f4f6; }
        .status-done-box .sub { color: #9ca3af; }
        .variant-addon-badge { background: #374151; color: #e5e7eb; border-color: #4b5563; }
        .feedback-comment { background: #111827; color: #e5e7eb; }
        .feedback-rating .star-empty { color: #4b5563; }
        .order-header { border-color: #374151; }
        .order-header .title { color: #f3f4f6; }
        .order-header .title .order-id { background: #111827; color: #9ca3af; }
        .breadcrumb-admin-detail { color: #9ca3af; }
        .breadcrumb-admin-detail a { color: #9ca3af; }
        .breadcrumb-admin-detail a:hover { color: #d4a373; }
        .breadcrumb-admin-detail .current { color: #d4a373; }
        .breadcrumb-admin-detail .separator { color: #4b5563; }
        .btn-print { box-shadow: 0 2px 8px rgba(14, 100, 70, 0.4); }
        .btn-print:hover { box-shadow: 0 8px 24px rgba(14, 100, 70, 0.6); }
    }
</style>

{{-- ── BACK LINK ── --}}
<a href="{{ route('admin.orders.index') }}" class="back-link-detail-admin">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Riwayat Pesanan</span>
</a>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin-detail">
    <a href="{{ route('admin.orders.index') }}">
        <i class="fas fa-history"></i> Riwayat Pesanan
    </a>
    <span class="separator">/</span>
    <span class="current">
        <i class="fas fa-receipt"></i> Detail Pesanan
    </span>
</div>

{{-- ── HEADER ── --}}
<div class="order-header">
    <div class="title">
        <i class="fas fa-receipt" style="color:#1b4332;"></i>
        Detail Pesanan
        <span class="order-id">#{{ $order->transaction_id }}</span>
    </div>
    <div class="actions">
        @if($order->payment_status === 'paid')
            <a href="{{ route('admin.orders.print', $order) }}" class="btn-print" target="_self">
                <i class="fas fa-print"></i> Cetak Nota
            </a>
        @else
            <span class="btn-print-disabled">
                <i class="fas fa-print"></i> Cetak Nota
            </span>
        @endif
    </div>
</div>

<div class="detail-container">
    
    <div class="main-info-column">
        
        <div class="detail-box">
            <div class="detail-box-header">
                <div class="detail-box-title">
                    <i class="fas fa-info-circle" style="color: #1b4332;"></i>
                    Informasi Pesanan
                </div>
            </div>
            <div class="detail-box-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">Nomor Meja</span>
                        <span class="value">Meja {{ $order->table->number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Nama Pelanggan</span>
                        <span class="value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Metode Bayar</span>
                        <span class="value">{{ $order->payment_method === 'cash' ? 'Tunai' : 'QRIS' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Status Bayar</span>
                        <span class="value">
                            @if($order->payment_status === 'paid')
                                <span class="badge badge-success"><i class="fas fa-check"></i> Lunas</span>
                            @elseif($order->payment_status === 'dibatalkan')
                                <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Dibatalkan</span>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Belum Bayar</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="label">Status Alur</span>
                        <span class="value">
                            @if($order->order_status === 'selesai')
                                <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                            @elseif($order->order_status === 'dibatalkan')
                                <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Dibatalkan</span>
                            @elseif($order->order_status === 'diproses')
                                <span class="badge badge-info"><i class="fas fa-spinner fa-spin"></i> Diproses</span>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="label">Waktu Masuk</span>
                        <span class="value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($order->notes)
                    <div class="info-item notes-item">
                        <span class="label">Catatan Nota</span>
                        <span class="value">{{ $order->notes }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="detail-box">
            <div class="detail-box-header">
                <div class="detail-box-title">
                    <i class="fas fa-utensils" style="color: #1b4332;"></i>
                    Item Pesanan
                </div>
                <span style="font-size:12px; color:#6b7280;">{{ $order->items->count() }} item</span>
            </div>
            <div class="detail-box-body" style="padding:0;">
                <div class="table-wrap-order">
                    <table class="table-order">
                        <thead>
                            <tr>
                                <th style="min-width:140px;">Menu</th>
                                <th style="width:60px; text-align:center;">Qty</th>
                                <th style="width:100px; text-align:right;">Harga</th>
                                <th style="width:120px; text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div style="font-weight:600; font-size:13px; color:#1a1a1a;">
                                        {{-- 🔥 PERBAIKAN: Deteksi menu atau retail --}}
                                        @if($item->menu_id)
                                            {{ $item->menu->name }}
                                        @elseif($item->retail_product_id)
                                            {{ $item->retailProduct->name }}
                                        @else
                                            Item tidak diketahui
                                        @endif
                                    </div>
                                    @if($item->notes)
                                    <div style="font-size:11px; color:#f59e0b; margin-top:2px;">
                                        <i class="fas fa-pen"></i> {{ $item->notes }}
                                    </div>
                                    @endif
                                    @if(isset($item->variants) && $item->variants && $item->variants->count() > 0)
                                    <div style="font-size:10px; color:#6b7280; margin-top:4px;">
                                        @foreach($item->variants as $variant)
                                        <span class="variant-addon-badge">
                                            {{ $variant->name }} (+{{ number_format($variant->pivot->extra_price ?? 0, 0, ',', '.') }})
                                        </span>
                                        @endforeach
                                    </div>
                                    @endif
                                    @if(isset($item->addons) && $item->addons && $item->addons->count() > 0)
                                    <div style="font-size:10px; color:#6b7280; margin-top:2px;">
                                        @foreach($item->addons as $addon)
                                        <span class="variant-addon-badge">
                                            + {{ $addon->name }} (+{{ number_format($addon->pivot->price ?? 0, 0, ',', '.') }})
                                        </span>
                                        @endforeach
                                    </div>
                                    @endif
                                </td>
                                <td style="text-align:center; font-weight:600;">{{ $item->quantity }}</td>
                                <td style="text-align:right; color:#6b7280;">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td style="text-align:right; font-weight:600; color:#1b4332;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:right; color:#6b7280;">Subtotal</td>
                                <td style="text-align:right; color:#6b7280;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @if($order->discount > 0)
                            <tr>
                                <td colspan="3" style="text-align:right; color:#16a34a;">Diskon</td>
                                <td style="text-align:right; color:#16a34a;">- Rp {{ number_format($order->discount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr class="total-row">
                                <td colspan="3" style="text-align:right; font-size:15px; font-weight:700; color:#1b4332;">Total</td>
                                <td style="text-align:right; font-size:15px; font-weight:700; color:#1b4332;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="side-action-column">
        
        @if(in_array($order->order_status, ['selesai', 'dibatalkan']))
        <div class="detail-box">
            <div class="status-done-box">
                <div class="icon">{{ $order->order_status === 'selesai' ? '✅' : '❌' }}</div>
                <div class="title">{{ $order->order_status === 'selesai' ? 'Pesanan Selesai' : 'Pesanan Dibatalkan' }}</div>
                <div class="sub">Tidak dapat mengubah status pesanan yang sudah selesai/dibatalkan.</div>
            </div>
        </div>
        @else

        <div class="detail-box">
            <div class="detail-box-header">
                <div class="detail-box-title">
                    <i class="fas fa-cog" style="color:#1b4332;"></i>
                    Kelola Pesanan
                </div>
            </div>
            <div class="detail-box-body">

                @if($order->payment_status === 'pending')
                    <div class="alert-pending">
                        <div class="title"><i class="fas fa-clock"></i> Menunggu Pembayaran</div>
                        <div class="amount">Total: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></div>
                    </div>

                    @if($order->payment_method === 'cash')
                    <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST">
                        @csrf
                        <div class="form-flat-group">
                            <label>Uang Diterima <span style="color:#dc2626;">*</span></label>
                            <input type="number" 
                                   name="cash_received" 
                                   id="cash_received" 
                                   data-total="{{ (int) $order->total }}"
                                   oninput="hitungKembalian()" 
                                   min="{{ (int) $order->total }}" 
                                   step="100" 
                                   placeholder="Masukkan nominal uang" 
                                   value="{{ old('cash_received') }}" 
                                   required>
                            @error('cash_received')
                                <div style="color:#dc2626; font-size:11px; margin-top:4px; font-weight:600;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="cash-change-box">
                            <span>Kembalian</span>
                            <span class="change-value" id="cash_change">Rp 0</span>
                        </div>
                        <button type="submit" class="btn btn-success" style="width:100%;">
                            <i class="fas fa-check"></i> Konfirmasi Bayar
                        </button>
                    </form>
                    <div style="font-size:11px; color:#6b7280; margin-top:8px; text-align:center;">
                        Pastikan uang yang diterima sesuai dengan total tagihan.
                    </div>
                    @else
                    <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" style="width:100%;">
                            <i class="fas fa-check"></i> Konfirmasi Bayar
                        </button>
                    </form>
                    <div style="font-size:11px; color:#6b7280; margin-top:8px; text-align:center; line-height:1.4;">
                        Pastikan pembayaran QRIS sudah masuk ke akun merchant sebelum konfirmasi.
                    </div>
                    @endif

                @elseif($order->payment_status === 'paid')
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    <div class="form-flat-group">
                        <label>Ubah Status</label>
                        <select name="order_status" class="form-control">
                            <option value="diproses" {{ $order->order_status === 'diproses' ? 'selected' : '' }}>
                                🍳 Sedang Diproses
                            </option>
                            <option value="selesai">
                                ✅ Selesai & Sajikan
                            </option>
                            @if($order->payment_method === 'cash')
                            <option value="dibatalkan">
                                ❌ Batalkan Pesanan
                            </option>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%; margin-top:4px;">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>
                @endif

            </div>
        </div>
        @endif

        @if($order->feedback)
        <div class="detail-box">
            <div class="detail-box-header">
                <div class="detail-box-title">
                    <i class="fas fa-star" style="color: #d97706;"></i>
                    Feedback Pelanggan
                </div>
            </div>
            <div class="detail-box-body">
                <div class="feedback-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $order->feedback->rating ? 'star-filled' : 'star-empty' }}">★</span>
                    @endfor
                    <span class="score">({{ $order->feedback->rating }}/5)</span>
                </div>
                @if($order->feedback->comment)
                    <div class="feedback-comment">
                        "{{ $order->feedback->comment }}"
                    </div>
                @endif
            </div>
        </div>
        @endif

    </div>
    
</div>

<script>
function hitungKembalian() {
    var inputReceived = document.getElementById('cash_received');
    var changeEl = document.getElementById('cash_change');
    
    if (!inputReceived || !changeEl) return;

    var totalHarga = parseInt(inputReceived.getAttribute('data-total')) || 0;
    var uangDiterima = parseInt(inputReceived.value) || 0;
    
    var kembalian = uangDiterima - totalHarga;
    if (kembalian < 0) {
        kembalian = 0;
    }
    
    changeEl.innerText = 'Rp ' + kembalian.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
@endsection