<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>درباره ما | GRAFIUM</title>

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
        ABOUT SECTION
        ============================================================ */
        .about-section {
            margin-top: -80px;
            position: relative;
            z-index: 2;
            padding-bottom: 60px;
        }

        .about-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            animation: fadeUp 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s backwards;
        }

        /* ===== HERO IMAGE ===== */
        .about-hero-image {
            width: 100%;
            height: 340px;
            position: relative;
            overflow: hidden;
            background: var(--navy-gradient);
        }
        .about-hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .about-card:hover .about-hero-image img {
            transform: scale(1.05);
        }
        .about-hero-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(10, 22, 40, 0.85) 100%);
            pointer-events: none;
        }

        /* Title overlay on image */
        .about-title-overlay {
            position: absolute;
            bottom: 30px;
            right: 40px;
            left: 40px;
            z-index: 2;
            color: #fff;
        }
        .about-title-overlay .title-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(212, 163, 115, 0.9);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 6px 18px;
            border-radius: 60px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 14px;
        }
        .about-title-overlay h1 {
            font-size: 42px;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: -1px;
        }
        .about-title-overlay h1 .gold-line {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .about-title-overlay p {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.75);
            margin-top: 8px;
        }

        /* ===== BODY ===== */
        .about-body {
            padding: 50px 48px;
        }

        /* Intro paragraph */
        .about-intro {
            font-size: 17px;
            line-height: 2.1;
            color: var(--text);
            text-align: justify;
            margin-bottom: 40px;
            padding: 24px 28px;
            background: var(--bg-soft);
            border-radius: var(--radius-sm);
            border-right: 4px solid var(--gold);
            position: relative;
        }
        [data-theme="dark"] .about-intro {
            background: var(--navy-700);
        }
        .about-intro::before {
            content: '"';
            position: absolute;
            top: -20px;
            right: 20px;
            font-size: 80px;
            color: rgba(212, 163, 115, 0.15);
            font-family: Georgia, serif;
            line-height: 1;
        }
        .about-intro strong {
            color: var(--gold-dark);
            font-weight: 800;
        }
        [data-theme="dark"] .about-intro strong { color: var(--gold); }

        /* Feature paragraph */
        .about-text {
            font-size: 16px;
            line-height: 2;
            color: var(--text-muted);
            text-align: justify;
            margin-bottom: 30px;
        }

        /* ===== INLINE IMAGE ===== */
        .about-inline {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
            align-items: center;
            margin: 40px 0;
            padding: 24px;
            background: var(--bg-soft);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }
        [data-theme="dark"] .about-inline {
            background: var(--navy-700);
        }
        .about-inline::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--gold-gradient);
            opacity: 0.5;
        }
        .about-inline:hover {
            border-color: var(--gold);
            box-shadow: var(--shadow-gold);
            transform: translateX(-6px);
        }
        .about-inline:hover::before { opacity: 1; }

        .about-inline.reverse {
            grid-template-columns: 1fr 280px;
        }
        .about-inline.reverse .about-inline-image { order: 2; }
        .about-inline.reverse .about-inline-text { order: 1; }

        .about-inline-image {
            border-radius: var(--radius-sm);
            overflow: hidden;
            height: 200px;
            box-shadow: var(--shadow-sm);
            position: relative;
        }
        .about-inline-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.8s;
        }
        .about-inline:hover .about-inline-image img {
            transform: scale(1.08);
        }

        .about-inline-text {
            font-size: 15px;
            line-height: 2;
            color: var(--text-muted);
            text-align: justify;
        }
        .about-inline-text strong {
            color: var(--text);
            font-weight: 800;
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
        }

        /* ===== FEATURE LIST ===== */
        .about-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 40px;
            padding-top: 40px;
            border-top: 1px solid var(--border);
        }
        .feature-item {
            text-align: center;
            padding: 24px 16px;
            background: var(--bg-soft);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }
        [data-theme="dark"] .feature-item {
            background: var(--navy-700);
        }
        .feature-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: var(--gold-gradient);
            transition: width 0.5s;
        }
        .feature-item:hover::before { width: 60%; }
        .feature-item:hover {
            transform: translateY(-6px);
            border-color: var(--gold);
            box-shadow: var(--shadow-gold);
        }
        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin: 0 auto 14px;
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.3);
            transition: transform 0.4s;
        }
        .feature-item:hover .feature-icon {
            transform: scale(1.1) rotate(-8deg);
        }
        .feature-item h4 {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
        }
        .feature-item p {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* ============================================================
        RELATED LINKS
        ============================================================ */
        .related-section {
            padding: 20px 0 80px;
        }
        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 50px;
        }
        .section-header h2 {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 12px;
            color: var(--text);
        }
        .section-header h2 .gold-line {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .section-header p {
            color: var(--text-muted);
            font-size: 16px;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .related-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 36px 28px;
            text-align: center;
            border: 1px solid var(--border);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .related-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 0%, rgba(212, 163, 115, 0.1), transparent 70%);
            opacity: 0;
            transition: opacity 0.4s;
        }
        .related-card:hover::before { opacity: 1; }
        .related-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
            box-shadow: var(--shadow-gold);
        }
        .related-card > * { position: relative; z-index: 1; }

        .related-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(212, 163, 115, 0.15), rgba(212, 163, 115, 0.05));
            border: 1px solid rgba(212, 163, 115, 0.2);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 20px;
            transition: all 0.4s;
        }
        .related-card:hover .related-icon {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
            transform: scale(1.1) rotate(-8deg);
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.4);
        }
        .related-card h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 10px;
        }
        .related-card p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 22px;
            line-height: 1.8;
        }
        .related-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            border-radius: 60px;
            background: transparent;
            border: 2px solid var(--gold);
            color: var(--gold);
            font-weight: 700;
            font-size: 13px;
            font-family: var(--font);
            transition: all 0.35s;
        }
        .related-btn:hover {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 8px 24px rgba(212, 163, 115, 0.35);
            transform: translateY(-2px);
        }
        .related-btn i { transition: transform 0.3s; }
        .related-btn:hover i { transform: translateX(-4px); }

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
        .cta-btn.gold:hover i { transform: translateX(-5px); }
        .cta-btn.gold i { transition: transform 0.3s; }
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
        @media (max-width: 992px) {
            .about-body { padding: 40px 32px; }
            .about-inline,
            .about-inline.reverse {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .about-inline.reverse .about-inline-image,
            .about-inline.reverse .about-inline-text {
                order: initial;
            }
            .about-inline-image { height: 220px; }
            .about-features { grid-template-columns: repeat(3, 1fr); }
            .related-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .page-hero { padding: 50px 0 120px; }
            .page-hero h1 { font-size: 28px; }
            .page-hero p { font-size: 14px; }
            .about-section { margin-top: -70px; }
            .about-hero-image { height: 240px; }
            .about-title-overlay { bottom: 20px; right: 24px; left: 24px; }
            .about-title-overlay h1 { font-size: 28px; }
            .about-title-overlay p { font-size: 13px; }
            .about-body { padding: 30px 24px; }
            .about-intro { font-size: 15px; padding: 20px 22px; }
            .about-features { grid-template-columns: 1fr; gap: 12px; }
            .related-grid { grid-template-columns: 1fr; gap: 18px; }
            .cta h2 { font-size: 26px; }
            .cta { padding: 60px 0; }
        }
        @media (max-width: 480px) {
            .page-hero h1 { font-size: 24px; }
            .about-hero-image { height: 200px; }
            .about-title-overlay h1 { font-size: 22px; }
            .about-body { padding: 24px 18px; }
            .about-intro { font-size: 14px; padding: 18px 18px; }
            .about-inline { padding: 16px; }
            .about-inline-image { height: 180px; }
            .feature-item { padding: 20px 14px; }
            .related-card { padding: 28px 22px; }
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
                <i class="fas fa-info-circle"></i>
                <span>درباره ما</span>
            </div>
            <h1>
                با <span class="gold-line">GRAFIUM</span> بیشتر آشنا شوید
            </h1>
            <p>
                جایی که خلاقیت با فناوری ملاقات می‌کند و ایده‌ها به واقعیت تبدیل می‌شوند
            </p>
        </div>
    </section>

    <!-- ===== ABOUT SECTION ===== -->
    <section class="about-section">
        <div class="container">
            <div class="about-card">

                <!-- ===== HERO IMAGE ===== -->
                <div class="about-hero-image">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1400&h=600&fit=crop&crop=center" alt="GRAFIUM Coworking Space" onerror="this.style.display='none'" />

                    <div class="about-title-overlay">
                        <div class="title-badge">
                            <i class="fas fa-star"></i>
                            <span>اولین سالن کار اشتراکی گرافیکی</span>
                        </div>
                        <h1>
                            <span class="gold-line">GRAFIUM</span>
                        </h1>
                        <p>
                            فضایی برای خلاقیت، هم‌افزایی و رشد حرفه‌ای
                        </p>
                    </div>
                </div>

                <!-- ===== BODY ===== -->
                <div class="about-body">

                    <!-- Intro -->
                    <div class="about-intro">
                        <strong>GRAFIUM</strong> اولین سالن کار اشتراکی گرافیکی در شهر است. فضایی که طراحان، هنرمندان و علاقه‌مندان به گرافیک می‌توانند در آن دور هم جمع شوند، ایده‌های خود را به اشتراک بگذارند و با استفاده از تجهیزات و سیستم‌های قدرتمند، پروژه‌های خود را بدون محدودیت اجرا کنند.
                    </div>

                    <!-- Inline 1 -->
                    <div class="about-inline">
                        <div class="about-inline-image">
                            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop&crop=center" alt="فضای کاری حرفه‌ای" onerror="this.style.display='none'" />
                        </div>
                        <div class="about-inline-text">
                            <strong>محیطی حرفه‌ای و الهام‌بخش</strong>
                            ما با فراهم کردن محیطی حرفه‌ای، ارگونومیک و الهام‌بخش، بستری برای رشد و خلاقیت فراهم کرده‌ایم. از میزهای کار استاندارد گرفته تا سیستم‌های i9 و کارت‌های گرافیک RTX، همه چیز برای خلق آثار بی‌نظیر در دسترس شماست.
                        </div>
                    </div>

                    <!-- Text -->
                    <p class="about-text">
                        تیم ما متشکل از طراحان، برنامه‌نویسان و مربیان مجرب است که همواره در کنار شما هستند تا بهترین تجربه ممکن را داشته باشید. هدف ما ایجاد یک جامعه‌ی پویا و خلاق است که در آن هنرمندان بتوانند از تجربیات یکدیگر بیاموزند، هم‌افزایی کنند و پروژه‌های بزرگ را با تکیه بر توانایی‌های جمعی به انجام برسانند. در GRAFIUM، شما نه تنها به یک فضای کار دسترسی دارید، بلکه به یک شبکه‌ی حمایتی از طراحان و هنرمندان حرفه‌ای متصل می‌شوید.
                    </p>

                    <!-- Inline 2 (reverse) -->
                    <div class="about-inline reverse">
                        <div class="about-inline-image">
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600&h=400&fit=crop&crop=center" alt="همکاری و خلاقیت" onerror="this.style.display='none'" />
                        </div>
                        <div class="about-inline-text">
                            <strong>جامعه‌ای پویا و خلاق</strong>
                            ما به‌طور مداوم در حال برگزاری کارگاه‌های تخصصی، دوره‌های آموزشی و رویدادهای شبکه‌سازی هستیم تا اعضای خود را در مسیر رشد حرفه‌ای یاری کنیم. از جلسات نقد و بررسی آثار تا همکاری در پروژه‌های مشترک، همه چیز در GRAFIUM برای پیشرفت شما طراحی شده است.
                        </div>
                    </div>

                    <!-- Closing text -->
                    <p class="about-text">
                        با ما همراه شوید و تجربه‌ای متفاوت از کار و خلاقیت را آغاز کنید. <strong style="color:var(--gold-dark);">GRAFIUM</strong>، جایی که هنر و تکنولوژی در کنار هم قرار می‌گیرند.
                    </p>

                    <!-- Features -->
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h4>سیستم‌های فوق‌قدرتمند</h4>
                            <p>i9 + RTX برای پروژه‌های سنگین</p>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>جامعه‌ی خلاقان</h4>
                            <p>شبکه‌ای از طراحان حرفه‌ای</p>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <h4>کیفیت تضمین‌شده</h4>
                            <p>تجهیزات مدرن و اینترنت پرسرعت</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ===== RELATED LINKS ===== -->
    <section class="related-section">
        <div class="container">
            <div class="section-header">
                <h2>
                    <span class="gold-line">پیشنهادهای</span> ویژه
                </h2>
                <p>صفحات مرتبط با ما را مشاهده کنید</p>
            </div>

            <div class="related-grid">
                <a href="{{ route('services') }}" class="related-card">
                    <div class="related-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>رزرو میز عمومی</h3>
                    <p>فضای کاری باز با میزهای اختصاصی و اینترنت پرسرعت</p>
                    <span class="related-btn">
                        مشاهده
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </a>

                <a href="{{ route('contact') }}" class="related-card">
                    <div class="related-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>تماس با ما</h3>
                    <p>پشتیبانی ۲۴/۷، مشاوره رایگان و پاسخ به سوالات شما</p>
                    <span class="related-btn">
                        مشاهده
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </a>

                <a href="{{ route('blog') }}" class="related-card">
                    <div class="related-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3>بلاگ و اخبار</h3>
                    <p>آخرین مقالات، آموزش‌ها و رویدادهای گرافیکی دنیا</p>
                    <span class="related-btn">
                        مشاهده
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </a>
            </div>
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
