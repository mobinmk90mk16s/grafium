@extends('admin.layouts.admin')

@section('title', 'داشبورد مدیریت | GRAFIUM')

@section('content')
<style>
    /* ============================================================
    WELCOME BANNER
    ============================================================ */
    .welcome-banner {
        background: linear-gradient(135deg, #0a1628, #1a2f4a);
        border-radius: 20px;
        padding: 32px;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        border: 1px solid #1a2f4a;
        animation: bannerFadeIn 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes bannerFadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%; right: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(212, 163, 115, 0.15), transparent 60%);
        border-radius: 50%;
        animation: bannerGlow 10s ease-in-out infinite alternate;
    }
    @keyframes bannerGlow {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(1.2); opacity: 1; }
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(212, 163, 115, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(212, 163, 115, 0.03) 1px, transparent 1px);
        background-size: 40px 40px;
        mask-image: radial-gradient(ellipse at 70% 50%, black 20%, transparent 70%);
        pointer-events: none;
    }
    .welcome-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }
    .welcome-content {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
        min-width: 280px;
    }
    .welcome-avatar {
        width: 64px;
        height: 64px;
        border-radius: 20px;
        background: linear-gradient(135deg, #d4a373, #b8874a);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: #fff;
        box-shadow: 0 12px 30px rgba(212, 163, 115, 0.4);
        flex-shrink: 0;
        border: 3px solid rgba(255, 255, 255, 0.15);
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .welcome-banner:hover .welcome-avatar {
        transform: scale(1.08) rotate(-6deg);
    }
    .welcome-text h2 {
        font-size: 24px;
        font-weight: 900;
        color: #fff;
        margin-bottom: 6px;
        line-height: 1.3;
    }
    .welcome-text h2 .gold-line {
        background: linear-gradient(135deg, #d4a373, #f0d5b0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .welcome-text p {
        font-size: 14px;
        color: #94a3b8;
        margin-bottom: 8px;
    }
    .welcome-meta {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        font-size: 12px;
        color: #64748b;
    }
    .welcome-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .welcome-meta i {
        width: 14px;
        height: 14px;
        color: #d4a373;
    }
    .welcome-date {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 22px;
        background: rgba(212, 163, 115, 0.15);
        border: 1px solid rgba(212, 163, 115, 0.35);
        backdrop-filter: blur(10px);
        border-radius: 60px;
        color: #f0d5b0;
        font-size: 13px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .welcome-date i {
        width: 16px;
        height: 16px;
        color: #d4a373;
    }

    /* ============================================================
    STATS CARDS - باکس‌های یکسان در هر ردیف
    ============================================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 18px;
        padding: 22px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        min-height: 140px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        animation: cardSlideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    }
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.2s; }
    .stat-card:nth-child(5) { animation-delay: 0.25s; }
    .stat-card:nth-child(6) { animation-delay: 0.3s; }
    .stat-card:nth-child(7) { animation-delay: 0.35s; }
    .stat-card:nth-child(8) { animation-delay: 0.4s; }
    @keyframes cardSlideIn {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 100px; height: 100px;
        background: radial-gradient(circle, var(--accent, #60a5fa) 0%, transparent 70%);
        opacity: 0.08;
        transition: transform 0.6s, opacity 0.4s;
        pointer-events: none;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 4px; height: 40px;
        background: var(--accent, #60a5fa);
        border-radius: 0 0 0 4px;
        opacity: 0.6;
        transition: all 0.4s;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        border-color: var(--accent, #60a5fa);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.35);
    }
    .stat-card:hover::before { transform: scale(1.6); opacity: 0.15; }
    .stat-card:hover::after { height: 100%; opacity: 1; }

    .stat-card.blue { --accent: #60a5fa; }
    .stat-card.emerald { --accent: #34d399; }
    .stat-card.amber { --accent: #fbbf24; }
    .stat-card.rose { --accent: #fb7185; }
    .stat-card.violet { --accent: #a78bfa; }
    .stat-card.cyan { --accent: #22d3ee; }
    .stat-card.gold { --accent: #d4a373; }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        position: relative;
        z-index: 1;
        gap: 12px;
    }
    .stat-num {
        font-size: 26px;
        font-weight: 900;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
        transition: all 0.4s;
        word-break: break-word;
    }
    .stat-card:hover .stat-num {
        color: var(--accent, #fff);
        transform: scale(1.05);
        transform-origin: right;
    }
    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--accent, #94a3b8);
        display: flex;
        align-items: center;
        gap: 6px;
        opacity: 0.9;
    }
    .stat-label i {
        width: 12px;
        height: 12px;
    }
    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: color-mix(in srgb, var(--accent, #60a5fa) 15%, transparent);
        color: var(--accent, #60a5fa);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 1px solid color-mix(in srgb, var(--accent, #60a5fa) 25%, transparent);
    }
    .stat-icon i {
        width: 20px;
        height: 20px;
    }
    .stat-card:hover .stat-icon {
        transform: scale(1.12) rotate(-10deg);
        background: var(--accent, #60a5fa);
        color: #fff;
        box-shadow: 0 10px 25px color-mix(in srgb, var(--accent, #60a5fa) 40%, transparent);
    }

    /* ============================================================
    MAIN GRID
    ============================================================ */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
        margin-bottom: 24px;
    }

    /* ============================================================
    RECENT RESERVATIONS
    ============================================================ */
    .recent-card {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 18px;
        padding: 24px;
        animation: cardSlideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s backwards;
        overflow: hidden;
    }
    .recent-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .recent-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .recent-header-left i {
        width: 20px;
        height: 20px;
        color: #60a5fa;
    }
    .recent-header-left h3 {
        font-size: 15px;
        font-weight: 800;
        color: #fff;
    }
    .recent-header-right {
        font-size: 12px;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        background: rgba(96, 165, 250, 0.08);
        border: 1px solid rgba(96, 165, 250, 0.15);
        border-radius: 20px;
    }
    .recent-header-right i {
        width: 12px;
        height: 12px;
        color: #60a5fa;
    }

    .recent-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .recent-table thead tr th {
        padding: 12px 14px;
        text-align: right;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #1a2f4a;
    }

    .recent-table tbody tr {
        transition: all 0.3s;
        border-bottom: 1px solid #132238;
    }
    .recent-table tbody tr:last-child { border-bottom: none; }
    .recent-table tbody tr:hover {
        background: rgba(96, 165, 250, 0.05);
        transform: translateX(-4px);
    }
    .recent-table tbody td {
        padding: 14px;
        color: #cbd5e1;
        text-align: right;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .user-avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .user-name-sm {
        font-weight: 700;
        color: #e2e8f0;
        font-size: 13px;
    }

    .status-badge-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .status-active {
        background: rgba(52, 211, 153, 0.15);
        color: #34d399;
        border: 1px solid rgba(52, 211, 153, 0.25);
    }
    .status-pending {
        background: rgba(251, 191, 36, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.25);
    }
    .status-cancelled {
        background: rgba(244, 63, 94, 0.15);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.25);
    }
    .status-completed {
        background: rgba(167, 139, 250, 0.15);
        color: #a78bfa;
        border: 1px solid rgba(167, 139, 250, 0.25);
    }
    .status-expired {
        background: rgba(148, 163, 184, 0.15);
        color: #94a3b8;
        border: 1px solid rgba(148, 163, 184, 0.25);
    }

    .empty-row td {
        text-align: center;
        padding: 40px 20px !important;
        color: #64748b;
    }
    .empty-row i {
        width: 40px;
        height: 40px;
        color: #334155;
        margin: 0 auto 12px;
        display: block;
    }

    /* ============================================================
    QUICK ACTIONS
    ============================================================ */
    .quick-card {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 18px;
        padding: 24px;
        animation: cardSlideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s backwards;
    }
    .quick-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
    }
    .quick-header i {
        width: 20px;
        height: 20px;
        color: #d4a373;
    }
    .quick-header h3 {
        font-size: 15px;
        font-weight: 800;
        color: #fff;
    }
    .quick-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .quick-item {
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 14px;
        padding: 16px 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    .quick-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--item-color, #60a5fa);
        opacity: 0;
        transition: opacity 0.4s;
    }
    .quick-item:hover::before { opacity: 0.08; }
    .quick-item:hover {
        transform: translateY(-4px);
        border-color: var(--item-color, #60a5fa);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    .quick-item > * { position: relative; z-index: 1; }
    .quick-item i {
        width: 22px;
        height: 22px;
        color: var(--item-color, #60a5fa);
        transition: transform 0.4s;
    }
    .quick-item:hover i {
        transform: scale(1.15) rotate(-8deg);
    }
    .quick-item span {
        font-size: 12px;
        font-weight: 700;
        color: #cbd5e1;
    }
    .quick-item.blue { --item-color: #60a5fa; }
    .quick-item.emerald { --item-color: #34d399; }
    .quick-item.violet { --item-color: #a78bfa; }
    .quick-item.amber { --item-color: #fbbf24; }
    .quick-item.rose { --item-color: #fb7185; }
    .quick-item.cyan { --item-color: #22d3ee; }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(3, 1fr); }
        .main-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .welcome-inner { flex-direction: column; align-items: flex-start; }
        .welcome-date { width: 100%; justify-content: center; }
        .welcome-text h2 { font-size: 19px; }
        .welcome-avatar { width: 54px; height: 54px; font-size: 22px; }
        .recent-table { font-size: 11px; }
        .recent-table thead tr th { padding: 10px 8px; }
        .recent-table tbody td { padding: 10px 8px; }
        .user-avatar-sm { width: 28px; height: 28px; font-size: 11px; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .quick-grid { grid-template-columns: 1fr; }
        .recent-table thead tr th:nth-child(4),
        .recent-table tbody tr td:nth-child(4) { display: none; }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="layout-dashboard" class="w-6 h-6 text-blue-400"></i>
            <h1 class="text-2xl font-extrabold text-white">داشبورد</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">نمای کلی از وضعیت سیستم</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
        <div class="w-9 h-9 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[#60a5fa]">
            <i data-lucide="user-circle" class="w-5 h-5"></i>
        </div>
    </div>
</div>

<!-- ===== WELCOME BANNER ===== -->
<div class="welcome-banner">
    <div class="welcome-inner">
        <div class="welcome-content">
            <div class="welcome-avatar">
                <i data-lucide="shield-check"></i>
            </div>
            <div class="welcome-text">
                <h2>
                    خوش آمدید،
                    <span class="gold-line">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
                    👋
                </h2>
                <p>به پنل مدیریت GRAFIUM خوش آمدید</p>
                <div class="welcome-meta">
                    <span>
                        <i data-lucide="clock"></i>
                        آخرین ورود:
                        {{ Auth::guard('admin')->user()->last_login 
                            ? \Carbon\Carbon::parse(Auth::guard('admin')->user()->last_login)->diffForHumans() 
                            : 'اولین ورود' }}
                    </span>
                    <span>
                        <i data-lucide="user-check"></i>
                        نقش: 
                        @php
                            $roles = [
                                'super_admin' => 'مدیر ارشد',
                                'manager' => 'مدیر',
                                'support' => 'پشتیبان',
                            ];
                            echo $roles[Auth::guard('admin')->user()->role ?? 'manager'] ?? 'مدیر';
                        @endphp
                    </span>
                </div>
            </div>
        </div>
        <div class="welcome-date">
            <i data-lucide="calendar"></i>
            <span>{{ now()->translatedFormat('l، j F Y') }}</span>
        </div>
    </div>
</div>

<!-- ===== STATS CARDS (ردیف اول - 4 باکس) ===== -->
<div class="stats-grid">
    <!-- کاربران -->
    <div class="stat-card blue">
        <div class="stat-top">
            <div>
                <div class="stat-num">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="stat-label">
                    <i data-lucide="users"></i>
                    کاربران
                </div>
            </div>
            <div class="stat-icon">
                <i data-lucide="users"></i>
            </div>
        </div>
    </div>

    <!-- مدیران -->
    <div class="stat-card violet">
        <div class="stat-top">
            <div>
                <div class="stat-num">{{ $stats['total_admins'] ?? 0 }}</div>
                <div class="stat-label">
                    <i data-lucide="user-cog"></i>
                    مدیران
                </div>
            </div>
            <div class="stat-icon">
                <i data-lucide="user-cog"></i>
            </div>
        </div>
    </div>

    <!-- رزروها -->
    <div class="stat-card amber">
        <div class="stat-top">
            <div>
                <div class="stat-num">{{ $stats['total_reservations'] ?? 0 }}</div>
                <div class="stat-label">
                    <i data-lucide="calendar-check"></i>
                    کل رزروها
                </div>
            </div>
            <div class="stat-icon">
                <i data-lucide="calendar-check"></i>
            </div>
        </div>
    </div>

    <!-- فاکتورها -->
    <div class="stat-card rose">
        <div class="stat-top">
            <div>
                <div class="stat-num">{{ $stats['total_invoices'] ?? 0 }}</div>
                <div class="stat-label">
                    <i data-lucide="file-text"></i>
                    فاکتورها
                </div>
            </div>
            <div class="stat-icon">
                <i data-lucide="file-text"></i>
            </div>
        </div>
    </div>
</div>

<!-- ===== STATS CARDS (ردیف دوم - 4 باکس) ===== -->
<div class="stats-grid">
    <!-- رزرو فعال -->
    <div class="stat-card emerald">
        <div class="stat-top">
            <div>
                <div class="stat-num">{{ $stats['active_reservations'] ?? 0 }}</div>
                <div class="stat-label">
                    <i data-lucide="check-circle"></i>
                    رزرو فعال
                </div>
            </div>
            <div class="stat-icon">
                <i data-lucide="check-circle"></i>
            </div>
        </div>
    </div>

    <!-- در انتظار -->
    <div class="stat-card amber">
        <div class="stat-top">
            <div>
                <div class="stat-num">{{ $stats['pending_reservations'] ?? 0 }}</div>
                <div class="stat-label">
                    <i data-lucide="clock"></i>
                    در انتظار
                </div>
            </div>
            <div class="stat-icon">
                <i data-lucide="clock"></i>
            </div>
        </div>
    </div>

    <!-- پرداخت شده -->
    <div class="stat-card cyan">
        <div class="stat-top">
            <div>
                <div class="stat-num">{{ $stats['paid_invoices'] ?? 0 }}</div>
                <div class="stat-label">
                    <i data-lucide="credit-card"></i>
                    پرداخت شده
                </div>
            </div>
            <div class="stat-icon">
                <i data-lucide="credit-card"></i>
            </div>
        </div>
    </div>

    <!-- درآمد کل -->
    <div class="stat-card gold">
        <div class="stat-top">
            <div>
                <div class="stat-num">{{ number_format($stats['total_income'] ?? 0) }}</div>
                <div class="stat-label">
                    <i data-lucide="wallet"></i>
                    درآمد (تومان)
                </div>
            </div>
            <div class="stat-icon">
                <i data-lucide="wallet"></i>
            </div>
        </div>
    </div>
</div>

<!-- ===== MAIN GRID ===== -->
<div class="main-grid">

    <!-- ===== RECENT RESERVATIONS ===== -->
    <div class="recent-card">
        <div class="recent-header">
            <div class="recent-header-left">
                <i data-lucide="clock"></i>
                <h3>آخرین رزروها</h3>
            </div>
            <span class="recent-header-right">
                <i data-lucide="activity"></i>
                {{ $recentReservations->count() }} رزرو
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>کاربر</th>
                        <th>خدمت</th>
                        <th>تاریخ</th>
                        <th>شیفت</th>
                        <th>وضعیت</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReservations as $res)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar-sm">
                                        {{ mb_substr($res->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div class="user-name-sm">{{ $res->user->name ?? 'نامشخص' }}</div>
                                </div>
                            </td>
                            <td>
                                @if($res->service)
                                    {{ $res->service->title }}
                                @elseif($res->desk)
                                    میز {{ $res->desk->desk_number }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                {{ $res->reservation_date 
                                    ? \Carbon\Carbon::parse($res->reservation_date)->format('Y/m/d') 
                                    : ($res->created_at ? $res->created_at->format('Y/m/d') : '—') }}
                            </td>
                            <td>{{ $res->shift_persian ?? '—' }}</td>
                            <td>
                                @php
                                    $statusClass = 'status-pending';
                                    $statusText = $res->status;
                                    switch($res->status) {
                                        case 'active':
                                            $statusClass = 'status-active';
                                            $statusText = 'فعال';
                                            break;
                                        case 'pending':
                                            $statusClass = 'status-pending';
                                            $statusText = 'در انتظار';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'status-cancelled';
                                            $statusText = 'لغو شده';
                                            break;
                                        case 'completed':
                                            $statusClass = 'status-completed';
                                            $statusText = 'تکمیل شده';
                                            break;
                                        case 'expired':
                                            $statusClass = 'status-expired';
                                            $statusText = 'منقضی';
                                            break;
                                    }
                                @endphp
                                <span class="status-badge-sm {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="5">
                                <i data-lucide="calendar-off"></i>
                                <p>هیچ رزروی یافت نشد</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== QUICK ACTIONS ===== -->
    <div class="quick-card">
        <div class="quick-header">
            <i data-lucide="zap"></i>
            <h3>دسترسی سریع</h3>
        </div>
        <div class="quick-grid">
            <a href="{{ route('admin.services.index') }}" class="quick-item blue">
                <i data-lucide="settings"></i>
                <span>خدمات</span>
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="quick-item emerald">
                <i data-lucide="calendar-check"></i>
                <span>رزروها</span>
            </a>
            <a href="{{ route('admin.admins.index') }}" class="quick-item violet">
                <i data-lucide="user-cog"></i>
                <span>مدیران</span>
            </a>
            <a href="{{ route('admin.calendar') }}" class="quick-item amber">
                <i data-lucide="calendar"></i>
                <span>تقویم</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="quick-item cyan">
                <i data-lucide="users"></i>
                <span>کاربران</span>
            </a>
            <a href="{{ route('admin.blog.index') }}" class="quick-item rose">
                <i data-lucide="book-open"></i>
                <span>بلاگ</span>
            </a>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection