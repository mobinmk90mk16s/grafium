<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>فاکتور رزرو | GRAFIUM</title>

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

        /* ===== SECTION ===== */
        .section { padding: 25px 0; }
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

        /* ============================================================
           INVOICE PAGE
           ============================================================ */
        .invoice-page {
            padding: 60px 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: 0 auto;
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 40px;
            border: 2px solid var(--gold);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .invoice-box:hover {
            box-shadow: 0 8px 50px rgba(212, 163, 115, 0.15);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 16px;
        }
        .invoice-header h2 {
            font-size: 28px;
            font-weight: 800;
        }

        .invoice-content {
            font-size: 14px;
        }

        .invoice-user {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            padding: 16px 0;
            border-bottom: 2px solid var(--gold);
            margin-bottom: 16px;
        }
        .invoice-user p {
            font-size: 15px;
            color: var(--text-muted);
        }
        .invoice-user p strong {
            color: var(--text);
        }

        .invoice-content .summary-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 20px 0;
        }

        .invoice-content .invoice-days {
            list-style: none;
            padding: 0;
            margin: 12px 0;
        }
        .invoice-content .invoice-days li {
            padding: 8px 12px;
            border-bottom: 1px dashed var(--border);
            color: var(--text-muted);
            font-size: 14px;
            transition: all 0.2s;
        }
        .invoice-content .invoice-days li:hover {
            background: rgba(212, 163, 115, 0.05);
            border-color: var(--gold);
        }

        .invoice-content .invoice-summary {
            margin-top: 16px;
        }
        .invoice-content .invoice-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: 15px;
        }
        .invoice-content .invoice-row span {
            color: var(--text-muted);
        }
        .invoice-content .invoice-row strong {
            color: var(--text);
            font-weight: 700;
        }
        .invoice-content .invoice-row.total {
            border-bottom: none;
            font-size: 20px;
            font-weight: 800;
            padding-top: 16px;
            margin-top: 4px;
        }
        .invoice-content .invoice-row.total span {
            color: var(--gold);
        }
        .invoice-content .invoice-row.total strong {
            color: var(--gold);
            font-size: 22px;
        }

        .invoice-content .btn-gold {
            width: 100%;
            margin-top: 24px;
            padding: 14px 0;
            font-weight: 700;
            font-size: 16px;
        }

        .invoice-not-found {
            text-align: center;
            padding: 60px 20px;
        }
        .invoice-not-found i {
            font-size: 48px;
            color: var(--gold);
            margin-bottom: 16px;
        }
        .invoice-not-found p {
            color: var(--text-muted);
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* ===== CTA ===== */
        .cta {
            background: var(--navy-gradient);
            color: #fff;
            padding: 80px 0;
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

        /* ===== FOOTER ===== */
        .footer {
            background: var(--deep-navy);
            color: #c8c8d4;
            padding: 60px 0 20px;
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .invoice-box { padding: 24px 16px; }
            .invoice-header { flex-direction: column; text-align: center; }
            .invoice-header h2 { font-size: 22px; }
            .invoice-user { flex-direction: column; gap: 8px; text-align: center; }
            .invoice-content .invoice-row { font-size: 13px; }
            .invoice-content .invoice-row.total { font-size: 17px; }
            .invoice-content .invoice-row.total strong { font-size: 18px; }
            .footer-grid { grid-template-columns: 1fr; }
            .cta { padding: 60px 0; }
        }

        @media (max-width: 480px) {
            .invoice-box { padding: 16px 12px; }
            .invoice-header h2 { font-size: 18px; }
            .invoice-content .invoice-days li { font-size: 12px; padding: 6px 8px; }
            .invoice-content .invoice-row { font-size: 12px; padding: 6px 0; }
            .invoice-content .invoice-row.total { font-size: 15px; }
            .invoice-content .invoice-row.total strong { font-size: 16px; }
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
                    <li><a href="{{ route('services') }}" class="active">خدمات</a></li>
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
    INVOICE PAGE
    ============================================================ -->
    <section class="section invoice-page">
        <div class="container">
            <div class="invoice-box">
                <div class="invoice-header">
                    <h2 class="purple-text"><i class="fas fa-file-invoice"></i> فاکتور رزرو</h2>
                    <a href="{{ route('services') }}" class="btn btn-gold-outline">
                        <i class="fas fa-arrow-right"></i> بازگشت به خدمات
                    </a>
                </div>
                <div id="invoiceContent" class="invoice-content">
                    <!-- محتوا توسط جاوااسکریپت ساخته می‌شود -->
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
        // 3. HEADER SHADOW
        // ============================================================
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (!header) return;
            if (window.scrollY > 50) header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.4)';
            else header.style.boxShadow = 'none';
        });

        // ============================================================
        // 4. INVOICE SYSTEM
        // ============================================================
        (function() {
            const container = document.getElementById('invoiceContent');

            // دریافت دیتا از localStorage
            let data = null;
            try {
                const raw = localStorage.getItem('invoiceData');
                if (raw) {
                    data = JSON.parse(raw);
                }
            } catch (e) {
                console.error('Error parsing invoice data:', e);
            }

            if (!data) {
                container.innerHTML = `
                    <div class="invoice-not-found">
                        <i class="fas fa-file-invoice"></i>
                        <p>اطلاعاتی برای نمایش وجود ندارد.</p>
                        <p style="font-size:14px;color:var(--text-muted);">لطفاً ابتدا از صفحه خدمات یک رزرو انجام دهید.</p>
                        <a href="{{ route('services') }}" class="btn btn-gold" style="margin-top:12px;">
                            <i class="fas fa-arrow-right"></i> بازگشت به خدمات
                        </a>
                    </div>
                `;
                return;
            }

            const { desk, cells, dates, user } = data;

            // گروه‌بندی بر اساس روز
            const dayMap = new Map();
            cells.forEach(cell => {
                if (!dayMap.has(cell.dayIndex)) dayMap.set(cell.dayIndex, []);
                dayMap.get(cell.dayIndex).push(cell.shiftIndex);
            });

            const sortedDays = Array.from(dayMap.keys()).sort((a, b) => a - b);

            // ساخت لیست آیتم‌ها
            let itemsHtml = '';
            sortedDays.forEach(dayIndex => {
                const shifts = dayMap.get(dayIndex).sort();
                const dayLabel = dates[dayIndex]?.label || `روز ${dayIndex + 1}`;
                if (shifts.length === 2) {
                    itemsHtml += `<li>${dayLabel} – <strong>روز کامل</strong> (شیفت ۱ و شیفت ۲)</li>`;
                } else if (shifts.length === 1) {
                    const shiftLabel = shifts[0] === 0 ? 'شیفت ۱ (۸-۱۴)' : 'شیفت ۲ (۱۵-۲۱)';
                    itemsHtml += `<li>${dayLabel} – <strong>${shiftLabel}</strong></li>`;
                } else {
                    itemsHtml += `<li>${dayLabel} – ${shifts.length} سلول انتخاب شده</li>`;
                }
            });

            const count = cells.length;
            const unitPrice = 500000;
            const subtotal = count * unitPrice;
            const discount = 0;
            const taxRate = 0.09;
            const tax = Math.round(subtotal * taxRate);
            const totalPayable = subtotal - discount + tax;

            let plan = 'شیفتی';
            if (count > 30) plan = 'ماهانه';
            else if (count > 6) plan = 'هفتگی';

            // تاریخ امروز
            const today = new Date();
            const persianDate = today.toLocaleDateString('fa-IR');

            const html = `
                <div class="invoice-user">
                    <p><strong><i class="fas fa-user"></i> نام کاربر:</strong> ${user?.name || 'کاربر مهمان'}</p>
                    <p><strong><i class="fas fa-chair"></i> میز شماره:</strong> ${desk}</p>
                    <p><strong><i class="fas fa-calendar-day"></i> تاریخ فاکتور:</strong> ${persianDate}</p>
                    <p><strong><i class="fas fa-hashtag"></i> شماره فاکتور:</strong> INV-${String(Date.now()).slice(-6)}</p>
                </div>

                <hr class="summary-divider" />

                <h4 style="font-size:16px;font-weight:700;margin-bottom:8px;"><i class="fas fa-list"></i> فهرست انتخاب‌ها (${count} سلول)</h4>
                <ul class="invoice-days">${itemsHtml || '<li>هیچ سلولی انتخاب نشده است</li>'}</ul>

                <hr class="summary-divider" />

                <div class="invoice-summary">
                    <div class="invoice-row">
                        <span>تعداد سلول:</span>
                        <strong>${count}</strong>
                    </div>
                    <div class="invoice-row">
                        <span>تعرفه:</span>
                        <strong>${plan}</strong>
                    </div>
                    <div class="invoice-row">
                        <span>قیمت واحد:</span>
                        <strong>${unitPrice.toLocaleString()} تومان</strong>
                    </div>
                    <div class="invoice-row">
                        <span>جمع جزء:</span>
                        <strong>${subtotal.toLocaleString()} تومان</strong>
                    </div>
                    <div class="invoice-row">
                        <span>تخفیف:</span>
                        <strong>${discount.toLocaleString()} تومان</strong>
                    </div>
                    <div class="invoice-row">
                        <span>مالیات (۹٪):</span>
                        <strong>${tax.toLocaleString()} تومان</strong>
                    </div>
                    <div class="invoice-row total">
                        <span><i class="fas fa-credit-card"></i> مبلغ قابل پرداخت:</span>
                        <strong>${totalPayable.toLocaleString()} تومان</strong>
                    </div>
                </div>

                <button class="btn btn-gold" id="finalPayBtn">
                    <i class="fas fa-credit-card"></i> اتصال به درگاه پرداخت
                </button>

                <p style="text-align:center;font-size:12px;color:var(--text-muted);margin-top:12px;">
                    <i class="fas fa-info-circle"></i> پس از پرداخت، رزرو شما تایید خواهد شد.
                </p>
            `;

            container.innerHTML = html;

            // دکمه پرداخت
            document.getElementById('finalPayBtn')?.addEventListener('click', function() {
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال اتصال به درگاه...';
                btn.disabled = true;

                setTimeout(() => {
                    alert('درگاه پرداخت به‌زودی فعال می‌شود.\nمبلغ قابل پرداخت: ' +
                        totalPayable.toLocaleString() + ' تومان');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 1500);
            });

        })();

        console.log('Invoice page loaded successfully!');
    </script>

</body>
</html>