<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>داشبورد کاربر | GRAFIUM</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />

    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --deep-navy: #0a1628;
            --deep-navy-light: #132238;
            --gold: #d4a373;
            --gold-dark: #b8874a;
            --gold-light: #f0d5b0;
            --gold-gradient: linear-gradient(135deg, #d4a373, #b8874a);
            --navy-gradient: linear-gradient(135deg, #0a1628, #1a2f4a);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --border: #e4e7ec;
            --shadow: 0 4px 30px rgba(10, 22, 40, 0.08);
            --radius: 16px;
            --radius-sm: 12px;
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font: "Vazirmatn", "Inter", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #132238;
            --text: #f0f0f0;
            --text-muted: #a0a0a0;
            --border: #1a2f4a;
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font);
            background: var(--bg-body);
            color: var(--text);
            direction: rtl;
            transition: background 0.4s, color 0.4s;
            line-height: 1.7;
            overflow-x: hidden;
        }

        ::selection { background: var(--gold); color: #fff; }

        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; display: block; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== TEXT & BADGE ===== */
        .gold-text {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .purple-text {
            color: var(--deep-navy);
        }
        [data-theme="dark"] .purple-text {
            color: #f0f0f0;
        }

        .gradient-badge {
            display: inline-block;
            background: var(--gold-gradient);
            color: #fff;
            padding: 4px 16px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            cursor: pointer;
            border: 2px solid transparent;
            background: var(--gold-gradient);
            color: #fff;
        }
        .btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.3);
        }
        .btn-gold {
            background: var(--gold-gradient);
            border-color: var(--gold);
            box-shadow: 0 4px 20px rgba(212, 163, 115, 0.2);
        }
        .btn-gold:hover {
            border-color: var(--gold-light);
            box-shadow: 0 8px 35px rgba(212, 163, 115, 0.35);
        }
        .btn-gold-outline {
            background: transparent;
            color: var(--gold);
            border: 2px solid var(--gold);
        }
        .btn-gold-outline:hover {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
        }
        .btn-white {
            background: #fff;
            color: var(--deep-navy);
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
        }
        .btn-white:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(255, 255, 255, 0.2);
        }
        .btn-sm {
            padding: 6px 16px;
            font-size: 12px;
        }

        /* ===== HEADER ===== */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212, 163, 115, 0.15);
            padding: 8px 0;
            transition: background 0.4s, border-color 0.4s;
        }
        [data-theme="dark"] .header {
            background: rgba(10, 22, 40, 0.95);
        }
        [data-theme="light"] .header {
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid var(--border);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 800;
        }
        .logo-img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .nav-desktop ul {
            display: flex;
            gap: 28px;
        }
        .nav-desktop a {
            font-weight: 500;
            font-size: 15px;
            position: relative;
            transition: color 0.3s;
            color: rgba(255, 255, 255, 0.7);
        }
        [data-theme="light"] .nav-desktop a {
            color: var(--deep-navy);
        }
        .nav-desktop a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            right: 0;
            width: 0;
            height: 2px;
            background: var(--gold-gradient);
            transition: width 0.3s;
        }
        .nav-desktop a:hover::after {
            width: 100%;
        }
        .nav-desktop a:hover {
            color: var(--gold);
        }
        .nav-desktop a.active {
            color: var(--gold);
        }
        .nav-desktop a.active::after {
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: transparent;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        [data-theme="light"] .theme-toggle {
            border-color: var(--border);
            color: var(--deep-navy);
        }
        .theme-toggle:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .menu-toggle {
            display: none;
            font-size: 24px;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        [data-theme="light"] .menu-toggle {
            color: var(--deep-navy);
        }

        /* ===== MOBILE MENU ===== */
        .mobile-menu {
            display: none;
            flex-direction: column;
            gap: 16px;
            padding: 20px;
            background: var(--bg-card);
            border-top: 1px solid var(--border);
        }
        .mobile-menu.open {
            display: flex;
        }
        .mobile-menu ul {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .mobile-menu a {
            font-weight: 500;
            font-size: 16px;
        }
        .mobile-auth {
            display: flex;
            gap: 12px;
        }

        /* ============================================================
           DASHBOARD
           ============================================================ */
        .dashboard-page {
            padding: 40px 0 60px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
            margin-top: 20px;
        }

        /* ===== SIDEBAR ===== */
        .dashboard-sidebar {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 24px 20px;
            box-shadow: var(--shadow);
            height: fit-content;
            transition: all 0.3s ease;
        }
        .dashboard-sidebar:hover {
            border-color: var(--gold);
            box-shadow: 0 8px 30px rgba(212, 163, 115, 0.08);
        }

        .user-info {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
        }
        .user-info .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--gold);
            margin: 0 auto 12px;
        }
        .user-info h3 {
            font-size: 18px;
            font-weight: 700;
        }
        .user-info p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .dashboard-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .dashboard-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }
        .dashboard-nav a i {
            width: 20px;
            color: var(--gold);
        }
        .dashboard-nav a:hover {
            background: rgba(212, 163, 115, 0.08);
            color: var(--text);
        }
        .dashboard-nav a.active {
            background: rgba(212, 163, 115, 0.12);
            color: var(--gold);
        }
        .dashboard-nav .logout-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            color: #ef4444;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            font-family: var(--font);
        }
        .dashboard-nav .logout-btn i {
            width: 20px;
            color: #ef4444;
        }
        .dashboard-nav .logout-btn:hover {
            background: rgba(239, 68, 68, 0.08);
        }

        /* ===== CONTENT ===== */
        .dashboard-content {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 30px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        .dashboard-content:hover {
            border-color: var(--gold);
            box-shadow: 0 8px 30px rgba(212, 163, 115, 0.08);
        }

        .dashboard-content .page-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 6px;
        }
        .dashboard-content .page-subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 24px;
        }

        /* ===== TAB CONTENT ===== */
        .tab-content {
            display: none;
            animation: fadeSlideIn 0.4s ease forwards;
        }
        .tab-content.active {
            display: block;
        }

        @keyframes fadeSlideIn {
            0% { opacity: 0; transform: translateY(12px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ===== STATS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: var(--bg-body);
            border-radius: var(--radius-sm);
            padding: 18px 20px;
            text-align: center;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            border-color: var(--gold);
            transform: translateY(-4px);
            box-shadow: 0 4px 20px rgba(212, 163, 115, 0.06);
        }
        .stat-card .number {
            display: block;
            font-size: 32px;
            font-weight: 800;
            color: var(--gold);
        }
        .stat-card .label {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* ===== TABLE ===== */
        .table-wrap {
            overflow-x: auto;
        }
        .table-wrap table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .table-wrap thead {
            background: var(--bg-body);
        }
        .table-wrap th {
            padding: 12px 16px;
            text-align: right;
            font-weight: 700;
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-wrap td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }
        .table-wrap tr:hover td {
            background: rgba(212, 163, 115, 0.03);
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-active {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-expired {
            background: #f3f4f6;
            color: #4b5563;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* ===== FILTER ===== */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
            align-items: center;
        }
        .filter-bar select,
        .filter-bar input {
            padding: 8px 14px;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--bg-body);
            color: var(--text);
            font-family: var(--font);
            font-size: 13px;
            outline: none;
            transition: all 0.3s ease;
        }
        .filter-bar select:focus,
        .filter-bar input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.1);
        }

        /* ===== PROFILE FORM ===== */
        .profile-form .form-group {
            margin-bottom: 18px;
        }
        .profile-form label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
            color: var(--text);
        }
        .profile-form input,
        .profile-form textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--bg-body);
            color: var(--text);
            font-family: var(--font);
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }
        .profile-form input:focus,
        .profile-form textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.1);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--deep-navy);
            color: #c8c8d4;
            padding: 40px 0 20px;
            margin-top: 40px;
            border-top: 2px solid var(--gold);
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-align: center;
        }
        .footer-brand .logo { justify-content: center; }
        .footer-brand p {
            font-size: 14px;
            max-width: 300px;
            margin: 0 auto 16px;
            color: rgba(255, 255, 255, 0.5);
        }
        .footer-social {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .footer-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #c8c8d4;
            transition: var(--transition);
        }
        .footer-social a:hover {
            background: var(--gold);
            color: #fff;
        }
        .footer-links h4,
        .footer-contact h4 {
            color: #fff;
            font-size: 16px;
            margin-bottom: 16px;
        }
        .footer-links ul,
        .footer-contact ul {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
        .footer-links a,
        .footer-contact li {
            font-size: 14px;
            color: #94a3b8;
        }
        .footer-links a:hover { color: var(--gold); }
        .footer-contact li {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer-contact li i {
            color: var(--gold);
            width: 20px;
        }
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            font-size: 14px;
            color: #64748b;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .dashboard-sidebar {
                order: 2;
            }
            .dashboard-content {
                order: 1;
                padding: 16px;
            }
            .dashboard-sidebar {
                padding: 16px;
            }
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-bar select,
            .filter-bar input {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .dashboard-content {
                padding: 12px;
            }
            .dashboard-sidebar {
                padding: 12px;
            }
            .stat-card .number {
                font-size: 24px;
            }
            .table-wrap table {
                font-size: 12px;
            }
            .table-wrap th,
            .table-wrap td {
                padding: 8px 10px;
            }
            .page-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- ============================================================
    HEADER
    ============================================================ -->
    <header class="header" id="header">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium Logo" class="logo-img" />
            </a>
            <nav class="nav-desktop">
                <ul>
                    <li><a href="{{ route('home') }}">خانه</a></li>
                    <li><a href="{{ route('about') }}">درباره ما</a></li>
                    <li><a href="{{ route('services') }}">خدمات</a></li>
                    <li><a href="{{ route('blog') }}">بلاگ</a></li>
                    <li><a href="{{ route('contact') }}">تماس</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle"><i class="fas fa-moon"></i></button>
                @auth
                    <span class="btn btn-gold" style="cursor:default;">
                        <i class="fas fa-user"></i> {{ Auth::user()->name ?? 'کاربر' }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-gold-outline">خروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold">ورود</a>
                @endauth
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <ul>
                <li><a href="{{ route('home') }}">خانه</a></li>
                <li><a href="{{ route('about') }}">درباره ما</a></li>
                <li><a href="{{ route('services') }}">خدمات</a></li>
                <li><a href="{{ route('blog') }}">بلاگ</a></li>
                <li><a href="{{ route('contact') }}">تماس</a></li>
            </ul>
            <div class="mobile-auth">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-gold">داشبورد</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold">ورود</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ============================================================
    DASHBOARD
    ============================================================ -->
    <section class="dashboard-page">
        <div class="container">
            <div class="dashboard-grid">

                <!-- ===== SIDEBAR ===== -->
                <aside class="dashboard-sidebar">
                    <div class="user-info">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'کاربر' }}&background=d4a373&color=fff&bold=true&size=80"
                             alt="avatar" class="avatar" />
                        <h3 class="purple-text">{{ Auth::user()->name ?? 'کاربر مهمان' }}</h3>
                        <p>{{ Auth::user()->email ?? 'email@example.com' }}</p>
                    </div>

                    <nav class="dashboard-nav">
                        <a class="active" data-tab="dashboard-tab">
                            <i class="fas fa-home"></i> داشبورد
                        </a>
                        <a data-tab="reservations-tab">
                            <i class="fas fa-calendar-check"></i> رزروهای من
                        </a>
                        <a data-tab="invoices-tab">
                            <i class="fas fa-file-invoice"></i> فاکتورها
                        </a>
                        <a data-tab="profile-tab">
                            <i class="fas fa-user-edit"></i> ویرایش پروفایل
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="margin-top:8px;">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> خروج از حساب
                            </button>
                        </form>
                    </nav>
                </aside>

                <!-- ===== CONTENT ===== -->
                <main class="dashboard-content">

                    <!-- ====== TAB 1: DASHBOARD ====== -->
                    <div id="dashboard-tab" class="tab-content active">
                        <h2 class="page-title purple-text">
                            <i class="fas fa-hand-peace"></i> خوش آمدید، {{ Auth::user()->name ?? 'کاربر' }}!
                        </h2>
                        <p class="page-subtitle">از آخرین وضعیت رزروها و فعالیت‌های خود مطلع شوید.</p>

                        <div class="stats-grid">
                            <div class="stat-card">
                                <span class="number">۳</span>
                                <span class="label">رزرو فعال</span>
                            </div>
                            <div class="stat-card">
                                <span class="number">۱۲</span>
                                <span class="label">کل رزروها</span>
                            </div>
                            <div class="stat-card">
                                <span class="number">۵</span>
                                <span class="label">فاکتور</span>
                            </div>
                        </div>

                        <h3 style="font-size:18px;font-weight:700;margin-bottom:16px;">
                            <i class="fas fa-clock"></i> آخرین رزروها
                        </h3>

                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>میز</th>
                                        <th>تاریخ</th>
                                        <th>شیفت</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $recentReservations = [
                                            ['desk' => 3, 'date' => '۱۴۰۵/۰۵/۲۰', 'shift' => 'شیفت ۱ (۸-۱۴)', 'status' => 'active', 'status_text' => 'فعال'],
                                            ['desk' => 7, 'date' => '۱۴۰۵/۰۵/۲۲', 'shift' => 'شیفت ۲ (۱۵-۲۱)', 'status' => 'pending', 'status_text' => 'در انتظار'],
                                            ['desk' => 1, 'date' => '۱۴۰۵/۰۵/۱۸', 'shift' => 'روز کامل', 'status' => 'cancelled', 'status_text' => 'لغو شده'],
                                        ];
                                    @endphp

                                    @forelse($recentReservations as $res)
                                    <tr>
                                        <td><strong>میز {{ $res['desk'] }}</strong></td>
                                        <td>{{ $res['date'] }}</td>
                                        <td>{{ $res['shift'] }}</td>
                                        <td>
                                            <span class="badge-{{ $res['status'] }}">
                                                {{ $res['status_text'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="gold-link" style="font-size:13px;color:var(--gold);">
                                                <i class="fas fa-eye"></i> مشاهده
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px 0;">
                                            <i class="fas fa-calendar-times" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                            هیچ رزروی یافت نشد.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div style="margin-top:20px;text-align:left;">
                            <a href="{{ route('services') }}" class="btn btn-gold">
                                <i class="fas fa-plus"></i> رزرو جدید
                            </a>
                        </div>
                    </div>

                    <!-- ====== TAB 2: RESERVATIONS ====== -->
                    <div id="reservations-tab" class="tab-content">
                        <h2 class="page-title purple-text">
                            <i class="fas fa-calendar-check"></i> رزروهای من
                        </h2>
                        <p class="page-subtitle">لیست کامل رزروهای شما با قابلیت فیلتر</p>

                        <div class="filter-bar">
                            <select id="reservationFilter">
                                <option value="all">همه</option>
                                <option value="active">فعال</option>
                                <option value="pending">در انتظار</option>
                                <option value="cancelled">لغو شده</option>
                                <option value="expired">منقضی</option>
                            </select>
                            <input type="text" id="reservationSearch" placeholder="جستجو در رزروها..." />
                            <button class="btn btn-gold btn-sm" onclick="filterReservations()">
                                <i class="fas fa-search"></i> جستجو
                            </button>
                        </div>

                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>میز</th>
                                        <th>تاریخ</th>
                                        <th>شیفت</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ رزرو</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody id="reservationsTableBody">
                                    @php
                                        $allReservations = [
                                            ['desk' => 3, 'date' => '۱۴۰۵/۰۵/۲۰', 'shift' => 'شیفت ۱ (۸-۱۴)', 'status' => 'active', 'status_text' => 'فعال', 'created_at' => '۱۴۰۵/۰۵/۰۱'],
                                            ['desk' => 7, 'date' => '۱۴۰۵/۰۵/۲۲', 'shift' => 'شیفت ۲ (۱۵-۲۱)', 'status' => 'pending', 'status_text' => 'در انتظار', 'created_at' => '۱۴۰۵/۰۵/۰۲'],
                                            ['desk' => 1, 'date' => '۱۴۰۵/۰۵/۱۸', 'shift' => 'روز کامل', 'status' => 'cancelled', 'status_text' => 'لغو شده', 'created_at' => '۱۴۰۵/۰۴/۲۸'],
                                            ['desk' => 5, 'date' => '۱۴۰۵/۰۵/۲۵', 'shift' => 'شیفت ۱ (۸-۱۴)', 'status' => 'active', 'status_text' => 'فعال', 'created_at' => '۱۴۰۵/۰۵/۰۳'],
                                            ['desk' => 2, 'date' => '۱۴۰۵/۰۴/۱۵', 'shift' => 'شیفت ۲ (۱۵-۲۱)', 'status' => 'expired', 'status_text' => 'منقضی', 'created_at' => '۱۴۰۵/۰۳/۲۰'],
                                            ['desk' => 8, 'date' => '۱۴۰۵/۰۵/۲۸', 'shift' => 'روز کامل', 'status' => 'pending', 'status_text' => 'در انتظار', 'created_at' => '۱۴۰۵/۰۵/۰۴'],
                                            ['desk' => 4, 'date' => '۱۴۰۵/۰۴/۲۵', 'shift' => 'شیفت ۱ (۸-۱۴)', 'status' => 'cancelled', 'status_text' => 'لغو شده', 'created_at' => '۱۴۰۵/۰۴/۱۰'],
                                            ['desk' => 9, 'date' => '۱۴۰۵/۰۶/۰۱', 'shift' => 'شیفت ۲ (۱۵-۲۱)', 'status' => 'active', 'status_text' => 'فعال', 'created_at' => '۱۴۰۵/۰۵/۰۵'],
                                            ['desk' => 6, 'date' => '۱۴۰۵/۰۴/۱۰', 'shift' => 'روز کامل', 'status' => 'expired', 'status_text' => 'منقضی', 'created_at' => '۱۴۰۵/۰۳/۰۱'],
                                            ['desk' => 10, 'date' => '۱۴۰۵/۰۶/۰۵', 'shift' => 'شیفت ۱ (۸-۱۴)', 'status' => 'pending', 'status_text' => 'در انتظار', 'created_at' => '۱۴۰۵/۰۵/۰۶'],
                                            ['desk' => 11, 'date' => '۱۴۰۵/۰۵/۳۰', 'shift' => 'شیفت ۲ (۱۵-۲۱)', 'status' => 'active', 'status_text' => 'فعال', 'created_at' => '۱۴۰۵/۰۵/۰۷'],
                                            ['desk' => 12, 'date' => '۱۴۰۵/۰۴/۰۵', 'shift' => 'روز کامل', 'status' => 'expired', 'status_text' => 'منقضی', 'created_at' => '۱۴۰۵/۰۲/۲۵'],
                                        ];
                                    @endphp

                                    @forelse($allReservations as $res)
                                    <tr class="reservation-row" data-status="{{ $res['status'] }}" data-search="{{ $res['desk'] }} {{ $res['date'] }}">
                                        <td><strong>میز {{ $res['desk'] }}</strong></td>
                                        <td>{{ $res['date'] }}</td>
                                        <td>{{ $res['shift'] }}</td>
                                        <td>
                                            <span class="badge-{{ $res['status'] }}">
                                                {{ $res['status_text'] }}
                                            </span>
                                        </td>
                                        <td>{{ $res['created_at'] }}</td>
                                        <td>
                                            <a href="#" class="gold-link" style="font-size:13px;color:var(--gold);">
                                                <i class="fas fa-eye"></i> مشاهده
                                            </a>
                                            @if($res['status'] == 'pending' || $res['status'] == 'active')
                                            <a href="#" class="gold-link" style="font-size:13px;color:#ef4444;margin-right:8px;" onclick="return confirm('آیا از لغو این رزرو اطمینان دارید؟')">
                                                <i class="fas fa-times"></i> لغو
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center;color:var(--text-muted);padding:30px 0;">
                                            <i class="fas fa-calendar-times" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                            هیچ رزروی یافت نشد.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ====== TAB 3: INVOICES ====== -->
                    <div id="invoices-tab" class="tab-content">
                        <h2 class="page-title purple-text">
                            <i class="fas fa-file-invoice"></i> فاکتورها
                        </h2>
                        <p class="page-subtitle">لیست فاکتورهای شما</p>

                        <div class="filter-bar">
                            <select id="invoiceFilter">
                                <option value="all">همه</option>
                                <option value="paid">پرداخت شده</option>
                                <option value="pending">در انتظار پرداخت</option>
                                <option value="cancelled">لغو شده</option>
                            </select>
                        </div>

                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>شماره فاکتور</th>
                                        <th>تاریخ</th>
                                        <th>مبلغ</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $invoices = [
                                            ['id' => 'INV-001', 'date' => '۱۴۰۵/۰۵/۲۰', 'amount' => '۱,۵۰۰,۰۰۰', 'status' => 'paid', 'status_text' => 'پرداخت شده'],
                                            ['id' => 'INV-002', 'date' => '۱۴۰۵/۰۵/۱۵', 'amount' => '۲,۰۰۰,۰۰۰', 'status' => 'pending', 'status_text' => 'در انتظار پرداخت'],
                                            ['id' => 'INV-003', 'date' => '۱۴۰۵/۰۴/۲۸', 'amount' => '۷۵۰,۰۰۰', 'status' => 'paid', 'status_text' => 'پرداخت شده'],
                                            ['id' => 'INV-004', 'date' => '۱۴۰۵/۰۴/۱۰', 'amount' => '۱,۲۰۰,۰۰۰', 'status' => 'cancelled', 'status_text' => 'لغو شده'],
                                            ['id' => 'INV-005', 'date' => '۱۴۰۵/۰۵/۰۱', 'amount' => '۳,۰۰۰,۰۰۰', 'status' => 'pending', 'status_text' => 'در انتظار پرداخت'],
                                        ];
                                    @endphp

                                    @forelse($invoices as $inv)
                                    <tr>
                                        <td><strong>{{ $inv['id'] }}</strong></td>
                                        <td>{{ $inv['date'] }}</td>
                                        <td>{{ $inv['amount'] }} تومان</td>
                                        <td>
                                            <span class="badge-{{ $inv['status'] }}">
                                                {{ $inv['status_text'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('invoice') }}" class="gold-link" style="font-size:13px;color:var(--gold);">
                                                <i class="fas fa-download"></i> دانلود
                                            </a>
                                            @if($inv['status'] == 'pending')
                                            <a href="#" class="gold-link" style="font-size:13px;color:#22c55e;margin-right:8px;">
                                                <i class="fas fa-credit-card"></i> پرداخت
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px 0;">
                                            <i class="fas fa-file-invoice" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                            هیچ فاکتوری یافت نشد.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ====== TAB 4: PROFILE ====== -->
                    <div id="profile-tab" class="tab-content">
                        <h2 class="page-title purple-text">
                            <i class="fas fa-user-edit"></i> ویرایش پروفایل
                        </h2>
                        <p class="page-subtitle">اطلاعات شخصی خود را به‌روزرسانی کنید</p>

                        <form class="profile-form" id="profileForm">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="fullName"><i class="fas fa-user"></i> نام کامل</label>
                                    <input type="text" id="fullName" value="{{ Auth::user()->name ?? 'کاربر' }}" required />
                                </div>

                                <div class="form-group">
                                    <label for="email"><i class="fas fa-envelope"></i> ایمیل</label>
                                    <input type="email" id="email" value="{{ Auth::user()->email ?? 'email@example.com' }}" required />
                                </div>

                                <div class="form-group">
                                    <label for="phone"><i class="fas fa-phone"></i> شماره تماس</label>
                                    <input type="text" id="phone" value="۰۹۱۲-۳۴۵-۶۷۸۹" />
                                </div>

                                <div class="form-group">
                                    <label for="password"><i class="fas fa-lock"></i> رمز عبور جدید</label>
                                    <input type="password" id="password" placeholder="برای تغییر وارد کنید" />
                                </div>

                                <div class="form-group md:col-span-2">
                                    <label for="address"><i class="fas fa-map-pin"></i> آدرس</label>
                                    <textarea id="address" rows="3">تهران، خیابان اصلی، پلاک ۱۲۳</textarea>
                                </div>
                            </div>

                            <div style="margin-top:20px;text-align:left;">
                                <button type="submit" class="btn btn-gold">
                                    <i class="fas fa-save"></i> ذخیره تغییرات
                                </button>
                            </div>
                        </form>
                    </div>

                </main>
            </div>
        </div>
    </section>

    <!-- ============================================================
    FOOTER
    ============================================================ -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium Logo" class="logo-img" />
                    </a>
                    <p>اولین سالن کار اشتراکی گرافیکی در شهر</p>
                    <div class="footer-social">
                        <a href="#"><i class="fas fa-comment"></i></a>
                        <a href="#"><i class="fas fa-check-circle"></i></a>
                        <a href="#"><i class="fas fa-video"></i></a>
                        <a href="#"><i class="fas fa-share-alt"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>لینک‌های مفید</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">خانه</a></li>
                        <li><a href="{{ route('about') }}">درباره ما</a></li>
                        <li><a href="{{ route('services') }}">خدمات</a></li>
                        <li><a href="{{ route('blog') }}">بلاگ</a></li>
                        <li><a href="{{ route('contact') }}">تماس</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>اطلاعات تماس</h4>
                    <ul>
                        <li><i class="fas fa-map-pin"></i> خیابان اصلی، پلاک ۱۲۳</li>
                        <li><i class="fas fa-phone"></i> ۰۲۱-۱۲۳۴-۵۶۷۸</li>
                        <li><i class="fas fa-envelope"></i> info@grafium.ir</li>
                    </ul>
                </div>
                <div class="footer-trust">
                    <h4>نمادهای اعتماد</h4>
                    <div class="trust-icons"><span>نماد ۱</span><span>نماد ۲</span><span>نماد ۳</span></div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; ۲۰۲۶ تمامی حقوق برای <span class="gold-text">GRAFIUM</span> محفوظ است.</p>
            </div>
        </div>
    </footer>

    <!-- ============================================================
    JAVASCRIPT
    ============================================================ -->
    <script>
        // ============================================================
        // 1. THEME TOGGLE
        // ============================================================
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle?.querySelector('i');
        let darkMode = localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : true;

        function applyTheme() {
            document.documentElement.setAttribute('data-theme', darkMode ? 'dark' : 'light');
            if (themeIcon) themeIcon.className = darkMode ? 'fas fa-moon' : 'fas fa-sun';
            localStorage.setItem('theme', darkMode ? 'dark' : 'light');
        }
        applyTheme();

        themeToggle?.addEventListener('click', () => {
            darkMode = !darkMode;
            applyTheme();
        });

        // ============================================================
        // 2. MOBILE MENU
        // ============================================================
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        menuToggle?.addEventListener('click', () => {
            mobileMenu?.classList.toggle('open');
            const icon = menuToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });

        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu?.classList.remove('open');
                const icon = menuToggle?.querySelector('i');
                if (icon) {
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-times');
                }
            });
        });

        // ============================================================
        // 3. HEADER SHADOW
        // ============================================================
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (!header) return;
            if (window.scrollY > 50) header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.4)';
            else header.style.boxShadow = 'none';
        });

        // ============================================================
        // 4. TAB NAVIGATION
        // ============================================================
        const navLinks = document.querySelectorAll('.dashboard-nav a[data-tab]');
        const tabContents = {
            'dashboard-tab': document.getElementById('dashboard-tab'),
            'reservations-tab': document.getElementById('reservations-tab'),
            'invoices-tab': document.getElementById('invoices-tab'),
            'profile-tab': document.getElementById('profile-tab'),
        };

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Active class on nav
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                // Show tab content
                const tabId = this.dataset.tab;
                Object.keys(tabContents).forEach(key => {
                    tabContents[key].classList.remove('active');
                });
                if (tabContents[tabId]) {
                    tabContents[tabId].classList.add('active');
                }
            });
        });

        // ============================================================
        // 5. RESERVATION FILTER
        // ============================================================
        function filterReservations() {
            const filter = document.getElementById('reservationFilter').value;
            const search = document.getElementById('reservationSearch').value.toLowerCase();
            const rows = document.querySelectorAll('.reservation-row');

            rows.forEach(row => {
                const status = row.dataset.status;
                const searchData = row.dataset.search.toLowerCase();
                let show = true;

                if (filter !== 'all' && status !== filter) {
                    show = false;
                }
                if (search && !searchData.includes(search)) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
            });
        }

        // Event listeners for filter
        document.getElementById('reservationFilter')?.addEventListener('change', filterReservations);
        document.getElementById('reservationSearch')?.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') filterReservations();
        });

        // ============================================================
        // 6. PROFILE FORM
        // ============================================================
        document.getElementById('profileForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('اطلاعات شما با موفقیت به‌روزرسانی شد!');
        });

        // ============================================================
        // 7. INVOICE FILTER
        // ============================================================
        document.getElementById('invoiceFilter')?.addEventListener('change', function() {
            const filter = this.value;
            const rows = document.querySelectorAll('#invoices-tab tbody tr');
            rows.forEach(row => {
                const status = row.querySelector('.badge')?.textContent.trim() || '';
                let show = true;
                if (filter !== 'all') {
                    const statusMap = {
                        'paid': 'پرداخت شده',
                        'pending': 'در انتظار پرداخت',
                        'cancelled': 'لغو شده'
                    };
                    show = status === statusMap[filter];
                }
                row.style.display = show ? '' : 'none';
            });
        });

        console.log('Dashboard page loaded successfully!');
    </script>

</body>
</html>