@extends('layouts.customer')

@section('title', 'Status Pesanan — Pivot Cafe')

@push('styles')
<style>
    .status-container {
        max-width: 700px;
        margin: 0 auto;
        padding-top: 120px;
        padding-bottom: 80px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .nav-back-status {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--text-light);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        padding: 8px 16px;
        border-radius: 50px;
        background: rgba(0,0,0,0.04);
        margin-bottom: 16px;
    }

    .nav-back-status:hover {
        background: rgba(0,0,0,0.08);
        color: var(--primary);
        transform: translateX(-4px);
    }

    .nav-back-status i {
        font-size: 14px;
    }

    .breadcrumb-status {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 24px;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .breadcrumb-status a {
        color: var(--text-light);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-status a:hover {
        color: var(--primary);
    }
    .breadcrumb-status .separator {
        color: #d1d5db;
    }
    .breadcrumb-status .current {
        color: var(--primary);
        font-weight: 600;
    }

    .status-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: var(--shadow);
        border: var(--border);
        text-align: center;
        margin-bottom: 30px;
    }

    .status-icon-box {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .status-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .status-desc {
        color: var(--text-light);
        font-size: 14px;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .order-details-card {
        background: white;
        border-radius: 25px;
        padding: 30px;
        box-shadow: var(--shadow);
        border: var(--border);
        margin-bottom: 30px;
    }

    .details-title {
        font-weight: 700;
        font-size: 16px;
        color: var(--primary);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: var(--border);
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .item-row span:first-child {
        color: var(--text-light);
    }

    .item-row span:last-child {
        font-weight: 600;
        color: var(--primary);
    }

    .badge-status {
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
    }
    .badge-waiting { background: #fffbeb; color: #d97706; }
    .badge-processing { background: #eff6ff; color: #2563eb; }
    .badge-success { background: #f0fdf4; color: #166534; }
    .badge-danger { background: #fef2f2; color: #dc2626; }
    .badge-paid { background: #dcfce7; color: #166534; }
    .badge-pending { background: #fef9c3; color: #854d0e; }
    .badge-failed { background: #fee2e2; color: #991b1b; }
    .badge-cash { background: #f1f5f9; color: #475569; }
    .badge-qris { background: #dbeafe; color: #1e40af; }

    .btn-status {
        display: block;
        width: 100%;
        padding: 15px 20px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
        font-family: 'Outfit', sans-serif;
    }
    .btn-status:hover {
        transform: translateY(-2px);
    }

    .btn-primary-status {
        background: var(--primary);
        color: white;
    }
    .btn-primary-status:hover {
        background: #133024;
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.35);
    }

    .btn-accent-status {
        background: var(--accent);
        color: white;
    }
    .btn-accent-status:hover {
        background: #c4956a;
        box-shadow: 0 4px 12px rgba(212, 163, 115, 0.35);
    }

    .btn-outline-status {
        background: white;
        color: var(--primary);
        border: 1px solid var(--primary);
    }
    .btn-outline-status:hover {
        background: var(--bg);
    }

    .btn-danger-status {
        background: white;
        color: #dc2626;
        border: 1px solid #dc2626;
    }
    .btn-danger-status:hover {
        background: #fef2f2;
        border-color: #b91c1c;
    }

    .btn-danger-disabled {
        background: #f3f4f6;
        color: #9ca3af;
        border: 1px solid #e5e7eb;
        cursor: not-allowed;
    }
    .btn-danger-disabled:hover {
        transform: none !important;
    }

    .btn-outline-secondary-status {
        background: white;
        color: var(--text-light);
        border: 1px solid #d1d5db;
    }
    .btn-outline-secondary-status:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .modal-overlay-status {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }
    .modal-overlay-status.open {
        display: flex;
    }
    .modal-box-status {
        background: white;
        border-radius: 24px;
        padding: 32px;
        max-width: 400px;
        width: 100%;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        animation: fadeInUp 0.3s ease;
    }
    .modal-box-status .icon {
        font-size: 48px;
        margin-bottom: 16px;
    }
    .modal-box-status h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 8px;
    }
    .modal-box-status p {
        color: var(--text-light);
        font-size: 14px;
        margin-bottom: 24px;
        line-height: 1.6;
    }
    .modal-box-status .btn-group {
        display: flex;
        gap: 12px;
        justify-content: center;
    }
    .modal-box-status .btn-group .btn {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        min-width: 120px;
        transition: all 0.2s ease;
    }
    .modal-box-status .btn-group .btn-cancel-modal {
        background: #f3f4f6;
        color: #4b5563;
    }
    .modal-box-status .btn-group .btn-cancel-modal:hover {
        background: #e5e7eb;
    }
    .modal-box-status .btn-group .btn-danger-modal {
        background: #dc2626;
        color: white;
    }
    .modal-box-status .btn-group .btn-danger-modal:hover {
        background: #b91c1c;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .last-updated {
        color: var(--text-light);
        font-size: 12px;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .status-container {
            padding-top: 100px;
            padding-left: 16px;
            padding-right: 16px;
        }
        .status-card { padding: 28px; }
        .order-details-card { padding: 24px; }
        .nav-back-status {
            font-size: 13px;
            padding: 6px 14px;
        }
        .breadcrumb-status {
            font-size: 12px;
            margin-bottom: 16px;
        }
    }

    @media (max-width: 480px) {
        .status-container {
            padding-top: 90px;
            padding-left: 14px;
            padding-right: 14px;
        }
        .status-card { padding: 20px; }
        .order-details-card { padding: 16px; }
        .modal-box-status { padding: 24px; }
        .modal-box-status .btn-group { flex-direction: column; }
        .modal-box-status .btn-group .btn { width: 100%; }
        .status-title { font-size: 1.4rem; }
        .badge-status { font-size: 11px; padding: 6px 14px; }
        .btn-status { font-size: 13px; padding: 12px 16px; }
        .item-row { font-size: 12px; }
        .nav-back-status {
            font-size: 12px;
            padding: 5px 12px;
            margin-bottom: 12px;
        }
        .breadcrumb-status {
            font-size: 11px;
            margin-bottom: 12px;
        }
    }

    @media (prefers-color-scheme: dark) {
        .status-card {
            background: #1f2937;
            border-color: #374151;
        }
        .order-details-card {
            background: #1f2937;
            border-color: #374151;
        }
        .status-title {
            color: #f3f4f6;
        }
        .status-desc {
            color: #9ca3af;
        }
        .details-title {
            color: #f3f4f6;
            border-color: #374151;
        }
        .item-row span:first-child {
            color: #9ca3af;
        }
        .item-row span:last-child {
            color: #f3f4f6;
        }
        .btn-outline-status {
            background: #1f2937;
            color: #f3f4f6;
            border-color: #374151;
        }
        .btn-outline-status:hover {
            background: #374151;
        }
        .btn-danger-status {
            background: #1f2937;
            color: #fca5a5;
            border-color: #7f1d1d;
        }
        .btn-danger-status:hover {
            background: #374151;
        }
        .btn-danger-disabled {
            background: #374151;
            color: #6b7280;
            border-color: #4b5563;
        }
        .btn-outline-secondary-status {
            background: #1f2937;
            color: #9ca3af;
            border-color: #374151;
        }
        .btn-outline-secondary-status:hover {
            background: #374151;
        }
        .modal-box-status {
            background: #1f2937;
        }
        .modal-box-status h3 {
            color: #f3f4f6;
        }
        .modal-box-status p {
            color: #9ca3af;
        }
        .modal-box-status .btn-group .btn-cancel-modal {
            background: #374151;
            color: #e5e7eb;
        }
        .modal-box-status .btn-group .btn-cancel-modal:hover {
            background: #4b5563;
        }
        .badge-cash { background: #374151; color: #e5e7eb; }
        .badge-qris { background: #1e3a5f; color: #93c5fd; }
        .badge-waiting { background: #422b00; color: #fbbf24; }
        .badge-processing { background: #1e3a5f; color: #93c5fd; }
        .badge-success { background: #064e3b; color: #6ee7b7; }
        .badge-danger { background: #7f1d1d; color: #fca5a5; }
        .badge-paid { background: #064e3b; color: #6ee7b7; }
        .badge-pending { background: #422b00; color: #fbbf24; }
        .badge-failed { background: #7f1d1d; color: #fca5a5; }
        .nav-back-status {
            color: #9ca3af;
            background: rgba(255,255,255,0.06);
        }
        .nav-back-status:hover {
            background: rgba(255,255,255,0.1);
            color: #d4a373;
        }
        .breadcrumb-status {
            color: #9ca3af;
        }
        .breadcrumb-status a {
            color: #9ca3af;
        }
        .breadcrumb-status a:hover {
            color: #d4a373;
        }
        .breadcrumb-status .current {
            color: #d4a373;
        }
        .breadcrumb-status .separator {
            color: #4b5563;
        }
    }
</style>
@endpush

@section('content')
<div class="status-container">
    
    <a href="{{ route('customer.menu', $order->table->qr_token) }}" class="nav-back-status">
        <i class="fas fa-arrow-left"></i> Kembali ke Menu
    </a>

    <div class="breadcrumb-status">
        <a href="{{ route('customer.home', $order->table->id) }}">
            <i class="fas fa-home"></i> Beranda
        </a>
        <span class="separator">/</span>
        <a href="{{ route('customer.menu', $order->table->qr_token) }}">Menu</a>
        <span class="separator">/</span>
        <span class="current">Status Pesanan</span>
    </div>

    <div style="text-align:center; margin-bottom: 30px;">
        <h1 class="font-serif" style="color: var(--primary); font-size: 2.5rem; margin-bottom: 5px;">Terima Kasih</h1>
        <p style="color: var(--text-light); font-size: 14px;">
            Nomor Pesanan: <span style="font-family: monospace; font-weight: 700;">{{ $order->transaction_id }}</span>
        </p>
        <p class="last-updated" id="last-updated">
            <i class="fas fa-clock"></i> Terakhir diperbarui: {{ now()->format('H:i:s') }}
        </p>
        <p class="last-updated" style="font-size: 11px; color: #9ca3af; margin-top: 2px;">
            Halaman akan refresh otomatis jika ada perubahan status
        </p>
    </div>

    {{-- ── STATUS CARD ── --}}
    <div class="status-card fade-in-up" id="status-card">
        @if($order->order_status === 'menunggu')
            <div class="status-icon-box" style="background: #fffbeb; color: #d97706;"><i class="fas fa-clock"></i></div>
            <h2 class="status-title">Menunggu Konfirmasi</h2>
            <p class="status-desc">
                @if($order->payment_method === 'qris')
                    Pembayaran Anda telah berhasil. Pesanan sedang menunggu dikonfirmasi oleh staf kami.
                @else
                    Pesanan Anda telah diterima dan sedang menunggu dikonfirmasi oleh staf kami.
                @endif
            </p>
        @elseif($order->order_status === 'diproses')
            <div class="status-icon-box" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-coffee"></i></div>
            <h2 class="status-title">Sedang Diproses</h2>
            <p class="status-desc">Barista kami sedang meracik pesanan terbaik untuk Anda. Mohon tunggu sebentar ya!</p>
        @elseif($order->order_status === 'selesai')
            <div class="status-icon-box" style="background: #f0fdf4; color: #166534;"><i class="fas fa-check-circle"></i></div>
            <h2 class="status-title">Pesanan Selesai</h2>
            <p class="status-desc">Pesanan Anda telah diantarkan. Selamat menikmati hidangan spesial dari Pivot Cafe!</p>
        @elseif($order->order_status === 'dibatalkan')
            <div class="status-icon-box" style="background: #fef2f2; color: #dc2626;"><i class="fas fa-times-circle"></i></div>
            <h2 class="status-title">Pesanan Dibatalkan</h2>
            <p class="status-desc">Mohon maaf, pesanan Anda telah dibatalkan. Silakan hubungi staf jika ada kendala.</p>
        @endif

        <div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px; flex-wrap: wrap;">
            @if($order->payment_status === 'paid')
                <span class="badge-status badge-paid">✅ Sudah Bayar</span>
            @elseif($order->payment_status === 'failed')
                <span class="badge-status badge-failed">❌ Gagal</span>
            @else
                <span class="badge-status badge-pending">⏳ Belum Bayar</span>
            @endif

            @if($order->payment_method === 'cash')
                <span class="badge-status badge-cash">💵 Tunai</span>
            @else
                <span class="badge-status badge-qris">📱 QRIS</span>
            @endif
        </div>
    </div>

    {{-- ── DETAIL PESANAN ── --}}
    <div class="order-details-card fade-in-up">
        <h3 class="details-title">Detail Pesanan</h3>
        
        <div class="item-row">
            <span>Meja</span>
            <span>Meja {{ $order->table->number }}</span>
        </div>
        <div class="item-row">
            <span>Nama Pemesan</span>
            <span>{{ $order->customer_name }}</span>
        </div>
        <div class="item-row">
            <span>Metode Bayar</span>
            <span>{{ $order->payment_method === 'cash' ? '💵 Tunai' : '📱 QRIS' }}</span>
        </div>
        <div class="item-row">
            <span>Status Bayar</span>
            <span>
                @if($order->payment_status === 'paid')
                    ✅ Sudah Bayar
                @elseif($order->payment_status === 'failed')
                    ❌ Gagal
                @else
                    ⏳ Belum Bayar
                @endif
            </span>
        </div>
        <div class="item-row">
            <span>Waktu Pesan</span>
            <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
        </div>
        
        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px dashed #e5e7eb;">
            @foreach($order->items as $item)
            <div class="item-row">
                <span>
                    {{ $item->quantity }}x 
                    @if($item->menu_id)
                        {{ $item->menu->name }}
                    @elseif($item->retail_product_id)
                        {{ $item->retailProduct->name }}
                    @else
                        Item tidak diketahui
                    @endif
                </span>
                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 15px; padding-top: 15px; border-top: 2px solid var(--primary);">
            <div class="item-row" style="font-size: 1.1rem; font-weight: 700;">
                <span style="color: var(--primary) !important;">Total Pembayaran</span>
                <span style="color: var(--primary);">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->notes)
        <div style="margin-top: 20px; padding: 15px; background: #f8fafc; border-radius: 15px; font-size: 13px; color: var(--text-light); font-style: italic; border: 1px solid #e5e7eb;">
            <strong>Catatan:</strong> "{{ $order->notes }}"
        </div>
        @endif
    </div>

    <form action="{{ route('customer.cancel', $order->table->qr_token) }}" method="POST" id="cancel-form">
        @csrf
        <input type="hidden" name="transaction_id" value="{{ $order->transaction_id }}">
    </form>

    {{-- ── TOMBOL AKSI ── --}}
    <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 40px;">
        
        @if(in_array($order->order_status, ['menunggu', 'diproses']) && $order->payment_method === 'cash' && $order->payment_status === 'pending')
            <button type="button" 
                    onclick="openCancelOrderModal()" 
                    class="btn-status btn-danger-status">
                <i class="fas fa-times-circle"></i> Batalkan Pesanan
            </button>
        @endif

        @if($order->order_status === 'selesai' && !$order->feedback)
            <a href="{{ route('customer.feedback', $order->transaction_id) }}" 
               class="btn-status btn-primary-status">
                <i class="fas fa-star"></i> Beri Penilaian & Saran
            </a>
        @endif

        @if($order->payment_status === 'paid' && $order->order_status !== 'selesai')
            <a href="{{ route('customer.nota.download', $order->transaction_id) }}" 
               class="btn-status btn-outline-secondary-status">
                <i class="fas fa-file-pdf"></i> Unduh Struk Digital (PDF)
            </a>
        @endif

        <a href="{{ route('customer.menu', $order->table->qr_token) }}" 
           class="btn-status btn-accent-status">
            <i class="fas fa-utensils"></i> Pesan Menu Lain
        </a>
    </div>
</div>

{{-- ── MODAL KONFIRMASI BATAL ── --}}
<div class="modal-overlay-status" id="cancel-order-modal">
    <div class="modal-box-status">
        <div class="icon">⚠️</div>
        <h3>Batalkan Pesanan?</h3>
        <p>Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="btn-group">
            <button class="btn btn-cancel-modal" onclick="closeCancelOrderModal()">Kembali</button>
            <button class="btn btn-danger-modal" onclick="confirmCancelOrder()">Ya, Batalkan</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── VARIABEL ──
    const currentStatus = '{{ $order->order_status }}';
    const transactionId = '{{ $order->transaction_id }}';
    let lastStatus = currentStatus;

    // ── FUNGSI CEK STATUS ──
    function checkStatus() {
        fetch(`/order/status/${transactionId}/peek`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            // Jika status berubah, reload halaman
            if (data.order_status !== lastStatus) {
                lastStatus = data.order_status;
                window.location.reload();
            }
            
            // Update waktu terakhir
            const now = new Date();
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                           now.getMinutes().toString().padStart(2, '0') + ':' + 
                           now.getSeconds().toString().padStart(2, '0');
            const el = document.getElementById('last-updated');
            if (el) {
                el.innerHTML = `<i class="fas fa-clock"></i> Terakhir diperbarui: ${timeStr}`;
            }
        })
        .catch(error => {
            console.error('Error checking status:', error);
        });
    }

    // ── MODAL BATAL ──
    function openCancelOrderModal() {
        document.getElementById('cancel-order-modal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeCancelOrderModal() {
        document.getElementById('cancel-order-modal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function confirmCancelOrder() {
        closeCancelOrderModal();
        document.getElementById('cancel-form').submit();
    }

    // ── START POLLING ──
    document.addEventListener('DOMContentLoaded', function() {
        // Hanya polling jika status belum final
        if (!['selesai', 'dibatalkan'].includes(currentStatus)) {
            // Cek setiap 5 detik
            setInterval(checkStatus, 5000);
            
            // Cek pertama kali setelah 1 detik
            setTimeout(checkStatus, 1000);
        }
    });
</script>
@endpush