@extends('admin.layouts.admin')

@section('title', 'مدیریت رزروها | GRAFIUM')

@section('content')
<style>
    /* ===== STATS BANNER ===== */
    .stats-banner {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }
    .stat-box {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-decoration: none;
    }
    .stat-box::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 80px; height: 80px;
        background: radial-gradient(circle, var(--accent), transparent 70%);
        opacity: 0.08;
        transition: transform 0.5s;
    }
    .stat-box:hover {
        transform: translateY(-4px);
        border-color: var(--accent);
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }
    .stat-box:hover::before { transform: scale(1.4); opacity: 0.15; }
    .stat-box.all { --accent: #60a5fa; }
    .stat-box.pending { --accent: #fbbf24; }
    .stat-box.paid { --accent: #34d399; }
    .stat-box.cancelled { --accent: #fb7185; }
    .stat-box.income { --accent: #f59e0b; }

    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: color-mix(in srgb, var(--accent) 15%, transparent);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .stat-info { flex: 1; min-width: 0; }
    .stat-num {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
    }
    .stat-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        padding: 16px 20px;
        background: #0a1628;
        border-radius: 12px;
        border: 1px solid #1a2f4a;
        margin-bottom: 20px;
    }
    .filter-bar input,
    .filter-bar select {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 10px;
        padding: 10px 14px;
        color: #e2e8f0;
        font-size: 13px;
        font-family: 'Vazirmatn', sans-serif;
        min-width: 160px;
    }
    .filter-bar input:focus,
    .filter-bar select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .filter-bar select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: left 12px center;
        padding-right: 36px;
        cursor: pointer;
    }
    .filter-bar select option { background: #0a1628; color: #e2e8f0; }

    .btn-blue {
        background: #1a2f4a;
        color: #60a5fa;
        border: 1px solid #2a4a6a;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Vazirmatn', sans-serif;
        text-decoration: none;
    }
    .btn-blue:hover { background: #2a4a6a; }

    .btn-rose {
        background: rgba(244, 63, 94, 0.08);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.2);
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Vazirmatn', sans-serif;
        text-decoration: none;
    }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    /* ===== TABLE ===== */
    .table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #1a2f4a;
        background: #0f1f33;
    }
    .table-wrap table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .table-wrap thead {
        background: #0a1628;
        border-bottom: 1px solid #1a2f4a;
    }
    .table-wrap thead th {
        padding: 14px 16px;
        text-align: right;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        white-space: nowrap;
    }
    .table-wrap tbody td {
        padding: 16px;
        border-bottom: 1px solid #132238;
        color: #cbd5e1;
        vertical-align: middle;
        text-align: right;
    }
    .table-wrap tbody tr {
        transition: background 0.15s;
        cursor: pointer;
    }
    .table-wrap tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }
    .table-wrap tbody tr:last-child td { border-bottom: none; }

    /* User cell */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .user-info { min-width: 0; }
    .user-name {
        font-weight: 700;
        color: #fff;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .user-phone {
        font-size: 11px;
        color: #64748b;
        direction: ltr;
        text-align: right;
        font-family: monospace;
    }

    .service-name {
        font-weight: 700;
        color: #e2e8f0;
        font-size: 13px;
    }
    .service-items {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
    }

    .amount-cell {
        font-weight: 800;
        color: #34d399;
        font-size: 14px;
        white-space: nowrap;
    }
    .amount-cell.empty { color: #475569; }

    .badge {
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }
    .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); }
    .badge-paid { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.3); }
    .badge-cancelled { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.3); }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: #60a5fa;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        font-size: 13px;
    }
    .action-btn:hover {
        background: #3b82f6;
        color: #fff;
        transform: scale(1.05);
    }

    .pagination-wrap {
        padding: 16px 20px;
        background: #0a1628;
        border-radius: 12px;
        border: 1px solid #1a2f4a;
        margin-top: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pagination-wrap .info { color: #64748b; font-size: 13px; }

    /* ============================================================
    MODAL
    ============================================================ */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(4, 10, 20, 0.85);
        backdrop-filter: blur(12px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        padding: 20px;
    }
    .modal-overlay.active { display: flex; opacity: 1; }
    .modal-box {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 22px;
        max-width: 720px;
        width: 100%;
        max-height: 90vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transform: scale(0.9);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 40px 100px rgba(0,0,0,0.6);
    }
    .modal-overlay.active .modal-box { transform: scale(1); }

    .modal-header {
        background: linear-gradient(135deg, #0a1628, #1a2f4a);
        padding: 22px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #1a2f4a;
        flex-shrink: 0;
    }
    .modal-header h3 {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .modal-header h3 i { color: #60a5fa; }
    .modal-close {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .modal-close:hover {
        background: rgba(244, 63, 94, 0.2);
        color: #fb7185;
        border-color: #fb7185;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 24px 28px;
        overflow-y: auto;
        flex: 1;
    }

    .modal-section { margin-bottom: 24px; }
    .modal-section-title {
        font-size: 12px;
        font-weight: 800;
        color: #60a5fa;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .modal-section-title i { font-size: 14px; }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 10px;
        margin-bottom: 8px;
        font-size: 13px;
    }
    .info-row .label { color: #94a3b8; }
    .info-row .value { font-weight: 700; color: #e2e8f0; }
    .info-row .value.ltr { direction: ltr; font-family: monospace; }

    .user-block {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px;
        background: linear-gradient(135deg, rgba(59,130,246,0.08), rgba(59,130,246,0.02));
        border: 1px solid rgba(59,130,246,0.2);
        border-radius: 14px;
        margin-bottom: 8px;
    }
    .user-block-avatar {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(59,130,246,0.3);
    }
    .user-block-info h4 {
        font-size: 16px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 4px;
    }
    .user-block-info p {
        font-size: 12px;
        color: #64748b;
        direction: ltr;
        text-align: right;
        font-family: monospace;
    }

    .item-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 12px;
        margin-bottom: 8px;
    }
    .item-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .item-info { flex: 1; min-width: 0; }
    .item-service {
        font-size: 11px;
        color: #60a5fa;
        font-weight: 700;
        margin-bottom: 3px;
    }
    .item-title {
        font-size: 13px;
        font-weight: 700;
        color: #e2e8f0;
        margin-bottom: 3px;
    }
    .item-time {
        font-size: 11px;
        color: #64748b;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .item-time i { color: #475569; font-size: 10px; margin-left: 3px; }
    .item-price {
        font-size: 13px;
        font-weight: 800;
        color: #34d399;
        white-space: nowrap;
    }

    .status-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 8px;
        margin-top: 12px;
    }
    .status-btn {
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Vazirmatn', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .status-btn.paid {
        background: rgba(52, 211, 153, 0.08);
        color: #34d399;
        border-color: rgba(52, 211, 153, 0.3);
    }
    .status-btn.paid:hover { background: #34d399; color: #fff; }
    .status-btn.pending {
        background: rgba(251, 191, 36, 0.08);
        color: #fbbf24;
        border-color: rgba(251, 191, 36, 0.3);
    }
    .status-btn.pending:hover { background: #fbbf24; color: #fff; }
    .status-btn.cancel {
        background: rgba(244, 63, 94, 0.08);
        color: #fb7185;
        border-color: rgba(244, 63, 94, 0.3);
    }
    .status-btn.cancel:hover { background: #f43f5e; color: #fff; }
    .status-btn.delete {
        background: rgba(100, 116, 139, 0.1);
        color: #94a3b8;
        border-color: rgba(100, 116, 139, 0.3);
    }
    .status-btn.delete:hover { background: #475569; color: #fff; }

    .total-box {
        padding: 20px 24px;
        background: linear-gradient(135deg, rgba(52, 211, 153, 0.1), rgba(52, 211, 153, 0.02));
        border: 2px solid rgba(52, 211, 153, 0.3);
        border-radius: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
    }
    .total-box .label { color: #94a3b8; font-size: 13px; font-weight: 700; }
    .total-box .value { color: #34d399; font-size: 22px; font-weight: 900; }

    .modal-loading {
        padding: 60px 20px;
        text-align: center;
        color: #94a3b8;
    }
    .modal-spinner {
        width: 44px; height: 44px;
        border-radius: 50%;
        border: 3px solid rgba(59, 130, 246, 0.15);
        border-top-color: #60a5fa;
        animation: spin 0.8s linear infinite;
        margin: 0 auto 16px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .empty-state {
        text-align: center;
        padding: 70px 20px;
        color: #64748b;
    }
    .empty-state i {
        font-size: 56px;
        color: #334155;
        margin-bottom: 16px;
    }
    .empty-state h3 {
        font-size: 18px;
        color: #94a3b8;
        margin-bottom: 6px;
    }
    .empty-state p { font-size: 13px; }

    .toast-container {
        position: fixed;
        bottom: 24px;
        left: 24px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .toast-item {
        padding: 14px 20px;
        border-radius: 12px;
        min-width: 280px;
        backdrop-filter: blur(8px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        animation: slideIn 0.4s ease forwards;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(255,255,255,0.08);
        font-size: 13px;
        font-weight: 600;
    }
    .toast-success { background: rgba(52, 211, 153, 0.15); color: #34d399; }
    .toast-error { background: rgba(244, 63, 94, 0.15); color: #fb7185; }
    .toast-info { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-60px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .toast-item.hiding { animation: slideOut 0.3s ease forwards; }
    @keyframes slideOut {
        to { opacity: 0; transform: translateX(-60px); }
    }

    @media (max-width: 768px) {
        .stats-banner { grid-template-columns: repeat(2, 1fr); }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-bar input, .filter-bar select { width: 100%; }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 10px 8px; }
        .modal-body { padding: 18px; }
        .modal-header { padding: 18px; }
        .user-block { flex-direction: column; text-align: center; }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="calendar-check" class="w-6 h-6 text-cyan-400"></i>
            <h1 class="text-2xl font-extrabold text-white">مدیریت رزروها</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت رزروهای پرداخت‌شده و در انتظار</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
        <div class="w-9 h-9 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[#60a5fa]">
            <i data-lucide="user-circle" class="w-5 h-5"></i>
        </div>
    </div>
</div>

@if(session('success'))
    <div style="padding:12px 16px;border-radius:10px;margin-bottom:16px;background:rgba(52,211,153,0.12);border:1px solid rgba(52,211,153,0.2);color:#34d399;display:flex;align-items:center;gap:10px;font-size:14px;">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        {{ session('success') }}
    </div>
@endif

<!-- ===== STATS BANNER ===== -->
<div class="stats-banner">
    <a href="{{ route('admin.reservations.index') }}" class="stat-box all">
        <div class="stat-icon"><i data-lucide="layers" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ $stats['total'] }}</div>
            <div class="stat-label">کل رزروها</div>
        </div>
    </a>
    <a href="{{ route('admin.reservations.index', ['status' => 'pending']) }}" class="stat-box pending">
        <div class="stat-icon"><i data-lucide="clock" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ $stats['pending'] }}</div>
            <div class="stat-label">در انتظار پرداخت</div>
        </div>
    </a>
    <a href="{{ route('admin.reservations.index', ['status' => 'paid']) }}" class="stat-box paid">
        <div class="stat-icon"><i data-lucide="badge-check" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ $stats['paid'] }}</div>
            <div class="stat-label">پرداخت شده</div>
        </div>
    </a>
    <a href="{{ route('admin.reservations.index', ['status' => 'cancelled']) }}" class="stat-box cancelled">
        <div class="stat-icon"><i data-lucide="x-circle" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ $stats['cancelled'] }}</div>
            <div class="stat-label">لغو شده</div>
        </div>
    </a>
    <div class="stat-box income">
        <div class="stat-icon"><i data-lucide="wallet" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ number_format($stats['total_income']) }}</div>
            <div class="stat-label">درآمد کل (تومان)</div>
        </div>
    </div>
</div>

<!-- ===== FILTER BAR ===== -->
<form method="GET" action="{{ route('admin.reservations.index') }}" class="filter-bar">
    <input type="text" name="search" placeholder="جستجو: نام، شماره، ایمیل..." value="{{ request('search') }}" />

    <select name="status">
        <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>همه وضعیت‌ها</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>
        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>پرداخت شده</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
    </select>

    <button type="submit" class="btn-blue">
        <i data-lucide="search" class="w-4 h-4"></i> جستجو
    </button>

    <a href="{{ route('admin.reservations.index') }}" class="btn-rose">
        <i data-lucide="refresh-cw" class="w-4 h-4"></i> بازنشانی
    </a>
</form>

<!-- ===== TABLE ===== -->
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th style="width:60px;">#</th>
                <th>کاربر</th>
                <th>خدمت</th>
                <th>تاریخ ثبت</th>
                <th>مبلغ</th>
                <th>وضعیت</th>
                <th style="width:80px;">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                @php
                    $firstItem = $booking->items->first();
                    $serviceTitle = $firstItem?->scheduling?->serviceItem?->service?->title ?? '—';
                    $itemsCount = $booking->items->count();

                    $badgeClass = match($booking->status) {
                        'pending' => 'badge-pending',
                        'paid' => 'badge-paid',
                        'cancelled' => 'badge-cancelled',
                        default => 'badge-pending',
                    };
                    $badgeLabel = match($booking->status) {
                        'pending' => 'در انتظار پرداخت',
                        'paid' => 'پرداخت شده',
                        'cancelled' => 'لغو شده',
                        default => $booking->status,
                    };
                @endphp
                <tr onclick="openDetails({{ $booking->id }})" data-id="{{ $booking->id }}">
                    <td style="color:#64748b;font-weight:700;">{{ $bookings->firstItem() + $loop->index }}</td>

                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">
                                {{ mb_substr($booking->user->name ?? '?', 0, 1) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $booking->user->name ?? 'کاربر حذف شده' }}</div>
                                <div class="user-phone">{{ $booking->user->phone ?? '—' }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="service-name">{{ $serviceTitle }}</div>
                        <div class="service-items">{{ $itemsCount }} آیتم</div>
                    </td>

                    <td>
                        <div style="font-size:12px;color:#94a3b8;">
                            {{ $booking->created_at ? $booking->created_at->format('Y/m/d') : '—' }}
                        </div>
                        <div style="font-size:11px;color:#475569;">
                            {{ $booking->created_at ? $booking->created_at->format('H:i') : '' }}
                        </div>
                    </td>

                    <td>
                        <span class="amount-cell {{ $booking->total_amount > 0 ? '' : 'empty' }}">
                            {{ number_format($booking->total_amount) }} ت
                        </span>
                    </td>

                    <td>
                        <span class="badge {{ $badgeClass }}">
                            {{ $badgeLabel }}
                        </span>
                    </td>

                    <td>
                        <button type="button" class="action-btn" onclick="event.stopPropagation(); openDetails({{ $booking->id }})" title="جزئیات">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i data-lucide="inbox" class="w-14 h-14"></i>
                            <h3>هیچ رزروی یافت نشد</h3>
                            <p>هنوز هیچ رزرو واقعی ثبت نشده است.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- ===== PAGINATION ===== -->
@if($bookings->hasPages())
<div class="pagination-wrap">
    <span class="info">
        نمایش {{ $bookings->firstItem() ?? 0 }} تا {{ $bookings->lastItem() ?? 0 }} از {{ $bookings->total() }} رزرو
    </span>
    <div>{{ $bookings->appends(request()->query())->links() }}</div>
</div>
@endif

<!-- ============================================================
MODAL
============================================================ -->
<div class="modal-overlay" id="detailsModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>
                <i data-lucide="file-text" class="w-5 h-5"></i>
                جزئیات رزرو
            </h3>
            <button type="button" class="modal-close" onclick="closeModal()">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="modal-body" id="modalBody">
            <div class="modal-loading">
                <div class="modal-spinner"></div>
                <div>در حال بارگذاری...</div>
            </div>
        </div>
    </div>
</div>

<!-- ===== TOAST ===== -->
<div class="toast-container" id="toastContainer"></div>

<script>
    lucide.createIcons();

    let currentBookingId = null;

    async function openDetails(id) {
        currentBookingId = id;
        const modal = document.getElementById('detailsModal');
        const body = document.getElementById('modalBody');

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        body.innerHTML = `
            <div class="modal-loading">
                <div class="modal-spinner"></div>
                <div>در حال بارگذاری...</div>
            </div>
        `;

        try {
            const res = await fetch(`/admin/reservations/${id}/details`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
            });

            const data = await res.json();

            if (data.success) {
                renderDetails(data);
            } else {
                body.innerHTML = `<div class="empty-state"><i data-lucide="alert-circle" class="w-14 h-14"></i><h3>خطا</h3><p>${data.message || 'خطا در دریافت اطلاعات'}</p></div>`;
                lucide.createIcons();
            }
        } catch (err) {
            console.error(err);
            body.innerHTML = `<div class="empty-state"><i data-lucide="wifi-off" class="w-14 h-14"></i><h3>خطای شبکه</h3><p>اتصال به سرور برقرار نشد.</p></div>`;
            lucide.createIcons();
        }
    }

    function renderDetails(data) {
        const body = document.getElementById('modalBody');
        const { booking, user, items } = data;

        let html = '';

        // User
        html += `
            <div class="modal-section">
                <div class="modal-section-title">
                    <i data-lucide="user"></i> اطلاعات کاربر
                </div>
                <div class="user-block">
                    <div class="user-block-avatar">${(user.name || '?').charAt(0)}</div>
                    <div class="user-block-info">
                        <h4>${user.name}</h4>
                        <p>${user.phone}</p>
                        ${user.email && user.email !== '—' ? `<p style="margin-top:2px;color:#475569;font-size:11px;">${user.email}</p>` : ''}
                    </div>
                </div>
            </div>
        `;

        // Booking Info
        html += `
            <div class="modal-section">
                <div class="modal-section-title">
                    <i data-lucide="info"></i> اطلاعات رزرو
                </div>
                <div class="info-row">
                    <span class="label">شماره رزرو</span>
                    <span class="value ltr">#${booking.id}</span>
                </div>
                <div class="info-row">
                    <span class="label">وضعیت</span>
                    <span class="value">${booking.status_label}</span>
                </div>
                <div class="info-row">
                    <span class="label">تاریخ ثبت</span>
                    <span class="value">${booking.created_at}</span>
                </div>
                ${booking.paid_at ? `
                <div class="info-row">
                    <span class="label">تاریخ پرداخت</span>
                    <span class="value">${booking.paid_at}</span>
                </div>
                ` : ''}
            </div>
        `;

        // Items
        if (items && items.length > 0) {
            html += `
                <div class="modal-section">
                    <div class="modal-section-title">
                        <i data-lucide="package"></i> آیتم‌های رزرو (${items.length})
                    </div>
            `;

            items.forEach(item => {
                const icon = item.service_type === 'shift' ? 'clock' : 'hourglass';
                html += `
                    <div class="item-row">
                        <div class="item-icon">
                            <i data-lucide="${icon}"></i>
                        </div>
                        <div class="item-info">
                            <div class="item-service">${item.service_title}</div>
                            <div class="item-title">${item.item_title}</div>
                            <div class="item-time">
                                <span><i data-lucide="calendar"></i>${item.jalali_date || '—'}</span>
                                <span><i data-lucide="clock"></i>${item.time_start} - ${item.time_end}</span>
                                ${item.item_place ? `<span><i data-lucide="map-pin"></i>${item.item_place}</span>` : ''}
                            </div>
                        </div>
                        <div class="item-price">${item.price_formatted} ت</div>
                    </div>
                `;
            });

            html += `</div>`;
        }

        // Total
        html += `
            <div class="total-box">
                <span class="label">مبلغ کل</span>
                <span class="value">${booking.total_formatted} تومان</span>
            </div>
        `;

        // Actions
        html += `
            <div class="modal-section" style="margin-top:24px;">
                <div class="modal-section-title">
                    <i data-lucide="settings"></i> عملیات
                </div>
                <div class="status-actions">
                    ${booking.status !== 'paid' ? `
                        <button type="button" class="status-btn paid" onclick="updateStatus(${booking.id}, 'paid')">
                            <i data-lucide="badge-check" class="w-4 h-4"></i> تایید پرداخت
                        </button>
                    ` : ''}
                    ${booking.status !== 'pending' ? `
                        <button type="button" class="status-btn pending" onclick="updateStatus(${booking.id}, 'pending')">
                            <i data-lucide="clock" class="w-4 h-4"></i> در انتظار پرداخت
                        </button>
                    ` : ''}
                    ${booking.status !== 'cancelled' ? `
                        <button type="button" class="status-btn cancel" onclick="updateStatus(${booking.id}, 'cancelled')">
                            <i data-lucide="x-circle" class="w-4 h-4"></i> لغو رزرو
                        </button>
                    ` : ''}
                    <button type="button" class="status-btn delete" onclick="deleteReservation(${booking.id})">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> حذف کامل
                    </button>
                </div>
            </div>
        `;

        body.innerHTML = html;
        lucide.createIcons();
    }

    function closeModal() {
        document.getElementById('detailsModal').classList.remove('active');
        document.body.style.overflow = '';
        currentBookingId = null;
    }

    document.getElementById('detailsModal')?.addEventListener('click', (e) => {
        if (e.target.id === 'detailsModal') closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });

    async function updateStatus(id, status) {
        const labels = {
            paid: 'تایید پرداخت',
            pending: 'در انتظار پرداخت',
            cancelled: 'لغو رزرو',
        };

        if (!confirm(`آیا از «${labels[status] || status}» اطمینان دارید؟`)) return;

        try {
            const res = await fetch(`/admin/reservations/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ status }),
            });

            const data = await res.json();

            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => window.location.reload(), 900);
            } else {
                showToast(data.message || 'خطا در تغییر وضعیت', 'error');
            }
        } catch (err) {
            showToast('خطا در ارتباط با سرور', 'error');
        }
    }

    async function deleteReservation(id) {
        if (!confirm('آیا از حذف کامل این رزرو اطمینان دارید؟')) return;

        try {
            const res = await fetch(`/admin/reservations/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
            });

            if (res.ok || res.redirected) {
                showToast('رزرو با موفقیت حذف شد', 'success');
                setTimeout(() => window.location.href = '{{ route("admin.reservations.index") }}', 900);
            } else {
                showToast('خطا در حذف رزرو', 'error');
            }
        } catch (err) {
            showToast('خطا در ارتباط با سرور', 'error');
        }
    }

    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const icons = {
            success: 'check-circle',
            error: 'alert-circle',
            info: 'info',
        };
        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type}`;
        toast.innerHTML = `<i data-lucide="${icons[type]}" class="w-5 h-5"></i><span>${message}</span>`;
        container.appendChild(toast);
        lucide.createIcons();
        setTimeout(() => {
            toast.classList.add('hiding');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>
@endsection
