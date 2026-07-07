@extends('layouts.admin')
@section('title', 'QR Code Meja '.$table->number)
@section('page-title', 'QR Code Meja')

@section('content')

<style>
    /* ── BREADCRUMB (sama seperti index) ── */
    .breadcrumb-admin {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: #6b7280; margin-bottom: 16px;
        flex-wrap: wrap; padding: 4px 0;
    }
    .breadcrumb-admin a { color: #6b7280; text-decoration: none; transition: color .2s; }
    .breadcrumb-admin a:hover { color: #1b4332; }
    .breadcrumb-admin .separator { color: #d1d5db; }
    .breadcrumb-admin .current { color: #1b4332; font-weight: 600; }

    .nav-back {
        display: inline-flex; align-items: center; gap: 10px;
        color: #6b7280; text-decoration: none; font-size: 14px; font-weight: 500;
        transition: all .3s; padding: 8px 16px; border-radius: 50px;
        background: rgba(0,0,0,0.04); margin-bottom: 12px;
    }
    .nav-back:hover { background: rgba(0,0,0,0.08); color: #1b4332; transform: translateX(-4px); }

    /* ── CARD (sama seperti index) ── */
    .card {
        background: white; border: 1px solid #e5e7eb; border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;
    }
    .card-header {
        padding: 16px 20px; border-bottom: 1px solid #e5e7eb;
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 12px; background: #fafafa;
    }
    .card-title {
        font-size: 15px; font-weight: 700; color: #1b4332; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }

    /* ── TOMBOL (sama persis dengan index) ── */
    .btn-primary {
        background: #0e6446; color: white; border: none; transition: all .2s ease;
        display: inline-flex; align-items: center; gap: 6px; justify-content: center;
        padding: 10px 22px; font-size: 13px; height: 40px;
        border-radius: 30px !important; cursor: pointer; font-family: 'Outfit', sans-serif;
        text-decoration: none;
    }
    .btn-primary:hover { background: #1b7a5a; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(14,100,70,.35); color: white; }
    .btn-primary:disabled { opacity: .7; cursor: not-allowed; transform: none; box-shadow: none; }

    .btn-secondary {
        background: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; transition: all .2s ease;
        display: inline-flex; align-items: center; gap: 6px; justify-content: center;
        padding: 10px 22px; font-size: 13px; height: 40px;
        border-radius: 30px !important; cursor: pointer; text-decoration: none;
    }
    .btn-secondary:hover { background: #e5e7eb; color: #1b4332; transform: translateY(-1px); }

    /* ── QR CONTENT (dibikin fit lebar card, bukan 440px kaku) ── */
    .qr-body { padding: 32px; text-align: center; }

    .brand { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 2px; }
    .brand-icon {
        font-size: 26px; color: #0e6446; background: #e8f5e9; padding: 10px;
        border-radius: 50%; width: 50px; height: 50px; display: flex;
        align-items: center; justify-content: center;
    }
    .brand-name { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: #0e6446; letter-spacing: .5px; }
    .brand-sub { font-size: 12px; color: #6b7280; margin-bottom: 6px; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 500; }
    .divider { width: 60px; height: 3px; background: #d4a373; margin: 10px auto 18px; border-radius: 4px; }

    .table-number { font-size: 34px; font-weight: 700; color: #1b4332; margin: 4px 0 2px; font-family: 'Playfair Display', serif; }
    .table-label { font-size: 12px; color: #6b7280; font-weight: 500; text-transform: uppercase; letter-spacing: 2px; }

    .table-info { display: flex; justify-content: center; gap: 12px; margin: 14px 0 18px; font-size: 12px; color: #6b7280; flex-wrap: wrap; }
    .table-info span {
        display: flex; align-items: center; gap: 6px; background: #f8fafc;
        padding: 4px 14px; border-radius: 50px; border: 1px solid #e5e7eb;
    }
    .table-info i { color: #0e6446; font-size: 13px; }

    .qr-wrapper {
        margin: 16px auto; padding: 20px; background: white; border-radius: 16px;
        border: 2px solid #e8f5e9; display: inline-flex; justify-content: center;
        position: relative; box-shadow: inset 0 2px 8px rgba(0,0,0,0.04); max-width: 320px;
    }
    .qr-wrapper svg { max-width: 100%; height: auto; }

    .qr-badge {
        position: absolute; bottom: -8px; right: -8px; background: #0e6446; color: white;
        font-size: 9px; font-weight: 600; padding: 4px 12px; border-radius: 50px; letter-spacing: .5px;
    }

    .qr-url {
        font-size: 11px; color: #6b7280; word-break: break-all; background: #f8fafc;
        padding: 8px 14px; border-radius: 8px; margin: 0 auto 16px; max-width: 400px;
        font-family: 'Courier New', monospace; border: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .qr-url i { color: #0e6446; }

    .actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 8px; }

    .footer-note {
        margin-top: 16px; font-size: 11px; color: #9ca3af; text-align: center;
        letter-spacing: .3px; padding-top: 12px; border-top: 1px solid #f3f4f6;
    }
    .footer-note i { color: #d4a373; }

    @media (max-width: 480px) {
        .qr-body { padding: 20px 14px; }
        .actions { flex-direction: column; }
        .actions .btn-primary, .actions .btn-secondary { width: 100%; }
        .table-number { font-size: 26px; }
    }

    /* ── DARK MODE (samain dengan index) ── */
    @media (prefers-color-scheme: dark) {
        .card { background: #1f2937; border-color: #374151; }
        .card-header { background: #111827; border-color: #374151; }
        .card-title { color: #f3f4f6; }
        .brand-name { color: #f3f4f6; }
        .brand-icon { background: #1a2e22; color: #d4a373; }
        .table-number { color: #f3f4f6; }
        .table-info span { background: #111827; border-color: #374151; }
        .qr-wrapper { background: #111827; border-color: #374151; }
        .qr-url { background: #111827; color: #9ca3af; border-color: #374151; }
        .btn-secondary { background: #111827; color: #9ca3af; border-color: #374151; }
        .btn-secondary:hover { background: #1f2937; color: #d4a373; }
        .footer-note { color: #4b5563; border-color: #374151; }
        .nav-back { color: #9ca3af; background: rgba(255,255,255,0.06); }
        .nav-back:hover { background: rgba(255,255,255,0.1); color: #d4a373; }
        .breadcrumb-admin { color: #9ca3af; }
        .breadcrumb-admin a { color: #9ca3af; }
        .breadcrumb-admin .current { color: #d4a373; }
    }

    /* ── PRINT ── */
    @media print {
        .nav-back, .breadcrumb-admin, .actions, .footer-note, .card-header { display: none !important; }
        .card { box-shadow: none !important; border: none !important; }
    }
</style>

{{-- ── BACK LINK ── --}}
<a href="{{ route('admin.tables.index') }}" class="nav-back">
    <i class="fas fa-arrow-left"></i> Kembali ke Kelola Meja
</a>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <a href="{{ route('admin.tables.index') }}"><i class="fas fa-table"></i> Kelola Meja</a>
    <span class="separator">/</span>
    <span class="current">QR Code Meja {{ $table->number }}</span>
</div>

{{-- ── CARD QR ── --}}
<div class="card" style="max-width: 480px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-qrcode" style="color:#1b4332;"></i>
            QR Code Meja {{ $table->number }}
        </div>
    </div>

    <div class="qr-body" id="qr-card">
        <div class="brand">
            <span class="brand-icon"><i class="fas fa-mug-hot"></i></span>
            <span class="brand-name">Pivot Cafe</span>
        </div>
        <div class="brand-sub">Scan QR untuk memesan</div>
        <div class="divider"></div>

        <div class="table-label">Nomor Meja</div>
        <div class="table-number">#{{ $table->number }}</div>

        <div class="table-info">
            <span><i class="fas fa-qrcode"></i> QR Code</span>
            <span><i class="fas fa-chair"></i> Meja {{ $table->number }}</span>
            <span><i class="fas fa-clock"></i> Aktif</span>
        </div>

        <div class="qr-wrapper" id="qr-wrapper">
            {!! $qrCode !!}
            <span class="qr-badge"><i class="fas fa-check-circle"></i> SCAN ME</span>
        </div>

        <div class="qr-url">
            <i class="fas fa-link"></i> {{ $url }}
        </div>

        <div class="actions">
            <button class="btn-primary" id="btn-download-pdf">
                <i class="fas fa-file-pdf"></i> Cetak QR (PDF)
            </button>
        </div>

        <div class="footer-note">
            <i class="fas fa-mug-hot"></i> Pivot Caffe — Scan & Order
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnDownload = document.getElementById('btn-download-pdf');

    async function downloadPDF() {
        const btn = btnDownload;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyiapkan PDF...';
        btn.disabled = true;

        try {
            const element = document.getElementById('qr-card');
            const canvas = await html2canvas(element, {
                scale: 3, useCORS: true, backgroundColor: '#ffffff', logging: false
            });

            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgData = canvas.toDataURL('image/png');
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('QR_Code_Meja_{{ $table->number }}_Pivot_Caffe.pdf');

            btn.innerHTML = '<i class="fas fa-check-circle"></i> Berhasil!';
            btn.style.background = '#16a34a';
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = '#0e6446';
                btn.disabled = false;
            }, 2000);
        } catch (error) {
            console.error('Error:', error);
            btn.innerHTML = '<i class="fas fa-exclamation-circle"></i> Gagal, coba lagi';
            btn.style.background = '#dc2626';
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = '#0e6446';
                btn.disabled = false;
            }, 3000);
        }
    }

    btnDownload.addEventListener('click', downloadPDF);

    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            downloadPDF();
        }
    });
});
</script>
@endpush