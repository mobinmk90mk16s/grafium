<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GRAFIUM | سالن کار اشتراکی گرافیکی</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />

    <style>
        /* ===== LOADING SCREEN ===== */
        #loadingScreen {
            position: fixed; inset: 0; z-index: 99999;
            background: radial-gradient(circle at 50% 50%, #132238 0%, #0a1628 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }
        #loadingScreen.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .loader-wrapper { display: flex; flex-direction: column; align-items: center; gap: 32px; position: relative; z-index: 2; }
        .loader-logo {
            width: 110px; height: 110px; border-radius: 30px;
            background: var(--gold-gradient);
            display: flex; align-items: center; justify-content: center;
            font-size: 48px; font-weight: 900; color: #fff;
            box-shadow: 0 0 80px rgba(212, 163, 115, 0.4), inset 0 0 30px rgba(255,255,255,0.15);
            animation: pulseLogo 2s ease-in-out infinite;
            position: relative;
        }
        .loader-logo::before {
            content: ''; position: absolute; inset: -8px; border-radius: 38px;
            border: 1px solid rgba(212, 163, 115, 0.3);
            animation: rotateRing 6s linear infinite;
        }
        @keyframes rotateRing { to { transform: rotate(360deg); } }
        .loader-logo span { font-size: 18px; letter-spacing: 3px; }
        @keyframes pulseLogo {
            0%, 100% { transform: scale(1); box-shadow: 0 0 80px rgba(212, 163, 115, 0.4), inset 0 0 30px rgba(255,255,255,0.15); }
            50% { transform: scale(1.06); box-shadow: 0 0 120px rgba(212, 163, 115, 0.6), inset 0 0 40px rgba(255,255,255,0.25); }
        }
        .loader-spinner {
            width: 60px; height: 60px; border-radius: 50%;
            border: 3px solid rgba(212, 163, 115, 0.08);
            border-top-color: var(--gold); border-right-color: var(--gold-light);
            animation: spin 0.9s cubic-bezier(0.6, 0.2, 0.4, 0.8) infinite;
            position: relative;
        }
        .loader-spinner::after {
            content: ''; position: absolute; inset: 6px; border-radius: 50%;
            border: 3px solid rgba(212, 163, 115, 0.05);
            border-top-color: var(--gold-dark);
            animation: spin 1.3s cubic-bezier(0.6, 0.2, 0.4, 0.8) infinite reverse;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loader-text {
            color: rgba(255, 255, 255, 0.55); font-size: 14px;
            font-weight: 500; letter-spacing: 6px; text-transform: uppercase;
            animation: fadeText 2s ease-in-out infinite;
            font-family: var(--font);
        }
        @keyframes fadeText {
            0%, 100% { opacity: 0.35; letter-spacing: 6px; }
            50% { opacity: 1; letter-spacing: 9px; }
        }
        .loader-progress {
            width: 220px; height: 2px; background: rgba(255, 255, 255, 0.06);
            border-radius: 10px; overflow: hidden; position: relative;
        }
        .loader-progress-bar {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold), var(--gold-light));
            border-radius: 10px; transition: width 0.3s ease;
            box-shadow: 0 0 20px rgba(212, 163, 115, 0.5);
        }
        .loader-particles { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
        .particle {
            position: absolute; width: 3px; height: 3px;
            background: var(--gold); border-radius: 50%; opacity: 0;
            animation: floatParticle 5s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(212, 163, 115, 0.8);
        }
        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 25%; animation-delay: 0.5s; }
        .particle:nth-child(3) { left: 40%; animation-delay: 1s; }
        .particle:nth-child(4) { left: 55%; animation-delay: 1.5s; }
        .particle:nth-child(5) { left: 70%; animation-delay: 2s; }
        .particle:nth-child(6) { left: 85%; animation-delay: 2.5s; }
        .particle:nth-child(7) { left: 15%; animation-delay: 3s; }
        .particle:nth-child(8) { left: 50%; animation-delay: 3.5s; }
        .particle:nth-child(9) { left: 75%; animation-delay: 1.2s; }
        .particle:nth-child(10) { left: 35%; animation-delay: 2.8s; }
        @keyframes floatParticle {
            0% { opacity: 0; transform: translateY(100px) scale(0); }
            20% { opacity: 0.7; transform: translateY(0) scale(1); }
            80% { opacity: 0.7; transform: translateY(-50px) scale(1); }
            100% { opacity: 0; transform: translateY(-100px) scale(0); }
        }
        #mainContent { opacity: 0; transition: opacity 0.8s ease; }
        #mainContent.visible { opacity: 1; }

        @font-face {
            font-family: 'Vazirmatn';
            src: url('{{ asset("fonts/Vazir_p30download.com.eot") }}') format('woff2');
            font-weight: 400; font-style: normal;
        }
        @font-face {
            font-family: 'Vazirmatn';
            src: url('{{ asset("fonts/Vazir_p30download.com.eot") }}') format('woff2');
            font-weight: 700; font-style: normal;
        }
        @font-face {
            font-family: 'Vazirmatn';
            src: url('{{ asset("fonts/Vazir_p30download.com.eot") }}') format('woff2');
            font-weight: 800; font-style: normal;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --deep-navy: #0a1628;
            --deep-navy-light: #132238;
            --gold: #d4a373;
            --gold-dark: #b8874a;
            --gold-light: #f0d5b0;
            --gold-gradient: linear-gradient(135deg, #d4a373, #b8874a);
            --gold-gradient-hover: linear-gradient(135deg, #f0d5b0, #d4a373);
            --navy-gradient: linear-gradient(135deg, #0a1628, #1a2f4a);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --border: #e4e7ec;
            --shadow: 0 4px 30px rgba(10, 22, 40, 0.08);
            --shadow-lg: 0 24px 70px rgba(10, 22, 40, 0.14);
            --shadow-gold: 0 20px 60px rgba(212, 163, 115, 0.2);
            --radius: 22px;
            --radius-sm: 14px;
            --transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --font: "Vazirmatn", "Inter", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #132238;
            --text: #f0f0f0;
            --text-muted: #a0a0a0;
            --border: #1a2f4a;
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 24px 70px rgba(0, 0, 0, 0.6);
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

        .container { max-width: 1240px; margin: 0 auto; padding: 0 24px; }

        /* ===== TEXT & BADGE ===== */
        .gold-text {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .purple-text { color: var(--deep-navy); }
        [data-theme="dark"] .purple-text { color: #f0f0f0; }

        .gradient-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--gold-gradient); color: #fff;
            padding: 8px 22px; border-radius: 60px;
            font-size: 12px; font-weight: 700;
            letter-spacing: 0.6px; margin-bottom: 18px;
            box-shadow: 0 8px 24px rgba(212, 163, 115, 0.25);
            position: relative; overflow: hidden;
        }
        .gradient-badge::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: translateX(-100%);
            animation: badgeShine 3s ease-in-out infinite;
        }
        @keyframes badgeShine {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }
        .gradient-badge i { font-size: 11px; position: relative; z-index: 1; }
        .gradient-badge span { position: relative; z-index: 1; }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 10px; padding: 14px 34px; border-radius: 60px;
            font-weight: 600; font-size: 14px; transition: var(--transition);
            cursor: pointer; border: 2px solid transparent;
            background: var(--gold-gradient); color: #fff;
            position: relative; overflow: hidden;
            font-family: var(--font);
        }
        .btn::before {
            content: ''; position: absolute; inset: 0;
            background: var(--gold-gradient-hover);
            opacity: 0; transition: opacity 0.4s; z-index: 0;
        }
        .btn:hover::before { opacity: 1; }
        .btn span, .btn i { position: relative; z-index: 1; }
        .btn i { transition: transform 0.4s; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(212, 163, 115, 0.45); }
        .btn:hover i.fa-arrow-left { transform: translateX(-5px); }

        .btn-gold {
            background: var(--gold-gradient); border-color: transparent;
            box-shadow: 0 6px 25px rgba(212, 163, 115, 0.25);
        }
        .btn-gold:hover { box-shadow: 0 20px 55px rgba(212, 163, 115, 0.55); }

        .btn-gold-outline {
            background: transparent; color: var(--gold); border: 2px solid var(--gold);
        }
        .btn-gold-outline::before { background: var(--gold-gradient); }
        .btn-gold-outline:hover { color: #fff; border-color: transparent; }

        .btn-white {
            background: #fff; color: var(--deep-navy);
            box-shadow: 0 6px 25px rgba(255, 255, 255, 0.15);
        }
        .btn-white::before { background: #f0f5fa; }
        .btn-white:hover { transform: translateY(-4px); box-shadow: 0 20px 55px rgba(255, 255, 255, 0.3); }

        .btn-link {
            display: block; width: 100%; margin-top: 10px;
            background: none; border: none; color: var(--text-muted);
            font-family: var(--font); font-size: 13px; cursor: pointer;
            transition: color 0.3s; text-align: center; padding: 6px;
        }
        .btn-link:hover { color: var(--gold); }

        /* ===== SECTION HEADER ===== */
        .section { padding: 100px 0; position: relative; }
        .section-header {
            text-align: center; max-width: 720px; margin: 0 auto 70px;
        }
        .section-header h2 {
            font-size: 44px; font-weight: 800; margin-bottom: 16px;
            letter-spacing: -0.8px; line-height: 1.25;
        }
        .section-header p { color: var(--text-muted); font-size: 16px; line-height: 1.9; }
        .section-header p + p { margin-top: 12px; }

        /* ===== HEADER ===== */
        .header {
            position: sticky; top: 0; z-index: 1000;
            background: rgba(10, 22, 40, 0.92);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(212, 163, 115, 0.12);
            padding: 10px 0; transition: background 0.4s, border-color 0.4s, padding 0.4s;
        }
        [data-theme="dark"] .header { background: rgba(10, 22, 40, 0.92); }
        [data-theme="light"] .header {
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid var(--border);
        }
        .header-inner { display: flex; align-items: center; justify-content: space-between; }
        .logo { display: flex; align-items: center; gap: 10px; font-size: 22px; font-weight: 800; }
        .logo-img { height: 52px; width: auto; object-fit: contain; transition: transform 0.4s; }
        .logo:hover .logo-img { transform: scale(1.05); }

        .nav-desktop ul { display: flex; gap: 32px; }
        .nav-desktop a {
            font-weight: 500; font-size: 15px; position: relative;
            transition: color 0.3s; color: rgba(255, 255, 255, 0.7);
            padding: 4px 0;
        }
        [data-theme="light"] .nav-desktop a { color: var(--deep-navy); }
        .nav-desktop a::after {
            content: ''; position: absolute; bottom: -4px; right: 0;
            width: 0; height: 2px; background: var(--gold-gradient);
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }
        .nav-desktop a:hover::after { width: 100%; }
        .nav-desktop a:hover { color: var(--gold); }
        .nav-desktop a.active { color: var(--gold); }
        .nav-desktop a.active::after { width: 100%; }

        .header-actions { display: flex; align-items: center; gap: 12px; }
        .theme-toggle {
            width: 42px; height: 42px; border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.03);
            color: #fff; cursor: pointer; font-size: 17px;
            display: flex; align-items: center; justify-content: center;
            transition: var(--transition);
        }
        [data-theme="light"] .theme-toggle {
            border-color: var(--border); color: var(--deep-navy);
            background: rgba(10, 22, 40, 0.03);
        }
        .theme-toggle:hover {
            border-color: var(--gold); color: var(--gold);
            background: rgba(212, 163, 115, 0.1);
            transform: rotate(20deg);
        }
        .menu-toggle {
            display: none; font-size: 24px; background: none; border: none;
            color: #fff; cursor: pointer; padding: 8px;
        }
        [data-theme="light"] .menu-toggle { color: var(--deep-navy); }

        /* ===== USER AVATAR & DROPDOWN ===== */
        .user-dropdown { position: relative; }

        .user-avatar-btn {
            width: 44px; height: 44px; border-radius: 50%;
            background: var(--gold-gradient);
            color: #fff;
            border: 2px solid rgba(212, 163, 115, 0.4);
            display: flex; align-items: center; justify-content: center;
            font-size: 17px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
            position: relative;
            overflow: hidden;
        }
        .user-avatar-btn::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, transparent, var(--gold-light), transparent 30%);
            opacity: 0;
            transition: opacity 0.4s;
            animation: rotateAvatar 3s linear infinite;
            z-index: -1;
        }
        @keyframes rotateAvatar { to { transform: rotate(360deg); } }
        .user-avatar-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.5);
        }
        .user-avatar-btn:hover::before { opacity: 1; }

        .user-avatar-btn i { transition: transform 0.4s; }
        .user-avatar-btn.open i { transform: scale(0.9); }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 16px);
            left: 0;
            background: var(--bg-card);
            border: 2px solid var(--gold);
            border-radius: 20px;
            padding: 10px;
            min-width: 230px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35), 0 0 0 6px rgba(212, 163, 115, 0.08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-15px) scale(0.92);
            transform-origin: top left;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 1000;
            overflow: hidden;
        }
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: 0; right: 0; left: 0;
            height: 3px;
            background: var(--gold-gradient);
            opacity: 0;
            transition: opacity 0.4s;
        }
        .dropdown-menu.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        .dropdown-menu.open::before { opacity: 1; }

        .dropdown-header {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 6px;
        }
        .dropdown-header .user-name {
            font-weight: 700;
            font-size: 15px;
            color: var(--text);
            display: block;
            margin-bottom: 2px;
        }
        .dropdown-header .user-phone {
            font-size: 12px;
            color: var(--text-muted);
            direction: ltr;
            text-align: right;
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            border: none;
            background: transparent;
            cursor: pointer;
            font-family: var(--font);
            text-align: right;
            position: relative;
            overflow: hidden;
        }
        .dropdown-item::before {
            content: '';
            position: absolute;
            right: 0; top: 0;
            width: 3px;
            height: 100%;
            background: var(--gold-gradient);
            transform: scaleY(0);
            transition: transform 0.3s;
            transform-origin: bottom;
        }
        .dropdown-item:hover {
            background: rgba(212, 163, 115, 0.08);
            color: var(--gold-dark);
            padding-right: 22px;
        }
        [data-theme="dark"] .dropdown-item:hover { color: var(--gold); }
        .dropdown-item:hover::before { transform: scaleY(1); }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: var(--gold);
            font-size: 15px;
            transition: transform 0.3s;
        }
        .dropdown-item:hover i { transform: scale(1.15); }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 6px 12px;
        }

        .logout-item:hover {
            background: rgba(244, 63, 94, 0.1);
            color: #fb7185;
        }
        .logout-item:hover i { color: #fb7185; }
        .logout-item::before { background: linear-gradient(180deg, #fb7185, #f43f5e); }

        /* ===== MOBILE MENU ===== */
        .mobile-menu {
            display: none; flex-direction: column; gap: 16px;
            padding: 24px; background: var(--bg-card);
            border-top: 1px solid var(--border);
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu ul { display: flex; flex-direction: column; gap: 16px; }
        .mobile-menu a { font-weight: 500; font-size: 16px; padding: 8px 0; display: block; }
        .mobile-auth { display: flex; gap: 12px; }

        /* ===== HERO SLIDER ===== */
        .hero-slider { padding: 0; position: relative; }
        .hero-slide {
            height: 660px; display: flex; align-items: center; justify-content: flex-start;
            color: #fff; background-size: cover; background-position: center;
            position: relative; overflow: hidden;
        }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(90deg, rgba(10, 22, 40, 0.85) 0%, rgba(10, 22, 40, 0.4) 60%, rgba(10, 22, 40, 0.2) 100%);
            z-index: 1;
        }
        .hero-content {
            position: relative; z-index: 2; text-align: right;
            margin-right: 35px; margin-left: auto;
            max-width: 720px; width: 100%; padding-right: 40px;
        }
        .hero-content .hero-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(212, 163, 115, 0.15);
            border: 1px solid rgba(212, 163, 115, 0.35);
            backdrop-filter: blur(10px);
            color: var(--gold-light);
            padding: 8px 18px; border-radius: 60px;
            font-size: 12px; font-weight: 700; letter-spacing: 1px;
            margin-bottom: 22px;
            opacity: 0; transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .hero-content h1 {
            display: flex; flex-direction: column; align-items: flex-start;
            font-size: 56px; font-weight: 900; margin-bottom: 18px;
            line-height: 1.2; color: #f0d5b0; letter-spacing: -1px;
            opacity: 0; transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .hero-content h1 .gold-line {
            background: var(--gold-gradient);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-content p {
            text-align: right; font-size: 19px; max-width: 560px;
            margin: 0 0 32px 0; color: rgba(255,255,255,0.85);
            line-height: 1.8;
            opacity: 0; transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .hero-content .btn {
            align-self: flex-start;
            opacity: 0; transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease, background 0.4s, box-shadow 0.4s;
        }
        .hero-content .hero-tag.animate-in,
        .hero-content h1.animate-in,
        .hero-content p.animate-in,
        .hero-content .btn.animate-in {
            opacity: 1; transform: translateY(0);
        }
        .hero-slide::before {
            content: ''; position: absolute; inset: 0;
            background: inherit; background-size: cover; background-position: center;
            transform: scale(1); transition: transform 7s ease; z-index: 0;
        }
        .swiper-slide-active .hero-slide::before { transform: scale(1.1); }

        .swiper-button-next, .swiper-button-prev {
            background: rgba(255, 255, 255, 0.08) !important;
            backdrop-filter: blur(12px) !important; -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(212, 163, 115, 0.3) !important;
            border-radius: 50% !important; width: 52px !important; height: 52px !important;
            transition: all 0.4s ease !important; color: var(--gold) !important;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: var(--gold-gradient) !important;
            border-color: var(--gold) !important; color: #fff !important;
            box-shadow: 0 0 40px rgba(212, 163, 115, 0.5) !important;
            transform: scale(1.1);
        }
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 18px !important; font-weight: 700 !important;
        }
        .swiper-pagination-bullet {
            width: 10px !important; height: 10px !important;
            background: rgba(212, 163, 115, 0.35) !important; opacity: 1 !important;
            border: 2px solid rgba(255, 255, 255, 0.25) !important;
            transition: all 0.4s ease !important;
        }
        .swiper-pagination-bullet-active {
            background: var(--gold) !important; border-color: var(--gold) !important;
            width: 30px !important; border-radius: 6px !important;
            box-shadow: 0 0 25px rgba(212, 163, 115, 0.5) !important;
        }
        .swiper-progress-bar {
            position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
            background: rgba(255, 255, 255, 0.12); z-index: 10;
            border-radius: 0; overflow: hidden;
        }
        .swiper-progress-fill {
            display: block; height: 100%; width: 0%;
            background: var(--gold-gradient); transition: width 0.1s linear;
            box-shadow: 0 0 15px rgba(212, 163, 115, 0.6);
        }

        /* ===== 3D PARTICLE SPHERE ===== */
        #particleSphere {
            position: absolute; top: 50%; left: 5%;
            transform: translateY(-50%); width: 500px; height: 500px;
            z-index: 2; pointer-events: none; opacity: 0;
            animation: fadeInSphere 2s ease forwards; animation-delay: 0.5s;
        }
        @keyframes fadeInSphere {
            0% { opacity: 0; transform: translateY(-50%) scale(0.8); }
            100% { opacity: 1; transform: translateY(-50%) scale(1); }
        }

        /* ===== TRUST BAR ===== */
        .trust-bar {
            background: var(--bg-card); border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border); padding: 32px 0;
            overflow: hidden; position: relative;
        }
        .trust-bar::before, .trust-bar::after {
            content: ''; position: absolute; top: 0; width: 120px; height: 100%;
            z-index: 2; pointer-events: none;
        }
        .trust-bar::before { right: 0; background: linear-gradient(270deg, var(--bg-card), transparent); }
        .trust-bar::after { left: 0; background: linear-gradient(90deg, var(--bg-card), transparent); }
        .trust-track {
            display: flex; gap: 70px; animation: scrollTrust 30s linear infinite;
            width: max-content;
        }
        .trust-track .trust-item {
            display: flex; align-items: center; gap: 12px;
            color: var(--text-muted); font-weight: 500; font-size: 14px;
            white-space: nowrap; transition: all 0.3s;
        }
        .trust-track .trust-item:hover { color: var(--gold); transform: translateY(-2px); }
        .trust-track .trust-item i { color: var(--gold); font-size: 20px; }
        @keyframes scrollTrust {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* ===== ABOUT ===== */
        .about-highlights {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 24px; margin-top: 60px;
        }
        .highlight-card {
            background: var(--bg-card); border-radius: var(--radius);
            padding: 32px 28px; border: 1px solid var(--border);
            text-align: center; transition: var(--transition);
            position: relative; overflow: hidden;
        }
        .highlight-card::before {
            content: ''; position: absolute; top: 0; right: 0;
            width: 100px; height: 100px;
            background: radial-gradient(circle, rgba(212, 163, 115, 0.1), transparent 70%);
            transition: transform 0.6s;
        }
        .highlight-card:hover { transform: translateY(-8px); border-color: var(--gold); box-shadow: var(--shadow-gold); }
        .highlight-card:hover::before { transform: scale(1.5); }
        .highlight-icon {
            width: 70px; height: 70px; border-radius: 20px;
            background: var(--gold-gradient); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; margin: 0 auto 18px;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.3);
            transition: transform 0.4s;
        }
        .highlight-card:hover .highlight-icon { transform: scale(1.1) rotate(-8deg); }
        .highlight-card h3 { font-size: 18px; margin-bottom: 8px; }
        .highlight-card p { font-size: 14px; color: var(--text-muted); }

        /* ===== SERVICES GRID ===== */
        .services-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 26px;
        }
        .service-card {
            background: var(--bg-card); border-radius: var(--radius);
            padding: 38px 26px; text-align: center;
            border: 1px solid var(--border); transition: var(--transition);
            box-shadow: var(--shadow); position: relative; overflow: hidden;
            cursor: pointer;
        }
        .service-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 4px; background: var(--gold-gradient);
            transform: scaleX(0); transform-origin: right;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 50% 0%, rgba(212, 163, 115, 0.1), transparent 70%);
            opacity: 0; transition: opacity 0.5s;
        }
        .service-card:hover::before { transform: scaleX(1); }
        .service-card:hover::after { opacity: 1; }
        .service-card:hover {
            transform: translateY(-12px); border-color: var(--gold);
            box-shadow: var(--shadow-gold);
        }
        .service-icon {
            width: 76px; height: 76px; border-radius: 22px;
            background: linear-gradient(135deg, rgba(212, 163, 115, 0.15), rgba(212, 163, 115, 0.05));
            border: 1px solid rgba(212, 163, 115, 0.2);
            color: var(--gold); font-size: 32px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            transition: all 0.4s;
        }
        .service-card:hover .service-icon {
            background: var(--gold-gradient); color: #fff;
            border-color: transparent; transform: scale(1.1) rotate(-6deg);
            box-shadow: 0 15px 35px rgba(212, 163, 115, 0.4);
        }
        .service-card h3 { font-size: 19px; margin-bottom: 10px; position: relative; z-index: 1; }
        .service-card p { color: var(--text-muted); font-size: 14px; margin-bottom: 20px; position: relative; z-index: 1; line-height: 1.8; }
        .service-links { display: flex; justify-content: center; gap: 18px; position: relative; z-index: 1; }
        .service-links a {
            font-size: 13px; font-weight: 600; color: var(--gold);
            padding: 6px 16px; border-radius: 30px;
            border: 1px solid rgba(212, 163, 115, 0.3);
            transition: all 0.3s;
        }
        .service-links a:hover {
            background: var(--gold-gradient); color: #fff;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.3);
        }

        /* ===== FAQ ===== */
        .faq-list { max-width: 820px; margin: 0 auto; }
        .faq-item {
            border-bottom: 1px solid var(--border); padding: 6px 0;
            transition: all 0.3s ease;
        }
        .faq-item:first-child { border-top: 1px solid var(--border); }
        .faq-question {
            display: flex; justify-content: space-between; align-items: center;
            padding: 22px 10px; cursor: pointer; font-weight: 600; font-size: 17px;
            color: var(--text); transition: color 0.3s ease; user-select: none;
            gap: 16px;
        }
        .faq-question:hover { color: var(--gold); }
        .faq-question i {
            transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            font-size: 16px; color: var(--gold);
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(212, 163, 115, 0.1);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .faq-item.active .faq-question i { transform: rotate(180deg); background: var(--gold-gradient); color: #fff; }
        .faq-answer {
            max-height: 0; overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.23, 1, 0.32, 1), padding 0.3s ease;
            padding: 0 10px; color: var(--text-muted); font-size: 15px; line-height: 1.9;
        }
        .faq-item.active .faq-answer { max-height: 300px; padding: 0 10px 24px; }

        /* ===== BLOG ===== */
        .blog-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;
        }
        .blog-card {
            background: var(--bg-card); border-radius: var(--radius);
            overflow: hidden; border: 1px solid var(--border);
            transition: var(--transition); display: flex; flex-direction: column;
            position: relative;
        }
        .blog-card:hover {
            transform: translateY(-12px); box-shadow: var(--shadow-lg);
            border-color: var(--gold);
        }
        .blog-image {
            position: relative; height: 230px; overflow: hidden;
            background-size: cover; background-position: center;
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .blog-image::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(10, 22, 40, 0.5) 100%);
            opacity: 0; transition: opacity 0.4s;
        }
        .blog-card:hover .blog-image { transform: scale(1.08); }
        .blog-card:hover .blog-image::after { opacity: 1; }
        .blog-badge {
            position: absolute; top: 16px; right: 16px;
            z-index: 2; font-size: 11px; padding: 6px 16px;
        }
        .blog-content { padding: 26px; text-align: center; flex: 1; display: flex; flex-direction: column; position: relative; z-index: 1; }
        .blog-content h3 {
            font-size: 19px; margin-bottom: 12px; transition: color 0.3s;
            line-height: 1.45; font-weight: 700;
        }
        .blog-card:hover .blog-content h3 { color: var(--gold); }
        .blog-content p {
            color: var(--text-muted); font-size: 14px;
            margin-bottom: 18px; flex: 1; line-height: 1.9;
        }
        .blog-footer { text-align: center; margin-top: 50px; }
        .gold-link {
            color: var(--gold); font-weight: 600; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 14px;
        }
        .gold-link:hover { color: var(--gold-dark); gap: 12px; }
        .gold-link i { transition: transform 0.3s; }
        .gold-link:hover i { transform: translateX(-4px); }

        /* ===== NEWSLETTER ===== */
        .newsletter-box {
            background: linear-gradient(135deg, var(--bg-card), var(--bg-body));
            border-radius: var(--radius); padding: 70px 60px;
            text-align: center; border: 1px solid var(--border);
            box-shadow: var(--shadow); max-width: 780px; margin: 0 auto;
            position: relative; overflow: hidden;
        }
        .newsletter-box::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 30% 40%, rgba(212, 163, 115, 0.06), transparent 60%);
            pointer-events: none;
        }
        .newsletter-box::after {
            content: ''; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(212, 163, 115, 0.04), transparent 30%);
            animation: rotateGradient 20s linear infinite; pointer-events: none;
        }
        @keyframes rotateGradient { to { transform: rotate(360deg); } }
        .newsletter-icon {
            width: 80px; height: 80px; border-radius: 24px;
            background: var(--gold-gradient); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 34px; margin: 0 auto 24px;
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.35);
            position: relative; z-index: 1;
        }
        .newsletter-box h3 {
            font-size: 32px; font-weight: 800; margin-bottom: 12px;
            position: relative; z-index: 1; line-height: 1.3;
        }
        .newsletter-box p {
            color: var(--text-muted); font-size: 16px;
            margin-bottom: 32px; position: relative; z-index: 1;
            max-width: 500px; margin-left: auto; margin-right: auto;
        }
        .newsletter-form {
            display: flex; gap: 12px; max-width: 520px;
            margin: 0 auto; position: relative; z-index: 1;
        }
        .newsletter-form input {
            flex: 1; padding: 16px 24px;
            border: 2px solid var(--border); border-radius: 60px;
            font-size: 14px; font-family: var(--font);
            background: var(--bg-body); transition: all 0.3s ease;
            outline: none; color: var(--text);
        }
        .newsletter-form input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 5px rgba(212, 163, 115, 0.12);
        }
        .newsletter-form input::placeholder { color: var(--text-muted); }
        .newsletter-form .btn { flex-shrink: 0; padding: 16px 34px; }

        /* ===== STATS ===== */
        .stats {
            background: var(--navy-gradient); color: #fff;
            padding: 80px 0; position: relative; overflow: hidden;
        }
        .stats::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 20% 50%, rgba(212, 163, 115, 0.08), transparent 50%);
        }
        .stats::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 80% 50%, rgba(212, 163, 115, 0.05), transparent 50%);
        }
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 24px; text-align: center; position: relative; z-index: 1;
        }
        .stat-item {
            transition: transform 0.4s; padding: 20px;
            border-radius: var(--radius-sm);
            position: relative;
        }
        .stat-item::before {
            content: ''; position: absolute; inset: 0;
            background: rgba(212, 163, 115, 0.03);
            border-radius: var(--radius-sm); border: 1px solid rgba(212, 163, 115, 0.1);
            opacity: 0; transition: opacity 0.4s;
        }
        .stat-item:hover::before { opacity: 1; }
        .stat-item:hover { transform: translateY(-8px); }
        .stat-number {
            font-size: 56px; font-weight: 900; display: block;
            background: var(--gold-gradient);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; line-height: 1.1; position: relative;
        }
        .stat-label { font-size: 15px; opacity: 0.8; margin-top: 8px; position: relative; }

        /* ===== TESTIMONIALS ===== */
        .testimonials-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;
        }
        .testimonial-card {
            background: var(--bg-card); border-radius: var(--radius);
            padding: 36px 30px; border: 1px solid var(--border);
            box-shadow: var(--shadow); transition: var(--transition);
            text-align: center; position: relative; overflow: hidden;
        }
        .testimonial-card::before {
            content: '"'; position: absolute; top: 8px; right: 24px;
            font-size: 120px; color: rgba(212, 163, 115, 0.07);
            font-family: Georgia, serif; line-height: 1;
            transition: all 0.5s;
        }
        .testimonial-card:hover::before { color: rgba(212, 163, 115, 0.15); transform: scale(1.1); }
        .testimonial-card:hover {
            transform: translateY(-10px); border-color: var(--gold);
            box-shadow: var(--shadow-gold);
        }
        .testimonial-stars { color: var(--gold); margin-bottom: 16px; position: relative; z-index: 1; }
        .testimonial-stars i { margin: 0 2px; font-size: 14px; }
        .testimonial-card p {
            font-size: 15px; margin-bottom: 24px;
            color: var(--text-muted); position: relative; z-index: 1;
            line-height: 2; font-style: italic;
        }
        .testimonial-author {
            display: flex; align-items: center; gap: 14px;
            justify-content: center; position: relative; z-index: 1;
        }
        .testimonial-author img {
            width: 54px; height: 54px; border-radius: 50%;
            object-fit: cover; border: 2px solid var(--gold);
            box-shadow: 0 0 0 4px rgba(212, 163, 115, 0.1);
        }
        .testimonial-author strong { display: block; font-size: 15px; }
        .testimonial-author span { font-size: 13px; color: var(--text-muted); }

        /* ===== CONTACT ===== */
        .contact-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 60px; align-items: start; }
        .contact-info { text-align: center; }
        .contact-item {
            display: flex; gap: 16px; margin-bottom: 18px;
            justify-content: flex-start; align-items: center;
            padding: 20px; border-radius: var(--radius-sm);
            transition: all 0.3s; text-align: right;
            border: 1px solid transparent;
        }
        .contact-item:hover {
            background: rgba(212, 163, 115, 0.05);
            border-color: rgba(212, 163, 115, 0.15);
            transform: translateX(-6px);
        }
        .contact-item i {
            font-size: 20px; color: var(--gold);
            width: 54px; height: 54px; border-radius: 16px;
            background: rgba(212, 163, 115, 0.1);
            border: 1px solid rgba(212, 163, 115, 0.2);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: all 0.3s;
        }
        .contact-item:hover i {
            background: var(--gold-gradient); color: #fff;
            border-color: transparent;
            box-shadow: 0 10px 25px rgba(212, 163, 115, 0.3);
        }
        .contact-item h4 { font-size: 15px; font-weight: 700; margin-bottom: 2px; }
        .contact-item p { color: var(--text-muted); font-size: 14px; line-height: 1.6; }

        .contact-form {
            background: var(--bg-card); padding: 40px;
            border-radius: var(--radius); border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .contact-form .form-group { margin-bottom: 22px; }
        .contact-form label {
            display: block; font-weight: 600; margin-bottom: 8px;
            font-size: 14px; text-align: right; color: var(--text);
        }
        .contact-form input, .contact-form textarea {
            width: 100%; padding: 15px 20px;
            border: 2px solid var(--border); border-radius: var(--radius-sm);
            background: var(--bg-body); color: var(--text);
            font-family: inherit; font-size: 14px; transition: var(--transition);
            text-align: right; outline: none;
        }
        .contact-form input:focus, .contact-form textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 5px rgba(212, 163, 115, 0.1);
        }
        .contact-form .btn { display: block; margin: 8px auto 0; }

        /* ===== CTA ===== */
        .cta {
            background: var(--navy-gradient); color: #fff;
            padding: 120px 0; text-align: center;
            position: relative; overflow: hidden;
            border-top: 2px solid var(--gold);
        }
        .cta::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 20% 50%, rgba(212, 163, 115, 0.08), transparent 60%);
        }
        .cta::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 80% 50%, rgba(212, 163, 115, 0.06), transparent 60%);
        }
        .cta .container { position: relative; z-index: 1; }
        .cta .section-title {
            color: #fff; font-size: 46px; font-weight: 800;
            margin-bottom: 18px; line-height: 1.3; letter-spacing: -0.5px;
        }
        .cta .section-subtitle {
            color: rgba(255, 255, 255, 0.5); margin: 0 auto 44px;
            max-width: 600px; font-size: 16px;
        }
        .cta .btn-group {
            display: flex; gap: 20px; justify-content: center;
            flex-wrap: wrap;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--deep-navy); color: #c8c8d4;
            padding: 80px 0 24px; margin-top: 0;
            border-top: 2px solid var(--gold);
            position: relative; overflow: hidden;
        }
        .footer::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.4;
        }
        [data-theme="light"] .footer { background: var(--deep-navy); }
        .footer-grid {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1.2fr;
            gap: 48px; padding-bottom: 48px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-align: center;
        }
        .footer-brand .logo { justify-content: center; margin-bottom: 16px; }
        .footer-brand p {
            font-size: 14px; max-width: 320px; margin: 0 auto 20px;
            color: rgba(255, 255, 255, 0.5); line-height: 1.9;
        }
        .footer-social { display: flex; gap: 12px; justify-content: center; }
        .footer-social a {
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            display: flex; align-items: center; justify-content: center;
            color: #c8c8d4; transition: var(--transition);
        }
        .footer-social a:hover {
            background: var(--gold-gradient); color: #fff;
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(212, 163, 115, 0.4);
            border-color: transparent;
        }
        .footer-links h4, .footer-contact h4, .footer-trust h4 {
            color: #fff; font-size: 16px; margin-bottom: 22px;
            position: relative; display: inline-block; font-weight: 700;
        }
        .footer-links h4::after, .footer-contact h4::after, .footer-trust h4::after {
            content: ''; position: absolute; bottom: -8px; right: 50%;
            transform: translateX(50%); width: 36px; height: 2px;
            background: var(--gold-gradient); border-radius: 2px;
        }
        .footer-links ul, .footer-contact ul {
            display: flex; flex-direction: column; gap: 14px; align-items: center;
        }
        .footer-links a, .footer-contact li {
            font-size: 14px; color: #94a3b8; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .footer-links a:hover { color: var(--gold); transform: translateX(-4px); }
        .footer-contact li { display: flex; align-items: center; gap: 10px; }
        .footer-contact li i { color: var(--gold); width: 18px; }
        .trust-icons { display: flex; gap: 14px; flex-wrap: wrap; justify-content: center; }
        .trust-icons span {
            background: rgba(255, 255, 255, 0.04);
            padding: 12px 20px; border-radius: 12px;
            font-size: 13px; color: #94a3b8;
            transition: all 0.3s; border: 1px solid rgba(255,255,255,0.05);
        }
        .trust-icons span:hover {
            background: rgba(212, 163, 115, 0.1);
            color: var(--gold); border-color: rgba(212, 163, 115, 0.25);
            transform: translateY(-3px);
        }
        .footer-bottom {
            text-align: center; padding-top: 28px;
            font-size: 14px; color: #64748b;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(10, 22, 40, 0.88);
            backdrop-filter: blur(20px); z-index: 9999;
            display: none; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.4s;
            padding: 20px;
        }
        .modal-overlay.active { display: flex; opacity: 1; }
        .modal {
            background: var(--bg-card); border-radius: 28px;
            padding: 44px 40px; max-width: 480px; width: 100%;
            border: 1px solid var(--gold);
            box-shadow: 0 0 60px rgba(212, 163, 115, 0.2);
            position: relative;
            transform: scale(0.9) translateY(30px);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-overlay.active .modal { transform: scale(1) translateY(0); }
        .modal-close {
            position: absolute; top: 16px; left: 20px;
            background: none; border: none; font-size: 22px;
            color: var(--text-muted); cursor: pointer;
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: 0.3s;
        }
        .modal-close:hover {
            color: var(--gold); background: rgba(212, 163, 115, 0.1);
            transform: rotate(90deg);
        }
        .modal-title {
            text-align: center; margin-bottom: 8px;
            font-size: 24px; font-weight: 800;
        }
        .modal-subtitle {
            text-align: center; color: var(--text-muted);
            font-size: 14px; margin-bottom: 28px;
        }
        .modal-form .form-group { margin-bottom: 20px; }
        .modal-form label {
            display: block; font-weight: 600; font-size: 13px;
            color: var(--text-muted); margin-bottom: 8px;
        }
        .modal-form input {
            width: 100%; padding: 14px 18px;
            border: 2px solid var(--border); border-radius: 14px;
            background: var(--bg-body); color: var(--text);
            font-family: var(--font); font-size: 14px;
            transition: all 0.4s; outline: none;
        }
        .modal-form input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 5px rgba(212, 163, 115, 0.12);
        }
        .modal-form input[dir="ltr"] {
            text-align: left;
            letter-spacing: 4px;
            font-weight: 700;
            font-size: 18px;
        }
        .modal-form .btn { width: 100%; background: var(--gold-gradient); border-color: transparent; margin-top: 6px; }

        /* ===== BOT-START BLOCK ===== */
        .bot-start-block {
            text-align: center;
            padding: 10px 0;
        }
        .bot-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: linear-gradient(135deg, #2AABEE, #229ED9);
            color: #fff; font-size: 36px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 15px 40px rgba(42, 171, 238, 0.35);
            animation: botPulse 2s ease-in-out infinite;
        }
        @keyframes botPulse {
            0%, 100% { transform: scale(1); box-shadow: 0 15px 40px rgba(42, 171, 238, 0.35); }
            50% { transform: scale(1.05); box-shadow: 0 20px 55px rgba(42, 171, 238, 0.5); }
        }
        .bot-start-btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 10px; width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #2AABEE, #229ED9);
            color: #fff; border-radius: 14px;
            font-weight: 700; font-size: 15px;
            transition: all 0.3s; margin-bottom: 12px;
            box-shadow: 0 10px 30px rgba(42, 171, 238, 0.3);
            border: none; cursor: pointer; text-decoration: none;
            font-family: var(--font);
        }
        .bot-start-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(42, 171, 238, 0.5);
        }
        .otp-inputs {
            display: flex; justify-content: center; gap: 10px;
            direction: ltr; margin: 20px 0;
        }
        .otp-inputs input {
            width: 50px; height: 60px;
            text-align: center; font-size: 24px; font-weight: 800;
            border: 2px solid var(--border); border-radius: 14px;
            background: var(--bg-body); color: var(--text);
            transition: all 0.3s; outline: none;
            font-family: var(--font);
            padding: 0;
        }
        .otp-inputs input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 5px rgba(212, 163, 115, 0.15);
            transform: scale(1.08);
        }
        .otp-inputs input.filled {
            border-color: var(--gold);
            background: rgba(212, 163, 115, 0.08);
        }
        .otp-timer {
            text-align: center; color: var(--text-muted);
            font-size: 13px; margin-top: 12px;
        }
        .otp-timer span {
            color: var(--gold);
            font-weight: 700;
            font-family: monospace;
            direction: ltr;
            display: inline-block;
        }
        .otp-resend {
            display: block; width: 100%; margin-top: 10px;
            background: none; border: none; color: var(--text-muted);
            font-family: var(--font); font-size: 13px; cursor: pointer;
            transition: color 0.3s; text-align: center; padding: 6px;
        }
        .otp-resend:hover:not(:disabled) { color: var(--gold); }
        .otp-resend:disabled { opacity: 0.4; cursor: not-allowed; }

        .alert-box {
            padding: 12px 16px; border-radius: 12px; font-size: 13px;
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 18px; line-height: 1.7;
        }
        .alert-info {
            background: rgba(96, 165, 250, 0.1);
            border: 1px solid rgba(96, 165, 250, 0.25);
            color: #60a5fa;
        }
        .alert-error {
            background: rgba(244, 63, 94, 0.1);
            border: 1px solid rgba(244, 63, 94, 0.25);
            color: #fb7185;
        }
        .alert-success {
            background: rgba(52, 211, 153, 0.1);
            border: 1px solid rgba(52, 211, 153, 0.25);
            color: #34d399;
        }
        .alert-box i { margin-top: 3px; }

        /* ===== PROFILE MODAL ===== */
        .profile-modal {
            max-width: 560px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }
        .profile-avatar-wrap {
            position: relative;
            display: inline-block;
            margin-bottom: 16px;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.35);
            border: 4px solid var(--bg-card);
        }
        .profile-avatar-edit {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #fff;
            border: 3px solid var(--bg-card);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.3s;
        }
        .profile-avatar-edit:hover {
            transform: scale(1.15) rotate(15deg);
        }
        .profile-header h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .profile-header .phone-text {
            font-size: 13px;
            color: var(--text-muted);
            direction: ltr;
        }

        .profile-form .form-group { margin-bottom: 18px; }
        .profile-form label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .profile-form label i {
            color: var(--gold);
            font-size: 12px;
        }
        .profile-form input,
        .profile-form textarea {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--bg-body);
            color: var(--text);
            font-family: var(--font);
            font-size: 14px;
            transition: all 0.4s;
            outline: none;
            resize: none;
        }
        .profile-form input:focus,
        .profile-form textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 5px rgba(212, 163, 115, 0.1);
        }

        /* ===== TOAST NOTIFICATION ===== */
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
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
            min-width: 300px;
            max-width: 420px;
            animation: toastIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }
        .toast-item.hiding {
            animation: toastOut 0.4s ease forwards;
        }
        .toast-item i {
            font-size: 20px;
            flex-shrink: 0;
        }
        .toast-success { border-color: #34d399; }
        .toast-success i { color: #34d399; }
        .toast-error { border-color: #fb7185; }
        .toast-error i { color: #fb7185; }
        .toast-info { border-color: #60a5fa; }
        .toast-info i { color: #60a5fa; }
        .toast-warning { border-color: #fbbf24; }
        .toast-warning i { color: #fbbf24; }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(-100px) scale(0.85);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }
        @keyframes toastOut {
            to {
                opacity: 0;
                transform: translateX(-100px) scale(0.85);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            #particleSphere {
                position: relative; top: auto; left: auto;
                transform: none; width: 100%; height: 400px;
                margin-top: 20px;
                animation: fadeInSphere 2s ease forwards; animation-delay: 0.5s;
            }
        }
        @media (max-width: 992px) {
            .blog-grid, .testimonials-grid { grid-template-columns: 1fr 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
            .section { padding: 80px 0; }
            .section-header h2 { font-size: 34px; }
            .about-highlights { grid-template-columns: 1fr; }
            .contact-grid { grid-template-columns: 1fr; gap: 40px; }
        }
        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .hero-slide { height: 500px; }
            .hero-content { margin-right: 0; padding-right: 20px; }
            .hero-content h1 { font-size: 34px; }
            .hero-content p { font-size: 16px; }
            .services-grid { grid-template-columns: 1fr 1fr; }
            .blog-grid, .testimonials-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .footer-grid { grid-template-columns: 1fr; gap: 36px; }
            .newsletter-form { flex-direction: column; }
            .newsletter-form .btn { width: 100%; justify-content: center; }
            .swiper-button-next, .swiper-button-prev { display: none !important; }
            .swiper-pagination-bullet { width: 8px !important; height: 8px !important; }
            .swiper-pagination-bullet-active { width: 22px !important; }
            #particleSphere { height: 300px; }
            .loader-logo { width: 80px; height: 80px; font-size: 32px; border-radius: 24px; }
            .loader-spinner { width: 50px; height: 50px; }
            .loader-text { font-size: 12px; letter-spacing: 4px; }
            .loader-progress { width: 160px; }
            .section-header h2 { font-size: 26px; }
            .cta .section-title { font-size: 28px; }
            .stat-number { font-size: 40px; }
            .newsletter-box { padding: 44px 24px; }
            .newsletter-box h3 { font-size: 24px; }
            .contact-form { padding: 28px 20px; }
            .modal { padding: 32px 24px; border-radius: 22px; }
            .section-header { margin-bottom: 50px; }
            .dropdown-menu { left: auto; right: 0; }
            .otp-inputs input { width: 42px; height: 52px; font-size: 20px; }
            .toast-container { left: 15px; right: 15px; bottom: 15px; }
            .toast-item { min-width: auto; }
        }
        @media (max-width: 480px) {
            .hero-slide { height: 420px; }
            .hero-content h1 { font-size: 26px; }
            .hero-content p { font-size: 14px; }
            .hero-content .hero-tag { font-size: 10px; padding: 6px 14px; }
            .services-grid { grid-template-columns: 1fr; }
            #particleSphere { height: 220px; }
            .loader-logo { width: 64px; height: 64px; font-size: 26px; border-radius: 18px; }
            .loader-spinner { width: 40px; height: 40px; }
            .loader-text { font-size: 11px; letter-spacing: 3px; }
            .loader-progress { width: 130px; }
            .stats-grid { grid-template-columns: 1fr; }
            .container { padding: 0 16px; }
            .btn { padding: 12px 26px; font-size: 13px; }
            .service-card { padding: 30px 20px; }
            .otp-inputs { gap: 6px; }
            .otp-inputs input { width: 38px; height: 48px; font-size: 18px; }
        }
    </style>
</head>
<body>

    <!-- ============================================================
    LOADING SCREEN
    ============================================================ -->
    <div id="loadingScreen">
        <div class="loader-particles">
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
        </div>
        <div class="loader-wrapper">
            <div class="loader-logo"><span>G</span></div>
            <div class="loader-spinner"></div>
            <div class="loader-text">GRAFIUM</div>
            <div class="loader-progress">
                <div class="loader-progress-bar" id="progressBar"></div>
            </div>
        </div>
    </div>

    <div id="mainContent">
        
@include('partials.header')
        <!-- ============================================================
        AUTH MODAL (OTP)
        ============================================================ -->
        <div class="modal-overlay" id="modalOverlay">
            <div class="modal">
                <button class="modal-close" id="modalClose"><i class="fas fa-times"></i></button>

                {{-- ===== مرحله ۱: وارد کردن شماره ===== --}}
                <div id="stepPhone">
                    <h3 class="modal-title">ورود / ثبت‌نام</h3>
                    <p class="modal-subtitle">شماره موبایل خود را وارد کنید</p>

                    <form class="modal-form" id="phoneForm" onsubmit="event.preventDefault();">
                        <div class="form-group">
                            <label for="phoneInput">شماره موبایل</label>
                            <input type="tel" id="phoneInput" placeholder="09123456789" dir="ltr" maxlength="11" autocomplete="tel" />
                        </div>
                        <div id="phoneError" class="alert-box alert-error" style="display:none;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span id="phoneErrorText"></span>
                        </div>
                        <button type="submit" class="btn btn-gold" id="sendOtpBtn">
                            <span>ارسال کد</span>
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </form>
                </div>

                {{-- ===== مرحله ۲: استارت بازو ===== --}}
                <div id="stepBotStart" style="display:none;">
                    <div class="bot-start-block">
                        <div class="bot-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h3 class="modal-title">استارت بازوی بله</h3>
                        <p class="modal-subtitle">
                            برای دریافت کد ورود، لطفاً ابتدا بازوی ما را در پیام‌رسان بله استارت کنید.
                        </p>

                        <a href="https://ble.ir/GRAFIUM_bot" target="_blank" rel="noopener" class="bot-start-btn" id="botLinkBtn">
                            <i class="fas fa-paper-plane"></i>
                            <span>رفتن به بازوی GRAFIUM</span>
                        </a>

                        <div class="alert-box alert-info" style="text-align:right;">
                            <i class="fas fa-info-circle"></i>
                            <span>پس از استارت بازو، به این صفحه برگردید و دوباره روی دکمه زیر کلیک کنید.</span>
                        </div>

                        <button type="button" class="btn btn-gold" id="retrySendOtp" style="width:100%;">
                            <span>استارت کردم، دوباره تلاش کن</span>
                            <i class="fas fa-redo"></i>
                        </button>
                        <button type="button" class="btn-link" id="backToPhoneFromBot">ویرایش شماره</button>
                    </div>
                </div>

                {{-- ===== مرحله ۳: وارد کردن کد OTP ===== --}}
                <div id="stepCode" style="display:none;">
                    <h3 class="modal-title">کد تایید</h3>
                    <p class="modal-subtitle">
                        کد ۶ رقمی ارسال شده به بله را وارد کنید
                    </p>

                    <div id="codeError" class="alert-box alert-error" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span id="codeErrorText"></span>
                    </div>

                    <div id="codeSuccess" class="alert-box alert-success" style="display:none;">
                        <i class="fas fa-check-circle"></i>
                        <span id="codeSuccessText"></span>
                    </div>

                    <div class="otp-inputs" id="otpInputs">
                        <input type="text" inputmode="numeric" maxlength="1" data-index="0" />
                        <input type="text" inputmode="numeric" maxlength="1" data-index="1" />
                        <input type="text" inputmode="numeric" maxlength="1" data-index="2" />
                        <input type="text" inputmode="numeric" maxlength="1" data-index="3" />
                        <input type="text" inputmode="numeric" maxlength="1" data-index="4" />
                        <input type="text" inputmode="numeric" maxlength="1" data-index="5" />
                    </div>

                    <button type="button" class="btn btn-gold" id="verifyOtpBtn" style="width:100%;">
                        <span>تایید و ورود</span>
                        <i class="fas fa-check"></i>
                    </button>

                    <p class="otp-timer">
                        ارسال مجدد تا <span id="timer">۰۲:۰۰</span>
                    </p>
                    <button type="button" class="otp-resend" id="resendOtp" disabled>
                        <i class="fas fa-redo"></i> ارسال مجدد کد
                    </button>
                    <button type="button" class="btn-link" id="backToPhoneFromCode">ویرایش شماره</button>
                </div>

            </div>
        </div>

        {{-- ============================================================
        PROFILE EDIT MODAL
        ============================================================ --}}
        @auth
        <div class="modal-overlay" id="profileModalOverlay">
            <div class="modal profile-modal">
                <button class="modal-close" id="profileModalClose"><i class="fas fa-times"></i></button>

                <div class="profile-header">
                    <div class="profile-avatar-wrap">
                        <div class="profile-avatar" id="profileAvatarPreview">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->display_name }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                    </div>
                    <h3>{{ auth()->user()->display_name }}</h3>
                    <span class="phone-text">{{ auth()->user()->phone }}</span>
                </div>

                <form class="profile-form" id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="profileName"><i class="fas fa-user"></i> نام و نام خانوادگی</label>
                        <input type="text" id="profileName" name="name" value="{{ auth()->user()->name }}" placeholder="نام خود را وارد کنید" required />
                    </div>

                    <div class="form-group">
                        <label for="profileEmail"><i class="fas fa-envelope"></i> ایمیل (اختیاری)</label>
                        <input type="email" id="profileEmail" name="email" value="{{ auth()->user()->email }}" placeholder="example@email.com" dir="ltr" />
                    </div>

                    <div class="form-group">
                        <label for="profilePhone"><i class="fas fa-phone"></i> شماره موبایل</label>
                        <input type="tel" id="profilePhone" value="{{ auth()->user()->phone }}" dir="ltr" disabled style="opacity:0.6;cursor:not-allowed;" />
                    </div>

                    <div class="form-group">
                        <label for="profileAddress"><i class="fas fa-map-marker-alt"></i> آدرس (اختیاری)</label>
                        <textarea id="profileAddress" name="address" rows="2" placeholder="آدرس خود را وارد کنید">{{ auth()->user()->address }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-gold" style="width:100%;">
                        <span>ذخیره تغییرات</span>
                        <i class="fas fa-save"></i>
                    </button>
                </form>
            </div>
        </div>
        @endauth

        <!-- ===== HERO SLIDER ===== -->
        <section class="hero-slider" id="home">
            <div class="swiper heroSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&h=900&fit=crop');">
                        <div class="hero-overlay"></div>
                        <div class="container hero-content">
                            <div class="hero-tag"><i class="fas fa-star"></i><span>سالن کار اشتراکی گرافیکی</span></div>
                            <h1>اولین سالن کار<span class="gold-line">اشتراکی گرافیکی</span></h1>
                            <p>فضایی برای خلاقیت، هم‌افزایی و رشد حرفه‌ای؛ جایی که ایده‌ها به واقعیت تبدیل می‌شوند.</p>
                            <a href="{{ route('services') }}" class="btn btn-gold"><span>مشاهده خدمات</span> <i class="fas fa-arrow-left"></i></a>
                        </div>
                    </div>
                    <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=1600&h=900&fit=crop');">
                        <div class="hero-overlay"></div>
                        <div class="container hero-content">
                            <div class="hero-tag"><i class="fas fa-microchip"></i><span>قدرت پردازش حرفه‌ای</span></div>
                            <h1>سیستم‌های قدرتمند<span class="gold-line">در دسترس شما</span></h1>
                            <p>اجاره سیستم‌های گران‌قیمت برای اجرای پروژه‌های سنگین گرافیکی، بدون نگرانی از هزینه تجهیزات.</p>
                            <a href="{{ route('services') }}" class="btn btn-gold"><span>مشاهده خدمات</span> <i class="fas fa-arrow-left"></i></a>
                        </div>
                    </div>
                    <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=1600&h=900&fit=crop');">
                        <div class="hero-overlay"></div>
                        <div class="container hero-content">
                            <div class="hero-tag"><i class="fas fa-users"></i><span>جامعه خلاقان</span></div>
                            <h1>جامعه‌ای از<span class="gold-line">هنرمندان و طراحان</span></h1>
                            <p>همکاری، تبادل ایده و رشد در کنار بهترین‌های صنعت گرافیک و طراحی دیجیتال.</p>
                            <a href="#contact" class="btn btn-gold"><span>تماس با ما</span> <i class="fas fa-arrow-left"></i></a>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <canvas id="particleSphere"></canvas>
        </section>

        <!-- ===== TRUST BAR ===== -->
        <section class="trust-bar">
            <div class="container" style="overflow:hidden;">
                <div class="trust-track">
                    <span class="trust-item"><i class="fas fa-check-circle"></i> ۱۰۰+ عضو فعال</span>
                    <span class="trust-item"><i class="fas fa-star"></i> ۹۸٪ رضایت</span>
                    <span class="trust-item"><i class="fas fa-wifi"></i> اینترنت پرسرعت</span>
                    <span class="trust-item"><i class="fas fa-coffee"></i> نوشیدنی رایگان</span>
                    <span class="trust-item"><i class="fas fa-clock"></i> دسترسی ۲۴/۷</span>
                    <span class="trust-item"><i class="fas fa-print"></i> چاپ حرفه‌ای</span>
                    <span class="trust-item"><i class="fas fa-check-circle"></i> ۱۰۰+ عضو فعال</span>
                    <span class="trust-item"><i class="fas fa-star"></i> ۹۸٪ رضایت</span>
                    <span class="trust-item"><i class="fas fa-wifi"></i> اینترنت پرسرعت</span>
                    <span class="trust-item"><i class="fas fa-coffee"></i> نوشیدنی رایگان</span>
                    <span class="trust-item"><i class="fas fa-clock"></i> دسترسی ۲۴/۷</span>
                    <span class="trust-item"><i class="fas fa-print"></i> چاپ حرفه‌ای</span>
                </div>
            </div>
        </section>

        <!-- ===== ABOUT ===== -->
        <section class="section about" id="about">
            <div class="container">
                <div class="section-header">
                    <span class="gradient-badge"><i class="fas fa-info-circle"></i><span>درباره ما</span></span>
                    <h2 class="purple-text">چرا <span class="gold-text">GRAFIUM</span>؟</h2>
                    <p>ما اولین سالن کار اشتراکی گرافیکی در شهر هستیم. فضایی که در آن طراحان، هنرمندان و علاقه‌مندان به گرافیک می‌توانند با اجاره سیستم‌های قدرتمند، پروژه‌های خود را بدون محدودیت اجرا کنند.</p>
                    <p>از میزهای کار ارگونومیک تا سیستم‌های i9 و کارت‌های گرافیک حرفه‌ای، همه چیز برای خلق آثار بی‌نظیر فراهم است.</p>
                </div>
                <div class="about-highlights">
                    <div class="highlight-card">
                        <div class="highlight-icon"><i class="fas fa-bolt"></i></div>
                        <h3>سیستم‌های فوق‌قدرتمند</h3>
                        <p>پردازنده‌های i9 و کارت‌های گرافیک RTX برای پروژه‌های سنگین</p>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon"><i class="fas fa-handshake"></i></div>
                        <h3>جامعه همکاران</h3>
                        <p>شبکه‌ای از طراحان، هنرمندان و متخصصان خلاق</p>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon"><i class="fas fa-award"></i></div>
                        <h3>کیفیت تضمین‌شده</h3>
                        <p>تجهیزات مدرن، اینترنت پرسرعت و محیطی الهام‌بخش</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== SERVICES ===== -->
        <section class="section services" id="services">
            <div class="container">
                <div class="section-header">
                    <span class="gradient-badge"><i class="fas fa-th-large"></i><span>خدمات ما</span></span>
                    <h2 class="purple-text">چه خدمات ارائه می‌دهیم؟</h2>
                    <p>خدمات متنوع برای رفع نیازهای گرافیکی شما</p>
                </div>
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-desktop"></i></div>
                        <h3>اجاره سیستم</h3>
                        <p>سیستم‌های i9 و RTX</p>
                        <div class="service-links">
                            <a href="{{ route('services') }}">مشاهده</a>
                            <a href="{{ route('services') }}">رزرو</a>
                        </div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-couch"></i></div>
                        <h3>فضای کار اشتراکی</h3>
                        <p>میز ارگونومیک و اینترنت پرسرعت</p>
                        <div class="service-links">
                            <a href="{{ route('services') }}">مشاهده</a>
                            <a href="{{ route('services') }}">رزرو</a>
                        </div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-users"></i></div>
                        <h3>کارگاه‌های آموزشی</h3>
                        <p>دوره‌های فتوشاپ و ایلوستریتور</p>
                        <div class="service-links">
                            <a href="{{ route('services') }}">مشاهده</a>
                            <a href="{{ route('services') }}">رزرو</a>
                        </div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-print"></i></div>
                        <h3>چاپ و تکثیر</h3>
                        <p>چاپ با کیفیت بالا</p>
                        <div class="service-links">
                            <a href="{{ route('services') }}">مشاهده</a>
                            <a href="{{ route('services') }}">رزرو</a>
                        </div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-coffee"></i></div>
                        <h3>کافه &amp; استراحت</h3>
                        <p>فضایی آرام برای تبادل ایده</p>
                        <div class="service-links">
                            <a href="{{ route('services') }}">مشاهده</a>
                            <a href="{{ route('services') }}">رزرو</a>
                        </div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-video"></i></div>
                        <h3>تدوین و انیمیشن</h3>
                        <p>خدمات تدوین و موشن گرافیک</p>
                        <div class="service-links">
                            <a href="{{ route('services') }}">مشاهده</a>
                            <a href="{{ route('services') }}">رزرو</a>
                        </div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-paint-brush"></i></div>
                        <h3>طراحی گرافیک</h3>
                        <p>لوگو، پوستر و هویت بصری</p>
                        <div class="service-links">
                            <a href="{{ route('services') }}">مشاهده</a>
                            <a href="{{ route('services') }}">رزرو</a>
                        </div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-photo-video"></i></div>
                        <h3>عکاسی و نورپردازی</h3>
                        <p>استودیو با تجهیزات حرفه‌ای</p>
                        <div class="service-links">
                            <a href="{{ route('services') }}">مشاهده</a>
                            <a href="{{ route('services') }}">رزرو</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FAQ ===== -->
        <section class="section faq" id="faq">
            <div class="container">
                <div class="section-header">
                    <span class="gradient-badge"><i class="fas fa-question-circle"></i><span>سوالات متداول</span></span>
                    <h2 class="purple-text">سوالات متداول</h2>
                    <p>هر آنچه باید درباره گرافیوم بدانید.</p>
                </div>
                <div class="faq-list">
                    <div class="faq-item active">
                        <div class="faq-question"><span>گرافیوم چیست؟</span><i class="fas fa-chevron-down"></i></div>
                        <div class="faq-answer">گرافیوم یک فضای کار اشتراکی ممتاز است که به‌طور تخصصی برای طراحان گرافیک، هنرمندان و حرفه‌ای‌های خلاق طراحی شده است. ما محیطی حرفه‌ای و الهام‌بخش با امکانات مدرن ارائه می‌دهیم.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question"><span>چگونه می‌توانم میز رزرو کنم؟</span><i class="fas fa-chevron-down"></i></div>
                        <div class="faq-answer">شما می‌توانید میز را مستقیماً از طریق سیستم رزرو آنلاین ما رزرو کنید. کافی است میزهای موجود را مرور کنید، تاریخ و شیفت مورد نظر را انتخاب کرده و رزرو خود را تایید کنید. این فرآیند سریع و آسان است.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question"><span>ساعات کاری چگونه است؟</span><i class="fas fa-chevron-down"></i></div>
                        <div class="faq-answer">ساعات کاری ما از شنبه تا پنجشنبه، ۸ صبح تا ۹ شب است. اعضای طرح‌های حرفه‌ای و سازمانی از دسترسی ۲۴/۷ برخوردار هستند.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question"><span>آیا پارکینگ وجود دارد؟</span><i class="fas fa-chevron-down"></i></div>
                        <div class="faq-answer">بله، ما پارکینگ اختصاصی برای اعضای خود داریم. پارکینگ برای تمام اعضا در طول بازدید رایگان است.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question"><span>آیا می‌توانم اتاق جلسات را جداگانه رزرو کنم؟</span><i class="fas fa-chevron-down"></i></div>
                        <div class="faq-answer">بله، اتاق‌های جلسات حتی اگر عضو نباشید نیز قابل رزرو هستند. اعضای طرح‌های حرفه‌ای و سازمانی اعتبار اتاق جلسات را در طرح خود دریافت می‌کنند.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question"><span>چه روش‌های پرداختی را می‌پذیرید؟</span><i class="fas fa-chevron-down"></i></div>
                        <div class="faq-answer">ما تمام کارت‌های اعتباری اصلی، انتقالات بانکی و روش‌های پرداخت دیجیتال را می‌پذیریم. همچنین برنامه‌های پرداخت منعطف برای عضویت‌های بلندمدت ارائه می‌دهیم.</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== BLOG ===== -->
        <section class="section blog" id="blog">
            <div class="container">
                <div class="section-header">
                    <span class="gradient-badge"><i class="fas fa-newspaper"></i><span>اخبار و مقالات</span></span>
                    <h2 class="purple-text">آخرین مطالب</h2>
                    <p>جدیدترین اخبار و مقالات آموزشی را دنبال کنید</p>
                </div>
                <div class="blog-grid">
                    @forelse($latestPosts ?? [] as $post)
                        <article class="blog-card">
                            <div class="blog-image" style="background-image: url('{{ $post->media ? asset($post->media) : 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=600&h=400&fit=crop' }}');">
                                @if($post->category)
                                    <span class="blog-badge gradient-badge"><span>{{ $post->category->name }}</span></span>
                                @endif
                            </div>
                            <div class="blog-content">
                                <h3>{{ Str::limit($post->title, 55) }}</h3>
                                <p>{{ Str::limit($post->summary ?? strip_tags($post->text), 110) }}</p>
                                <a href="{{ route('blog.post', $post->id) }}" class="gold-link">ادامه مطلب <i class="fas fa-arrow-left"></i></a>
                            </div>
                        </article>
                    @empty
                        <article class="blog-card">
                            <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=600&h=400&fit=crop');">
                                <span class="blog-badge gradient-badge"><span>ویژه</span></span>
                            </div>
                            <div class="blog-content">
                                <h3>افتتاح رسمی GRAFIUM</h3>
                                <p>اولین سالن کار اشتراکی گرافیکی با حضور هنرمندان و طراحان برتر افتتاح شد.</p>
                                <a href="{{ route('blog') }}" class="gold-link">ادامه مطلب <i class="fas fa-arrow-left"></i></a>
                            </div>
                        </article>
                        <article class="blog-card">
                            <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1561070791-2526d30994b5?w=600&h=400&fit=crop');">
                                <span class="blog-badge gradient-badge"><span>پربازدید</span></span>
                            </div>
                            <div class="blog-content">
                                <h3>آموزش رایگان فتوشاپ</h3>
                                <p>دوره‌های آموزشی رایگان برای علاقه‌مندان به گرافیک و طراحی دیجیتال.</p>
                                <a href="{{ route('blog') }}" class="gold-link">ادامه مطلب <i class="fas fa-arrow-left"></i></a>
                            </div>
                        </article>
                        <article class="blog-card">
                            <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&h=400&fit=crop');">
                                <span class="blog-badge gradient-badge"><span>آخرین</span></span>
                            </div>
                            <div class="blog-content">
                                <h3>سیستم‌های جدید به GRAFIUM آمدند</h3>
                                <p>ارتقاء سیستم‌ها با جدیدترین پردازنده‌ها و کارت‌های گرافیک برای تجربه بهتر.</p>
                                <a href="{{ route('blog') }}" class="gold-link">ادامه مطلب <i class="fas fa-arrow-left"></i></a>
                            </div>
                        </article>
                    @endforelse
                </div>
                <div class="blog-footer">
                    <a href="{{ route('blog') }}" class="btn btn-gold-outline">
                        <span>مشاهده همه اخبار</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- ===== NEWSLETTER ===== -->
        <section class="section newsletter" id="newsletter">
            <div class="container">
                <div class="newsletter-box">
                    <div class="newsletter-icon"><i class="fas fa-envelope-open-text"></i></div>
                    <h3>در جریان <span class="gold-text">بمانید</span></h3>
                    <p>در خبرنامه ما عضو شوید و آخرین به‌روزرسانی‌ها، رویدادها و پیشنهادات را دریافت کنید.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); showToast('از ثبت‌نام شما متشکریم!', 'success');">
                        <input type="email" placeholder="آدرس ایمیل خود را وارد کنید" required />
                        <button type="submit" class="btn btn-gold"><span>عضویت</span> <i class="fas fa-arrow-left"></i></button>
                    </form>
                </div>
            </div>
        </section>

        <!-- ===== STATS ===== -->
        <section class="section stats">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item"><span class="stat-number" data-target="120">0</span><span class="stat-label">پروژه انجام شده</span></div>
                    <div class="stat-item"><span class="stat-number" data-target="85">0</span><span class="stat-label">طراح حرفه‌ای</span></div>
                    <div class="stat-item"><span class="stat-number" data-target="15">0</span><span class="stat-label">سیستم قدرتمند</span></div>
                    <div class="stat-item"><span class="stat-number" data-target="100">0</span><span class="stat-label">مشتری راضی</span></div>
                </div>
            </div>
        </section>

        <!-- ===== TESTIMONIALS ===== -->
        <section class="section testimonials">
            <div class="container">
                <div class="section-header">
                    <span class="gradient-badge"><i class="fas fa-comments"></i><span>نظرات مشتریان</span></span>
                    <h2 class="purple-text">آنها چه می‌گویند؟</h2>
                </div>
                <div class="testimonials-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p>“فضای فوق‌العاده، سیستم‌های قدرتمند و محیطی الهام‌بخش.”</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="کاربر" />
                            <div><strong>مهدی کریمی</strong><span>طراح گرافیک</span></div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p>“سیستم‌های باورنکردنی، اینترنت عالی و کافه‌ی دنج.”</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" alt="کاربر" />
                            <div><strong>سارا احمدی</strong><span>تصویرساز دیجیتال</span></div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p>“همکاری با GRAFIUM باعث شد پروژه‌های سنگینم را بدون نگرانی انجام بدم.”</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" alt="کاربر" />
                            <div><strong>رضا نوری</strong><span>انیماتور</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CONTACT ===== -->
        <section class="section contact" id="contact">
            <div class="container">
                <div class="section-header">
                    <span class="gradient-badge"><i class="fas fa-paper-plane"></i><span>تماس با ما</span></span>
                    <h2 class="purple-text">در ارتباط باشید</h2>
                    <p>ما همیشه آماده پاسخگویی به شما هستیم</p>
                </div>
                <div class="contact-grid">
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div><h4>آدرس</h4><p>خیابان اصلی، نبش خیابان دوم، پلاک ۱۲۳</p></div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div><h4>تلفن</h4><p>۰۲۱-۱۲۳۴-۵۶۷۸</p></div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div><h4>ایمیل</h4><p>info@grafium.ir</p></div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <div><h4>ساعت کاری</h4><p>شنبه تا پنجشنبه: ۹ صبح تا ۱۰ شب</p></div>
                        </div>
                    </div>
                    <form class="contact-form">
                        <div class="form-group"><label for="name">نام و نام خانوادگی</label><input type="text" id="name" placeholder="نام خود را وارد کنید" /></div>
                        <div class="form-group"><label for="email">ایمیل</label><input type="email" id="email" placeholder="ایمیل خود را وارد کنید" /></div>
                        <div class="form-group"><label for="message">پیام</label><textarea id="message" rows="5" placeholder="پیام خود را بنویسید..."></textarea></div>
                        <button type="submit" class="btn btn-gold"><span>ارسال پیام</span> <i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </section>

        <!-- ===== CTA ===== -->
        <section class="cta" id="cta">
            <div class="container">
                <span class="gradient-badge" style="background:rgba(212,163,115,0.15);color:var(--gold);"><i class="fas fa-rocket"></i><span>شروع کنید</span></span>
                <h2 class="section-title">فضای کاری <span class="gold-text">خود را امروز رزرو کنید</span></h2>
                <p class="section-subtitle">به جامعه طراحان حرفه‌ای بپیوندید و از امکانات ممتاز گرافیوم لذت ببرید.</p>
                <div class="btn-group">
                    <a href="{{ route('services') }}" class="btn btn-gold"><span>رزرو میز</span> <i class="fas fa-arrow-left"></i></a>
                    <a href="#contact" class="btn btn-white"><span>تماس با ما</span></a>
                </div>
            </div>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer class="footer">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-brand">
                        <a href="{{ route('home') }}" class="logo">
                            <img src="{{ asset('images/Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium Logo" class="logo-img" />
                        </a>
                        <p>اولین سالن کار اشتراکی گرافیکی در شهر؛ جایی که خلاقیت با فناوری ملاقات می‌کند.</p>
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
                    <p>&copy; {{ date('Y') }} تمامی حقوق برای <span class="gold-text">GRAFIUM</span> محفوظ است.</p>
                </div>
            </div>
        </footer>

    </div>

    <!-- ============================================================
    TOAST CONTAINER
    ============================================================ -->
    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // ============================================================
        // LOADING SCREEN
        // ============================================================
        (function() {
            const loadingScreen = document.getElementById('loadingScreen');
            const mainContent = document.getElementById('mainContent');
            const progressBar = document.getElementById('progressBar');
            const totalTime = 2900;
            const intervalTime = 50;
            let progress = 0;
            let elapsed = 0;

            const timer = setInterval(() => {
                elapsed += intervalTime;
                progress = Math.min((elapsed / totalTime) * 100, 100);
                progressBar.style.width = progress + '%';
                if (elapsed >= totalTime) {
                    clearInterval(timer);
                    loadingScreen.classList.add('hidden');
                    mainContent.classList.add('visible');
                }
            }, intervalTime);

            setTimeout(() => {
                if (!loadingScreen.classList.contains('hidden')) {
                    clearInterval(timer);
                    loadingScreen.classList.add('hidden');
                    mainContent.classList.add('visible');
                }
            }, 4000);
        })();

        // ============================================================
        // TOAST
        // ============================================================
        function showToast(message, type = 'info', duration = 4000) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            const toast = document.createElement('div');
            toast.className = `toast-item toast-${type}`;
            toast.innerHTML = `
                <i class="fas ${icons[type] || 'fa-info-circle'}"></i>
                <span>${message}</span>
            `;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 400);
            }, duration);
        }

        // ============================================================
        // SWIPER
        // ============================================================
        if (document.querySelector('.heroSwiper')) {
            const heroSwiper = new Swiper('.heroSwiper', {
                loop: true,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                autoplay: { delay: 2910, disableOnInteraction: false },
                speed: 1200,
                parallax: true,
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                on: {
                    init: function() {
                        animateSlide();
                        this.update();
                    },
                    slideChangeTransitionStart: function() {
                        document.querySelectorAll('.hero-content .hero-tag, .hero-content h1, .hero-content p, .hero-content .btn').forEach(el => {
                            el.classList.remove('animate-in');
                        });
                    },
                    slideChangeTransitionEnd: function() {
                        animateSlide();
                    }
                }
            });

            function animateSlide() {
                const activeSlide = document.querySelector('.swiper-slide-active');
                if (!activeSlide) return;
                const tag = activeSlide.querySelector('.hero-tag');
                const h1 = activeSlide.querySelector('h1');
                const p = activeSlide.querySelector('p');
                const btn = activeSlide.querySelector('.btn');
                if (tag) setTimeout(() => tag.classList.add('animate-in'), 100);
                if (h1) setTimeout(() => h1.classList.add('animate-in'), 300);
                if (p) setTimeout(() => p.classList.add('animate-in'), 500);
                if (btn) setTimeout(() => btn.classList.add('animate-in'), 700);
            }

            const progressBarSwiper = document.createElement('div');
            progressBarSwiper.className = 'swiper-progress-bar';
            progressBarSwiper.innerHTML = `<span class="swiper-progress-fill"></span>`;
            const heroSlider = document.querySelector('.hero-slider');
            if (heroSlider) heroSlider.appendChild(progressBarSwiper);

            heroSwiper.on('autoplayTimeLeft', function(s, time, progress) {
                const fill = progressBarSwiper.querySelector('.swiper-progress-fill');
                if (fill) fill.style.width = (1 - progress) * 100 + '%';
            });
        }

        // ============================================================
        // THEME TOGGLE
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
        themeToggle?.addEventListener('click', () => { darkMode = !darkMode; applyTheme(); });

        // ============================================================
        // MOBILE MENU
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
        // STATS COUNTER
        // ============================================================
        const statNumbers = document.querySelectorAll('.stat-number');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.dataset.target);
                    const el = entry.target;
                    let current = 0;
                    const increment = Math.ceil(target / 70);
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            el.textContent = target;
                            clearInterval(timer);
                        } else {
                            el.textContent = current;
                        }
                    }, 25);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        statNumbers.forEach(el => counterObserver.observe(el));

        // ============================================================
        // SMOOTH SCROLL
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
        // STICKY HEADER SHADOW
        // ============================================================
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (!header) return;
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.4)';
                header.style.padding = '6px 0';
            } else {
                header.style.boxShadow = 'none';
                header.style.padding = '10px 0';
            }
        });

        // ============================================================
        // USER DROPDOWN
        // ============================================================
        const avatarBtn = document.getElementById('avatarBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const userDropdown = document.getElementById('userDropdown');

        avatarBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = dropdownMenu.classList.contains('open');
            if (isOpen) {
                dropdownMenu.classList.remove('open');
                avatarBtn.classList.remove('open');
            } else {
                dropdownMenu.classList.add('open');
                avatarBtn.classList.add('open');
            }
        });

        document.addEventListener('click', (e) => {
            if (userDropdown && !userDropdown.contains(e.target)) {
                dropdownMenu?.classList.remove('open');
                avatarBtn?.classList.remove('open');
            }
        });

        // ============================================================
        // PROFILE MODAL
        // ============================================================
        const openProfileBtn = document.getElementById('openProfileBtn');
        const profileModalOverlay = document.getElementById('profileModalOverlay');
        const profileModalClose = document.getElementById('profileModalClose');

        openProfileBtn?.addEventListener('click', () => {
            dropdownMenu?.classList.remove('open');
            avatarBtn?.classList.remove('open');
            profileModalOverlay?.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        function closeProfileModal() {
            profileModalOverlay?.classList.remove('active');
            document.body.style.overflow = '';
        }

        profileModalClose?.addEventListener('click', closeProfileModal);
        profileModalOverlay?.addEventListener('click', (e) => {
            if (e.target === profileModalOverlay) closeProfileModal();
        });

        // ============================================================
        // AUTH MODAL + OTP
        // ============================================================
        const modalOverlay = document.getElementById('modalOverlay');
        const modalClose = document.getElementById('modalClose');
        const openModalBtns = document.querySelectorAll('#openModalBtn, #openModalBtnMobile');

        const stepPhone = document.getElementById('stepPhone');
        const stepBotStart = document.getElementById('stepBotStart');
        const stepCode = document.getElementById('stepCode');

        const phoneInput = document.getElementById('phoneInput');
        const phoneError = document.getElementById('phoneError');
        const phoneErrorText = document.getElementById('phoneErrorText');
        const sendOtpBtn = document.getElementById('sendOtpBtn');

        const retrySendOtp = document.getElementById('retrySendOtp');
        const backToPhoneFromBot = document.getElementById('backToPhoneFromBot');

        const otpInputs = document.querySelectorAll('#otpInputs input');
        const verifyOtpBtn = document.getElementById('verifyOtpBtn');
        const codeError = document.getElementById('codeError');
        const codeErrorText = document.getElementById('codeErrorText');
        const codeSuccess = document.getElementById('codeSuccess');
        const codeSuccessText = document.getElementById('codeSuccessText');
        const backToPhoneFromCode = document.getElementById('backToPhoneFromCode');
        const timerEl = document.getElementById('timer');
        const resendOtp = document.getElementById('resendOtp');

     let otpTimerInterval = null;
let currentPhone = '';
let isSending = false;

        function openModal() {
            modalOverlay?.classList.add('active');
            document.body.style.overflow = 'hidden';
            resetAuthModal();
        }

        function closeModal() {
            modalOverlay?.classList.remove('active');
            document.body.style.overflow = '';
            clearInterval(otpTimerInterval);
        }

        function resetAuthModal() {
            stepPhone.style.display = 'block';
            stepBotStart.style.display = 'none';
            stepCode.style.display = 'none';
            phoneError.style.display = 'none';
            codeError.style.display = 'none';
            codeSuccess.style.display = 'none';
            otpInputs.forEach(i => { i.value = ''; i.classList.remove('filled'); });
            clearInterval(otpTimerInterval);
            if (resendOtp) resendOtp.disabled = true;
        }

        function showStep(step) {
            stepPhone.style.display = step === 'phone' ? 'block' : 'none';
            stepBotStart.style.display = step === 'bot' ? 'block' : 'none';
            stepCode.style.display = step === 'code' ? 'block' : 'none';
        }

        openModalBtns.forEach(btn => btn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        }));

        modalClose?.addEventListener('click', closeModal);
        modalOverlay?.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
                closeProfileModal();
            }
        });

        // ============================================================
        // SEND OTP
        // ============================================================
 async function sendOtp(phone) {
    if (isSending) return;
    isSending = true;

    // ✅ ذخیره شماره در متغیر global
    currentPhone = phone;

    sendOtpBtn.disabled = true;
    sendOtpBtn.innerHTML = '<span>در حال ارسال...</span><i class="fas fa-spinner fa-spin"></i>';
    phoneError.style.display = 'none';

    try {
        const res = await fetch('{{ route("otp.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ phone }),
        });

        const data = await res.json();

        if (data.success) {
            showStep('code');
            startTimer(120);
            showToast('کد ورود به بله شما ارسال شد', 'success');
            setTimeout(() => otpInputs[0].focus(), 300);
        } else if (data.needs_bot_start) {
            showStep('bot');
        } else {
            phoneErrorText.textContent = data.message || 'خطا در ارسال کد';
            phoneError.style.display = 'flex';
        }
    } catch (err) {
        phoneErrorText.textContent = 'خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید.';
        phoneError.style.display = 'flex';
    } finally {
        sendOtpBtn.disabled = false;
        sendOtpBtn.innerHTML = '<span>ارسال کد</span><i class="fas fa-arrow-left"></i>';
        isSending = false;
    }
}
        // ============================================================
        // FORM SUBMIT
        // ============================================================
        document.getElementById('phoneForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            const phone = phoneInput.value.trim();

            if (!phone || phone.length < 10) {
                phoneErrorText.textContent = 'لطفاً شماره موبایل معتبر وارد کنید.';
                phoneError.style.display = 'flex';
                return;
            }

            sendOtp(phone);
        });
