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
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --deep-navy: #0a1628;
            --navy-800: #0f1f33;
            --navy-700: #132238;
            --navy-600: #1a2f4a;
            --gold: #d4a373;
            --gold-dark: #b8874a;
            --gold-light: #f0d5b0;
            --gold-gradient: linear-gradient(135deg, #d4a373, #b8874a);
            --navy-gradient: linear-gradient(135deg, #0a1628, #1a2f4a);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --bg-soft: #fafbfc;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --border: #e4e7ec;
            --shadow-sm: 0 2px 8px rgba(10, 22, 40, 0.04);
            --shadow: 0 8px 30px rgba(10, 22, 40, 0.08);
            --shadow-lg: 0 20px 60px rgba(10, 22, 40, 0.15);
            --shadow-gold: 0 20px 50px rgba(212, 163, 115, 0.25);
            --radius: 24px;
            --radius-sm: 16px;
            --transition: 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            --font: "Vazirmatn", "Inter", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #0f1f33;
            --bg-soft: #132238;
            --text: #f0f0f0;
            --text-muted: #94a3b8;
            --border: #1a2f4a;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.2);
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.5);
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
            -webkit-font-smoothing: antialiased;
        }

        ::selection { background: var(--gold); color: #fff; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; display: block; }

        .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }

        /* ============================================================
        PAGE HERO
        ============================================================ */
        .page-hero {
            background: var(--deep-navy);
            padding: 70px 0 140px;
            position: relative;
            overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 85% 20%, rgba(212, 163, 115, 0.18), transparent 45%),
                radial-gradient(circle at 15% 80%, rgba(212, 163, 115, 0.1), transparent 50%);
            animation: heroGlow 15s ease-in-out infinite alternate;
        }
        @keyframes heroGlow {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }
        .page-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(212, 163, 115, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 163, 115, 0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 20%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 20%, transparent 75%);
        }

        .page-hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: #fff;
            animation: fadeUp 0.9s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(212, 163, 115, 0.15);
            border: 1px solid rgba(212, 163, 115, 0.35);
            backdrop-filter: blur(10px);
            color: var(--gold-light);
            padding: 8px 20px;
            border-radius: 60px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
        }
        .hero-badge::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: badgeShine 3s ease-in-out infinite;
        }
        @keyframes badgeShine {
            0%, 100% { left: -100%; }
            50% { left: 100%; }
        }

        .page-hero h1 {
            font-size: 46px;
            font-weight: 900;
            margin-bottom: 16px;
            letter-spacing: -1px;
            line-height: 1.2;
        }
        .page-hero h1 .gold-line {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .page-hero p {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.65);
            max-width: 600px;
            margin: 0 auto;
        }

        /* ============================================================
        BLOG SECTION
        ============================================================ */
        .blog-section {
            margin-top: -80px;
            position: relative;
            z-index: 2;
            padding-bottom: 80px;
        }

        /* ============================================================
        SEARCH BOX
        ============================================================ */
        .search-wrapper {
            max-width: 600px;
            margin: 0 auto 40px;
            position: relative;
            animation: fadeUp 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s backwards;
        }
        .search-box {
            position: relative;
            background: var(--bg-card);
            border-radius: 20px;
            padding: 8px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        .search-box:focus-within {
            border-color: var(--gold);
            box-shadow: var(--shadow-gold);
            transform: translateY(-2px);
        }
        .search-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--bg-soft);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            transition: all 0.3s;
        }
        .search-box:focus-within .search-icon {
            background: var(--gold-gradient);
            color: #fff;
        }
        .search-input {
            flex: 1;
            border: none;
            background: transparent;
            color: var(--text);
            font-family: var(--font);
            font-size: 15px;
            outline: none;
            padding: 0 8px;
        }
        .search-input::placeholder { color: var(--text-muted); }
        .search-submit {
            padding: 0 24px;
            height: 48px;
            border-radius: 14px;
            background: var(--gold-gradient);
            color: #fff;
            border: none;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: var(--font);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        .search-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 163, 115, 0.4);
        }

        /* Results info */
        .results-info {
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
            color: var(--text-muted);
        }
        .results-info .highlight {
            color: var(--gold-dark);
            font-weight: 800;
        }
        [data-theme="dark"] .results-info .highlight { color: var(--gold); }

        .results-info .clear-search {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-right: 12px;
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(244, 63, 94, 0.1);
            color: #fb7185;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.3s;
        }
        .results-info .clear-search:hover {
            background: rgba(244, 63, 94, 0.2);
        }

        /* ============================================================
        BLOG GRID
        ============================================================ */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        /* ============================================================
        BLOG CARD
        ============================================================ */
        .blog-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: var(--shadow-sm);
            position: relative;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            animation: cardFadeIn 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
        }
        .blog-card:nth-child(1) { animation-delay: 0.05s; }
        .blog-card:nth-child(2) { animation-delay: 0.1s; }
        .blog-card:nth-child(3) { animation-delay: 0.15s; }
        .blog-card:nth-child(4) { animation-delay: 0.2s; }
        .blog-card:nth-child(5) { animation-delay: 0.25s; }
        .blog-card:nth-child(6) { animation-delay: 0.3s; }
        .blog-card:nth-child(7) { animation-delay: 0.35s; }
        .blog-card:nth-child(8) { animation-delay: 0.4s; }
        .blog-card:nth-child(9) { animation-delay: 0.45s; }
        @keyframes cardFadeIn {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .blog-card:hover {
            transform: translateY(-12px);
            border-color: var(--gold);
            box-shadow: var(--shadow-gold);
        }

        /* Shine effect */
        .blog-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 163, 115, 0.12), transparent);
            transition: left 0.8s;
            z-index: 3;
            pointer-events: none;
        }
        .blog-card:hover::after { left: 150%; }

        /* ============================================================
        BLOG IMAGE
        ============================================================ */
        .blog-image {
            width: 100%;
            height: 220px;
            position: relative;
            overflow: hidden;
            background: var(--navy-gradient);
        }
        .blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .blog-card:hover .blog-image img {
            transform: scale(1.1);
        }
        .blog-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(10, 22, 40, 0.7) 100%);
            pointer-events: none;
        }

        /* Category badge */
        .blog-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 6px 16px;
            border-radius: 9999px;
            background: rgba(10, 22, 40, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.4s;
        }
        .blog-badge i { color: var(--gold); font-size: 10px; }
        .blog-card:hover .blog-badge {
            background: var(--gold-gradient);
            border-color: transparent;
            transform: translateY(-2px);
        }
        .blog-card:hover .blog-badge i { color: #fff; }

        /* Date overlay (bottom of image) */
        .blog-date-overlay {
            position: absolute;
            bottom: 16px;
            left: 16px;
            padding: 6px 14px;
            border-radius: 12px;
            background: rgba(212, 163, 115, 0.9);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.4s;
        }
        .blog-card:hover .blog-date-overlay {
            background: var(--gold-gradient);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.4);
        }

        /* ============================================================
        BLOG CONTENT
        ============================================================ */
        .blog-content {
            padding: 26px 24px 24px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .blog-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 12px;
            line-height: 1.45;
            transition: color 0.3s;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .blog-card:hover .blog-title {
            color: var(--gold-dark);
        }
        [data-theme="dark"] .blog-card:hover .blog-title { color: var(--gold); }

        .blog-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.9;
            margin-bottom: 18px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Footer */
        .blog-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            margin-top: auto;
        }
        .blog-author {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
        }
        .blog-author i {
            color: var(--gold);
            font-size: 11px;
        }

        .blog-read-more {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 700;
            color: var(--gold);
            transition: all 0.3s;
        }
        .blog-read-more i {
            transition: transform 0.3s;
            font-size: 11px;
        }
        .blog-card:hover .blog-read-more {
            color: var(--gold-dark);
            gap: 10px;
        }
        [data-theme="dark"] .blog-card:hover .blog-read-more { color: var(--gold); }
        .blog-card:hover .blog-read-more i { transform: translateX(-4px); }

        /* Tags row */
        .blog-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 14px;
        }
        .blog-tag {
            padding: 3px 10px;
            border-radius: 9999px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 700;
            transition: all 0.3s;
        }
        .blog-tag:hover {
            background: rgba(212, 163, 115, 0.1);
            color: var(--gold);
            border-color: rgba(212, 163, 115, 0.3);
        }

        /* ============================================================
        EMPTY STATE
        ============================================================ */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 100px 20px;
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px dashed var(--border);
        }
        .empty-icon {
            width: 100px;
            height: 100px;
            border-radius: 30px;
            background: linear-gradient(135deg, rgba(212, 163, 115, 0.1), rgba(212, 163, 115, 0.03));
            border: 2px dashed rgba(212, 163, 115, 0.3);
            color: var(--gold);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            margin-bottom: 22px;
            animation: emptyFloat 3s ease-in-out infinite;
        }
        @keyframes emptyFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .empty-state h3 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 10px;
        }
        .empty-state p {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }
        .empty-state .btn-gold-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 9999px;
            background: transparent;
            border: 2px solid var(--gold);
            color: var(--gold);
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s;
            font-family: var(--font);
        }
        .empty-state .btn-gold-outline:hover {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
            transform: translateY(-3px);
        }

        /* ============================================================
        PAGINATION
        ============================================================ */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }
        .pagination-wrapper nav {
            display: flex;
            gap: 8px;
            align-items: center;
            background: var(--bg-card);
            padding: 8px;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .pagination-wrapper nav > div {
            display: flex;
            gap: 4px;
            align-items: center;
        }
        .pagination-wrapper a,
        .pagination-wrapper span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            transition: all 0.3s;
            font-family: var(--font);
        }
        .pagination-wrapper a:hover {
            background: var(--bg-soft);
            color: var(--gold);
        }
        .pagination-wrapper span[aria-current="page"] span,
        .pagination-wrapper .active span {
            background: var(--gold-gradient) !important;
            color: #fff !important;
            box-shadow: 0 6px 18px rgba(212, 163, 115, 0.35);
        }
        .pagination-wrapper svg {
            width: 16px;
            height: 16px;
        }

        /* ============================================================
        CTA
        ============================================================ */
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
            background: radial-gradient(circle at 20% 50%, rgba(212, 163, 115, 0.08), transparent 60%);
        }
        .cta::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 50%, rgba(212, 163, 115, 0.06), transparent 60%);
        }
        .cta .container { position: relative; z-index: 1; }
        .cta h2 {
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.3;
        }
        .cta h2 .gold-line {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .cta p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto 36px;
        }
        .cta-buttons {
            display: flex;
            gap: 18px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 32px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid transparent;
        }
        .cta-btn.gold {
            background: var(--gold-gradient);
            color: #fff;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.35);
        }
        .cta-btn.gold:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(212, 163, 115, 0.55);
        }
        .cta-btn.white {
            background: #fff;
            color: var(--deep-navy);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.15);
        }
        .cta-btn.white:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(255, 255, 255, 0.3);
        }

        /* ============================================================
        RESPONSIVE
        ============================================================ */
        @media (max-width: 1100px) {
            .blog-grid { grid-template-columns: repeat(2, 1fr); gap: 22px; }
        }
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .page-hero { padding: 50px 0 120px; }
            .page-hero h1 { font-size: 28px; }
            .page-hero p { font-size: 14px; }
            .blog-section { margin-top: -70px; }
            .blog-grid { grid-template-columns: 1fr; gap: 18px; }
            .blog-image { height: 200px; }
            .search-submit span { display: none; }
            .search-submit { padding: 0 16px; }
            .cta h2 { font-size: 26px; }
            .cta { padding: 60px 0; }
        }
        @media (max-width: 480px) {
            .page-hero h1 { font-size: 24px; }
            .search-icon { width: 42px; height: 42px; }
            .search-box { padding: 6px; }
            .search-submit { height: 42px; }
            .blog-image { height: 180px; }
            .cta-buttons { flex-direction: column; }
            .cta-btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <!-- ===== PAGE HERO ===== -->
    <section class="page-hero">
        <div class="container page-hero-content">
            <div class="hero-badge">
                <i class="fas fa-newspaper"></i>
                <span>اخبار و مقالات</span>
            </div>
            <h1>
                آخرین مطالب <span class="gold-line">GRAFIUM</span>
            </h1>
            <p>
                جدیدترین مقالات آموزشی، اخبار و رویدادهای دنیای گرافیک را دنبال کنید
            </p>
        </div>
    </section>

    <!-- ===== BLOG SECTION ===== -->
    <section class="blog-section">
        <div class="container">

            <!-- ===== SEARCH BOX ===== -->
            <div class="search-wrapper">
                <form action="{{ route('blog.search') }}" method="GET">
                    <div class="search-box">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input
                            type="text"
                            name="q"
                            class="search-input"
                            placeholder="جستجو در مقالات... (مثلاً: فتوشاپ)"
                            value="{{ request('q') }}"
                        />
                        <button type="submit" class="search-submit">
                            <i class="fas fa-search"></i>
                            <span>جستجو</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- ===== RESULTS INFO ===== -->
            @if(request('q'))
                <div class="results-info">
                    <span>
                        نتایج جستجو برای: 
                        <span class="highlight">«{{ request('q') }}»</span>
                    </span>
                    <a href="{{ route('blog') }}" class="clear-search">
                        <i class="fas fa-times"></i>
                        پاک کردن
                    </a>
                </div>
            @endif

            <!-- ===== BLOG GRID ===== -->
            <div class="blog-grid">
                @forelse($posts as $post)
                    @php
                        $imageUrl = $post->media 
                            ? asset('storage/' . $post->media) 
                            : 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=600&fit=crop';
                        
                        $firstTag = null;
                        if ($post->tags) {
                            $tagsArray = explode(',', $post->tags);
                            $firstTag = trim($tagsArray[0]);
                        }
                    @endphp

                    <a href="{{ route('blog.post', $post->id) }}" class="blog-card">
                        <!-- IMAGE -->
                        <div class="blog-image">
                            <img src="{{ $imageUrl }}" alt="{{ $post->title }}" loading="lazy" onerror="this.style.display='none'" />
                            
                            <!-- Category badge -->
                            @if($post->category)
                                <span class="blog-badge">
                                    <i class="fas fa-folder"></i>
                                    {{ $post->category->name }}
                                </span>
                            @else
                                <span class="blog-badge">
                                    <i class="fas fa-folder"></i>
                                    عمومی
                                </span>
                            @endif

                            <!-- Date overlay -->
                            <span class="blog-date-overlay">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $post->created_at ? $post->created_at->format('Y/m/d') : '—' }}
                            </span>
                        </div>

                        <!-- CONTENT -->
                        <div class="blog-content">
                            <h3 class="blog-title">{{ $post->title }}</h3>

                            <p class="blog-desc">
                                {{ Str::limit(strip_tags($post->summary ?? $post->text), 110) }}
                            </p>

                            <!-- Tags -->
                            @if($firstTag)
                                <div class="blog-tags">
                                    <span class="blog-tag">
                                        <i class="fas fa-tag"></i> {{ $firstTag }}
                                    </span>
                                </div>
                            @endif

                            <!-- Footer -->
                            <div class="blog-footer">
                                <span class="blog-author">
                                    <i class="fas fa-user"></i>
                                    {{ $post->author->name ?? 'GRAFIUM' }}
                                </span>
                                <span class="blog-read-more">
                                    ادامه مطلب
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-search-minus"></i>
                        </div>
                        <h3>هیچ مقاله‌ای یافت نشد</h3>
                        <p>
                            @if(request('q'))
                                متأسفانه مقاله‌ای برای «{{ request('q') }}» پیدا نشد.
                            @else
                                هنوز هیچ مقاله‌ای منتشر نشده است.
                            @endif
                        </p>
                        <a href="{{ route('blog') }}" class="btn-gold-outline">
                            <i class="fas fa-arrow-right"></i>
                            بازگشت به بلاگ
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- ===== PAGINATION ===== -->
            @if($posts->hasPages())
                <div class="pagination-wrapper">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta">
        <div class="container">
            <h2>
                فضای کاری <span class="gold-line">خود را امروز رزرو کنید</span>
            </h2>
            <p>
                به جامعه طراحان حرفه‌ای بپیوندید و از امکانات ممتاز گرافیوم لذت ببرید.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('services') }}" class="cta-btn gold">
                    <i class="fas fa-rocket"></i>
                    <span>رزرو میز</span>
                </a>
                <a href="{{ route('contact') }}" class="cta-btn white">
                    <i class="fas fa-headset"></i>
                    <span>تماس با ما</span>
                </a>
            </div>
        </div>
    </section>

</body>
</html>
