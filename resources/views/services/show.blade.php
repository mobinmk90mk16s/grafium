<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>{{ $service->title }} | GRAFIUM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --deep-navy: #0a1628;
            --gold: #d4a373;
            --gold-dark: #b8874a;
            --gold-gradient: linear-gradient(135deg, #d4a373, #b8874a);
            --navy-gradient: linear-gradient(135deg, #0a1628, #1a2f4a);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --border: #e4e7ec;
            --shadow: 0 4px 30px rgba(10, 22, 40, 0.08);
            --radius: 16px;
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font: "Vazirmatn", sans-serif;
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
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }
        ul { list-style: none; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* ===== HEADER ===== */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212, 163, 115, 0.15);
            padding: 8px 0;
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
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo-img { height: 50px; width: auto; }

        .nav-desktop ul { display: flex; gap: 28px; }
        .nav-desktop a {
            font-weight: 500;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.7);
            transition: color 0.3s;
        }
        [data-theme="light"] .nav-desktop a { color: var(--deep-navy); }
        .nav-desktop a:hover, .nav-desktop a.active { color: var(--gold); }

        .header-actions { display: flex; align-items: center; gap: 12px; }
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
        .theme-toggle:hover { border-color: var(--gold); color: var(--gold); }

        .menu-toggle {
            display: none;
            font-size: 24px;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        [data-theme="light"] .menu-toggle { color: var(--deep-navy); }

        /* ===== BREADCRUMB ===== */
        .breadcrumb-bar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
        }
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--text-muted);
            flex-wrap: wrap;
        }
        .breadcrumb a {
            color: var(--text-muted);
            transition: color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .breadcrumb a:hover { color: var(--gold); }
        .breadcrumb i { font-size: 12px; }
        .breadcrumb .current { color: var(--text); font-weight: 600; }

        /* ===== SERVICE HERO ===== */
        .service-hero {
            padding: 40px 0;
        }
        .hero-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow);
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 0;
        }
        .hero-image {
            background: var(--navy-gradient);
            height: 100%;
            min-height: 260px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 80px;
        }
        .hero-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 30%, rgba(212, 163, 115, 0.15) 100%);
        }
        .hero-content {
            padding: 32px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .hero-badge {
            display: inline-block;
            background: var(--gold-gradient);
            color: #fff;
            padding: 4px 16px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            align-self: flex-start;
        }
        .hero-title {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
            color: var(--text);
        }
        .hero-desc {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.9;
            margin-bottom: 20px;
        }
        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            background: rgba(212, 163, 115, 0.1);
            color: var(--gold-dark);
            border: 1px solid rgba(212, 163, 115, 0.2);
        }
        [data-theme="dark"] .meta-badge {
            background: rgba(212, 163, 115, 0.15);
            color: var(--gold);
        }

        /* ===== ITEMS SECTION ===== */
        .items-section {
            padding: 20px 0 60px;
        }
        .items-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .items-header h3 {
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .items-header h3 i { color: var(--gold); }
        .items-count {
            font-size: 14px;
            color: var(--text-muted);
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 6px 14px;
            border-radius: 20px;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        /* ===== ITEM CARD (طراحی جدید و زیبا) ===== */
        .item-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px solid var(--border);
            padding: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: var(--shadow);
            position: relative;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        .item-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 16px 48px rgba(212, 163, 115, 0.18);
        }

        .item-status-bar {
            height: 4px;
            background: var(--gold-gradient);
            transition: height 0.3s;
        }
        .item-card:hover .item-status-bar { height: 6px; }

        .item-icon-wrap {
            padding: 28px 20px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .item-icon-circle {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--gold-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #fff;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.3);
            transition: transform 0.4s;
        }
        .item-card:hover .item-icon-circle {
            transform: scale(1.1) rotate(-8deg);
        }

        .item-body {
            padding: 0 20px 20px;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .item-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
        }

        .item-place {
            font-size: 13px;
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            justify-content: center;
            margin-bottom: 16px;
        }
        .item-place i { color: var(--gold); font-size: 11px; }

        .item-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin: 0 auto 14px;
            width: fit-content;
        }
        .status-free {
            background: rgba(52, 211, 153, 0.12);
            color: #34d399;
            border: 1px solid rgba(52, 211, 153, 0.25);
        }
        .status-busy {
            background: rgba(251, 113, 133, 0.12);
            color: #fb7185;
            border: 1px solid rgba(251, 113, 133, 0.25);
        }

        .item-footer {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .item-footer-text {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
        }
        .item-arrow {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: transform 0.4s;
        }
        .item-card:hover .item-arrow {
            transform: translateX(-4px);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px dashed var(--border);
        }
        .empty-state i {
            font-size: 64px;
            color: var(--border);
            margin-bottom: 20px;
        }
        .empty-state h3 {
            font-size: 22px;
            color: var(--text);
            margin-bottom: 8px;
        }
        .empty-state p {
            color: var(--text-muted);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .hero-card { grid-template-columns: 1fr; }
            .hero-image { min-height: 180px; font-size: 60px; }
            .hero-content { padding: 24px; }
            .hero-title { font-size: 24px; }
        }
        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .items-grid { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 14px; }
            .item-icon-circle { width: 60px; height: 60px; font-size: 26px; }
            .item-title { font-size: 16px; }
        }
        @media (max-width: 480px) {
            .items-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
            .item-icon-wrap { padding: 20px 12px 12px; }
            .item-body { padding: 0 12px 14px; }
        }
    </style>
</head>
<body>

    <!-- ============================================================
    HEADER
    ============================================================ -->
    <header class="header">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium" class="logo-img" />
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
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            </div>
        </div>
    </header>

    <!-- ============================================================
    BREADCRUMB
    ============================================================ -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}"><i class="fas fa-home"></i> خانه</a>
                <i class="fas fa-chevron-left"></i>
                <a href="{{ route('services') }}">خدمات</a>
                <i class="fas fa-chevron-left"></i>
                <span class="current">{{ $service->title }}</span>
            </div>
        </div>
    </div>

    <!-- ============================================================
    SERVICE HERO
    ============================================================ -->
    <section class="service-hero">
        <div class="container">
            <div class="hero-card">
                <div class="hero-image">
                    <i class="fas fa-{{ $service->icon ?: 'concierge-bell' }}"></i>
                </div>
                <div class="hero-content">
                    <span class="hero-badge">{{ $service->type_persian }}</span>
                    <h1 class="hero-title">{{ $service->title }}</h1>
                    @if($service->description)
                        <p class="hero-desc">{{ $service->description }}</p>
                    @endif
                    <div class="hero-meta">
                        @if($service->place)
                            <span class="meta-badge"><i class="fas fa-map-marker-alt"></i> {{ $service->place }}</span>
                        @endif
                        <span class="meta-badge"><i class="fas fa-tag"></i> از {{ number_format($service->price) }} تومان</span>
                        <span class="meta-badge"><i class="fas fa-chair"></i> {{ $service->active_items_count }} مورد موجود</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    ITEMS (میزها)
    ============================================================ -->
    <section class="items-section">
        <div class="container">
            @if($service->activeItems->count() > 0)
                <div class="items-header">
                    <h3><i class="fas fa-th-large"></i> انتخاب {{ $service->type === 'shift' ? 'میز' : 'آیتم' }}</h3>
                    <span class="items-count">{{ $service->activeItems->count() }} مورد</span>
                </div>

                <div class="items-grid">
                    @foreach($service->activeItems as $item)
                        <a href="{{ route('services.reserve', [$service->id, $item->id]) }}" class="item-card">
                            <div class="item-status-bar"></div>

                            <div class="item-icon-wrap">
                                <div class="item-icon-circle">
                                    <i class="fas fa-desktop"></i>
                                </div>
                            </div>

                            <div class="item-body">
                                <h4 class="item-title">{{ $item->title }}</h4>

                                @if($item->place)
                                    <div class="item-place">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $item->place }}
                                    </div>
                                @endif

                                @if($item->is_busy_now)
                                    <div class="item-status status-busy">
                                        <i class="fas fa-circle" style="font-size: 7px;"></i>
                                        الان رزرو شده
                                    </div>
                                @else
                                    <div class="item-status status-free">
                                        <i class="fas fa-circle" style="font-size: 7px;"></i>
                                        آزاد برای رزرو
                                    </div>
                                @endif

                                <div class="item-footer">
                                    <span class="item-footer-text">
                                        {{ $item->upcoming_count > 0 ? $item->upcoming_count . ' رزرو آینده' : 'بدون رزرو آینده' }}
                                    </span>
                                    <div class="item-arrow">
                                        <i class="fas fa-arrow-left"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>هیچ موردی برای این خدمت ثبت نشده</h3>
                    <p>لطفاً بعداً مراجعه کنید یا با پشتیبانی تماس بگیرید.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- ============================================================
    JAVASCRIPT
    ============================================================ -->
    <script>
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

        const menuToggle = document.getElementById('menuToggle');
        menuToggle?.addEventListener('click', () => {
            // در این صفحه منوی موبایل ساده است
        });
    </script>
</body>
</html>