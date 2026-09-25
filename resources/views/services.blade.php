@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>خدمات | GRAFIUM</title>

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
            --gold-gradient-hover: linear-gradient(135deg, #f0d5b0, #d4a373);
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

        /* ===== HERO HEADER ===== */
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

        /* ===== SERVICES SECTION ===== */
        .services-section {
            margin-top: -80px;
            position: relative;
            z-index: 2;
            padding-bottom: 80px;
        }

        /* ===== FILTER TABS ===== */
        .filter-wrapper {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-bottom: 40px;
            display: inline-flex;
            gap: 6px;
            position: relative;
            left: 50%;
            transform: translateX(50%);
            animation: fadeUp 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s backwards;
        }
        .filter-tab {
            padding: 12px 24px;
            border-radius: 16px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-family: var(--font);
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            white-space: nowrap;
            text-decoration: none;
        }
        .filter-tab:hover {
            color: var(--gold);
            background: rgba(212, 163, 115, 0.08);
        }
        .filter-tab.active {
            background: var(--gold-gradient);
            color: #fff;
            box-shadow: 0 8px 24px rgba(212, 163, 115, 0.35);
        }
        .filter-tab .count {
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            min-width: 22px;
            text-align: center;
        }
        .filter-tab.active .count {
            background: rgba(255, 255, 255, 0.3);
        }

        /* ===== SERVICES GRID ===== */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        /* ===== SERVICE CARD ===== */
        .service-card {
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
            text-decoration: none;
            animation: cardFadeIn 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
        }
        .service-card:nth-child(1) { animation-delay: 0.05s; }
        .service-card:nth-child(2) { animation-delay: 0.1s; }
        .service-card:nth-child(3) { animation-delay: 0.15s; }
        .service-card:nth-child(4) { animation-delay: 0.2s; }
        .service-card:nth-child(5) { animation-delay: 0.25s; }
        .service-card:nth-child(6) { animation-delay: 0.3s; }
        .service-card:nth-child(7) { animation-delay: 0.35s; }
        .service-card:nth-child(8) { animation-delay: 0.4s; }
        .service-card:nth-child(9) { animation-delay: 0.45s; }
        @keyframes cardFadeIn {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .service-card:hover {
            transform: translateY(-12px);
            border-color: var(--gold);
            box-shadow: var(--shadow-gold);
        }

        .service-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(212, 163, 115, 0.12),
                transparent
            );
            transition: left 0.8s;
            z-index: 3;
            pointer-events: none;
        }
        .service-card:hover::after { left: 150%; }

        /* ===== IMAGE BOX ===== */
        .service-image-box {
            width: 100%;
            height: 220px;
            position: relative;
            overflow: hidden;
            background: var(--navy-gradient);
        }
        .service-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card:hover .service-image-box img {
            transform: scale(1.1);
        }
        .service-image-box::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(10, 22, 40, 0.7) 100%);
            pointer-events: none;
        }

        /* ===== SERVICE ICON BIG (مرکز عکس) ===== */
        .service-icon-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90px;
            height: 90px;
            border-radius: 24px;
            background: rgba(10, 22, 40, 0.55);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 2px solid rgba(212, 163, 115, 0.4);
            color: #fff;
            font-size: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        .service-icon-center i {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 12px rgba(212, 163, 115, 0.5));
        }
        .service-card:hover .service-icon-center {
            transform: translate(-50%, -50%) scale(1.15) rotate(-8deg);
            background: rgba(212, 163, 115, 0.3);
            border-color: var(--gold);
            box-shadow: 0 20px 50px rgba(212, 163, 115, 0.6);
        }

        /* Type badge (top) */
        .service-type-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 6px 16px;
            border-radius: 9999px;
            background: rgba(10, 22, 40, 0.7);
            backdrop-filter: blur(10px);
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
        .service-type-badge.shift {
            background: rgba(96, 165, 250, 0.9);
            border-color: rgba(96, 165, 250, 0.4);
        }
        .service-type-badge.hourly {
            background: rgba(167, 139, 250, 0.9);
            border-color: rgba(167, 139, 250, 0.4);
        }
        .service-card:hover .service-type-badge {
            transform: translateY(-2px);
        }

        /* ===== CONTENT ===== */
        .service-content {
            padding: 28px 26px 24px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .service-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 10px;
            line-height: 1.35;
            transition: color 0.3s;
        }
        .service-card:hover .service-title {
            color: var(--gold-dark);
        }
        [data-theme="dark"] .service-card:hover .service-title {
            color: var(--gold);
        }

        .service-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.9;
            margin-bottom: 20px;
            flex: 1;
        }

        .service-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }
        .meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            background: var(--bg-soft);
            color: var(--text-muted);
            border: 1px solid var(--border);
            transition: all 0.3s;
        }
        .meta-badge i {
            font-size: 10px;
            color: var(--gold);
        }
        .service-card:hover .meta-badge {
            border-color: rgba(212, 163, 115, 0.3);
            background: rgba(212, 163, 115, 0.05);
        }

        .service-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            margin-top: auto;
        }
        .service-price {
            display: flex;
            flex-direction: column;
        }
        .service-price .price-label {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 3px;
            font-weight: 500;
        }
        .service-price .price-value {
            font-size: 19px;
            font-weight: 800;
            color: var(--gold-dark);
            transition: all 0.3s;
        }
        [data-theme="dark"] .service-price .price-value {
            color: var(--gold);
        }

        .service-arrow {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--bg-soft);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid var(--border);
        }
        .service-card:hover .service-arrow {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
            transform: translateX(-8px) rotate(-15deg);
            box-shadow: 0 10px 28px rgba(212, 163, 115, 0.5);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1100px) {
            .services-grid { grid-template-columns: repeat(2, 1fr); gap: 22px; }
        }
        @media (max-width: 992px) {
            .page-hero h1 { font-size: 36px; }
        }
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .page-hero { padding: 50px 0 120px; }
            .page-hero h1 { font-size: 28px; }
            .page-hero p { font-size: 14px; }
            .services-section { margin-top: -70px; }
            .services-grid { grid-template-columns: 1fr; gap: 18px; }
            .filter-wrapper {
                padding: 8px;
                flex-wrap: wrap;
                justify-content: center;
                left: 0;
                transform: none;
                display: flex;
                width: 100%;
            }
            .filter-tab {
                padding: 10px 16px;
                font-size: 12px;
                flex: 1;
                justify-content: center;
            }
            .filter-tab .count { font-size: 10px; padding: 2px 8px; }
            .service-image-box { height: 190px; }
            .service-icon-center { width: 72px; height: 72px; font-size: 32px; }
            .service-content { padding: 22px 20px 20px; }
            .service-title { font-size: 18px; }
            .cta h2 { font-size: 26px; }
            .cta { padding: 60px 0; }
        }
        @media (max-width: 480px) {
            .page-hero h1 { font-size: 24px; }
            .service-image-box { height: 170px; }
            .service-icon-center { width: 64px; height: 64px; font-size: 28px; border-radius: 18px; }
            .service-price .price-value { font-size: 16px; }
            .service-arrow { width: 40px; height: 40px; }
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
                <i class="fas fa-star"></i>
                <span>خدمات گرافیوم</span>
            </div>
            <h1>
                انتخاب <span class="gold-line">نوع خدمت</span>
            </h1>
            <p>
                نوع خدمت مورد نظر خود را انتخاب کنید تا وارد مرحله رزرو شوید
            </p>
        </div>
    </section>

    <!-- ===== SERVICES SECTION ===== -->
    <section class="services-section">
        <div class="container">

            <!-- ===== FILTER TABS ===== -->
            <div class="filter-wrapper">
                <a href="{{ route('services') }}" class="filter-tab {{ $type === 'all' ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>همه</span>
                    <span class="count">{{ $stats['total'] }}</span>
                </a>
                <a href="{{ route('services', ['type' => 'shift']) }}" class="filter-tab {{ $type === 'shift' ? 'active' : '' }}">
                    <i class="fas fa-clock"></i>
                    <span>شیفتی</span>
                    <span class="count">{{ $stats['shift'] }}</span>
                </a>
                <a href="{{ route('services', ['type' => 'hourly']) }}" class="filter-tab {{ $type === 'hourly' ? 'active' : '' }}">
                    <i class="fas fa-hourglass-half"></i>
                    <span>ساعتی</span>
                    <span class="count">{{ $stats['hourly'] }}</span>
                </a>
            </div>

            <!-- ===== SERVICES GRID ===== -->
            @if($services->count() > 0)
                <div class="services-grid">
                    @foreach($services as $service)
                        @php
                            $typeLabel = $service->type === 'shift' ? 'شیفتی' : 'ساعتی';
                            $typeIcon = $service->type === 'shift' ? 'fa-clock' : 'fa-hourglass-half';
                            $typeClass = $service->type === 'shift' ? 'shift' : 'hourly';

                            // ============================================================
                            // عکس: اول از storage، بعد پیش‌فرض
                            // ============================================================
                            $imageUrl = null;

                            if (!empty($service->image) && Storage::disk('public')->exists($service->image)) {
                                $imageUrl = asset('storage/' . $service->image);
                            }

                            // اگه عکس نبود، از پیش‌فرض استفاده کن
                            if (!$imageUrl) {
                                $defaultImages = [
                                    'shift' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=600&fit=crop',
                                    'hourly' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=600&fit=crop',
                                ];
                                $imageUrl = $defaultImages[$service->type] ?? 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=800&h=600&fit=crop';
                            }

                            // ============================================================
                            // آیکون: اول از service، بعد بر اساس عنوان
                            // ============================================================
                            $serviceIcon = $service->icon;
                            if (empty($serviceIcon)) {
                                $titleLower = mb_strtolower($service->title);
                                $serviceIcon = 'fa-concierge-bell';
                                
                                if (str_contains($titleLower, 'vip') || str_contains($titleLower, 'ویژه')) {
                                    $serviceIcon = 'fa-crown';
                                } elseif (str_contains($titleLower, 'cip')) {
                                    $serviceIcon = 'fa-shield-alt';
                                } elseif (str_contains($titleLower, 'رندر') || str_contains($titleLower, 'render')) {
                                    $serviceIcon = 'fa-microchip';
                                } elseif (str_contains($titleLower, 'استودیو') || str_contains($titleLower, 'studio')) {
                                    $serviceIcon = 'fa-camera-retro';
                                } elseif (str_contains($titleLower, 'میز') || str_contains($titleLower, 'desk')) {
                                    $serviceIcon = 'fa-desktop';
                                } elseif (str_contains($titleLower, 'اتاق') || str_contains($titleLower, 'room')) {
                                    $serviceIcon = 'fa-door-open';
                                } elseif (str_contains($titleLower, 'چاپ') || str_contains($titleLower, 'print')) {
                                    $serviceIcon = 'fa-print';
                                } elseif (str_contains($titleLower, 'کافه') || str_contains($titleLower, 'coffee')) {
                                    $serviceIcon = 'fa-coffee';
                                } elseif (str_contains($titleLower, 'طراحی') || str_contains($titleLower, 'design')) {
                                    $serviceIcon = 'fa-paint-brush';
                                } elseif (str_contains($titleLower, 'عکاس') || str_contains($titleLower, 'photo')) {
                                    $serviceIcon = 'fa-camera';
                                } elseif (str_contains($titleLower, 'ویدیو') || str_contains($titleLower, 'video')) {
                                    $serviceIcon = 'fa-video';
                                }
                            }
                        @endphp
                        <a href="{{ route('services.show', $service->id) }}" class="service-card">
                            <!-- ===== IMAGE BOX ===== -->
                            <div class="service-image-box">
                                <img src="{{ $imageUrl }}" alt="{{ $service->title }}" loading="lazy" />

                                <!-- Type Badge -->
                                <div class="service-type-badge {{ $typeClass }}">
                                    <i class="fas {{ $typeIcon }}"></i>
                                    {{ $typeLabel }}
                                </div>

                                <!-- Icon Center (روی عکس) -->
                                <div class="service-icon-center">
                                    <i class="fas {{ $serviceIcon }}"></i>
                                </div>
                            </div>

                            <!-- ===== CONTENT ===== -->
                            <div class="service-content">
                                <h3 class="service-title">{{ $service->title }}</h3>

                                @if($service->description)
                                    <p class="service-desc">{{ Str::limit($service->description, 100) }}</p>
                                @else
                                    <p class="service-desc">خدمات حرفه‌ای و باکیفیت در محیطی الهام‌بخش</p>
                                @endif

                                <div class="service-meta">
                                    @if($service->place)
                                        <span class="meta-badge">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $service->place }}
                                        </span>
                                    @endif
                                    <span class="meta-badge">
                                        <i class="fas fa-check-circle"></i>
                                        فعال
                                    </span>
                                </div>

                                <div class="service-footer">
                                    <div class="service-price">
                                        <span class="price-label">قیمت پایه</span>
                                        <span class="price-value">{{ number_format($service->price) }} تومان</span>
                                    </div>
                                    <div class="service-arrow">
                                        <i class="fas fa-arrow-left"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3>هیچ خدمتی یافت نشد</h3>
                    <p>در حال حاضر خدمتی برای نمایش وجود ندارد.</p>
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
                    <span>رزرو خدمت</span>
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