// ============================================================
// RETRY SEND OTP (after bot start) - with polling
// ============================================================
let chatIdPollingInterval = null;

retrySendOtp?.addEventListener('click', () => {
    if (!currentPhone) {
        showStep('phone');
        return;
    }

    retrySendOtp.disabled = true;
    retrySendOtp.innerHTML = '<span>در حال بررسی...</span><i class="fas fa-spinner fa-spin"></i>';

    let attempts = 0;
    const maxAttempts = 15;

    clearInterval(chatIdPollingInterval);
    chatIdPollingInterval = setInterval(async () => {
        attempts++;

        try {
            const res = await fetch('{{ route("otp.check-chat-id") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ phone: currentPhone }),
            });

            const data = await res.json();

            if (data.success && data.has_chat_id) {
                clearInterval(chatIdPollingInterval);
                retrySendOtp.disabled = false;
                retrySendOtp.innerHTML = '<span>استارت کردم، دوباره تلاش کن</span><i class="fas fa-redo"></i>';

                showToast('بازو با موفقیت متصل شد! در حال ارسال کد...', 'success');

                sendOtp(currentPhone);
                return;
            }

            if (attempts >= maxAttempts) {
                clearInterval(chatIdPollingInterval);
                retrySendOtp.disabled = false;
                retrySendOtp.innerHTML = '<span>استارت کردم، دوباره تلاش کن</span><i class="fas fa-redo"></i>';
                showToast('زمان انتظار به پایان رسید. لطفاً بازو را استارت کنید و دوباره تلاش کنید.', 'warning');
            }
        } catch (err) {
            console.error('Polling error:', err);
        }
    }, 2000);
});

