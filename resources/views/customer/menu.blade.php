@extends('layouts.customer')

@section('title', 'Menu — Pivot Cafe')

@push('styles')
<style>
    /* ══ LAYOUT ══════════════════════════════════════════════════════════ */
    .menu-layout {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    @media (min-width: 992px) {
        .menu-layout {
            flex-direction: row;
            align-items: flex-start;
        }
        .menu-sidebar {
            width: 300px;
            flex-shrink: 0;
            position: sticky;
            top: 100px;
        }
        .menu-main { flex: 1; min-width: 0; }
    }

    /* ══ BREADCRUMB ══════════════════════════════════════════════════════ */
    .breadcrumb-menu {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 16px;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .breadcrumb-menu a {
        color: var(--text-light);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-menu a:hover {
        color: var(--primary);
    }
    .breadcrumb-menu .separator {
        color: #d1d5db;
    }
    .breadcrumb-menu .current {
        color: var(--primary);
        font-weight: 600;
    }

    /* ══ SIDEBAR ═════════════════════════════════════════════════════════ */
    .sidebar-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 25px;
        border: var(--border);
    }

    .sidebar-card-header {
        padding: 15px 25px;
        background: #fafafa;
        border-bottom: var(--border);
        font-weight: 700;
        font-size: 14px;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .sidebar-card-body {
        padding: 15px;
    }

    .cat-list { display: flex; flex-direction: column; gap: 5px; }
    .cat-list-item {
        display: block;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        color: var(--text-light);
        transition: all 0.3s;
    }

    .cat-list-item:hover {
        background: var(--bg);
        color: var(--primary);
        transform: translateX(5px);
    }

    .cat-list-item.active {
        background: var(--primary);
        color: white;
        font-weight: 600;
    }

    /* ══ RETAIL NAV ══════════════════════════════════════════════════════ */
    .cat-list-divider {
        height: 1px;
        background: rgba(0,0,0,0.08);
        margin: 10px 8px;
    }

    .cat-list-item-retail {
        border: 1px dashed rgba(212, 163, 115, 0.5);
    }

    .cat-list-item-retail.active {
        border-color: var(--primary);
        border-style: solid;
    }

    .tab-btn-retail {
        border-color: var(--accent) !important;
    }

    .retail-stock-warning {
        font-size: 11px;
        color: #e67e22;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 6px;
    }

    /* ══ SEARCH ══════════════════════════════════════════════════════════ */
    .search-container {
        position: relative;
        margin-bottom: 30px;
    }

    .search-container input {
        width: 100%;
        padding: 16px 25px 16px 55px;
        border-radius: 50px;
        border: var(--border);
        background: white;
        font-family: inherit;
        font-size: 15px;
        box-shadow: var(--shadow);
        transition: all 0.3s;
    }

    .search-container input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    .search-icon-abs {
        position: absolute;
        left: 22px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--accent);
        font-size: 18px;
    }

    /* ══ MENU GRID ═══════════════════════════════════════════════════════ */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 25px;
    }

    @media (max-width: 768px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    @media (max-width: 480px) {
        .menu-grid {
            grid-template-columns: 1fr !important;
        }
    }

    .menu-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: var(--border);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
    }

    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .menu-card-img-wrap {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f0f0f0;
    }

    .menu-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s;
    }

    .menu-card:hover .menu-card-img-wrap img {
        transform: scale(1.1);
    }

    .menu-card-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .menu-item-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--primary);
    }

    .menu-item-desc {
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 15px;
        line-height: 1.5;
        flex: 1;
    }

    .menu-item-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px dashed rgba(0,0,0,0.1);
    }

    .menu-item-price {
        font-weight: 700;
        color: var(--primary);
        font-size: 16px;
    }

    .btn-add-cart {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-add-cart:hover {
        background: var(--accent);
        color: var(--primary-dark);
        transform: rotate(90deg);
    }

    /* ══ CATEGORY TABS MOBILE ════════════════════════════════════════════ */
    .mobile-tabs {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 15px;
        margin-bottom: 20px;
        scrollbar-width: none;
    }
    .mobile-tabs::-webkit-scrollbar { display: none; }

    .tab-btn {
        flex-shrink: 0;
        padding: 10px 20px;
        border-radius: 50px;
        background: white;
        border: var(--border);
        font-size: 13px;
        font-weight: 600;
        color: var(--text-light);
        text-decoration: none;
        transition: all 0.3s;
    }

    .tab-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .page-header {
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .page-header p {
        color: var(--text-light);
    }

    /* ══ BEST SELLER ════════════════════════════════════════════════════ */
    .best-seller-section {
        margin-bottom: 30px;
        background: white;
        border-radius: 22px;
        border: var(--border);
        box-shadow: var(--shadow);
        padding: 24px;
    }

    .best-seller-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .best-seller-title {
        font-size: 1.4rem;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }

    .best-seller-subtitle {
        font-size: 12px;
        color: var(--text-light);
    }

    .best-seller-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
    }

    .best-card {
        background: linear-gradient(135deg, #ffffff 0%, #fdf6ee 100%);
        border-radius: 18px;
        padding: 16px;
        border: 1px solid rgba(212, 163, 115, 0.35);
        display: flex;
        gap: 14px;
        align-items: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .best-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    .best-card img {
        width: 70px;
        height: 70px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
        background: #f0f0f0;
    }

    .best-card-name {
        font-weight: 700;
        color: var(--primary);
        font-size: 15px;
        margin-bottom: 6px;
    }

    .best-card-price {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 13px;
    }

    .best-card-action {
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .best-card-badge {
        background: var(--accent);
        color: var(--primary-dark);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 4px 8px;
        border-radius: 999px;
    }

    @media (max-width: 991px) {
        .menu-sidebar { display: none; }
    }

    /* ══ PROMO SPECIAL SECTION ══════════════════════════════════════════ */
    .promo-section {
        margin-bottom: 35px;
        padding: 0 5px;
    }

    .promo-section-title {
        font-size: 1.3rem;
        color: #1e3a2f;
        font-family: 'Playfair Display', serif;
        margin-bottom: 16px;
        font-weight: 800;
        letter-spacing: -0.3px;
    }

    /* Slider Container */
    .promo-slider {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding: 5px 5px 15px 5px;
    }

    .promo-slider::-webkit-scrollbar {
        display: none;
    }

    .promo-slide {
        flex-shrink: 0;
        width: 310px;
        scroll-snap-align: start;
    }

    /* Struktur Utama Kartu Voucher */
    .promo-card-voucher {
        display: flex;
        height: 125px;
        background: linear-gradient(135deg, #1e3a2f 0%, #2d5a49 100%);
        border-radius: 18px;
        box-shadow: 0 8px 20px rgba(30, 58, 47, 0.12);
        position: relative;
        overflow: hidden;
        cursor: default;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    @media (hover: hover) {
        .promo-card-voucher:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(30, 58, 47, 0.22);
        }
    }

    .promo-card-voucher:active {
        transform: scale(0.98);
        transition: transform 0.1s ease;
    }

    .promo-details {
        flex: 1;
        padding: 16px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-sizing: border-box;
        z-index: 2;
    }

    .promo-badge {
        background-color: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        color: #f3e8ff;
        font-size: 10px;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 30px;
        width: fit-content;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .promo-title {
        font-size: 20px;
        font-weight: 800;
        color: #ffffff;
        margin-top: 6px;
        letter-spacing: -0.5px;
    }

    .promo-desc {
        font-size: 11px;
        color: #c2d6cd;
        line-height: 1.4;
        font-weight: 400;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .voucher-divider {
        width: 2px;
        border-left: 2px dashed rgba(255, 255, 255, 0.3);
        position: relative;
        height: 100%;
    }

    .voucher-divider::before, .voucher-divider::after {
        content: '';
        position: absolute;
        width: 14px;
        height: 14px;
        background: #ffffff;
        border-radius: 50%;
        left: -8px;
    }
    .voucher-divider::before { top: -7px; }
    .voucher-divider::after { bottom: -7px; }

    .voucher-tail {
        width: 50px;
        background: rgba(255, 255, 255, 0.04);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .tail-decor-icon {
        color: rgba(255, 255, 255, 0.25);
        font-size: 18px;
    }

    .promo-card-voucher::before {
        content: '';
        position: absolute;
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
        top: -40px;
        left: -40px;
        pointer-events: none;
    }

    /* ══ PAGINATION ══════════════════════════════════════════════════════ */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 40px;
    }

    .pagination-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: var(--border);
        background: white;
        color: var(--primary);
        font-family: inherit;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow);
    }

    .pagination-btn:hover:not(.disabled) {
        background: var(--accent);
        color: var(--primary-dark);
        border-color: var(--accent);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(212, 163, 115, 0.25);
    }

    .pagination-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .pagination-btn.disabled {
        color: var(--text-light);
        opacity: 0.35;
        cursor: not-allowed;
        background: transparent;
        border-color: var(--border);
        box-shadow: none;
    }

    /* ══ DARK MODE ═══════════════════════════════════════════════════════ */
    @media (prefers-color-scheme: dark) {
        .breadcrumb-menu {
            color: #9ca3af;
        }
        .breadcrumb-menu a {
            color: #9ca3af;
        }
        .breadcrumb-menu a:hover {
            color: #d4a373;
        }
        .breadcrumb-menu .current {
            color: #d4a373;
        }
        .breadcrumb-menu .separator {
            color: #4b5563;
        }
    }
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">

    @php
        $isRetailView = $selectedCategory === 'retail-products';
        $activeList = $isRetailView ? $retailProducts : $menus;
        $categoryName = $categories->firstWhere('slug', $selectedCategory)?->name;
    @endphp

    {{-- ── BREADCRUMB ── --}}
    <div class="breadcrumb-menu">
        <a href="{{ route('customer.home', $table->id) }}">
            <i class="fas fa-home"></i> Beranda
        </a>
        <span class="separator">/</span>
        <span class="current">Menu</span>
    </div>

    <div class="page-header">
        <h1 class="font-serif">
            @if($isRetailView)
                Produk Retail
            @elseif($selectedCategory && $categoryName)
                {{ $categoryName }}
            @else
                Menu Kami
            @endif
        </h1>
        <p>
            @if($isRetailView)
                Kopi kemasan favorit, siap dibawa pulang.
            @else
                Temukan kenikmatan dalam setiap pilihan menu terbaik kami.
            @endif
        </p>
    </div>

    @php
        $cartCount = collect($cart)->sum('quantity');
        $cartTotal = collect($cart)->sum(fn($i) => $i['unit_price'] * $i['quantity']);
        $appliedPromo = session('applied_promo_' . $table->id);
    @endphp


    <div class="menu-layout">
        {{-- ── SIDEBAR (desktop) ──────────────────────────────────────────── --}}
        <aside class="menu-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-card-header">Kategori</div>
                <div class="sidebar-card-body">
                    <div class="cat-list">
                        <a href="{{ route('customer.menu', $table->qr_token) }}{{ $search ? '?search='.$search : '' }}"
                           class="cat-list-item {{ !$selectedCategory ? 'active' : '' }}">
                            Semua Menu
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('customer.menu', $table->qr_token) }}?category={{ $cat->slug }}{{ $search ? '&search='.$search : '' }}"
                           class="cat-list-item {{ $selectedCategory === $cat->slug ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                        @endforeach

                        <div class="cat-list-divider"></div>

                        <a href="{{ route('customer.menu', $table->qr_token) }}?category=retail-products{{ $search ? '&search='.$search : '' }}"
                           class="cat-list-item cat-list-item-retail {{ $isRetailView ? 'active' : '' }}">
                            <i class="fas fa-shopping-bag" style="margin-right:8px;"></i> Produk Retail
                        </a>
                    </div>
                </div>
            </div>

        </aside>

        {{-- ── MAIN CONTENT ────────────────────────────────────────────────── --}}
        <div class="menu-main">

            {{-- Mobile Tabs --}}
            <div class="mobile-tabs d-lg-none">
                <a href="{{ route('customer.menu', $table->qr_token) }}{{ $search ? '?search='.$search : '' }}"
                   class="tab-btn {{ !$selectedCategory ? 'active' : '' }}">Semua</a>
                @foreach($categories as $cat)
                <a href="{{ route('customer.menu', $table->qr_token) }}?category={{ $cat->slug }}{{ $search ? '&search='.$search : '' }}"
                   class="tab-btn {{ $selectedCategory === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
                <a href="{{ route('customer.menu', $table->qr_token) }}?category=retail-products{{ $search ? '&search='.$search : '' }}"
                   class="tab-btn tab-btn-retail {{ $isRetailView ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i> Retail
                </a>
            </div>

            {{-- Search --}}
            <div class="search-container">
                <form method="GET" action="{{ route('customer.menu', $table->qr_token) }}">
                    @if($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    <i class="fas fa-search search-icon-abs"></i>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="{{ $isRetailView ? 'Cari produk retail...' : 'Cari kopi favoritmu...' }}">
                </form>
            </div>

            {{-- Promo Spesial Slider --}}
            @if($promos->count() > 0)
            <div class="promo-section">
                <h2 class="promo-section-title">Promo Spesial Untukmu</h2>
                <div class="promo-slider">
                    @foreach($promos as $promo)
                    @php
                        $promoTitle = '';
                        $promoDesc = '';

                        if ($promo->code === 'HEMAT10') {
                            $promoTitle = 'Mood Booster Hemat ✨';
                            $promoDesc = 'Diskon 10% buat semua menu, pas banget nemenin nongkrongmu hari ini!';
                        } elseif ($promo->code === 'GRATIS5K') {
                            $promoTitle = 'Traktiran Pivot Cafe ☕';
                            $promoDesc = 'Potongan Rp 5.000! Makin rame makin hemat dengan jajan min. 50k.';
                        } else {
                            if ($promo->discount_type === 'percent') {
                                $promoTitle = 'Spesial Potongan ' . number_format($promo->discount_value, 0) . '% 🎉';
                                $promoDesc = !empty($promo->description) ? $promo->description : 'Klaim promonya sekarang sebelum kehabisan!';
                            } else {
                                $valueK = number_format($promo->discount_value / 1000, 0) . 'K';
                                $promoTitle = 'Voucher Potongan ' . $valueK . ' 🔥';
                                $promoDesc = !empty($promo->description) ? $promo->description : 'Pilihan terbaik buat nemenin produktivitasmu hari ini.';
                            }
                        }
                    @endphp
                        <div class="promo-slide">
                            <div class="promo-card-voucher">
                                <div class="promo-details">
                                    <span class="promo-badge"><i class="fas fa-ticket-alt"></i> {{ $promo->code }}</span>
                                    <div class="promo-title">{{ $promoTitle }}</div>
                                    <div class="promo-desc">{{ $promoDesc }}</div>
                                </div>

                                <div class="voucher-divider"></div>

                                <div class="voucher-tail">
                                    <div class="tail-decor-icon">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Best Seller --}}
            @if($bestSellers->count() > 0 && !$isRetailView)
            <div class="best-seller-section">
                <div class="best-seller-header">
                    <div>
                        <div class="best-seller-title">Menu Terlaris</div>
                        <div class="best-seller-subtitle">Paling banyak dipesan minggu ini</div>
                    </div>
                    <div class="best-card-badge">Best Seller</div>
                </div>
                <div class="best-seller-grid">
                    @foreach($bestSellers as $menu)
                    <a href="{{ route('customer.menu.detail', [$table->qr_token, $menu]) }}" class="best-card">
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy">
                        <div>
                            <div class="best-card-name">{{ $menu->name }}</div>
                            <div class="best-card-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                            <div class="best-card-action">
                                <span style="font-size:11px;color:var(--text-light)">Lihat detail</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if(!$isRetailView)
            {{-- ══ GRID MENU KAFE (Makanan / Minuman) ══════════════════════ --}}
            <div class="menu-grid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:25px;">
                @forelse($menus as $menu)
                <div class="menu-card">
                    <a href="{{ route('customer.menu.detail', [$table->qr_token, $menu]) }}" class="menu-card-img-wrap">
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy">
                    </a>
                    <div class="menu-card-content">
                        <h3 class="menu-item-name">{{ $menu->name }}</h3>
                        <p class="menu-item-desc">{{ Str::limit($menu->short_description ?: $menu->description, 65) }}</p>

                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>

                            @if($menu->is_available)
                            <button type="button" class="btn-add-cart" title="Tambah ke Keranjang"
                                onclick="openAddCartModal({{ $menu->id }}, '{{ addslashes($menu->name) }}', '{{ $menu->category->name }}', '{{ $menu->image_url }}', 'Rp {{ number_format($menu->price, 0, ',', '.') }}', '{{ addslashes($menu->short_description ?: $menu->description ?? '') }}')">
                                <i class="fas fa-plus"></i>
                            </button>
                            @else
                            <span style="font-size: 11px; color: var(--danger); font-weight: 600; text-transform: uppercase;">Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 0;">
                    <i class="fas fa-coffee" style="font-size: 3rem; color: #eee; margin-bottom: 20px;"></i>
                    <p style="color: var(--text-light);">Menu tidak ditemukan. Coba kata kunci lain.</p>
                </div>
                @endforelse
            </div>
            @else
            {{-- ══ GRID PRODUK RETAIL (Kopi Kemasan) ════════════════════════ --}}
            <div class="menu-grid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:25px;">
                @forelse($retailProducts as $product)
                <div class="menu-card">
                    <a href="{{ route('customer.retail.detail', [$table->qr_token, $product]) }}" class="menu-card-img-wrap">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/placeholder.png') }}"
                            alt="{{ $product->name }}" loading="lazy">
                    </a>
                    <div class="menu-card-content">
                        <h3 class="menu-item-name">{{ $product->name }}</h3>
                        <p class="menu-item-desc">{{ Str::limit($product->description, 60) }}</p>

                        @if($product->is_available && $product->stock > 0 && $product->stock <= 5)
                        <span class="retail-stock-warning"><i class="fas fa-exclamation-circle"></i> Sisa {{ $product->stock }} stok</span>
                        @endif

                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>

                            @if($product->is_available && $product->stock > 0)
                            <button type="button" class="btn-add-cart" title="Tambah ke Keranjang"
                                onclick="openAddCartModal({{ $product->id }}, '{{ addslashes($product->name) }}', 'Retail', '{{ $product->image ? asset('storage/'.$product->image) : asset('images/placeholder.png') }}', 'Rp {{ number_format($product->price, 0, ',', '.') }}', '{{ addslashes($product->description ?? '') }}', { isRetail: true, stock: {{ $product->stock }} })">
                                <i class="fas fa-plus"></i>
                            </button>
                            @else
                            <span style="font-size: 11px; color: var(--danger); font-weight: 600; text-transform: uppercase;">Stok Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 0;">
                    <i class="fas fa-shopping-bag" style="font-size: 3rem; color: #eee; margin-bottom: 20px;"></i>
                    <p style="color: var(--text-light);">Produk retail tidak ditemukan.</p>
                </div>
                @endforelse
            </div>
            @endif

            {{-- Pagination (menyesuaikan list yang aktif: menu atau retail) --}}
            @if($activeList->hasPages())
            <div class="pagination-container">
                {{-- Previous Page Link --}}
                @if($activeList->onFirstPage())
                    <span class="pagination-btn disabled"><i class="fas fa-chevron-left"></i></span>
                @else
                    <a href="{{ $activeList->previousPageUrl() }}" class="pagination-btn"><i class="fas fa-chevron-left"></i></a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($activeList->getUrlRange(1, $activeList->lastPage()) as $page => $url)
                    @if ($page == $activeList->currentPage())
                        <span class="pagination-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($activeList->hasMorePages())
                    <a href="{{ $activeList->nextPageUrl() }}" class="pagination-btn"><i class="fas fa-chevron-right"></i></a>
                @else
                    <span class="pagination-btn disabled"><i class="fas fa-chevron-right"></i></span>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>

{{-- ══ DIALOG MODAL TAMBAH KE KERANJANG ════════════════════════════════════ --}}
@include('customer.partials.add-cart-modal')
{{-- MODAL TAMBAH KE KERANJANG --}}
<div class="modal-backdrop" id="add-cart-modal">
    <div class="modal" style="max-width: 450px;">
        <div class="modal-header">
            <div class="modal-title" style="font-family: 'Playfair Display', serif;">
                <i class="fas fa-utensils" style="color: var(--accent);"></i>
                Tambah ke Keranjang
            </div>
            <button type="button" class="modal-close" onclick="closeAddCartModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="modal-body" style="padding: 24px;">
            {{-- Hidden fields --}}
            <input type="hidden" id="modal-item-id" value="">
            <input type="hidden" id="modal-is-retail" value="0">
            
            {{-- Image --}}
            <div style="text-align: center; margin-bottom: 16px;">
                <img id="modal-item-image" src="{{ asset('images/placeholder.png') }}" 
                     alt="Item" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px;" loading="lazy">
            </div>
            
            {{-- Name --}}
            <h3 id="modal-item-name" style="font-family: 'Playfair Display', serif; font-size: 1.3rem; color: var(--primary); text-align: center; margin-bottom: 4px;">
                Nama Item
            </h3>
            
            {{-- Category & Price --}}
            <div style="text-align: center; margin-bottom: 12px;">
                <span id="modal-item-category" style="font-size: 12px; color: var(--text-light);">Kategori</span>
                <span style="margin: 0 8px; color: #ddd;">|</span>
                <span id="modal-item-price" style="font-weight: 700; color: var(--accent-dark); font-size: 1.1rem;">Rp 0</span>
            </div>
            
            {{-- Description --}}
            <p id="modal-item-desc" style="font-size: 13px; color: var(--text-light); text-align: center; margin-bottom: 20px;">
                Deskripsi item
            </p>
            
            {{-- Quantity --}}
            <div class="form-group" style="margin-bottom: 16px;">
                <label style="font-size: 14px; font-weight: 600;">Jumlah</label>
                <div style="display: flex; align-items: center; gap: 12px; justify-content: center;">
                    <button type="button" onclick="adjustQuantity(-1)" 
                            style="width: 40px; height: 40px; border-radius: 50%; border: var(--border); background: white; cursor: pointer; font-size: 18px; transition: all 0.2s;">
                        <i class="fas fa-minus" style="color: var(--text-light);"></i>
                    </button>
                    <input type="number" id="modal-quantity" value="1" min="1" 
                           style="width: 80px; text-align: center; font-size: 18px; font-weight: 700; border: var(--border); border-radius: 8px; padding: 8px;">
                    <button type="button" onclick="adjustQuantity(1)" 
                            style="width: 40px; height: 40px; border-radius: 50%; border: var(--border); background: var(--primary); color: white; cursor: pointer; font-size: 18px; transition: all 0.2s;">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            
            {{-- Notes --}}
            <div class="form-group" style="margin-bottom: 16px;">
                <label style="font-size: 14px; font-weight: 600;">Catatan (opsional)</label>
                <input type="text" id="modal-notes" placeholder="Contoh: Tidak pedas, ekstra es..." 
                       style="width: 100%; padding: 10px 16px; border: var(--border); border-radius: 8px; font-family: inherit; font-size: 14px;">
            </div>
        </div>
        
        <div class="modal-footer" style="padding: 16px 24px; display: flex; gap: 10px;">
            <button type="button" onclick="closeAddCartModal()" 
                    style="flex: 1; padding: 12px; border-radius: 50px; border: var(--border); background: transparent; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                Batal
            </button>
            <button type="button" id="modal-submit-btn" onclick="submitAddToCart()" 
                    style="flex: 2; padding: 12px; border-radius: 50px; border: none; background: var(--primary); color: white; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                <i class="fas fa-cart-plus"></i> Tambahkan
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── OPTIMASI: Delay load modal content ──
    document.addEventListener('DOMContentLoaded', function() {
        // Modal image lazy load
        const modalImg = document.getElementById('modal-item-image');
        if (modalImg) {
            modalImg.loading = 'lazy';
        }
    });
</script>
@endpush