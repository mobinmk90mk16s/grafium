<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>پنل کاربری | GRAFIUM</title>

    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
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
            --gold-glow: 0 0 40px rgba(212, 163, 115, 0.35);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --bg-soft: #fafbfc;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --text-light: #94a3b8;
            --border: #e4e7ec;
            --border-light: #f0f2f5;
            --shadow-sm: 0 2px 8px rgba(10, 22, 40, 0.04);
            --shadow: 0 4px 24px rgba(10, 22, 40, 0.08);
            --shadow-lg: 0 20px 60px rgba(10, 22, 40, 0.12);
            --radius: 20px;
            --radius-sm: 14px;
            --radius-xs: 10px;
            --transition: 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            --font: "Vazirmatn", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #0f1f33;
            --bg-soft: #132238;
            --text: #f0f0f0;
            --text-muted: #94a3b8;
            --text-light: #64748b;
            --border: #1a2f4a;
            --border-light: #162b42;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.2);
            --shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font);
            background: var(--bg-body);
            color: var(--text);
            direction: rtl;
            line-height: 1.7;
            min-height: 100vh;
            transition: background 0.4s, color 0.4s;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        button { font-family: var(--font); cursor: pointer; border: none; background: none; }

        .container { max-width: 1320px; margin: 0 auto; padding: 0 24px; }

        /* ============================================================
        HEADER (Glass)
        ============================================================ */
        .header {
            position: sticky; top: 0; z-index: 1000;
            background: rgba(10, 22, 40, 0.85);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-bottom: 1px solid rgba(212, 163, 115, 0.12);
            padding: 12px 0;
            transition: all 0.4s;
        }
        [data-theme="light"] .header {
            background: rgba(255, 255, 255, 0.85);
            border-bottom: 1px solid var(--border);
        }
        .header-inner { display: flex; align-items: center; justify-content: space-between; }
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo-img { height: 48px; transition: transform 0.4s; }
        .logo:hover .logo-img { transform: scale(1.05); }

        .nav-desktop ul { display: flex; gap: 6px; }
        .nav-desktop a {
            font-weight: 500; font-size: 14px;
            color: rgba(255, 255, 255, 0.65);
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s;
            position: relative;
        }
        [data-theme="light"] .nav-desktop a { color: var(--text-muted); }
        .nav-desktop a:hover {
            color: var(--gold);
            background: rgba(212, 163, 115, 0.08);
        }
        .nav-desktop a.active {
            color: #fff;
            background: var(--gold-gradient);
            box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
        }

        .header-actions { display: flex; align-items: center; gap: 12px; }
        .theme-toggle {
            width: 42px; height: 42px; border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: #fff;
            font-size: 16px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s;
            cursor: pointer;
        }
        [data-theme="light"] .theme-toggle {
            border-color: var(--border);
            background: rgba(10, 22, 40, 0.03);
            color: var(--text);
        }
        .theme-toggle:hover {
            border-color: var(--gold);
            color: var(--gold);
            transform: rotate(20deg) scale(1.05);
        }

        /* ===== User Dropdown ===== */
        .user-dropdown { position: relative; }
        .user-avatar-btn {
            width: 44px; height: 44px; border-radius: 14px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
            border: 2px solid rgba(255,255,255,0.15);
        }
        .user-avatar-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.5);
        }
        .dropdown-menu {
            position: absolute; top: calc(100% + 14px); left: 0;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 8px;
            min-width: 250px;
            box-shadow: var(--shadow-lg);
            opacity: 0; visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transform-origin: top left;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 1000;
        }
        .dropdown-menu.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        .dropdown-header {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 6px;
        }
        .dropdown-header .user-name {
            font-weight: 700; font-size: 15px;
            display: block; margin-bottom: 3px;
        }
        .dropdown-header .user-phone {
            font-size: 12px; color: var(--text-muted);
            direction: ltr; display: block;
            font-family: monospace;
        }
        .dropdown-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            font-size: 14px; font-weight: 600;
            color: var(--text);
            transition: all 0.25s;
            width: 100%; text-align: right;
        }
        .dropdown-item:hover {
            background: rgba(212, 163, 115, 0.1);
            color: var(--gold-dark);
            padding-right: 18px;
        }
        [data-theme="dark"] .dropdown-item:hover { color: var(--gold); }
        .dropdown-item i { width: 20px; text-align: center; color: var(--gold); }
        .dropdown-divider { height: 1px; background: var(--border); margin: 6px 10px; }
        .logout-item:hover { background: rgba(244, 63, 94, 0.1); color: #fb7185; }
        .logout-item:hover i { color: #fb7185; }

        /* ============================================================
        HERO SECTION
        ============================================================ */
        .hero {
            background: var(--deep-navy);
            padding: 60px 0 140px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 90% 20%, rgba(212, 163, 115, 0.15), transparent 45%),
                radial-gradient(circle at 10% 80%, rgba(212, 163, 115, 0.08), transparent 50%);
        }
        .hero::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(212, 163, 115, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 163, 115, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 80%);
        }
        .hero-content {
            position: relative; z-index: 1;
            display: flex; align-items: center;
            justify-content: space-between;
            gap: 30px; flex-wrap: wrap;
        }
        .hero-greeting {
            display: flex; align-items: center; gap: 20px;
        }
        .hero-avatar {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: var(--gold-gradient);
            color: #fff; font-size: 28px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: var(--gold-glow);
            border: 3px solid rgba(255,255,255,0.15);
            flex-shrink: 0;
        }
        .hero-text h1 {
            font-size: 30px; font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
        }
        .hero-text h1 .gold-name {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-text p {
            color: rgba(255,255,255,0.55);
            font-size: 14px;
            display: flex; align-items: center; gap: 8px;
        }
        .hero-text p i { color: var(--gold); font-size: 12px; }

        .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }

        /* ============================================================
        STATS (Overlapping Cards)
        ============================================================ */
        .stats-wrapper {
            margin-top: -80px;
            position: relative;
            z-index: 2;
            margin-bottom: 50px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 26px 22px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 120px; height: 120px;
            background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
            opacity: 0.08;
            transition: transform 0.6s, opacity 0.4s;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 4px; height: 40px;
            background: var(--accent);
            border-radius: 0 0 0 4px;
            opacity: 0.6;
            transition: all 0.4s;
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }
        .stat-card:hover::before { transform: scale(1.5); opacity: 0.15; }
        .stat-card:hover::after { height: 100%; opacity: 1; }
        .stat-card.blue { --accent: #60a5fa; }
        .stat-card.green { --accent: #34d399; }
        .stat-card.amber { --accent: #fbbf24; }
        .stat-card.purple { --accent: #a78bfa; }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            background: color-mix(in srgb, var(--accent) 15%, transparent);
            color: var(--accent);
            margin-bottom: 18px;
            transition: all 0.4s;
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(-6deg);
            box-shadow: 0 8px 20px color-mix(in srgb, var(--accent) 30%, transparent);
        }
        .stat-value {
            font-size: 28px; font-weight: 800;
            line-height: 1.2;
            margin-bottom: 4px;
            color: var(--text);
        }
        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }
        .stat-trend {
            position: absolute;
            top: 22px; left: 22px;
            font-size: 11px; font-weight: 700;
            padding: 3px 10px;
            border-radius: 9999px;
            background: rgba(52, 211, 153, 0.12);
            color: #34d399;
        }

        /* ============================================================
        SECTION CARD
        ============================================================ */
        .section-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: box-shadow 0.4s;
        }
        .section-card:hover { box-shadow: var(--shadow); }
        .section-header {
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 22px 26px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-soft);
        }
        .section-header h3 {
            font-size: 16px; font-weight: 800;
            display: flex; align-items: center; gap: 12px;
            color: var(--text);
        }
        .section-header h3 .icon-badge {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            box-shadow: 0 6px 16px rgba(212, 163, 115, 0.3);
        }
        .section-header a {
            font-size: 13px; font-weight: 700;
            color: var(--gold);
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px;
            border-radius: 9999px;
            transition: all 0.3s;
        }
        .section-header a:hover {
            background: rgba(212, 163, 115, 0.1);
            gap: 10px;
        }
        .section-body { padding: 22px 26px; }

        /* ============================================================
        LAYOUT GRID
        ============================================================ */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            margin-bottom: 30px;
        }
        .dashboard-main { display: flex; flex-direction: column; gap: 24px; }
        .dashboard-side { display: flex; flex-direction: column; gap: 24px; }

        /* ============================================================
        QUICK ACTIONS
        ============================================================ */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 30px;
        }
        .quick-action {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 22px 16px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 10px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .quick-action::before {
            content: '';
            position: absolute; inset: 0;
            background: var(--gold-gradient);
            opacity: 0;
            transition: opacity 0.4s;
        }
        .quick-action:hover {
            transform: translateY(-6px);
            border-color: var(--gold);
            box-shadow: var(--shadow-lg);
        }
        .quick-action:hover::before { opacity: 0.05; }
        .quick-action > * { position: relative; z-index: 1; }
        .quick-action-icon {
            width: 50px; height: 50px;
            border-radius: 14px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.3);
            transition: transform 0.4s;
        }
        .quick-action:hover .quick-action-icon {
            transform: scale(1.12) rotate(-8deg);
        }
        .quick-action span {
            font-weight: 700; font-size: 14px;
            color: var(--text);
        }
        .quick-action small {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* ============================================================
        NOTIFICATIONS
        ============================================================ */
        .notifications-list {
            display: flex; flex-direction: column; gap: 10px;
            margin-bottom: 30px;
        }
        .notification-item {
            display: flex; align-items: flex-start; gap: 14px;
            padding: 16px 20px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }
        .notification-item::before {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 4px;
            background: var(--notif-color);
        }
        .notification-item:hover {
            transform: translateX(-8px);
            box-shadow: var(--shadow);
            border-color: var(--notif-color);
        }
        .notification-item.warning { --notif-color: #fbbf24; }
        .notification-item.info { --notif-color: #60a5fa; }
        .notification-item.success { --notif-color: #34d399; }
        .notification-item.error { --notif-color: #fb7185; }

        .notification-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; flex-shrink: 0;
            background: color-mix(in srgb, var(--notif-color) 15%, transparent);
            color: var(--notif-color);
        }
        .notification-body { flex: 1; min-width: 0; }
        .notification-title {
            font-weight: 700; font-size: 14px;
            margin-bottom: 3px;
            color: var(--text);
        }
        .notification-message {
            font-size: 13px; color: var(--text-muted);
            line-height: 1.6;
        }
        .notification-link {
            color: var(--gold);
            font-weight: 700; font-size: 12px;
            margin-top: 6px;
            display: inline-flex; align-items: center; gap: 5px;
            transition: gap 0.3s;
        }
        .notification-link:hover { gap: 9px; }

        /* ============================================================
        RESERVATION CARD (Redesigned)
        ============================================================ */
        .reservation-list {
            display: flex; flex-direction: column; gap: 14px;
        }
        .reservation-card {
            display: flex; align-items: stretch;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
        }
        .reservation-card:hover {
            transform: translateX(-6px);
            border-color: var(--gold);
            box-shadow: 0 12px 36px rgba(212, 163, 115, 0.15);
        }
        .res-side-bar {
            width: 6px;
            background: var(--status-color, #60a5fa);
            flex-shrink: 0;
        }
        .res-body {
            flex: 1; padding: 18px 20px;
            display: flex; align-items: center;
            gap: 16px;
        }
        .res-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.25);
            flex-shrink: 0;
        }
        .res-info { flex: 1; min-width: 0; }
        .res-title {
            font-size: 15px; font-weight: 800;
            color: var(--text);
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .res-meta {
            display: flex; flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: var(--text-muted);
        }
        .res-meta span {
            display: inline-flex; align-items: center; gap: 5px;
        }
        .res-meta i { color: var(--gold); font-size: 11px; }

        .res-actions {
            display: flex; flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            flex-shrink: 0;
        }
        .res-badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11px; font-weight: 700;
            white-space: nowrap;
        }
        .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
        .badge-active { background: rgba(52, 211, 153, 0.15); color: #34d399; }
        .badge-completed { background: rgba(96, 165, 250, 0.15); color: #60a5fa; }
        .badge-cancelled { background: rgba(244, 63, 94, 0.15); color: #fb7185; }
        .badge-expired { background: rgba(148, 163, 184, 0.15); color: #94a3b8; }

        .res-price {
            font-weight: 800; font-size: 14px;
            color: var(--gold-dark);
            direction: rtl;
        }
        [data-theme="dark"] .res-price { color: var(--gold); }

        .btn-cancel {
            padding: 6px 14px;
            border-radius: 9px;
            background: rgba(244, 63, 94, 0.08);
            color: #fb7185;
            font-size: 11px; font-weight: 700;
            transition: all 0.25s;
            display: inline-flex; align-items: center; gap: 5px;
            cursor: pointer;
            border: 1px solid rgba(244, 63, 94, 0.15);
        }
        .btn-cancel:hover {
            background: rgba(244, 63, 94, 0.15);
            transform: scale(1.03);
        }

        /* ============================================================
        PROFILE CARD (Redesigned)
        ============================================================ */
        .profile-card-v2 {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            position: relative;
        }
        .profile-cover {
            height: 90px;
            background: linear-gradient(135deg, #0a1628, #1a2f4a);
            position: relative;
        }
        .profile-cover::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at 80% 50%, rgba(212, 163, 115, 0.15), transparent 60%);
        }
        .profile-cover::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(212, 163, 115, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 163, 115, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .profile-avatar-wrap {
            position: relative;
            margin-top: -45px;
            text-align: center;
            padding: 0 24px;
        }
        .profile-avatar-v2 {
            width: 90px; height: 90px;
            border-radius: 24px;
            background: var(--gold-gradient);
            color: #fff; font-size: 34px;
            display: inline-flex; align-items: center; justify-content: center;
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.4);
            border: 5px solid var(--bg-card);
            transition: transform 0.4s;
        }
        .profile-avatar-v2:hover { transform: scale(1.05) rotate(-3deg); }
        .profile-name-v2 {
            text-align: center;
            font-size: 20px; font-weight: 800;
            margin: 16px 0 4px;
            color: var(--text);
        }
        .profile-phone-v2 {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            direction: ltr;
            display: block;
            font-family: monospace;
            margin-bottom: 20px;
        }
        .profile-info-v2 {
            padding: 0 24px 20px;
            display: flex; flex-direction: column; gap: 4px;
        }
        .profile-info-row {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 13px;
            transition: background 0.3s;
        }
        .profile-info-row:hover { background: var(--bg-soft); }
        .profile-info-row .icon {
            width: 32px; height: 32px;
            border-radius: 9px;
            background: rgba(212, 163, 115, 0.1);
            color: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }
        .profile-info-row .label {
            color: var(--text-muted);
            flex: 1;
        }
        .profile-info-row .value {
            color: var(--text);
            font-weight: 600;
            font-size: 12px;
            text-align: left;
            direction: ltr;
        }
        .profile-info-row .value.rtl {
            direction: rtl;
            text-align: right;
        }
        .btn-edit-profile-v2 {
            display: flex; align-items: center; justify-content: center;
            gap: 8px;
            margin: 0 24px 24px;
            padding: 12px;
            border-radius: 12px;
            background: var(--gold-gradient);
            color: #fff;
            font-weight: 700; font-size: 13px;
            transition: all 0.35s;
            box-shadow: 0 8px 22px rgba(212, 163, 115, 0.3);
        }
        .btn-edit-profile-v2:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 35px rgba(212, 163, 115, 0.45);
        }

        /* ============================================================
        CHART SECTION
        ============================================================ */
        .chart-section {
            margin-bottom: 30px;
        }
        .chart-wrapper {
            padding: 26px;
            height: 300px;
            position: relative;
        }
        .chart-legend {
            display: flex; gap: 20px;
            justify-content: center;
            margin-top: 16px;
        }
        .legend-item {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
        }
        .legend-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: var(--gold);
        }

        /* ============================================================
        INVOICES (Redesigned Table-like)
        ============================================================ */
        .invoice-list { display: flex; flex-direction: column; gap: 10px; }
        .invoice-row {
            display: flex; align-items: center; gap: 14px;
            padding: 16px 18px;
            border-radius: 14px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
        }
        .invoice-row:hover {
            transform: translateX(-6px);
            border-color: var(--gold);
            background: var(--bg-card);
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.12);
        }
        .invoice-icon-wrap {
            width: 46px; height: 46px;
            border-radius: 13px;
            background: rgba(212, 163, 115, 0.1);
            color: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .invoice-info { flex: 1; min-width: 0; }
        .invoice-title {
            font-weight: 700; font-size: 14px;
            color: var(--text);
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .invoice-num {
            font-size: 11px;
            color: var(--text-muted);
            font-family: monospace;
            direction: ltr;
        }
        .invoice-amount {
            font-weight: 800;
            color: var(--gold-dark);
            font-size: 14px;
            white-space: nowrap;
        }
        [data-theme="dark"] .invoice-amount { color: var(--gold); }
        .invoice-arrow {
            color: var(--text-muted);
            font-size: 14px;
            transition: all 0.3s;
        }
        .invoice-row:hover .invoice-arrow {
            color: var(--gold);
            transform: translateX(-4px);
        }

        /* ============================================================
        PAST RESERVATIONS (Compact)
        ============================================================ */
        .past-row {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-bottom: 8px;
            transition: all 0.3s;
            font-size: 13px;
        }
        .past-row:hover {
            background: var(--bg-soft);
            border-color: var(--border-light);
        }
        .past-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: var(--status-color, #60a5fa);
            flex-shrink: 0;
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--status-color) 20%, transparent);
        }
        .past-title {
            flex: 1; min-width: 0;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .past-date {
            font-size: 11px;
            color: var(--text-muted);
            direction: ltr;
        }

        /* ============================================================
        EMPTY STATE
        ============================================================ */
        .empty-state {
            text-align: center;
            padding: 44px 20px;
            color: var(--text-muted);
        }
        .empty-icon {
            width: 80px; height: 80px;
            border-radius: 24px;
            background: var(--bg-soft);
            color: var(--text-light);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 34px;
            margin-bottom: 18px;
        }
        .empty-state h4 {
            font-size: 16px;
            color: var(--text);
            margin-bottom: 6px;
            font-weight: 700;
        }
        .empty-state p {
            font-size: 13px;
            margin-bottom: 18px;
        }
        .empty-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 26px;
            border-radius: 9999px;
            background: var(--gold-gradient);
            color: #fff;
            font-weight: 700; font-size: 13px;
            transition: all 0.35s;
            box-shadow: 0 8px 22px rgba(212, 163, 115, 0.3);
        }
        .empty-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 35px rgba(212, 163, 115, 0.45);
        }

        /* ============================================================
        TOAST
        ============================================================ */
        .toast-container {
            position: fixed; bottom: 30px; left: 30px;
            z-index: 99999;
            display: flex; flex-direction: column; gap: 12px;
        }
        .toast-item {
            display: flex; align-items: center; gap: 14px;
            padding: 16px 22px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            min-width: 300px; max-width: 420px;
            font-size: 14px; font-weight: 600;
            color: var(--text);
            animation: toastIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }
        .toast-item::before {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 4px;
            background: var(--toast-color);
        }
        .toast-item i {
            font-size: 20px;
            color: var(--toast-color);
            flex-shrink: 0;
        }
        .toast-success { --toast-color: #34d399; }
        .toast-error { --toast-color: #fb7185; }
        .toast-info { --toast-color: #60a5fa; }
        .toast-warning { --toast-color: #fbbf24; }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(-100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* ============================================================
        RESPONSIVE
        ============================================================ */
        @media (max-width: 1200px) {
            .dashboard-grid { grid-template-columns: 1fr 340px; }
        }
        @media (max-width: 992px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .quick-actions-grid { grid-template-columns: repeat(2, 1fr); }
            .dashboard-grid { grid-template-columns: 1fr; }
            .nav-desktop { display: none; }
            .hero-text h1 { font-size: 24px; }
        }
        @media (max-width: 576px) {
            .container { padding: 0 16px; }
            .hero { padding: 40px 0 120px; }
            .hero-avatar { width: 60px; height: 60px; font-size: 22px; }
            .hero-text h1 { font-size: 20px; }
            .hero-text p { font-size: 12px; }
            .stats-grid { grid-template-columns: 1fr; }
            .quick-actions-grid { grid-template-columns: 1fr 1fr; }
            .stat-value { font-size: 22px; }
            .res-body { flex-wrap: wrap; padding: 14px; gap: 10px; }
            .res-actions { width: 100%; align-items: stretch; }
            .dropdown-menu { left: auto; right: 0; }
        }
    </style>
</head>
<body>

        @include('partials.header')
    <!-- ============================================================
    HERO
    ============================================================ -->
    <section class="hero">
        <div class="container hero-content">
            <div class="hero-greeting">
                <div class="hero-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="hero-text">
                    <h1>سلام، <span class="gold-name">{{ $user->display_name }}</span>!</h1>
                    <p>
                        <i class="fas fa-circle"></i>
                        خوش آمدید به پنل کاربری GRAFIUM
                    </p>
                </div>
            </div>
            <div class="hero-actions">
                <a href="{{ route('services') }}" class="btn" style="display:inline-flex;align-items:center;gap:10px;padding:13px 26px;border-radius:9999px;background:var(--gold-gradient);color:#fff;font-weight:700;font-size:14px;box-shadow:0 10px 30px rgba(212,163,115,0.35);transition:all 0.35s;">
                    <i class="fas fa-plus-circle"></i>
                    <span>رزرو جدید</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================
    STATS (Overlapping)
    ============================================================ -->
    <div class="container stats-wrapper">
        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-value">{{ $stats['active_reservations'] }}</div>
                <div class="stat-label">رزرو فعال</div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon"><i class="fas fa-check-double"></i></div>
                <div class="stat-value">{{ $stats['completed_reservations'] }}</div>
                <div class="stat-label">تکمیل شده</div>
            </div>
            <div class="stat-card amber">
                <div class="stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <div class="stat-value">{{ $stats['pending_invoices'] }}</div>
                <div class="stat-label">فاکتور در انتظار</div>
            </div>
            <div class="stat-card purple">
                <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                <div class="stat-value">{{ number_format($stats['total_paid']) }}</div>
                <div class="stat-label">مجموع پرداخت (تومان)</div>
            </div>
        </div>
    </div>

    <div class="container">

        <!-- ============================================================
        QUICK ACTIONS
        ============================================================ -->
        <div class="quick-actions-grid">
            <a href="{{ route('services') }}" class="quick-action">
                <div class="quick-action-icon"><i class="fas fa-plus"></i></div>
                <span>رزرو جدید</span>
                <small>خدمات موجود</small>
            </a>
            <a href="{{ route('reservations.index') }}" class="quick-action">
                <div class="quick-action-icon"><i class="fas fa-calendar-alt"></i></div>
                <span>رزروها</span>
                <small>مشاهده همه</small>
            </a>
            <a href="{{ route('invoices.index') }}" class="quick-action">
                <div class="quick-action-icon"><i class="fas fa-file-invoice"></i></div>
                <span>فاکتورها</span>
                <small>مالی</small>
            </a>
            <a href="{{ route('profile.edit') }}" class="quick-action">
                <div class="quick-action-icon"><i class="fas fa-user-cog"></i></div>
                <span>تنظیمات</span>
                <small>ویرایش پروفایل</small>
            </a>
        </div>

        <!-- ============================================================
        NOTIFICATIONS
        ============================================================ -->
        @if(!empty($notifications))
            <div class="notifications-list">
                @foreach($notifications as $notif)
                    <div class="notification-item {{ $notif['type'] }}">
                        <div class="notification-icon">
                            <i class="fas {{ $notif['icon'] }}"></i>
                        </div>
                        <div class="notification-body">
                            <div class="notification-title">{{ $notif['title'] }}</div>
                            <div class="notification-message">{{ $notif['message'] }}</div>
                            @if(!empty($notif['link']))
                                <a href="{{ $notif['link'] }}" class="notification-link">
                                    مشاهده <i class="fas fa-arrow-left"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- ============================================================
        MAIN GRID
        ============================================================ -->
        <div class="dashboard-grid">

            <!-- ===== MAIN COLUMN ===== -->
            <div class="dashboard-main">

                <!-- Active Reservations -->
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <span class="icon-badge"><i class="fas fa-calendar-check"></i></span>
                            رزروهای فعال
                        </h3>
                        <a href="{{ route('reservations.index') }}">
                            مشاهده همه <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                    <div class="section-body">
                        @forelse($activeReservations as $res)
                            @php
                                $statusColors = [
                                    'pending' => '#fbbf24',
                                    'active' => '#34d399',
                                    'completed' => '#60a5fa',
                                    'cancelled' => '#fb7185',
                                ];
                                $color = $statusColors[$res->status] ?? '#60a5fa';
                            @endphp
                            <div class="reservation-card" data-id="{{ $res->id }}">
                                <div class="res-side-bar" style="--status-color: {{ $color }}; background: {{ $color }};"></div>
                                <div class="res-body">
                                    <div class="res-icon">
                                        <i class="fas fa-desktop"></i>
                                    </div>
                                    <div class="res-info">
                                        <div class="res-title">{{ $res->service->title ?? 'خدمت' }}</div>
                                        <div class="res-meta">
                                            <span><i class="fas fa-calendar"></i> {{ $res->reservation_date ? $res->reservation_date->format('Y/m/d') : '-' }}</span>
                                            <span><i class="fas fa-clock"></i> {{ $res->shift_persian ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="res-actions">
                                        <span class="res-badge badge-{{ $res->status }}">
                                            {{ $res->status_persian ?? $res->status }}
                                        </span>
                                        <span class="res-price">{{ number_format($res->total_price) }} ت</span>
                                        <button type="button" class="btn-cancel" onclick="cancelReservation({{ $res->id }})">
                                            <i class="fas fa-times"></i> لغو
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-calendar-times"></i></div>
                                <h4>هنوز رزروی نداری!</h4>
                                <p>برای شروع، یه خدمت رزرو کن</p>
                                <a href="{{ route('services') }}" class="empty-btn">
                                    <i class="fas fa-plus"></i> مشاهده خدمات
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chart -->
                <div class="section-card chart-section">
                    <div class="section-header">
                        <h3>
                            <span class="icon-badge"><i class="fas fa-chart-line"></i></span>
                            نمودار رزروها
                        </h3>
                        <span style="font-size: 12px; color: var(--text-muted);">۶ ماه اخیر</span>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <!-- Past Reservations -->
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <span class="icon-badge"><i class="fas fa-history"></i></span>
                            رزروهای گذشته
                        </h3>
                        <a href="{{ route('reservations.index') }}">
                            مشاهده همه <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                    <div class="section-body">
                        @forelse($pastReservations as $res)
                            @php
                                $pastColors = [
                                    'completed' => '#34d399',
                                    'cancelled' => '#fb7185',
                                    'expired' => '#94a3b8',
                                ];
                                $pcolor = $pastColors[$res->status] ?? '#60a5fa';
                            @endphp
                            <div class="past-row">
                                <span class="past-dot" style="--status-color: {{ $pcolor }}; background: {{ $pcolor }};"></span>
                                <span class="past-title">{{ $res->service->title ?? 'خدمت' }}</span>
                                <span class="past-date">{{ $res->reservation_date ? $res->reservation_date->format('Y/m/d') : '-' }}</span>
                                <span class="res-badge badge-{{ $res->status }}">
                                    {{ $res->status_persian ?? $res->status }}
                                </span>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                                <p>رزرو گذشته‌ای نداری</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- ===== SIDE COLUMN ===== -->
            <div class="dashboard-side">

                <!-- Profile -->
                <div class="profile-card-v2">
                    <div class="profile-cover"></div>
                    <div class="profile-avatar-wrap">
                        <div class="profile-avatar-v2">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="profile-name-v2">{{ $user->display_name }}</div>
                    <span class="profile-phone-v2">{{ $user->phone }}</span>

                    <div class="profile-info-v2">
                        <div class="profile-info-row">
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                            <span class="label">ایمیل</span>
                            <span class="value">{{ $user->email ?: '—' }}</span>
                        </div>
                        <div class="profile-info-row">
                            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                            <span class="label">آدرس</span>
                            <span class="value rtl">{{ $user->address ? \Str::limit($user->address, 18) : '—' }}</span>
                        </div>
                        <div class="profile-info-row">
                            <div class="icon"><i class="fas fa-clock"></i></div>
                            <span class="label">آخرین ورود</span>
                            <span class="value rtl">{{ $user->last_login ? $user->last_login->diffForHumans() : 'الان' }}</span>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="btn-edit-profile-v2">
                        <i class="fas fa-user-edit"></i>
                        ویرایش اطلاعات
                    </a>
                </div>

                <!-- Invoices -->
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <span class="icon-badge"><i class="fas fa-file-invoice-dollar"></i></span>
                            فاکتورها
                        </h3>
                        <a href="{{ route('invoices.index') }}">
                            همه <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                    <div class="section-body">
                        <div class="invoice-list">
                            @forelse($invoices as $inv)
                                <a href="{{ route('invoices.show', $inv->id) }}" class="invoice-row">
                                    <div class="invoice-icon-wrap">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div class="invoice-info">
                                        <div class="invoice-title">{{ $inv->title ?? 'فاکتور' }}</div>
                                        <div class="invoice-num">{{ $inv->invoice_number }}</div>
                                    </div>
                                    <div class="invoice-amount">{{ number_format($inv->final_amount) }} ت</div>
                                    <i class="fas fa-arrow-left invoice-arrow"></i>
                                </a>
                            @empty
                                <div class="empty-state" style="padding: 24px 10px;">
                                    <div class="empty-icon" style="width: 60px; height: 60px; font-size: 24px;"><i class="fas fa-receipt"></i></div>
                                    <p style="font-size: 12px;">فاکتوری نداری</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div style="height: 40px;"></div>

    </div>

    <!-- ============================================================
    TOAST
    ============================================================ -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // ============================================================
        // THEME
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
        // USER DROPDOWN
        // ============================================================
        const avatarBtn = document.getElementById('avatarBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        avatarBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu?.classList.toggle('open');
        });
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.user-dropdown')) {
                dropdownMenu?.classList.remove('open');
            }
        });

        // ============================================================
        // LOGOUT
        // ============================================================
        document.getElementById('logoutBtn')?.addEventListener('click', async () => {
            if (!confirm('آیا از خروج اطمینان دارید؟')) return;
            try {
                await fetch('{{ route("logout") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });
                window.location.href = '{{ route("home") }}';
            } catch (e) {
                window.location.href = '{{ route("home") }}';
            }
        });

        // ============================================================
        // TOAST
        // ============================================================
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const icons = { success: 'fa-check-circle', error: 'fa-exclamation-circle', info: 'fa-info-circle', warning: 'fa-exclamation-triangle' };
            const toast = document.createElement('div');
            toast.className = `toast-item toast-${type}`;
            toast.innerHTML = `<i class="fas ${icons[type]}"></i><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(-100px)';
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

        // ============================================================
        // CANCEL RESERVATION
        // ============================================================
        async function cancelReservation(id) {
            if (!confirm('آیا از لغو این رزرو اطمینان دارید؟')) return;
            try {
                const res = await fetch(`/dashboard/reservations/${id}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });
                const data = await res.json();
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(data.message || 'خطا در لغو', 'error');
                }
            } catch (err) {
                showToast('خطا در ارتباط با سرور', 'error');
            }
        }

        // ============================================================
        // CHART
        // ============================================================
        const chartData = @json($chartData);
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';

        if (document.getElementById('monthlyChart')) {
            const ctx = document.getElementById('monthlyChart').getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(212, 163, 115, 0.5)');
            gradient.addColorStop(1, 'rgba(212, 163, 115, 0.02)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'تعداد رزرو',
                        data: chartData.counts,
                        borderColor: '#d4a373',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.45,
                        pointBackgroundColor: '#d4a373',
                        pointBorderColor: isDark ? '#0f1f33' : '#fff',
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 9,
                        pointHoverBackgroundColor: '#b8874a',
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDark ? '#0f1f33' : '#fff',
                            titleColor: isDark ? '#fff' : '#0a1628',
                            bodyColor: '#d4a373',
                            borderColor: '#d4a373',
                            borderWidth: 2,
                            padding: 14,
                            cornerRadius: 12,
                            displayColors: false,
                            titleFont: { family: 'Vazirmatn', size: 13, weight: '700' },
                            bodyFont: { family: 'Vazirmatn', size: 13, weight: '600' },
                            callbacks: {
                                label: (ctx) => `${ctx.parsed.y} رزرو`,
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: isDark ? '#94a3b8' : '#6b7a8a',
                                font: { family: 'Vazirmatn', size: 11 },
                            },
                            grid: { color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)', drawBorder: false },
                        },
                        x: {
                            ticks: {
                                color: isDark ? '#94a3b8' : '#6b7a8a',
                                font: { family: 'Vazirmatn', size: 12 },
                            },
                            grid: { display: false },
                        },
                    },
                },
            });
        }
    </script>

</body>
</html>