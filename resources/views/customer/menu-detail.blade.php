@extends('layouts.customer')

@section('title', $menu->name . ' — Pivot Cafe')

@push('styles')
<style>
    /* ── HERO SECTION ── */
    .detail-hero {
        padding-top: 120px;
        padding-bottom: 40px;
    }

    /* ── BACK LINK (TETAP SAMA) ── */
    .detail-hero .back-link {
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
    }

    .detail-hero .back-link:hover {
        background: rgba(0,0,0,0.08);
        color: var(--primary);
        transform: translateX(-4px);
    }

    /* ── BREADCRUMB (TAMBAHAN BARU) ── */
    .breadcrumb-detail-menu {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 24px;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .breadcrumb-detail-menu a {
        color: var(--text-light);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-detail-menu a:hover {
        color: var(--primary);
    }
    .breadcrumb-detail-menu .separator {
        color: #d1d5db;
    }
    .breadcrumb-detail-menu .current {
        color: var(--primary);
        font-weight: 600;
    }

    /* ── MAIN CARD ── */
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

    /* ── IMAGE SIDE ── */
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

    /* ── CONTENT SIDE ── */
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
    }

    .detail-price small {
        font-size: 13px;
        font-weight: 400;
        color: var(--text-light);
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
        .detail-hero .back-link {
            color: #9ca3af;
            background: rgba(255,255,255,0.06);
        }
        .detail-hero .back-link:hover {
            background: rgba(255,255,255,0.1);
            color: #d4a373;
        }
        .breadcrumb-detail-menu {
            color: #9ca3af;
        }
        .breadcrumb-detail-menu a {
            color: #9ca3af;
        }
        .breadcrumb-detail-menu a:hover {
            color: #d4a373;
        }
        .breadcrumb-detail-menu .current {
            color: #d4a373;
        }
        .breadcrumb-detail-menu .separator {
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
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .detail-hero {
            padding-top: 100px;
            padding-bottom: 20px;
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
        .detail-hero .back-link {
            font-size: 13px;
            padding: 6px 14px;
            margin-bottom: 16px;
        }
        .breadcrumb-detail-menu {
            font-size: 12px;
            margin-bottom: 16px;
        }
    }

    @media (max-width: 480px) {
        .detail-hero {
            padding-top: 90px;
        }
        .detail-img-side {
            height: 180px;
        }
        .detail-name {
            font-size: 1.3rem;
        }
        .detail-price {
            font-size: 1.1rem;
        }
        .detail-content-side {
            padding: 14px 12px !important;
        }
        .detail-desc {
            font-size: 12px;
            padding-left: 12px;
        }
        .btn-add-detail {
            padding: 12px 14px;
            font-size: 13px;
        }
        .detail-hero .back-link {
            font-size: 12px;
            padding: 5px 12px;
            margin-bottom: 12px;
        }
        .breadcrumb-detail-menu {
            font-size: 11px;
            margin-bottom: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-hero">
    <div class="container">

        {{-- ── NAVIGASI ── --}}
        {{-- BACK LINK (TETAP SEPERTI SEBELUMNYA) --}}
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('customer.menu', $table->qr_token) }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Menu</span>
            </a>

            @if($menu->is_retail ?? false)
                <a href="{{ route('customer.menu', $table->qr_token) }}?category=retail-products" 
                   class="back-link" 
                   style="margin-left: 0;">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Retail</span>
                </a>
            @endif
        </div>

       {{-- ── BREADCRUMB ── --}}
        <div class="breadcrumb-detail-menu">
            <a href="{{ route('customer.home', $table->id) }}">
                <i class="fas fa-home"></i> Beranda
            </a>
            <span class="separator">/</span>
            <a href="{{ route('customer.menu', $table->qr_token) }}">Menu</a>
            <span class="separator">/</span>
            <span class="current">{{ $menu->name }}</span>
        </div>

        {{-- ── CARD ── --}}
        <div class="detail-card fade-in-up">

            {{-- Sisi Gambar --}}
            <div class="detail-img-side">
                <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy">
                
                {{-- Badges di atas gambar --}}
                <div class="detail-img-badges">
                    @if($menu->is_retail ?? false)
                        <span class="detail-img-badge badge-retail">
                            <i class="fas fa-shopping-bag"></i> Retail
                        </span>
                    @endif
                    
                    @if(!$menu->is_available)
                        <span class="detail-img-badge badge-unavailable">
                            <i class="fas fa-times-circle"></i> Tidak Tersedia
                        </span>
                    @endif
                </div>
            </div>

            {{-- Sisi Konten --}}
            <div class="detail-content-side">
                <div class="detail-category">{{ $menu->category->name }}</div>

                @if($menu->is_retail ?? false)
                    <div class="retail-badge-content">
                        <i class="fas fa-shopping-bag"></i> Produk Retail
                    </div>
                @endif

                <h1 class="detail-name">{{ $menu->name }}</h1>

                <div class="detail-price">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                    @if($menu->is_retail ?? false)
                        <small>/ kemasan</small>
                    @endif
                </div>

                <hr class="detail-divider">

                @if($menu->description)
                    <div class="detail-desc">{{ $menu->description }}</div>
                @endif

                @if($menu->is_available)
                    <button type="button" class="btn-add-detail"
                        onclick="openAddCartModal(
                            {{ $menu->id }}, 
                            '{{ addslashes($menu->name) }}', 
                            '{{ $menu->category->name }}', 
                            '{{ $menu->image_url }}', 
                            'Rp {{ number_format($menu->price, 0, ',', '.') }}', 
                            '{{ addslashes($menu->description ?? '') }}',
                            { isRetail: {{ ($menu->is_retail ?? false) ? 'true' : 'false' }} }
                        )">
                        <i class="fas fa-shopping-basket"></i>
                        Tambah ke Keranjang
                    </button>
                @else
                    <div class="unavailable-box">
                        <i class="fas fa-info-circle"></i>
                        Maaf, menu ini sedang tidak tersedia saat ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('customer.partials.add-cart-modal')
@endsection