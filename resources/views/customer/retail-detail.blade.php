@extends('layouts.customer')

@section('title', $retailProduct->name . ' — Pivot Cafe')

@push('styles')
<style>
    .detail-container {
        padding-top: 120px;
        padding-bottom: 80px;
        padding-left: 20px;
        padding-right: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── BACK LINK (SAMA SEPERTI DETAIL MENU) ── */
    .back-link-detail {
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

    .back-link-detail:hover {
        background: rgba(0,0,0,0.08);
        color: var(--primary);
        transform: translateX(-4px);
    }

    .back-link-detail i {
        font-size: 14px;
    }

    /* ── BREADCRUMB ── */
    .breadcrumb-detail {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 24px;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .breadcrumb-detail a {
        color: var(--text-light);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-detail a:hover {
        color: var(--primary);
    }
    .breadcrumb-detail .separator {
        color: #d1d5db;
    }
    .breadcrumb-detail .current {
        color: var(--primary);
        font-weight: 600;
    }

    /* ── CARD DETAIL ── */
    .detail-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        max-width: 1000px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    @media (min-width: 768px) {
        .detail-card {
            flex-direction: row;
            min-height: 500px;
            border-radius: 28px;
        }
        .detail-img-side {
            width: 48%;
            flex-shrink: 0;
        }
        .detail-content-side {
            padding: 48px 44px !important;
        }
    }

    .detail-img-side {
        position: relative;
        height: 300px;
        background: #f8f6f2;
        overflow: hidden;
    }

    @media (min-width: 768px) {
        .detail-img-side {
            height: auto;
            min-height: 500px;
        }
    }

    .detail-img-side img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .detail-img-side:hover img {
        transform: scale(1.03);
    }

    /* ── BADGE DI GAMBAR ── */
    .detail-img-badges {
        position: absolute;
        top: 16px;
        left: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        z-index: 2;
    }

    .detail-img-badge {
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-retail {
        background: rgba(254, 243, 199, 0.95);
        color: #92400e;
        border: 1px solid #fcd34d;
    }

    .badge-unavailable {
        background: rgba(220, 38, 38, 0.92);
        color: white;
    }

    .badge-stock {
        background: rgba(59, 130, 246, 0.92);
        color: white;
        border: 1px solid #60a5fa;
    }

    .badge-stock-low {
        background: rgba(245, 158, 11, 0.92);
        color: white;
        border: 1px solid #fbbf24;
        animation: pulse-stock 1.5s ease-in-out infinite;
    }

    @keyframes pulse-stock {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .detail-content-side {
        padding: 28px 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .detail-category {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 6px;
    }

    .detail-name {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 6px;
        line-height: 1.2;
    }

    @media (min-width: 768px) {
        .detail-name {
            font-size: 2.6rem;
        }
    }

    .detail-price {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .detail-price small {
        font-size: 13px;
        font-weight: 400;
        color: var(--text-light);
    }

    .detail-price .stock-info {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 50px;
        background: #f0fdf4;
        color: #16a34a;
    }

    .detail-price .stock-info.low {
        background: #fef3c7;
        color: #d97706;
    }

    .detail-desc {
        color: var(--text-light);
        line-height: 1.8;
        margin-bottom: 28px;
        font-size: 14px;
        border-left: 3px solid var(--accent);
        padding-left: 16px;
    }

    .detail-divider {
        border: 0;
        border-top: 1.5px dashed rgba(0,0,0,0.06);
        margin: 4px 0 20px 0;
    }

    /* ── BADGE RETAIL DI CONTENT ── */
    .retail-badge-content {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef3c7;
        color: #92400e;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #fcd34d;
        margin-bottom: 12px;
        width: fit-content;
    }

    /* ── BUTTON ── */
    .btn-add-detail {
        width: 100%;
        padding: 16px 20px;
        border-radius: 16px;
        font-weight: 700;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-family: inherit;
        background: var(--primary);
        color: white;
        margin-top: auto;
    }

    .btn-add-detail:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(27, 67, 50, 0.25);
    }

    .btn-add-detail:active {
        transform: translateY(0);
    }

    .btn-add-detail:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    .btn-add-detail i {
        font-size: 16px;
    }

    /* ── UNAVAILABLE ── */
    .unavailable-box {
        padding: 20px;
        background: #fff8f8;
        border-radius: 16px;
        border: 1.5px solid #fed7d7;
        color: #c53030;
        text-align: center;
        margin-top: auto;
    }

    .unavailable-box i {
        font-size: 1.4rem;
        display: block;
        margin-bottom: 8px;
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme: dark) {
        .detail-card {
            background: #1f2937;
            border-color: #374151;
        }
        .detail-name {
            color: #f3f4f6;
        }
        .detail-price {
            color: #f3f4f6;
        }
        .detail-desc {
            color: #9ca3af;
        }
        .unavailable-box {
            background: #7f1d1d;
            border-color: #991b1b;
            color: #fca5a5;
        }
        .back-link-detail {
            color: #9ca3af;
            background: rgba(255,255,255,0.06);
        }
        .back-link-detail:hover {
            background: rgba(255,255,255,0.1);
            color: #d4a373;
        }
        .breadcrumb-detail {
            color: #9ca3af;
        }
        .breadcrumb-detail a {
            color: #9ca3af;
        }
        .breadcrumb-detail a:hover {
            color: #d4a373;
        }
        .breadcrumb-detail .current {
            color: #d4a373;
        }
        .breadcrumb-detail .separator {
            color: #4b5563;
        }
        .retail-badge-content {
            background: #422b00;
            color: #fbbf24;
            border-color: #92400e;
        }
        .badge-retail {
            background: rgba(68, 44, 0, 0.95);
            color: #fbbf24;
            border-color: #92400e;
        }
        .detail-divider {
            border-color: rgba(255,255,255,0.08);
        }
        .detail-price .stock-info {
            background: #064e3b;
            color: #4ade80;
        }
        .detail-price .stock-info.low {
            background: #451a03;
            color: #fbbf24;
        }
        .badge-stock {
            background: rgba(30, 58, 138, 0.92);
            border-color: #3b82f6;
        }
        .badge-stock-low {
            background: rgba(120, 53, 15, 0.92);
            border-color: #f59e0b;
        }
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .detail-container {
            padding-top: 100px;
            padding-left: 16px;
            padding-right: 16px;
        }
        .detail-img-side {
            height: 220px;
        }
        .detail-content-side {
            padding: 20px 16px !important;
        }
        .detail-name {
            font-size: 1.5rem;
        }
        .detail-price {
            font-size: 1.3rem;
        }
        .btn-add-detail {
            padding: 14px 16px;
            font-size: 14px;
        }
        .back-link-detail {
            font-size: 13px;
            padding: 6px 14px;
            margin-bottom: 16px;
        }
        .breadcrumb-detail {
            font-size: 12px;
            margin-bottom: 16px;
        }
    }

    @media (max-width: 480px) {
        .detail-container {
            padding-top: 90px;
        }
        .detail-img-side {
            height: 180px;
        }
        .detail-content-side {
            padding: 14px 12px !important;
        }
        .detail-name {
            font-size: 1.3rem;
        }
        .detail-price {
            font-size: 1.1rem;
        }
        .detail-desc {
            font-size: 12px;
            padding-left: 12px;
        }
        .btn-add-detail {
            padding: 12px 14px;
            font-size: 13px;
        }
        .back-link-detail {
            font-size: 12px;
            padding: 5px 12px;
            margin-bottom: 12px;
        }
        .breadcrumb-detail {
            font-size: 11px;
            margin-bottom: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-container">

    {{-- ── BACK LINK ── --}}
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('customer.menu', $table->qr_token) }}?category=retail-products" 
           class="back-link-detail" 
           style="margin-left: 0;">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Retail</span>
        </a>
    </div>

    {{-- ── BREADCRUMB ── --}}
    <div class="breadcrumb-detail">
        <a href="{{ route('customer.home', $table->id) }}">
            <i class="fas fa-home"></i> Beranda
        </a>
        <span class="separator">/</span>
        <a href="{{ route('customer.menu', $table->qr_token) }}">Menu</a>
        <span class="separator">/</span>
        <span class="current">Produk Retail</span>
    </div>

    {{-- ── CARD DETAIL ── --}}
    <div class="detail-card fade-in-up">
        <div class="detail-img-side">
            <img src="{{ $retailProduct->image ? asset('storage/'.$retailProduct->image) : asset('images/placeholder.png') }}"
                 alt="{{ $retailProduct->name }}" loading="lazy">
            
            {{-- Badges di atas gambar --}}
            <div class="detail-img-badges">
                <span class="detail-img-badge badge-retail">
                    <i class="fas fa-shopping-bag"></i> Retail
                </span>
                
                @if($retailProduct->stock <= 0 || !$retailProduct->is_available)
                    <span class="detail-img-badge badge-unavailable">
                        <i class="fas fa-times-circle"></i> Stok Habis
                    </span>
                @elseif($retailProduct->stock <= 5)
                    <span class="detail-img-badge badge-stock-low">
                        <i class="fas fa-exclamation-triangle"></i> Sisa {{ $retailProduct->stock }}
                    </span>
                @else
                    <span class="detail-img-badge badge-stock">
                        <i class="fas fa-check-circle"></i> Tersedia
                    </span>
                @endif
            </div>
        </div>

        <div class="detail-content-side">
            <div class="detail-category">Produk Retail</div>

            <div class="retail-badge-content">
                <i class="fas fa-shopping-bag"></i> Produk Retail
            </div>

            <h1 class="detail-name">{{ $retailProduct->name }}</h1>

            <div class="detail-price">
                Rp {{ number_format($retailProduct->price, 0, ',', '.') }}
                <small>/ kemasan</small>
                
                @if($retailProduct->is_available && $retailProduct->stock > 0)
                    @if($retailProduct->stock <= 5)
                        <span class="stock-info low">
                            <i class="fas fa-exclamation-circle"></i> Sisa {{ $retailProduct->stock }}
                        </span>
                    @else
                        <span class="stock-info">
                            <i class="fas fa-check-circle"></i> Tersedia
                        </span>
                    @endif
                @endif
            </div>

            <hr class="detail-divider">

            @if($retailProduct->description)
                <div class="detail-desc">{{ $retailProduct->description }}</div>
            @endif

            @if($retailProduct->is_available && $retailProduct->stock > 0)
                <button type="button" class="btn-add-detail"
                    onclick="openAddCartModal(
                        {{ $retailProduct->id }}, 
                        '{{ addslashes($retailProduct->name) }}', 
                        'Retail', 
                        '{{ $retailProduct->image ? asset('storage/'.$retailProduct->image) : asset('images/placeholder.png') }}', 
                        'Rp {{ number_format($retailProduct->price, 0, ',', '.') }}', 
                        '{{ addslashes($retailProduct->description ?? '') }}',
                        { isRetail: true, stock: {{ $retailProduct->stock }} }
                    )">
                    <i class="fas fa-shopping-basket"></i>
                    Tambah ke Keranjang
                </button>
            @else
                <div class="unavailable-box">
                    <i class="fas fa-info-circle"></i>
                    Maaf, produk ini sedang tidak tersedia saat ini.
                </div>
            @endif
        </div>
    </div>
</div>

@include('customer.partials.add-cart-modal')
@endsection