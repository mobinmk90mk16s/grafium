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
        .section { padding: 60px 0; }
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

        /* ===== SERVICES PAGE ===== */
        .services-page {
            padding: 60px 0;
        }

        /* ===== DESK GRID ===== */
        .desk-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 30px;
        }
        .desk-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px solid var(--border);
            padding: 24px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: var(--shadow);
            min-height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .desk-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 12px 40px rgba(212, 163, 115, 0.12);
        }
        .desk-card:nth-child(odd) .desk-card-inner {
            background: rgba(10, 22, 40, 0.04);
        }
        .desk-card:nth-child(even) .desk-card-inner {
            background: rgba(212, 163, 115, 0.04);
        }
        .desk-card-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 16px;
            border-radius: var(--radius-sm);
            width: 100%;
            transition: all 0.3s;
        }
        .desk-number {
            font-size: 32px;
            font-weight: 800;
            color: var(--gold);
            line-height: 1;
        }
        .desk-card-inner span {
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 500;
        }
        .desk-card-inner i {
            font-size: 24px;
            color: var(--gold);
            opacity: 0.4;
            margin-top: 4px;
        }
        .desk-card:hover .desk-card-inner i {
            opacity: 1;
            transform: scale(1.1);
        }

        /* ===== RESERVATION SECTION ===== */
        .reservation-section {
            margin-top: 40px;
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.4s, transform 0.4s;
        }
        .reservation-section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        .reservation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .reservation-header h3 {
            font-size: 26px;
            font-weight: 800;
            margin: 0;
        }
        .reservation-close {
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
        .reservation-close:hover {
            color: var(--gold);
            background: rgba(212, 163, 115, 0.1);
            transform: rotate(90deg);
        }
        .reservation-wrapper {
            display: flex;
            gap: 24px;
            align-items: flex-start;
        }
        .reservation-table-box {
            flex: 1;
            border: 2px solid var(--gold);
            border-radius: var(--radius);
            background: var(--bg-card);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        .reservation-table-scroll {
            max-height: 400px;
            overflow-y: auto;
            border-radius: inherit;
        }
        .reservation-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .reservation-table th {
            background: var(--bg-body);
            padding: 12px 10px;
            font-weight: 700;
            color: var(--text);
            border-bottom: 2px solid var(--gold);
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        .reservation-table td {
            padding: 10px 8px;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }
        .status-cell {
            border-radius: 6px;
            padding: 6px 4px;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .status-available {
            background: #fff;
            color: #0a1628;
            border-color: #d4a373;
        }
        .status-available:hover {
            background: #d4a37320;
        }
        .status-reserved-other {
            background: #f59e0b;
            color: #fff;
        }
        .status-previous-self {
            background: #3b82f6;
            color: #fff;
        }
        .status-temporary {
            background: #facc15;
            color: #0a1628;
        }
        .status-closed {
            background: #dc2626;
            color: #fff;
        }
        .status-selected {
            background: #22c55e;
            color: #fff;
        }
        .status-expired {
            background: #6b7280;
            color: #f0f0f0;
        }
        .reservation-summary-box {
            width: 280px;
            flex-shrink: 0;
            background: var(--bg-card);
            border: 2px solid var(--gold);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        .summary-title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 16px;
            color: var(--gold);
            text-align: center;
        }
        .summary-item {
            margin-bottom: 12px;
            font-size: 14px;
            color: var(--text-muted);
        }
        .summary-item strong {
            color: var(--text);
            font-weight: 700;
        }
        .summary-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 16px 0;
        }
        .reservation-summary-box .btn-gold {
            width: 100%;
            padding: 10px 0;
            font-size: 14px;
            font-weight: 700;
        }

        /* ===== TRUST BAR ===== */
        .trust-bar {
            background: var(--bg-card);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 24px 0;
            overflow: hidden;
            position: relative;
        }
        .trust-bar::before,
        .trust-bar::after {
            content: '';
            position: absolute;
            top: 0;
            width: 80px;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }
        .trust-bar::before {
            right: 0;
            background: linear-gradient(270deg, var(--bg-card), transparent);
        }
        .trust-bar::after {
            left: 0;
            background: linear-gradient(90deg, var(--bg-card), transparent);
        }
        .trust-track {
            display: flex;
            gap: 60px;
            animation: scrollTrust 25s linear infinite;
            width: max-content;
        }
        .trust-track .trust-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 14px;
            white-space: nowrap;
        }
        .trust-track .trust-item i {
            color: var(--gold);
            font-size: 20px;
        }
        @keyframes scrollTrust {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
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
            .desk-grid { grid-template-columns: repeat(3, 1fr); gap: 18px; }
            .reservation-wrapper { flex-direction: column; }
            .reservation-summary-box { width: 100%; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .desk-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
            .desk-card { padding: 18px 12px; min-height: 110px; }
            .desk-number { font-size: 26px; }
            .reservation-table th,
            .reservation-table td { font-size: 12px; padding: 6px 4px; }
            .footer-grid { grid-template-columns: 1fr; }
            .cta { padding: 60px 0; }
        }

        @media (max-width: 480px) {
            .desk-grid { gap: 10px; }
            .desk-card { padding: 14px 10px; min-height: 90px; }
            .desk-number { font-size: 22px; }
            .status-cell { font-size: 10px; padding: 3px 2px; }
            .reservation-section { padding: 20px 12px; }
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
                <img src="{{ asset('images/Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium Logo" class="logo-img" />
            </a>
            <nav class="nav-desktop" id="navDesktop">
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
                <a href="#" class="btn btn-gold" id="openModalBtn">ورود</a>
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
                <a href="#" class="btn btn-gold" id="openModalBtnMobile">ورود</a>
            </div>
        </div>
    </header>

    <!-- ============================================================
    MODAL
    ============================================================ -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <button class="modal-close" id="modalClose"><i class="fas fa-times"></i></button>
            <div class="modal-tabs">
                <button class="modal-tab active" data-tab="login">ورود</button>
                <button class="modal-tab" data-tab="register">ثبت‌نام</button>
            </div>
            <form class="modal-form" id="loginForm">
                <div class="form-group">
                    <label for="loginEmail">ایمیل</label>
                    <input type="email" id="loginEmail" placeholder="ایمیل خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="loginPassword">رمز عبور</label>
                    <input type="password" id="loginPassword" placeholder="رمز عبور خود را وارد کنید" />
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
    TRUST BAR
    ============================================================ -->
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

    <!-- ============================================================
    SERVICES PAGE
    ============================================================ -->
    <section class="section services-page">
        <div class="container">
            <div class="section-header">
                <span class="gradient-badge">رزرو میز</span>
                <h2 class="purple-text">انتخاب میز مورد نظر</h2>
                <p>روی هر میز کلیک کنید تا جدول رزرو آن باز شود</p>
            </div>

            <div class="desk-grid">
                @for ($i = 1; $i <= 12; $i++)
                    <div class="desk-card" data-desk="{{ $i }}">
                        <div class="desk-card-inner">
                            <span class="desk-number">{{ $i }}</span>
                            <span>میز</span>
                            <i class="fas fa-table"></i>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="reservation-section" id="reservationSection">
                <div class="reservation-header">
                    <h3 class="purple-text">میز شماره <span id="deskNumber">۱</span></h3>
                    <button class="reservation-close" id="reservationClose"><i class="fas fa-times"></i></button>
                </div>
                <div class="reservation-wrapper">
                    <div class="reservation-table-box">
                        <div class="reservation-table-scroll">
                            <table class="reservation-table" id="reservationTable">
                                <thead>
                                    <tr><th>تاریخ</th><th>شیفت ۱ (۸-۱۴)</th><th>شیفت ۲ (۱۵-۲۱)</th></tr>
                                </thead>
                                <tbody id="reservationTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="reservation-summary-box">
                        <h4 class="summary-title">خلاصه رزرو</h4>
                        <div class="summary-item"><span>تعداد سلول انتخاب شده:</span> <strong id="selectedCount">۰</strong></div>
                        <div class="summary-item"><span>تعرفه:</span> <strong id="summaryPlan">-</strong></div>
                        <div class="summary-item"><span>قیمت کل:</span> <strong id="summaryPrice">۰ تومان</strong></div>
                        <hr class="summary-divider" />
                        <button class="btn btn-gold" id="payBtn">پرداخت</button>
                    </div>
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
                        <img src="{{ asset('images/Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium Logo" class="logo-img" />
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
                <p>&copy; {{ date('Y') }} تمامی حقوق برای <span class="gold-text">GRAFIUM</span> محفوظ است.</p>
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
        // 4. MODAL
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
        // 5. RESERVATION SYSTEM
        // ============================================================
        (function() {
            // ---------- DATABASE ----------
            const DB = {
                currentUser: { id: 1, name: 'کاربر' },
                startDate: new Date(2026, 7, 6),
                daysCount: 90,
                holidays: ['2026-08-23', '2026-09-12', '2026-10-02'],
            };
            const daysMap = ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'];
            const persianMonths = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];

            function toPersianDate(date) {
                const day = date.getDate();
                const month = date.getMonth();
                const year = date.getFullYear() - 621;
                return `${day} ${persianMonths[month]} ${year}`;
            }

            function isHoliday(date) {
                const iso = date.toISOString().split('T')[0];
                return date.getDay() === 5 || DB.holidays.includes(iso);
            }

            const DATES = [];
            for (let i = 0; i < DB.daysCount; i++) {
                const d = new Date(DB.startDate);
                d.setDate(d.getDate() + i);
                DATES.push({
                    label: `${daysMap[d.getDay()]} ${toPersianDate(d)}`,
                    iso: d.toISOString().split('T')[0],
                    isHoliday: isHoliday(d),
                });
            }

            function pseudoRandom(deskId, dayIndex, shiftIndex) {
                const seed = (deskId * 31 + dayIndex * 17 + shiftIndex * 7) % 100;
                return seed;
            }

            DB.reservations = {};
            for (let d = 1; d <= 12; d++) {
                DB.reservations[d] = DATES.map((date, dayIndex) => {
                    if (date.isHoliday) return [4, 4];
                    const row = [];
                    for (let shift = 0; shift < 2; shift++) {
                        const rnd = pseudoRandom(d, dayIndex, shift);
                        if (rnd < 45) row[shift] = 0;
                        else if (rnd < 65) row[shift] = 1;
                        else if (rnd < 80) row[shift] = 3;
                        else if (rnd < 88) row[shift] = 2;
                        else if (rnd < 95) row[shift] = 6;
                        else row[shift] = 0;
                    }
                    return row;
                });
            }

            const fixedStatuses = [
                [1, 0, [3, 0]], [1, 1, [0, 3]], [2, 0, [3, 0]],
                [3, 1, [0, 3]], [4, 2, [3, 0]], [5, 0, [0, 3]],
                [6, 3, [3, 0]], [7, 4, [0, 3]], [8, 5, [3, 0]],
                [9, 0, [0, 3]], [10, 1, [3, 0]], [1, 2, [1, 0]],
                [2, 3, [0, 1]], [3, 4, [1, 0]], [4, 5, [0, 1]],
                [5, 6, [1, 0]], [6, 7, [0, 1]], [11, 0, [2, 0]],
                [12, 1, [0, 2]], [10, 2, [2, 0]], [9, 3, [0, 2]],
                [8, 4, [2, 0]], [7, 5, [0, 2]], [12, 20, [6, 6]],
                [11, 40, [6, 6]], [10, 30, [4, 4]],
            ];
            fixedStatuses.forEach(([desk, day, val]) => {
                if (DB.reservations[desk] && DB.reservations[desk][day]) {
                    DB.reservations[desk][day] = val;
                }
            });

            // ---------- DOM ----------
            const section = document.getElementById('reservationSection');
            const closeBtn = document.getElementById('reservationClose');
            const deskNumberSpan = document.getElementById('deskNumber');
            const tableBody = document.getElementById('reservationTableBody');
            const payBtn = document.getElementById('payBtn');
            const selectedCount = document.getElementById('selectedCount');
            const summaryPlan = document.getElementById('summaryPlan');
            const summaryPrice = document.getElementById('summaryPrice');

            let currentDesk = 1;
            let selectedCells = [];

            function getStatus(deskId, dayIndex, shiftIndex) {
                const deskStatus = DB.reservations[deskId];
                if (!deskStatus || dayIndex >= deskStatus.length) return 0;
                return deskStatus[dayIndex][shiftIndex] ?? 0;
            }

            function setStatus(deskId, dayIndex, shiftIndex, status) {
                if (!DB.reservations[deskId]) DB.reservations[deskId] = DATES.map(() => [0, 0]);
                if (!DB.reservations[deskId][dayIndex]) DB.reservations[deskId][dayIndex] = [0, 0];
                DB.reservations[deskId][dayIndex][shiftIndex] = status;
            }

            function getStatusClass(status) {
                const classes = {
                    0: 'status-available',
                    1: 'status-reserved-other',
                    2: 'status-previous-self',
                    3: 'status-temporary',
                    4: 'status-closed',
                    5: 'status-selected',
                    6: 'status-expired',
                };
                return classes[status] || '';
            }

            function getStatusText(status) {
                const texts = {
                    0: 'قابل رزرو',
                    1: 'رزرو شده',
                    2: 'رزرو قبلی شما',
                    3: 'در حال رزرو',
                    4: 'تعطیل',
                    5: 'انتخاب شده',
                    6: 'منقضی',
                };
                return texts[status] || '';
            }

            function renderTable(deskId) {
                tableBody.innerHTML = '';
                selectedCells = [];

                DATES.forEach((date, i) => {
                    const tr = document.createElement('tr');
                    const tdDate = document.createElement('td');
                    tdDate.textContent = date.label;
                    tr.appendChild(tdDate);

                    for (let shift = 0; shift < 2; shift++) {
                        const td = document.createElement('td');
                        const status = getStatus(deskId, i, shift);
                        td.className = `status-cell ${getStatusClass(status)}`;
                        td.textContent = getStatusText(status);
                        td.dataset.dayIndex = i;
                        td.dataset.shiftIndex = shift;

                        if (status === 0 || status === 5) {
                            td.addEventListener('click', () => handleCellClick(deskId, i, shift));
                        } else {
                            td.style.cursor = 'not-allowed';
                        }
                        tr.appendChild(td);

                        if (status === 5) selectedCells.push({ dayIndex: i, shiftIndex: shift });
                    }
                    tableBody.appendChild(tr);
                });
                updateSummary();
            }

            function handleCellClick(deskId, dayIndex, shiftIndex) {
                const current = getStatus(deskId, dayIndex, shiftIndex);
                if (current === 0) setStatus(deskId, dayIndex, shiftIndex, 5);
                else if (current === 5) setStatus(deskId, dayIndex, shiftIndex, 0);
                else {
                    alert('این سلول قابل انتخاب نیست.');
                    return;
                }
                renderTable(deskId);
            }

            function updateSummary() {
                const count = selectedCells.length;
                selectedCount.textContent = count;
                let plan = '-';
                if (count > 30) plan = 'ماهانه';
                else if (count > 6) plan = 'هفتگی';
                else if (count > 0) plan = 'شیفتی';
                summaryPlan.textContent = plan;
                summaryPrice.textContent = count > 0 ? (count * 500000).toLocaleString() + ' تومان' : '۰ تومان';
            }

            function openSection(deskId) {
                currentDesk = deskId;
                deskNumberSpan.textContent = deskId;
                renderTable(deskId);
                section.classList.add('active');
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            function closeSection() {
                section.classList.remove('active');
                for (let i = 0; i < DATES.length; i++) {
                    for (let j = 0; j < 2; j++) {
                        if (getStatus(currentDesk, i, j) === 5) setStatus(currentDesk, i, j, 0);
                    }
                }
                renderTable(currentDesk);
            }

            payBtn.addEventListener('click', () => {
                if (selectedCells.length === 0) {
                    alert('لطفاً حداقل یک سلول را انتخاب کنید.');
                    return;
                }
                const invoiceData = {
                    desk: currentDesk,
                    cells: selectedCells,
                    dates: DATES,
                    user: DB.currentUser
                };
                localStorage.setItem('invoiceData', JSON.stringify(invoiceData));
                window.location.href = "{{ route('invoice') }}";
            });

            document.querySelectorAll('.desk-card').forEach(card => {
                card.addEventListener('click', () => {
                    openSection(parseInt(card.dataset.desk));
                });
            });

            closeBtn.addEventListener('click', closeSection);
        })();

        console.log('✅ Services page loaded successfully!');
    </script>

</body>
</html>