@extends('layouts.customer')

@section('title', 'Checkout — Pivot Cafe')

@push('styles')
<style>
    .checkout-container {
        max-width: 1000px;
        margin: 0 auto;
        padding-top: 120px;
        padding-bottom: 80px;
        padding-left: 20px;
        padding-right: 20px;
    }

    /* ── BACK LINK ── */
    .back-link-checkout {
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
        margin-bottom: 30px;
        cursor: pointer;
    }

    .back-link-checkout:hover {
        background: rgba(0,0,0,0.08);
        color: var(--primary);
        transform: translateX(-4px);
    }

    .back-link-checkout i {
        font-size: 14px;
    }

    /* ── BREADCRUMB ── */
    .breadcrumb-checkout {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 24px;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .breadcrumb-checkout a {
        color: var(--text-light);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-checkout a:hover {
        color: var(--primary);
    }
    .breadcrumb-checkout .separator {
        color: #d1d5db;
    }
    .breadcrumb-checkout .current {
        color: var(--primary);
        font-weight: 600;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
    }

    @media (min-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1.6fr 1fr;
            align-items: flex-start;
        }
    }

    .checkout-card {
        background: white;
        border-radius: 25px;
        padding: 30px;
        box-shadow: var(--shadow);
        border: var(--border);
        margin-bottom: 30px;
    }

    .checkout-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .checkout-card-title i {
        font-size: 1.2rem;
        color: var(--accent);
    }

    /* Items Table */
    .order-items-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 20px;
    }

    .order-item-row {
        display: flex;
        gap: 15px;
        align-items: center;
        padding-bottom: 20px;
        border-bottom: 1px dashed rgba(0,0,0,0.1);
    }

    .order-item-row:last-child {
        border-bottom: none;
    }

    .order-item-info {
        flex: 1;
    }

    .order-item-name {
        font-weight: 700;
        color: var(--primary);
        font-size: 15px;
        margin-bottom: 5px;
    }

    .order-item-meta {
        font-size: 12px;
        color: var(--text-light);
    }

    .order-item-qty {
        font-weight: 600;
        background: var(--bg);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 12px;
    }

    .order-item-total {
        font-weight: 700;
        color: var(--primary);
        font-size: 15px;
        min-width: 100px;
        text-align: right;
    }

    /* Form Styles */
    .form-group-p {
        margin-bottom: 25px;
    }

    .form-label-p {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: var(--text);
        margin-bottom: 10px;
    }

    .form-input-p {
        width: 100%;
        padding: 15px 20px;
        border-radius: 15px;
        border: var(--border);
        background: var(--bg);
        font-family: inherit;
        font-size: 15px;
        transition: all 0.3s;
    }

    .form-input-p:focus {
        outline: none;
        border-color: var(--accent);
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .char-counter {
        font-size: 11px;
        color: var(--text-light);
        text-align: right;
        margin-top: 5px;
    }

    /* Promo Options */
    .promo-selection {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .promo-opt {
        position: relative;
        cursor: pointer;
    }

    .promo-opt input {
        position: absolute;
        opacity: 0;
    }

    .promo-opt-box {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        border-radius: 15px;
        border: 2px solid #f0f0f0;
        transition: all 0.3s;
        background: white;
    }

    .promo-opt input:checked + .promo-opt-box {
        border-color: var(--primary);
        background: rgba(27, 67, 50, 0.02);
    }

    .promo-radio-ui {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #ddd;
        position: relative;
        flex-shrink: 0;
    }

    .promo-opt input:checked + .promo-opt-box .promo-radio-ui {
        border-color: var(--primary);
    }

    .promo-opt input:checked + .promo-opt-box .promo-radio-ui::after {
        content: '';
        position: absolute;
        inset: 4px;
        background: var(--primary);
        border-radius: 50%;
    }

    .promo-info {
        flex: 1;
    }

    .promo-code-name {
        font-weight: 700;
        font-size: 14px;
        color: var(--primary);
        margin-bottom: 2px;
    }

    .promo-code-desc {
        font-size: 11px;
        color: var(--text-light);
    }

    .promo-val-badge {
        background: var(--accent-light);
        color: var(--primary-dark);
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
    }

    /* ── PROMO DISABLED (Seperti Shopee/Gojek) ── */
    .promo-opt.promo-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .promo-opt.promo-disabled .promo-opt-box {
        background: #f9fafb;
        border-color: #e5e7eb;
    }

    .promo-opt.promo-disabled .promo-radio-ui {
        border-color: #d1d5db;
        background: #f3f4f6;
    }

    .promo-opt.promo-disabled .promo-radio-ui::after {
        display: none !important;
    }

    .promo-opt.promo-disabled .promo-code-name {
        color: #9ca3af;
    }

    .promo-opt.promo-disabled .promo-code-desc {
        color: #9ca3af;
    }

    .promo-opt.promo-disabled .promo-val-badge {
        background: #f3f4f6;
        color: #9ca3af;
    }

    .promo-opt.promo-disabled .promo-code-name span {
        color: #dc2626 !important;
    }

    .badge-disabled {
        background: #f3f4f6 !important;
        color: #9ca3af !important;
    }

    /* Dark Mode */
    @media (prefers-color-scheme: dark) {
        .promo-opt.promo-disabled .promo-opt-box {
            background: #1f2937;
            border-color: #374151;
        }
        .promo-opt.promo-disabled .promo-code-name {
            color: #6b7280;
        }
        .promo-opt.promo-disabled .promo-code-desc {
            color: #6b7280;
        }
        .promo-opt.promo-disabled .promo-val-badge {
            background: #374151;
            color: #6b7280;
        }
        .promo-opt.promo-disabled .promo-code-name span {
            color: #fca5a5 !important;
        }
    }

    /* Payment Methods */
    .payment-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .pay-opt {
        position: relative;
        cursor: pointer;
    }

    .pay-opt input {
        position: absolute;
        opacity: 0;
    }

    .pay-opt-box {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        border-radius: 15px;
        border: 2px solid #f0f0f0;
        transition: all 0.3s;
        background: white;
    }

    .pay-opt input:checked + .pay-opt-box {
        border-color: var(--primary);
        background: rgba(27, 67, 50, 0.02);
    }

    .pay-icon {
        width: 45px;
        height: 45px;
        background: var(--bg);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary);
    }

    .pay-opt input:checked + .pay-opt-box .pay-icon {
        background: var(--primary);
        color: white;
    }

    /* Summary */
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .summary-total {
        margin-top: 20px;
        padding-top: 20px;
        border-top: var(--border);
        display: flex;
        justify-content: space-between;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        pointer-events: none;
    }

    .empty-cart-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        border-radius: 15px;
        padding: 15px 20px;
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* ── QRIS MODAL ── */
    #qris-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(5px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #qris-modal.show {
        display: flex;
        opacity: 1;
    }

    #qris-modal .modal-content {
        background: white;
        padding: 30px;
        border-radius: 28px;
        max-width: 360px;
        width: 100%;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }

    #qris-modal.show .modal-content {
        transform: translateY(0);
    }

    .qr-box {
        background: #fff;
        padding: 15px;
        border-radius: 20px;
        display: inline-block;
        margin: 20px 0;
        border: 1px solid #eee;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.03);
    }

    .qr-box img {
        width: 180px;
        height: 180px;
        display: block;
        margin: 0 auto;
    }

    /* ── MODAL KONFIRMASI KEMBALI KE MENU ── */
    #back-confirm-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 9997;
        justify-content: center;
        align-items: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #back-confirm-modal.show {
        display: flex;
        opacity: 1;
    }

    #back-confirm-modal .modal-content {
        background: white;
        padding: 30px 35px 35px;
        border-radius: 24px;
        max-width: 380px;
        width: 100%;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }

    #back-confirm-modal.show .modal-content {
        transform: translateY(0);
    }

    .back-confirm-icon {
        font-size: 40px;
        margin-bottom: 16px;
        color: #f59e0b;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .back-confirm-icon i {
        font-size: 40px;
    }

    .back-confirm-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 8px;
    }

    .back-confirm-desc {
        font-size: 14px;
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 28px;
    }

    .back-confirm-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .back-confirm-buttons button {
        width: 100%;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-back-stay {
        background: var(--primary);
        color: white;
        order: 1;
    }

    .btn-back-stay:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(27, 67, 50, 0.2);
    }

    .btn-back-leave {
        background: transparent;
        color: var(--danger);
        border: 1.5px solid var(--danger);
        order: 2;
    }

    .btn-back-leave:hover {
        background: #fee2e2;
        transform: translateY(-2px);
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme: dark) {
        .checkout-card {
            background: #1f2937;
            border-color: #374151;
        }
        .checkout-card-title {
            color: #f3f4f6;
        }
        .breadcrumb-checkout {
            color: #9ca3af;
        }
        .breadcrumb-checkout a {
            color: #9ca3af;
        }
        .breadcrumb-checkout a:hover {
            color: #d4a373;
        }
        .breadcrumb-checkout .current {
            color: #d4a373;
        }
        .breadcrumb-checkout .separator {
            color: #4b5563;
        }
        .back-link-checkout {
            color: #9ca3af;
            background: rgba(255,255,255,0.06);
        }
        .back-link-checkout:hover {
            background: rgba(255,255,255,0.1);
            color: #d4a373;
        }
        .order-item-name {
            color: #f3f4f6;
        }
        .order-item-total {
            color: #f3f4f6;
        }
        .summary-total {
            color: #f3f4f6;
            border-top-color: #374151;
        }
        .form-input-p {
            background: #374151;
            border-color: #4b5563;
            color: #f3f4f6;
        }
        .form-label-p {
            color: #f3f4f6;
        }
        .promo-opt-box {
            background: #1f2937;
            border-color: #374151;
        }
        .promo-opt input:checked + .promo-opt-box {
            border-color: #d4a373;
            background: rgba(212, 163, 115, 0.05);
        }
        .pay-opt-box {
            background: #1f2937;
            border-color: #374151;
        }
        .pay-opt input:checked + .pay-opt-box {
            border-color: #d4a373;
            background: rgba(212, 163, 115, 0.05);
        }
        .pay-icon {
            background: #374151;
            color: #f3f4f6;
        }
        .pay-opt input:checked + .pay-opt-box .pay-icon {
            background: #d4a373;
            color: #1f2937;
        }
        #qris-modal .modal-content {
            background: #1f2937;
        }
        #back-confirm-modal .modal-content {
            background: #1f2937;
        }
        .back-confirm-title {
            color: #f3f4f6;
        }
        .back-confirm-desc {
            color: #9ca3af;
        }
        .btn-back-leave {
            color: #fca5a5;
            border-color: #fca5a5;
        }
        .btn-back-leave:hover {
            background: #7f1d1d;
        }
        .btn-back-stay {
            background: #d4a373;
            color: #1f2937;
        }
        .btn-back-stay:hover {
            background: #faedcd;
        }
        .empty-cart-warning {
            background: #422b00;
            color: #fbbf24;
            border-color: #92400e;
        }
        .back-confirm-icon {
            color: #fbbf24;
        }
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .checkout-container {
            padding-top: 100px;
            padding-left: 16px;
            padding-right: 16px;
        }
        .checkout-card {
            padding: 20px;
        }
        .checkout-card-title {
            font-size: 1.2rem;
        }
        .order-item-row {
            flex-wrap: wrap;
        }
        .order-item-total {
            min-width: auto;
            text-align: left;
            width: 100%;
            padding-left: 0;
        }
        .back-link-checkout {
            font-size: 13px;
            padding: 6px 14px;
            margin-bottom: 16px;
        }
        .breadcrumb-checkout {
            font-size: 12px;
            margin-bottom: 16px;
        }
        .promo-opt-box {
            padding: 15px;
        }
        .pay-opt-box {
            padding: 15px;
        }
        #back-confirm-modal .modal-content {
            padding: 25px 20px;
            margin: 10px;
        }
        .back-confirm-buttons button {
            padding: 14px 16px;
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .checkout-container {
            padding-top: 90px;
            padding-left: 12px;
            padding-right: 12px;
        }
        .checkout-card {
            padding: 16px;
        }
        .checkout-card-title {
            font-size: 1rem;
        }
        .form-input-p {
            padding: 12px 16px;
            font-size: 14px;
        }
        .back-link-checkout {
            font-size: 12px;
            padding: 5px 12px;
            margin-bottom: 12px;
        }
        .breadcrumb-checkout {
            font-size: 11px;
            margin-bottom: 12px;
        }
        .order-item-name {
            font-size: 13px;
        }
        .order-item-total {
            font-size: 13px;
        }
        .summary-total {
            font-size: 1.1rem;
        }
        #qris-modal .modal-content {
            padding: 20px;
            margin: 10px;
        }
        #back-confirm-modal .modal-content {
            padding: 20px 16px;
            margin: 10px;
        }
        .qr-box img {
            width: 140px;
            height: 140px;
        }
        .back-confirm-icon i {
            font-size: 32px;
        }
        .back-confirm-title {
            font-size: 16px;
        }
        .back-confirm-desc {
            font-size: 13px;
        }
        .back-confirm-buttons button {
            padding: 12px 14px;
            font-size: 14px;
        }
    }