backToPhoneFromBot?.addEventListener('click', () => {
    showStep('phone');
    phoneError.style.display = 'none';
});

backToPhoneFromCode?.addEventListener('click', () => {
    showStep('phone');
    clearInterval(otpTimerInterval);
    otpInputs.forEach(i => { i.value = ''; i.classList.remove('filled'); });
});

// ============================================================
// OTP INPUTS AUTO-FOCUS
// ============================================================
otpInputs.forEach((input, idx) => {
    input.addEventListener('input', (e) => {
        const val = e.target.value.replace(/[^0-9]/g, '');
        e.target.value = val;

        if (val) {
            e.target.classList.add('filled');
            if (idx < otpInputs.length - 1) otpInputs[idx + 1].focus();
        } else {
            e.target.classList.remove('filled');
        }
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && idx > 0) {
            otpInputs[idx - 1].focus();
        }
    });

    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
        if (paste.length === 6) {
            paste.split('').forEach((char, i) => {
                if (otpInputs[i]) {
                    otpInputs[i].value = char;
                    otpInputs[i].classList.add('filled');
                }
            });
            otpInputs[5].focus();
        }
    });
});
        // ============================================================
        // OTP INPUTS AUTO-FOCUS
        // ============================================================
        otpInputs.forEach((input, idx) => {
            input.addEventListener('input', (e) => {
                const val = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = val;

                if (val) {
                    e.target.classList.add('filled');
                    if (idx < otpInputs.length - 1) otpInputs[idx + 1].focus();
                } else {
                    e.target.classList.remove('filled');
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                    otpInputs[idx - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
                if (paste.length === 6) {
                    paste.split('').forEach((char, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = char;
                            otpInputs[i].classList.add('filled');
                        }
                    });
                    otpInputs[5].focus();
                }
            });
        });

        // ============================================================
        // VERIFY OTP
        // ============================================================
        verifyOtpBtn?.addEventListener('click', async () => {
            const code = Array.from(otpInputs).map(i => i.value).join('');

            if (code.length !== 6) {
                codeErrorText.textContent = 'لطفاً کد ۶ رقمی را کامل وارد کنید.';
                codeError.style.display = 'flex';
                return;
            }

            verifyOtpBtn.disabled = true;
            verifyOtpBtn.innerHTML = '<span>در حال بررسی...</span><i class="fas fa-spinner fa-spin"></i>';
            codeError.style.display = 'none';

            try {
                const res = await fetch('{{ route("otp.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ phone: currentPhone || phoneInput.value.trim(), code }),
                });

                const data = await res.json();

                if (data.success) {
                    codeSuccessText.textContent = 'ورود موفق! در حال انتقال...';
                    codeSuccess.style.display = 'flex';
                    showToast('خوش آمدید!', 'success');
                    setTimeout(() => window.location.reload(), 900);
                } else {
                    codeErrorText.textContent = data.message || 'کد وارد شده صحیح نیست.';
                    codeError.style.display = 'flex';
                    otpInputs.forEach(i => { i.value = ''; i.classList.remove('filled'); });
                    otpInputs[0].focus();
                }
            } catch (err) {
                codeErrorText.textContent = 'خطا در ارتباط با سرور.';
                codeError.style.display = 'flex';
            } finally {
                verifyOtpBtn.disabled = false;
                verifyOtpBtn.innerHTML = '<span>تایید و ورود</span><i class="fas fa-check"></i>';
            }
        });

        // Auto verify on last digit
        otpInputs[5]?.addEventListener('input', () => {
            const code = Array.from(otpInputs).map(i => i.value).join('');
            if (code.length === 6) {
                setTimeout(() => verifyOtpBtn?.click(), 200);
            }
        });

        // ============================================================
        // OTP TIMER
        // ============================================================
        function startTimer(seconds) {
            clearInterval(otpTimerInterval);
            let remaining = seconds;
            updateTimerDisplay(remaining);
            if (resendOtp) resendOtp.disabled = true;

            otpTimerInterval = setInterval(() => {
                remaining--;
                if (remaining <= 0) {
                    clearInterval(otpTimerInterval);
                    timerEl.textContent = '۰۰:۰۰';
                    if (resendOtp) resendOtp.disabled = false;
                    return;
                }
                updateTimerDisplay(remaining);
            }, 1000);
        }

        function updateTimerDisplay(sec) {
            const m = String(Math.floor(sec / 60)).padStart(2, '0');
            const s = String(sec % 60).padStart(2, '0');
            if (timerEl) timerEl.textContent = `${m}:${s}`;
        }

        resendOtp?.addEventListener('click', () => {
            if (phoneInput.value.trim()) {
                sendOtp(phoneInput.value.trim());
            }
        });

        // ============================================================
