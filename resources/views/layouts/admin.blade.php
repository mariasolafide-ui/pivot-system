<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Pivot Cafe</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        :root {
            --primary: #1b4332;
            --primary-light: #2d6a4f;
            --primary-dark: #081c15;
            --accent: #d4a373;
            --accent-light: #faedcd;
            --accent-dark: #b5835a;
            --text: #1a1a1a;
            --text-light: #6b7280;
            --bg: #fdfcfb;
            --white: #ffffff;
            --danger: #dc2626;
            --success: #16a34a;
            --warning: #f59e0b;
            --border: 1px solid rgba(0,0,0,0.08);
            --shadow: 0 4px 20px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.08);
            --radius: 16px;
            --radius-sm: 10px;
            --sidebar-w: 260px;
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            display: flex;
            min-height: 100vh;
        }

        h1, h2, h3, h4, .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--primary);
            color: var(--white);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            border-right: 1px solid rgba(255,255,255,0.06);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sidebar-brand img {
            height: 42px;
            width: 42px;
            object-fit: contain;
        }

        .sidebar-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.02em;
        }

        .sidebar-brand span {
            font-size: 11px;
            opacity: 0.6;
            font-weight: 400;
            display: block;
            margin-top: 0px;
            color: var(--accent-light);
            font-family: 'Outfit', sans-serif;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 14px;
        }

        .nav-section {
            padding: 12px 14px 6px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.3);
            font-family: 'Outfit', sans-serif;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-radius: var(--radius-sm);
            margin-bottom: 2px;
            transition: all 0.25s ease;
            font-family: 'Outfit', sans-serif;
        }

        .nav-link i {
            font-size: 16px;
            width: 22px;
            text-align: center;
            opacity: 0.6;
            transition: all 0.25s;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.06);
            color: var(--white);
        }

        .nav-link:hover i {
            opacity: 1;
            color: var(--accent);
        }

        .nav-link.active {
            background: var(--accent);
            color: var(--primary-dark);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(212, 163, 115, 0.25);
        }

        .nav-link.active i {
            opacity: 1;
            color: var(--primary-dark);
        }

        .waiter-badge {
            background: var(--danger);
            color: white;
            border-radius: 20px;
            padding: 1px 8px;
            font-size: 10px;
            font-weight: 700;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logout-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.5);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            cursor: pointer;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: var(--radius-sm);
            transition: all 0.25s;
            width: 100%;
        }

        .logout-btn:hover {
            background: rgba(220, 38, 38, 0.12);
            color: #f87171;
        }

        .logout-btn i {
            font-size: 15px;
            width: 22px;
            text-align: center;
        }

        /* ── MAIN CONTENT ── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: rgba(253, 252, 251, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 16px 32px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: var(--border);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            flex-direction: column;
            gap: 4px;
        }

        .hamburger span {
            display: block;
            width: 22px;
            height: 2.5px;
            background: var(--primary);
            border-radius: 2px;
            transition: all 0.3s;
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 16px 6px 12px;
            background: var(--white);
            border-radius: 30px;
            border: var(--border);
            box-shadow: var(--shadow);
        }

        .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 600;
            font-size: 14px;
        }

        .admin-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .content {
            flex: 1;
            padding: 28px 32px 32px;
        }

        /* ── CARDS ── */
        .card {
            background: var(--white);
            border: var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--white);
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
        }

        .card-body {
            padding: 24px;
        }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border: var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--accent);
        }

        .stat-label {
            font-size: 11px;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-family: 'Outfit', sans-serif;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
            margin-top: 4px;
            font-family: 'Playfair Display', serif;
        }

        .stat-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 32px;
            opacity: 0.08;
            color: var(--primary);
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 50px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            box-shadow: 0 6px 20px rgba(27, 67, 50, 0.2);
        }

        .btn-accent {
            background: var(--accent);
            color: var(--primary-dark);
        }

        .btn-accent:hover {
            background: var(--accent-dark);
            box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
        }

        .btn-danger {
            background: var(--danger);
            color: var(--white);
        }

        .btn-danger:hover {
            background: #b91c1c;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25);
        }

        .btn-success {
            background: var(--success);
            color: var(--white);
        }

        .btn-success:hover {
            background: #15803d;
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.25);
        }

        .btn-warning {
            background: var(--warning);
            color: var(--white);
        }

        .btn-warning:hover {
            background: #d97706;
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.25);
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border: 2px solid var(--border);
        }

        .btn-outline:hover {
            background: var(--bg);
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 12px;
        }

        .btn-lg {
            padding: 14px 32px;
            font-size: 15px;
        }

        /* ── TABLES ── */
        .table-wrap {
            overflow-x: auto;
            border: var(--border);
            border-radius: var(--radius);
            background: var(--white);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }

        th {
            font-weight: 600;
            background: #f8fafc;
            color: var(--text-light);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-family: 'Outfit', sans-serif;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: var(--bg);
        }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            font-family: 'Outfit', sans-serif;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: var(--accent-light);
            color: #78350f;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        /* ── FORMS ── */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text);
            font-family: 'Outfit', sans-serif;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px 16px;
            border: 2px solid rgba(0,0,0,0.06);
            border-radius: var(--radius-sm);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            color: var(--text);
            background: var(--white);
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(27, 67, 50, 0.06);
        }

        .field-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── MODALS ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(4px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-backdrop.open {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: var(--white);
            border-radius: var(--radius);
            width: 100%;
            max-width: 480px;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.95) translateY(10px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: var(--shadow-lg);
        }

        .modal-backdrop.open .modal {
            transform: scale(1) translateY(0);
        }

        .modal-sm { max-width: 400px; }
        .modal-lg { max-width: 680px; }

        .modal-header {
            padding: 20px 24px;
            border-bottom: var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            background: var(--white);
            z-index: 1;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: #f1f5f9;
            cursor: pointer;
            font-size: 14px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .modal-close:hover {
            background: var(--accent-light);
            color: var(--primary);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: var(--border);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            background: #fafafa;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        /* Delete Modal */
        .delete-modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #fee2e2;
            color: var(--danger);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 24px;
        }

        .delete-modal-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .delete-modal-desc {
            text-align: center;
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 24px;
            line-height: 1.6;
        }

        /* ── TOASTS ── */
        #toast-container {
            position: fixed;
            top: 90px;
            right: 24px;
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }

        .toast {
            background: var(--white);
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-lg);
            border-left: 4px solid var(--primary);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* ── SIDEBAR OVERLAY ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(8, 28, 21, 0.3);
            backdrop-filter: blur(2px);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .hamburger {
                display: flex;
            }

            .topbar {
                padding: 12px 16px;
                height: 64px;
            }

            .topbar-title {
                font-size: 18px;
            }

            .content {
                padding: 16px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .admin-profile span {
                display: none;
            }

            #toast-container {
                right: 16px;
                left: 16px;
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .modal {
                max-width: 100%;
                margin: 10px;
            }

            .topbar-title {
                font-size: 16px;
            }

            .card-body {
                padding: 16px;
            }

            th, td {
                padding: 10px 12px;
                font-size: 12px;
            }
        }

        /* ── PAGINATION ── */
        .pagination-wrapper nav {
            display: flex;
            justify-content: center;
            padding: 16px;
            border-top: var(--border);
        }

        .pagination-wrapper ul {
            display: flex;
            gap: 6px;
            align-items: center;
            list-style: none;
        }

        .pagination-wrapper li a,
        .pagination-wrapper li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 8px;
            border-radius: 50%;
            font-size: 13px;
            text-decoration: none;
            color: var(--text);
            border: var(--border);
            background: var(--white);
            transition: all 0.3s;
            font-family: 'Outfit', sans-serif;
        }

        .pagination-wrapper li a:hover {
            background: var(--accent-light);
            border-color: var(--accent);
        }

        .pagination-wrapper li.active span,
        .pagination-wrapper li[aria-current="page"] span {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(27, 67, 50, 0.2);
        }

        /* ── NOTIFICATION CONTAINER (ADMIN - TANPA CLOSE BUTTON) ── */
        #admin-notifications-container {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 2500;
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 320px;
            overflow-y: auto;
            width: 320px;
            padding-right: 4px;
            scrollbar-width: thin;
        }

        #admin-notifications-container::-webkit-scrollbar {
            width: 4px;
        }
        #admin-notifications-container::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
            border-radius: 4px;
        }
        #admin-notifications-container::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.15);
            border-radius: 4px;
        }
        #admin-notifications-container::-webkit-scrollbar-thumb:hover {
            background: rgba(0,0,0,0.3);
        }

        .admin-notification-card {
            background: var(--white);
            border: var(--border);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            box-shadow: var(--shadow-lg);
            animation: slideInUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            flex-shrink: 0;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
        }

        .admin-notification-card:hover {
            transform: translateX(-3px);
            box-shadow: var(--shadow-lg);
        }

        .admin-notification-card.waiter-call {
            border-left-color: var(--danger);
        }

        .admin-notification-header {
            font-weight: 700;
            font-size: 12px;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .admin-notification-header i {
            font-size: 12px;
        }

        .admin-notification-body {
            font-size: 11px;
            color: var(--text-light);
            line-height: 1.4;
        }

        .admin-notification-body strong {
            color: var(--text);
        }

        .admin-notification-footer {
            display: flex;
            gap: 6px;
            margin-top: 6px;
        }

        .admin-notification-footer .btn-sm {
            font-size: 10px;
            padding: 2px 10px;
            height: 24px;
            border-radius: 30px !important;
        }

        .notif-time {
            font-size: 9px;
            color: #9ca3af;
            margin-top: 2px;
            display: block;
        }

        .admin-notification-card.slide-out {
            animation: slideOutRight 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slideInUp {
            from { transform: translateY(15px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(30px); opacity: 0; }
        }

        /* ── DARK MODE NOTIFICATION ── */
        @media (prefers-color-scheme: dark) {
            .admin-notification-card {
                background: #1f2937;
                border-color: #374151;
            }
            .notif-time {
                color: #6b7280;
            }
            #admin-notifications-container::-webkit-scrollbar-track {
                background: rgba(255,255,255,0.05);
            }
            #admin-notifications-container::-webkit-scrollbar-thumb {
                background: rgba(255,255,255,0.15);
            }
        }

        /* ── RESPONSIVE NOTIFICATION ── */
        @media (max-width: 768px) {
            #admin-notifications-container {
                right: 12px;
                bottom: 12px;
                width: calc(100% - 24px);
                max-width: 300px;
                max-height: 250px;
            }
            .admin-notification-card {
                padding: 8px 12px;
            }
            .admin-notification-header {
                font-size: 11px;
            }
            .admin-notification-body {
                font-size: 10px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Toast Container -->
    <div id="toast-container"></div>

    @auth('admin')
    <div id="admin-notifications-container"></div>
    @endauth

    <!-- Global Delete Modal -->
    <div class="modal-backdrop" id="delete-modal-backdrop">
        <div class="modal modal-sm">
            <div class="modal-body" style="padding: 28px 24px;">
                <div class="delete-modal-icon">🗑️</div>
                <div class="delete-modal-title">Hapus Data?</div>
                <div class="delete-modal-desc" id="delete-modal-desc">
                    Apakah Anda yakin ingin menghapus <span id="delete-modal-name" style="font-weight: 700; color: var(--primary);"></span>?
                    <br><span style="font-size: 13px; color: var(--text-light);">Tindakan ini tidak dapat dibatalkan.</span>
                </div>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" class="btn btn-outline btn-sm" onclick="closeDeleteModal()">Batal</button>
                    <form id="delete-modal-form" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Pivot Caffe">
            <div>
                <h1>Pivot Cafe</h1>
                <span>Panel Administrasi</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            @php $role = auth('admin')->user()->role ?? null; @endphp

            <div class="nav-section">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Beranda
                @if(isset($pendingWaiterCallsCount) && $pendingWaiterCallsCount > 0)
                    <span class="waiter-badge">{{ $pendingWaiterCallsCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.orders.monitor') }}" class="nav-link {{ request()->routeIs('admin.orders.monitor') ? 'active' : '' }}">
                <i class="fas fa-desktop"></i> Monitor Pesanan
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show') || request()->routeIs('admin.orders.print') || request()->routeIs('admin.orders.filter') ? 'active' : '' }}">
                <i class="fas fa-clock-rotate-left"></i> Riwayat Pesanan
            </a>

            @if($role === 'admin')
                <a href="{{ route('admin.laporan') }}" class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Laporan
                </a>
            @endif

            @if($role === 'admin')
                <div class="nav-section">Katalog</div>
                <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.*') || request()->routeIs('admin.addons.*') || request()->routeIs('admin.variant-groups.*') ? 'active' : '' }}">
                    <i class="fas fa-utensils"></i> Menu
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i> Kategori
                </a>
                <a href="{{ route('admin.retail-products.index') }}" class="nav-link {{ request()->routeIs('admin.retail-products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Produk Retail
                </a>
            @endif

            <div class="nav-section">Operasional</div>
            @if($role === 'admin')
                <a href="{{ route('admin.tables.index') }}" class="nav-link {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
                    <i class="fas fa-chair"></i> Meja
                </a>
                <a href="{{ route('admin.promos.index') }}" class="nav-link {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket"></i> Promo
                </a>
                <a href="{{ route('admin.feedback.index') }}" class="nav-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                    <i class="fas fa-comment-dots"></i> Komentar 
                </a>
            @endif

            <a href="{{ route('admin.waiter-calls.index') }}" class="nav-link {{ request()->routeIs('admin.waiter-calls.*') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> Panggilan 
            </a>

            @if($role === 'admin')
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-gear"></i> Manajemen Pengguna
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Pesan Kontak
                </a>
            @endif

            <div style="margin-top: 16px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 12px;">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-right-from-bracket"></i> Keluar Sistem
                    </button>
                </form>
            </div>
        </nav>
        <div class="sidebar-footer">
            <span>{{ auth('admin')->user()->name ?? 'Administrator' }}</span>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button class="hamburger" id="hamburger-btn" onclick="toggleSidebar()" aria-label="Toggle menu">
                    <span></span><span></span><span></span>
                </button>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            </div>
            <div class="topbar-right">
                <div class="admin-profile">
                    <div class="admin-avatar">
                        {{ substr(auth('admin')->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <span class="admin-name">{{ auth('admin')->user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </header>
        <main class="content">
            @yield('content')
        </main>
    </div>

    <script>
        // ── TOGGLE SIDEBAR ──
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebar-overlay').classList.remove('show');
            document.body.style.overflow = '';
        }

        // ── TOAST ──
        function showToast(type, title, message) {
            const container = document.getElementById('toast-container');
            const isSuccess = type === 'success';
            const borderColor = isSuccess ? 'var(--success)' : 'var(--danger)';
            const icon = isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.style.borderLeftColor = borderColor;
            toast.innerHTML = `
                <i class="fas ${icon}" style="color: ${borderColor}; font-size: 18px;"></i>
                <div>
                    <div style="font-weight: 600; font-size: 14px;">${title}</div>
                    <div style="font-size: 13px; color: var(--text-light);">${message}</div>
                </div>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(20px)';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        // ── DELETE MODAL ──
        function confirmDelete(action, name, desc) {
            document.getElementById('delete-modal-name').textContent = name || '';
            document.getElementById('delete-modal-desc').innerHTML = desc || `Apakah Anda yakin ingin menghapus <span style="font-weight: 700; color: var(--primary);">${name || 'item'}</span>?<br><span style="font-size: 13px; color: var(--text-light);">Tindakan ini tidak dapat dibatalkan.</span>`;
            document.getElementById('delete-modal-form').action = action;
            document.getElementById('delete-modal-backdrop').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal-backdrop').classList.remove('open');
            document.body.style.overflow = '';
        }

        // ── MODAL ──
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('open');
                document.body.style.overflow = '';
            }
        }

        // ── TABLE SORT ──
        function initSortableTable(tableSelector) {
            const table = typeof tableSelector === 'string' ? document.querySelector(tableSelector) : tableSelector;
            if (!table) return;
            
            const headers = table.querySelectorAll('thead th');
            let sortCol = -1, sortAsc = true;
            
            headers.forEach((th, colIdx) => {
                if (th.classList.contains('no-sort')) return;
                th.style.cursor = 'pointer';
                th.style.userSelect = 'none';
                
                const indicator = document.createElement('span');
                indicator.className = 'sort-indicator';
                indicator.style.cssText = 'margin-left: 6px; font-size: 10px; opacity: 0.3; display: inline-block;';
                indicator.textContent = '⇅';
                th.appendChild(indicator);
                
                th.addEventListener('click', () => {
                    if (sortCol === colIdx) {
                        sortAsc = !sortAsc;
                    } else {
                        sortCol = colIdx;
                        sortAsc = true;
                    }
                    
                    headers.forEach(h => {
                        const ind = h.querySelector('.sort-indicator');
                        if (ind) {
                            ind.textContent = '⇅';
                            ind.style.opacity = '0.3';
                            ind.style.color = '';
                        }
                    });
                    
                    indicator.textContent = sortAsc ? '↑' : '↓';
                    indicator.style.opacity = '1';
                    indicator.style.color = 'var(--accent)';
                    
                    const tbody = table.querySelector('tbody');
                    const rows = Array.from(tbody.querySelectorAll('tr'));
                    
                    rows.sort((a, b) => {
                        const aCell = a.querySelectorAll('td')[colIdx];
                        const bCell = b.querySelectorAll('td')[colIdx];
                        if (!aCell || !bCell) return 0;
                        
                        const aText = aCell.innerText.trim().toLowerCase();
                        const bText = bCell.innerText.trim().toLowerCase();
                        const aNum = parseFloat(aText.replace(/[^0-9,.-]/g, '').replace(',', '.'));
                        const bNum = parseFloat(bText.replace(/[^0-9,.-]/g, '').replace(',', '.'));
                        
                        if (!isNaN(aNum) && !isNaN(bNum)) {
                            return sortAsc ? aNum - bNum : bNum - aNum;
                        }
                        return sortAsc ? aText.localeCompare(bText, 'id') : bText.localeCompare(aText, 'id');
                    });
                    
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        }

        // ── INIT ──
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('table.sortable').forEach(t => initSortableTable(t));
            
            @if(session('success'))
                showToast('success', 'Berhasil', @json(session('success')));
            @endif
            @if(session('error'))
                showToast('error', 'Gagal', @json(session('error')));
            @endif
            @if($errors->any() && session('open_modal'))
                openModal(@json(session('open_modal')));
            @endif

            // ── ADMIN NOTIFICATIONS ──
            // Hanya dijalankan jika user login sebagai admin
            @auth('admin')
            (function() {
                const container = document.getElementById('admin-notifications-container');
                if (!container) return;

                container.style.display = 'flex';

                let isFirstLoad = true;
                const MAX_NOTIFICATIONS = 10;

                function formatTime(dateString) {
                    if (!dateString) return 'Baru saja';
                    const date = new Date(dateString);
                    if (isNaN(date.getTime())) return 'Baru saja';

                    const now = new Date();
                    const diffMs = now - date;
                    const diffMin = Math.floor(diffMs / 60000);
                    const diffHour = Math.floor(diffMs / 3600000);

                    if (diffMin < 1) return 'Baru saja';
                    if (diffMin < 60) return diffMin + 'm';
                    if (diffHour < 24) return diffHour + 'j';
                    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                }

                // Fungsi untuk mengurutkan ulang card berdasarkan timestamp (descending)
                function reorderCards() {
                    const cards = Array.from(container.children);
                    cards.sort((a, b) => {
                        const timeA = parseInt(a.dataset.timestamp || 0);
                        const timeB = parseInt(b.dataset.timestamp || 0);
                        return timeB - timeA; // descending: yang baru di atas
                    });
                    cards.forEach(card => container.appendChild(card));
                }

                function fetchAdminNotifications() {
                    fetch('{{ route("admin.notifications.peek") }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => res.ok ? res.json() : null)
                    .then(data => {
                        if (!data) return;

                        const allNotifications = [];

                        // Proses orders
                        (data.orders || []).forEach(order => {
                            allNotifications.push({
                                id: `admin-notif-order-${order.id}`,
                                type: 'order',
                                data: order,
                                created_at: order.created_at,
                                timestamp: new Date(order.created_at).getTime()
                            });
                        });

                        // Proses waiter calls
                        (data.waiter_calls || []).forEach(call => {
                            allNotifications.push({
                                id: `admin-notif-call-${call.id}`,
                                type: 'call',
                                data: call,
                                created_at: call.created_at,
                                timestamp: new Date(call.created_at).getTime()
                            });
                        });

                        // Urutkan dari yang terbaru
                        allNotifications.sort((a, b) => b.timestamp - a.timestamp);

                        // Batasi maksimal
                        if (allNotifications.length > MAX_NOTIFICATIONS) {
                            allNotifications.length = MAX_NOTIFICATIONS;
                        }

                        // Ambil ID notifikasi yang aktif dari data baru
                        const activeIds = allNotifications.map(n => n.id);

                        // Hapus card yang tidak ada di data baru (dengan animasi slide-out)
                        const existingCards = container.querySelectorAll('.admin-notification-card');
                        existingCards.forEach(card => {
                            if (!activeIds.includes(card.id)) {
                                card.classList.add('slide-out');
                                setTimeout(() => card.remove(), 300);
                            }
                        });

                        // Tambahkan card baru atau perbarui yang sudah ada
                        allNotifications.forEach(notif => {
                            let card = document.getElementById(notif.id);
                            if (!card) {
                                // Buat card baru
                                card = document.createElement('div');
                                card.id = notif.id;
                                card.className = `admin-notification-card ${notif.type === 'order' ? 'new-order' : 'waiter-call'}`;
                                card.dataset.timestamp = notif.timestamp;

                                let headerHtml = '';
                                let bodyHtml = '';
                                let footerHtml = '';
                                let timeHtml = '';

                                if (notif.type === 'order') {
                                    const order = notif.data;
                                    headerHtml = `
                                        <div class="admin-notification-header" style="color: var(--primary);">
                                            <i class="fas fa-coffee"></i> Pesanan Baru
                                        </div>
                                    `;
                                    bodyHtml = `
                                        <div class="admin-notification-body">
                                            <strong>Meja ${order.table_number}</strong> — ${order.customer_name}
                                        </div>
                                    `;
                                    footerHtml = `
                                        <div class="admin-notification-footer">
                                            <a href="${order.url}" class="btn btn-primary btn-sm">Proses</a>
                                        </div>
                                    `;
                                    timeHtml = `<span class="notif-time">${formatTime(order.created_at)}</span>`;
                                } else {
                                    const call = notif.data;
                                    headerHtml = `
                                        <div class="admin-notification-header" style="color: var(--danger);">
                                            <i class="fas fa-bell"></i> 🔔 Panggilan Pelayan
                                        </div>
                                    `;
                                    bodyHtml = `
                                        <div class="admin-notification-body">
                                            <strong>Meja ${call.table_number}</strong> butuh bantuan
                                        </div>
                                    `;
                                    footerHtml = `
                                        <div class="admin-notification-footer">
                                            <form action="${call.done_url}" method="POST" style="display:inline;">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-success btn-sm">✅ Selesai</button>
                                            </form>
                                        </div>
                                    `;
                                    timeHtml = `<span class="notif-time">${formatTime(call.created_at)}</span>`;
                                }

                                card.innerHTML = `
                                    ${headerHtml}
                                    ${bodyHtml}
                                    ${timeHtml}
                                    ${footerHtml}
                                `;

                                // Masukkan ke container (tambahkan di akhir, nanti diurutkan ulang)
                                container.appendChild(card);
                            } else {
                                // Update timestamp jika berubah (misal untuk urutan)
                                card.dataset.timestamp = notif.timestamp;
                            }
                        });

                        // Urutkan ulang semua card berdasarkan timestamp (descending)
                        reorderCards();

                        isFirstLoad = false;
                    })
                    .catch(err => console.error('Error fetching notifications:', err));
                }

                // Panggil pertama kali dan interval
                fetchAdminNotifications();
                setInterval(fetchAdminNotifications, 5000);
            })();
            @endauth
        });
    </script>
    @stack('scripts')
</body>
</html>