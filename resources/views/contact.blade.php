<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>تماس با ما | GRAFIUM</title>

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
        CONTACT SECTION
        ============================================================ */
        .contact-section {
            margin-top: -80px;
            position: relative;
            z-index: 2;
            padding-bottom: 60px;
        }

        .contact-wrapper {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 28px;
            align-items: start;
            animation: fadeUp 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s backwards;
        }

        /* ============================================================
        INFO CARD
        ============================================================ */
        .info-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            position: sticky;
            top: 100px;
        }

        .info-header {
            background: linear-gradient(135deg, #0a1628, #1a2f4a);
            padding: 28px;
            position: relative;
            overflow: hidden;
        }
        .info-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 30%, rgba(212, 163, 115, 0.2), transparent 60%);
        }
        .info-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 14px;
            color: #fff;
        }
        .info-header-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: var(--gold-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 22px rgba(212, 163, 115, 0.4);
            flex-shrink: 0;
        }
        .info-header h3 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 3px;
        }
        .info-header p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .info-body {
            padding: 24px 28px;
        }

        .info-item {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            align-items: flex-start;
            border-bottom: 1px dashed var(--border);
            transition: all 0.3s;
        }
        .info-item:last-of-type { border-bottom: none; }

        .info-item-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(212, 163, 115, 0.1);
            border: 1px solid rgba(212, 163, 115, 0.2);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            transition: all 0.4s;
        }
        .info-item:hover .info-item-icon {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
            transform: scale(1.1) rotate(-8deg);
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.35);
        }

        .info-item-content h4 {
            font-size: 13px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 3px;
        }
        .info-item-content p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.8;
        }
        .info-item-content a {
            color: var(--text-muted);
            transition: color 0.3s;
        }
        .info-item-content a:hover { color: var(--gold); }

        /* Social */
        .info-social {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .info-social-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-social-title i { color: var(--gold); }

        .info-social-links {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .info-social-links a {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .info-social-links a:hover {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(212, 163, 115, 0.4);
        }

        /* ============================================================
        FORM CARD
        ============================================================ */
        .form-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #0a1628, #1a2f4a);
            padding: 28px;
            position: relative;
            overflow: hidden;
        }
        .form-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 30%, rgba(212, 163, 115, 0.2), transparent 60%);
        }
        .form-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 14px;
            color: #fff;
        }
        .form-header-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: var(--gold-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 22px rgba(212, 163, 115, 0.4);
            flex-shrink: 0;
        }
        .form-header h3 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 3px;
        }
        .form-header p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .form-body {
            padding: 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            margin-bottom: 18px;
        }
        .form-group.full { grid-column: 1 / -1; }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            font-size: 13px;
            color: var(--text);
            margin-bottom: 8px;
        }
        .form-group label i {
            color: var(--gold);
            font-size: 12px;
        }
        .form-group label .required {
            color: #fb7185;
            font-size: 13px;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--bg-body);
            color: var(--text);
            font-family: var(--font);
            font-size: 14px;
            transition: all 0.3s;
            outline: none;
        }
        [data-theme="dark"] .form-input,
        [data-theme="dark"] .form-textarea {
            background: #0a1628;
        }
        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(212, 163, 115, 0.12);
            background: var(--bg-card);
        }
        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--text-muted);
        }
        .form-textarea {
            resize: vertical;
            min-height: 140px;
        }

        .form-submit {
            width: 100%;
            padding: 15px 24px;
            border-radius: 14px;
            background: var(--gold-gradient);
            color: #fff;
            border: none;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            font-family: var(--font);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.35);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }
        .form-submit::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.7s;
        }
        .form-submit:hover::before { left: 100%; }
        .form-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 50px rgba(212, 163, 115, 0.55);
        }
        .form-submit:active {
            transform: translateY(-1px) scale(0.99);
        }

        /* ============================================================
        MAP CARD
        ============================================================ */
        .map-card {
            margin-top: 28px;
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s backwards;
        }

        .map-header {
            padding: 20px 26px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-soft);
        }
        .map-header-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 6px 18px rgba(212, 163, 115, 0.3);
        }
        .map-header-text h3 {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 2px;
        }
        .map-header-text p {
            font-size: 12px;
            color: var(--text-muted);
        }

        .map-body {
            height: 320px;
            background: var(--bg-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 14px;
            color: var(--text-muted);
            position: relative;
            overflow: hidden;
        }
        [data-theme="dark"] .map-body {
            background: var(--navy-700);
        }
        .map-body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(212, 163, 115, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 163, 115, 0.06) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .map-body-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .map-icon-pulse {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(212, 163, 115, 0.15);
            border: 2px solid rgba(212, 163, 115, 0.3);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
            animation: mapPulse 2.4s ease-in-out infinite;
            position: relative;
        }
        .map-icon-pulse::after {
            content: '';
            position: absolute;
            inset: -12px;
            border-radius: 50%;
            border: 2px solid rgba(212, 163, 115, 0.3);
            animation: mapRing 2.4s ease-in-out infinite;
        }
        @keyframes mapPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        @keyframes mapRing {
            0% { transform: scale(1); opacity: 0.7; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        .map-body-content h4 {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
        }
        .map-body-content p {
            font-size: 13px;
            color: var(--text-muted);
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.7;
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
        TOAST
        ============================================================ */
        .toast-container {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .toast-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 22px;
            background: var(--bg-card);
            border: 2px solid var(--gold);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            min-width: 300px;
            max-width: 420px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            animation: toastIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .toast-item i { font-size: 20px; flex-shrink: 0; }
        .toast-success { border-color: #34d399; }
        .toast-success i { color: #34d399; }
        .toast-error { border-color: #fb7185; }
        .toast-error i { color: #fb7185; }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(-100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* ============================================================
        RESPONSIVE
        ============================================================ */
        @media (max-width: 992px) {
            .contact-wrapper {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .info-card { position: static; }
            .form-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .page-hero { padding: 50px 0 120px; }
            .page-hero h1 { font-size: 28px; }
            .page-hero p { font-size: 14px; }
            .contact-section { margin-top: -70px; }
            .info-header,
            .form-header { padding: 22px; }
            .info-body,
            .form-body { padding: 20px; }
            .map-body { height: 260px; }
            .cta h2 { font-size: 26px; }
            .cta { padding: 60px 0; }
        }
        @media (max-width: 480px) {
            .page-hero h1 { font-size: 24px; }
            .info-header-icon,
            .form-header-icon { width: 46px; height: 46px; font-size: 18px; }
            .info-header h3,
            .form-header h3 { font-size: 15px; }
            .form-input,
            .form-textarea { font-size: 13px; padding: 11px 14px; }
            .form-submit { padding: 13px 20px; font-size: 14px; }
            .cta-buttons { flex-direction: column; }
            .cta-btn { width: 100%; justify-content: center; }
            .toast-container { left: 16px; right: 16px; bottom: 16px; }
            .toast-item { min-width: auto; max-width: 100%; }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <!-- ===== PAGE HERO ===== -->
    <section class="page-hero">
        <div class="container page-hero-content">
            <div class="hero-badge">
                <i class="fas fa-headset"></i>
                <span>تماس با ما</span>
            </div>
            <h1>
                در <span class="gold-line">ارتباط</span> باشید
            </h1>
            <p>
                ما همیشه آماده پاسخگویی به سوالات، انتقادات و پیشنهادات شما هستیم
            </p>
        </div>
    </section>

    <!-- ===== CONTACT SECTION ===== -->
    <section class="contact-section">
        <div class="container">

            <div class="contact-wrapper">

                <!-- ===== INFO CARD ===== -->
                <div class="info-card">
                    <div class="info-header">
                        <div class="info-header-content">
                            <div class="info-header-icon">
                                <i class="fas fa-address-card"></i>
                            </div>
                            <div>
                                <h3>اطلاعات تماس</h3>
                                <p>راه‌های ارتباطی با GRAFIUM</p>
                            </div>
                        </div>
                    </div>

                    <div class="info-body">
                        <!-- Address -->
                        <div class="info-item">
                            <div class="info-item-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-item-content">
                                <h4>آدرس</h4>
                                <p>قم، صفائیه، کوچه ممتاز، نبش کوچه ۶، پلاک ۱۴</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="info-item">
                            <div class="info-item-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="info-item-content">
                                <h4>تلفن تماس</h4>
                                <p>
                                    <a href="tel:02112345678" dir="ltr">۰۲۱-۱۲۳۴-۵۶۷۸</a><br />
                                    <a href="tel:09123456789" dir="ltr">۰۹۱۲-۳۴۵-۶۷۸۹</a>
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="info-item">
                            <div class="info-item-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-item-content">
                                <h4>ایمیل</h4>
                                <p>
                                    <a href="mailto:info@grafium.ir">info@grafium.ir</a><br />
                                    <a href="mailto:support@grafium.ir">support@grafium.ir</a>
                                </p>
                            </div>
                        </div>

                        <!-- Working hours -->
                        <div class="info-item">
                            <div class="info-item-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-item-content">
                                <h4>ساعت کاری</h4>
                                <p>شنبه تا پنجشنبه: ۹ صبح تا ۱۰ شب<br />جمعه: تعطیل</p>
                            </div>
                        </div>

                        <!-- Social -->
                        <div class="info-social">
                            <div class="info-social-title">
                                <i class="fas fa-share-alt"></i>
                                ما را دنبال کنید
                            </div>
                            <div class="info-social-links">
                                <a href="#" aria-label="اینستاگرام" title="اینستاگرام">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" aria-label="تلگرام" title="تلگرام">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a href="#" aria-label="واتساپ" title="واتساپ">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" aria-label="لینکدین" title="لینکدین">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== FORM CARD ===== -->
                <div class="form-card">
                    <div class="form-header">
                        <div class="form-header-content">
                            <div class="form-header-icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div>
                                <h3>ارسال پیام</h3>
                                <p>پیام خود را بنویسید و ارسال کنید</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <form id="contactForm" action="{{ route('contact') }}" method="POST">
                            @csrf

                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="contactName">
                                        <i class="fas fa-user"></i>
                                        نام و نام خانوادگی
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="contactName"
                                        name="name"
                                        class="form-input"
                                        placeholder="مثلاً: علی رضایی"
                                        required
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="contactEmail">
                                        <i class="fas fa-envelope"></i>
                                        ایمیل
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="contactEmail"
                                        name="email"
                                        class="form-input"
                                        placeholder="example@email.com"
                                        dir="ltr"
                                        required
                                    />
                                </div>

                                <div class="form-group full">
                                    <label for="contactSubject">
                                        <i class="fas fa-tag"></i>
                                        موضوع
                                    </label>
                                    <input
                                        type="text"
                                        id="contactSubject"
                                        name="subject"
                                        class="form-input"
                                        placeholder="موضوع پیام خود را وارد کنید"
                                    />
                                </div>

                                <div class="form-group full">
                                    <label for="contactMessage">
                                        <i class="fas fa-comment"></i>
                                        پیام
                                        <span class="required">*</span>
                                    </label>
                                    <textarea
                                        id="contactMessage"
                                        name="message"
                                        class="form-textarea"
                                        placeholder="پیام خود را اینجا بنویسید..."
                                        required
                                    ></textarea>
                                </div>
                            </div>

                            <button type="submit" class="form-submit">
                                <i class="fas fa-paper-plane"></i>
                                <span>ارسال پیام</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- ===== MAP CARD ===== -->
            <div class="map-card">
                <div class="map-header">
                    <div class="map-header-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="map-header-text">
                        <h3>موقعیت مکانی</h3>
                        <p>ما را روی نقشه پیدا کنید</p>
                    </div>
                </div>

                <div class="map-body">
                    <div class="map-body-content">
                        <div class="map-icon-pulse">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>GRAFIUM اینجاست!</h4>
                        <p>قم، صفائیه، کوچه ممتاز، نبش کوچه ۶، پلاک ۱۴</p>
                    </div>
                </div>
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

    <!-- ===== TOAST ===== -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // ============================================================
        // TOAST
        // ============================================================
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const icons = { success: 'check-circle', error: 'alert-circle', info: 'info' };
            const toast = document.createElement('div');
            toast.className = `toast-item toast-${type}`;
            toast.innerHTML = `<i class="fas fa-${icons[type]}"></i><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(-100px)';
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

        // ============================================================
        // CONTACT FORM
        // ============================================================
        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('contactName').value.trim();
            const email = document.getElementById('contactEmail').value.trim();
            const message = document.getElementById('contactMessage').value.trim();

            if (!name || !email || !message) {
                showToast('لطفاً فیلدهای ضروری را پر کنید.', 'error');
                return;
            }

            // اعتبارسنجی ساده ایمیل
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showToast('ایمیل وارد شده معتبر نیست.', 'error');
                return;
            }

            // نمایش پیام موفقیت
            showToast('پیام شما با موفقیت ارسال شد. به‌زودی با شما تماس خواهیم گرفت.', 'success');

            // ریست فرم
            this.reset();
        });
    </script>

</body>
</html>