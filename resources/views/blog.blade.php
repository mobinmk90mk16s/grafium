<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>بلاگ و اخبار | GRAFIUM</title>

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
           BLOG PAGE
           ============================================================ */
        .blog-page {
            padding: 60px 0;
        }

        .blog-search-wrapper {
            position: relative;
            max-width: 500px;
            margin: 0 auto 50px;
        }

        .blog-search-input {
            width: 100%;
            padding: 14px 50px 14px 18px;
            border: 2px solid var(--border);
            border-radius: 40px;
            background: var(--bg-card);
            color: var(--text);
            font-family: var(--font);
            font-size: 15px;
            outline: none;
            transition: all 0.4s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .blog-search-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(212, 163, 115, 0.15), 0 8px 30px rgba(212, 163, 115, 0.05);
        }

        .blog-search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--gold-gradient);
            color: #fff;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s;
        }

        .blog-search-btn:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.35);
        }

        .blog-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 30px;
        }

        .blog-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            box-shadow: var(--shadow);
        }

        .blog-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 12px 40px rgba(212, 163, 115, 0.12);
        }

        .blog-image {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .blog-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 4px 14px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 700;
            background: var(--gold-gradient);
            color: #fff;
        }

        .blog-content {
            padding: 20px;
            text-align: center;
        }

        .blog-content h3 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text);
            line-height: 1.5;
        }

        .blog-content p {
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 12px;
            line-height: 1.7;
        }

        .blog-meta {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .blog-meta i {
            color: var(--gold);
            margin-left: 4px;
        }

        .gold-link {
            color: var(--gold);
            font-weight: 600;
            font-size: 13px;
            transition: color 0.3s;
            text-decoration: none;
        }

        .gold-link:hover {
            color: var(--gold-dark);
            text-decoration: underline;
        }

        .highlight {
            background: var(--gold);
            color: #fff;
            padding: 0 3px;
            border-radius: 4px;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
            font-size: 16px;
            grid-column: 1 / -1;
        }

        .no-results i {
            font-size: 40px;
            color: var(--gold);
            margin-bottom: 15px;
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
        @media (max-width: 992px) {
            .blog-grid-4 {
                grid-template-columns: repeat(2, 1fr);
                gap: 18px;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .blog-grid-4 {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .blog-search-wrapper {
                max-width: 100%;
            }
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .cta { padding: 60px 0; }
        }

        @media (max-width: 480px) {
            .blog-image {
                height: 140px;
            }
            .blog-content {
                padding: 14px;
            }
            .blog-content h3 {
                font-size: 15px;
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
                    <li><a href="{{ route('blog') }}" class="active">بلاگ</a></li>
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
    BLOG PAGE
    ============================================================ -->
    <section class="section blog-page">
        <div class="container">
            <div class="section-header">
                <span class="gradient-badge"><i class="fas fa-newspaper"></i> اخبار و مقالات</span>
                <h2 class="purple-text">آخرین مطالب GRAFIUM</h2>
                <p>جدیدترین مقالات آموزشی، اخبار و رویدادهای دنیای گرافیک را دنبال کنید</p>
            </div>

            <!-- باکس جستجو -->
            <div class="blog-search-wrapper">
                <input type="text" id="blogSearchInput" class="blog-search-input" placeholder="جستجو در مقالات... (مثلاً: فتوشاپ)" />
                <button class="blog-search-btn" id="blogSearchBtn" aria-label="جستجو">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- گرید مقالات -->
            <div id="blogGrid" class="blog-grid-4"></div>
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
        // 4. BLOG SYSTEM
        // ============================================================
        (function() {
            // ===== مقالات (دیتابیس فیک) =====
            const articles = [
                {
                    id: 1,
                    title: "آموزش جامع فتوشاپ از صفر تا صد",
                    excerpt: "در این مقاله تمام ابزارهای فتوشاپ را قدم‌به‌قدم یاد می‌گیرید.",
                    content: "فتوشاپ نرم‌افزاری قدرتمند برای ویرایش تصاویر است.",
                    image: "https://images.unsplash.com/photo-1561070791-2526d30994b5?w=600&h=400&fit=crop",
                    badge: "آموزش",
                    date: "۱۴۰۵/۰۵/۱۸",
                    tags: ["فتوشاپ", "آموزش", "طراحی"]
                },
                {
                    id: 2,
                    title: "روتوش حرفه‌ای پرتره در فتوشاپ",
                    excerpt: "یاد بگیرید چگونه پوست صورت را نرم کنید و رنگ‌ها را متعادل کنید.",
                    content: "روتوش پرتره یکی از مهم‌ترین مهارت‌های فتوشاپ است.",
                    image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&h=400&fit=crop",
                    badge: "فتوشاپ",
                    date: "۱۴۰۵/۰۵/۱۷",
                    tags: ["فتوشاپ", "روتوش", "پرتره"]
                },
                {
                    id: 3,
                    title: "نکات طلایی طراحی لوگو",
                    excerpt: "طراحی لوگو از ایده تا اجرا. نکات کاربردی برای طراحی لوگوی ماندگار.",
                    content: "طراحی لوگو یک فرآیند خلاقانه است.",
                    image: "https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=400&fit=crop",
                    badge: "طراحی",
                    date: "۱۴۰۵/۰۵/۱۶",
                    tags: ["لوگو", "طراحی", "گرافیک"]
                },
                {
                    id: 4,
                    title: "ایلوستریتور برای طراحان گرافیک",
                    excerpt: "هر آنچه برای شروع کار با ایلوستریتور نیاز دارید.",
                    content: "ایلوستریتور نرم‌افزار استاندارد طراحی وکتور است.",
                    image: "https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop",
                    badge: "آموزش",
                    date: "۱۴۰۵/۰۵/۱۵",
                    tags: ["ایلوستریتور", "طراحی", "وکتور"]
                },
                {
                    id: 5,
                    title: "موشن گرافیک با افترافکت",
                    excerpt: "با افترافکت به طرح‌های خود جان بدهید.",
                    content: "موشن گرافیک ترکیبی از طراحی گرافیک و انیمیشن است.",
                    image: "https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=600&h=400&fit=crop",
                    badge: "ویدیو",
                    date: "۱۴۰۵/۰۵/۱۴",
                    tags: ["موشن گرافیک", "افترافکت", "انیمیشن"]
                },
                {
                    id: 6,
                    title: "عکاسی پرتره در استودیو GRAFIUM",
                    excerpt: "با تجهیزات حرفه‌ای استودیو GRAFIUM عکاسی کنید.",
                    content: "استودیو GRAFIUM مجهز به نورپردازی حرفه‌ای است.",
                    image: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600&h=400&fit=crop",
                    badge: "عکاسی",
                    date: "۱۴۰۵/۰۵/۱۳",
                    tags: ["عکاسی", "استودیو", "پرتره"]
                },
                {
                    id: 7,
                    title: "بهترین سیستم‌های گرافیکی برای طراحان",
                    excerpt: "راهنمای انتخاب سیستم مناسب برای کارهای گرافیکی سنگین.",
                    content: "انتخاب سیستم مناسب برای کار گرافیکی اهمیت زیادی دارد.",
                    image: "https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop",
                    badge: "سخت‌افزار",
                    date: "۱۴۰۵/۰۵/۱۲",
                    tags: ["سیستم", "سخت‌افزار", "گرافیک"]
                },
                {
                    id: 8,
                    title: "راهنمای رزرو میز در GRAFIUM",
                    excerpt: "چگونه میز یا سیستم مورد نظر خود را به‌صورت آنلاین رزرو کنید.",
                    content: "رزرو میز در GRAFIUM بسیار ساده است.",
                    image: "https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=400&fit=crop",
                    badge: "راهنما",
                    date: "۱۴۰۵/۰۵/۱۱",
                    tags: ["رزرو", "میز", "خدمات"]
                },
                {
                    id: 9,
                    title: "۱۰ ترفند افزایش سرعت اینترنت",
                    excerpt: "با این ترفندها سرعت اینترنت خود را به حداکثر برسانید.",
                    content: "اینترنت پرسرعت برای طراحان گرافیک حیاتی است.",
                    image: "https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=600&h=400&fit=crop",
                    badge: "ترفند",
                    date: "۱۴۰۵/۰۵/۱۰",
                    tags: ["اینترنت", "سرعت", "ترفند"]
                },
                {
                    id: 10,
                    title: "کارگاه‌های آموزشی GRAFIUM",
                    excerpt: "از کارگاه‌های تخصصی فتوشاپ و موشن گرافیک دیدن کنید.",
                    content: "GRAFIUM به‌طور منظم کارگاه‌های آموزشی برگزار می‌کند.",
                    image: "https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=400&fit=crop",
                    badge: "رویداد",
                    date: "۱۴۰۵/۰۵/۰۹",
                    tags: ["کارگاه", "آموزش", "رویداد"]
                },
                {
                    id: 11,
                    title: "چاپ و صحافی در GRAFIUM",
                    excerpt: "خدمات چاپ با کیفیت بالا و صحافی حرفه‌ای.",
                    content: "در GRAFIUM خدمات چاپ دیجیتال ارائه می‌شود.",
                    image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&h=400&fit=crop",
                    badge: "چاپ",
                    date: "۱۴۰۵/۰۵/۰۸",
                    tags: ["چاپ", "صحافی", "خدمات"]
                },
                {
                    id: 12,
                    title: "ساخت نمونه کار حرفه‌ای برای طراحان",
                    excerpt: "نمونه کار قوی اولین قدم برای جذب مشتری است.",
                    content: "یک نمونه کار حرفه‌ای باید پروژه‌های شما را نمایش دهد.",
                    image: "https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=400&fit=crop",
                    badge: "طراحی",
                    date: "۱۴۰۵/۰۵/۰۷",
                    tags: ["نمونه کار", "پورتفولیو", "طراحی"]
                },
            ];

            // ===== عناصر =====
            const grid = document.getElementById('blogGrid');
            const searchInput = document.getElementById('blogSearchInput');
            const searchBtn = document.getElementById('blogSearchBtn');

            // ===== توابع کمکی =====
            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) { return map[m]; });
            }

            function highlight(text, query) {
                if (!query.trim()) return escapeHtml(text);
                const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                return escapeHtml(text).replace(
                    new RegExp(escapedQuery, 'gi'),
                    match => `<mark class="highlight">${match}</mark>`
                );
            }

            function countOccurrences(text, query) {
                if (!query.trim()) return 0;
                const normalized = text.toLowerCase();
                const q = query.toLowerCase();
                let count = 0;
                let index = normalized.indexOf(q);
                while (index !== -1) {
                    count++;
                    index = normalized.indexOf(q, index + q.length);
                }
                return count;
            }

            function scoreArticle(article, query) {
                if (!query.trim()) return 0;
                const terms = query.toLowerCase().split(/\s+/).filter(Boolean);
                let score = 0;
                terms.forEach(term => {
                    score += countOccurrences(article.title, term) * 10;
                    score += countOccurrences(article.excerpt, term) * 5;
                    score += countOccurrences(article.content, term) * 2;
                    article.tags.forEach(tag => {
                        score += countOccurrences(tag, term) * 8;
                    });
                });
                return score;
            }

            function filterAndSortArticles(query) {
                if (!query.trim()) return articles.slice();
                return articles
                    .map(article => ({ article, score: scoreArticle(article, query) }))
                    .filter(item => item.score > 0)
                    .sort((a, b) => b.score - a.score)
                    .map(item => item.article);
            }

            function renderArticles(list) {
                if (list.length === 0) {
                    grid.innerHTML = `
                        <div class="no-results">
                            <i class="fas fa-search-minus"></i>
                            <p>مقاله‌ای مطابق جستجوی شما پیدا نشد.</p>
                        </div>
                    `;
                    return;
                }

                grid.innerHTML = list.map(article => {
                    // استفاده از url() به جای route() برای جلوگیری از خطا
                    const postUrl = "{{ url('/blog') }}/" + article.id;
                    
                    return `
                        <article class="blog-card" data-id="${article.id}">
                            <div class="blog-image" style="background-image: url('${article.image}');">
                                <span class="blog-badge">${article.badge}</span>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="fas fa-calendar-alt"></i> ${article.date}</span>
                                    <span><i class="fas fa-tag"></i> ${article.tags[0]}</span>
                                </div>
                                <h3>${highlight(article.title, searchInput.value)}</h3>
                                <p>${highlight(article.excerpt, searchInput.value)}</p>
                                <a href="${postUrl}" class="gold-link">
                                    ادامه مطلب <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </article>
                    `;
                }).join('');
            }

            function handleSearch() {
                const query = searchInput.value.trim();
                const filtered = filterAndSortArticles(query);
                renderArticles(filtered);
            }

            // رویدادها
            searchBtn.addEventListener('click', handleSearch);
            searchInput.addEventListener('input', handleSearch);
            searchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    handleSearch();
                }
            });

            // نمایش اولیه
            renderArticles(articles);

            // کلیک روی کارت برای رفتن به مقاله
            document.addEventListener('click', function(e) {
                const card = e.target.closest('.blog-card');
                if (card && !e.target.closest('a')) {
                    const id = card.dataset.id;
                    window.location.href = "{{ url('/blog') }}/" + id;
                }
            });

        })();

        console.log('Blog page loaded successfully!');
    </script>

</body>
</html>