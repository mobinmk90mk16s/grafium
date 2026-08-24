<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>پنل مدیریت | Grafioum</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        /* ===== Reset & Base ===== */
        * {
            font-family: 'Vazirmatn', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #0f172a;
            direction: rtl;
            scroll-behavior: smooth;
        }

        /* ===== Scrollbar ===== */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: var(--primary-color, #2563eb); border-radius: 10px; }

        /* ===== Sidebar ===== */
        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: var(--primary-color, #2563eb); border-radius: 10px; }

        .sidebar-transition {
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== Nav Items ===== */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            color: rgba(255,255,255,0.6);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 2px;
            position: relative;
            transform: scale(1);
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: white;
            transform: scale(1.02) translateX(-4px);
        }
        .nav-item.active {
            background: rgba(255,255,255,0.12);
            color: white;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: var(--primary-color, #2563eb);
            border-radius: 0 4px 4px 0;
            transition: height 0.25s ease;
        }
        .nav-item .lucide { width: 20px; height: 20px; flex-shrink: 0; transition: transform 0.3s ease; }
        .nav-item:hover .lucide { transform: scale(1.15); }
        .nav-item .badge {
            margin-right: auto;
            background: var(--primary-color, #2563eb);
            color: white;
            font-size: 10px;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .nav-item:hover .badge { transform: scale(1.05); background: #fff; color: var(--primary-color); }
        .nav-section {
            color: rgba(255,255,255,0.3);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px 16px 6px;
            font-weight: 700;
        }
        .nav-section:first-of-type { padding-top: 4px; }

        /* ===== Sidebar divider ===== */
        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,0.06);
            margin: 6px 16px;
        }

        /* ===== Page Content (Smooth Transitions) ===== */
        .page-content {
            display: none;
            animation: none;
        }
        .page-content.active {
            display: block;
            animation: fadeSlideIn 0.5s cubic-bezier(0.2, 0, 0, 1) forwards;
        }

        @keyframes fadeSlideIn {
            0% { opacity: 0; transform: translateY(18px) scale(0.98); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ===== Staggered Cards & Charts ===== */
        .stat-card,
        .chart-card,
        .table-card {
            opacity: 0;
            animation: fadeScaleIn 0.6s cubic-bezier(0.2, 0, 0, 1) forwards;
        }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.20s; }
        .chart-card:nth-child(1) { animation-delay: 0.15s; }
        .chart-card:nth-child(2) { animation-delay: 0.25s; }
        .table-card { animation-delay: 0.30s; }

        @keyframes fadeScaleIn {
            0% { opacity: 0; transform: scale(0.92) translateY(12px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* ===== Color-Coded Cards ===== */
        .stat-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255,255,255,0.06);
            position: relative;
            overflow: hidden;
            cursor: default;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            border-radius: 0 4px 4px 0;
            transition: all 0.3s ease;
        }
        .stat-card:hover::after {
            width: 6px;
        }
        .stat-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 20px 50px rgba(0,0,0,0.30);
        }

        .stat-card.orange::after { background: #f97316; }
        .stat-card.orange .icon-bg { background: #f97316; color: white; }
        .stat-card.orange:hover { box-shadow: 0 16px 40px rgba(249,115,22,0.25); }

        .stat-card.blue::after { background: #2563eb; }
        .stat-card.blue .icon-bg { background: #2563eb; color: white; }
        .stat-card.blue:hover { box-shadow: 0 16px 40px rgba(37,99,235,0.25); }

        .stat-card.green::after { background: #22c55e; }
        .stat-card.green .icon-bg { background: #22c55e; color: white; }
        .stat-card.green:hover { box-shadow: 0 16px 40px rgba(34,197,94,0.25); }

        .stat-card.purple::after { background: #8b5cf6; }
        .stat-card.purple .icon-bg { background: #8b5cf6; color: white; }
        .stat-card.purple:hover { box-shadow: 0 16px 40px rgba(139,92,246,0.25); }

        .stat-card .icon-bg {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.4s ease;
        }
        .stat-card:hover .icon-bg {
            transform: scale(1.05) rotate(-4deg);
        }
        .stat-card .icon-bg .lucide { width: 24px; height: 24px; }

        /* ===== Badges ===== */
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-shipped { background: #dbeafe; color: #1e40af; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #f3f4f6; color: #4b5563; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .badge {
            transition: all 0.3s ease;
            display: inline-block;
        }
        .badge:hover { transform: scale(1.05); }

        /* ===== Form Inputs ===== */
        .form-input {
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 10px 14px;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #1e293b;
            color: #f1f5f9;
        }
        .form-input:focus {
            border-color: var(--primary-color, #2563eb);
            outline: none;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
            transform: scale(1.01);
        }
        .form-input::placeholder { color: #94a3b8; }

        /* ===== Table Wrapper ===== */
        .table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table-wrap::-webkit-scrollbar { height: 4px; }
        .table-wrap::-webkit-scrollbar-thumb { background: var(--primary-color, #2563eb); border-radius: 10px; }

        tbody tr {
            transition: all 0.25s ease;
        }
        tbody tr:hover td {
            background: rgba(255,255,255,0.03);
        }

        /* ===== Dropdown Menu (Smooth) ===== */
        .dropdown-menu {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            pointer-events: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: #1e293b;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            min-width: 220px;
            padding: 8px;
            z-index: 100;
            border: 1px solid #334155;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top right;
        }
        .dropdown-menu.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }
        .dropdown-menu .item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: #f1f5f9;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 14px;
        }
        .dropdown-menu .item:hover {
            background: #334155;
            transform: translateX(-4px);
        }
        .dropdown-menu .item .lucide {
            width: 18px;
            height: 18px;
            color: #94a3b8;
            transition: transform 0.2s ease;
        }
        .dropdown-menu .item:hover .lucide { transform: scale(1.1); }
        .dropdown-menu .divider { height: 1px; background: #334155; margin: 4px 8px; }
        .dropdown-menu .item.danger { color: #ef4444; }
        .dropdown-menu .item.danger .lucide { color: #ef4444; }

        /* ===== Theme Toggle (Dark Mode) ===== */
        .theme-toggle {
            width: 52px;
            height: 28px;
            background: #475569;
            border-radius: 20px;
            cursor: pointer;
            position: relative;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
        }
        .theme-toggle .thumb {
            width: 22px;
            height: 22px;
            background: #f1f5f9;
            border-radius: 50%;
            position: absolute;
            top: 3px;
            right: 3px;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .theme-toggle .thumb .lucide {
            width: 14px;
            height: 14px;
            color: #f59e0b;
            transition: transform 0.4s ease;
        }
        .theme-toggle.light {
            background: #cbd5e1;
        }
        .theme-toggle.light .thumb {
            right: calc(100% - 25px);
            background: #f8fafc;
        }
        .theme-toggle.light .thumb .lucide {
            color: #f59e0b;
            transform: rotate(20deg);
        }

        /* ===== Online Status ===== */
        .online-status {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background: #22c55e;
            border: 2px solid #1e293b;
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        .notif-dot {
            position: absolute;
            top: 1px;
            left: 1px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #1e293b;
            animation: pulse-dot 1.8s infinite;
        }

        /* ===== Color Picker ===== */
        .color-option {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .color-option:hover { transform: scale(1.15) rotate(-10deg); }
        .color-option.active { border-color: #f1f5f9; transform: scale(1.1); }

        /* ===== Mobile Overlay ===== */
        .mobile-overlay {
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            transition: opacity 0.3s ease;
        }
        .mobile-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }
        .mobile-overlay:not(.hidden) {
            opacity: 1;
            pointer-events: all;
        }

        /* ===== Chart containers ===== */
        .chart-container { position: relative; height: 240px; }
        .chart-container-lg { height: 280px; }

        /* ===== Theme variables ===== */
        :root {
            --primary-color: #2563eb;
            --sidebar-bg: #0f172a;
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --text-color: #f1f5f9;
            --text-muted: #94a3b8;
            --border-color: #334155;
        }
        [data-theme="light"] {
            --bg-color: #f1f5f9;
            --card-bg: #ffffff;
            --text-color: #1a1a2e;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }
        body {
            background: var(--bg-color);
            color: var(--text-color);
            transition: background 0.4s ease, color 0.3s ease;
        }
        .bg-white { background: var(--card-bg) !important; transition: background 0.3s ease; }
        .border-gray-100 { border-color: var(--border-color) !important; transition: border 0.3s ease; }
        .border-gray-200 { border-color: var(--border-color) !important; }
        .text-gray-800 { color: var(--text-color) !important; }
        .text-gray-600 { color: var(--text-muted) !important; }
        .text-gray-500 { color: var(--text-muted) !important; }
        .text-gray-700 { color: var(--text-color) !important; }
        .bg-gray-50 { background: var(--bg-color) !important; }
        .bg-gray-100 { background: var(--bg-color) !important; }

        [data-theme="light"] .stat-card { border-color: #e5e7eb; }
        [data-theme="light"] .form-input { background: #ffffff; border-color: #e2e8f0; color: #1a1a2e; }
        [data-theme="light"] .form-input:focus { border-color: var(--primary-color); }
        [data-theme="light"] .dropdown-menu { background: #ffffff; border-color: #e5e7eb; }
        [data-theme="light"] .dropdown-menu .item { color: #374151; }
        [data-theme="light"] .dropdown-menu .item:hover { background: #f3f4f6; }
        [data-theme="light"] .dropdown-menu .divider { background: #e5e7eb; }
        [data-theme="light"] .dropdown-menu .item .lucide { color: #6b7280; }
        [data-theme="light"] .table-wrap table { color: #1a1a2e; }
        [data-theme="light"] thead { background: #f8fafc; }
        [data-theme="light"] thead th { color: #6b7280; }
        [data-theme="light"] td { border-color: #e5e7eb; }
        [data-theme="light"] tr:hover td { background: #f8fafc; }
        [data-theme="light"] .online-status { border-color: #ffffff; }
        [data-theme="light"] .notif-dot { border-color: #ffffff; }
        [data-theme="light"] .avatar-container .online-status { border-color: #ffffff; }

        /* ===== Avatar ===== */
        .avatar-container {
            position: relative;
            display: inline-block;
        }
        .avatar-container .avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid transparent;
            transition: transform 0.3s ease;
        }
        .avatar-container:hover .avatar-img { transform: scale(1.05); }

        /* ===== Button hover ===== */
        .btn-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-hover:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0,0,0,0.20);
        }

        /* ===== AI Chat - Typewriter ===== */
        .chat-container {
            max-height: 420px;
            overflow-y: auto;
            padding-right: 4px;
        }
        .chat-container::-webkit-scrollbar { width: 4px; }
        .chat-container::-webkit-scrollbar-track { background: transparent; }
        .chat-container::-webkit-scrollbar-thumb { background: var(--primary-color, #2563eb); border-radius: 10px; }

        .chat-bubble {
            animation: chatPop 0.4s cubic-bezier(0.2, 0, 0, 1) forwards;
            opacity: 0;
            transform: scale(0.95) translateY(10px);
        }
        @keyframes chatPop {
            0% { opacity: 0; transform: scale(0.95) translateY(10px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        .quick-btn {
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .quick-btn:hover {
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .quick-btn .lucide {
            width: 16px;
            height: 16px;
        }

        /* ===== Slider Management ===== */
        .slider-preview {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #334155;
        }
        [data-theme="light"] .slider-preview {
            border-color: #e5e7eb;
        }

        /* ===== Calendar ===== */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }
        .calendar-grid .day {
            padding: 8px 4px;
            text-align: center;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s;
            cursor: default;
        }
        .calendar-grid .day.other-month {
            color: #64748b;
        }
        .calendar-grid .day.today {
            background: var(--primary-color);
            color: white;
            font-weight: 700;
        }
        .calendar-grid .day.has-event {
            position: relative;
        }
        .calendar-grid .day.has-event::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 50%;
        }
        [data-theme="light"] .calendar-grid .day.other-month {
            color: #94a3b8;
        }
        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-bottom: 8px;
        }
        .calendar-header .day-name {
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
            padding: 4px 0;
        }

        /* ===== DataTables-like ===== */
        .dataTable-search {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dataTable-search input {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 6px;
            padding: 6px 12px;
            color: #f1f5f9;
            font-size: 14px;
            width: 200px;
        }
        .dataTable-search input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        }
        [data-theme="light"] .dataTable-search input {
            background: #ffffff;
            border-color: #e2e8f0;
            color: #1a1a2e;
        }
        .dataTable-pagination {
            display: flex;
            gap: 4px;
            justify-content: flex-end;
            margin-top: 12px;
        }
        .dataTable-pagination button {
            padding: 4px 12px;
            border: 1px solid #334155;
            border-radius: 4px;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.2s;
        }
        .dataTable-pagination button:hover {
            background: #334155;
            color: white;
        }
        .dataTable-pagination button.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        [data-theme="light"] .dataTable-pagination button {
            border-color: #e2e8f0;
            color: #64748b;
        }
        [data-theme="light"] .dataTable-pagination button:hover {
            background: #f1f5f9;
        }
        [data-theme="light"] .dataTable-pagination button.active {
            background: var(--primary-color);
            color: white;
        }

        .slider-thumbnail {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* ===== Fix for login ===== */
        #loginPage {
            display: flex !important;
        }
        #adminPanel {
            display: none !important;
        }
        #adminPanel.show {
            display: flex !important;
        }
    </style>

<style id="grafioum-runtime-safety">
@media (min-width:768px){
  #sidebar{transform:translateX(0)!important;visibility:visible!important}
}
@media (max-width:767px){
  #sidebar{transition:transform.25s ease}
}
</style>

<style id="grafioum-auth-visibility-fix">
#loginPage.logged-in-hidden {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
}
#adminPanel.show {
    display: flex !important;
    visibility: visible !important;
    opacity: 1 !important;
}
</style>

</head>
<body>

    <!-- ===== LOGIN PAGE ===== -->
    <div id="loginPage" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#0f172a] p-4">
        <div class="w-full max-w-md bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 md:p-10 shadow-2xl animate-[fadeScaleIn_0.6s_ease]">
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <i data-lucide="store" class="text-white w-8 h-8"></i>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-white">پنل مدیریت Grafioum</h2>
                <p class="text-white/50 text-sm mt-1">برای ورود اطلاعات خود را وارد کنید</p>
            </div>
            <form id="loginForm" class="mt-8 space-y-5">
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-1">نام کاربری</label>
                    <input type="text" id="username" value="admin" class="w-full bg-white/10 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-white/30 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-300">
                </div>
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-1">رمز عبور</label>
                    <input type="password" id="password" value="1234" class="w-full bg-white/10 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-white/30 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-300">
                </div>
                <button type="submit" id="loginBtn" class="w-full py-3.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    ورود به پنل
                </button>
            </form>
            <p class="text-white/30 text-xs text-center mt-6">سیستم مدیریت پیشرفته Grafioum</p>
        </div>
    </div>

    <!-- ===== ADMIN PANEL ===== -->
    <div id="adminPanel" class="flex min-h-screen">

        <!-- ===== SIDEBAR ===== -->
        <aside id="sidebar" class="fixed inset-y-0 right-0 w-[280px] bg-[#0f172a] text-white shadow-2xl z-50 sidebar-scroll overflow-y-auto sidebar-transition translate-x-0">
            <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <i data-lucide="store" class="text-white w-6 h-6"></i>
                </div>
                <span class="text-xl font-bold tracking-tight">Grafioum</span>
            </div>

            <nav class="px-4 py-3">
                <div class="nav-section">داشبورد</div>
                <a href="#" class="nav-item active" data-page="dashboard">
                    <i data-lucide="layout-dashboard"></i>
                    <span>داشبورد</span>
                </a>

                <div class="sidebar-divider"></div>

                <div class="nav-section">مدیریت</div>
                <a href="#" class="nav-item" data-page="products">
                    <i data-lucide="package"></i>
                    <span>محصولات</span>
                    <span class="badge">50</span>
                </a>
                <a href="#" class="nav-item" data-page="categories">
                    <i data-lucide="tags"></i>
                    <span>دسته‌بندی‌ها</span>
                </a>
                <a href="#" class="nav-item" data-page="orders">
                    <i data-lucide="shopping-bag"></i>
                    <span>سفارشات</span>
                    <span class="badge">70</span>
                </a>
                <a href="#" class="nav-item" data-page="users">
                    <i data-lucide="users"></i>
                    <span>کاربران</span>
                    <span class="badge">90</span>
                </a>
                <a href="#" class="nav-item" data-page="reviews">
                    <i data-lucide="star"></i>
                    <span>نظرات</span>
                </a>
                <a href="#" class="nav-item" data-page="coupons">
                    <i data-lucide="ticket"></i>
                    <span>کدهای تخفیف</span>
                </a>
                <a href="#" class="nav-item" data-page="banners">
                    <i data-lucide="image"></i>
                    <span>بنرها</span>
                </a>

                <div class="sidebar-divider"></div>

                <div class="nav-section">گزارشات</div>
                <a href="#" class="nav-item" data-page="reports">
                    <i data-lucide="bar-chart-3"></i>
                    <span>گزارشات فروش</span>
                </a>
                <a href="#" class="nav-item" data-page="analytics">
                    <i data-lucide="trending-up"></i>
                    <span>تحلیل‌ها</span>
                </a>

                <div class="sidebar-divider"></div>

                <div class="nav-section">ابزارها</div>
                <a href="#" class="nav-item" data-page="sliders">
                    <i data-lucide="images"></i>
                    <span>مدیریت اسلایدر</span>
                </a>
                <a href="#" class="nav-item" data-page="calendar">
                    <i data-lucide="calendar"></i>
                    <span>تقویم</span>
                </a>
                <a href="#" class="nav-item" data-page="datatable">
                    <i data-lucide="table"></i>
                    <span>جدول داده</span>
                </a>

                <div class="sidebar-divider"></div>

                <div class="nav-section">سیستم</div>
                <a href="#" class="nav-item" data-page="settings">
                    <i data-lucide="settings"></i>
                    <span>تنظیمات</span>
                </a>
                <a href="#" class="nav-item" data-page="ai">
                    <i data-lucide="bot"></i>
                    <span>هوش مصنوعی</span>
                </a>
            </nav>

            <div class="border-t border-white/10 p-4 mt-auto">
                <div class="flex items-center gap-3">
                    <div class="avatar-container">
                        <img src="https://ui-avatars.com/api/?name=مدیر+سیستم&background=2563eb&color=fff&bold=true&size=40"
                        alt="avatar"
                        class="avatar-img w-10 h-10 rounded-full object-cover border-2 border-white/20">
                        <span class="online-status"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-white">مدیر سیستم</div>
                        <div class="text-xs text-white/40">مدیر ارشد</div>
                    </div>
                    <button id="logoutBtn" class="text-white/30 hover:text-red-400 transition duration-300 transform hover:scale-110">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- ===== MOBILE SIDEBAR OVERLAY ===== -->
        <div id="mobileOverlay" class="fixed inset-0 z-40 mobile-overlay hidden" onclick="closeMobileMenu()"></div>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="flex-1 mr-0 md:mr-[280px] transition-all duration-300 p-4 md:p-6">

            <!-- ===== TOP HEADER ===== -->
            <header class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-800 transition duration-300">
                        <i data-lucide="menu" class="w-6 h-6 text-gray-300"></i>
                    </button>
                    <h1 id="pageTitle" class="text-2xl font-bold text-gray-100 transition-colors duration-300">داشبورد <span class="text-blue-500">مدیریت</span></h1>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <div class="relative group">
                        <i data-lucide="search" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 transition-colors group-focus-within:text-blue-500"></i>
                        <input type="text" id="globalSearch" placeholder="جستجو..." class="pr-10 pl-4 py-2 border border-gray-700 rounded-lg text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all duration-300 w-48 md:w-64 bg-[#1e293b] text-gray-100 placeholder-gray-500 focus:w-56 md:focus:w-72">
                    </div>

                    <button class="relative p-2 bg-[#1e293b] rounded-lg shadow-sm hover:shadow transition-all duration-300 hover:scale-105">
                        <i data-lucide="bell" class="w-5 h-5 text-gray-300"></i>
                        <span class="notif-dot"></span>
                    </button>

                    <!-- Theme Toggle -->
                    <div class="theme-toggle" id="themeToggle">
                        <div class="thumb">
                            <i data-lucide="moon" class="w-3.5 h-3.5 text-blue-400"></i>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profileBtn" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-800 transition duration-300 bg-[#1e293b] shadow-sm hover:shadow">
                            <div class="avatar-container">
                                <img src="https://ui-avatars.com/api/?name=مدیر+سیستم&background=2563eb&color=fff&bold=true&size=32"
                                alt="avatar"
                                class="avatar-img w-8 h-8 rounded-full object-cover">
                                <span class="online-status" style="width:10px;height:10px;border-width:2px;"></span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform duration-300"></i>
                        </button>

                        <div class="dropdown-menu" id="profileDropdown">
                            <div class="item">
                                <i data-lucide="user"></i>
                                <span>پروفایل من</span>
                            </div>
                            <div class="item">
                                <i data-lucide="settings"></i>
                                <span>تنظیمات</span>
                            </div>
                            <div class="divider"></div>
                            <div class="item">
                                <i data-lucide="help-circle"></i>
                                <span>سوال‌های متداول</span>
                            </div>
                            <div class="item">
                                <i data-lucide="tag"></i>
                                <span>قیمت‌گذاری</span>
                            </div>
                            <div class="divider"></div>
                            <div class="item danger" id="logoutDropdown">
                                <i data-lucide="log-out"></i>
                                <span>خروج از حساب</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ===== DASHBOARD ===== -->
            <div id="dashboard-page" class="page-content active">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="stat-card orange bg-[#1e293b] rounded-xl shadow-sm p-5 border border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="icon-bg">
                                <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">سفارشات امروز</p>
                                <p class="text-2xl font-bold text-gray-100" id="todayOrders">124</p>
                                <p class="text-xs text-green-400 flex items-center gap-1">
                                    <i data-lucide="arrow-up" class="w-3 h-3"></i> ۱۲٪ نسبت به دیروز
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card blue bg-[#1e293b] rounded-xl shadow-sm p-5 border border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="icon-bg">
                                <i data-lucide="credit-card" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">فروش امروز</p>
                                <p class="text-2xl font-bold text-gray-100" id="todaySales">۲۴۵,۸۰۰,۰۰۰</p>
                                <p class="text-xs text-green-400 flex items-center gap-1">
                                    <i data-lucide="arrow-up" class="w-3 h-3"></i> ۸٪ نسبت به دیروز
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card green bg-[#1e293b] rounded-xl shadow-sm p-5 border border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="icon-bg">
                                <i data-lucide="user-plus" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">کاربران جدید</p>
                                <p class="text-2xl font-bold text-gray-100" id="newUsers">47</p>
                                <p class="text-xs text-green-400 flex items-center gap-1">
                                    <i data-lucide="arrow-up" class="w-3 h-3"></i> ۲۳٪ نسبت به دیروز
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card purple bg-[#1e293b] rounded-xl shadow-sm p-5 border border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="icon-bg">
                                <i data-lucide="package" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">محصولات</p>
                                <p class="text-2xl font-bold text-gray-100" id="totalProducts">1,245</p>
                                <p class="text-xs text-red-400 flex items-center gap-1">
                                    <i data-lucide="arrow-down" class="w-3 h-3"></i> ۳٪ نسبت به ماه قبل
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="chart-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-gray-100">نمودار فروش ماهانه</h3>
                            <span class="text-xs text-gray-400 bg-gray-800 px-3 py-1 rounded-full">سال ۱۴۰۳</span>
                        </div>
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-gray-100">فروش بر اساس دسته‌بندی</h3>
                            <span class="text-xs text-gray-400 bg-gray-800 px-3 py-1 rounded-full">هفته جاری</span>
                        </div>
                        <div class="chart-container">
                            <canvas id="productsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">آخرین سفارشات</h3>
                        <button class="text-sm text-blue-400 hover:text-blue-300 font-medium flex items-center gap-1 transition duration-300 hover:translate-x-1">
                            <i data-lucide="eye" class="w-4 h-4"></i> مشاهده همه
                        </button>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">شماره سفارش</th>
                                    <th class="px-4 py-3 text-right">مشتری</th>
                                    <th class="px-4 py-3 text-right">تاریخ</th>
                                    <th class="px-4 py-3 text-right">مبلغ</th>
                                    <th class="px-4 py-3 text-right">وضعیت</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="recentOrdersBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===== PRODUCTS ===== -->
            <div id="products-page" class="page-content">
                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">مدیریت محصولات</h3>
                        <button id="showAddProduct" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-1 transition duration-300 transform hover:scale-105 hover:shadow-lg">
                            <i data-lucide="plus" class="w-4 h-4"></i> افزودن محصول
                        </button>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">شناسه</th>
                                    <th class="px-4 py-3 text-right">نام محصول</th>
                                    <th class="px-4 py-3 text-right">دسته</th>
                                    <th class="px-4 py-3 text-right">قیمت</th>
                                    <th class="px-4 py-3 text-right">موجودی</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
                <div id="productFormContainer" class="mt-6 bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-6 transition-all duration-300" style="display:none;">
                    <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-5 h-5 text-blue-500"></i>
                        <span id="productFormTitle">افزودن محصول جدید</span>
                    </h3>
                    <form id="productForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">نام محصول</label>
                                <input type="text" id="prodName" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">دسته‌بندی</label>
                                <select id="prodCategory" class="form-input" required>
                                    <option value="">انتخاب کنید</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">قیمت (تومان)</label>
                                <input type="number" id="prodPrice" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">موجودی</label>
                                <input type="number" id="prodStock" class="form-input" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-300 mb-1">توضیحات</label>
                                <textarea id="prodDesc" rows="3" class="form-input"></textarea>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button type="button" id="cancelProduct" class="px-4 py-2 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 transition duration-300">انصراف</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition duration-300 flex items-center gap-1 transform hover:scale-105">
                                <i data-lucide="save" class="w-4 h-4"></i> <span id="productSubmitText">ذخیره محصول</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== CATEGORIES ===== -->
            <div id="categories-page" class="page-content">
                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">دسته‌بندی‌ها</h3>
                        <button id="showAddCategory" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-1 transition duration-300 transform hover:scale-105">
                            <i data-lucide="plus" class="w-4 h-4"></i> افزودن دسته
                        </button>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">شناسه</th>
                                    <th class="px-4 py-3 text-right">نام دسته</th>
                                    <th class="px-4 py-3 text-right">تعداد محصول</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
                <div id="categoryFormContainer" class="mt-6 bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-6 transition-all duration-300" style="display:none;">
                    <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center gap-2">
                        <i data-lucide="tag" class="w-5 h-5 text-blue-500"></i>
                        <span id="categoryFormTitle">افزودن دسته‌بندی جدید</span>
                    </h3>
                    <form id="categoryForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">نام دسته‌بندی</label>
                            <input type="text" id="catName" class="form-input" required>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button type="button" id="cancelCategory" class="px-4 py-2 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 transition duration-300">انصراف</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition duration-300 flex items-center gap-1 transform hover:scale-105">
                                <i data-lucide="save" class="w-4 h-4"></i> <span id="categorySubmitText">ذخیره</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== ORDERS ===== -->
            <div id="orders-page" class="page-content">
                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">مدیریت سفارشات</h3>
                        <div class="flex gap-2">
                            <select id="orderFilter" class="form-input w-auto py-1.5 text-sm transition duration-300">
                                <option value="all">همه</option>
                                <option value="success">تحویل شده</option>
                                <option value="pending">در انتظار</option>
                                <option value="shipped">ارسال شده</option>
                                <option value="cancelled">لغو شده</option>
                            </select>
                            <button class="border border-gray-600 hover:bg-gray-700 px-4 py-1.5 rounded-lg text-sm font-medium text-gray-300 transition duration-300 flex items-center gap-1 hover:shadow">
                                <i data-lucide="download" class="w-4 h-4"></i> خروجی
                            </button>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">شماره سفارش</th>
                                    <th class="px-4 py-3 text-right">مشتری</th>
                                    <th class="px-4 py-3 text-right">تاریخ</th>
                                    <th class="px-4 py-3 text-right">مبلغ</th>
                                    <th class="px-4 py-3 text-right">وضعیت</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="ordersFullTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===== USERS ===== -->
            <div id="users-page" class="page-content">
                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">مدیریت کاربران</h3>
                        <button id="showAddUser" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-1 transition duration-300 transform hover:scale-105">
                            <i data-lucide="user-plus" class="w-4 h-4"></i> افزودن کاربر
                        </button>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">شناسه</th>
                                    <th class="px-4 py-3 text-right">نام کاربر</th>
                                    <th class="px-4 py-3 text-right">ایمیل</th>
                                    <th class="px-4 py-3 text-right">نقش</th>
                                    <th class="px-4 py-3 text-right">وضعیت</th>
                                    <th class="px-4 py-3 text-right">تاریخ ثبت</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
                <div id="userFormContainer" class="mt-6 bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-6 transition-all duration-300" style="display:none;">
                    <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center gap-2">
                        <i data-lucide="user-plus" class="w-5 h-5 text-blue-500"></i>
                        <span id="userFormTitle">افزودن کاربر جدید</span>
                    </h3>
                    <form id="userForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">نام کامل</label>
                                <input type="text" id="userName" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">ایمیل</label>
                                <input type="email" id="userEmail" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">رمز عبور</label>
                                <input type="password" id="userPass" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">نقش</label>
                                <select id="userRole" class="form-input">
                                    <option value="کاربر">کاربر</option>
                                    <option value="مدیر">مدیر</option>
                                    <option value="ادمین">ادمین</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">وضعیت</label>
                                <select id="userStatus" class="form-input">
                                    <option value="active">فعال</option>
                                    <option value="inactive">غیرفعال</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button type="button" id="cancelUser" class="px-4 py-2 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 transition duration-300">انصراف</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition duration-300 flex items-center gap-1 transform hover:scale-105">
                                <i data-lucide="save" class="w-4 h-4"></i> <span id="userSubmitText">ذخیره کاربر</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== REVIEWS ===== -->
            <div id="reviews-page" class="page-content">
                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">مدیریت نظرات</h3>
                        <select id="reviewFilter" class="form-input w-auto py-1.5 text-sm transition duration-300">
                            <option value="all">همه</option>
                            <option value="approved">تایید شده</option>
                            <option value="pending">در انتظار</option>
                            <option value="rejected">رد شده</option>
                        </select>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">محصول</th>
                                    <th class="px-4 py-3 text-right">کاربر</th>
                                    <th class="px-4 py-3 text-right">امتیاز</th>
                                    <th class="px-4 py-3 text-right">نظر</th>
                                    <th class="px-4 py-3 text-right">وضعیت</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="reviewsTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===== COUPONS ===== -->
            <div id="coupons-page" class="page-content">
                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">کدهای تخفیف</h3>
                        <button id="showAddCoupon" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-1 transition duration-300 transform hover:scale-105">
                            <i data-lucide="plus" class="w-4 h-4"></i> افزودن کد
                        </button>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">کد</th>
                                    <th class="px-4 py-3 text-right">تخفیف</th>
                                    <th class="px-4 py-3 text-right">نوع</th>
                                    <th class="px-4 py-3 text-right">انقضا</th>
                                    <th class="px-4 py-3 text-right">وضعیت</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="couponsTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
                <div id="couponFormContainer" class="mt-6 bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-6 transition-all duration-300" style="display:none;">
                    <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center gap-2">
                        <i data-lucide="ticket" class="w-5 h-5 text-blue-500"></i>
                        <span id="couponFormTitle">افزودن کد تخفیف</span>
                    </h3>
                    <form id="couponForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">کد</label>
                                <input type="text" id="couponCode" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">مقدار تخفیف</label>
                                <input type="number" id="couponDiscount" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">نوع</label>
                                <select id="couponType" class="form-input">
                                    <option value="percent">درصدی</option>
                                    <option value="fixed">مبلغ ثابت</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">تاریخ انقضا</label>
                                <input type="date" id="couponExpiry" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">وضعیت</label>
                                <select id="couponStatus" class="form-input">
                                    <option value="active">فعال</option>
                                    <option value="inactive">غیرفعال</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button type="button" id="cancelCoupon" class="px-4 py-2 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 transition duration-300">انصراف</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition duration-300 flex items-center gap-1 transform hover:scale-105">
                                <i data-lucide="save" class="w-4 h-4"></i> <span id="couponSubmitText">ذخیره</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== BANNERS ===== -->
            <div id="banners-page" class="page-content">
                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">مدیریت بنرها</h3>
                        <button id="showAddBanner" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-1 transition duration-300 transform hover:scale-105">
                            <i data-lucide="plus" class="w-4 h-4"></i> افزودن بنر
                        </button>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">عنوان</th>
                                    <th class="px-4 py-3 text-right">لینک</th>
                                    <th class="px-4 py-3 text-right">موقعیت</th>
                                    <th class="px-4 py-3 text-right">وضعیت</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="bannersTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
                <div id="bannerFormContainer" class="mt-6 bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-6 transition-all duration-300" style="display:none;">
                    <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center gap-2">
                        <i data-lucide="image" class="w-5 h-5 text-blue-500"></i>
                        <span id="bannerFormTitle">افزودن بنر جدید</span>
                    </h3>
                    <form id="bannerForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">عنوان</label>
                                <input type="text" id="bannerTitle" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">لینک</label>
                                <input type="url" id="bannerLink" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">موقعیت</label>
                                <select id="bannerPosition" class="form-input">
                                    <option value="main">اصلی</option>
                                    <option value="sidebar">سایدبار</option>
                                    <option value="footer">فوتر</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">وضعیت</label>
                                <select id="bannerStatus" class="form-input">
                                    <option value="active">فعال</option>
                                    <option value="inactive">غیرفعال</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-300 mb-1">آدرس تصویر (URL)</label>
                                <input type="url" id="bannerImage" class="form-input" placeholder="https://example.com/image.jpg">
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button type="button" id="cancelBanner" class="px-4 py-2 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 transition duration-300">انصراف</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition duration-300 flex items-center gap-1 transform hover:scale-105">
                                <i data-lucide="save" class="w-4 h-4"></i> <span id="bannerSubmitText">ذخیره</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== REPORTS ===== -->
            <div id="reports-page" class="page-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="chart-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-gray-100">نمودار فروش ماهانه</h3>
                            <span class="text-xs text-gray-400 bg-gray-800 px-3 py-1 rounded-full">سال ۱۴۰۳</span>
                        </div>
                        <div class="chart-container-lg">
                            <canvas id="reportsChart1"></canvas>
                        </div>
                    </div>
                    <div class="chart-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-gray-100">توزیع فروش بر اساس دسته</h3>
                            <span class="text-xs text-gray-400 bg-gray-800 px-3 py-1 rounded-full">ماه جاری</span>
                        </div>
                        <div class="chart-container-lg">
                            <canvas id="reportsChart2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-700">
                        <h3 class="font-semibold text-gray-100">گزارش فروش محصولات</h3>
                        <div class="flex gap-2">
                            <button class="border border-gray-600 hover:bg-gray-700 px-4 py-1.5 rounded-lg text-sm font-medium text-gray-300 transition duration-300 flex items-center gap-1 hover:shadow">
                                <i data-lucide="file-text" class="w-4 h-4"></i> PDF
                            </button>
                            <button class="border border-gray-600 hover:bg-gray-700 px-4 py-1.5 rounded-lg text-sm font-medium text-gray-300 transition duration-300 flex items-center gap-1 hover:shadow">
                                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> اکسل
                            </button>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">محصول</th>
                                    <th class="px-4 py-3 text-right">تعداد فروش</th>
                                    <th class="px-4 py-3 text-right">درآمد</th>
                                    <th class="px-4 py-3 text-right">سهم فروش</th>
                                </tr>
                            </thead>
                            <tbody id="reportsTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===== ANALYTICS ===== -->
            <div id="analytics-page" class="page-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="stat-card blue bg-[#1e293b] rounded-xl shadow-sm p-5 border border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="icon-bg">
                                <i data-lucide="eye" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">بازدید امروز</p>
                                <p class="text-2xl font-bold text-gray-100">۱۲,۴۵۰</p>
                                <p class="text-xs text-green-400 flex items-center gap-1"><i data-lucide="arrow-up" class="w-3 h-3"></i> ۱۸٪</p>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card green bg-[#1e293b] rounded-xl shadow-sm p-5 border border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="icon-bg">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">کاربران فعال</p>
                                <p class="text-2xl font-bold text-gray-100">۳,۲۸۰</p>
                                <p class="text-xs text-green-400 flex items-center gap-1"><i data-lucide="arrow-up" class="w-3 h-3"></i> ۷٪</p>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card purple bg-[#1e293b] rounded-xl shadow-sm p-5 border border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="icon-bg">
                                <i data-lucide="clock" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">میانگین زمان بازدید</p>
                                <p class="text-2xl font-bold text-gray-100">۴:۳۲</p>
                                <p class="text-xs text-red-400 flex items-center gap-1"><i data-lucide="arrow-down" class="w-3 h-3"></i> ۲٪</p>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card orange bg-[#1e293b] rounded-xl shadow-sm p-5 border border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="icon-bg">
                                <i data-lucide="percent" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">نرخ تبدیل</p>
                                <p class="text-2xl font-bold text-gray-100">۳.۲٪</p>
                                <p class="text-xs text-green-400 flex items-center gap-1"><i data-lucide="arrow-up" class="w-3 h-3"></i> ۰.۴٪</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chart-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-100">آمار بازدیدکنندگان</h3>
                        <span class="text-xs text-gray-400 bg-gray-800 px-3 py-1 rounded-full">۳۰ روز اخیر</span>
                    </div>
                    <div class="chart-container-lg">
                        <canvas id="analyticsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- ===== SLIDERS ===== -->
            <div id="sliders-page" class="page-content">
                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h3 class="font-semibold text-gray-100 flex items-center gap-2">
                            <i data-lucide="images" class="w-5 h-5 text-blue-500"></i>
                            مدیریت اسلایدرها
                        </h3>
                        <button id="addSliderBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-1 transition duration-300 transform hover:scale-105">
                            <i data-lucide="plus" class="w-4 h-4"></i> افزودن اسلاید
                        </button>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">اسلایدهای اصلی صفحه اصلی را مدیریت کنید. ترتیب نمایش با شماره مشخص می‌شود.</p>
                </div>

                <div class="table-card bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 overflow-hidden">
                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right">شناسه</th>
                                    <th class="px-4 py-3 text-right">تصویر</th>
                                    <th class="px-4 py-3 text-right">عنوان</th>
                                    <th class="px-4 py-3 text-right">توضیحات</th>
                                    <th class="px-4 py-3 text-right">لینک</th>
                                    <th class="px-4 py-3 text-right">ترتیب</th>
                                    <th class="px-4 py-3 text-right">وضعیت</th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="slidersTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>
                </div>

                <div id="sliderFormContainer" class="mt-6 bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-6 transition-all duration-300" style="display:none;">
                    <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center gap-2">
                        <i data-lucide="image-plus" class="w-5 h-5 text-blue-500"></i>
                        <span id="sliderFormTitle">افزودن اسلاید جدید</span>
                    </h3>
                    <form id="sliderForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">عنوان</label>
                                <input type="text" id="sliderTitle" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">لینک</label>
                                <input type="url" id="sliderLink" class="form-input" placeholder="https://example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">آدرس تصویر</label>
                                <input type="url" id="sliderImage" class="form-input" placeholder="https://picsum.photos/800/400" required>
                                <div class="mt-2">
                                    <img id="sliderPreview" src="" alt="پیش‌نمایش" class="slider-preview hidden">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">ترتیب نمایش</label>
                                <input type="number" id="sliderOrder" class="form-input" value="1" min="1">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">وضعیت</label>
                                <select id="sliderStatus" class="form-input">
                                    <option value="active">فعال</option>
                                    <option value="inactive">غیرفعال</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-300 mb-1">توضیحات</label>
                                <textarea id="sliderDesc" rows="2" class="form-input" placeholder="توضیحات اسلاید"></textarea>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button type="button" id="cancelSlider" class="px-4 py-2 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 transition duration-300">انصراف</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition duration-300 flex items-center gap-1 transform hover:scale-105">
                                <i data-lucide="save" class="w-4 h-4"></i> <span id="sliderSubmitText">ذخیره</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== CALENDAR ===== -->
            <div id="calendar-page" class="page-content">
                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <h3 class="font-semibold text-gray-100 flex items-center gap-2">
                            <i data-lucide="calendar" class="w-5 h-5 text-blue-500"></i>
                            تقویم
                        </h3>
                        <div class="flex items-center gap-2">
                            <button id="prevMonth" class="p-2 rounded-lg hover:bg-gray-700 transition">
                                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-300"></i>
                            </button>
                            <span id="calendarMonthYear" class="text-gray-100 font-medium min-w-[140px] text-center"></span>
                            <button id="nextMonth" class="p-2 rounded-lg hover:bg-gray-700 transition">
                                <i data-lucide="chevron-left" class="w-5 h-5 text-gray-300"></i>
                            </button>
                            <button id="todayBtn" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm transition">امروز</button>
                        </div>
                    </div>

                    <div class="calendar-header">
                        <div class="day-name">ش</div>
                        <div class="day-name">ی</div>
                        <div class="day-name">د</div>
                        <div class="day-name">س</div>
                        <div class="day-name">چ</div>
                        <div class="day-name">پ</div>
                        <div class="day-name">ج</div>
                    </div>
                    <div id="calendarGrid" class="calendar-grid"></div>

                    <div class="mt-4 border-t border-gray-700 pt-4">
                        <div class="flex items-center gap-4 flex-wrap">
                            <span class="text-sm text-gray-400">رویدادهای امروز:</span>
                            <div id="todayEvents" class="text-sm text-gray-300"></div>
                        </div>
                        <div class="mt-3 flex gap-2 flex-wrap">
                            <button id="addEventBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-sm flex items-center gap-1 transition">
                                <i data-lucide="plus" class="w-4 h-4"></i> افزودن رویداد
                            </button>
                            <input type="text" id="eventTitleInput" class="form-input w-48 py-1.5 text-sm" placeholder="عنوان رویداد...">
                            <input type="date" id="eventDateInput" class="form-input w-40 py-1.5 text-sm">
                            <select id="eventColorInput" class="form-input w-32 py-1.5 text-sm">
                                <option value="#2563eb">آبی</option>
                                <option value="#f97316">نارنجی</option>
                                <option value="#22c55e">سبز</option>
                                <option value="#8b5cf6">بنفش</option>
                                <option value="#ef4444">قرمز</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== DATA TABLE ===== -->
            <div id="datatable-page" class="page-content">
                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <h3 class="font-semibold text-gray-100 flex items-center gap-2">
                            <i data-lucide="table" class="w-5 h-5 text-blue-500"></i>
                            جدول داده‌های پیشرفته
                        </h3>
                        <div class="flex items-center gap-2 flex-wrap">
                            <div class="dataTable-search">
                                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                                <input type="text" id="dataTableSearch" placeholder="جستجو در جدول...">
                            </div>
                            <select id="dataTableFilter" class="form-input w-32 py-1.5 text-sm">
                                <option value="all">همه</option>
                                <option value="active">فعال</option>
                                <option value="inactive">غیرفعال</option>
                            </select>
                            <button id="dataTableRefresh" class="p-2 rounded-lg hover:bg-gray-700 transition">
                                <i data-lucide="refresh-cw" class="w-5 h-5 text-gray-300"></i>
                            </button>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-right cursor-pointer sortable" data-sort="id">شناسه <i data-lucide="chevrons-up-down" class="w-3 h-3 inline"></i></th>
                                    <th class="px-4 py-3 text-right cursor-pointer sortable" data-sort="name">نام <i data-lucide="chevrons-up-down" class="w-3 h-3 inline"></i></th>
                                    <th class="px-4 py-3 text-right cursor-pointer sortable" data-sort="email">ایمیل <i data-lucide="chevrons-up-down" class="w-3 h-3 inline"></i></th>
                                    <th class="px-4 py-3 text-right cursor-pointer sortable" data-sort="role">نقش <i data-lucide="chevrons-up-down" class="w-3 h-3 inline"></i></th>
                                    <th class="px-4 py-3 text-right cursor-pointer sortable" data-sort="status">وضعیت <i data-lucide="chevrons-up-down" class="w-3 h-3 inline"></i></th>
                                    <th class="px-4 py-3 text-right cursor-pointer sortable" data-sort="date">تاریخ <i data-lucide="chevrons-up-down" class="w-3 h-3 inline"></i></th>
                                    <th class="px-4 py-3 text-right">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody" class="divide-y divide-gray-700"></tbody>
                        </table>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 mt-4">
                        <div class="text-sm text-gray-400" id="dataTableInfo">نمایش ۱ تا ۱۰ از ۵۰ نتیجه</div>
                        <div class="dataTable-pagination" id="dataTablePagination"></div>
                    </div>
                </div>
            </div>

            <!-- ===== AI CHAT ===== -->
            <div id="ai-page" class="page-content">
                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-5">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                            <i data-lucide="bot" class="text-white w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-100">هوش مصنوعی Grafioum</h3>
                            <p class="text-xs text-gray-400">تحلیل‌گر هوشمند کسب‌وکار</p>
                        </div>
                    </div>

                    <div class="chat-container" id="chatContainer">
                        <!-- پیام‌ها توسط JS ساخته می‌شوند -->
                    </div>

                    <div class="flex flex-wrap gap-2 mt-4" id="quickActions">
                        <!-- دکمه‌های سریع توسط JS ساخته می‌شوند -->
                    </div>
                </div>
            </div>

            <!-- ===== SETTINGS ===== -->
            <div id="settings-page" class="page-content">
                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-gray-700 p-6 transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-100 mb-4 flex items-center gap-2">
                        <i data-lucide="settings" class="w-5 h-5 text-blue-500"></i>
                        تنظیمات عمومی
                    </h3>
                    <form id="settingsForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">نام فروشگاه</label>
                                <input type="text" value="Grafioum" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">ایمیل پشتیبانی</label>
                                <input type="email" value="support@grafioum.com" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">شماره تماس</label>
                                <input type="text" value="۰۲۱-۱۲۳۴۵۶۷۸" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">واحد پول</label>
                                <select class="form-input">
                                    <option>تومان</option>
                                    <option>ریال</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-300 mb-1">آدرس</label>
                                <textarea rows="2" class="form-input">تهران، خیابان ولیعصر، پلاک ۱۲۳</textarea>
                            </div>
                        </div>

                        <div class="border-t border-gray-700 pt-4 mt-4">
                            <label class="block text-sm font-medium text-gray-300 mb-3">انتخاب تم رنگی</label>
                            <div class="flex gap-3">
                                <div class="color-option active" style="background:#2563eb;" data-color="#2563eb" onclick="changeThemeColor('#2563eb', this)"></div>
                                <div class="color-option" style="background:#f97316;" data-color="#f97316" onclick="changeThemeColor('#f97316', this)"></div>
                                <div class="color-option" style="background:#22c55e;" data-color="#22c55e" onclick="changeThemeColor('#22c55e', this)"></div>
                                <div class="color-option" style="background:#8b5cf6;" data-color="#8b5cf6" onclick="changeThemeColor('#8b5cf6', this)"></div>
                                <div class="color-option" style="background:#ef4444;" data-color="#ef4444" onclick="changeThemeColor('#ef4444', this)"></div>
                                <div class="color-option" style="background:#0891b2;" data-color="#0891b2" onclick="changeThemeColor('#0891b2', this)"></div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition duration-300 flex items-center gap-1 transform hover:scale-105 hover:shadow-lg">
                                <i data-lucide="save" class="w-4 h-4"></i> ذخیره تنظیمات
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- ============================================================ -->
    <!-- SCRIPTS -->
    <!-- ============================================================ -->
    <script>
        // ============================================================
        // FIX: All code runs after DOM is ready
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Ready - Initializing...');
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons();
            }

            // ============================================================
            // 1. DATA GENERATORS
            // ============================================================

            const names = ['علی محمدی', 'فاطمه کریمی', 'رضا احمدی', 'سارا حسینی', 'محمدرضا نوری',
                'مریم رضایی', 'حسین صادقی', 'زهرا موسوی', 'امیر عباسی', 'نگار بهرامی',
                'پویا فتحی', 'شیدا مرادی', 'کیوان رستمی', 'الناز صفایی', 'یاسین تقوی',
                'ملیکا زمانی', 'سینا اختری', 'هانیه کرمانشاهی', 'آرمان جعفری', 'ترنم رحمانی'
            ];
            const roles = ['کاربر', 'مدیر', 'ادمین'];
            const categoriesList = ['موبایل', 'لپ‌تاپ', 'پوشاک', 'لوازم خانگی', 'اکسسوری', 'کتاب', 'اسباب‌بازی', 'ورزشی', 'زیبایی',
                'خودرو'
            ];
            const statuses = ['success', 'pending', 'shipped', 'cancelled'];
            const statusMap = { success: 'تحویل شده', pending: 'در انتظار', shipped: 'ارسال شده', cancelled: 'لغو شده' };
            const productNames = [
                'گوشی سامسونگ S24 Ultra', 'گوشی آیفون ۱۵ پرو', 'لپ‌تاپ ایسوس ROG', 'هدفون بی‌سیم سونی',
                'ساعت هوشمند اپل واچ', 'کیبورد مکانیکی ریزر', 'موس گیمینگ لوگی‌تک', 'پاوربانک ۲۰۰۰۰',
                'هندزفری بی‌سیم ایرپادز', 'مانیتور ۴K سامسونگ', 'تبلت اپل آیپد ایر', 'دوربین کانن EOS R6',
                'اسپیکر بلوتوثی جی‌بی‌ال', 'کیس گوشی سیلیکونی', 'شارژر سریع ۶۵ وات', 'هدست واقعیت مجازی',
                'دکوراسیون خانه', 'ساعت مچی کلاسیک', 'عینک آفتابی', 'کیف لپ‌تاپ', 'بند ساعت هوشمند'
            ];

            function randomItem(arr) { return arr[Math.floor(Math.random() * arr.length)]; }

            function randomNumber(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }

            function randomDate(start, end) {
                const d = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
                return d.toLocaleDateString('fa-IR');
            }

            function generateUsers(count) {
                const users = [];
                for (let i = 1; i <= count; i++) {
                    users.push({
                        id: i,
                        name: randomItem(names) + (i > names.length ? ` ${i}` : ''),
                        email: `user${i}@example.com`,
                        role: randomItem(roles),
                        status: randomItem(['active', 'inactive']),
                        date: randomDate(new Date(2023, 0, 1), new Date()),
                    });
                }
                return users;
            }

            function generateProducts(count) {
                const products = [];
                for (let i = 1; i <= count; i++) {
                    const price = randomNumber(50000, 50000000);
                    products.push({
                        id: i,
                        name: randomItem(productNames) + (i > productNames.length ? ` ${i}` : ''),
                        category: randomItem(categoriesList),
                        price: price.toLocaleString() + ' تومان',
                        stock: randomNumber(0, 200),
                        rating: (Math.random() * 3 + 2).toFixed(1),
                    });
                }
                return products;
            }

            function generateCategories(list) {
                return list.map((name, idx) => ({ id: idx + 1, name: name, count: randomNumber(5, 30) }));
            }

            function generateOrders(count, users, products) {
                const orders = [];
                for (let i = 1; i <= count; i++) {
                    const user = randomItem(users);
                    orders.push({
                        id: `#ORD-${String(i).padStart(4, '0')}`,
                        customer: user.name,
                        date: randomDate(new Date(2024, 0, 1), new Date()),
                        amount: randomNumber(100000, 10000000).toLocaleString() + ' تومان',
                        status: randomItem(statuses),
                        items: randomNumber(1, 5),
                    });
                }
                return orders;
            }

            function generateReviews(count, users, products) {
                const reviews = [];
                const reviewTexts = ['عالی بود، پیشنهاد میکنم', 'خیلی خوب، اما کمی گران', 'انتظار بیشتری داشتم', 'کیفیت عالی',
                    'بد نبود، ولی قابل قبول', 'ارسال سریع، محصول عالی', 'جنس نامرغوب', 'دقیقاً مطابق عکس',
                    'ارزش خرید داشت', 'پشتیبانی عالی'
                ];
                for (let i = 1; i <= count; i++) {
                    reviews.push({
                        id: i,
                        product: randomItem(products).name,
                        user: randomItem(users).name,
                        rating: randomNumber(1, 5),
                        comment: randomItem(reviewTexts),
                        status: randomItem(['approved', 'pending', 'rejected']),
                        date: randomDate(new Date(2024, 0, 1), new Date()),
                    });
                }
                return reviews;
            }

            function generateCoupons(count) {
                const codes = ['SAVE10', 'DISCOUNT20', 'SUMMER', 'WELCOME', 'VIP15', 'BLACK', 'FALL', 'WINTER', 'SPRING',
                    'SALE50'
                ];
                const coupons = [];
                for (let i = 1; i <= count; i++) {
                    coupons.push({
                        id: i,
                        code: randomItem(codes) + (i > codes.length ? i : ''),
                        discount: randomNumber(5, 50),
                        type: randomItem(['percent', 'fixed']),
                        expiry: randomDate(new Date(), new Date(2025, 11, 31)),
                        status: randomItem(['active', 'inactive']),
                    });
                }
                return coupons;
            }

            function generateBanners(count) {
                const titles = ['تخفیف ویژه تابستان', 'جدیدترین محصولات', 'حراج هفتگی', 'پیش‌فروش آیفون', 'هدیه ویژه',
                    'تخفیف پوشاک', 'ارسال رایگان', 'خرید اقساطی'
                ];
                const banners = [];
                for (let i = 1; i <= count; i++) {
                    banners.push({
                        id: i,
                        title: randomItem(titles) + (i > titles.length ? ` ${i}` : ''),
                        link: '#',
                        position: randomItem(['main', 'sidebar', 'footer']),
                        status: randomItem(['active', 'inactive']),
                        image: `https://picsum.photos/seed/${i}/800/400`,
                    });
                }
                return banners;
            }

            // ===== Initialize Data =====
            const usersData = generateUsers(90);
            const productsData = generateProducts(50);
            const categoriesData = generateCategories(categoriesList);
            const ordersData = generateOrders(70, usersData, productsData);
            const reviewsData = generateReviews(40, usersData, productsData);
            const couponsData = generateCoupons(15);
            const bannersData = generateBanners(8);

            // ============================================================
            // 2. STATE
            // ============================================================
            let currentPage = 'dashboard';
            let editingProductId = null;
            let editingUserId = null;
            let editingCategoryId = null;
            let editingCouponId = null;
            let editingBannerId = null;
            let editingSliderId = null;
            let isDarkTheme = true;
            let currentColor = '#2563eb';

            // Slider data
            let slidersData = [
                { id: 1, title: 'تخفیف ویژه تابستان', desc: 'تا ۵۰٪ تخفیف برای تمام محصولات', link: '#',
                    image: 'https://picsum.photos/seed/1/800/400', order: 1, status: 'active' },
                { id: 2, title: 'محصولات جدید', desc: 'جدیدترین گوشی‌ها و لپ‌تاپ‌ها', link: '#',
                    image: 'https://picsum.photos/seed/2/800/400', order: 2, status: 'active' },
                { id: 3, title: 'حراج هفتگی', desc: 'تخفیف‌های شگفت‌انگیز هر هفته', link: '#',
                    image: 'https://picsum.photos/seed/3/800/400', order: 3, status: 'inactive' },
            ];
            let nextSliderId = 4;

            // Calendar events
            let calendarEvents = [
                { date: new Date(), title: 'جلسه تیم بازاریابی', color: '#2563eb' },
                { date: new Date(new Date().setDate(new Date().getDate() + 2)), title: 'ارسال گزارش ماهانه',
                    color: '#f97316' },
                { date: new Date(new Date().setDate(new Date().getDate() + 5)), title: 'بررسی موجودی انبار',
                    color: '#22c55e' },
            ];

            // DataTable state
            let dataTableData = generateUsers(50);
            let filteredData = [...dataTableData];
            let currentPageData = 1;
            let pageSize = 10;
            let sortField = 'id';
            let sortDirection = 'asc';

            // ============================================================
            // 3. DOM REFS
            // ============================================================
            const $ = (id) => document.getElementById(id);
            const loginPage = $('loginPage');
            const adminPanel = $('adminPanel');
            const loginForm = $('loginForm');
            const logoutBtn = $('logoutBtn');
            const logoutDropdown = $('logoutDropdown');
            const mobileMenuBtn = $('mobileMenuBtn');
            const mobileOverlay = $('mobileOverlay');
            const sidebar = $('sidebar');
            const pageTitle = $('pageTitle');
            const globalSearch = $('globalSearch');
            const profileBtn = $('profileBtn');
            const profileDropdown = $('profileDropdown');
            const themeToggle = $('themeToggle');

            // ============================================================
            // 4. AUTH
            // ============================================================
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log('Login button clicked');

                    const username = document.getElementById('username').value;
                    const password = document.getElementById('password').value;

                    if (username === 'admin' && password === '1234') {
                        loginPage.classList.add('logged-in-hidden');
                        adminPanel.classList.add('show');
                        adminPanel.style.display = 'flex';
                        console.log('Login successful - showing admin panel');

                        // Initialize everything
                        initAll();
                        renderAll();
                        setTimeout(initCharts, 200);
                        setTimeout(renderCalendar, 300);
                        setTimeout(renderDataTable, 400);
                        setTimeout(() => lucide.createIcons(), 500);
                    } else {
                        alert('نام کاربری یا رمز عبور اشتباه است!');
                    }
                });
            } else {
                console.error('loginForm not found!');
            }

            if (logoutBtn) {
                logoutBtn.addEventListener('click', logout);
            }
            if (logoutDropdown) {
                logoutDropdown.addEventListener('click', logout);
            }

            function logout() {
                adminPanel.classList.remove('show');
                adminPanel.style.display = 'none';
                loginPage.classList.remove('logged-in-hidden');
                loginPage.style.display = 'flex';
                closeMobileMenu();
                closeDropdown();
            }

            // ============================================================
            // 5. PROFILE DROPDOWN
            // ============================================================
            if (profileBtn) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (profileDropdown) {
                        profileDropdown.classList.toggle('show');
                    }
                });
            }

            document.addEventListener('click', function(e) {
                if (profileBtn && profileDropdown && !profileBtn.contains(e.target) && !profileDropdown.contains(e
                    .target)) {
                    profileDropdown.classList.remove('show');
                }
            });

            function closeDropdown() {
                if (profileDropdown) {
                    profileDropdown.classList.remove('show');
                }
            }

            // ============================================================
            // 6. THEME TOGGLE
            // ============================================================
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    isDarkTheme = !isDarkTheme;
                    this.classList.toggle('light');
                    document.documentElement.setAttribute('data-theme', isDarkTheme ? 'dark' : 'light');

                    const thumb = this.querySelector('.thumb');
                    const icon = thumb ? thumb.querySelector('.lucide') : null;
                    if (icon) {
                        icon.setAttribute('data-lucide', isDarkTheme ? 'moon' : 'sun');
                        if (window.lucide && typeof window.lucide.createIcons === 'function') {
                            window.lucide.createIcons();
                        }
                    }
                });
            }

            // ============================================================
            // 7. COLOR THEME
            // ============================================================
            window.changeThemeColor = function(color, el) {
                currentColor = color;
                document.querySelectorAll('.color-option').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
                document.documentElement.style.setProperty('--primary-color', color);

                document.querySelectorAll(
                        '.bg-blue-600, .bg-blue-500, .bg-gradient-to-r.from-blue-500, .bg-gradient-to-br.from-blue-500')
                    .forEach(e => {
                        if (e.classList.contains('bg-blue-600') || e.classList.contains('bg-blue-500')) {
                            e.style.background = color;
                        }
                    });
                document.querySelectorAll('.text-blue-500, .text-blue-400')
                    .forEach(e => {
                        e.style.color = color;
                    });
                document.querySelectorAll('.border-blue-500')
                    .forEach(e => {
                        e.style.borderColor = color;
                    });
                document.querySelectorAll('.nav-item.active::before').forEach(el => {
                    el.style.background = color;
                });
            };

            // ============================================================
            // 8. NAVIGATION
            // ============================================================
            const navLinks = document.querySelectorAll('.nav-item[data-page]');
            const pageTitles = {
                dashboard: 'داشبورد مدیریت',
                products: 'مدیریت محصولات',
                categories: 'دسته‌بندی‌ها',
                orders: 'مدیریت سفارشات',
                users: 'مدیریت کاربران',
                reviews: 'مدیریت نظرات',
                coupons: 'کدهای تخفیف',
                banners: 'بنرها',
                reports: 'گزارشات فروش',
                analytics: 'تحلیل‌ها',
                sliders: 'مدیریت اسلایدر',
                calendar: 'تقویم',
                datatable: 'جدول داده',
                ai: 'هوش مصنوعی',
                settings: 'تنظیمات'
            };

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.dataset.page;
                    switchPage(page);
                    if (window.innerWidth < 768) {
                        closeMobileMenu();
                    }
                });
            });

            function switchPage(page) {
                currentPage = page;
                document.querySelectorAll('.page-content').forEach(p => p.classList.remove('active'));
                const target = $(`${page}-page`);
                if (target) {
                    target.classList.add('active');
                    if (page === 'ai') {
                        renderAIChat();
                    }
                    if (page === 'calendar') {
                        renderCalendar();
                    }
                    if (page === 'datatable') {
                        renderDataTable();
                    }
                    if (page === 'sliders') {
                        renderSliders();
                    }
                }
                pageTitle.innerHTML = (pageTitles[page] || page) + ' <span class="text-blue-500">مدیریت</span>';
                navLinks.forEach(l => l.classList.remove('active'));
                document.querySelectorAll(`.nav-item[data-page="${page}"]`).forEach(l => l.classList.add('active'));
                if (page === 'dashboard') { updateDashboardStats();
                    setTimeout(initCharts, 100); }
                if (page === 'reports') setTimeout(initReportsCharts, 100);
                if (page === 'analytics') setTimeout(initAnalyticsChart, 100);
                renderAll();
            }

            // ============================================================
            // 9. RENDER FUNCTIONS
            // ============================================================
            function renderAll() {
                renderProducts();
                renderCategories();
                renderOrdersFull();
                renderRecentOrders();
                renderUsers();
                renderReviews();
                renderCoupons();
                renderBanners();
                renderReportsTable();
                updateDashboardStats();
                populateCategorySelect();
                renderSliders();
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            function renderProducts() {
                const tbody = $('productsTableBody');
                if (!tbody) return;
                tbody.innerHTML = productsData.map(p => `
                                <tr>
                                    <td class="px-4 py-3">${p.id}</td>
                                    <td class="px-4 py-3 font-medium text-gray-100">${p.name}</td>
                                    <td class="px-4 py-3 text-gray-400">${p.category}</td>
                                    <td class="px-4 py-3 text-gray-100">${p.price}</td>
                                    <td class="px-4 py-3 ${p.stock < 10 ? 'text-red-400 font-bold' : 'text-gray-300'}">${p.stock}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1">
                                            <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="editProduct(${p.id})">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteProduct(${p.id})">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            window.deleteProduct = function(id) {
                if (confirm('آیا از حذف این محصول اطمینان دارید؟')) {
                    const index = productsData.findIndex(p => p.id === id);
                    if (index !== -1) { productsData.splice(index, 1);
                        renderProducts();
                        updateDashboardStats();
                        alert('محصول حذف شد!'); }
                }
            };

            window.editProduct = function(id) {
                const p = productsData.find(p => p.id === id);
                if (!p) return;
                editingProductId = id;
                $('productFormTitle').textContent = 'ویرایش محصول';
                $('productSubmitText').textContent = 'به‌روزرسانی';
                $('prodName').value = p.name;
                $('prodCategory').value = p.category;
                $('prodPrice').value = p.price.replace(/[^0-9]/g, '');
                $('prodStock').value = p.stock;
                $('prodDesc').value = '';
                $('productFormContainer').style.display = 'block';
                window.scrollTo({ top: $('productFormContainer').offsetTop - 100, behavior: 'smooth' });
            };

            $('showAddProduct').addEventListener('click', function() {
                editingProductId = null;
                $('productFormTitle').textContent = 'افزودن محصول جدید';
                $('productSubmitText').textContent = 'ذخیره محصول';
                $('productForm').reset();
                $('productFormContainer').style.display = 'block';
                window.scrollTo({ top: $('productFormContainer').offsetTop - 100, behavior: 'smooth' });
            });

            $('cancelProduct').addEventListener('click', function() {
                $('productFormContainer').style.display = 'none';
            });

            $('productForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const name = $('prodName').value,
                    category = $('prodCategory').value;
                const price = Number($('prodPrice').value),
                    stock = Number($('prodStock').value);
                if (!name || !category || !price || !stock) return alert('لطفاً همه فیلدها را پر کنید!');
                if (editingProductId) {
                    const p = productsData.find(p => p.id === editingProductId);
                    if (p) { p.name = name;
                        p.category = category;
                        p.price = price.toLocaleString() + ' تومان';
                        p.stock = stock;
                        alert('محصول به‌روزرسانی شد!'); }
                    editingProductId = null;
                } else {
                    productsData.push({
                        id: productsData.length ? Math.max(...productsData.map(p => p.id)) + 1 : 1,
                        name,
                        category,
                        price: price.toLocaleString() + ' تومان',
                        stock,
                        rating: (Math.random() * 3 + 2).toFixed(1),
                    });
                    alert('محصول با موفقیت اضافه شد!');
                }
                $('productFormContainer').style.display = 'none';
                renderProducts();
                updateDashboardStats();
            });

            function renderCategories() {
                const tbody = $('categoriesTableBody');
                if (!tbody) return;
                tbody.innerHTML = categoriesData.map(c => `
                                <tr>
                                    <td class="px-4 py-3">${c.id}</td>
                                    <td class="px-4 py-3 font-medium text-gray-100">${c.name}</td>
                                    <td class="px-4 py-3 text-gray-400">${c.count}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1">
                                            <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="editCategory(${c.id})">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteCategory(${c.id})">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            window.deleteCategory = function(id) {
                if (confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟')) {
                    const index = categoriesData.findIndex(c => c.id === id);
                    if (index !== -1) { categoriesData.splice(index, 1);
                        renderCategories();
                        populateCategorySelect();
                        alert('دسته‌بندی حذف شد!'); }
                }
            };

            window.editCategory = function(id) {
                const c = categoriesData.find(c => c.id === id);
                if (!c) return;
                editingCategoryId = id;
                $('categoryFormTitle').textContent = 'ویرایش دسته‌بندی';
                $('categorySubmitText').textContent = 'به‌روزرسانی';
                $('catName').value = c.name;
                $('categoryFormContainer').style.display = 'block';
            };

            $('showAddCategory').addEventListener('click', function() {
                editingCategoryId = null;
                $('categoryFormTitle').textContent = 'افزودن دسته‌بندی جدید';
                $('categorySubmitText').textContent = 'ذخیره';
                $('catName').value = '';
                $('categoryFormContainer').style.display = 'block';
            });

            $('cancelCategory').addEventListener('click', function() {
                $('categoryFormContainer').style.display = 'none';
            });

            $('categoryForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const name = $('catName').value.trim();
                if (!name) return alert('لطفاً نام دسته را وارد کنید!');
                if (editingCategoryId) {
                    const c = categoriesData.find(c => c.id === editingCategoryId);
                    if (c) { c.name = name;
                        alert('دسته‌بندی به‌روزرسانی شد!'); }
                    editingCategoryId = null;
                } else {
                    categoriesData.push({ id: categoriesData.length ? Math.max(...categoriesData.map(c => c.id)) + 1 : 1,
                        name,
                        count: 0 });
                    alert('دسته‌بندی اضافه شد!');
                }
                $('categoryFormContainer').style.display = 'none';
                renderCategories();
                populateCategorySelect();
            });

            function renderOrdersFull() {
                const tbody = $('ordersFullTableBody');
                if (!tbody) return;
                const filter = $('orderFilter')?.value || 'all';
                const filtered = filter === 'all' ? ordersData : ordersData.filter(o => o.status === filter);
                tbody.innerHTML = filtered.map(o => `
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-100">${o.id}</td>
                                    <td class="px-4 py-3 text-gray-300">${o.customer}</td>
                                    <td class="px-4 py-3 text-gray-400">${o.date}</td>
                                    <td class="px-4 py-3 text-gray-100">${o.amount}</td>
                                    <td class="px-4 py-3"><span class="badge-${o.status} badge text-xs px-3 py-1 rounded-full">${statusMap[o.status]}</span></td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1">
                                            <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="editOrder('${o.id}')">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteOrder('${o.id}')">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            window.deleteOrder = function(id) {
                if (confirm('آیا از حذف این سفارش اطمینان دارید؟')) {
                    const index = ordersData.findIndex(o => o.id === id);
                    if (index !== -1) { ordersData.splice(index, 1);
                        renderOrdersFull();
                        renderRecentOrders();
                        alert('سفارش حذف شد!'); }
                }
            };

            window.editOrder = function(id) {
                const o = ordersData.find(o => o.id === id);
                if (!o) return;
                const newStatus = prompt('وضعیت جدید را وارد کنید (success, pending, shipped, cancelled):', o.status);
                if (newStatus && statuses.includes(newStatus)) {
                    o.status = newStatus;
                    renderOrdersFull();
                    renderRecentOrders();
                    alert('وضعیت سفارش به‌روزرسانی شد!');
                }
            };

            $('orderFilter').addEventListener('change', function() { renderOrdersFull(); });

            function renderRecentOrders() {
                const tbody = $('recentOrdersBody');
                if (!tbody) return;
                const recent = ordersData.slice(0, 8);
                tbody.innerHTML = recent.map(o => `
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-100">${o.id}</td>
                                    <td class="px-4 py-3 text-gray-300">${o.customer}</td>
                                    <td class="px-4 py-3 text-gray-400">${o.date}</td>
                                    <td class="px-4 py-3 text-gray-100">${o.amount}</td>
                                    <td class="px-4 py-3"><span class="badge-${o.status} badge text-xs px-3 py-1 rounded-full">${statusMap[o.status]}</span></td>
                                    <td class="px-4 py-3">
                                        <button class="text-sm text-blue-400 hover:text-blue-300 font-medium transition duration-200 hover:translate-x-1" onclick="alert('مشاهده سفارش ${o.id}')">مشاهده</button>
                                    </td>
                                </tr>
                            `).join('');
            }

            function renderUsers() {
                const tbody = $('usersTableBody');
                if (!tbody) return;
                tbody.innerHTML = usersData.map(u => {
                    const avatarColor = `avatar-color-${(u.id % 8) + 1}`;
                    return `
                                    <tr>
                                        <td class="px-4 py-3">${u.id}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full ${avatarColor} flex items-center justify-center text-white text-xs font-bold">${u.name.charAt(0)}</div>
                                                <span class="font-medium text-gray-100">${u.name}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-400">${u.email}</td>
                                        <td class="px-4 py-3"><span class="badge-${u.role === 'ادمین' ? 'success' : u.role === 'مدیر' ? 'shipped' : 'pending'} badge text-xs px-3 py-1 rounded-full">${u.role}</span></td>
                                        <td class="px-4 py-3"><span class="badge-${u.status} badge text-xs px-3 py-1 rounded-full">${u.status === 'active' ? 'فعال' : 'غیرفعال'}</span></td>
                                        <td class="px-4 py-3 text-gray-400">${u.date}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-1">
                                                <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="editUser(${u.id})">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </button>
                                                <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteUser(${u.id})">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                }).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            window.deleteUser = function(id) {
                if (confirm('آیا از حذف این کاربر اطمینان دارید؟')) {
                    const index = usersData.findIndex(u => u.id === id);
                    if (index !== -1) { usersData.splice(index, 1);
                        renderUsers();
                        alert('کاربر حذف شد!'); }
                }
            };

            window.editUser = function(id) {
                const u = usersData.find(u => u.id === id);
                if (!u) return;
                editingUserId = id;
                $('userFormTitle').textContent = 'ویرایش کاربر';
                $('userSubmitText').textContent = 'به‌روزرسانی';
                $('userName').value = u.name;
                $('userEmail').value = u.email;
                $('userRole').value = u.role;
                $('userStatus').value = u.status;
                $('userPass').value = '';
                $('userFormContainer').style.display = 'block';
                window.scrollTo({ top: $('userFormContainer').offsetTop - 100, behavior: 'smooth' });
            };

            $('showAddUser').addEventListener('click', function() {
                editingUserId = null;
                $('userFormTitle').textContent = 'افزودن کاربر جدید';
                $('userSubmitText').textContent = 'ذخیره کاربر';
                $('userForm').reset();
                $('userFormContainer').style.display = 'block';
                window.scrollTo({ top: $('userFormContainer').offsetTop - 100, behavior: 'smooth' });
            });

            $('cancelUser').addEventListener('click', function() {
                $('userFormContainer').style.display = 'none';
            });

            $('userForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const name = $('userName').value,
                    email = $('userEmail').value;
                const pass = $('userPass').value,
                    role = $('userRole').value;
                const status = $('userStatus').value;
                if (!name || !email || (!pass && !editingUserId)) {
                    return alert('لطفاً همه فیلدها را پر کنید (رمز عبور برای کاربر جدید الزامی است)!');
                }
                if (editingUserId) {
                    const u = usersData.find(u => u.id === editingUserId);
                    if (u) { u.name = name;
                        u.email = email;
                        u.role = role;
                        u.status = status;
                        if (pass) u.password = pass;
                        alert('کاربر به‌روزرسانی شد!'); }
                    editingUserId = null;
                } else {
                    usersData.push({
                        id: usersData.length ? Math.max(...usersData.map(u => u.id)) + 1 : 1,
                        name,
                        email,
                        role,
                        status,
                        date: new Date().toLocaleDateString('fa-IR'),
                        password: pass,
                    });
                    alert('کاربر با موفقیت اضافه شد!');
                }
                $('userFormContainer').style.display = 'none';
                renderUsers();
            });

            function renderReviews() {
                const tbody = $('reviewsTableBody');
                if (!tbody) return;
                const filter = $('reviewFilter')?.value || 'all';
                const filtered = filter === 'all' ? reviewsData : reviewsData.filter(r => r.status === filter);
                tbody.innerHTML = filtered.map(r => `
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-100">${r.product}</td>
                                    <td class="px-4 py-3 text-gray-300">${r.user}</td>
                                    <td class="px-4 py-3 text-yellow-500">${'⭐'.repeat(r.rating)}</td>
                                    <td class="px-4 py-3 text-gray-400 max-w-xs truncate">${r.comment}</td>
                                    <td class="px-4 py-3"><span class="badge-${r.status} badge text-xs px-3 py-1 rounded-full">${r.status === 'approved' ? 'تایید شده' : r.status === 'pending' ? 'در انتظار' : 'رد شده'}</span></td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1">
                                            <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="alert('ویرایش نظر ${r.id}')">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteReview(${r.id})">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            window.deleteReview = function(id) {
                if (confirm('آیا از حذف این نظر اطمینان دارید؟')) {
                    const index = reviewsData.findIndex(r => r.id === id);
                    if (index !== -1) { reviewsData.splice(index, 1);
                        renderReviews();
                        alert('نظر حذف شد!'); }
                }
            };

            $('reviewFilter')?.addEventListener('change', function() { renderReviews(); });

            function renderCoupons() {
                const tbody = $('couponsTableBody');
                if (!tbody) return;
                tbody.innerHTML = couponsData.map(c => `
                                <tr>
                                    <td class="px-4 py-3 font-mono font-bold text-blue-400">${c.code}</td>
                                    <td class="px-4 py-3 text-gray-100">${c.discount}${c.type === 'percent' ? '%' : ' تومان'}</td>
                                    <td class="px-4 py-3 text-gray-400">${c.type === 'percent' ? 'درصدی' : 'مبلغ ثابت'}</td>
                                    <td class="px-4 py-3 text-gray-400">${c.expiry}</td>
                                    <td class="px-4 py-3"><span class="badge-${c.status} badge text-xs px-3 py-1 rounded-full">${c.status === 'active' ? 'فعال' : 'غیرفعال'}</span></td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1">
                                            <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="editCoupon(${c.id})">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteCoupon(${c.id})">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            window.deleteCoupon = function(id) {
                if (confirm('آیا از حذف این کد تخفیف اطمینان دارید؟')) {
                    const index = couponsData.findIndex(c => c.id === id);
                    if (index !== -1) { couponsData.splice(index, 1);
                        renderCoupons();
                        alert('کد تخفیف حذف شد!'); }
                }
            };

            window.editCoupon = function(id) {
                const c = couponsData.find(c => c.id === id);
                if (!c) return;
                editingCouponId = id;
                $('couponFormTitle').textContent = 'ویرایش کد تخفیف';
                $('couponSubmitText').textContent = 'به‌روزرسانی';
                $('couponCode').value = c.code;
                $('couponDiscount').value = c.discount;
                $('couponType').value = c.type;
                $('couponExpiry').value = c.expiry;
                $('couponStatus').value = c.status;
                $('couponFormContainer').style.display = 'block';
                window.scrollTo({ top: $('couponFormContainer').offsetTop - 100, behavior: 'smooth' });
            };

            $('showAddCoupon').addEventListener('click', function() {
                editingCouponId = null;
                $('couponFormTitle').textContent = 'افزودن کد تخفیف';
                $('couponSubmitText').textContent = 'ذخیره';
                $('couponForm').reset();
                $('couponFormContainer').style.display = 'block';
                window.scrollTo({ top: $('couponFormContainer').offsetTop - 100, behavior: 'smooth' });
            });

            $('cancelCoupon').addEventListener('click', function() {
                $('couponFormContainer').style.display = 'none';
            });

            $('couponForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const code = $('couponCode').value,
                    discount = Number($('couponDiscount').value);
                const type = $('couponType').value,
                    expiry = $('couponExpiry').value;
                const status = $('couponStatus').value;
                if (!code || !discount || !expiry) return alert('لطفاً همه فیلدها را پر کنید!');
                if (editingCouponId) {
                    const c = couponsData.find(c => c.id === editingCouponId);
                    if (c) { c.code = code;
                        c.discount = discount;
                        c.type = type;
                        c.expiry = expiry;
                        c.status = status;
                        alert('کد تخفیف به‌روزرسانی شد!'); }
                    editingCouponId = null;
                } else {
                    couponsData.push({
                        id: couponsData.length ? Math.max(...couponsData.map(c => c.id)) + 1 : 1,
                        code,
                        discount,
                        type,
                        expiry,
                        status,
                    });
                    alert('کد تخفیف با موفقیت اضافه شد!');
                }
                $('couponFormContainer').style.display = 'none';
                renderCoupons();
            });

            function renderBanners() {
                const tbody = $('bannersTableBody');
                if (!tbody) return;
                tbody.innerHTML = bannersData.map(b => `
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-100">${b.title}</td>
                                    <td class="px-4 py-3 text-blue-400 underline"><a href="${b.link}" target="_blank">${b.link}</a></td>
                                    <td class="px-4 py-3 text-gray-400">${b.position}</td>
                                    <td class="px-4 py-3"><span class="badge-${b.status} badge text-xs px-3 py-1 rounded-full">${b.status === 'active' ? 'فعال' : 'غیرفعال'}</span></td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1">
                                            <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="editBanner(${b.id})">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteBanner(${b.id})">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            window.deleteBanner = function(id) {
                if (confirm('آیا از حذف این بنر اطمینان دارید؟')) {
                    const index = bannersData.findIndex(b => b.id === id);
                    if (index !== -1) { bannersData.splice(index, 1);
                        renderBanners();
                        alert('بنر حذف شد!'); }
                }
            };

            window.editBanner = function(id) {
                const b = bannersData.find(b => b.id === id);
                if (!b) return;
                editingBannerId = id;
                $('bannerFormTitle').textContent = 'ویرایش بنر';
                $('bannerSubmitText').textContent = 'به‌روزرسانی';
                $('bannerTitle').value = b.title;
                $('bannerLink').value = b.link;
                $('bannerPosition').value = b.position;
                $('bannerStatus').value = b.status;
                $('bannerImage').value = b.image;
                $('bannerFormContainer').style.display = 'block';
                window.scrollTo({ top: $('bannerFormContainer').offsetTop - 100, behavior: 'smooth' });
            };

            $('showAddBanner').addEventListener('click', function() {
                editingBannerId = null;
                $('bannerFormTitle').textContent = 'افزودن بنر جدید';
                $('bannerSubmitText').textContent = 'ذخیره';
                $('bannerForm').reset();
                $('bannerFormContainer').style.display = 'block';
                window.scrollTo({ top: $('bannerFormContainer').offsetTop - 100, behavior: 'smooth' });
            });

            $('cancelBanner').addEventListener('click', function() {
                $('bannerFormContainer').style.display = 'none';
            });

            $('bannerForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const title = $('bannerTitle').value,
                    link = $('bannerLink').value;
                const position = $('bannerPosition').value,
                    status = $('bannerStatus').value;
                const image = $('bannerImage').value;
                if (!title || !link) return alert('لطفاً عنوان و لینک را وارد کنید!');
                if (editingBannerId) {
                    const b = bannersData.find(b => b.id === editingBannerId);
                    if (b) { b.title = title;
                        b.link = link;
                        b.position = position;
                        b.status = status;
                        if (image) b.image = image;
                        alert('بنر به‌روزرسانی شد!'); }
                    editingBannerId = null;
                } else {
                    bannersData.push({
                        id: bannersData.length ? Math.max(...bannersData.map(b => b.id)) + 1 : 1,
                        title,
                        link,
                        position,
                        status,
                        image: image || 'https://picsum.photos/seed/random/800/400',
                    });
                    alert('بنر با موفقیت اضافه شد!');
                }
                $('bannerFormContainer').style.display = 'none';
                renderBanners();
            });

            function renderReportsTable() {
                const tbody = $('reportsTableBody');
                if (!tbody) return;
                const reportData = productsData.slice(0, 12).map(p => {
                    const sales = randomNumber(10, 200);
                    const revenue = sales * parseInt(p.price.replace(/[^0-9]/g, ''));
                    return {
                        name: p.name,
                        sales: sales,
                        revenue: revenue.toLocaleString(),
                        share: (Math.random() * 15 + 2).toFixed(1) + '%'
                    };
                });
                tbody.innerHTML = reportData.map(r => `
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-100">${r.name}</td>
                                    <td class="px-4 py-3 text-gray-300">${r.sales}</td>
                                    <td class="px-4 py-3 text-gray-100">${r.revenue} تومان</td>
                                    <td class="px-4 py-3 text-gray-400">${r.share}</td>
                                </tr>
                            `).join('');
            }

            function updateDashboardStats() {
                const today = new Date().toLocaleDateString('fa-IR');
                const todayOrders = ordersData.filter(o => o.date === today).length || randomNumber(10, 50);
                const todaySales = ordersData.filter(o => o.date === today).reduce((sum, o) => sum + parseInt(o.amount.replace(
                    /[^0-9]/g, '')), 0) ||
                    randomNumber(10000000, 50000000);
                const newUsers = usersData.filter(u => u.date === today).length || randomNumber(5, 30);
                $('todayOrders').textContent = todayOrders;
                $('todaySales').textContent = todaySales.toLocaleString();
                $('newUsers').textContent = newUsers;
                $('totalProducts').textContent = productsData.length;
            }

            function populateCategorySelect() {
                const select = $('prodCategory');
                if (!select) return;
                const currentVal = select.value;
                select.innerHTML = '<option value="">انتخاب کنید</option>' +
                    categoriesData.map(c => `<option value="${c.name}">${c.name}</option>`).join('');
                if (currentVal) select.value = currentVal;
            }

            // ============================================================
            // 10. SLIDERS CRUD
            // ============================================================
            function renderSliders() {
                const tbody = $('slidersTableBody');
                if (!tbody) return;
                tbody.innerHTML = slidersData.map(s => `
                                <tr>
                                    <td class="px-4 py-3">${s.id}</td>
                                    <td class="px-4 py-3">
                                        <img src="${s.image}" alt="${s.title}" class="slider-thumbnail rounded">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-100">${s.title}</td>
                                    <td class="px-4 py-3 text-gray-400 max-w-xs truncate">${s.desc || '-'}</td>
                                    <td class="px-4 py-3 text-blue-400"><a href="${s.link}" target="_blank">${s.link}</a></td>
                                    <td class="px-4 py-3 text-gray-300">${s.order}</td>
                                    <td class="px-4 py-3"><span class="badge-${s.status} badge text-xs px-3 py-1 rounded-full">${s.status === 'active' ? 'فعال' : 'غیرفعال'}</span></td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1">
                                            <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="editSlider(${s.id})">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteSlider(${s.id})">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            window.deleteSlider = function(id) {
                if (confirm('آیا از حذف این اسلاید اطمینان دارید؟')) {
                    const index = slidersData.findIndex(s => s.id === id);
                    if (index !== -1) { slidersData.splice(index, 1);
                        renderSliders();
                        alert('اسلاید حذف شد!'); }
                }
            };

            window.editSlider = function(id) {
                const s = slidersData.find(s => s.id === id);
                if (!s) return;
                editingSliderId = id;
                $('sliderFormTitle').textContent = 'ویرایش اسلاید';
                $('sliderSubmitText').textContent = 'به‌روزرسانی';
                $('sliderTitle').value = s.title;
                $('sliderLink').value = s.link;
                $('sliderImage').value = s.image;
                $('sliderOrder').value = s.order;
                $('sliderStatus').value = s.status;
                $('sliderDesc').value = s.desc || '';
                const preview = $('sliderPreview');
                preview.src = s.image;
                preview.classList.remove('hidden');
                $('sliderFormContainer').style.display = 'block';
                window.scrollTo({ top: $('sliderFormContainer').offsetTop - 100, behavior: 'smooth' });
            };

            $('addSliderBtn').addEventListener('click', function() {
                editingSliderId = null;
                $('sliderFormTitle').textContent = 'افزودن اسلاید جدید';
                $('sliderSubmitText').textContent = 'ذخیره';
                $('sliderForm').reset();
                $('sliderPreview').classList.add('hidden');
                $('sliderFormContainer').style.display = 'block';
                window.scrollTo({ top: $('sliderFormContainer').offsetTop - 100, behavior: 'smooth' });
            });

            $('cancelSlider').addEventListener('click', function() {
                $('sliderFormContainer').style.display = 'none';
            });

            $('sliderImage').addEventListener('input', function() {
                const preview = $('sliderPreview');
                if (this.value) {
                    preview.src = this.value;
                    preview.classList.remove('hidden');
                } else {
                    preview.classList.add('hidden');
                }
            });

            $('sliderForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const title = $('sliderTitle').value;
                const link = $('sliderLink').value;
                const image = $('sliderImage').value;
                const order = Number($('sliderOrder').value) || 1;
                const status = $('sliderStatus').value;
                const desc = $('sliderDesc').value;

                if (!title || !image) return alert('لطفاً عنوان و آدرس تصویر را وارد کنید!');

                if (editingSliderId) {
                    const s = slidersData.find(s => s.id === editingSliderId);
                    if (s) {
                        s.title = title;
                        s.link = link;
                        s.image = image;
                        s.order = order;
                        s.status = status;
                        s.desc = desc;
                        alert('اسلاید به‌روزرسانی شد!');
                    }
                    editingSliderId = null;
                } else {
                    slidersData.push({
                        id: nextSliderId++,
                        title,
                        link,
                        image,
                        order,
                        status,
                        desc
                    });
                    alert('اسلاید با موفقیت اضافه شد!');
                }
                $('sliderFormContainer').style.display = 'none';
                renderSliders();
            });

            // ============================================================
            // 11. CALENDAR
            // ============================================================
            let calendarDate = new Date();
            let selectedDate = new Date();

            function renderCalendar() {
                const year = calendarDate.getFullYear();
                const month = calendarDate.getMonth();
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const daysInPrevMonth = new Date(year, month, 0).getDate();

                const monthNames = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن',
                    'اسفند'
                ];
                $('calendarMonthYear').textContent = `${monthNames[month]} ${year}`;

                const grid = $('calendarGrid');
                if (!grid) return;
                let html = '';

                const startOffset = firstDay === 0 ? 6 : firstDay - 1;
                for (let i = startOffset - 1; i >= 0; i--) {
                    const day = daysInPrevMonth - i;
                    html += `<div class="day other-month">${day}</div>`;
                }

                const today = new Date();
                for (let d = 1; d <= daysInMonth; d++) {
                    const dateObj = new Date(year, month, d);
                    const isToday = dateObj.toDateString() === today.toDateString();
                    const hasEvent = calendarEvents.some(e => e.date.toDateString() === dateObj.toDateString());
                    let classes = 'day';
                    if (isToday) classes += ' today';
                    if (hasEvent) classes += ' has-event';
                    html += `<div class="${classes}" data-date="${dateObj.toISOString()}">${d}</div>`;
                }

                const totalCells = startOffset + daysInMonth;
                const remaining = (7 - (totalCells % 7)) % 7;
                for (let d = 1; d <= remaining; d++) {
                    html += `<div class="day other-month">${d}</div>`;
                }

                grid.innerHTML = html;

                const todayEvents = calendarEvents.filter(e => e.date.toDateString() === today.toDateString());
                const eventsContainer = $('todayEvents');
                if (eventsContainer) {
                    if (todayEvents.length) {
                        eventsContainer.innerHTML = todayEvents.map(e =>
                            `<span class="inline-flex items-center gap-1 mr-2"><span class="w-2 h-2 rounded-full" style="background:${e.color}"></span>${e.title}</span>`
                        ).join('');
                    } else {
                        eventsContainer.textContent = 'هیچ رویدادی برای امروز وجود ندارد.';
                    }
                }

                grid.querySelectorAll('.day:not(.other-month)').forEach(el => {
                    el.addEventListener('click', function() {
                        const dateStr = this.dataset.date;
                        if (dateStr) {
                            selectedDate = new Date(dateStr);
                            const dayEvents = calendarEvents.filter(e => e.date.toDateString() === selectedDate
                                .toDateString());
                            if (dayEvents.length) {
                                alert(
                                    `رویدادهای ${selectedDate.toLocaleDateString('fa-IR')}:\n${dayEvents.map(e => e.title).join('\n')}`
                                    );
                            } else {
                                alert(
                                    `هیچ رویدادی برای ${selectedDate.toLocaleDateString('fa-IR')} وجود ندارد.`);
                            }
                        }
                    });
                });

                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            $('prevMonth').addEventListener('click', function() {
                calendarDate.setMonth(calendarDate.getMonth() - 1);
                renderCalendar();
            });

            $('nextMonth').addEventListener('click', function() {
                calendarDate.setMonth(calendarDate.getMonth() + 1);
                renderCalendar();
            });

            $('todayBtn').addEventListener('click', function() {
                calendarDate = new Date();
                renderCalendar();
            });

            $('addEventBtn').addEventListener('click', function() {
                const title = $('eventTitleInput').value.trim();
                const dateVal = $('eventDateInput').value;
                const color = $('eventColorInput').value;
                if (!title) return alert('لطفاً عنوان رویداد را وارد کنید!');
                if (!dateVal) return alert('لطفاً تاریخ رویداد را انتخاب کنید!');
                const date = new Date(dateVal);
                calendarEvents.push({ date, title, color });
                $('eventTitleInput').value = '';
                $('eventDateInput').value = '';
                renderCalendar();
                alert('رویداد با موفقیت اضافه شد!');
            });

            // ============================================================
            // 12. DATA TABLE
            // ============================================================
            function renderDataTable() {
                const searchTerm = $('dataTableSearch')?.value.toLowerCase() || '';
                const filterStatus = $('dataTableFilter')?.value || 'all';

                let filtered = dataTableData.filter(item => {
                    const matchSearch = item.name.includes(searchTerm) || item.email.includes(searchTerm);
                    const matchStatus = filterStatus === 'all' || item.status === filterStatus;
                    return matchSearch && matchStatus;
                });

                filtered.sort((a, b) => {
                    let valA = a[sortField] || '';
                    let valB = b[sortField] || '';
                    if (typeof valA === 'string') valA = valA.toLowerCase();
                    if (typeof valB === 'string') valB = valB.toLowerCase();
                    if (valA < valB) return sortDirection === 'asc' ? -1 : 1;
                    if (valA > valB) return sortDirection === 'asc' ? 1 : -1;
                    return 0;
                });

                filteredData = filtered;

                const total = filteredData.length;
                const totalPages = Math.ceil(total / pageSize) || 1;
                if (currentPageData > totalPages) currentPageData = totalPages;
                const start = (currentPageData - 1) * pageSize;
                const end = Math.min(start + pageSize, total);
                const pageItems = filteredData.slice(start, end);

                const tbody = $('dataTableBody');
                if (!tbody) return;
                tbody.innerHTML = pageItems.map(u => `
                                <tr>
                                    <td class="px-4 py-3">${u.id}</td>
                                    <td class="px-4 py-3 font-medium text-gray-100">${u.name}</td>
                                    <td class="px-4 py-3 text-gray-400">${u.email}</td>
                                    <td class="px-4 py-3"><span class="badge-${u.role === 'ادمین' ? 'success' : u.role === 'مدیر' ? 'shipped' : 'pending'} badge text-xs px-3 py-1 rounded-full">${u.role}</span></td>
                                    <td class="px-4 py-3"><span class="badge-${u.status} badge text-xs px-3 py-1 rounded-full">${u.status === 'active' ? 'فعال' : 'غیرفعال'}</span></td>
                                    <td class="px-4 py-3 text-gray-400">${u.date}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1">
                                            <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="alert('ویرایش کاربر ${u.id}')">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="if(confirm('حذف شود؟')){alert('کاربر ${u.id} حذف شد!')}">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();

                const info = $('dataTableInfo');
                if (info) {
                    info.textContent = `نمایش ${start + 1} تا ${end} از ${total} نتیجه`;
                }

                const pagination = $('dataTablePagination');
                if (pagination) {
                    let phtml =
                        `<button onclick="goToDataPage(1)" ${currentPageData === 1 ? 'disabled' : ''}><i data-lucide="chevrons-right" class="w-4 h-4"></i></button>`;
                    phtml +=
                        `<button onclick="goToDataPage(${currentPageData - 1})" ${currentPageData === 1 ? 'disabled' : ''}><i data-lucide="chevron-right" class="w-4 h-4"></i></button>`;
                    for (let p = 1; p <= totalPages; p++) {
                        if (p === currentPageData) {
                            phtml += `<button class="active">${p}</button>`;
                        } else if (p === 1 || p === totalPages || Math.abs(p - currentPageData) <= 2) {
                            phtml += `<button onclick="goToDataPage(${p})">${p}</button>`;
                        } else if (p === 2 || p === totalPages - 1) {
                            phtml += `<span>...</span>`;
                        }
                    }
                    phtml +=
                        `<button onclick="goToDataPage(${currentPageData + 1})" ${currentPageData === totalPages ? 'disabled' : ''}><i data-lucide="chevron-left" class="w-4 h-4"></i></button>`;
                    phtml +=
                        `<button onclick="goToDataPage(${totalPages})" ${currentPageData === totalPages ? 'disabled' : ''}><i data-lucide="chevrons-left" class="w-4 h-4"></i></button>`;
                    pagination.innerHTML = phtml;
                    if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
                }
            }

            window.goToDataPage = function(page) {
                const total = filteredData.length;
                const totalPages = Math.ceil(total / pageSize) || 1;
                if (page < 1) page = 1;
                if (page > totalPages) page = totalPages;
                currentPageData = page;
                renderDataTable();
            };

            $('dataTableSearch')?.addEventListener('input', function() {
                currentPageData = 1;
                renderDataTable();
            });
            $('dataTableFilter')?.addEventListener('change', function() {
                currentPageData = 1;
                renderDataTable();
            });
            $('dataTableRefresh')?.addEventListener('click', function() {
                renderDataTable();
            });

            document.querySelectorAll('.sortable').forEach(el => {
                el.addEventListener('click', function() {
                    const field = this.dataset.sort;
                    if (sortField === field) {
                        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        sortField = field;
                        sortDirection = 'asc';
                    }
                    currentPageData = 1;
                    renderDataTable();
                });
            });

            // ============================================================
            // 13. CHARTS
            // ============================================================
            let salesChartInstance, productsChartInstance, reportsChart1Instance, reportsChart2Instance,
            analyticsChartInstance;

            function initCharts() {
                const ctx1 = document.getElementById('salesChart')?.getContext('2d');
                if (ctx1) {
                    if (salesChartInstance) salesChartInstance.destroy();
                    salesChartInstance = new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
                            datasets: [{ label: 'فروش (میلیون تومان)', data: [45, 52, 48, 70, 65, 82],
                                borderColor: currentColor, backgroundColor: currentColor + '40', fill: true,
                                tension: 0.4,
                                pointBackgroundColor: currentColor, pointBorderColor: '#1e293b',
                                pointBorderWidth: 2,
                                pointRadius: 4 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                            animation: { duration: 800, easing: 'easeOutQuart' },
                            scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                                x: { grid: { display: false } } } }
                    });
                }
                const ctx2 = document.getElementById('productsChart')?.getContext('2d');
                if (ctx2) {
                    if (productsChartInstance) productsChartInstance.destroy();
                    const counts = categoriesData.map(c => c.count);
                    const colors = ['#f97316', '#2563eb', '#22c55e', '#8b5cf6', '#f59e0b', '#ec4899', '#14b8a6'];
                    productsChartInstance = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: categoriesData.slice(0, 7).map(c => c.name),
                            datasets: [{ label: 'تعداد فروش', data: counts.slice(0, 7), backgroundColor: colors.slice(
                                    0, 7).map(c => c + 'CC'), borderColor: colors.slice(0, 7), borderWidth: 2,
                                borderRadius: 6 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                            animation: { duration: 700, easing: 'easeOutCubic' },
                            scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                                x: { grid: { display: false } } } }
                    });
                }
            }

            function initReportsCharts() {
                const ctx1 = document.getElementById('reportsChart1')?.getContext('2d');
                if (ctx1) {
                    if (reportsChart1Instance) reportsChart1Instance.destroy();
                    reportsChart1Instance = new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
                            datasets: [{ label: 'فروش (میلیون تومان)', data: [45, 52, 48, 70, 65, 82],
                                backgroundColor: currentColor + 'BB', borderColor: currentColor, borderWidth: 2,
                                borderRadius: 6 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                            animation: { duration: 800, easing: 'easeOutQuart' },
                            scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                                x: { grid: { display: false } } } }
                    });
                }
                const ctx2 = document.getElementById('reportsChart2')?.getContext('2d');
                if (ctx2) {
                    if (reportsChart2Instance) reportsChart2Instance.destroy();
                    const counts = categoriesData.map(c => c.count);
                    const colors = ['#f97316', '#2563eb', '#22c55e', '#8b5cf6', '#f59e0b', '#ec4899'];
                    reportsChart2Instance = new Chart(ctx2, {
                        type: 'doughnut',
                        data: {
                            labels: categoriesData.slice(0, 6).map(c => c.name),
                            datasets: [{ data: counts.slice(0, 6), backgroundColor: colors.slice(0, 6),
                                borderWidth: 0 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false,
                            animation: { duration: 750, easing: 'easeOutQuart' },
                            plugins: { legend: { position: 'bottom', labels: { padding: 10, usePointStyle: true,
                                        pointStyle: 'circle', font: { size: 11, color: '#94a3b8' } } } },
                            cutout: '60%' }
                    });
                }
            }

            function initAnalyticsChart() {
                const ctx = document.getElementById('analyticsChart')?.getContext('2d');
                if (ctx) {
                    if (analyticsChartInstance) analyticsChartInstance.destroy();
                    analyticsChartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['۱', '۵', '۱۰', '۱۵', '۲۰', '۲۵', '۳۰'],
                            datasets: [
                                { label: 'بازدید', data: [1200, 1400, 1100, 1800, 1600, 2100, 1900],
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59,130,246,0.15)', fill: true, tension: 0.4 },
                                { label: 'کاربران جدید', data: [45, 52, 38, 67, 55, 82, 70], borderColor: '#22c55e',
                                    backgroundColor: 'rgba(34,197,94,0.15)', fill: true, tension: 0.4 }
                            ]
                        },
                        options: { responsive: true, maintainAspectRatio: false,
                            animation: { duration: 800, easing: 'easeOutQuart' },
                            plugins: { legend: { position: 'bottom', labels: { padding: 10, usePointStyle: true,
                                        pointStyle: 'circle', font: { size: 11, color: '#94a3b8' } } } },
                            scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                                x: { grid: { display: false } } } }
                    });
                }
            }

            // ============================================================
            // 14. AI CHAT (با تایپ تیکه‌تیکه)
            // ============================================================
            const chatData = {
                initial: {
                    message: 'سلام! من هوش مصنوعی Grafioum هستم. چطور می‌توانم به شما کمک کنم؟',
                    options: [
                        { label: 'گزارش فروش', icon: 'bar-chart-3', action: 'sales_report' },
                        { label: 'وضعیت سفارشات', icon: 'shopping-bag', action: 'orders_status' },
                        { label: 'محصولات پرفروش', icon: 'trophy', action: 'top_products' },
                        { label: 'تحلیل بازدیدکنندگان', icon: 'users', action: 'visitor_analysis' }
                    ]
                },
                sales_report: {
                    message: `گزارش فروش ماهانه\n\nفروش کل: ۲۴۵,۸۰۰,۰۰۰ تومان\nتعداد سفارشات: ۱۲۴ سفارش\nمیانگین ارزش هر سفارش: ۱,۹۸۰,۰۰۰ تومان\n\nرشد فروش نسبت به ماه قبل: +۱۲.۵٪\nپرفروش‌ترین دسته: موبایل و لوازم جانبی\n\nآیا نیاز به گزارش جزئی‌تر دارید؟`,
                    options: [
                        { label: 'گزارش روزانه', icon: 'calendar', action: 'daily_report' },
                        { label: 'تحلیل دسته‌بندی', icon: 'pie-chart', action: 'category_analysis' },
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                orders_status: {
                    message: `وضعیت سفارشات امروز\n\nتحویل شده: ۴۲ سفارش\nدر انتظار: ۲۸ سفارش\nارسال شده: ۳۵ سفارش\nلغو شده: ۱۹ سفارش\n\nمیانگین زمان تحویل: ۲.۳ روز\nنرخ موفقیت: ۷۸٪`,
                    options: [
                        { label: 'لیست سفارشات در انتظار', icon: 'list', action: 'pending_orders' },
                        { label: 'آمار روزانه', icon: 'bar-chart', action: 'daily_orders_stats' },
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                top_products: {
                    message: `محصولات پرفروش هفته\n\n۱. گوشی سامسونگ S24 Ultra - ۴۵ عدد\n۲. هدفون بی‌سیم سونی - ۳۸ عدد\n۳. لپ‌تاپ ایسوس ROG - ۲۲ عدد\n۴. ساعت هوشمند اپل واچ - ۱۸ عدد\n۵. پاوربانک ۲۰۰۰۰ - ۱۵ عدد\n\nمجموع فروش این محصولات: ۱۸۲,۰۰۰,۰۰۰ تومان`,
                    options: [
                        { label: 'تحلیل فروش محصولات', icon: 'trending-up', action: 'product_sales_analysis' },
                        { label: 'مقایسه با هفته قبل', icon: 'refresh-cw', action: 'compare_weeks' },
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                visitor_analysis: {
                    message: `تحلیل بازدیدکنندگان امروز\n\nبازدید کل: ۱۲,۴۵۰\nکاربران جدید: ۴۷ نفر\nمیانگین زمان بازدید: ۴ دقیقه و ۳۲ ثانیه\nنرخ پرش: ۲۳٪\nبیشترین بازدید: ساعت ۱۰ تا ۱۲\n\nنسبت به دیروز: +۱۸٪`,
                    options: [
                        { label: 'بازدید بر اساس دستگاه', icon: 'smartphone', action: 'device_analysis' },
                        { label: 'بازدید بر اساس شهر', icon: 'map-pin', action: 'city_analysis' },
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                daily_report: {
                    message: `گزارش روزانه (امروز)\n\nفروش: ۳۲,۴۰۰,۰۰۰ تومان\nتعداد سفارش: ۴۲ سفارش\nمیانگین ارزش سفارش: ۷۷۱,۰۰۰ تومان\n\nپیک فروش: ساعت ۱۴-۱۶\nبیشترین فروش از طریق: اپلیکیشن موبایل (۶۸٪)`,
                    options: [
                        { label: 'مقایسه با دیروز', icon: 'arrow-left-right', action: 'compare_daily' },
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                category_analysis: {
                    message: `تحلیل فروش بر اساس دسته‌بندی\n\nموبایل: ۴۲٪\nلپ‌تاپ: ۲۲٪\nاکسسوری: ۱۸٪\nپوشاک: ۱۰٪\nلوازم خانگی: ۸٪\n\nرشد موبایل نسبت به ماه قبل: +۱۵٪`,
                    options: [
                        { label: 'جزئیات هر دسته', icon: 'layers', action: 'category_details' },
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                pending_orders: {
                    message: `سفارشات در انتظار (۲۸ مورد)\n\n۱۲ سفارش در انتظار تأیید پرداخت\n۸ سفارش در حال آماده‌سازی\n۵ سفارش در انتظار هماهنگی ارسال\n۳ سفارش مشکل دار\n\nمیانگین زمان انتظار: ۴.۲ ساعت`,
                    options: [
                        { label: 'مشاهده جزئیات', icon: 'info', action: 'pending_details' },
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                daily_orders_stats: {
                    message: `آمار روزانه سفارشات (۷ روز اخیر)\n\nشنبه: ۴۲\nیکشنبه: ۳۸\nدوشنبه: ۵۱\nسه‌شنبه: ۴۷\nچهارشنبه: ۵۵\nپنجشنبه: ۶۳\nجمعه: ۴۱\n\nمیانگین روزانه: ۴۸.۱ سفارش`,
                    options: [
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                product_sales_analysis: {
                    message: `تحلیل فروش محصولات\n\nگوشی سامسونگ: ۴۵ عدد، ارزش: ۱,۱۶۵,۵۰۰,۰۰۰\nهدفون سونی: ۳۸ عدد، ارزش: ۴۷,۵۰۰,۰۰۰\nلپ‌تاپ ایسوس: ۲۲ عدد، ارزش: ۷۵۹,۰۰۰,۰۰۰\nساعت اپل: ۱۸ عدد، ارزش: ۲۳۰,۴۰۰,۰۰۰\nپاوربانک: ۱۵ عدد، ارزش: ۴,۵۰۰,۰۰۰\n\nمجموع: ۲,۲۰۶,۹۰۰,۰۰۰ تومان`,
                    options: [
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                compare_weeks: {
                    message: `مقایسه هفته جاری با هفته قبل\n\nفروش: +۱۲.۵٪\nتعداد سفارش: +۸.۲٪\nمیانگین ارزش: +۴.۳٪\n\nمحصولات پرفروش هفته قبل:\n۱. ساعت هوشمند (۲۵ عدد)\n۲. گوشی سامسونگ (۲۲ عدد)\n\nرشد کلی: مثبت و رو به بهبود`,
                    options: [
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                device_analysis: {
                    message: `بازدید بر اساس دستگاه\n\nموبایل: ۶۸٪ (۸,۴۶۶ بازدید)\nدسکتاپ: ۲۲٪ (۲,۷۳۹ بازدید)\nتبلت: ۱۰٪ (۱,۲۴۵ بازدید)\n\nمیانگین زمان بازدید موبایل: ۳:۵۲\nمیانگین زمان بازدید دسکتاپ: ۶:۱۸`,
                    options: [
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                city_analysis: {
                    message: `بازدید بر اساس شهر\n\nتهران: ۵,۴۲۰ (۴۳.۵٪)\nاصفهان: ۱,۸۶۰ (۱۵٪)\nمشهد: ۱,۴۹۰ (۱۲٪)\nشیراز: ۹۹۰ (۸٪)\nتبریز: ۷۴۰ (۶٪)\nسایر: ۱,۹۵۰ (۱۵.۵٪)`,
                    options: [
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                compare_daily: {
                    message: `مقایسه امروز با دیروز\n\nفروش: +۸.۲٪ (۳۲,۴۰۰,۰۰۰ تومان)\nسفارشات: +۱۲.۳٪ (۴۲ سفارش)\nمیانگین ارزش: -۳.۶٪\n\nدیروز: فروش ۲۹,۹۰۰,۰۰۰، سفارش ۳۷`,
                    options: [
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                category_details: {
                    message: `جزئیات فروش دسته‌بندی‌ها\n\nموبایل: ۱۰۲,۸۰۰,۰۰۰ (۴۲٪)\nلپ‌تاپ: ۵۳,۹۰۰,۰۰۰ (۲۲٪)\nاکسسوری: ۴۴,۲۰۰,۰۰۰ (۱۸٪)\nپوشاک: ۲۴,۵۰۰,۰۰۰ (۱۰٪)\nلوازم خانگی: ۱۹,۶۰۰,۰۰۰ (۸٪)`,
                    options: [
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                pending_details: {
                    message: `جزئیات سفارشات در انتظار\n\n۱۲ سفارش در انتظار تأیید پرداخت (ارزش کل: ۱۴,۲۰۰,۰۰۰)\n۸ سفارش در حال آماده‌سازی (ارزش کل: ۹,۸۰۰,۰۰۰)\n۵ سفارش در انتظار هماهنگی (ارزش کل: ۶,۳۰۰,۰۰۰)\n۳ سفارش مشکل دار (ارزش کل: ۴,۱۰۰,۰۰۰)`,
                    options: [
                        { label: 'بازگشت', icon: 'arrow-left', action: 'back' }
                    ]
                },
                back: {
                    message: 'به منوی اصلی بازگشتید. لطفاً یکی از گزینه‌های زیر را انتخاب کنید:',
                    options: [
                        { label: 'گزارش فروش', icon: 'bar-chart-3', action: 'sales_report' },
                        { label: 'وضعیت سفارشات', icon: 'shopping-bag', action: 'orders_status' },
                        { label: 'محصولات پرفروش', icon: 'trophy', action: 'top_products' },
                        { label: 'تحلیل بازدیدکنندگان', icon: 'users', action: 'visitor_analysis' }
                    ]
                }
            };

            let chatHistory = [];
            let currentChatNode = 'initial';
            let isTyping = false;
            let typeTimer = null;

            function renderAIChat() {
                const container = $('chatContainer');
                const actions = $('quickActions');
                if (!container) return;

                container.innerHTML = chatHistory.map(msg => `
                                <div class="chat-bubble mb-3 ${msg.role === 'user' ? 'text-left' : 'text-right'}">
                                    <div class="inline-block max-w-[85%] p-3 rounded-xl ${msg.role === 'user' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-100'}">
                                        <p class="text-sm whitespace-pre-line">${msg.content}</p>
                                    </div>
                                </div>
                            `).join('');

                if (chatHistory.length === 0) {
                    const initialMsg = chatData.initial.message;
                    chatHistory.push({ role: 'assistant', content: initialMsg });
                    currentChatNode = 'initial';
                    renderAIChat();
                    renderQuickActions(chatData.initial.options);
                    return;
                }

                const currentNode = chatData[currentChatNode];
                if (currentNode && currentNode.options) {
                    renderQuickActions(currentNode.options);
                }

                container.scrollTop = container.scrollHeight;
            }

            function renderQuickActions(options) {
                const actions = $('quickActions');
                if (!actions) return;
                actions.innerHTML = options.map(opt => `
                                <button class="quick-btn px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-200 rounded-lg text-sm transition duration-200 border border-gray-700 flex items-center gap-1" data-action="${opt.action}">
                                    <i data-lucide="${opt.icon || 'circle'}" class="w-4 h-4"></i>
                                    ${opt.label}
                                </button>
                            `).join('');

                actions.querySelectorAll('button').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const action = this.dataset.action;
                        handleAIAction(action);
                    });
                });
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            }

            function handleAIAction(action) {
                if (!chatData[action] || isTyping) return;

                const node = chatData[action];
                const userLabel = chatData[currentChatNode]?.options?.find(o => o.action === action)?.label || action;

                chatHistory.push({ role: 'user', content: userLabel });

                isTyping = true;
                const fullMessage = node.message;
                let displayedMessage = '';
                let index = 0;

                chatHistory.push({ role: 'assistant', content: '' });
                const lastIndex = chatHistory.length - 1;

                renderAIChat();
                const actions = $('quickActions');
                if (actions) {
                    actions.style.pointerEvents = 'none';
                    actions.style.opacity = '0.5';
                }

                typeTimer = setInterval(() => {
                    if (index < fullMessage.length) {
                        displayedMessage += fullMessage.charAt(index);
                        chatHistory[lastIndex].content = displayedMessage;
                        const container = $('chatContainer');
                        const bubbles = container.querySelectorAll('.chat-bubble');
                        if (bubbles.length > 0) {
                            const lastBubble = bubbles[bubbles.length - 1];
                            const p = lastBubble.querySelector('p');
                            if (p) {
                                p.textContent = displayedMessage + '|';
                            }
                        }
                        container.scrollTop = container.scrollHeight;
                        index++;
                    } else {
                        clearInterval(typeTimer);
                        const container = $('chatContainer');
                        const bubbles = container.querySelectorAll('.chat-bubble');
                        if (bubbles.length > 0) {
                            const lastBubble = bubbles[bubbles.length - 1];
                            const p = lastBubble.querySelector('p');
                            if (p) {
                                p.textContent = fullMessage;
                            }
                        }
                        isTyping = false;
                        currentChatNode = action;
                        if (actions) {
                            actions.style.pointerEvents = 'all';
                            actions.style.opacity = '1';
                        }
                        renderQuickActions(node.options);
                        if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
                    }
                }, 35);
            }

            // ============================================================
            // 15. MOBILE MENU
            // ============================================================
            function openMobileMenu() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('translate-x-0');
                    sidebar.classList.remove('translate-x-full');
                    mobileOverlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeMobileMenu() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    mobileOverlay.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }

            mobileMenuBtn.addEventListener('click', openMobileMenu);
            mobileOverlay.addEventListener('click', closeMobileMenu);

            // ============================================================
            // 16. SEARCH
            // ============================================================
            globalSearch.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                if (!query) { renderAll(); return; }
                const filteredProducts = productsData.filter(p => p.name.includes(query) || p.category.includes(
                query));
                const tbody = $('productsTableBody');
                if (tbody) {
                    tbody.innerHTML = filteredProducts.map(p => `
                                    <tr>
                                        <td class="px-4 py-3">${p.id}</td>
                                        <td class="px-4 py-3 font-medium text-gray-100">${p.name}</td>
                                        <td class="px-4 py-3 text-gray-400">${p.category}</td>
                                        <td class="px-4 py-3 text-gray-100">${p.price}</td>
                                        <td class="px-4 py-3 ${p.stock < 10 ? 'text-red-400 font-bold' : 'text-gray-300'}">${p.stock}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-1">
                                                <button class="p-1.5 rounded bg-blue-900/40 text-blue-400 hover:bg-blue-800 transition duration-200 hover:scale-110" onclick="editProduct(${p.id})">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </button>
                                                <button class="p-1.5 rounded bg-red-900/40 text-red-400 hover:bg-red-800 transition duration-200 hover:scale-110" onclick="deleteProduct(${p.id})">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `).join('');
                    if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
                }
            });

            // ============================================================
            // 17. INIT
            // ============================================================
            function initAll() {
                renderAll();
                updateDashboardStats();
                populateCategorySelect();
                ['productFormContainer', 'categoryFormContainer', 'userFormContainer', 'couponFormContainer',
                    'bannerFormContainer', 'sliderFormContainer'
                ].forEach(id => {
                    const el = $(id);
                    if (el) el.style.display = 'none';
                });
                switchPage('dashboard');
                const dashboardPage = $('dashboard-page');
                if (dashboardPage) dashboardPage.classList.add('active');
                if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
                document.documentElement.setAttribute('data-theme', 'dark');
                themeToggle.classList.remove('light');
                document.documentElement.style.setProperty('--primary-color', '#2563eb');
                document.querySelectorAll('.color-option').forEach(c => c.classList.remove('active'));
                document.querySelector('.color-option[style*="background:#2563eb"]')?.classList.add('active');

                if (window.innerWidth < 768) {
                    sidebar.classList.add('translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                } else {
                    sidebar.classList.add('translate-x-0');
                    sidebar.classList.remove('translate-x-full');
                }

                if (chatHistory.length === 0) {
                    const initialMsg = chatData.initial.message;
                    chatHistory.push({ role: 'assistant', content: initialMsg });
                    currentChatNode = 'initial';
                }
            }

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    mobileOverlay.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                } else {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('translate-x-full');
                }
            });

            if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
            console.log('Grafioum admin panel loaded successfully.');
            console.log('Slider, calendar, data table and AI typing features initialized.');

            // ============================================================
            // END OF DOMContentLoaded
            // ============================================================
        }); // end DOMContentLoaded
    </script>
</body>
</html>