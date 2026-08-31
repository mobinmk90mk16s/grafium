<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>پنل مدیریت حرفه‌ای | GRAFIUM</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#080e1a', 900: '#0a1628', 800: '#0f1f33', 700: '#132238', 600: '#1a2f4a', 500: '#2a4a6a' },
                        blue: { 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb' },
                        emerald: { 400: '#34d399', 500: '#10b981' },
                        rose: { 400: '#fb7185', 500: '#f43f5e' },
                        amber: { 400: '#fbbf24', 500: '#f59e0b' },
                        violet: { 400: '#a78bfa', 500: '#8b5cf6' },
                        cyan: { 400: '#22d3ee', 500: '#06b6d4' },
                        pink: { 400: '#f472b6', 500: '#ec4899' },
                    },
                    fontFamily: { vazir: ['Vazirmatn', 'sans-serif'] }
                }
            }
        }
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0a1628; }
        ::-webkit-scrollbar-thumb { background: #1a2f4a; border-radius: 10px; }

        body { font-family: 'Vazirmatn', sans-serif; background: #080e1a; color: #e2e8f0; direction: rtl; }

        .sidebar { scrollbar-width: thin; scrollbar-color: #1a2f4a transparent; }
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: #1a2f4a; border-radius: 10px; }

        .menu-item {
            transition: all 0.2s ease;
            position: relative;
            cursor: pointer;
        }
        .menu-item:hover { background: rgba(255, 255, 255, 0.04); color: #f1f5f9; }
        .menu-item.active { background: rgba(59, 130, 246, 0.08); color: #60a5fa; }
        .menu-item.active i { color: #60a5fa; }
        .menu-item .menu-indicator {
            position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 24px; background: #3b82f6; border-radius: 0 4px 4px 0;
            opacity: 0; transition: opacity 0.2s;
        }
        .menu-item.active .menu-indicator { opacity: 1; }

        /* ===== STAT CARDS WITH FIXED COLORS AND ZOOM ===== */
        .stat-card {
            background: #0f1f33;
            border: 1px solid #1a2f4a;
            border-radius: 14px;
            padding: 20px 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            opacity: 1;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: scale(1.03);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);
        }
        .stat-card:hover::before {
            height: 5px;
        }

        .stat-blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .stat-blue { border-color: rgba(59, 130, 246, 0.2); }
        .stat-blue .stat-icon { background: rgba(59, 130, 246, 0.12); color: #60a5fa; }

        .stat-emerald::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-emerald { border-color: rgba(16, 185, 129, 0.2); }
        .stat-emerald .stat-icon { background: rgba(16, 185, 129, 0.12); color: #34d399; }

        .stat-amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .stat-amber { border-color: rgba(245, 158, 11, 0.2); }
        .stat-amber .stat-icon { background: rgba(245, 158, 11, 0.12); color: #fbbf24; }

        .stat-rose::before { background: linear-gradient(90deg, #f43f5e, #fb7185); }
        .stat-rose { border-color: rgba(244, 63, 94, 0.2); }
        .stat-rose .stat-icon { background: rgba(244, 63, 94, 0.12); color: #fb7185; }

        .stat-violet::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
        .stat-violet { border-color: rgba(139, 92, 246, 0.2); }
        .stat-violet .stat-icon { background: rgba(139, 92, 246, 0.12); color: #a78bfa; }

        .stat-cyan::before { background: linear-gradient(90deg, #06b6d4, #22d3ee); }
        .stat-cyan { border-color: rgba(6, 182, 212, 0.2); }
        .stat-cyan .stat-icon { background: rgba(6, 182, 212, 0.12); color: #22d3ee; }

        .stat-card .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
        }
        .stat-card .stat-label {
            font-size: 12px;
            font-weight: 500;
            margin-top: 2px;
        }
        .stat-card .stat-change {
            font-size: 10px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .table-wrap {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #1a2f4a;
            background: #0f1f33;
        }
        .table-wrap table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table-wrap thead { background: #0a1628; border-bottom: 1px solid #1a2f4a; }
        .table-wrap thead th {
            padding: 14px 16px; text-align: right; font-weight: 600; font-size: 11px;
            text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;
            border-bottom: 1px solid #1a2f4a; white-space: nowrap;
            cursor: pointer;
            user-select: none;
        }
        .table-wrap thead th:hover { color: #94a3b8; }
        .table-wrap tbody td {
            padding: 14px 16px; border-bottom: 1px solid #132238; color: #cbd5e1; vertical-align: middle;
        }
        .table-wrap tbody tr:last-child td { border-bottom: none; }
        .table-wrap tbody tr { transition: background 0.15s; }
        .table-wrap tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

        .badge {
            padding: 4px 14px; border-radius: 9999px; font-size: 11px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
        }
        .badge-active { background: rgba(16,185,129,0.12); color: #34d399; border: 1px solid rgba(16,185,129,0.2); }
        .badge-pending { background: rgba(245,158,11,0.12); color: #fbbf24; border: 1px solid rgba(245,158,11,0.2); }
        .badge-cancelled { background: rgba(244,63,94,0.12); color: #fb7185; border: 1px solid rgba(244,63,94,0.2); }
        .badge-completed { background: rgba(59,130,246,0.12); color: #60a5fa; border: 1px solid rgba(59,130,246,0.2); }
        .badge-expired { background: rgba(100,116,139,0.12); color: #94a3b8; border: 1px solid rgba(100,116,139,0.2); }

        .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

        .btn-emerald { background: rgba(16,185,129,0.08); color: #34d399; border: 1px solid rgba(16,185,129,0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-emerald:hover { background: rgba(16,185,129,0.15); }

        .btn-rose { background: rgba(244,63,94,0.08); color: #fb7185; border: 1px solid rgba(244,63,94,0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-rose:hover { background: rgba(244,63,94,0.15); }

        .input-dark {
            background: #0a1628; border: 1px solid #1a2f4a; border-radius: 8px; padding: 10px 14px;
            color: #e2e8f0; font-size: 13px; width: 100%; transition: border 0.2s; font-family: 'Vazirmatn', sans-serif;
        }
        .input-dark:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .input-dark::placeholder { color: #475569; }

        .filter-select {
            background: #0a1628; border: 1px solid #1a2f4a; border-radius: 8px; padding: 10px 14px;
            color: #e2e8f0; font-size: 13px; min-width: 140px; transition: border 0.2s; font-family: 'Vazirmatn', sans-serif; cursor: pointer;
        }
        .filter-select:focus { outline: none; border-color: #3b82f6; }

        .avatar-icon { width: 36px; height: 36px; border-radius: 50%; background: #1a2f4a; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 16px; }

        .tab-content { display: none; animation: fadeIn 0.3s ease forwards; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { 0% { opacity: 0; transform: translateY(8px); } 100% { opacity: 1; transform: translateY(0); } }

        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);
            display: none; align-items: center; justify-content: center; z-index: 999;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 16px;
            padding: 32px; max-width: 550px; width: 90%; max-height: 90vh; overflow-y: auto;
        }

        .toast-container {
            position: fixed; bottom: 24px; left: 24px; z-index: 9999;
            display: flex; flex-direction: column; gap: 8px;
        }
        .toast-item {
            padding: 14px 20px; border-radius: 12px; min-width: 300px; max-width: 450px;
            backdrop-filter: blur(8px); box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            animation: slideIn 0.4s ease forwards;
            display: flex; align-items: center; gap: 12px;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .toast-item.hiding { animation: slideOut 0.3s ease forwards; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }

        .toast-success { background: rgba(16,185,129,0.15); border-color: rgba(16,185,129,0.3); color: #34d399; }
        .toast-error { background: rgba(244,63,94,0.15); border-color: rgba(244,63,94,0.3); color: #fb7185; }
        .toast-info { background: rgba(59,130,246,0.15); border-color: rgba(59,130,246,0.3); color: #60a5fa; }
        .toast-warning { background: rgba(245,158,11,0.15); border-color: rgba(245,158,11,0.3); color: #fbbf24; }

        /* ============================================================
           AI FLOATING BUTTON
        ============================================================ */
        .ai-float-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 40px rgba(59, 130, 246, 0.4);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 3s ease-in-out infinite;
        }
        .ai-float-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 50px rgba(59, 130, 246, 0.6);
        }
        .ai-float-btn .pulse {
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid rgba(59, 130, 246, 0.3);
            animation: pulse-ring 2s ease-out infinite;
        }
        .ai-float-btn .pulse:nth-child(2) { animation-delay: 0.5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        /* AI Chat Modal */
        .ai-chat-modal .modal-box {
            max-width: 700px;
            padding: 0;
            border-radius: 24px;
            background: #0a1628;
            border: 1px solid rgba(139, 92, 246, 0.2);
            backdrop-filter: blur(20px);
            height: 80vh;
            max-height: 700px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .ai-chat-modal .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #1a2f4a;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(10, 22, 40, 0.8);
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }
        .ai-chat-modal .modal-header .ai-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ai-chat-modal .modal-header .ai-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 3s ease-in-out infinite;
        }
        .ai-chat-modal .modal-header .ai-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #34d399;
        }
        .ai-chat-modal .modal-header .ai-status .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #34d399;
            animation: pulse-dot 1.5s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .ai-chat-modal .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px 24px;
            scroll-behavior: smooth;
        }
        .ai-chat-modal .chat-messages::-webkit-scrollbar { width: 4px; }
        .ai-chat-modal .chat-messages::-webkit-scrollbar-track { background: transparent; }
        .ai-chat-modal .chat-messages::-webkit-scrollbar-thumb { background: #1a2f4a; border-radius: 10px; }

        .ai-chat-modal .message {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            animation: fadeIn 0.3s ease forwards;
        }
        .ai-chat-modal .message.user { flex-direction: row-reverse; }
        .ai-chat-modal .message .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .ai-chat-modal .message .avatar.ai {
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            color: white;
        }
        .ai-chat-modal .message .avatar.user {
            background: #1a2f4a;
            color: #60a5fa;
        }
        .ai-chat-modal .message .bubble {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.6;
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        .ai-chat-modal .message.ai .bubble {
            background: #1a2f4a;
            color: #e2e8f0;
            border-bottom-right-radius: 4px;
        }
        .ai-chat-modal .message.user .bubble {
            background: #3b82f6;
            color: white;
            border-bottom-left-radius: 4px;
        }
        .ai-chat-modal .message .bubble .typing-cursor {
            display: inline-block;
            width: 2px;
            height: 16px;
            background: #60a5fa;
            animation: blink 0.8s step-end infinite;
            margin-right: 2px;
            vertical-align: text-bottom;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .ai-chat-modal .chat-input-area {
            padding: 16px 24px;
            border-top: 1px solid #1a2f4a;
            display: flex;
            gap: 12px;
            flex-shrink: 0;
            background: rgba(10, 22, 40, 0.8);
            backdrop-filter: blur(10px);
        }
        .ai-chat-modal .chat-input-area input {
            flex: 1;
            background: #0a1628;
            border: 1px solid #1a2f4a;
            border-radius: 10px;
            padding: 12px 16px;
            color: #e2e8f0;
            font-size: 13px;
            font-family: 'Vazirmatn', sans-serif;
            outline: none;
            transition: border 0.2s;
        }
        .ai-chat-modal .chat-input-area input:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        .ai-chat-modal .chat-input-area input::placeholder {
            color: #475569;
        }
        .ai-chat-modal .chat-input-area .btn-send {
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ai-chat-modal .chat-input-area .btn-send:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
        }
        .ai-chat-modal .chat-input-area .btn-send:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .ai-chat-modal .quick-replies {
            padding: 8px 24px 12px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            border-top: 1px solid #132238;
            flex-shrink: 0;
            background: rgba(10, 22, 40, 0.6);
        }
        .ai-chat-modal .quick-replies .qr-btn {
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #1a2f4a;
            background: transparent;
            color: #94a3b8;
            font-size: 12px;
            font-family: 'Vazirmatn', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
        }
        .ai-chat-modal .quick-replies .qr-btn:hover {
            border-color: #8b5cf6;
            color: #a78bfa;
            background: rgba(139, 92, 246, 0.05);
        }

        .ai-chat-modal .update-banner {
            padding: 10px 24px;
            background: rgba(245, 158, 11, 0.08);
            border-bottom: 1px solid rgba(245, 158, 11, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            font-size: 12px;
            color: #fbbf24;
        }
        .ai-chat-modal .update-banner .btn-update {
            padding: 4px 16px;
            border-radius: 6px;
            border: 1px solid rgba(245, 158, 11, 0.3);
            background: rgba(245, 158, 11, 0.1);
            color: #fbbf24;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Vazirmatn', sans-serif;
        }
        .ai-chat-modal .update-banner .btn-update:hover {
            background: rgba(245, 158, 11, 0.2);
        }

        .chart-container { position: relative; height: 280px; width: 100%; }
        .chart-container canvas { max-height: 280px; }

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; border-left: none; border-bottom: 1px solid #1a2f4a; }
            .main-content { margin-right: 0 !important; padding: 16px !important; }
            .stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
            .toast-item { min-width: auto; max-width: 90%; }
            .ai-float-btn { width: 56px; height: 56px; bottom: 20px; right: 20px; }
            .ai-float-btn svg { width: 28px; height: 28px; }
            .ai-chat-modal .modal-box { height: 90vh; max-height: none; border-radius: 16px; }
            .ai-chat-modal .message .bubble { max-width: 85%; font-size: 13px; }
        }
        @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr !important; } .table-wrap { overflow-x: auto; } }
    </style>
</head>
<body>

    <!-- ============================================================
    SIDEBAR
    ============================================================ -->
    <aside class="sidebar fixed right-0 top-0 w-[270px] h-screen bg-[#0a1628] border-l border-[#1a2f4a] p-4 overflow-y-auto z-50">
        <div class="text-center mb-6 pb-4 border-b border-[#1a2f4a]">
            <div class="flex items-center justify-center gap-2">
                <i data-lucide="gem" class="w-6 h-6 text-blue-400"></i>
                <h2 class="text-2xl font-extrabold text-white tracking-tight">GRAFIUM</h2>
            </div>
            <p class="text-[11px] text-[#475569] mt-1">پنل مدیریت</p>
        </div>

        <nav class="space-y-5">
            @php
                $menuSections = [
                    'اصلی' => [
                        ['id' => 'dashboard', 'icon' => 'layout-dashboard', 'label' => 'داشبورد']
                    ],
                    'فروشگاه' => [
                        ['id' => 'products', 'icon' => 'package', 'label' => 'محصولات'],
                        ['id' => 'categories', 'icon' => 'tags', 'label' => 'دسته‌بندی‌ها'],
                        ['id' => 'orders', 'icon' => 'shopping-cart', 'label' => 'سفارشات'],
                        ['id' => 'discounts', 'icon' => 'percent', 'label' => 'تخفیف‌ها'],
                        ['id' => 'warehouses', 'icon' => 'warehouse', 'label' => 'انبارها']
                    ],
                    'کاربران' => [
                        ['id' => 'users', 'icon' => 'users', 'label' => 'کاربران'],
                        ['id' => 'admins', 'icon' => 'user-cog', 'label' => 'مدیران'],
                        ['id' => 'reviews', 'icon' => 'star', 'label' => 'نظرات']
                    ],
                    'گزارشات' => [
                        ['id' => 'sales', 'icon' => 'chart-line', 'label' => 'فروش'],
                        ['id' => 'analytics', 'icon' => 'chart-pie', 'label' => 'تحلیل‌ها']
                    ],
                    'ابزارها' => [
                        ['id' => 'slider', 'icon' => 'image', 'label' => 'اسلایدر'],
                        ['id' => 'calendar', 'icon' => 'calendar', 'label' => 'تقویم'],
                        ['id' => 'datatable', 'icon' => 'table', 'label' => 'جدول داده'],
                        ['id' => 'blog', 'icon' => 'newspaper', 'label' => 'بلاگ']
                    ],
                    'سیستم' => [
                        ['id' => 'settings', 'icon' => 'settings', 'label' => 'تنظیمات']
                    ]
                ];
            @endphp

            @foreach($menuSections as $section => $items)
                <div>
                    <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">{{ $section }}</p>
                    <ul class="space-y-0.5">
                        @foreach($items as $item)
                            <li>
                                <a href="#" onclick="switchTab('{{ $item['id'] }}-tab')" 
                                   class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition {{ $loop->first && $section == 'اصلی' ? 'active' : '' }}" 
                                   data-tab="{{ $item['id'] }}-tab">
                                    <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 text-[#60a5fa]"></i>
                                    {{ $item['label'] }}
                                    <span class="menu-indicator"></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <form action="{{ route('admin.logout') }}" method="POST" class="pt-4 border-t border-[#1a2f4a]">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:bg-rose-500/10 transition w-full text-sm font-medium">
                    <i data-lucide="log-out" class="w-5 h-5"></i> خروج از پنل
                </button>
            </form>
        </nav>
    </aside>

    <!-- ============================================================
    TOAST CONTAINER
    ============================================================ -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- ============================================================
    AI FLOATING BUTTON
    ============================================================ -->
    <button class="ai-float-btn" onclick="toggleAIChat()" id="aiFloatBtn">
        <span class="pulse"></span>
        <span class="pulse"></span>
        <i data-lucide="bot" class="w-9 h-9 text-white"></i>
    </button>

    <!-- ============================================================
    AI CHAT MODAL (with more options)
    ============================================================ -->
    <div id="aiChatModal" class="modal-overlay ai-chat-modal">
        <div class="modal-box">
            <!-- Header -->
            <div class="modal-header">
                <div class="ai-info">
                    <div class="ai-avatar">
                        <i data-lucide="bot" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-sm">دستیار هوش مصنوعي</h3>
                        <div class="ai-status">
                            <span class="dot"></span>
                            <span>آنلاین</span>
                        </div>
                    </div>
                </div>
                <button onclick="toggleAIChat()" class="text-[#64748b] hover:text-white transition">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Update Banner -->
            <div class="update-banner">
                <div class="flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-amber-400"></i>
                    <span id="aiDataInfo">اطلاعات برای تاریخ <span id="aiDataDate"></span> هست. برای اطلاعات به‌روز، بروزرسانی کنید.</span>
                </div>
                <button class="btn-update" onclick="updateAIData()">
                    <i data-lucide="refresh-cw" class="w-3 h-3 inline"></i> بروزرسانی
                </button>
            </div>

            <!-- Messages -->
            <div class="chat-messages" id="aiChatMessages">
                <div class="message ai">
                    <div class="avatar ai">
                        <i data-lucide="bot" class="w-5 h-5"></i>
                    </div>
                    <div class="bubble">
                        سلام! من دستیار هوش مصنوعي GRAFIUM هستم. 
                        <span class="typing-cursor"></span>
                    </div>
                </div>
            </div>

            <!-- Quick Replies (more options) -->
            <div class="quick-replies" id="aiQuickReplies">
                <button class="qr-btn" onclick="sendQuickReply('سلام')">سلام</button>
                <button class="qr-btn" onclick="sendQuickReply('آمار فروش امروز')">فروش امروز</button>
                <button class="qr-btn" onclick="sendQuickReply('مقایسه با دیروز')">مقایسه با دیروز</button>
                <button class="qr-btn" onclick="sendQuickReply('تعداد کاربران')">کاربران</button>
                <button class="qr-btn" onclick="sendQuickReply('پرفروش‌ترین محصول')">پرفروش‌ترین</button>
                <button class="qr-btn" onclick="sendQuickReply('پیش‌بینی فروش')">پیش‌بینی فروش</button>
                <button class="qr-btn" onclick="sendQuickReply('تحلیل روند')">تحلیل روند</button>
                <button class="qr-btn" onclick="sendQuickReply('گزارش هفتگی')">گزارش هفتگی</button>
                <button class="qr-btn" onclick="sendQuickReply('بهترین زمان فروش')">بهترین زمان</button>
            </div>

            <!-- Input -->
            <div class="chat-input-area">
                <input type="text" id="aiChatInput" placeholder="پیام خود را بنویسید..." onkeypress="if(event.key==='Enter') sendAIMessage()" />
                <button class="btn-send" onclick="sendAIMessage()" id="aiSendBtn">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    ارسال
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================================
    MAIN CONTENT
    ============================================================ -->
    <main class="mr-[270px] p-6 min-h-screen main-content">

        <!-- HEADER -->
        <div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
            <div>
                <div class="flex items-center gap-3">
                    <i data-lucide="layout-dashboard" class="w-6 h-6 text-blue-400"></i>
                    <h1 class="text-2xl font-extrabold text-white"><span id="pageTitle">داشبورد</span></h1>
                </div>
                <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت جامع سیستم</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
                <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
            </div>
        </div>
<!-- ============================================================
TAB: DASHBOARD (با کارت‌های رنگی ثابت و زوم)
============================================================ -->
<div id="dashboard-tab" class="tab-content active">

    <!-- ===== STATS CARDS WITH COLOR-CODED & ZOOM ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6 stats-grid">
        
        <!-- Card 1: مدیران - آبی -->
        <div class="stat-card stat-blue group hover:scale-[1.02] transition-all duration-300 cursor-pointer">
            <div class="flex items-start justify-between">
                <div>
                    <span class="stat-number">{{ number_format($stats['total_admins'] ?? 0) }}</span>
                    <p class="stat-label text-blue-400">مدیران</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user-cog" class="w-6 h-6 text-blue-400"></i>
                </div>
            </div>
            <div class="stat-change text-blue-400/70">
                <span>↑ ۱۲٪ نسبت به ماه قبل</span>
            </div>
        </div>

        <!-- Card 2: کاربران - زمردی -->
        <div class="stat-card stat-emerald group hover:scale-[1.02] transition-all duration-300 cursor-pointer">
            <div class="flex items-start justify-between">
                <div>
                    <span class="stat-number">{{ number_format($stats['total_users'] ?? 0) }}</span>
                    <p class="stat-label text-emerald-400">کاربران</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="users" class="w-6 h-6 text-emerald-400"></i>
                </div>
            </div>
            <div class="stat-change text-emerald-400/70">
                <span>↑ ۸٪ نسبت به ماه قبل</span>
            </div>
        </div>

        <!-- Card 3: رزروها - کهربایی -->
        <div class="stat-card stat-amber group hover:scale-[1.02] transition-all duration-300 cursor-pointer">
            <div class="flex items-start justify-between">
                <div>
                    <span class="stat-number">{{ number_format($stats['total_reservations'] ?? 0) }}</span>
                    <p class="stat-label text-amber-400">رزروها</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="calendar-check" class="w-6 h-6 text-amber-400"></i>
                </div>
            </div>
            <div class="stat-change text-amber-400/70">
                <span>↑ ۵٪ نسبت به ماه قبل</span>
            </div>
        </div>

        <!-- Card 4: فاکتورها - رز -->
        <div class="stat-card stat-rose group hover:scale-[1.02] transition-all duration-300 cursor-pointer">
            <div class="flex items-start justify-between">
                <div>
                    <span class="stat-number">{{ number_format($stats['total_invoices'] ?? 0) }}</span>
                    <p class="stat-label text-rose-400">فاکتورها</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-rose-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="file-text" class="w-6 h-6 text-rose-400"></i>
                </div>
            </div>
            <div class="stat-change text-rose-400/70">
                <span>↑ ۳٪ نسبت به ماه قبل</span>
            </div>
        </div>
    </div>

    <!-- ===== CHARTS ROW ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="card card-blue bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-3">
                <i data-lucide="chart-column" class="w-5 h-5 text-blue-400"></i>
                <h3 class="text-base font-bold text-white">فروش ماهانه</h3>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        <div class="card card-emerald bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-3">
                <i data-lucide="pie-chart" class="w-5 h-5 text-emerald-400"></i>
                <h3 class="text-base font-bold text-white">توزیع سفارشات</h3>
            </div>
            <div class="chart-container">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ===== WELCOME & ADMINS LAST LOGIN ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="card card-violet bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5 lg:col-span-2">
            <div class="flex items-start gap-3">
                <div class="w-12 h-12 rounded-full bg-violet-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user" class="w-6 h-6 text-violet-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">خوش آمدید، {{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</h2>
                    <p class="text-[#94a3b8] mt-1">به پنل مدیریت GRAFIUM خوش آمدید.</p>
                    <div class="flex items-center gap-2 mt-3 text-xs text-[#475569]">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>آخرین ورود: {{ Auth::guard('admin')->user()->last_login ?? 'اولین ورود' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-amber bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="users" class="w-5 h-5 text-amber-400"></i>
                <h3 class="text-sm font-bold text-white">آخرین ورود مدیران</h3>
            </div>
            <div class="space-y-2 max-h-48 overflow-y-auto">
                @php
                    $adminsList = [
                        ['name' => 'مدیر اصلی', 'last_login' => '۱۴۰۵/۰۶/۱۵ ۱۴:۳۰'],
                        ['name' => 'مدیر فروش', 'last_login' => '۱۴۰۵/۰۶/۱۴ ۰۹:۱۵'],
                        ['name' => 'پشتیبان', 'last_login' => '۱۴۰۵/۰۶/۱۳ ۲۲:۴۵'],
                    ];
                @endphp
                @foreach($adminsList as $admin)
                <div class="flex items-center justify-between py-1.5 border-b border-[#1a2f4a] last:border-0">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[9px] text-amber-400 font-bold">
                            {{ substr($admin['name'], 0, 1) }}
                        </div>
                        <span class="text-xs text-[#94a3b8]">{{ $admin['name'] }}</span>
                    </div>
                    <span class="text-[10px] text-[#64748b] font-mono">{{ $admin['last_login'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ===== RECENT RESERVATIONS TABLE ===== -->
    <div class="table-wrap">
        <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
            <div class="flex items-center gap-3">
                <i data-lucide="clock" class="w-5 h-5 text-blue-400"></i>
                <h3 class="text-base font-bold text-white">آخرین رزروها</h3>
            </div>
            <span class="text-xs text-[#475569]">{{ isset($recent_reservations) ? $recent_reservations->count() : 0 }} رزرو</span>
        </div>
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>کاربر</th>
                        <th>میز</th>
                        <th>تاریخ</th>
                        <th>شیفت</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($recent_reservations) && $recent_reservations->count() > 0)
                        @foreach($recent_reservations as $res)
                        <tr>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[10px] text-blue-400 font-bold">
                                        {{ substr($res->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span>{{ $res->user->name ?? 'نامشخص' }}</span>
                                </div>
                            </td>
                            <td><span class="font-mono text-blue-400">میز {{ $res->desk->desk_number ?? '—' }}</span></td>
                            <td>{{ $res->reservation_date ?? '—' }}</td>
                            <td>{{ $res->shift_persian ?? '—' }}</td>
                            <td>
                                <span class="badge badge-{{ $res->status }}">
                                    @switch($res->status)
                                        @case('active') فعال @break
                                        @case('pending') در انتظار @break
                                        @case('cancelled') لغو شده @break
                                        @case('completed') تکمیل شده @break
                                        @default {{ $res->status }}
                                    @endswitch
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <button class="text-blue-400 hover:text-blue-300" onclick="showToast('ویرایش رزرو', 'info')">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </button>
                                    <button class="text-rose-400 hover:text-rose-300" onclick="showToast('حذف رزرو', 'error')">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center py-8 text-[#475569]">
                                <i data-lucide="calendar-off" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i>
                                <p>هیچ رزروی یافت نشد</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
        <!-- ============================================================
        TAB: PRODUCTS (سایر تب‌ها)
        ============================================================ -->
        <div id="products-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="package" class="w-5 h-5 text-emerald-400"></i>
                        <h2 class="text-xl font-bold text-white">مدیریت محصولات</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت همه محصولات فروشگاه</p>
                </div>
                <button class="btn-emerald" onclick="showToast('فرم افزودن محصول باز می‌شود', 'info')">
                    <i data-lucide="plus" class="w-4 h-4"></i> محصول جدید
                </button>
            </div>
            <div class="flex flex-wrap gap-3 mb-5">
                <input type="text" placeholder="جستجوی محصول..." class="input-dark max-w-xs" />
                <select class="filter-select"><option>همه دسته‌ها</option><option>دسته اول</option><option>دسته دوم</option></select>
                <button class="btn-blue"><i data-lucide="search" class="w-4 h-4"></i> جستجو</button>
            </div>
            <div class="table-wrap">
                <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
                    <span class="text-xs text-[#475569]">۵ محصول</span>
                </div>
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>نام محصول</th>
                                <th>دسته‌بندی</th>
                                <th>قیمت</th>
                                <th>موجودی</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $products = [
                                    ['name' => 'محصول شماره ۱', 'category' => 'دسته اول', 'price' => '۱,۲۰۰,۰۰۰', 'stock' => 15, 'status' => 'active'],
                                    ['name' => 'محصول شماره ۲', 'category' => 'دسته دوم', 'price' => '۸۵۰,۰۰۰', 'stock' => 3, 'status' => 'pending'],
                                    ['name' => 'محصول شماره ۳', 'category' => 'دسته اول', 'price' => '۲,۱۰۰,۰۰۰', 'stock' => 0, 'status' => 'cancelled'],
                                ];
                            @endphp
                            @foreach($products as $p)
                            <tr>
                                <td class="font-medium">{{ $p['name'] }}</td>
                                <td>{{ $p['category'] }}</td>
                                <td class="text-emerald-400 font-bold">{{ $p['price'] }} تومان</td>
                                <td>{{ $p['stock'] }}</td>
                                <td><span class="badge badge-{{ $p['status'] }}">{{ $p['status'] == 'active' ? 'موجود' : ($p['status'] == 'pending' ? 'در انتظار' : 'ناموجود') }}</span></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button class="text-blue-400 hover:text-blue-300" onclick="showToast('ویرایش محصول', 'info')"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                        <button class="text-rose-400 hover:text-rose-300" onclick="showToast('حذف محصول', 'error')"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Categories Tab -->
        <div id="categories-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="tags" class="w-5 h-5 text-amber-400"></i>
                        <h2 class="text-xl font-bold text-white">دسته‌بندی‌ها</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت دسته‌بندی‌های محصولات</p>
                </div>
                <button class="btn-emerald" onclick="showToast('فرم افزودن دسته‌بندی باز می‌شود', 'info')">
                    <i data-lucide="plus" class="w-4 h-4"></i> دسته جدید
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $categories = [
                        ['name' => 'دسته اول', 'count' => 12],
                        ['name' => 'دسته دوم', 'count' => 8],
                        ['name' => 'دسته سوم', 'count' => 5],
                        ['name' => 'دسته چهارم', 'count' => 3],
                    ];
                @endphp
                @foreach($categories as $cat)
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-4 hover:border-blue-400/30 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-white">{{ $cat['name'] }}</span>
                        <i data-lucide="folder" class="w-6 h-6 text-blue-400/60"></i>
                    </div>
                    <p class="text-[#64748b] text-sm mt-2">{{ $cat['count'] }} محصول</p>
                    <div class="flex gap-3 mt-3">
                        <button class="text-blue-400 hover:text-blue-300 text-sm" onclick="showToast('ویرایش دسته‌بندی', 'info')">
                            <i data-lucide="pencil" class="w-4 h-4 inline"></i> ویرایش
                        </button>
                        <button class="text-rose-400 hover:text-rose-300 text-sm" onclick="showToast('حذف دسته‌بندی', 'error')">
                            <i data-lucide="trash-2" class="w-4 h-4 inline"></i> حذف
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Orders Tab -->
        <div id="orders-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="shopping-cart" class="w-5 h-5 text-cyan-400"></i>
                        <h2 class="text-xl font-bold text-white">سفارشات</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت همه سفارشات</p>
                </div>
                <select class="filter-select"><option>همه سفارشات</option><option>پرداخت شده</option><option>در انتظار</option></select>
            </div>
            <div class="table-wrap">
                <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
                    <span class="text-xs text-[#475569]">۴ سفارش</span>
                </div>
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>شماره</th>
                                <th>کاربر</th>
                                <th>تاریخ</th>
                                <th>مبلغ</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $orders = [
                                    ['id' => 'ORD-001', 'user' => 'علی رضایی', 'date' => '۱۴۰۵/۰۵/۲۰', 'amount' => '۱,۵۰۰,۰۰۰', 'status' => 'paid'],
                                    ['id' => 'ORD-002', 'user' => 'مریم حسینی', 'date' => '۱۴۰۵/۰۵/۱۹', 'amount' => '۷۵۰,۰۰۰', 'status' => 'pending'],
                                    ['id' => 'ORD-003', 'user' => 'رضا کریمی', 'date' => '۱۴۰۵/۰۵/۱۸', 'amount' => '۲,۲۰۰,۰۰۰', 'status' => 'cancelled'],
                                ];
                            @endphp
                            @foreach($orders as $o)
                            <tr>
                                <td class="font-mono text-blue-400">{{ $o['id'] }}</td>
                                <td>{{ $o['user'] }}</td>
                                <td>{{ $o['date'] }}</td>
                                <td class="font-bold text-emerald-400">{{ $o['amount'] }} تومان</td>
                                <td><span class="badge badge-{{ $o['status'] }}">{{ $o['status'] == 'paid' ? 'پرداخت شده' : ($o['status'] == 'pending' ? 'در انتظار' : 'لغو شده') }}</span></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button class="text-blue-400 hover:text-blue-300" onclick="showToast('ویرایش سفارش', 'info')"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                        <button class="text-rose-400 hover:text-rose-300" onclick="showToast('حذف سفارش', 'error')"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Discounts Tab -->
        <div id="discounts-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="percent" class="w-5 h-5 text-amber-400"></i>
                        <h2 class="text-xl font-bold text-white">کدهای تخفیف</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت کدهای تخفیف</p>
                </div>
                <button class="btn-emerald" onclick="showToast('فرم افزودن تخفیف باز می‌شود', 'info')">
                    <i data-lucide="plus" class="w-4 h-4"></i> کد جدید
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $discounts = [
                        ['code' => 'SUMMER50', 'discount' => '۵۰٪', 'expires' => '۱۴۰۵/۰۶/۰۱', 'used' => 45, 'status' => 'active'],
                        ['code' => 'WELCOME10', 'discount' => '۱۰٪', 'expires' => '۱۴۰۵/۰۷/۱۵', 'used' => 120, 'status' => 'active'],
                        ['code' => 'VIP20', 'discount' => '۲۰٪', 'expires' => '۱۴۰۵/۰۵/۲۵', 'used' => 8, 'status' => 'expired'],
                    ];
                @endphp
                @foreach($discounts as $d)
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-4 hover:border-amber-400/30 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-blue-400">{{ $d['code'] }}</span>
                        <span class="badge badge-{{ $d['status'] }}">{{ $d['status'] == 'active' ? 'فعال' : 'منقضی' }}</span>
                    </div>
                    <p class="text-2xl font-extrabold text-white mt-2">{{ $d['discount'] }}</p>
                    <p class="text-xs text-[#64748b]">انقضا: {{ $d['expires'] }}</p>
                    <p class="text-xs text-[#64748b]">تعداد استفاده: {{ $d['used'] }}</p>
                    <div class="flex gap-3 mt-3">
                        <button class="text-blue-400 hover:text-blue-300 text-sm" onclick="showToast('ویرایش تخفیف', 'info')">
                            <i data-lucide="pencil" class="w-4 h-4 inline"></i> ویرایش
                        </button>
                        <button class="text-rose-400 hover:text-rose-300 text-sm" onclick="showToast('حذف تخفیف', 'error')">
                            <i data-lucide="trash-2" class="w-4 h-4 inline"></i> حذف
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Warehouses Tab -->
        <div id="warehouses-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="warehouse" class="w-5 h-5 text-cyan-400"></i>
                        <h2 class="text-xl font-bold text-white">انبارها</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت انبارها</p>
                </div>
                <button class="btn-emerald" onclick="showToast('فرم افزودن انبار باز می‌شود', 'info')">
                    <i data-lucide="plus" class="w-4 h-4"></i> انبار جدید
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $warehouses = [
                        ['name' => 'انبار مرکزی', 'location' => 'تهران', 'items' => 145, 'capacity' => 80],
                        ['name' => 'انبار شرق', 'location' => 'مشهد', 'items' => 67, 'capacity' => 45],
                        ['name' => 'انبار غرب', 'location' => 'تبریز', 'items' => 32, 'capacity' => 20],
                    ];
                @endphp
                @foreach($warehouses as $w)
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-4 hover:border-cyan-400/30 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-white">{{ $w['name'] }}</span>
                        <i data-lucide="warehouse" class="w-6 h-6 text-cyan-400/60"></i>
                    </div>
                    <p class="text-[#94a3b8] text-sm mt-1">{{ $w['location'] }}</p>
                    <p class="text-[#94a3b8] text-sm mt-2">تعداد اقلام: {{ $w['items'] }}</p>
                    <div class="w-full bg-[#1a2f4a] rounded-full h-2 mt-2">
                        <div class="bg-cyan-400 h-2 rounded-full" style="width: {{ $w['capacity'] }}%;"></div>
                    </div>
                    <p class="text-xs text-[#64748b] mt-1">ظرفیت: {{ $w['capacity'] }}%</p>
                    <div class="flex gap-3 mt-3">
                        <button class="text-blue-400 hover:text-blue-300 text-sm" onclick="showToast('ویرایش انبار', 'info')">
                            <i data-lucide="pencil" class="w-4 h-4 inline"></i> ویرایش
                        </button>
                        <button class="text-rose-400 hover:text-rose-300 text-sm" onclick="showToast('حذف انبار', 'error')">
                            <i data-lucide="trash-2" class="w-4 h-4 inline"></i> حذف
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Users Tab -->
        <div id="users-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="users" class="w-5 h-5 text-emerald-400"></i>
                        <h2 class="text-xl font-bold text-white">مدیریت کاربران</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت همه کاربران</p>
                </div>
                <button class="btn-emerald" onclick="showToast('فرم افزودن کاربر باز می‌شود', 'info')">
                    <i data-lucide="plus" class="w-4 h-4"></i> کاربر جدید
                </button>
            </div>
            <div class="flex flex-wrap gap-3 mb-5">
                <input type="text" placeholder="جستجوی کاربر..." class="input-dark max-w-xs" />
                <select class="filter-select"><option>همه وضعیت‌ها</option><option>فعال</option><option>غیرفعال</option></select>
                <button class="btn-blue"><i data-lucide="search" class="w-4 h-4"></i> جستجو</button>
            </div>
            <div class="table-wrap">
                <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
                    <span class="text-xs text-[#475569]">{{ isset($users) ? $users->total() : 0 }} کاربر</span>
                </div>
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>کاربر</th>
                                <th>ایمیل</th>
                                <th>شماره تماس</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users) && $users->count() > 0)
                                @foreach($users as $u)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[10px] text-blue-400 font-bold">{{ substr($u->name, 0, 1) }}</div>
                                            <span>{{ $u->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->phone ?? '—' }}</td>
                                    <td><span class="badge badge-{{ $u->status == 'active' ? 'active' : 'pending' }}">{{ $u->status == 'active' ? 'فعال' : 'غیرفعال' }}</span></td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <button class="text-blue-400 hover:text-blue-300" onclick="showToast('ویرایش کاربر', 'info')"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                            <button class="text-rose-400 hover:text-rose-300" onclick="showToast('حذف کاربر', 'error')"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5" class="text-center py-8 text-[#475569]"><i data-lucide="users" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i><p>هیچ کاربری یافت نشد</p></td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between p-4 border-t border-[#1a2f4a]">
                    <span class="text-xs text-[#475569]">نمایش {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} از {{ $users->total() ?? 0 }}</span>
                    <div class="flex gap-2">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Admins Tab -->
        <div id="admins-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="user-cog" class="w-5 h-5 text-violet-400"></i>
                        <h2 class="text-xl font-bold text-white">مدیران سیستم</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت همه مدیران</p>
                </div>
                <a href="{{ route('admin.admins.create') }}" class="btn-emerald">
                    <i data-lucide="plus" class="w-4 h-4"></i> مدیر جدید
                </a>
            </div>
            <div class="table-wrap">
                <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
                    <span class="text-xs text-[#475569]">{{ isset($admins) ? $admins->count() : 0 }} مدیر</span>
                </div>
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>مدیر</th>
                                <th>ایمیل</th>
                                <th>نقش</th>
                                <th>وضعیت</th>
                                <th>آخرین ورود</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($admins) && $admins->count() > 0)
                                @foreach($admins as $a)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[10px] text-blue-400 font-bold">{{ substr($a->name, 0, 1) }}</div>
                                            <span>{{ $a->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $a->email }}</td>
                                    <td><span class="badge badge-{{ $a->role }}">@switch($a->role) @case('super_admin') مدیر اصلی @break @case('manager') مدیر @break @case('support') پشتیبان @break @default {{ $a->role }} @endswitch</span></td>
                                    <td><span class="badge badge-{{ $a->is_active ? 'active' : 'cancelled' }}">{{ $a->is_active ? 'فعال' : 'غیرفعال' }}</span></td>
                                    <td>{{ $a->last_login ? $a->last_login->format('Y/m/d H:i') : '—' }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.admins.edit', $a->id) }}" class="text-blue-400 hover:text-blue-300"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                                            @if($a->id != Auth::guard('admin')->id())
                                                <form action="{{ route('admin.admins.destroy', $a->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این مدیر اطمینان دارید؟')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-400 hover:text-rose-300"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="6" class="text-center py-8 text-[#475569]"><i data-lucide="user-cog" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i><p>هیچ مدیری یافت نشد</p></td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reviews Tab -->
        <div id="reviews-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="star" class="w-5 h-5 text-amber-400"></i>
                        <h2 class="text-xl font-bold text-white">نظرات</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت نظرات کاربران</p>
                </div>
                <select class="filter-select"><option>همه نظرات</option><option>تایید شده</option><option>در انتظار</option></select>
            </div>
            <div class="table-wrap">
                <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
                    <span class="text-xs text-[#475569]">۴ نظر</span>
                </div>
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>کاربر</th>
                                <th>محصول</th>
                                <th>امتیاز</th>
                                <th>نظر</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $reviews = [
                                    ['user' => 'علی رضایی', 'product' => 'محصول شماره ۱', 'rating' => 5, 'comment' => 'عالی بود', 'status' => 'active'],
                                    ['user' => 'مریم حسینی', 'product' => 'محصول شماره ۲', 'rating' => 4, 'comment' => 'خوب بود', 'status' => 'pending'],
                                    ['user' => 'رضا کریمی', 'product' => 'محصول شماره ۳', 'rating' => 2, 'comment' => 'بد نبود', 'status' => 'cancelled'],
                                ];
                            @endphp
                            @foreach($reviews as $r)
                            <tr>
                                <td>{{ $r['user'] }}</td>
                                <td>{{ $r['product'] }}</td>
                                <td><div class="flex items-center gap-1"><span class="text-amber-400">{{ $r['rating'] }}</span><i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i></div></td>
                                <td class="max-w-xs truncate">{{ $r['comment'] }}</td>
                                <td><span class="badge badge-{{ $r['status'] }}">{{ $r['status'] == 'active' ? 'تایید شده' : ($r['status'] == 'pending' ? 'در انتظار' : 'رد شده') }}</span></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button class="text-emerald-400 hover:text-emerald-300" onclick="showToast('نظر تایید شد', 'success')"><i data-lucide="check" class="w-4 h-4"></i></button>
                                        <button class="text-rose-400 hover:text-rose-300" onclick="showToast('نظر رد شد', 'error')"><i data-lucide="x" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sales Tab -->
        <div id="sales-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="chart-line" class="w-5 h-5 text-emerald-400"></i>
                        <h2 class="text-xl font-bold text-white">گزارشات فروش</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">آمار و گزارشات فروش</p>
                </div>
                <div class="flex gap-2">
                    <select class="filter-select"><option>امسال</option><option>ماه جاری</option></select>
                    <button class="btn-blue" onclick="showToast('گزارش فروش دانلود شد', 'success')">
                        <i data-lucide="download" class="w-4 h-4"></i> خروجی
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                @php
                    $salesStats = [
                        ['label' => 'کل فروش', 'value' => number_format($total_sales ?? 0), 'unit' => 'تومان', 'change' => '+۱۲%', 'color' => 'blue'],
                        ['label' => 'تعداد سفارشات', 'value' => '۱۴۲', 'unit' => '', 'change' => '+۸%', 'color' => 'emerald'],
                        ['label' => 'میانگین ارزش', 'value' => '۸۷,۶۰۰', 'unit' => 'تومان', 'change' => '+۳%', 'color' => 'amber'],
                        ['label' => 'میزان بازگشت', 'value' => '۴.۲', 'unit' => '%', 'change' => '-۱%', 'color' => 'rose'],
                    ];
                @endphp
                @foreach($salesStats as $stat)
                <div class="stat-card stat-{{ $stat['color'] }}">
                    <p class="text-[#64748b] text-sm">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-extrabold text-white">{{ $stat['value'] }} <span class="text-sm text-[#64748b]">{{ $stat['unit'] }}</span></p>
                    <span class="text-xs {{ strpos($stat['change'], '+') !== false ? 'text-emerald-400' : 'text-rose-400' }}">
                        {{ $stat['change'] }} نسبت به ماه قبل
                    </span>
                </div>
                @endforeach
            </div>
            <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-3">
                    <i data-lucide="trending-up" class="w-5 h-5 text-blue-400"></i>
                    <h3 class="text-base font-bold text-white">روند فروش ماهانه</h3>
                </div>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Analytics Tab -->
        <div id="analytics-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="chart-pie" class="w-5 h-5 text-violet-400"></i>
                        <h2 class="text-xl font-bold text-white">تحلیل‌ها</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">تحلیل داده‌های سیستم</p>
                </div>
                <select class="filter-select"><option>۳۰ روز اخیر</option><option>۹۰ روز اخیر</option></select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @php
                    $analyticsStats = [
                        ['label' => 'بازدیدکنندگان', 'value' => '۱۲,۴۵۰', 'change' => '+۱۵%', 'color' => 'blue'],
                        ['label' => 'نرخ تبدیل', 'value' => '۳.۲%', 'change' => '+۰.۵%', 'color' => 'emerald'],
                        ['label' => 'زمان ماندگاری', 'value' => '۴:۳۲', 'change' => '+۱۲%', 'color' => 'amber'],
                    ];
                @endphp
                @foreach($analyticsStats as $stat)
                <div class="stat-card stat-{{ $stat['color'] }}">
                    <p class="text-[#64748b] text-sm">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-extrabold text-white mt-1">{{ $stat['value'] }}</p>
                    <span class="text-xs text-emerald-400">{{ $stat['change'] }}</span>
                </div>
                @endforeach
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="pie-chart" class="w-5 h-5 text-violet-400"></i>
                        <h3 class="text-base font-bold text-white">توزیع بازدیدکنندگان</h3>
                    </div>
                    <div class="chart-container" style="height: 260px;">
                        <canvas id="analyticsPieChart"></canvas>
                    </div>
                </div>
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="bar-chart" class="w-5 h-5 text-cyan-400"></i>
                        <h3 class="text-base font-bold text-white">آمار روزانه</h3>
                    </div>
                    <div class="chart-container" style="height: 260px;">
                        <canvas id="analyticsBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Tab -->
        <div id="slider-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="image" class="w-5 h-5 text-amber-400"></i>
                        <h2 class="text-xl font-bold text-white">مدیریت اسلایدر</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت اسلایدهای اصلی سایت</p>
                </div>
                <button class="btn-emerald" onclick="showToast('فرم افزودن اسلاید باز می‌شود', 'info')">
                    <i data-lucide="plus" class="w-4 h-4"></i> اسلاید جدید
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $slides = [
                        ['title' => 'اسلاید اصلی', 'subtitle' => 'توضیح اسلاید اصلی', 'status' => 'active'],
                        ['title' => 'اسلاید تبلیغاتی', 'subtitle' => 'توضیح تبلیغات', 'status' => 'pending'],
                        ['title' => 'اسلاید ویژه', 'subtitle' => 'توضیح ویژه', 'status' => 'active'],
                    ];
                @endphp
                @foreach($slides as $s)
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-4 hover:border-amber-400/30 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-white">{{ $s['title'] }}</span>
                        <span class="badge badge-{{ $s['status'] }}">{{ $s['status'] == 'active' ? 'فعال' : 'غیرفعال' }}</span>
                    </div>
                    <div class="bg-[#1a2f4a] h-24 rounded-lg mt-3 flex items-center justify-center">
                        <i data-lucide="image" class="w-12 h-12 text-[#475569]"></i>
                    </div>
                    <p class="text-[#64748b] text-sm mt-2">{{ $s['subtitle'] }}</p>
                    <div class="flex gap-3 mt-3">
                        <button class="text-blue-400 hover:text-blue-300 text-sm" onclick="showToast('ویرایش اسلاید', 'info')">
                            <i data-lucide="pencil" class="w-4 h-4 inline"></i> ویرایش
                        </button>
                        <button class="text-rose-400 hover:text-rose-300 text-sm" onclick="showToast('حذف اسلاید', 'error')">
                            <i data-lucide="trash-2" class="w-4 h-4 inline"></i> حذف
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
<!-- Calendar Tab -->
<div id="calendar-tab" class="tab-content">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <div class="flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-cyan-400"></i>
                <h2 class="text-xl font-bold text-white">تقویم</h2>
            </div>
            <p class="text-sm text-[#475569] mr-7">تقویم جامع رویدادها</p>
        </div>
        <a href="{{ route('admin.calendar') }}" class="btn-emerald">
            <i data-lucide="external-link" class="w-4 h-4"></i> مشاهده تقویم کامل
        </a>
    </div>
    
    <!-- Preview Calendar -->
    <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <i data-lucide="calendar-days" class="w-5 h-5 text-cyan-400"></i>
                <span class="text-sm text-[#94a3b8]">پیش‌نمایش تقویم</span>
            </div>
            <span class="text-xs text-[#475569]">مرداد ۱۴۰۵</span>
        </div>
        <div class="grid grid-cols-7 gap-2 max-w-full">
            @php
                $days = ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج'];
            @endphp
            @foreach($days as $day)
                <div class="text-center text-[#475569] text-xs font-bold py-2">{{ $day }}</div>
            @endforeach
            @php
                $events = [5, 12, 20, 25, 28];
            @endphp
            @for($i = 1; $i <= 31; $i++)
                @php
                    $isToday = ($i == 15);
                    $hasEvent = in_array($i, $events);
                @endphp
                <div class="text-center py-2 rounded-lg transition cursor-pointer {{ $isToday ? 'bg-[#1a2f4a] text-white border border-cyan-400/30' : 'text-[#94a3b8]' }} {{ $hasEvent ? 'border border-emerald-500/30' : '' }} hover:bg-[#1a2f4a] transition text-sm"
                     onclick="window.location.href='{{ route('admin.calendar') }}'">
                    {{ $i }}
                    @if($hasEvent)
                        <div class="w-1 h-1 rounded-full bg-emerald-400 mx-auto mt-1"></div>
                    @endif
                </div>
            @endfor
        </div>
        <div class="flex gap-4 mt-4 pt-4 border-t border-[#1a2f4a]">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                <span class="text-xs text-[#64748b]">رویداد</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-cyan-400/50 border border-cyan-400/30"></div>
                <span class="text-xs text-[#64748b]">امروز</span>
            </div>
            <div class="flex items-center gap-2">
                <i data-lucide="external-link" class="w-3 h-3 text-blue-400"></i>
                <span class="text-xs text-[#64748b]">کلیک برای مشاهده کامل</span>
            </div>
        </div>
    </div>
</div>
        <!-- Datatable Tab -->
        <div id="datatable-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="table" class="w-5 h-5 text-blue-400"></i>
                        <h2 class="text-xl font-bold text-white">جدول داده</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">جدول داده پیشرفته</p>
                </div>
                <button class="btn-emerald" onclick="showToast('فرم افزودن رکورد باز می‌شود', 'info')">
                    <i data-lucide="plus" class="w-4 h-4"></i> رکورد جدید
                </button>
            </div>
            <div class="table-wrap">
                <div class="flex flex-wrap justify-between items-center p-4 border-b border-[#1a2f4a] gap-3">
                    <span class="text-xs text-[#475569]">۵ رکورد</span>
                    <div class="flex flex-wrap gap-2">
                        <input type="text" placeholder="جستجو..." class="input-dark max-w-xs" />
                        <select class="filter-select"><option>۱۰</option><option>۲۵</option><option>۵۰</option></select>
                        <button class="btn-blue"><i data-lucide="search" class="w-4 h-4"></i></button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="rounded border-[#1a2f4a] bg-[#0a1628] text-blue-400" /></th>
                                <th>#</th>
                                <th>نام</th>
                                <th>ایمیل</th>
                                <th>نقش</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $data = [
                                    ['id' => 1, 'name' => 'علی رضایی', 'email' => 'ali@email.com', 'role' => 'کاربر', 'status' => 'active'],
                                    ['id' => 2, 'name' => 'مریم حسینی', 'email' => 'maryam@email.com', 'role' => 'مدیر', 'status' => 'active'],
                                    ['id' => 3, 'name' => 'رضا کریمی', 'email' => 'reza@email.com', 'role' => 'کاربر', 'status' => 'pending'],
                                ];
                            @endphp
                            @foreach($data as $d)
                            <tr>
                                <td><input type="checkbox" class="rounded border-[#1a2f4a] bg-[#0a1628] text-blue-400" /></td>
                                <td class="text-blue-400 font-mono">{{ $d['id'] }}</td>
                                <td>{{ $d['name'] }}</td>
                                <td>{{ $d['email'] }}</td>
                                <td><span class="badge badge-{{ $d['role'] == 'مدیر' ? 'active' : 'pending' }}">{{ $d['role'] }}</span></td>
                                <td><span class="badge badge-{{ $d['status'] }}">{{ $d['status'] == 'active' ? 'فعال' : 'در انتظار' }}</span></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button class="text-blue-400 hover:text-blue-300" onclick="showToast('ویرایش رکورد', 'info')"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                        <button class="text-rose-400 hover:text-rose-300" onclick="showToast('حذف رکورد', 'error')"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-wrap justify-between items-center p-4 border-t border-[#1a2f4a]">
                    <span class="text-xs text-[#475569]">نمایش ۱-۳ از ۵ رکورد</span>
                    <div class="flex gap-2">
                        <button class="btn-blue text-sm px-3 py-1">قبلی</button>
                        <button class="btn-emerald text-sm px-3 py-1">۱</button>
                        <button class="btn-blue text-sm px-3 py-1">بعدی</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Tab -->
        <div id="blog-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="newspaper" class="w-5 h-5 text-emerald-400"></i>
                        <h2 class="text-xl font-bold text-white">مدیریت بلاگ</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">مدیریت نوشته‌های بلاگ</p>
                </div>
                <button class="btn-emerald" onclick="showToast('فرم افزودن نوشته باز می‌شود', 'info')">
                    <i data-lucide="plus" class="w-4 h-4"></i> نوشته جدید
                </button>
            </div>
            <div class="flex flex-wrap gap-3 mb-5">
                <input type="text" placeholder="جستجوی نوشته..." class="input-dark max-w-xs" />
                <select class="filter-select"><option>همه دسته‌ها</option><option>اخبار</option><option>آموزش</option></select>
                <button class="btn-blue"><i data-lucide="search" class="w-4 h-4"></i> جستجو</button>
            </div>
            <div class="table-wrap">
                <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
                    <span class="text-xs text-[#475569]">۴ نوشته</span>
                </div>
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>عنوان</th>
                                <th>دسته</th>
                                <th>نویسنده</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $posts = [
                                    ['title' => 'پست اول', 'category' => 'اخبار', 'author' => 'مدیر', 'date' => '۱۴۰۵/۰۵/۲۰', 'status' => 'active'],
                                    ['title' => 'پست دوم', 'category' => 'آموزش', 'author' => 'مدیر', 'date' => '۱۴۰۵/۰۵/۱۸', 'status' => 'pending'],
                                    ['title' => 'پست سوم', 'category' => 'مقالات', 'author' => 'نویسنده', 'date' => '۱۴۰۵/۰۵/۱۵', 'status' => 'cancelled'],
                                ];
                            @endphp
                            @foreach($posts as $p)
                            <tr>
                                <td class="font-medium">{{ $p['title'] }}</td>
                                <td><span class="badge badge-{{ $p['category'] == 'اخبار' ? 'active' : 'pending' }}">{{ $p['category'] }}</span></td>
                                <td>{{ $p['author'] }}</td>
                                <td>{{ $p['date'] }}</td>
                                <td><span class="badge badge-{{ $p['status'] }}">{{ $p['status'] == 'active' ? 'منتشر شده' : ($p['status'] == 'pending' ? 'در انتظار' : 'پیش‌نویس') }}</span></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button class="text-blue-400 hover:text-blue-300" onclick="showToast('ویرایش نوشته', 'info')"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                        <button class="text-rose-400 hover:text-rose-300" onclick="showToast('حذف نوشته', 'error')"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Settings Tab -->
        <div id="settings-tab" class="tab-content">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="settings" class="w-5 h-5 text-violet-400"></i>
                        <h2 class="text-xl font-bold text-white">تنظیمات</h2>
                    </div>
                    <p class="text-sm text-[#475569] mr-7">تنظیمات عمومی سیستم</p>
                </div>
                <button class="btn-emerald" onclick="showToast('تنظیمات با موفقیت ذخیره شد', 'success')">
                    <i data-lucide="save" class="w-4 h-4"></i> ذخیره همه
                </button>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <i data-lucide="settings" class="w-5 h-5 text-blue-400"></i>
                        <h3 class="text-lg font-bold text-white">تنظیمات عمومی</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">نام سایت</label>
                            <input type="text" value="GRAFIUM" class="input-dark" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">ایمیل پشتیبانی</label>
                            <input type="email" value="info@grafium.ir" class="input-dark" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">شماره تماس</label>
                            <input type="text" value="۰۲۱-۱۲۳۴-۵۶۷۸" class="input-dark" />
                        </div>
                    </div>
                </div>
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <i data-lucide="palette" class="w-5 h-5 text-emerald-400"></i>
                        <h3 class="text-lg font-bold text-white">تنظیمات ظاهری</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">تم پیش‌فرض</label>
                            <select class="input-dark"><option>تاریک</option><option>روشن</option></select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">رنگ اصلی</label>
                            <input type="color" value="#3b82f6" class="w-full h-12 rounded-lg bg-[#0a1628] border border-[#1a2f4a] cursor-pointer" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">زبان</label>
                            <select class="input-dark"><option>فارسی</option><option>English</option></select>
                        </div>
                    </div>
                </div>
                <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5 lg:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <i data-lucide="shield" class="w-5 h-5 text-rose-400"></i>
                        <h3 class="text-lg font-bold text-white">تنظیمات امنیتی</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">رمز عبور جدید</label>
                            <input type="password" placeholder="********" class="input-dark" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">تکرار رمز عبور</label>
                            <input type="password" placeholder="********" class="input-dark" />
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" class="rounded border-[#1a2f4a] bg-[#0a1628] text-blue-400" checked />
                            <span class="text-sm text-[#94a3b8]">فعال‌سازی احراز هویت دو مرحله‌ای</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- ============================================================
    SCRIPTS
    ============================================================ -->
    <script>
        // ============================================================
        // INITIALIZE
        // ============================================================
        lucide.createIcons();

        // ============================================================
        // CHART.JS
        // ============================================================
        let salesChartInstance = null;
        let ordersChartInstance = null;
        let salesTrendChartInstance = null;
        let analyticsPieInstance = null;
        let analyticsBarInstance = null;

        function initCharts() {
            const salesCtx = document.getElementById('salesChart')?.getContext('2d');
            if (salesCtx) {
                if (salesChartInstance) salesChartInstance.destroy();
                salesChartInstance = new Chart(salesCtx, {
                    type: 'bar',
                    data: {
                        labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر'],
                        datasets: [{
                            label: 'فروش (میلیون)',
                            data: [8, 12, 18, 15, 22, 17, 25],
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { labels: { color: '#94a3b8', font: { family: 'Vazirmatn' } } } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#64748b' } },
                            x: { grid: { display: false }, ticks: { color: '#64748b' } }
                        }
                    }
                });
            }

            const ordersCtx = document.getElementById('ordersChart')?.getContext('2d');
            if (ordersCtx) {
                if (ordersChartInstance) ordersChartInstance.destroy();
                ordersChartInstance = new Chart(ordersCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['تکمیل شده', 'در انتظار', 'لغو شده'],
                        datasets: [{
                            data: [45, 30, 25],
                            backgroundColor: ['#34d399', '#fbbf24', '#fb7185'],
                            borderColor: '#0f1f33',
                            borderWidth: 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: '#94a3b8', font: { family: 'Vazirmatn', size: 11 }, padding: 12 } }
                        },
                        cutout: '65%',
                    }
                });
            }

            const trendCtx = document.getElementById('salesTrendChart')?.getContext('2d');
            if (trendCtx) {
                if (salesTrendChartInstance) salesTrendChartInstance.destroy();
                salesTrendChartInstance = new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: ['هفته ۱', 'هفته ۲', 'هفته ۳', 'هفته ۴', 'هفته ۵', 'هفته ۶', 'هفته ۷'],
                        datasets: [{
                            label: 'فروش',
                            data: [12, 19, 15, 22, 28, 24, 35],
                            borderColor: '#60a5fa',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#60a5fa',
                            pointBorderColor: '#0f1f33',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { labels: { color: '#94a3b8', font: { family: 'Vazirmatn' } } } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#64748b' } },
                            x: { grid: { display: false }, ticks: { color: '#64748b' } }
                        }
                    }
                });
            }

            const pieCtx = document.getElementById('analyticsPieChart')?.getContext('2d');
            if (pieCtx) {
                if (analyticsPieInstance) analyticsPieInstance.destroy();
                analyticsPieInstance = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: ['دسکتاپ', 'موبایل', 'تبلت'],
                        datasets: [{
                            data: [55, 35, 10],
                            backgroundColor: ['#60a5fa', '#34d399', '#fbbf24'],
                            borderColor: '#0f1f33',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: '#94a3b8', font: { family: 'Vazirmatn', size: 11 }, padding: 12 } }
                        }
                    }
                });
            }

            const barCtx = document.getElementById('analyticsBarChart')?.getContext('2d');
            if (barCtx) {
                if (analyticsBarInstance) analyticsBarInstance.destroy();
                analyticsBarInstance = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'],
                        datasets: [{
                            label: 'بازدید',
                            data: [320, 450, 380, 520, 480, 600, 410],
                            backgroundColor: 'rgba(52, 211, 153, 0.6)',
                            borderColor: '#34d399',
                            borderWidth: 1,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { labels: { color: '#94a3b8', font: { family: 'Vazirmatn' } } } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#64748b' } },
                            x: { grid: { display: false }, ticks: { color: '#64748b' } }
                        }
                    }
                });
            }
        }

        // ============================================================
        // TAB SWITCHING
        // ============================================================
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            const target = document.getElementById(tabId);
            if (target) target.classList.add('active');

            document.querySelectorAll('.menu-item').forEach(el => el.classList.remove('active'));
            const activeLink = document.querySelector(`.menu-item[data-tab="${tabId}"]`);
            if (activeLink) activeLink.classList.add('active');

            const titles = {
                'dashboard-tab': 'داشبورد',
                'products-tab': 'مدیریت محصولات',
                'categories-tab': 'دسته‌بندی‌ها',
                'orders-tab': 'سفارشات',
                'discounts-tab': 'کدهای تخفیف',
                'warehouses-tab': 'انبارها',
                'users-tab': 'کاربران',
                'admins-tab': 'مدیران',
                'reviews-tab': 'نظرات',
                'sales-tab': 'گزارشات فروش',
                'analytics-tab': 'تحلیل‌ها',
                'slider-tab': 'مدیریت اسلایدر',
                'calendar-tab': 'تقویم',
                'datatable-tab': 'جدول داده',
                'blog-tab': 'مدیریت بلاگ',
                'settings-tab': 'تنظیمات'
            };
            document.getElementById('pageTitle').textContent = titles[tabId] || 'داشبورد';
            setTimeout(initCharts, 100);
        }

        // ============================================================
        // TOAST SYSTEM
        // ============================================================
        function showToast(message, type = 'info', duration = 3000) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast-item toast-${type}`;
            
            const icons = {
                success: 'check-circle',
                error: 'alert-circle',
                warning: 'alert-triangle',
                info: 'info'
            };

            toast.innerHTML = `
                <i data-lucide="${icons[type] || 'info'}" class="w-5 h-5 flex-shrink-0"></i>
                <span class="text-sm font-medium">${message}</span>
            `;
            
            container.appendChild(toast);
            lucide.createIcons();

            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        // ============================================================
        // AI CHAT SYSTEM (با گزینه‌های بیشتر)
        // ============================================================
        let aiChatOpen = false;
        let isTyping = false;
        let aiDataDate = new Date().toLocaleDateString('fa-IR');

        const aiResponses = {
            'سلام': 'سلام! وقت بخیر. چطور می‌توانم به شما کمک کنم؟\n\nمی‌توانید از گزینه‌های زیر استفاده کنید:\n- آمار فروش امروز\n- مقایسه با دیروز\n- تعداد کاربران\n- پرفروش‌ترین محصول\n- پیش‌بینی فروش\n- تحلیل روند\n- گزارش هفتگی\n- بهترین زمان فروش',
            
            'آمار فروش امروز': 'گزارش فروش امروز\n\nفروش کل: ۱۲,۴۵۰,۰۰۰ تومان\nتعداد سفارشات: ۲۴ عدد\nمیانگین ارزش هر سفارش: ۵۱۸,۷۵۰ تومان\nنرخ تبدیل: ۳.۲٪\n\nدر مقایسه با دیروز: +۱۲٪ رشد',
            
            'مقایسه با دیروز': 'مقایسه فروش امروز با دیروز\n\nفروش امروز: ۱۲,۴۵۰,۰۰۰ تومان\nفروش دیروز: ۱۱,۱۰۰,۰۰۰ تومان\nرشد: +۱,۳۵۰,۰۰۰ تومان (+۱۲٪)\n\nسفارشات امروز: ۲۴ عدد\nسفارشات دیروز: ۲۱ عدد\nرشد سفارشات: +۳ عدد (+۱۴٪)\n\nنرخ تبدیل امروز: ۳.۲٪\نرخ تبدیل دیروز: ۲.۹٪\رشد: +۰.۳٪',
            
            'تعداد کاربران': 'تعداد کل کاربران: ۱,۲۴۵ نفر\nکاربران فعال امروز: ۸۷ نفر\nکاربران جدید امروز: ۱۲ نفر\nکاربران غیرفعال: ۳۴ نفر',
            
            'پرفروش‌ترین محصول': 'پرفروش‌ترین محصول امروز:\nمحصول شماره ۱ با ۴۵ عدد فروش\nمحصول شماره ۳ با ۳۲ عدد فروش\nمحصول شماره ۵ با ۲۸ عدد فروش\n\nمجموع فروش: ۱۰۵ عدد',
            
            'پیش‌بینی فروش': 'پیش‌بینی فروش برای هفته آینده\n\nبر اساس تحلیل داده‌ها:\n\nروز ۱: ۱۳,۲۰۰,۰۰۰ تومان\nروز ۲: ۱۴,۵۰۰,۰۰۰ تومان\nروز ۳: ۱۱,۸۰۰,۰۰۰ تومان\nروز ۴: ۱۵,۲۰۰,۰۰۰ تومان\nروز ۵: ۱۶,۷۰۰,۰۰۰ تومان\nروز ۶: ۱۲,۹۰۰,۰۰۰ تومان\nروز ۷: ۱۴,۱۰۰,۰۰۰ تومان\n\nمجموع پیش‌بینی: ۹۸,۴۰۰,۰۰۰ تومان\nرشد پیش‌بینی شده: +۱۵٪ نسبت به هفته قبل',
            
            'تحلیل روند': 'تحلیل روند فروش ۳۰ روز اخیر\n\nروند کلی: صعودی\n\nهفته اول: ۴۵,۲۰۰,۰۰۰ تومان\nهفته دوم: ۵۱,۸۰۰,۰۰۰ تومان (+۱۴.۶٪)\nهفته سوم: ۴۸,۵۰۰,۰۰۰ تومان (-۶.۴٪)\nهفته چهارم: ۵۶,۳۰۰,۰۰۰ تومان (+۱۶.۱٪)\n\nبهترین روز: جمعه (۱۰,۲۰۰,۰۰۰ تومان)\nضعیف‌ترین روز: دوشنبه (۵,۸۰۰,۰۰۰ تومان)\n\nمیانگین رشد روزانه: +۲.۳٪',
            
            'گزارش هفتگی': 'گزارش هفتگی فروش\n\nهفته: ۱۴۰۵/۰۵/۲۰ تا ۱۴۰۵/۰۵/۲۶\n\nفروش کل: ۹۸,۵۰۰,۰۰۰ تومان\nتعداد سفارشات: ۱۸۶ عدد\nمیانگین روزانه: ۱۴,۰۷۱,۰۰۰ تومان\n\nنرخ تبدیل: ۳.۱٪\بازدیدکنندگان: ۶,۰۰۰ نفر\n\nپرفروش‌ترین روز: پنجشنبه (۱۶,۲۰۰,۰۰۰ تومان)\nکم‌فروش‌ترین روز: یکشنبه (۱۱,۸۰۰,۰۰۰ تومان)\n\nرشد نسبت به هفته قبل: +۸.۵٪',
            
            'بهترین زمان فروش': 'بهترین زمان‌های فروش\n\nبر اساس تحلیل ۹۰ روز اخیر:\n\nبهترین ساعت‌ها:\n۱۰:۰۰ - ۱۲:۰۰ (۲۵٪ فروش)\n۱۶:۰۰ - ۱۸:۰۰ (۲۲٪ فروش)\n۱۲:۰۰ - ۱۴:۰۰ (۱۸٪ فروش)\n\nبهترین روزها:\nپنجشنبه (۲۲٪ فروش)\nجمعه (۱۸٪ فروش)\nچهارشنبه (۱۵٪ فروش)\n\nتوصیه: تمرکز تبلیغات در ساعت ۱۰ تا ۱۲ و روزهای پنجشنبه',
            
            'default': 'ممنون از سوال شما. در حال بررسی اطلاعات هستم...\n\nبرای اطلاعات دقیق‌تر، لطفاً سوال خود را واضح‌تر مطرح کنید یا از گزینه‌های سریع استفاده کنید.'
        };

        function toggleAIChat() {
            aiChatOpen = !aiChatOpen;
            const modal = document.getElementById('aiChatModal');
            const floatBtn = document.getElementById('aiFloatBtn');
            
            if (aiChatOpen) {
                modal.classList.add('active');
                floatBtn.style.display = 'none';
                document.getElementById('aiDataDate').textContent = aiDataDate;
                setTimeout(() => document.getElementById('aiChatInput').focus(), 300);
            } else {
                modal.classList.remove('active');
                floatBtn.style.display = 'flex';
            }
            lucide.createIcons();
        }

        function sendAIMessage() {
            const input = document.getElementById('aiChatInput');
            const message = input.value.trim();
            if (!message || isTyping) return;

            addMessage('user', message);
            input.value = '';
            input.disabled = true;

            isTyping = true;
            const typingMsg = addMessage('ai', '', true);
            
            setTimeout(() => {
                const response = getAIResponse(message);
                typingMsg.querySelector('.bubble').textContent = response;
                const cursor = typingMsg.querySelector('.typing-cursor');
                if (cursor) cursor.remove();
                isTyping = false;
                input.disabled = false;
                input.focus();
                scrollToBottom();
            }, 500 + Math.random() * 1000);
        }

        function sendQuickReply(text) {
            document.getElementById('aiChatInput').value = text;
            sendAIMessage();
        }

        function getAIResponse(message) {
            const lowerMsg = message.toLowerCase().trim();
            
            for (const [key, value] of Object.entries(aiResponses)) {
                if (lowerMsg === key.toLowerCase()) {
                    return value;
                }
            }

            if (lowerMsg.includes('فروش') || lowerMsg.includes('درآمد')) {
                return aiResponses['آمار فروش امروز'];
            }
            if (lowerMsg.includes('کاربر') || lowerMsg.includes('عضو')) {
                return aiResponses['تعداد کاربران'];
            }
            if (lowerMsg.includes('محصول') || lowerMsg.includes('پرفروش')) {
                return aiResponses['پرفروش‌ترین محصول'];
            }
            if (lowerMsg.includes('سلام') || lowerMsg.includes('درود')) {
                return aiResponses['سلام'];
            }
            if (lowerMsg.includes('خداحافظ') || lowerMsg.includes('بای')) {
                return 'خداحافظ! روز خوبی داشته باشید. هر وقت نیاز داشتید در خدمت شما هستم.';
            }
            if (lowerMsg.includes('ممنون') || lowerMsg.includes('تشکر')) {
                return 'خواهش می‌کنم! هر وقت نیاز داشتید در خدمت شما هستم.';
            }

            return aiResponses['default'];
        }

        function addMessage(type, content, isTyping = false) {
            const container = document.getElementById('aiChatMessages');
            const div = document.createElement('div');
            div.className = `message ${type}`;
            
            const avatarIcon = type === 'ai' ? 'bot' : 'user';
            const avatarClass = type === 'ai' ? 'ai' : 'user';
            
            div.innerHTML = `
                <div class="avatar ${avatarClass}">
                    <i data-lucide="${avatarIcon}" class="w-5 h-5"></i>
                </div>
                <div class="bubble">
                    ${content}
                    ${isTyping ? '<span class="typing-cursor"></span>' : ''}
                </div>
            `;
            
            container.appendChild(div);
            lucide.createIcons();
            scrollToBottom();
            return div;
        }

        function scrollToBottom() {
            const container = document.getElementById('aiChatMessages');
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 50);
        }

        function updateAIData() {
            const now = new Date();
            aiDataDate = now.toLocaleDateString('fa-IR');
            document.getElementById('aiDataDate').textContent = aiDataDate;
            addMessage('ai', 'اطلاعات به‌روزرسانی شد.\n\nآخرین به‌روزرسانی: ' + now.toLocaleTimeString('fa-IR'));
            showToast('اطلاعات با موفقیت به‌روزرسانی شد', 'success');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && aiChatOpen) {
                toggleAIChat();
            }
        });

        document.getElementById('aiChatModal').addEventListener('click', function(e) {
            if (e.target === this && aiChatOpen) {
                toggleAIChat();
            }
        });

        // ============================================================
        // INIT
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('dashboard-tab');
            setTimeout(initCharts, 300);
            document.getElementById('aiDataDate').textContent = aiDataDate;
        });
    </script>

</body>
</html>