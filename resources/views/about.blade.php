<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>درباره ما | GRAFIUM</title>

    <!-- CSRF Token (برای فرم‌ها) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />

    <style>
        /* ===== تمام CSS مثل قبل ===== */
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

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font);
            background: var(--bg-body);
            color: var(--text);
            direction: rtl;
            transition: background 0.4s, color 0.4s;
            line-height: 1.7;
            overflow-x: hidden;
        }

        ::selection {
            background: var(--gold);
            color: #fff;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
        ul {
            list-style: none;
        }
        img {
            max-width: 100%;
            display: block;
        }

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

        /* ===== SECTION HEADER ===== */
        .section {
            padding: 25px 0;
        }
        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 50px;
        }
        .section-header h2 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 12px;
        }
        .section-header p {
            color: var(--text-muted);
            font-size: 16px;
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

        /* ===== ABOUT PAGE ===== */
        .about-page {
            padding: 60px 0 40px;
        }
        .about-box {
            border-radius: var(--radius);
            padding: 40px 36px;
            max-width: 900px;
            margin: 0 auto;
            transition: transform 0.4s, box-shadow 0.4s;
            background: var(--bg-card);
            box-shadow: var(--shadow);
        }
        .about-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(10, 22, 40, 0.08);
        }
        .about-box-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .about-box-header h1 {
            font-size: 36px;
            font-weight: 800;
        }
        .about-box-body p {
            color: var(--text-muted);
            font-size: 16px;
            line-height: 1.9;
            margin-bottom: 16px;
            text-align: justify;
        }
        .about-hero-image {
            width: 100%;
            height: 220px;
            overflow: hidden;
            border-radius: var(--radius) var(--radius) 0 0;
            margin-bottom: 20px;
        }
        .about-hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s;
        }
        .about-hero-image img:hover {
            transform: scale(1.02);
        }
        .about-inline-image {
            display: flex;
            gap: 20px;
            align-items: center;
            margin: 24px 0;
            background: var(--bg-body);
            border-radius: var(--radius-sm);
            padding: 16px;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }
        .about-inline-image:hover {
            border-color: var(--gold);
            box-shadow: 0 4px 20px rgba(212, 163, 115, 0.06);
        }
        .about-inline-image img {
            width: 180px;
            height: 140px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            flex-shrink: 0;
        }
        .about-inline-image p {
            margin: 0;
            flex: 1;
            font-size: 15px;
            line-height: 1.9;
            color: var(--text-muted);
        }
        .about-inline-image.left {
            flex-direction: row-reverse;
        }

        /* ===== RELATED LINKS ===== */
        .related-links {
            padding: 40px 0 80px;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .related-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 32px 24px;
            text-align: center;
            border: 1px solid var(--border);
            transition: all 0.4s;
            box-shadow: var(--shadow);
        }
        .related-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 12px 40px rgba(212, 163, 115, 0.08);
        }
        .related-icon {
            font-size: 40px;
            color: var(--gold);
            margin-bottom: 16px;
        }
        .related-card h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .related-card p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* ===== CTA ===== */
        .cta {
            background: var(--navy-gradient);
            color: #fff;
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-top: 2px solid var(--gold);
        }
        .cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 50%, rgba(212, 163, 115, 0.04), transparent 60%);
        }
        .cta .section-title {
            color: #fff;
        }
        .cta .section-subtitle {
            color: rgba(255, 255, 255, 0.35);
            margin: 0 auto 36px;
        }
        .cta .btn-group {
            display: flex;
            gap: 18px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
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

        /* ===== FOOTER ===== */
        .footer {
            background: var(--deep-navy);
            color: #c8c8d4;
            padding: 60px 0 20px;
            margin-top: 40px;
            border-top: 2px solid var(--gold);
        }
        [data-theme="light"] .footer {
            background: var(--deep-navy);
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-align: center;
        }
        .footer-brand .logo {
            justify-content: center;
        }
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
        .footer-contact h4,
        .footer-trust h4 {
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
        .footer-links a:hover {
            color: var(--gold);
        }
        .footer-contact li {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer-contact li i {
            color: var(--gold);
            width: 20px;
        }
        .trust-icons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .trust-icons span {
            background: rgba(255, 255, 255, 0.04);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            color: #94a3b8;
        }
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            font-size: 14px;
            color: #64748b;
        }
        .gold-text {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 22, 40, 0.85);
            backdrop-filter: blur(16px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s;
        }
        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }
        .modal {
            background: var(--bg-card);
            border-radius: 24px;
            padding: 40px 36px;
            max-width: 480px;
            width: 100%;
            border: 2px solid var(--gold);
            box-shadow: 0 0 40px rgba(212, 163, 115, 0.15);
            position: relative;
            transform: scale(0.9) translateY(30px);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
        }
        .modal-close {
            position: absolute;
            top: 14px;
            left: 18px;
            background: none;
            border: none;
            font-size: 22px;
            color: var(--text-muted);
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }
        .modal-close:hover {
            color: var(--gold);
            background: rgba(212, 163, 115, 0.1);
            transform: rotate(90deg);
        }
        .modal-tabs {
            display: flex;
            gap: 6px;
            background: var(--bg-body);
            padding: 4px;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-bottom: 28px;
        }
        .modal-tab {
            flex: 1;
            padding: 10px 16px;
            border: none;
            background: transparent;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.3s;
        }
        .modal-tab.active {
            background: var(--gold-gradient);
            color: #fff;
        }
        .modal-tab:hover:not(.active) {
            color: var(--gold);
        }
        .modal-form.hidden {
            display: none;
        }
        .modal-form .form-group {
            margin-bottom: 18px;
        }
        .modal-form label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .modal-form input {
            width: 100%;
            padding: 13px 18px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--bg-body);
            color: var(--text);
            font-family: var(--font);
            font-size: 14px;
            transition: all 0.4s;
            outline: none;
        }
        .modal-form input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(212, 163, 115, 0.15);
        }
        .modal-form .btn {
            width: 100%;
            background: var(--gold-gradient);
            border-color: var(--gold);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .related-grid {
                grid-template-columns: 1fr 1fr;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-desktop {
                display: none;
            }
            .menu-toggle {
                display: block;
            }
            .about-inline-image {
                flex-direction: column !important;
            }
            .about-inline-image img {
                width: 100%;
                height: 160px;
            }
            .about-hero-image {
                height: 150px;
            }
            .about-box {
                padding: 20px 16px;
            }
            .about-box-header h1 {
                font-size: 28px;
            }
            .related-grid {
                grid-template-columns: 1fr;
            }
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .cta {
                padding: 60px 0;
            }
        }

        @media (max-width: 480px) {
            .about-hero-image {
                height: 120px;
            }
            .about-box {
                padding: 16px 12px;
            }
            .about-box-header h1 {
                font-size: 24px;
            }
            .about-box-body p {
                font-size: 14px;
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
                    <li><a href="{{ route('about') }}" class="active">درباره ما</a></li>
                    <li><a href="{{ route('services') }}">خدمات</a></li>
                    <li><a href="{{ route('blog') }}">بلاگ</a></li>
                    <li><a href="{{ route('contact') }}">تماس</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle"><i class="fas fa-moon"></i></button>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-gold">داشبورد</a>
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
    MODAL (فقط برای لاگین با JS - در Laravel از route استفاده کن)
    ============================================================ -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <button class="modal-close" id="modalClose"><i class="fas fa-times"></i></button>
            <div class="modal-tabs">
                <button class="modal-tab active" data-tab="login">ورود</button>
                <button class="modal-tab" data-tab="register">ثبت‌نام</button>
            </div>
            <form class="modal-form" id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="loginEmail">ایمیل</label>
                    <input type="email" id="loginEmail" name="email" placeholder="ایمیل خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="loginPassword">رمز عبور</label>
                    <input type="password" id="loginPassword" name="password" placeholder="رمز عبور خود را وارد کنید" />
                </div>
                <button type="submit" class="btn btn-gold">ورود</button>
            </form>
            <form class="modal-form hidden" id="registerForm">
                <div class="form-group">
                    <label for="regName">نام و نام خانوادگی</label>
                    <input type="text" id="regName" placeholder="نام خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="regEmail">ایمیل</label>
                    <input type="email" id="regEmail" placeholder="ایمیل خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="regPassword">رمز عبور</label>
                    <input type="password" id="regPassword" placeholder="رمز عبور خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="regPasswordConfirm">تکرار رمز عبور</label>
                    <input type="password" id="regPasswordConfirm" placeholder="رمز عبور را تکرار کنید" />
                </div>
                <button type="submit" class="btn btn-gold">ثبت‌نام</button>
            </form>
        </div>
    </div>

    <!-- ============================================================
    ABOUT PAGE CONTENT
    ============================================================ -->
    <section class="section about-page" id="about">
        <div class="container">
            <div class="about-box">
                <div class="about-hero-image">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&h=400&fit=crop&crop=center" alt="فضای کار اشتراکی گرافیکی" />
                </div>
                <div class="about-box-header">
                    <span class="gradient-badge">درباره ما</span>
                    <h1 class="purple-text">GRAFIUM</h1>
                </div>
                <div class="about-box-body">
                    <p><strong>GRAFIUM</strong> اولین سالن کار اشتراکی گرافیکی در شهر است. فضایی که طراحان، هنرمندان و علاقه‌مندان به گرافیک می‌توانند در آن دور هم جمع شوند، ایده‌های خود را به اشتراک بگذارند و با استفاده از تجهیزات و سیستم‌های قدرتمند، پروژه‌های خود را بدون محدودیت اجرا کنند.</p>

                    <div class="about-inline-image">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=300&fit=crop&crop=center" alt="فضای کاری حرفه‌ای" />
                        <p>ما با فراهم کردن محیطی حرفه‌ای، ارگونومیک و الهام‌بخش، بستری برای رشد و خلاقیت فراهم کرده‌ایم. از میزهای کار استاندارد گرفته تا سیستم‌های i9 و کارت‌های گرافیک RTX، همه چیز برای خلق آثار بی‌نظیر در دسترس شماست.</p>
                    </div>

                    <p>تیم ما متشکل از طراحان، برنامه‌نویسان و مربیان مجرب است که همواره در کنار شما هستند تا بهترین تجربه ممکن را داشته باشید.</p>

                    <p>هدف ما ایجاد یک جامعه‌ی پویا و خلاق است که در آن هنرمندان بتوانند از تجربیات یکدیگر بیاموزند، هم‌افزایی کنند و پروژه‌های بزرگ را با تکیه بر توانایی‌های جمعی به انجام برسانند. در GRAFIUM، شما نه تنها به یک فضای کار دسترسی دارید، بلکه به یک شبکه‌ی حمایتی از طراحان و هنرمندان حرفه‌ای متصل می‌شوید.</p>

                    <div class="about-inline-image left">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400&h=300&fit=crop&crop=center" alt="همکاری و خلاقیت" />
                        <p>ما به‌طور مداوم در حال برگزاری کارگاه‌های تخصصی، دوره‌های آموزشی و رویدادهای شبکه‌سازی هستیم تا اعضای خود را در مسیر رشد حرفه‌ای یاری کنیم. از جلسات نقد و بررسی آثار تا همکاری در پروژه‌های مشترک، همه چیز در GRAFIUM برای پیشرفت شما طراحی شده است.</p>
                    </div>

                    <p>با ما همراه شوید و تجربه‌ای متفاوت از کار و خلاقیت را آغاز کنید. GRAFIUM، جایی که هنر و تکنولوژی در کنار هم قرار می‌گیرند.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    RELATED LINKS
    ============================================================ -->
    <section class="section related-links">
        <div class="container">
            <div class="section-header">
                <span class="gradient-badge">مطالب مرتبط</span>
                <h2 class="purple-text">پیشنهادهای ویژه</h2>
                <p>صفحات مرتبط با ما را مشاهده کنید</p>
            </div>
            <div class="related-grid">
                <div class="related-card">
                    <div class="related-icon"><i class="fas fa-calendar-check"></i></div>
                    <h3>رزرو میز عمومی</h3>
                    <p>فضای کاری باز با میزهای اختصاصی و اینترنت پرسرعت</p>
                    <a href="{{ route('services') }}" class="btn btn-gold-outline">مشاهده</a>
                </div>
                <div class="related-card">
                    <div class="related-icon"><i class="fas fa-headset"></i></div>
                    <h3>تماس با ما</h3>
                    <p>پشتیبانی ۲۴/۷، مشاوره رایگان و پاسخ به سوالات شما</p>
                    <a href="{{ route('contact') }}" class="btn btn-gold-outline">مشاهده</a>
                </div>
                <div class="related-card">
                    <div class="related-icon"><i class="fas fa-newspaper"></i></div>
                    <h3>بلاگ و اخبار</h3>
                    <p>آخرین مقالات، آموزش‌ها و رویدادهای گرافیکی دنیا</p>
                    <a href="{{ route('blog') }}" class="btn btn-gold-outline">مشاهده</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    CTA
    ============================================================ -->
    <section class="cta" id="cta">
        <div class="container">
            <span class="gradient-badge" style="background:rgba(212,163,115,0.12);color:var(--gold);">شروع کنید</span>
            <h2 class="section-title">فضای کاری <span style="color:var(--gold);">خود را امروز رزرو کنید</span></h2>
            <p class="section-subtitle" style="color:rgba(255,255,255,0.35);max-width:600px;margin:0 auto 36px;">به جامعه طراحان حرفه‌ای بپیوندید و از امکانات ممتاز گرافیوم لذت ببرید.</p>
            <div class="btn-group">
                <a href="{{ route('services') }}" class="btn btn-gold">رزرو میز <i class="fas fa-arrow-left"></i></a>
                <a href="{{ route('contact') }}" class="btn btn-white">تماس با ما</a>
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
        // 3. MODAL
        // ============================================================
        const modalOverlay = document.getElementById('modalOverlay');
        const modalClose = document.getElementById('modalClose');
        const openModalBtns = document.querySelectorAll('#openModalBtn, #openModalBtnMobile');
        const modalTabs = document.querySelectorAll('.modal-tab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        function openModal(tab = 'login') {
            modalOverlay?.classList.add('active');
            document.body.style.overflow = 'hidden';
            switchTab(tab);
        }

        function closeModal() {
            modalOverlay?.classList.remove('active');
            document.body.style.overflow = '';
        }

        function switchTab(tab) {
            modalTabs.forEach(t => t.classList.remove('active'));
            document.querySelector(`.modal-tab[data-tab="${tab}"]`)?.classList.add('active');
            loginForm?.classList.toggle('hidden', tab !== 'login');
            registerForm?.classList.toggle('hidden', tab !== 'register');
        }

        openModalBtns.forEach(btn => btn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal('login');
        }));

        modalClose?.addEventListener('click', closeModal);
        modalOverlay?.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });

        modalTabs.forEach(tab => tab.addEventListener('click', () => switchTab(tab.dataset.tab)));

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        // ============================================================
        // 4. SMOOTH SCROLL
        // ============================================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ============================================================
        // 5. HEADER SHADOW
        // ============================================================
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (!header) return;
            if (window.scrollY > 50) header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.4)';
            else header.style.boxShadow = 'none';
        });

        console.log('✅ About page loaded successfully!');
    </script>

</body>
</html>