</style>
@endpush

@section('content')
<div class="checkout-container">

    {{-- ── BACK LINK ── --}}
    <a href="#" class="back-link-checkout" onclick="confirmBackToMenu(event)">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Menu</span>
    </a>

    {{-- ── BREADCRUMB ── --}}
    <div class="breadcrumb-checkout">
        <a href="{{ route('customer.home', $table->id) }}">
            <i class="fas fa-home"></i> Beranda
        </a>
        <span class="separator">/</span>
        <a href="{{ route('customer.menu', $table->qr_token) }}">Menu</a>
        <span class="separator">/</span>
        <span class="current">Checkout</span>
    </div>

    <h1 class="font-serif" style="margin-bottom: 40px; font-size: 2.5rem; color: var(--primary);">Konfirmasi Pesanan</h1>

    @if(empty($cart))
        <div class="empty-cart-warning">
            <i class="fas fa-exclamation-triangle"></i>
            Keranjang Anda kosong. Silakan tambahkan menu terlebih dahulu sebelum checkout.
        </div>
        <a href="{{ route('customer.menu', $table->qr_token) }}" class="btn btn-primary">
            Kembali ke Menu
        </a>
    @else

    <div class="checkout-grid">
        <div class="checkout-left">

            {{-- Form Checkout --}}
            <form action="{{ route('customer.checkout.store', $table->qr_token) }}" method="POST" id="checkout-form">
                @csrf

                <div class="checkout-card fade-in-up">
                    <h2 class="checkout-card-title">Data Diri</h2>

                    <div class="form-group-p">
                        <label class="form-label-p" for="customer_name">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" class="form-input-p"
                            value="{{ old('customer_name') }}" placeholder="Contoh: Budi Santoso"
                            minlength="3" maxlength="100" required autocomplete="name">
                        @error('customer_name') <div style="color:var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group-p" style="margin-bottom:0">
                        <label class="form-label-p" for="notes">Catatan Pesanan (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3" class="form-input-p" style="border-radius: 20px; resize: none;"
                            placeholder="Contoh: Es sedikit, kopi dipisah, dll..." maxlength="255">{{ old('notes') }}</textarea>
                        <div class="char-counter" id="notes-counter">0 / 255</div>
                        @error('notes') <div style="color:var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                @if($promos->count() > 0)
<div class="checkout-card fade-in-up">
    <h2 class="checkout-card-title">Pakai Promo</h2>

    <div class="promo-selection">
        {{-- No Promo --}}
        <label class="promo-opt">
            <input type="radio" name="promo_code" value=""
                {{ request('promo') ? '' : 'checked' }} onchange="onPromoChange(this)">
            <div class="promo-opt-box">
                <div class="promo-radio-ui"></div>
                <div class="promo-info">
                    <div class="promo-code-name">Tidak Pakai Promo</div>
                </div>
            </div>
        </label>

        @foreach($promos as $promo)
        <label class="promo-opt {{ !$promo->is_eligible ? 'promo-disabled' : '' }}">
            <input type="radio" name="promo_code" value="{{ $promo->code }}"
                {{ request('promo') === $promo->code ? 'checked' : '' }}
                data-type="{{ $promo->discount_type }}"
                data-value="{{ $promo->discount_value }}"
                data-eligible="{{ $promo->is_eligible ? 'true' : 'false' }}"
                {{ !$promo->is_eligible ? 'disabled' : '' }}
                onchange="onPromoChange(this)">
            <div class="promo-opt-box">
                <div class="promo-radio-ui"></div>
                <div class="promo-info">
                    <div class="promo-code-name">
                        {{ $promo->code }}
                        @if(!$promo->is_eligible)
                            <span style="font-size:9px; color:#dc2626; font-weight:400; margin-left:6px;">
                                <i class="fas fa-lock"></i> Tidak Memenuhi Syarat
                            </span>
                        @endif
                    </div>
                    <div class="promo-code-desc">
                        {{ $promo->description }}
                        @if(!$promo->is_eligible)
                            <br><small style="color:#dc2626; font-size:10px;">
                                <i class="fas fa-exclamation-circle"></i> {{ $promo->ineligibility_reason }}
                            </small>
                        @else
                            @if($promo->min_order > 0)
                                <br><small style="color:#6b7280; font-size:10px;">
                                    <i class="fas fa-info-circle"></i> Min. belanja Rp {{ number_format($promo->min_order, 0, ',', '.') }}
                                </small>
                            @endif
                            @if($promo->category_id)
                                <br><small style="color:#6b7280; font-size:10px;">
                                    <i class="fas fa-tag"></i> {{ $promo->category->name }}
                                </small>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="promo-val-badge {{ !$promo->is_eligible ? 'badge-disabled' : '' }}">
                    {{ $promo->discount_type === 'percent' ? $promo->discount_value.'%' : 'Rp '.number_format($promo->discount_value,0,',','.') }} OFF
                </div>
            </div>
        </label>
        @endforeach
    </div>
    <p style="font-size:11px;color:var(--text-light);margin-top:12px;margin-bottom:0;">
        <i class="fas fa-info-circle"></i> Diskon final akan diverifikasi ulang oleh sistem sebelum pesanan diproses.
    </p>
</div>
@else
<input type="hidden" name="promo_code" value="">
@endif

                <div class="checkout-card fade-in-up">
                    <h2 class="checkout-card-title">Pembayaran</h2>

                    <div class="payment-grid">
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                            <div class="pay-opt-box">
                                <div class="pay-icon"><i class="fas fa-money-bill-wave"></i></div>
                                <div class="pay-info">
                                    <div style="font-weight: 700; color: var(--primary);">Tunai (Kasir)</div>
                                    <div style="font-size: 12px; color: var(--text-light);">Bayar di kasir setelah pesanan dibuat</div>
                                </div>
                            </div>
                        </label>

                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="qris" {{ old('payment_method') === 'qris' ? 'checked' : '' }}>
                            <div class="pay-opt-box">
                                <div class="pay-icon"><i class="fas fa-qrcode"></i></div>
                                <div class="pay-info">
                                    <div style="font-weight: 700; color: var(--primary);">QRIS</div>
                                    <div style="font-size: 12px; color: var(--text-light);">Scan QRIS untuk pembayaran</div>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div id="payment-error-slot"></div>
                    @error('payment_method') <div style="color:var(--danger); font-size: 12px; margin-top: 10px;">{{ $message }}</div> @enderror
                </div>
            </form>
        </div>

        <div class="checkout-right">
            <div class="checkout-card fade-in-up" style="position: sticky; top: 100px;">
                <h2 class="checkout-card-title">Ringkasan</h2>

                <div class="order-items-list">
                    @foreach($cart as $menuId => $item)
                    <div class="order-item-row">
                        <div class="order-item-info">
                            <div class="order-item-name">{{ $item['name'] }}</div>
                            @if(!empty($item['notes']))
                            <div style="font-size: 11px; color: var(--accent); font-weight: 500; margin-bottom: 5px;">
                                <i class="far fa-comment-dots"></i> {{ $item['notes'] }}
                            </div>
                            @endif
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span class="order-item-qty">{{ $item['quantity'] }}x</span>
                                <span class="order-item-meta">@ Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="order-item-total">Rp {{ number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>

                <div style="margin-top: 25px;">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span style="font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-row" id="discount-row" style="color: var(--success); display: none;">
                        <span>Diskon (<span id="discount-label"></span>)</span>
                        <span id="discount-display">- Rp 0</span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span id="total-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="button" id="checkout-submit-btn" class="btn btn-primary btn-block" style="margin-top: 30px; padding: 18px;" onclick="handleCheckout()">
                    <i class="fas fa-shopping-basket"></i> Konfirmasi & Pesan
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- ── MODAL KONFIRMASI KEMBALI KE MENU ── --}}
<div id="back-confirm-modal">
    <div class="modal-content">
        <div class="back-confirm-icon">
            <i class="fas fa-arrow-left"></i>
        </div>
        <h3 class="back-confirm-title">Kembali ke Menu?</h3>
        <div class="back-confirm-desc">
            Data yang diisi akan hilang
        </div>
        <div class="back-confirm-buttons">
            <button type="button" class="btn-back-stay" onclick="closeBackConfirm()">
                Lanjutkan
            </button>
            <button type="button" class="btn-back-leave" onclick="leaveCheckout()">
                Ya, Kembali
            </button>
        </div>
    </div>
</div>

{{-- ── MODAL QRIS ── --}}
<div id="qris-modal">
    <div class="modal-content">
        <h3 style="font-family: 'Playfair Display', serif; color: var(--primary); margin-bottom: 8px;">Scan QRIS</h3>
        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 10px;">Lakukan pembayaran untuk menyelesaikan pesanan Anda.</p>

        <div class="qr-box">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PivotCaffeSimulasi" alt="QRIS" loading="lazy">
        </div>

        <div style="background: var(--bg); padding: 12px; border-radius: 12px; font-size: 13px; color: var(--primary); margin-bottom: 20px;">
            Total Bayar: <span id="modal-total-display" style="color: var(--accent); font-weight: 800; font-size: 1.1rem;">Rp 0</span>
        </div>

        <button type="button" id="modal-confirm-btn" class="btn btn-primary" style="width: 100%; padding: 14px; border-radius: 12px; font-weight: 600; cursor: pointer; border: none; background: #1B4332; color: #ffffff;" onclick="submitCheckoutForm()">
            Saya Sudah Bayar
        </button>

        <button type="button" id="modal-cancel-btn" style="width: 100%; padding: 14px; border-radius: 12px; font-weight: 600; cursor: pointer; background: transparent; border: 1px solid #d1d5db; color: #6b7280; margin-top: 12px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='transparent'" onclick="closeQrisModal()">
            Batal
        </button>
    </div>
</div>

@include('customer.partials.add-cart-modal')
@endsection

@push('scripts')
<script>
const SUBTOTAL = {{ $subtotal }};
let currentTotal = SUBTOTAL;
let isSubmitting = false;
let selectedPaymentMethod = null;
let isBackModalOpen = false;

function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

// ── PROMO ──
function onPromoChange(radio) {
    const code = radio.value;
    const type = radio.dataset.type || '';
    const val = parseFloat(radio.dataset.value || 0);
    const isEligible = radio.dataset.eligible === 'true';

    let discount = 0;

    // Hanya proses jika promo eligible
    if (code && isEligible) {
        if (type === 'percent') {
            discount = SUBTOTAL * (val / 100);
        } else if (type === 'fixed') {
            discount = Math.min(val, SUBTOTAL);
        }
    }

    currentTotal = SUBTOTAL - discount;

    const discountRow = document.getElementById('discount-row');

    if (discount > 0) {
        document.getElementById('discount-label').textContent = code;
        document.getElementById('discount-display').textContent = '- ' + formatRp(discount);
        discountRow.style.display = 'flex';
    } else {
        discountRow.style.display = 'none';
    }

    document.getElementById('total-display').textContent = formatRp(currentTotal);
}

// ── MODAL KONFIRMASI KEMBALI KE MENU ──
function confirmBackToMenu(event) {
    event.preventDefault();
    
    if (isBackModalOpen) return;
    isBackModalOpen = true;
    
    const modal = document.getElementById('back-confirm-modal');
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeBackConfirm() {
    const modal = document.getElementById('back-confirm-modal');
    modal.classList.remove('show');
    isBackModalOpen = false;
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

function leaveCheckout() {
    closeBackConfirm();
    isBackModalOpen = false;
    setTimeout(() => {
        window.location.href = "{{ route('customer.menu', $table->qr_token) }}";
    }, 400);
}

// ── HANDLE CHECKOUT ──
function handleCheckout() {
    const nameValid = validateCustomerName();
    if (!nameValid) {
        document.getElementById('customer_name').focus();
        return;
    }

    const paymentMethod = validatePaymentMethod();
    if (!paymentMethod) {
        return;
    }

    selectedPaymentMethod = paymentMethod.value;

    if (selectedPaymentMethod === 'cash') {
        submitCheckoutForm();
        return;
    }

    if (selectedPaymentMethod === 'qris') {
        openQrisModal();
    }
}

// ── QRIS MODAL ──
function openQrisModal() {
    document.getElementById('modal-total-display').textContent = formatRp(currentTotal);

    const modal = document.getElementById('qris-modal');
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeQrisModal() {
    const modal = document.getElementById('qris-modal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

// ── SUBMIT FORM ──
function submitCheckoutForm() {
    if (isSubmitting) return;
    isSubmitting = true;

    const submitBtn = document.getElementById('checkout-submit-btn');
    const modalConfirmBtn = document.getElementById('modal-confirm-btn');
    const modalCancelBtn = document.getElementById('modal-cancel-btn');

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Memproses...';
    }
    if (modalConfirmBtn) {
        modalConfirmBtn.disabled = true;
        modalConfirmBtn.textContent = 'Memproses...';
    }
    if (modalCancelBtn) {
        modalCancelBtn.disabled = true;
    }

    document.getElementById('checkout-form').submit();
}

// ── VALIDASI ──
function validateCustomerName() {
    const nameInput = document.getElementById('customer_name');
    const value = nameInput.value.trim();

    if (value === '') {
        showFieldError(nameInput, 'Nama Lengkap wajib diisi untuk memproses pesanan.');
        return false;
    }

    if (value.length < 3) {
        showFieldError(nameInput, 'Nama minimal 3 karakter.');
        return false;
    }

    if (value.length > 100) {
        showFieldError(nameInput, 'Nama maksimal 100 karakter.');
        return false;
    }

    clearFieldError(nameInput);
    return true;
}

function validatePaymentMethod() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (!paymentMethod) {
        showPaymentError('Silakan pilih metode pembayaran.');
        return null;
    }
    clearPaymentError();
    return paymentMethod;
}

function showFieldError(input, message) {
    input.style.borderColor = '#dc3545';
    input.style.backgroundColor = 'rgba(220,53,69,0.05)';

    let errorMessage = input.parentNode.querySelector('.js-error-msg');
    if (!errorMessage) {
        errorMessage = document.createElement('div');
        errorMessage.className = 'js-error-msg';
        errorMessage.style.color = '#dc3545';
        errorMessage.style.fontSize = '12px';
        errorMessage.style.marginTop = '5px';
        input.parentNode.appendChild(errorMessage);
    }
    errorMessage.textContent = message;
}

function clearFieldError(input) {
    input.style.borderColor = '';
    input.style.backgroundColor = '';
    const errorMessage = input.parentNode.querySelector('.js-error-msg');
    if (errorMessage) errorMessage.remove();
}

function showPaymentError(message) {
    const slot = document.getElementById('payment-error-slot');
    let err = slot.querySelector('.js-payment-error');
    if (!err) {
        err = document.createElement('div');
        err.className = 'js-payment-error';
        err.style.color = '#dc3545';
        err.style.fontSize = '12px';
        err.style.marginTop = '10px';
        slot.appendChild(err);
    }
    err.textContent = message;
}

function clearPaymentError() {
    const slot = document.getElementById('payment-error-slot');
    const err = slot.querySelector('.js-payment-error');
    if (err) err.remove();
}

// ── DOMContentLoaded ──
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('customer_name');

    if (nameInput) {
        nameInput.addEventListener('input', function () {
            if (this.value.trim().length >= 3 && this.value.trim().length <= 100) {
                clearFieldError(this);
            }
        });
    }

    const notesInput = document.getElementById('notes');
    const notesCounter = document.getElementById('notes-counter');

    if (notesInput && notesCounter) {
        const updateCounter = () => {
            notesCounter.textContent = notesInput.value.length + ' / 255';
        };
        updateCounter();
        notesInput.addEventListener('input', updateCounter);
    }

    document.querySelectorAll('input[name="payment_method"]').forEach(function (el) {
        el.addEventListener('change', clearPaymentError);
    });

    const checkedPromo = document.querySelector('input[name="promo_code"]:checked');
    if (checkedPromo && checkedPromo.value) {
        onPromoChange(checkedPromo);
    }
});
</script>
@endpush