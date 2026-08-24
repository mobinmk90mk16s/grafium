<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>مقاله | GRAFIUM</title>

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
           ARTICLE PAGE
           ============================================================ */
        .article-page {
            padding: 60px 0;
        }

        .article-container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .article-container:hover {
            box-shadow: 0 8px 50px rgba(212, 163, 115, 0.1);
        }

        .article-hero {
            height: 300px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .article-hero .article-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: var(--gold-gradient);
            color: #fff;
            padding: 6px 18px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 700;
            z-index: 1;
        }

        .article-body {
            padding: 30px 35px;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 20px;
        }

        .article-meta i {
            color: var(--gold);
            margin-left: 5px;
        }

        .article-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .article-excerpt {
            font-size: 17px;
            color: var(--text-muted);
            line-height: 1.9;
            margin-bottom: 24px;
            border-right: 3px solid var(--gold);
            padding-right: 15px;
        }

        .article-content {
            font-size: 16px;
            line-height: 2;
            color: var(--text);
            text-align: justify;
            margin-bottom: 24px;
        }

        .article-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }

        .article-tag {
            background: var(--bg-body);
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 13px;
            transition: all 0.3s;
        }

        .article-tag:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--gold);
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--gold-dark);
        }

        .article-not-found {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .article-not-found i {
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
        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .article-hero { height: 200px; }
            .article-body { padding: 20px; }
            .article-title { font-size: 22px; }
            .footer-grid { grid-template-columns: 1fr; }
            .cta { padding: 60px 0; }
        }

        @media (max-width: 480px) {
            .article-hero { height: 160px; }
            .article-body { padding: 16px; }
            .article-title { font-size: 18px; }
            .article-excerpt { font-size: 14px; }
            .article-content { font-size: 14px; }
            .article-meta { font-size: 11px; gap: 8px; }
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
    ARTICLE PAGE
    ============================================================ -->
    <section class="section article-page">
        <div class="container">
            <div id="articleContainer">
                <!-- محتوا توسط جاوااسکریپت ساخته می‌شود -->
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
        // 4. ARTICLE SYSTEM
        // ============================================================
        (function() {
            // ===== مقالات (دیتابیس فیک) =====
            const articles = [
                {
                    id: 1,
                    title: "آموزش جامع فتوشاپ از صفر تا صد",
                    excerpt: "در این مقاله تمام ابزارهای فتوشاپ را قدم‌به‌قدم یاد می‌گیرید.",
                    content: "فتوشاپ نرم‌افزاری قدرتمند برای ویرایش تصاویر است. در این آموزش فتوشاپ، ابتدا با محیط کار فتوشاپ آشنا می‌شوید، سپس لایه‌ها، ماسک‌ها، فیلترها و تنظیمات رنگ را فرا می‌گیرید. فتوشاپ برای طراحان گرافیک، عکاسان و هنرمندان دیجیتال ضروری است. اگر می‌خواهید فتوشاپ را به‌صورت حرفه‌ای یاد بگیرید، این مقاله بهترین نقطه شروع است.",
                    image: "https://images.unsplash.com/photo-1561070791-2526d30994b5?w=600&h=400&fit=crop",
                    badge: "آموزش",
                    date: "۱۴۰۵/۰۵/۱۸",
                    tags: ["فتوشاپ", "آموزش", "طراحی", "گرافیک"]
                },
                {
                    id: 2,
                    title: "روتوش حرفه‌ای پرتره در فتوشاپ",
                    excerpt: "یاد بگیرید چگونه پوست صورت را نرم کنید، رنگ‌ها را متعادل کنید و جزئیات را حفظ کنید.",
                    content: "روتوش پرتره یکی از مهم‌ترین مهارت‌های فتوشاپ است. در این مقاله با ابزارهای فتوشاپ مانند Healing Brush، Clone Stamp و Frequency Separation آشنا می‌شوید. روتوش حرفه‌ای فتوشاپ یعنی حذف لک‌ها بدون از بین بردن بافت طبیعی پوست.",
                    image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&h=400&fit=crop",
                    badge: "فتوشاپ",
                    date: "۱۴۰۵/۰۵/۱۷",
                    tags: ["فتوشاپ", "روتوش", "پرتره", "آموزش"]
                },
                {
                    id: 3,
                    title: "نکات طلایی طراحی لوگو",
                    excerpt: "طراحی لوگو از ایده تا اجرا. نکات کاربردی برای طراحی لوگوی ماندگار و حرفه‌ای.",
                    content: "طراحی لوگو یک فرآیند خلاقانه است. یک لوگوی خوب باید ساده، منحصربه‌فرد و به‌یادماندنی باشد. در این مقاله طراحی لوگو را از تحقیقات اولیه شروع می‌کنیم و با اصول انتخاب رنگ، تایپوگرافی و فرم لوگو ادامه می‌دهیم.",
                    image: "https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=400&fit=crop",
                    badge: "طراحی",
                    date: "۱۴۰۵/۰۵/۱۶",
                    tags: ["لوگو", "طراحی", "گرافیک", "برند"]
                },
                {
                    id: 4,
                    title: "ایلوستریتور برای طراحان گرافیک",
                    excerpt: "هر آنچه برای شروع کار با ایلوستریتور نیاز دارید. از ابزارهای پایه تا طراحی وکتور حرفه‌ای.",
                    content: "ایلوستریتور نرم‌افزار استاندارد طراحی وکتور است. در این مقاله با محیط کار ایلوستریتور، ابزار Pen، شکل‌ها و رنگ‌ها آشنا می‌شوید. ایلوستریتور برای طراحی لوگو، آیکون و تصویرسازی استفاده می‌شود.",
                    image: "https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop",
                    badge: "آموزش",
                    date: "۱۴۰۵/۰۵/۱۵",
                    tags: ["ایلوستریتور", "طراحی", "وکتور", "گرافیک"]
                },
                {
                    id: 5,
                    title: "موشن گرافیک با افترافکت",
                    excerpt: "با افترافکت به طرح‌های خود جان بدهید. آموزش ساخت انیمیشن‌های حرفه‌ای موشن گرافیک.",
                    content: "موشن گرافیک ترکیبی از طراحی گرافیک و انیمیشن است. افترافکت نرم‌افزار اصلی موشن گرافیک است. در این مقاله با کی‌فریم‌ها، افکت‌ها و خروجی گرفتن از افترافکت آشنا می‌شوید.",
                    image: "https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=600&h=400&fit=crop",
                    badge: "ویدیو",
                    date: "۱۴۰۵/۰۵/۱۴",
                    tags: ["موشن گرافیک", "افترافکت", "انیمیشن", "ویدیو"]
                },
                {
                    id: 6,
                    title: "عکاسی پرتره در استودیو GRAFIUM",
                    excerpt: "با تجهیزات حرفه‌ای استودیو GRAFIUM، عکاسی پرتره را به سطح جدیدی ببرید.",
                    content: "استودیو GRAFIUM مجهز به نورپردازی حرفه‌ای و پس‌زمینه‌های متنوع است. عکاسی پرتره نیازمند شناخت نور، لنز و ژست‌دهی است. در این مقاله با اصول عکاسی پرتره در استودیو آشنا می‌شوید.",
                    image: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600&h=400&fit=crop",
                    badge: "عکاسی",
                    date: "۱۴۰۵/۰۵/۱۳",
                    tags: ["عکاسی", "استودیو", "پرتره", "نورپردازی"]
                },
                {
                    id: 7,
                    title: "بهترین سیستم‌های گرافیکی برای طراحان",
                    excerpt: "راهنمای انتخاب سیستم مناسب برای کارهای گرافیکی سنگین. از پردازنده تا کارت گرافیک.",
                    content: "انتخاب سیستم مناسب برای کار گرافیکی اهمیت زیادی دارد. پردازنده‌های i9 و کارت‌های گرافیک RTX از محبوب‌ترین انتخاب‌ها هستند. در این مقاله نکات مهم انتخاب سیستم گرافیکی را بررسی می‌کنیم.",
                    image: "https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop",
                    badge: "سخت‌افزار",
                    date: "۱۴۰۵/۰۵/۱۲",
                    tags: ["سیستم", "سخت‌افزار", "گرافیک", "طراحی"]
                },
                {
                    id: 8,
                    title: "راهنمای رزرو میز در GRAFIUM",
                    excerpt: "چگونه میز یا سیستم مورد نظر خود را به‌صورت آنلاین رزرو کنید. راهنمای گام‌به‌گام.",
                    content: "رزرو میز در GRAFIUM بسیار ساده است. وارد صفحه خدمات شوید، میز مورد نظر را انتخاب کنید، روز و شیفت دلخواه را بزنید و پرداخت کنید. با این راهنما تمام مراحل رزرو میز را یاد می‌گیرید.",
                    image: "https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=400&fit=crop",
                    badge: "راهنما",
                    date: "۱۴۰۵/۰۵/۱۱",
                    tags: ["رزرو", "میز", "خدمات", "راهنما"]
                },
                {
                    id: 9,
                    title: "۱۰ ترفند افزایش سرعت اینترنت و دانلود",
                    excerpt: "با این ترفندها سرعت اینترنت خود را در GRAFIUM به حداکثر برسانید و بدون قطعی کار کنید.",
                    content: "اینترنت پرسرعت و پایدار برای طراحان گرافیک حیاتی است. در GRAFIUM زیرساخت اینترنت فیبر نوری فراهم شده است. در این مقاله ۱۰ ترفند ساده برای بهینه‌سازی سرعت اینترنت و دانلود فایل‌های سنگین را یاد می‌گیرید.",
                    image: "https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=600&h=400&fit=crop",
                    badge: "ترفند",
                    date: "۱۴۰۵/۰۵/۱۰",
                    tags: ["اینترنت", "سرعت", "ترفند", "دانلود"]
                },
                {
                    id: 10,
                    title: "کارگاه‌های آموزشی GRAFIUM",
                    excerpt: "از کارگاه‌های تخصصی فتوشاپ، ایلوستریتور و موشن گرافیک دیدن کنید.",
                    content: "GRAFIUM به‌طور منظم کارگاه‌های آموزشی برگزار می‌کند. در این کارگاه‌ها به‌صورت حضوری و آنلاین فتوشاپ، ایلوستریتور، افترافکت و عکاسی آموزش داده می‌شود.",
                    image: "https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=400&fit=crop",
                    badge: "رویداد",
                    date: "۱۴۰۵/۰۵/۰۹",
                    tags: ["کارگاه", "آموزش", "رویداد", "گرافیک"]
                },
                {
                    id: 11,
                    title: "چاپ و صحافی در GRAFIUM",
                    excerpt: "خدمات چاپ با کیفیت بالا، صحافی حرفه‌ای و تحویل سریع برای پروژه‌های شما.",
                    content: "در GRAFIUM خدمات چاپ دیجیتال، چاپ لارج فرمت و صحافی ارائه می‌شود. اگر پروژه گرافیکی شما نیاز به خروجی فیزیکی دارد، می‌توانید از خدمات چاپ GRAFIUM استفاده کنید.",
                    image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&h=400&fit=crop",
                    badge: "چاپ",
                    date: "۱۴۰۵/۰۵/۰۸",
                    tags: ["چاپ", "صحافی", "خدمات", "چاپ دیجیتال"]
                },
                {
                    id: 12,
                    title: "ساخت نمونه کار حرفه‌ای برای طراحان",
                    excerpt: "نمونه کار قوی اولین قدم برای جذب مشتری است. با این راهنما پورتفولیو بسازید.",
                    content: "یک نمونه کار حرفه‌ای باید پروژه‌های شما را به بهترین شکل نمایش دهد. در این مقاله مراحل ساخت نمونه کار آنلاین و چاپی را یاد می‌گیرید.",
                    image: "https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=400&fit=crop",
                    badge: "طراحی",
                    date: "۱۴۰۵/۰۵/۰۷",
                    tags: ["نمونه کار", "پورتفولیو", "طراحی", "گرافیک"]
                },
            ];

            // ===== خواندن id از URL =====
            const params = new URLSearchParams(window.location.search);
            const articleId = parseInt(params.get('id')) || 1;

            const article = articles.find(a => a.id === articleId);
            const container = document.getElementById('articleContainer');

            if (!article) {
                container.innerHTML = `
                    <div class="article-not-found">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>مقاله‌ای یافت نشد.</p>
                        <a href="{{ route('blog') }}" class="btn btn-gold-outline" style="margin-top:12px;">
                            <i class="fas fa-arrow-right"></i> بازگشت به بلاگ
                        </a>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="article-container">
                        <div class="article-hero" style="background-image: url('${article.image}');">
                            <span class="article-badge">${article.badge}</span>
                        </div>
                        <div class="article-body">
                            <div class="article-meta">
                                <span><i class="fas fa-calendar-alt"></i> ${article.date}</span>
                                <span><i class="fas fa-tag"></i> ${article.tags.join(' / ')}</span>
                            </div>
                            <h1 class="article-title purple-text">${article.title}</h1>
                            <div class="article-excerpt">${article.excerpt}</div>
                            <div class="article-content">${article.content}</div>
                            <div class="article-tags">
                                ${article.tags.map(tag => `<span class="article-tag">${tag}</span>`).join('')}
                            </div>
                            <a href="{{ route('blog') }}" class="back-link">
                                <i class="fas fa-arrow-right"></i>
                                بازگشت به مقالات
                            </a>
                        </div>
                    </div>
                `;
            }

        })();

        console.log('Blog post page loaded successfully!');
    </script>

</body>
</html>