// LOGOUT
// ============================================================
const logoutBtn = document.getElementById('logoutBtn');

logoutBtn?.addEventListener('click', async () => {
    if (!confirm('آیا از خروج از حساب اطمینان دارید؟')) return;

    logoutBtn.disabled = true;
    const originalHTML = logoutBtn.innerHTML;
    logoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>در حال خروج...</span>';

    try {
        const res = await fetch('{{ route("logout") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        if (res.ok || res.redirected) {
            showToast('با موفقیت خارج شدید', 'success');
            setTimeout(() => {
                window.location.href = '{{ route("home") }}';
            }, 800);
        } else {
            showToast('خطا در خروج. لطفاً دوباره تلاش کنید.', 'error');
            logoutBtn.disabled = false;
            logoutBtn.innerHTML = originalHTML;
        }
    } catch (err) {
        showToast('خطا در ارتباط با سرور', 'error');
        logoutBtn.disabled = false;
        logoutBtn.innerHTML = originalHTML;
    }
});
        // ============================================================
        // FAQ ACCORDION
        // ============================================================
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', function() {
                const item = this.closest('.faq-item');
                const isActive = item.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
                if (!isActive) item.classList.add('active');
            });
        });

        // ============================================================
        // 3D PARTICLE SPHERE
        // ============================================================
        (function() {
            const canvas = document.getElementById('particleSphere');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let W, H;
            let particles = [];
            const NUM_PARTICLES = 650;
            let mouseX = 0, mouseY = 0;
            let targetRotX = 0, targetRotY = 0;
            let rotX = 0, rotY = 0;
            let time = 0;

            function resize() {
                const container = canvas.parentElement;
                const parentRect = container.getBoundingClientRect();
                if (window.innerWidth <= 768) {
                    canvas.width = Math.min(parentRect.width, 400);
                    canvas.height = Math.min(parentRect.width, 400) * 0.8;
                } else if (window.innerWidth <= 1024) {
                    canvas.width = Math.min(parentRect.width, 500);
                    canvas.height = Math.min(parentRect.width, 500) * 0.85;
                } else {
                    canvas.width = 580;
                    canvas.height = 580;
                }
                W = canvas.width;
                H = canvas.height;
                initParticles();
            }

            function initParticles() {
                particles = [];
                const radius = Math.min(W, H) * 0.38;
                for (let i = 0; i < NUM_PARTICLES; i++) {
                    const theta = Math.random() * Math.PI * 2;
                    const phi = Math.acos(2 * Math.random() - 1);
                    const r = radius * (0.85 + Math.random() * 0.15);
                    const x = r * Math.sin(phi) * Math.cos(theta);
                    const y = r * Math.sin(phi) * Math.sin(theta);
                    const z = r * Math.cos(phi);
                    const size = 1.5 + Math.random() * 3.5;
                    const brightness = 0.4 + Math.random() * 0.6;
                    particles.push({ x, y, z, ox: x, oy: y, oz: z, size, brightness, speed: 0.002 + Math.random() * 0.004, phase: Math.random() * Math.PI * 2 });
                }
            }

            document.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = (e.clientX - cx) / (rect.width / 2);
                const dy = (e.clientY - cy) / (rect.height / 2);
                mouseX = Math.max(-1, Math.min(1, dx));
                mouseY = Math.max(-1, Math.min(1, dy));
            });

            document.addEventListener('touchmove', (e) => {
                if (e.touches.length > 0) {
                    const rect = canvas.getBoundingClientRect();
                    const cx = rect.left + rect.width / 2;
                    const cy = rect.top + rect.height / 2;
                    const dx = (e.touches[0].clientX - cx) / (rect.width / 2);
                    const dy = (e.touches[0].clientY - cy) / (rect.height / 2);
                    mouseX = Math.max(-1, Math.min(1, dx));
                    mouseY = Math.max(-1, Math.min(1, dy));
                }
            });

            function draw() {
                ctx.clearRect(0, 0, W, H);
                targetRotX = mouseY * 0.4;
                targetRotY = mouseX * 0.4;
                rotX += (targetRotX - rotX) * 0.06;
                rotY += (targetRotY - rotY) * 0.06;
                time += 0.008;
                const autoRot = time * 0.15;

                const transformed = particles.map((p) => {
                    const waveX = Math.sin(time * p.speed * 3 + p.phase) * 4;
                    const waveY = Math.cos(time * p.speed * 2.5 + p.phase * 1.3) * 4;
                    const waveZ = Math.sin(time * p.speed * 2 + p.phase * 0.7) * 4;
                    let x = p.ox + waveX, y = p.oy + waveY, z = p.oz + waveZ;
                    const angleY = autoRot + rotY;
                    const cosY = Math.cos(angleY), sinY = Math.sin(angleY);
                    let rx = x * cosY - z * sinY;
                    let rz = x * sinY + z * cosY;
                    let ry = y;
                    const angleX = rotX;
                    const cosX = Math.cos(angleX), sinX = Math.sin(angleX);
                    let ry2 = ry * cosX - rz * sinX;
                    let rz2 = ry * sinX + rz * cosX;
                    return { x: rx, y: ry2, z: rz2, size: p.size, brightness: p.brightness };
                });

                transformed.sort((a, b) => a.z - b.z);
                const cx = W / 2, cy = H / 2;
                const scale = Math.min(W, H) * 0.85;
                const connectionDist = 45 * (Math.min(W, H) / 500);

                for (let i = 0; i < transformed.length; i++) {
                    const p = transformed[i];
                    const px = cx + p.x * scale * 0.4;
                    const py = cy + p.y * scale * 0.4;
                    const perspective = 1 + p.z * 0.06;
                    let size = p.size * perspective;
                    if (size < 0.1) size = 0.1;
                    const alpha = (0.6 + 0.4 * (1 - Math.abs(p.z) / 0.6)) * p.brightness;

                    const gradient = ctx.createRadialGradient(px, py, 0, px, py, size * 4);
                    gradient.addColorStop(0, `rgba(212, 163, 115, ${alpha * 0.4})`);
                    gradient.addColorStop(1, `rgba(212, 163, 115, ${alpha * 0.05})`);
                    ctx.fillStyle = gradient;
                    ctx.beginPath();
                    ctx.arc(px, py, size * 4, 0, Math.PI * 2);
                    ctx.fill();

                    ctx.fillStyle = `rgba(255, 220, 180, ${alpha * 0.9})`;
                    ctx.shadowColor = `rgba(212, 163, 115, ${alpha * 0.5})`;
                    ctx.shadowBlur = size * 3;
                    ctx.beginPath();
                    ctx.arc(px, py, size, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.shadowBlur = 0;

                    if (size > 2) {
                        ctx.fillStyle = `rgba(255, 255, 255, ${alpha * 0.2})`;
                        ctx.beginPath();
                        ctx.arc(px - size * 0.2, py - size * 0.2, size * 0.4, 0, Math.PI * 2);
                        ctx.fill();
                    }

                    if (i < transformed.length - 1) {
                        for (let j = i + 1; j < Math.min(i + 8, transformed.length); j++) {
                            const p2 = transformed[j];
                            const dx2 = px - (cx + p2.x * scale * 0.4);
                            const dy2 = py - (cy + p2.y * scale * 0.4);
                            const dist = Math.sqrt(dx2 * dx2 + dy2 * dy2);
                            if (dist < connectionDist) {
                                const connAlpha = (1 - dist / connectionDist) * 0.15 * p.brightness * p2.brightness;
                                ctx.strokeStyle = `rgba(212, 163, 115, ${connAlpha})`;
                                ctx.lineWidth = 0.5;
                                ctx.beginPath();
                                ctx.moveTo(px, py);
                                ctx.lineTo(cx + p2.x * scale * 0.4, cy + p2.y * scale * 0.4);
                                ctx.stroke();
                            }
                        }
                    }
                }

                const ringRadius = Math.min(W, H) * 0.38;
                const gradient2 = ctx.createRadialGradient(cx, cy, ringRadius * 0.7, cx, cy, ringRadius * 1.2);
                gradient2.addColorStop(0, 'rgba(212, 163, 115, 0)');
                gradient2.addColorStop(0.5, 'rgba(212, 163, 115, 0.02)');
                gradient2.addColorStop(1, 'rgba(212, 163, 115, 0)');
                ctx.fillStyle = gradient2;
                ctx.beginPath();
                ctx.arc(cx, cy, ringRadius * 1.2, 0, Math.PI * 2);
                ctx.fill();

                requestAnimationFrame(draw);
            }

            window.addEventListener('resize', resize);
            resize();
            draw();
            setTimeout(resize, 500);
        })();
    </script>

</body>
</html>
