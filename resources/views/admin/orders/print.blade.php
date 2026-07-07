@extends('layouts.admin')

@section('title', 'Nota - ' . $order->transaction_id)
@section('page-title', 'Cetak Nota')

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

    .breadcrumb-admin-nota {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 20px;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .breadcrumb-admin-nota a { color: #6b7280; text-decoration: none; transition: color .2s; }
    .breadcrumb-admin-nota a:hover { color: #1b4332; }
    .breadcrumb-admin-nota .separator { color: #d1d5db; }
    .breadcrumb-admin-nota .current { color: #1b4332; font-weight: 600; }

    .nota-page-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
        max-width: 460px;
        margin: 0 auto;
    }
    .nota-page-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #fafafa;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .nota-page-title {
        font-size: 15px;
        font-weight: 700;
        color: #1b4332;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nota-body-wrap { padding: 24px 20px; }
    .header {
        text-align: center;
        margin-bottom: 16px;
        border-bottom: 1px dashed #d1d5db;
        padding-bottom: 12px;
    }
    .header .logo {
        font-size: 20px;
        font-weight: 700;
        color: #0e6446;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: 'Playfair Display', serif;
    }
    .header .sub { font-size: 11px; color: #6b7280; margin-top: 2px; }
    .header .divider {
        width: 40px; height: 2px; background: #d4a373;
        margin: 6px auto 0; border-radius: 4px;
    }

    .info { margin-bottom: 12px; font-size: 12px; }
    .info .row {
        display: flex; justify-content: space-between;
        padding: 4px 0; border-bottom: 1px solid #f3f4f6;
    }
    .info .row:last-child { border-bottom: none; }
    .info .label { color: #6b7280; }
    .info .value { font-weight: 500; color: #1a1a1a; }
    .info .value-small { font-size: 10px; font-family: monospace; color: #6b7280; }

    .items {
        border-top: 1px dashed #d1d5db;
        border-bottom: 1px dashed #d1d5db;
        padding: 10px 0;
        margin-bottom: 10px;
    }
    .item {
        display: flex; justify-content: space-between;
        padding: 4px 0; font-size: 12px; border-bottom: 1px solid #f9fafb;
    }
    .item:last-child { border-bottom: none; }
    .item .name { font-weight: 500; }
    .item .notes {
        font-size: 10px; color: #6b7280; padding-left: 14px;
        font-style: italic; display: block; margin-top: 1px;
    }

    .totals { margin-top: 4px; }
    .totals .row { display: flex; justify-content: space-between; padding: 4px 0; font-size: 12px; }
    .totals .total-final {
        font-weight: 700; font-size: 16px; border-top: 2px solid #0e6446;
        padding-top: 8px; margin-top: 4px; color: #0e6446;
    }

    .footer {
        text-align: center; margin-top: 16px; font-size: 11px; color: #6b7280;
        border-top: 1px dashed #d1d5db; padding-top: 12px;
    }
    .footer .thanks { font-weight: 600; color: #1b4332; }
    .footer .brand { color: #0e6446; font-weight: 600; }

    .btn-download {
        background: #0e6446;
        color: white;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        padding: 10px 28px;
        font-size: 13px;
        font-weight: 600;
        height: 40px;
        border-radius: 30px !important;
        cursor: pointer;
        font-family: 'Outfit', sans-serif;
        box-shadow: 0 2px 8px rgba(14, 100, 70, 0.25);
        min-width: 180px;
    }
    .btn-download:hover {
        background: #1b7a5a;
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(14, 100, 70, 0.4);
        color: white;
    }
    .btn-download:active {
        transform: translateY(-1px) scale(0.97);
        box-shadow: 0 4px 12px rgba(14, 100, 70, 0.3);
    }
    .btn-download:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    .btn-download i { font-size: 15px; transition: transform 0.3s ease; }
    .btn-download:hover i { transform: scale(1.1); }

    .nota-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
        padding: 16px 20px;
        border-top: 1px solid #e5e7eb;
        background: #fafafa;
    }

    @media (max-width: 480px) {
        .nota-body-wrap { padding: 16px 14px; }
        .nota-actions { flex-direction: column; }
        .nota-actions .btn-download { width: 100%; min-width: unset; }
        .back-link-detail-admin { font-size: 13px; padding: 6px 14px; }
        .breadcrumb-admin-nota { font-size: 12px; }
    }

    @media (prefers-color-scheme: dark) {
        .nota-page-card { background: #1f2937; border-color: #374151; }
        .nota-page-header { background: #111827; border-color: #374151; }
        .nota-page-title { color: #f3f4f6; }
        .info .value { color: #f3f4f6; }
        .item { border-color: #374151; color: #f3f4f6; }
        .items, .header, .footer { border-color: #374151; }
        .footer { color: #9ca3af; }
        .nota-actions { background: #111827; border-color: #374151; }
        .back-link-detail-admin { color: #9ca3af; background: rgba(255,255,255,0.06); }
        .back-link-detail-admin:hover { background: rgba(255,255,255,0.1); color: #d4a373; }
        .breadcrumb-admin-nota { color: #9ca3af; }
        .breadcrumb-admin-nota a { color: #9ca3af; }
        .breadcrumb-admin-nota a:hover { color: #d4a373; }
        .breadcrumb-admin-nota .current { color: #d4a373; }
        .breadcrumb-admin-nota .separator { color: #4b5563; }
        .btn-download { box-shadow: 0 2px 8px rgba(14, 100, 70, 0.4); }
        .btn-download:hover { box-shadow: 0 8px 24px rgba(14, 100, 70, 0.6); }
    }

    @media print {
        .back-link-detail-admin, .breadcrumb-admin-nota, .nota-actions, .nota-page-header { display: none !important; }
        .nota-page-card { box-shadow: none !important; border: none !important; max-width: 100%; }
        .nota-body-wrap { padding: 10px; }
    }
</style>

{{-- ── BACK LINK ── --}}
<a href="{{ route('admin.orders.show', $order) }}" class="back-link-detail-admin" target="_self">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Detail Pesanan</span>
</a>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin-nota">
    <a href="{{ route('admin.orders.index') }}">
        <i class="fas fa-history"></i> Riwayat Pesanan
    </a>
    <span class="separator">/</span>
    <a href="{{ route('admin.orders.show', $order) }}">
        <i class="fas fa-receipt"></i> Detail Pesanan
    </a>
    <span class="separator">/</span>
    <span class="current">
        <i class="fas fa-print"></i> Cetak Nota
    </span>
</div>

{{-- ── CARD NOTA ── --}}
<div class="nota-page-card">
    <div class="nota-page-header">
        <div class="nota-page-title">
            <i class="fas fa-receipt" style="color:#1b4332;"></i>
            Nota #{{ $order->transaction_id }}
        </div>
    </div>

    <div class="nota-body-wrap" id="nota-content">
        <div class="header">
            <div class="logo">
                <i class="fas fa-mug-hot"></i> Pivot Caffe
            </div>
            <div class="sub">Nota Pembelian</div>
            <div class="divider"></div>
        </div>

        <div class="info">
            <div class="row">
                <span class="label">No. Transaksi</span>
                <span class="value-small">{{ $order->transaction_id }}</span>
            </div>
            <div class="row">
                <span class="label">Meja</span>
                <span class="value">Meja {{ $order->table->number }}</span>
            </div>
            <div class="row">
                <span class="label">Pelanggan</span>
                <span class="value">{{ $order->customer_name }}</span>
            </div>
            <div class="row">
                <span class="label">Tanggal</span>
                <span class="value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="row">
                <span class="label">Pembayaran</span>
                <span class="value">{{ $order->payment_method === 'cash' ? 'Tunai' : 'QRIS' }}</span>
            </div>
        </div>

        <div class="items">
            @foreach($order->items as $item)
            <div class="item">
                <span>
                    <span class="name">
                        {{ $item->quantity }}x 
                        @if($item->menu_id && $item->menu)
                            {{ $item->menu->name }}
                        @elseif($item->retail_product_id && $item->retailProduct)
                            {{ $item->retailProduct->name }}
                        @else
                            Item tidak diketahui
                        @endif
                    </span>
                    @if($item->notes)
                    <span class="notes">&bull; {{ $item->notes }}</span>
                    @endif
                </span>
                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div class="totals">
            <div class="row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->discount > 0)
            <div class="row">
                <span>Diskon</span>
                <span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="row total-final">
                <span>TOTAL</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p class="thanks">Terima kasih telah berkunjung!</p>
            <p>— <span class="brand">Pivot Caffe</span> —</p>
        </div>
    </div>

    {{-- ── ACTIONS ── --}}
    <div class="nota-actions">
        <button class="btn-download" id="btn-download-pdf">
            <i class="fas fa-file-pdf"></i> Download PDF
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btn-download-pdf');

    async function downloadPDF() {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyiapkan...';
        btn.disabled = true;

        try {
            const element = document.getElementById('nota-content');
            const canvas = await html2canvas(element, {
                scale: 3,
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false,
                width: element.scrollWidth,
                height: element.scrollHeight
            });

            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgData = canvas.toDataURL('image/png');
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('Nota_{{ $order->transaction_id }}.pdf');

            btn.innerHTML = '<i class="fas fa-check-circle"></i> Berhasil!';
            btn.style.background = '#16a34a';
            btn.style.boxShadow = '0 4px 16px rgba(22, 163, 74, 0.4)';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-file-pdf"></i> Download PDF';
                btn.style.background = '#0e6446';
                btn.style.boxShadow = '0 2px 8px rgba(14, 100, 70, 0.25)';
                btn.disabled = false;
            }, 2000);
        } catch (error) {
            console.error('Error:', error);
            btn.innerHTML = '<i class="fas fa-exclamation-circle"></i> Gagal, coba lagi';
            btn.style.background = '#dc2626';
            btn.style.boxShadow = '0 4px 16px rgba(220, 38, 38, 0.4)';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-file-pdf"></i> Download PDF';
                btn.style.background = '#0e6446';
                btn.style.boxShadow = '0 2px 8px rgba(14, 100, 70, 0.25)';
                btn.disabled = false;
            }, 3000);
        }
    }

    btn.addEventListener('click', downloadPDF);

    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            downloadPDF();
        }
    });

    console.log('✅ Halaman Cetak Nota siap digunakan!');
});
</script>
@endpush