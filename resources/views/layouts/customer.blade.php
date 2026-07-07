<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pivot Cafe')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- ═══ PRELOAD FONT ═══ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- ═══ FONT (HANYA YANG DIPAKAI) ═══ -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- ═══ FONT AWESOME ═══ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #1b4332;
            --primary-light: #2d6a4f;
            --primary-dark: #081c15;
            --accent: #d4a373;
            --accent-light: #faedcd;
            --text: #1a1a1a;
            --text-light: #6b7280;
            --bg: #fdfcfb;
            --white: #ffffff;
            --border: 1px solid rgba(0,0,0,0.1);
            --shadow: 0 4px 20px rgba(0,0,0,0.05);
            --danger: #dc2626;
            --success: #16a34a;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            min-height: 100vh;
        }
        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 25px;
            width: 100%;
        }
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: transparent;
            z-index: 1000;
            padding: 25px 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar.scrolled, .navbar.navbar-solid {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            box-shadow: var(--shadow);
            border-bottom: var(--border);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--white);
            font-weight: 700;
            font-size: 22px;
            transition: color 0.3s;
        }
        .navbar.scrolled .navbar-brand, .navbar.navbar-solid .navbar-brand {
            color: var(--primary);
        }
        .navbar-brand img {
            height: 40px;
        }
        .nav-links {
            display: flex;
            gap: 35px;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            color: rgba(255,255,255,0.8);
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s;
            position: relative;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s;
        }
        .nav-links a:hover::after, .nav-links a.active::after {
            width: 100%;
        }
        .nav-links a:hover, .nav-links a.active {
            color: var(--white);
        }
        .navbar.scrolled .nav-links a, .navbar.navbar-solid .nav-links a {
            color: var(--text-light);
        }
        .navbar.scrolled .nav-links a:hover, .navbar.scrolled .nav-links a.active,
        .navbar.navbar-solid .nav-links a:hover, .navbar.navbar-solid .nav-links a.active {
            color: var(--primary);
        }
        .nav-meta {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .table-badge {
            background: var(--accent);
            color: var(--primary-dark);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .cart-toggle-btn {
            position: relative;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .cart-toggle-btn:hover {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: var(--primary-dark) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(212, 163, 115, 0.3);
        }
        .navbar.scrolled .cart-toggle-btn, .navbar.navbar-solid .cart-toggle-btn {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        .navbar.scrolled .cart-toggle-btn:hover, .navbar.navbar-solid .cart-toggle-btn:hover {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: var(--primary-dark) !important;
        }
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 20px;
            cursor: pointer;
            margin-left: 10px;
            transition: color 0.3s;
        }
        .navbar.scrolled .menu-toggle, .navbar.navbar-solid .menu-toggle {
            color: var(--primary);
        }
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--white);
            transition: all 0.3s ease;
        }
        .cart-toggle-btn:hover .cart-badge {
            border-color: var(--accent);
        }
        main {
            flex: 1;
        }
        .cart-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 2600;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        .cart-backdrop.open {
            opacity: 1;
            visibility: visible;
        }
        .cart-drawer {
            position: fixed;
            top: 0; right: 0;
            width: 100%; max-width: 450px;
            height: 100vh;
            height: 100dvh;
            background: var(--white);
            z-index: 2601;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
        }
        .cart-backdrop.open .cart-drawer {
            transform: translateX(0);
        }
        .cart-header {
            padding: 25px;
            border-bottom: var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .cart-body {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            -webkit-overflow-scrolling: touch;
        }
        .cart-footer {
            padding: 25px;
            padding-bottom: calc(25px + env(safe-area-inset-bottom, 0px));
            background: #fafafa;
            border-top: var(--border);
            flex-shrink: 0;
        }
        /* Toasts */
        #toast-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .toast {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 5px solid var(--primary);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.3s ease-out;
            min-width: 250px;
        }
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        /* Footer */
        footer {
            background: var(--primary-dark);
            color: var(--white);
            padding: 100px 8% 60px;
            text-align: center;
        }
        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }
        .footer-brand {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 25px;
        }
        .footer-description {
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 40px;
        }
        .footer-social {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 50px;
        }
        .social-icon {
            width: 50px; height: 50px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            color: var(--white); text-decoration: none;
            transition: all 0.3s; font-size: 1.2rem;
        }
        .social-icon:hover {
            background: var(--accent); color: var(--primary-dark); transform: translateY(-5px);
        }
        /* Utility Classes */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer; border: none; text-align: center; font-size: 15px;
        }
        .section-padding {
            padding: 100px 0;
        }
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-title h2 {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-accent { background: var(--accent); color: var(--primary-dark); }
        .btn-block { width: 100%; display: block; }
        .btn-sm { padding: 8px 20px; font-size: 13px; }
        
        .btn-footer-action {
            display: block;
            width: 100%;
            padding: 14px 20px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 67, 50, 0.2);
        }
        .btn-footer-action[style*="transparent"]:hover {
            background: var(--danger) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.2);
        }
        .bg-light { background-color: #f8f9fa; }
        .bg-white { background-color: #ffffff; }
        .text-center { text-align: center; }
        
        .no-print { @media print { display: none !important; } }
        
        /* Display Utilities */
        .d-none { display: none !important; }
        .d-block { display: block !important; }
        .d-flex { display: flex !important; }
        .d-grid { display: grid !important; }
        @media (min-width: 992px) {
            .d-lg-none { display: none !important; }
            .d-lg-block { display: block !important; }
            .d-lg-flex { display: flex !important; }
        }
        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Cart Item Row */
        .cart-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.08);
        }
        .cart-item-info {
            flex: 1;
            min-width: 0;
        }
        .cart-item-name {
            font-weight: 700;
            font-size: 14px;
            line-height: 1.4;
            color: var(--text);
            word-break: break-word;
        }
        .cart-item-notes {
            font-size: 11px;
            color: var(--accent);
            font-weight: 500;
            margin-top: 4px;
        }
        .cart-item-price {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 2px;
            font-weight: 500;
        }
        .cart-qty-ctrl {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }
        .cart-qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #475569;
            transition: all 0.2s ease;
        }
        .cart-qty-btn:hover:not(:disabled) {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .cart-qty-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }
        .cart-qty-btn.btn-trash {
            color: var(--danger);
            border-color: rgba(220, 38, 38, 0.15);
            background: rgba(220, 38, 38, 0.02);
            margin-left: 4px;
        }
        .cart-qty-btn.btn-trash:hover {
            background: rgba(220, 38, 38, 0.1);
        }
        .cart-qty-num {
            font-weight: 700;
            font-size: 13px;
            min-width: 22px;
            text-align: center;
            color: var(--text);
        }
        /* Floating Order Status Container */
        #floating-order-status-container {
            position: fixed;
            right: 18px;
            bottom: 22px;
            bottom: calc(22px + env(safe-area-inset-bottom, 0px));
            z-index: 2500;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 40vh;
            overflow-y: auto;
            width: 280px;
            pointer-events: auto;
            scrollbar-width: thin;
        }
        #floating-order-status-container::-webkit-scrollbar {
            width: 6px;
        }
        #floating-order-status-container::-webkit-scrollbar-track {
            background: transparent;
        }
        #floating-order-status-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 3px;
        }
        #floating-order-status-container::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }
        .floating-order-status {
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            border: var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            text-decoration: none;
            color: var(--text);
            position: relative;
            min-width: 240px;
            transition: transform 0.2s ease, opacity 0.3s ease;
            animation: slideInUp 0.3s ease-out;
        }
        @keyframes slideInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .floating-status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.18);
        }
        .floating-status-dot.processing {
            background: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.18);
        }
        .floating-status-dot.success {
            background: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.18);
        }
        .floating-status-dot.danger {
            background: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.18);
        }
        .floating-status-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .floating-status-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-light);
        }
        .floating-status-value {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
        }
        .floating-status-meta {
            font-size: 11px;
            color: var(--text-light);
        }
        @media (max-width: 768px) {
            .navbar { padding: 15px 0; background: rgba(255, 255, 255, 0.95); border-bottom: var(--border); }
            .navbar-brand { color: var(--primary); }
            
            .menu-toggle { display: block; color: var(--primary); }
            .cart-toggle-btn { 
                background: var(--primary); 
                border-color: var(--primary); 
                color: white; 
            }
            .cart-badge { border-color: var(--white); }
            .nav-links {
                position: absolute; top: 100%; left: 0; right: 0; background: white;
                flex-direction: column; gap: 0; border-bottom: var(--border);
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); transition: clip-path 0.4s ease-in-out;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            .nav-links.active { clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%); }
            .nav-links a { padding: 20px 25px; border-bottom: 1px solid #f0f0f0; display: block; color: var(--text) !important; }
            .nav-meta { margin-left: auto; }
        }
        
        /* ══ WAITER FAB (UKURAN TETAP, HOVER SEPERTI MENU) ═══════════════════════════════════════ */
        .waiter-fab {
            background: var(--accent);
            color: var(--primary-dark);
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 25px rgba(212, 163, 115, 0.3);
            transition: background 0.3s ease,
                        transform 0.3s ease,
                        box-shadow 0.3s ease,
                        color 0.3s ease;
        }

        /* Hover - SAMA PERSIS SEPERTI MENU-FAB */
        .waiter-fab:hover {
            background: var(--accent-light) !important;
            color: var(--primary-dark);
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.22);
        }

        /* Klik */
        .waiter-fab:active {
            transform: translateY(-2px) scale(0.97);
        }

        /* Ikon */
        .waiter-fab .waiter-icon {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        /* Hover ikon */
        .waiter-fab:hover .waiter-icon {
            transform: translateX(5px);
        }

        /* ══ LOADING STATE (BENAR-BENAR NORMAL, TANPA EFEK APAPUN) ════════════════════ */
        .waiter-fab.loading {
            cursor: not-allowed;
            pointer-events: none;
        }

        .waiter-fab.loading .waiter-icon {
            animation: none !important;
        }

        .waiter-fab.loading .waiter-text {
            animation: none !important;
        }

        .waiter-fab.loading .waiter-text::after {
            display: none !important;
            content: none !important;
        }

        /* ══ CART CLOSE BUTTON (TOMbol X) ═══════════════════════════════════════════════ */
        .cart-close-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background: #f1f5f9;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #475569;
            transition: all 0.3s ease;
        }
        .cart-close-btn:hover {
            background: #fee2e2;
            border-color: var(--danger);
            color: var(--danger);
            transform: rotate(90deg);
        }
        .cart-close-btn:active {
            transform: rotate(90deg) scale(0.95);
        }

        /* ── Modal System Standar ── */
        .modal-backdrop { 
            position: fixed; 
            inset: 0; 
            background: rgba(0,0,0,0.5); 
            backdrop-filter: blur(4px);
            z-index: 2900; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 16px; 
            opacity: 0; 
            visibility: hidden; 
            transition: opacity 0.3s ease, visibility 0.3s ease; 
        }
        .modal-backdrop.open { 
            opacity: 1; 
            visibility: visible; 
        }
        .modal { 
            background: var(--white); 
            border-radius: 20px; 
            width: 100%; 
            max-width: 400px; 
            max-height: 90vh; 
            overflow-y: auto; 
            transform: scale(0.95) translateY(20px); 
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
            box-shadow: 0 20px 60px rgba(0,0,0,0.3); 
        }
        .modal-backdrop.open .modal { 
            transform: scale(1) translateY(0); 
        }
        .modal-sm { 
            max-width: 400px; 
        }
        .modal-lg { 
            max-width: 680px; 
        }
        .modal-header { 
            padding: 16px 20px; 
            border-bottom: 1px solid var(--secondary); 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            position: sticky; 
            top: 0; 
            background: var(--white); 
            z-index: 1; 
        }
        .modal-title { 
            font-size: 14px; 
            font-weight: 600; 
        }
        .modal-close { 
            width: 30px; 
            height: 30px; 
            border-radius: 4px; 
            border: none; 
            background: #e2e8f0; 
            cursor: pointer; 
            font-size: 16px; 
            color: var(--text-muted); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .modal-close:hover { 
            background: #cbd5e1; 
        }
        .modal-body { 
            padding: 20px; 
        }
        .modal-footer { 
            padding: 14px 20px; 
            border-top: 1px solid var(--secondary); 
            display: flex; 
            gap: 10px; 
            justify-content: flex-end; 
            background: #f8fafc; 
        }
        
        .modal-footer-btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease-in-out;
        }
        .btn-cancel:hover {
            background: #cbd5e1 !important;
            transform: translateY(-1px);
        }
        .btn-confirm-danger:hover {
            background: #b91c1c !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        .logo-placeholder {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--primary-dark);
            font-size: 18px;
        }
    </style>
    @stack('styles')
</head>
@php
    $cart = [];
    $cartCount = 0;
    $cartTotal = 0;
    if(session('table_id')) {
        $cart = session('cart_' . session('table_id'), []);
        $cartCount = collect($cart)->sum('quantity');
        $cartTotal = collect($cart)->sum(fn($item) => $item['quantity'] * $item['unit_price']);
    }
@endphp
<body>
    <nav class="navbar {{ !request()->routeIs('customer.home', 'customer.about', 'customer.contact') ? 'navbar-solid' : '' }}" id="navbar">
        <div class="container navbar-container">
            <a href="{{ session('table_id') ? route('customer.home', session('table_id')) : url('/') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe Logo">
                Pivot Cafe
            </a>
            
            <div class="nav-links" id="nav-links">
                <a href="{{ session('table_id') ? route('customer.home', session('table_id')) : url('/') }}" class="{{ request()->routeIs('customer.home') ? 'active' : '' }}">Beranda</a>
                @if(session('qr_token'))
                    <a href="{{ route('customer.menu', session('qr_token')) }}" class="{{ request()->routeIs('customer.menu*') ? 'active' : '' }}">Pesan</a>
                @endif
                <a href="{{ route('customer.about') }}" class="{{ request()->routeIs('customer.about') ? 'active' : '' }}">Tentang</a>
                <a href="{{ route('customer.contact') }}" class="{{ request()->routeIs('customer.contact') ? 'active' : '' }}">Kontak</a>
            </div>
            <div class="nav-meta">
                @if(session('table_number'))
                    <div class="table-badge">Meja {{ session('table_number') }}</div>
                @endif
                @if(session('table_id'))
                    <button class="cart-toggle-btn" onclick="toggleCart()" id="cart-icon-btn">
                        <i class="fas fa-shopping-basket"></i>
                        @if($cartCount > 0)
                            <span class="cart-badge" id="cart-badge-count">{{ $cartCount }}</span>
                        @endif
                    </button>
                @endif
                <button class="menu-toggle" id="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>
    <div class="cart-backdrop" id="cart-backdrop" onclick="handleBackdropClick(event)">
        <div class="cart-drawer" id="cart-drawer">
            <div class="cart-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-shopping-bag" style="color: var(--primary); font-size: 18px;"></i>
                    <h3 class="font-serif" style="font-size: 1.2rem;">Pesanan Anda</h3>
                </div>
                <button class="cart-close-btn" onclick="toggleCart()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="cart-body" id="cart-drawer-body">
                @forelse($cart as $id => $item)
                    <div class="cart-item-row">
                        <div class="cart-item-info">
                            <div class="cart-item-name">
                                {{ $item['name'] }}
                                @if(!empty($item['notes']))
                                    <div style="font-size: 11px; color: var(--accent); font-weight: 500; margin-top: 3px;">
                                        <i class="far fa-comment-dots"></i> {{ $item['notes'] }}
                                    </div>
                                @endif
                            </div>
                            <div class="cart-item-price">Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</div>
                        </div>
                        <div class="cart-qty-ctrl">
                            {{-- Tombol Minus (jika quantity > 1) --}}
                            <form action="{{ route('customer.cart.update', session('qr_token')) }}" method="POST" style="display:inline;" class="cart-minus-form">
                                @csrf
                                <input type="hidden" name="item_key" value="{{ $id }}">
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                <button type="submit" 
                                        class="cart-qty-btn cart-minus-btn" 
                                        data-item-key="{{ $id }}"
                                        data-item-name="{{ addslashes($item['name']) }}"
                                        data-quantity="{{ $item['quantity'] }}"
                                        style="{{ $item['quantity'] <= 1 ? 'display:none;' : '' }}">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </form>
                            
                            {{-- Tombol Minus (jika quantity = 1, jadi tombol hapus) --}}
                            <button type="button" 
                                    class="cart-qty-btn btn-remove-item" 
                                    data-item-key="{{ $id }}"
                                    data-item-name="{{ addslashes($item['name']) }}"
                                    style="color: var(--danger); border-color: rgba(220, 38, 38, 0.2); {{ $item['quantity'] > 1 ? 'display:none;' : '' }}">
                                <i class="fas fa-minus"></i>
                            </button>
                            
                            <span class="cart-qty-num">{{ $item['quantity'] }}</span>
                            
                            {{-- Tombol Plus --}}
                            <form action="{{ route('customer.cart.update', session('qr_token')) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="item_key" value="{{ $id }}">
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                <button type="submit" class="cart-qty-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="text-align:center; color: var(--text-light); margin-top: 50px;">Keranjang kosong</p>
                @endforelse
            </div>
            @if($cartCount > 0)
            <div class="cart-footer">
                <div style="display:flex; justify-content:space-between; margin-bottom: 20px;">
                    <span style="font-weight: 500;">Subtotal</span>
                    <span style="font-weight: 700; color: var(--primary);">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('customer.checkout', session('qr_token')) }}" 
                class="btn-footer-action btn-primary">
                    Checkout Sekarang
                </a>
                <button type="button" 
                        onclick="confirmClearCart()" 
                        class="btn-footer-action" 
                        style="background: transparent; color: var(--danger); border: 1px solid var(--danger); margin-top: 12px;">
                    <i class="fas fa-trash-alt" style="margin-right: 8px;"></i> 
                    Kosongkan Keranjang
                </button>
            </div>
            @endif
        </div>
    </div>
    <main>
        @yield('content')
    </main>
    @php
        $currentTableId = session('table_id');
        $activeTrxs = [];
        if ($currentTableId) {
            $sessionTrxs = session('active_transactions', []);
            $lastTrx = session('last_transaction_id');
            if ($lastTrx && !in_array($lastTrx, $sessionTrxs)) {
                $sessionTrxs[] = $lastTrx;
            }
            if (!empty($sessionTrxs)) {
                $dbActiveOrders = \App\Models\Order::whereIn('transaction_id', $sessionTrxs)
                    ->where(function($query) {
                        $query->whereNotIn('order_status', ['selesai', 'dibatalkan'])
                              ->orWhere(function($q) {
                                  $q->where('order_status', 'selesai')
                                    ->doesntHave('feedback');
                              });
                    })
                    ->get();
                
                $activeTrxs = $dbActiveOrders->where('table_id', $currentTableId)->pluck('transaction_id')->toArray();
                
                $newSessionTrxs = $dbActiveOrders->pluck('transaction_id')->toArray();
                session(['active_transactions' => $newSessionTrxs]);
                if ($lastTrx && !in_array($lastTrx, $newSessionTrxs)) {
                    session()->forget('last_transaction_id');
                }
            }
        }
    @endphp
    <div id="floating-order-status-container" class="no-print">
        
        {{-- ════════════════════════════════════════════════════════════════ --}}
        {{-- ══ WAITER CALL WIDGET (FLOATING STYLE - DENGAN PEMBEDA) ══════ --}}
        {{-- ════════════════════════════════════════════════════════════════ --}}
        @if(session('qr_token'))
            @php
                $activeCall = \App\Models\WaiterCall::where('table_id', session('table_id'))
                    ->where('status', 'pending')
                    ->latest()
                    ->first();
            @endphp
            <div id="waiter-call-widget" 
                 data-table-token="{{ session('qr_token') }}"
                 style="align-self: flex-end; margin-bottom: 5px;"
            >
                {{-- ── TOMBOL PANGGIL ── --}}
                <div id="waiter-call-btn-container" style="{{ $activeCall ? 'display:none;' : '' }}">
                    <button id="waiter-call-btn" 
                            onclick="callWaiter()"
                            class="waiter-fab"
                            style="background: var(--accent); color: var(--primary-dark); padding: 15px 25px; border-radius: 50px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 8px 25px rgba(212, 163, 115, 0.3); transition: all 0.3s ease;">
                        <i class="fas fa-bell waiter-icon"></i>
                        <span class="waiter-text" id="waiter-call-btn-text">Panggil Pelayan</span>
                    </button>
                </div>
                {{-- ── STATUS PANGGILAN (FLOATING STYLE - DENGAN PEMBEDA) ── --}}
                <div id="waiter-status-display" 
                     style="{{ $activeCall ? 'display:flex;' : 'display:none;' }} 
                            align-items: center;
                            gap: 12px;
                            background: var(--white);
                            border: 2px solid #f59e0b;
                            border-radius: 10px;
                            padding: 12px 14px;
                            text-decoration: none;
                            color: var(--text);
                            position: relative;
                            min-width: 240px;
                            transition: transform 0.2s ease, opacity 0.3s ease;
                            animation: slideInUp 0.3s ease-out;
                            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.15);">
                    
                    {{-- Icon Bell (beda dari status pesanan) --}}
                    <div id="waiter-status-icon" 
                         style="width: 36px; height: 36px; border-radius: 50%; background: #fef3c7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-bell" style="color: #f59e0b; font-size: 16px;"></i>
                    </div>
                    {{-- Text Status --}}
                    <span class="floating-status-text" style="display: flex; flex-direction: column; gap: 2px; flex: 1; min-width: 0;">
                        <span class="floating-status-title" style="font-size: 12px; font-weight: 700; color: #f59e0b; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fas fa-bell" style="font-size: 10px;"></i> Panggil Pelayan
                        </span>
                        <span id="waiter-status-value" class="floating-status-value" style="font-size: 14px; font-weight: 700; color: var(--primary);">
                            @if($activeCall)
                                @if($activeCall->status === 'pending')
                                    ⏳ Menunggu Konfirmasi
                                @endif
                            @endif
                        </span>
                        <span id="waiter-status-meta" class="floating-status-meta" style="font-size: 11px; color: var(--text-light);">
                            @if($activeCall)
                                Meja {{ session('table_number') }} • {{ $activeCall->created_at->format('H:i') }}
                            @endif
                        </span>
                    </span>
                    {{-- Tombol Batal --}}
                    @if($activeCall && $activeCall->status === 'pending')
                    <button id="waiter-cancel-btn"
                            onclick="cancelWaiterCall()"
                            style="background: #fee2e2; border: 1px solid #dc2626; color: #dc2626; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 10px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 4px; flex-shrink: 0;"
                            onmouseover="this.style.background='#fecaca';"
                            onmouseout="this.style.background='#fee2e2';">
                        <i class="fas fa-times" style="font-size: 10px;"></i> Batal
                    </button>
                    @endif
                </div>
            </div>
        @endif
        {{-- ── ORDER STATUS ── --}}
        @foreach($activeTrxs as $trxId)
            <div
                class="floating-order-status"
                id="floating-order-status-{{ $trxId }}"
                data-trx-id="{{ $trxId }}"
                data-status-url="{{ route('customer.status.peek', $trxId) }}"
                style="display: none;"
            >
                <a href="{{ route('customer.status', $trxId) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px; width: 100%;">
                    <span class="floating-status-dot" id="floating-status-dot-{{ $trxId }}"></span>
                    <span class="floating-status-text">
                        <span class="floating-status-title">Status Pesanan</span>
                        <span class="floating-status-value" id="floating-status-value-{{ $trxId }}">Memuat...</span>
                        <span class="floating-status-meta" id="floating-status-meta-{{ $trxId }}">{{ $trxId }}</span>
                    </span>
                </a>
            </div>
        @endforeach
    </div>
    <div id="toast-container"></div>
    <footer>
        <div class="container">
            <div class="footer-content">
                <h3 class="footer-brand font-serif">Pivot Cafe</h3>
                <p class="footer-description">
                    Tempat terbaik untuk menikmati kopi pilihan dengan suasana yang hangat dan inspiratif. Kami menghadirkan biji kopi terbaik dari petani lokal untuk Anda.
                </p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/pivotco.op/" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Pivot Caffe. Crafted with passion for coffee lovers.</p>
            </div>
        </div>
    </footer>
    {{-- ── MODAL KONFIRMASI KOSONGKAN KERANJANG ── --}}
    <div class="modal-backdrop" id="clear-cart-modal">
        <div class="modal modal-sm">
            <div class="modal-body" style="padding: 28px 24px 20px; text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">🗑️</div>
                <div class="modal-title" style="font-size: 18px; margin-bottom: 10px;">Kosongkan Keranjang?</div>
                <div class="delete-modal-desc" style="font-size: 14px; color: var(--text-light); margin-bottom: 20px;">
                    Apakah Anda yakin ingin menghapus semua pesanan? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div style="display:flex; gap:10px; justify-content:center; padding-top: 10px;">
                    <button type="button" 
                            class="modal-footer-btn btn-cancel" 
                            onclick="closeClearCartModal()" 
                            style="background:#e2e8f0; color:#475569;">
                        Batal
                    </button>
                    <form id="cart-clear-form" action="{{ route('customer.cart.clear', session('qr_token')) }}" method="POST">
                        @csrf 
                        <button type="submit" 
                                class="modal-footer-btn btn-confirm-danger" 
                                style="background:var(--danger); color:white;">
                            Ya, Hapus Semua
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ── MODAL KONFIRMASI HAPUS 1 ITEM DARI KERANJANG ── --}}
    <div class="modal-backdrop" id="remove-item-modal">
        <div class="modal modal-sm">
            <div class="modal-body" style="padding: 28px 24px 20px; text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">🗑️</div>
                <div class="modal-title" style="font-size: 18px; margin-bottom: 10px;">Hapus Item?</div>
                <div class="delete-modal-desc" style="font-size: 14px; color: var(--text-light); margin-bottom: 20px;">
                    Yakin mau hapus <strong id="remove-item-name">item ini</strong> dari keranjang?
                </div>
                <div style="display:flex; gap:10px; justify-content:center; padding-top: 10px;">
                    <button type="button" 
                            class="modal-footer-btn btn-cancel" 
                            onclick="closeRemoveItemModal()" 
                            style="background:#e2e8f0; color:#475569;">
                        Batal
                    </button>
                    <form id="remove-item-form" action="{{ route('customer.cart.remove', session('qr_token')) }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_key" id="remove-item-key" value="">
                        <button type="submit" 
                                class="modal-footer-btn btn-confirm-danger" 
                                style="background:var(--danger); color:white;">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ── MODAL KONFIRMASI BATAL PANGGILAN (KUSTOM) ── --}}
    <div class="modal-backdrop" id="cancel-waiter-modal">
        <div class="modal modal-sm">
            <div class="modal-body" style="text-align: center; padding: 32px 24px 28px;">
                <div style="font-size: 48px; margin-bottom: 12px;">🤔</div>
                <div style="font-size: 18px; font-weight: 700; color: #1b4332; margin-bottom: 8px;">
                    Batalkan Panggilan?
                </div>
                <div style="font-size: 14px; color: #6b7280; margin-bottom: 24px; line-height: 1.6;">
                    Yakin ingin membatalkan panggilan pelayan?<br>
                    <span style="font-size: 12px; color: #9ca3af;">Pelayan akan diberitahu bahwa panggilan dibatalkan.</span>
                </div>
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button type="button" 
                            onclick="closeCancelWaiterModal()" 
                            style="background: #f3f4f6; border: none; color: #4b5563; padding: 10px 30px; border-radius: 50px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#e5e7eb';"
                            onmouseout="this.style.background='#f3f4f6';">
                        Batal
                    </button>
                    <button type="button" 
                            onclick="confirmCancelWaiter()" 
                            style="background: #dc2626; border: none; color: white; padding: 10px 30px; border-radius: 50px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#b91c1c';"
                            onmouseout="this.style.background='#dc2626';">
                        Ya, Batalkan
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('nav-links').classList.toggle('active');
        });
        // Cart Drawer Functions
        function toggleCart() {
            const bd = document.getElementById('cart-backdrop');
            bd.classList.toggle('open');
            document.body.style.overflow = bd.classList.contains('open') ? 'hidden' : '';
        }
        function handleBackdropClick(e) {
            if (e.target === document.getElementById('cart-backdrop')) toggleCart();
        }
        // Toast Notification (Existing)
        function cToast(msg, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.style.borderLeft = `5px solid ${type === 'success' ? 'var(--success)' : 'var(--danger)'}`;
            toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}" style="color: ${type === 'success' ? 'var(--success)' : 'var(--danger)'}"></i> <span>${msg}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0'; toast.style.transform = 'translateX(20px)';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
        @if(session('success')) cToast(@json(session('success')), 'success'); @endif
        @if(session('error')) cToast(@json(session('error')), 'error'); @endif
        @if(session('waiter_called')) cToast(@json(session('waiter_called')), 'success'); @endif
        // Floating order status polling
        (function () {
            var widgets = document.querySelectorAll('#floating-order-status-container .floating-order-status');
            if (widgets.length === 0) return;
            function statusLabel(status) {
                if (status === 'menunggu') return 'Menunggu Konfirmasi';
                if (status === 'diproses') return 'Sedang Diproses';
                if (status === 'selesai') return 'Selesai';
                if (status === 'dibatalkan') return 'Dibatalkan';
                return 'Status Tidak Diketahui';
            }
            function dotClass(status) {
                if (status === 'diproses') return 'processing';
                if (status === 'selesai') return 'success';
                if (status === 'dibatalkan') return 'danger';
                return '';
            }
            widgets.forEach(function (widget) {
                var trxId = widget.getAttribute('data-trx-id');
                widget.style.display = 'flex';
                var url = widget.getAttribute('data-status-url');
                var dot = document.getElementById('floating-status-dot-' + trxId);
                var valueEl = document.getElementById('floating-status-value-' + trxId);
                var metaEl = document.getElementById('floating-status-meta-' + trxId);
                var intervalId = null;
                function fetchStatus() {
                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function (res) { return res.ok ? res.json() : null; })
                        .then(function (data) {
                            if (!data) return;
                            if (data.has_feedback) {
                                widget.style.display = 'none';
                                clearInterval(intervalId);
                                return;
                            }
                            var label = statusLabel(data.order_status);
                            valueEl.textContent = label;
                            metaEl.textContent = 'Meja ' + data.table_number + ' • ' + data.transaction_id;
                            dot.className = 'floating-status-dot ' + dotClass(data.order_status);
                            if (data.order_status === 'selesai' || data.order_status === 'dibatalkan') {
                                clearInterval(intervalId);
                            }
                        })
                        .catch(function () {
                            valueEl.textContent = 'Status tidak tersedia';
                        });
                }
                fetchStatus();
                intervalId = setInterval(fetchStatus, 5000);
            });
        })();
        // ── FUNGSI UNTUK MODAL KOSONGKAN KERANJANG ──
        function confirmClearCart() {
            // Buka modal konfirmasi (keranjang tetap terbuka di belakang)
            document.getElementById('clear-cart-modal').classList.add('open');
        }
        function closeClearCartModal() {
            const modal = document.getElementById('clear-cart-modal');
            modal.classList.remove('open');
        }
        // ── FUNGSI UNTUK MODAL HAPUS 1 ITEM ──
        function confirmRemoveItem(itemKey, itemName) {
            document.getElementById('remove-item-key').value = itemKey;
            document.getElementById('remove-item-name').textContent = itemName || 'item ini';
            document.getElementById('remove-item-modal').classList.add('open');
        }
        function closeRemoveItemModal() {
            document.getElementById('remove-item-modal').classList.remove('open');
        }
        // Event delegation: tangkap klik tombol hapus item di dalam cart-drawer-body
        document.addEventListener('click', function(e) {
            // Cari tombol hapus (btn-remove-item)
            const removeBtn = e.target.closest('.btn-remove-item');
            if (removeBtn) {
                // Pastikan ada di dalam cart drawer
                const cartDrawer = document.getElementById('cart-drawer');
                if (cartDrawer && cartDrawer.contains(removeBtn)) {
                    e.preventDefault();
                    confirmRemoveItem(removeBtn.dataset.itemKey, removeBtn.dataset.itemName);
                    return false;
                }
            }
            
            // Cari tombol minus (cart-minus-btn)
            const minusBtn = e.target.closest('.cart-minus-btn');
            if (minusBtn) {
                const cartDrawer = document.getElementById('cart-drawer');
                if (cartDrawer && cartDrawer.contains(minusBtn)) {
                    const quantity = parseInt(minusBtn.dataset.quantity);
                    if (quantity <= 1) {
                        e.preventDefault();
                        confirmRemoveItem(minusBtn.dataset.itemKey, minusBtn.dataset.itemName);
                        return false;
                    }
                }
            }
        });

        // ─══════════════════════════════════════════════════════════════════─
        // ─═ WAITER CALL FUNCTIONS (REALTIME + POPUP KUSTOM) ══════════════─
        // ─══════════════════════════════════════════════════════════════════─
        
        function callWaiter() {
            const btn = document.getElementById('waiter-call-btn');
            const btnText = document.getElementById('waiter-call-btn-text');
            
            if (!btn) return;
            
            // Disable button
            btn.disabled = true;
            btn.classList.add('loading');
            btnText.textContent = 'Memanggil...';
            
            const widget = document.getElementById('waiter-call-widget');
            const token = widget ? widget.dataset.tableToken : null;
            
            if (!token) {
                showToast('error', 'Gagal', 'Token tidak ditemukan');
                btn.disabled = false;
                btn.classList.remove('loading');
                btnText.textContent = 'Panggil Pelayan';
                return;
            }
            
            // HAPUS FLAG DONE SEBELUMNYA (biar bisa muncul lagi)
            sessionStorage.removeItem('waiter_done_' + token);
            
            const url = `/order/${token}/waiter/call`;
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(data => {
                        throw new Error(data.error || 'Server error');
                    });
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('success', 'Berhasil', data.message);
                    fetchWaiterStatus();
                } else {
                    showToast('error', 'Gagal', data.error || 'Terjadi kesalahan');
                    btn.disabled = false;
                    btn.classList.remove('loading');
                    btnText.textContent = 'Panggil Pelayan';
                }
            })
            .catch(err => {
                console.error('Error:', err);
                showToast('error', 'Gagal', err.message || 'Terjadi kesalahan jaringan');
                btn.disabled = false;
                btn.classList.remove('loading');
                btnText.textContent = 'Panggil Pelayan';
            });
        }

        // ── BATAL DENGAN MODAL KUSTOM ──
        function cancelWaiterCall() {
            document.getElementById('cancel-waiter-modal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeCancelWaiterModal() {
            document.getElementById('cancel-waiter-modal').classList.remove('open');
            document.body.style.overflow = '';
        }
        function confirmCancelWaiter() {
            // Tutup modal langsung
            closeCancelWaiterModal();
            
            const cancelBtn = document.getElementById('waiter-cancel-btn');
            if (cancelBtn) {
                cancelBtn.disabled = true;
                cancelBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                cancelBtn.style.opacity = '0.6';
                cancelBtn.style.cursor = 'not-allowed';
            }
            
            const widget = document.getElementById('waiter-call-widget');
            const token = widget ? widget.dataset.tableToken : null;
            
            if (!token) {
                showToast('error', 'Gagal', 'Token tidak ditemukan');
                if (cancelBtn) {
                    cancelBtn.disabled = false;
                    cancelBtn.innerHTML = '<i class="fas fa-times"></i> Batal';
                    cancelBtn.style.opacity = '1';
                    cancelBtn.style.cursor = 'pointer';
                }
                return;
            }
            
            // HAPUS FLAG DONE
            sessionStorage.removeItem('waiter_done_' + token);
            
            const url = `/order/${token}/waiter/cancel`;
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Berhasil', data.message);
                    
                    // LANGSUNG KEMBALI KE TOMBOL PANGGIL TANPA RELOAD
                    const statusDisplay = document.getElementById('waiter-status-display');
                    const callBtnContainer = document.getElementById('waiter-call-btn-container');
                    
                    if (statusDisplay) {
                        statusDisplay.style.display = 'none';
                        while (statusDisplay.firstChild) {
                            statusDisplay.removeChild(statusDisplay.firstChild);
                        }
                    }
                    if (callBtnContainer) {
                        callBtnContainer.style.display = 'block';
                    }
                    
                    if (cancelBtn) {
                        cancelBtn.disabled = false;
                        cancelBtn.innerHTML = '<i class="fas fa-times"></i> Batal';
                        cancelBtn.style.opacity = '1';
                        cancelBtn.style.cursor = 'pointer';
                    }
                    
                    const callBtn = document.getElementById('waiter-call-btn');
                    if (callBtn) {
                        callBtn.disabled = false;
                        callBtn.classList.remove('loading');
                        document.getElementById('waiter-call-btn-text').textContent = 'Panggil Pelayan';
                    }
                    
                } else {
                    showToast('error', 'Gagal', data.error || 'Terjadi kesalahan');
                    if (cancelBtn) {
                        cancelBtn.disabled = false;
                        cancelBtn.innerHTML = '<i class="fas fa-times"></i> Batal';
                        cancelBtn.style.opacity = '1';
                        cancelBtn.style.cursor = 'pointer';
                    }
                }
            })
            .catch(err => {
                console.error('Error:', err);
                showToast('error', 'Gagal', 'Terjadi kesalahan jaringan');
                if (cancelBtn) {
                    cancelBtn.disabled = false;
                    cancelBtn.innerHTML = '<i class="fas fa-times"></i> Batal';
                    cancelBtn.style.opacity = '1';
                    cancelBtn.style.cursor = 'pointer';
                }
            });
        }

        // ── FETCH STATUS (REALTIME - FLOATING STYLE) ──
        function fetchWaiterStatus() {
            const widget = document.getElementById('waiter-call-widget');
            if (!widget) return;
            
            const token = widget.dataset.tableToken;
            if (!token) return;
            const url = `/order/${token}/waiter/status`;
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                const statusDisplay = document.getElementById('waiter-status-display');
                const callBtnContainer = document.getElementById('waiter-call-btn-container');
                const statusValue = document.getElementById('waiter-status-value');
                const statusMeta = document.getElementById('waiter-status-meta');
                const statusIcon = document.getElementById('waiter-status-icon');
                let cancelBtn = document.getElementById('waiter-cancel-btn');
                
                // CEK APAKAH SUDAH PERNAH DONE SEBELUMNYA
                const hasBeenDone = sessionStorage.getItem('waiter_done_' + token) === 'true';
                
                if (data.has_active) {
                    statusDisplay.style.display = 'flex';
                    callBtnContainer.style.display = 'none';
                    
                    if (data.status === 'pending') {
                        // Reset flag jika status kembali pending (user panggil ulang)
                        sessionStorage.removeItem('waiter_done_' + token);
                        
                        statusValue.textContent = '⏳ Menunggu Konfirmasi';
                        statusDisplay.style.borderColor = '#f59e0b';
                        statusDisplay.style.boxShadow = '0 4px 15px rgba(245, 158, 11, 0.15)';
                        statusIcon.style.background = '#fef3c7';
                        statusIcon.innerHTML = '<i class="fas fa-bell" style="color: #f59e0b; font-size: 16px;"></i>';
                        
                        if (!cancelBtn) {
                            const parent = statusDisplay;
                            const newCancelBtn = document.createElement('button');
                            newCancelBtn.id = 'waiter-cancel-btn';
                            newCancelBtn.innerHTML = '<i class="fas fa-times" style="font-size: 10px;"></i> Batal';
                            newCancelBtn.style.cssText = 'background: #fee2e2; border: 1px solid #dc2626; color: #dc2626; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 10px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 4px; flex-shrink: 0;';
                            newCancelBtn.onmouseover = function() { this.style.background = '#fecaca'; };
                            newCancelBtn.onmouseout = function() { this.style.background = '#fee2e2'; };
                            newCancelBtn.onclick = function() { cancelWaiterCall(); };
                            parent.appendChild(newCancelBtn);
                        } else {
                            cancelBtn.style.display = 'flex';
                        }
                        
                    } else if (data.status === 'done') {
                        // JIKA SUDAH PERNAH DONE, LANGSUNG HILANGKAN (TIDAK MUNCUL LAGI)
                        if (hasBeenDone) {
                            statusDisplay.style.display = 'none';
                            callBtnContainer.style.display = 'block';
                            
                            const callBtn = document.getElementById('waiter-call-btn');
                            if (callBtn) {
                                callBtn.disabled = false;
                                callBtn.classList.remove('loading');
                                document.getElementById('waiter-call-btn-text').textContent = 'Panggil Pelayan';
                            }
                            return;
                        }
                        
                        // TAMPILKAN SEKALI, LALU TANDAI SUDAH PERNAH
                        statusValue.textContent = '✅ Pelayan Datang';
                        statusDisplay.style.borderColor = '#16a34a';
                        statusDisplay.style.boxShadow = '0 4px 15px rgba(22, 163, 74, 0.15)';
                        statusIcon.style.background = '#f0fdf4';
                        statusIcon.innerHTML = '<i class="fas fa-check" style="color: #16a34a; font-size: 16px;"></i>';
                        if (cancelBtn) cancelBtn.style.display = 'none';
                        
                        // TANDAI SUDAH PERNAH DITAMPILKAN (pakai sessionStorage)
                        sessionStorage.setItem('waiter_done_' + token, 'true');
                        
                        // HILANGKAN SETELAH 3 DETIK
                        setTimeout(function() {
                            statusDisplay.style.display = 'none';
                            callBtnContainer.style.display = 'block';
                            
                            const callBtn = document.getElementById('waiter-call-btn');
                            if (callBtn) {
                                callBtn.disabled = false;
                                callBtn.classList.remove('loading');
                                document.getElementById('waiter-call-btn-text').textContent = 'Panggil Pelayan';
                            }
                            
                            const cancelBtnEl = document.getElementById('waiter-cancel-btn');
                            if (cancelBtnEl) {
                                cancelBtnEl.remove();
                            }
                        }, 3000);
                    }
                    
                    statusMeta.textContent = 'Meja {{ session('table_number') }} • ' + data.created_at;
                } else {
                    statusDisplay.style.display = 'none';
                    callBtnContainer.style.display = 'block';
                    
                    const callBtn = document.getElementById('waiter-call-btn');
                    if (callBtn) {
                        callBtn.disabled = false;
                        callBtn.classList.remove('loading');
                        document.getElementById('waiter-call-btn-text').textContent = 'Panggil Pelayan';
                    }
                    
                    if (cancelBtn) {
                        cancelBtn.remove();
                    }
                    
                    // HAPUS FLAG KETIKA TIDAK ADA PANGGILAN AKTIF
                    sessionStorage.removeItem('waiter_done_' + token);
                }
            })
            .catch(err => console.error('Error fetching waiter status:', err));
        }

        function showToast(type, title, message) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            
            container.innerHTML = '';
            
            const isSuccess = type === 'success';
            const borderColor = isSuccess ? '#16a34a' : '#dc2626';
            const icon = isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.style.borderLeftColor = borderColor;
            toast.innerHTML = `
                <i class="fas ${icon}" style="color: ${borderColor}; font-size: 18px;"></i>
                <div>
                    <div style="font-weight: 600; font-size: 14px;">${title}</div>
                    <div style="font-size: 13px; color: #6b7280;">${message}</div>
                </div>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.remove();
                        }
                    }, 300);
                }
            }, 4000);
        }

        // ── AUTO POLLING UNTUK WAITER STATUS (REALTIME) ──
        (function() {
            const widget = document.getElementById('waiter-call-widget');
            if (!widget) return;
            
            const token = widget.dataset.tableToken;
            if (!token) return;
            
            setInterval(function() {
                fetchWaiterStatus();
            }, 3000);
        })();
    </script>
    @stack('scripts')
</body>
</html>