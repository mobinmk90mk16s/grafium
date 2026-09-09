@extends('admin.layouts.admin')

@section('title', 'تقویم کامل | GRAFIUM')

@section('content')
<style>
    /* ===== STATS BANNER ===== */
    .stats-banner {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        padding: 16px 20px;
        background: #0f1f33;
        border-radius: 12px;
        border: 1px solid #1a2f4a;
        margin-bottom: 20px;
    }
    .stats-banner .stat-item { text-align: center; }
    .stats-banner .stat-item .num { font-size: 20px; font-weight: 700; color: #60a5fa; }
    .stats-banner .stat-item .label { font-size: 11px; color: #64748b; }

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
    .filter-bar input, .filter-bar select {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 8px;
        padding: 8px 14px;
        color: #e2e8f0;
        font-size: 13px;
        font-family: 'Vazirmatn', sans-serif;
    }
    .filter-bar input:focus, .filter-bar select:focus {
        outline: none;
        border-color: #3b82f6;
    }
    .filter-bar .w-48 { width: 12rem; }

    /* ===== BUTTONS ===== */
    .btn-blue {
        background: #1a2f4a;
        color: #60a5fa;
        border: 1px solid #2a4a6a;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

    .btn-rose {
        background: rgba(244, 63, 94, 0.08);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.2);
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    .btn-emerald {
        background: rgba(52, 211, 153, 0.08);
        color: #34d399;
        border: 1px solid rgba(52, 211, 153, 0.2);
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

    .btn-violet {
        background: rgba(167, 139, 250, 0.08);
        color: #a78bfa;
        border: 1px solid rgba(167, 139, 250, 0.2);
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-violet:hover { background: rgba(167, 139, 250, 0.15); }

    /* ===== TABLE ===== */
    .table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #1a2f4a;
        background: #0f1f33;
    }
    .table-wrap table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-wrap thead {
        background: #0a1628;
        border-bottom: 1px solid #1a2f4a;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .table-wrap thead th {
        padding: 14px 16px;
        text-align: center;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        border-bottom: 1px solid #1a2f4a;
        white-space: nowrap;
    }
    .table-wrap tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #132238;
        color: #cbd5e1;
        vertical-align: middle;
        text-align: center;
    }
    .table-wrap tbody tr { transition: background 0.15s; }
    .table-wrap tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

    /* ===== BADGE ===== */
    .badge {
        padding: 4px 14px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .badge-active { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-inactive { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }
    .badge-event { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-birth { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-death { background: rgba(100, 116, 139, 0.15); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.2); }
    .badge-national { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
    .badge-normal { background: rgba(100, 116, 139, 0.08); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.1); padding: 2px 10px; border-radius: 12px; font-size: 11px; }
    .badge-holiday { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); padding: 2px 10px; border-radius: 12px; font-size: 11px; }

    /* ===== TOAST ===== */
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

    .toast-success { background: rgba(52, 211, 153, 0.15); border-color: rgba(52, 211, 153, 0.3); color: #34d399; }
    .toast-error { background: rgba(244, 63, 94, 0.15); border-color: rgba(244, 63, 94, 0.3); color: #fb7185; }
    .toast-info { background: rgba(59, 130, 246, 0.15); border-color: rgba(59, 130, 246, 0.3); color: #60a5fa; }

    /* ===== ACTION BUTTONS ===== */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .action-buttons button {
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid transparent;
        font-size: 12px;
        cursor: pointer;
        transition: 0.2s;
        font-family: 'Vazirmatn', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .action-buttons .btn-action-toggle {
        background: rgba(251, 191, 36, 0.08);
        color: #fbbf24;
        border-color: rgba(251, 191, 36, 0.2);
    }
    .action-buttons .btn-action-toggle:hover { background: rgba(251, 191, 36, 0.15); }

    .action-buttons .btn-action-delete {
        background: rgba(244, 63, 94, 0.08);
        color: #fb7185;
        border-color: rgba(244, 63, 94, 0.2);
    }
    .action-buttons .btn-action-delete:hover { background: rgba(244, 63, 94, 0.15); }

    /* ===== MODAL ===== */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px);
        display: none; align-items: center; justify-content: center; z-index: 999;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 20px;
        padding: 32px; max-width: 550px; width: 90%; max-height: 90vh; overflow-y: auto;
    }

    .input-dark {
        background: #0a1628; border: 1px solid #1a2f4a; border-radius: 8px; padding: 10px 14px;
        color: #e2e8f0; font-size: 13px; width: 100%; transition: border 0.2s; font-family: 'Vazirmatn', sans-serif;
    }
    .input-dark:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .input-dark::placeholder { color: #475569; }

    .avatar-icon { width: 36px; height: 36px; border-radius: 50%; background: #1a2f4a; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 16px; }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        display: flex;
        align-items: center; gap: 10px; font-size: 14px;
    }
    .alert-success {
        background: rgba(52, 211, 153, 0.12);
        border: 1px solid rgba(52, 211, 153, 0.2);
        color: #34d399;
    }
    .alert-error {
        background: rgba(244, 63, 94, 0.12);
        border: 1px solid rgba(244, 63, 94, 0.2);
        color: #fb7185;
    }

    .dropdown-container {
        position: relative;
        display: inline-block;
    }
    .dropdown-btn {
        background: #1a2f4a; color: #94a3b8; border: 1px solid #2a4a6a;
        padding: 8px 16px; border-radius: 8px; cursor: pointer;
        display: flex; align-items: center; gap: 8px;
        font-family: 'Vazirmatn', sans-serif; font-size: 13px;
        transition: 0.2s;
    }
    .dropdown-btn:hover { background: #2a4a6a; color: #fff; }
    .dropdown-menu {
        position: absolute; top: 100%; right: 0; margin-top: 4px;
        background: #132238; border: 1px solid #1a2f4a; border-radius: 10px;
        min-width: 120px; padding: 6px 0; z-index: 100;
        display: none; box-shadow: 0 8px 30px rgba(0,0,0,0.5);
    }
    .dropdown-menu.open { display: block; }
    .dropdown-menu button {
        display: block; width: 100%; padding: 8px 16px;
        background: none; border: none; color: #94a3b8;
        font-family: 'Vazirmatn', sans-serif; font-size: 13px;
        cursor: pointer; text-align: right; transition: 0.2s;
    }
    .dropdown-menu button:hover { background: #1a2f4a; color: #fff; }
    .dropdown-menu button.active { background: #1a2f4a; color: #60a5fa; }

    .pagination-bar {
        display: flex; justify-content: space-between; align-items: center;
        padding: 12px 20px; background: #0a1628; border-radius: 12px;
        border: 1px solid #1a2f4a; margin-top: 16px; flex-wrap: wrap; gap: 12px;
    }
    .pagination-bar .page-info { color: #64748b; font-size: 13px; }
    .pagination-bar .month-btns {
        display: flex; gap: 6px; flex-wrap: wrap;
    }
    .pagination-bar .month-btns button {
        padding: 6px 16px; border-radius: 8px; border: 1px solid #1a2f4a;
        background: transparent; color: #94a3b8; cursor: pointer; transition: 0.2s;
        font-family: 'Vazirmatn', sans-serif; font-size: 13px;
        min-width: 70px;
    }
    .pagination-bar .month-btns button:hover { background: #1a2f4a; color: #fff; }
    .pagination-bar .month-btns button.active {
        background: #3b82f6; color: #fff; border-color: #3b82f6;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .stats-banner { grid-template-columns: repeat(2, 1fr); }
        .toast-item { min-width: auto; max-width: 90%; }
        .pagination-bar .month-btns button { min-width: 55px; font-size: 12px; padding: 4px 10px; }
    }
    @media (max-width: 480px) {
        .table-wrap table { font-size: 10px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 6px 4px; }
        .stats-banner { grid-template-columns: 1fr; }
        .pagination-bar .month-btns button { min-width: 45px; font-size: 11px; padding: 3px 8px; }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="calendar" class="w-6 h-6 text-cyan-400"></i>
            <h1 class="text-2xl font-extrabold text-white">تقویم کامل</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9" id="currentMonthDisplay">نمایش: شهریور ۱۴۰۵</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
        <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
    </div>
</div>

<!-- ===== ALERT MESSAGES ===== -->
@if(session('success'))
    <div class="alert alert-success">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        <i data-lucide="alert-circle" class="w-5 h-5"></i>
        {{ session('error') }}
    </div>
@endif

<!-- ===== STATS BANNER ===== -->
<div class="stats-banner">
    <div class="stat-item">
        <span class="num" id="totalDays">0</span>
        <span class="label">روزهای ماه</span>
    </div>
    <div class="stat-item">
        <span class="num" id="totalHolidays">0</span>
        <span class="label">تعطیلات</span>
    </div>
    <div class="stat-item">
        <span class="num" id="totalEvents">0</span>
        <span class="label">مناسبت‌ها</span>
    </div>
    <div class="stat-item">
        <span class="num" id="totalBirths">0</span>
        <span class="label">ولادت‌ها</span>
    </div>
</div>

<!-- ===== FILTER BAR ===== -->
<div class="filter-bar">
    <input type="text" id="searchInput" placeholder="جستجو در مناسبت‌ها..." onkeyup="filterTable()" class="w-48" />
    <select id="typeFilter" onchange="filterTable()" class="filter-select">
        <option value="all">همه نوع‌ها</option>
        <option value="normal">عادی</option>
        <option value="birth">ولادت</option>
        <option value="death">شهادت</option>
        <option value="event">مناسبت</option>
        <option value="holiday">تعطیل</option>
        <option value="national">ملی</option>
    </select>

    <button class="btn-emerald" onclick="openAddDayModal()">
        <i data-lucide="plus" class="w-4 h-4"></i> افزودن روز
    </button>
    <button class="btn-violet" onclick="openAddMonthModal()">
        <i data-lucide="calendar-plus" class="w-4 h-4"></i> افزودن ماه کامل
    </button>
    <button class="btn-blue" onclick="filterTable()">
        <i data-lucide="search" class="w-4 h-4"></i> جستجو
    </button>
    <button class="btn-rose" onclick="resetFilters()">
        <i data-lucide="refresh-cw" class="w-4 h-4"></i> بازنشانی
    </button>
</div>

<!-- ===== CALENDAR TABLE ===== -->
<div class="table-wrap">
    <div class="overflow-x-auto">
        <table id="calendarTable">
            <thead>
                <tr>
                    <th style="min-width:80px;">شمسی</th>
                    <th style="min-width:100px;">میلادی</th>
                    <th style="min-width:120px;">مناسبت</th>
                    <th style="min-width:80px;">نوع</th>
                    <th style="min-width:80px;">تعطیل</th>
                    <th style="min-width:120px;">عملیات</th>
                </tr>
            </thead>
            <tbody id="calendarBody">
                @forelse($events as $event)
                    @php
                        $isNormal = empty($event->occasion) || $event->occasion_type == 'normal';
                    @endphp
                    <tr class="{{ $event->holy_day ? 'holiday' : '' }} {{ $isNormal ? 'normal' : '' }}"
                        data-month="{{ $event->month }}"
                        data-type="{{ $isNormal ? 'normal' : $event->occasion_type }}"
                        data-event="{{ $event->occasion }}"
                        data-id="{{ $event->id }}">
                        <td>{{ $event->year }} {{ $event->month }} {{ $event->day }}</td>
                        <td>{{ $event->miladi_date ?? '—' }}</td>
                        <td>{{ $event->occasion ?? 'عادی' }}</td>
                        <td>
                            @if($isNormal)
                                <span class="badge-normal">عادی</span>
                            @else
                                @php
                                    $typeMap = [
                                        'holiday' => 'badge-holiday',
                                        'birth' => 'badge-birth',
                                        'death' => 'badge-death',
                                        'event' => 'badge-event',
                                        'national' => 'badge-national',
                                    ];
                                    $labelMap = [
                                        'holiday' => 'تعطیل',
                                        'birth' => 'ولادت',
                                        'death' => 'شهادت',
                                        'event' => 'مناسبت',
                                        'national' => 'ملی',
                                    ];
                                @endphp
                                <span class="{{ $typeMap[$event->occasion_type] ?? 'badge-event' }}">
                                    {{ $labelMap[$event->occasion_type] ?? 'مناسبت' }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($event->holy_day)
                                <span class="badge-holiday">بله</span>
                            @else
                                <span class="text-[#475569] text-sm">خیر</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button onclick="openEditModal({{ $event->id }})" 
                                        class="text-blue-400 hover:text-blue-300 transition hover:bg-blue-500/10 px-2 py-1 rounded">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <button onclick="toggleHoliday({{ $event->id }})" 
                                        class="{{ $event->holy_day ? 'text-emerald-400 hover:text-emerald-300' : 'text-amber-400 hover:text-amber-300' }} transition hover:bg-amber-500/10 px-2 py-1 rounded"
                                        title="{{ $event->holy_day ? 'لغو تعطیلی' : 'تعطیل کردن' }}">
                                    <i data-lucide="{{ $event->holy_day ? 'calendar-check' : 'calendar-off' }}" class="w-4 h-4"></i>
                                </button>
                                <button onclick="deleteEvent({{ $event->id }})" 
                                        class="text-rose-400 hover:text-rose-300 transition hover:bg-rose-500/10 px-2 py-1 rounded"
                                        title="حذف مناسبت (تبدیل به روز عادی)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-[#475569]">
                            <i data-lucide="calendar-off" class="w-12 h-12 mx-auto text-[#475569] mb-3"></i>
                            <p>هیچ رویدادی در تقویم یافت نشد</p>
                            <p class="text-xs mt-1">برای افزودن رویداد، روی دکمه "افزودن روز" کلیک کنید</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== PAGINATION WITH MONTH NAMES ===== -->
<div class="pagination-bar">
    <span class="page-info">نمایش <span id="startRow">{{ $events->count() > 0 ? 1 : 0 }}</span> - <span id="endRow">{{ $events->count() }}</span> از <span id="totalRows">{{ $events->count() }}</span> روز</span>
    <div class="month-btns" id="monthButtons">
        @php
            $months = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
        @endphp
        @foreach($months as $month)
            <button class="month-btn {{ $month == 'شهریور' ? 'active' : '' }}" 
                    data-month="{{ $month }}"
                    onclick="filterByMonth('{{ $month }}')">
                {{ $month }}
            </button>
        @endforeach
    </div>
</div>

<!-- ============================================================
MODAL: افزودن روز
============================================================ -->
<div id="addDayModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <i data-lucide="calendar-plus" class="w-5 h-5 text-emerald-400"></i>
                <h3 class="text-xl font-bold text-white">افزودن روز جدید</h3>
            </div>
            <button onclick="closeModal('addDayModal')" class="text-[#64748b] hover:text-white transition">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="addDayForm" action="{{ route('admin.calendar.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">سال</label>
                        <input type="text" name="year" class="input-dark" value="۱۴۰۵" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">ماه</label>
                        <select name="month" class="input-dark" required>
                            <option value="">انتخاب ماه</option>
                            @foreach($months as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">روز</label>
                        <input type="number" name="day" class="input-dark" min="1" max="31" required />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">نام روز</label>
                    <select name="day_name" class="input-dark">
                        <option value="">انتخاب نام روز</option>
                        <option value="شنبه">شنبه</option>
                        <option value="یکشنبه">یکشنبه</option>
                        <option value="دوشنبه">دوشنبه</option>
                        <option value="سه‌شنبه">سه‌شنبه</option>
                        <option value="چهارشنبه">چهارشنبه</option>
                        <option value="پنجشنبه">پنجشنبه</option>
                        <option value="جمعه">جمعه</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">مناسبت</label>
                    <input type="text" name="occasion" class="input-dark" placeholder="مثال: ولادت امام رضا (ع) - خالی بگذارید برای روز عادی" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">نوع مناسبت</label>
                        <select name="occasion_type" class="input-dark">
                            <option value="normal">عادی</option>
                            <option value="event">مناسبت</option>
                            <option value="birth">ولادت</option>
                            <option value="death">شهادت</option>
                            <option value="holiday">تعطیل</option>
                            <option value="national">ملی</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">تعطیل</label>
                        <select name="holy_day" class="input-dark">
                            <option value="0">خیر</option>
                            <option value="1">بله</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">تاریخ میلادی</label>
                    <input type="date" name="miladi_date" class="input-dark" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">توضیحات</label>
                    <textarea name="description" class="input-dark" rows="2" placeholder="توضیحات اضافی..."></textarea>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-emerald w-full justify-center">
                    <i data-lucide="save" class="w-4 h-4"></i> ذخیره روز
                </button>
                <button type="button" onclick="closeModal('addDayModal')" class="btn-rose w-full justify-center">انصراف</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================
MODAL: افزودن ماه کامل
============================================================ -->
<div id="addMonthModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <i data-lucide="calendar-plus" class="w-5 h-5 text-violet-400"></i>
                <h3 class="text-xl font-bold text-white">افزودن ماه کامل</h3>
            </div>
            <button onclick="closeModal('addMonthModal')" class="text-[#64748b] hover:text-white transition">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="addMonthForm" action="{{ route('admin.calendar.store-month') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">سال</label>
                        <input type="text" name="year" class="input-dark" value="۱۴۰۵" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">ماه</label>
                        <select name="month" class="input-dark" required>
                            <option value="">انتخاب ماه</option>
                            @foreach($months as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">تعداد روزهای ماه</label>
                    <select name="month_days" class="input-dark" required>
                        <option value="29">۲۹ روز</option>
                        <option value="30" selected>۳۰ روز</option>
                        <option value="31">۳۱ روز</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">اولین روز ماه</label>
                    <select name="first_day" class="input-dark" required>
                        <option value="شنبه">شنبه</option>
                        <option value="یکشنبه">یکشنبه</option>
                        <option value="دوشنبه">دوشنبه</option>
                        <option value="سه‌شنبه">سه‌شنبه</option>
                        <option value="چهارشنبه">چهارشنبه</option>
                        <option value="پنجشنبه">پنجشنبه</option>
                        <option value="جمعه">جمعه</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">تاریخ شروع میلادی</label>
                    <input type="date" name="miladi_start" class="input-dark" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">توضیحات</label>
                    <textarea name="description" class="input-dark" rows="2" placeholder="توضیحات مربوط به این ماه..."></textarea>
                </div>
                <div class="bg-[#0a1628] p-3 rounded-lg border border-[#1a2f4a]">
                    <p class="text-xs text-[#64748b]">با کلیک روی "ذخیره ماه"، تمام روزهای این ماه با وضعیت "عادی" ایجاد می‌شوند. بعداً می‌توانید هر روز را ویرایش کنید.</p>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-violet w-full justify-center">
                    <i data-lucide="save" class="w-4 h-4"></i> ذخیره ماه کامل
                </button>
                <button type="button" onclick="closeModal('addMonthModal')" class="btn-rose w-full justify-center">انصراف</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================
MODAL: ویرایش روز
============================================================ -->
<div id="editEventModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <i data-lucide="pencil" class="w-5 h-5 text-blue-400"></i>
                <h3 class="text-xl font-bold text-white">ویرایش رویداد</h3>
            </div>
            <button onclick="closeModal('editEventModal')" class="text-[#64748b] hover:text-white transition">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="editEventForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">سال</label>
                        <input type="text" id="edit_year" name="year" class="input-dark" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">ماه</label>
                        <input type="text" id="edit_month" name="month" class="input-dark" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">روز</label>
                        <input type="number" id="edit_day" name="day" class="input-dark" min="1" max="31" required />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">نام روز</label>
                    <input type="text" id="edit_day_name" name="day_name" class="input-dark" placeholder="شنبه، یکشنبه، ..." />
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">مناسبت</label>
                    <input type="text" id="edit_occasion" name="occasion" class="input-dark" placeholder="خالی بگذارید برای روز عادی" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">نوع مناسبت</label>
                        <select id="edit_occasion_type" name="occasion_type" class="input-dark">
                            <option value="normal">عادی</option>
                            <option value="event">مناسبت</option>
                            <option value="birth">ولادت</option>
                            <option value="death">شهادت</option>
                            <option value="holiday">تعطیل</option>
                            <option value="national">ملی</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">تعطیل</label>
                        <select id="edit_holy_day" name="holy_day" class="input-dark">
                            <option value="0">خیر</option>
                            <option value="1">بله</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">تاریخ میلادی</label>
                    <input type="date" id="edit_miladi_date" name="miladi_date" class="input-dark" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#94a3b8] mb-1">توضیحات</label>
                    <textarea id="edit_description" name="description" class="input-dark" rows="2" placeholder="توضیحات اضافی..."></textarea>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-blue w-full justify-center">
                    <i data-lucide="save" class="w-4 h-4"></i> ذخیره تغییرات
                </button>
                <button type="button" onclick="closeModal('editEventModal')" class="btn-rose w-full justify-center">انصراف</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================
TOAST
============================================================ -->
<div id="toastContainer" class="toast-container"></div>

<!-- ============================================================
SCRIPTS
============================================================ -->
<script>
    lucide.createIcons();

    // ============================================================
    // CALENDAR STATE
    // ============================================================
    let currentMonth = 'شهریور';
    let currentYear = 1405;

    // ============================================================
    // MODALS
    // ============================================================
    function openAddDayModal() {
        document.getElementById('addDayModal').classList.add('active');
        lucide.createIcons();
    }

    function openAddMonthModal() {
        document.getElementById('addMonthModal').classList.add('active');
        lucide.createIcons();
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    // ============================================================
    // EDIT EVENT
    // ============================================================
    function openEditModal(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (!row) {
            showToast('خطا در بارگذاری اطلاعات', 'error');
            return;
        }

        const cells = row.querySelectorAll('td');
        const shamsi = cells[0]?.textContent?.trim() || '';
        const miladi = cells[1]?.textContent?.trim() || '';
        const occasion = cells[2]?.textContent?.trim() || '';

        const form = document.getElementById('editEventForm');
        form.action = `/admin/calendar/${id}`;

        const shamsiParts = shamsi.split(' ');
        document.getElementById('edit_year').value = shamsiParts[0] || '';
        document.getElementById('edit_month').value = shamsiParts[1] || '';
        document.getElementById('edit_day').value = shamsiParts[2] || '';
        document.getElementById('edit_occasion').value = occasion !== 'عادی' ? occasion : '';

        // Convert miladi date to input format
        if (miladi !== '—') {
            document.getElementById('edit_miladi_date').value = miladi;
        }

        const type = row.dataset.type || 'normal';
        document.getElementById('edit_occasion_type').value = type;

        const isHoliday = row.classList.contains('holiday');
        document.getElementById('edit_holy_day').value = isHoliday ? '1' : '0';

        document.getElementById('editEventModal').classList.add('active');
        lucide.createIcons();
    }

    // ============================================================
    // DELETE EVENT
    // ============================================================
    function deleteEvent(id) {
        if (!confirm('آیا از حذف این مناسبت اطمینان دارید؟ روز به حالت عادی باز می‌گردد.')) return;

        fetch(`/admin/calendar/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('رویداد با موفقیت حذف شد', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('خطا در حذف رویداد: ' + (data.message || ''), 'error');
            }
        })
        .catch(err => {
            showToast('خطا در ارتباط با سرور', 'error');
            console.error(err);
        });
    }

    // ============================================================
    // TOGGLE HOLIDAY
    // ============================================================
    function toggleHoliday(id) {
        fetch(`/admin/calendar/${id}/toggle-holiday`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('وضعیت تعطیلی با موفقیت تغییر کرد', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('خطا در تغییر وضعیت: ' + (data.message || ''), 'error');
            }
        })
        .catch(err => {
            showToast('خطا در ارتباط با سرور', 'error');
            console.error(err);
        });
    }

    // ============================================================
    // FILTER BY MONTH
    // ============================================================
    function filterByMonth(month) {
        const rows = document.querySelectorAll('#calendarBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowMonth = row.dataset.month || '';
            if (month === 'all' || rowMonth === month) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.querySelectorAll('.month-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.month === month) {
                btn.classList.add('active');
            }
        });

        document.getElementById('totalRows').textContent = visibleCount;
        document.getElementById('endRow').textContent = visibleCount;
        document.getElementById('startRow').textContent = visibleCount > 0 ? 1 : 0;

        document.getElementById('currentMonthDisplay').textContent = 'نمایش: ' + month + ' ۱۴۰۵';

        showToast('نمایش ماه ' + month, 'info');
    }

    // ============================================================
    // FILTER TABLE
    // ============================================================
    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const type = document.getElementById('typeFilter').value;
        const rows = document.querySelectorAll('#calendarBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const shamsi = row.cells[0]?.textContent || '';
            const event = row.cells[2]?.textContent || '';
            const rowType = row.dataset.type || '';
            let show = true;

            if (search && !shamsi.includes(search) && !event.includes(search)) {
                show = false;
            }
            if (type !== 'all' && rowType !== type) {
                show = false;
            }

            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        document.getElementById('totalRows').textContent = visibleCount;
        document.getElementById('endRow').textContent = visibleCount;
        document.getElementById('startRow').textContent = visibleCount > 0 ? 1 : 0;
    }

    // ============================================================
    // RESET FILTERS
    // ============================================================
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('typeFilter').value = 'all';
        filterTable();
        showToast('فیلترها بازنشانی شدند', 'info');
    }

    // ============================================================
    // TOAST
    // ============================================================
    function showToast(message, type = 'info', duration = 3000) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type}`;
        const icons = { success: 'check-circle', error: 'alert-circle', warning: 'alert-triangle', info: 'info' };
        toast.innerHTML = `
            <i data-lucide="${icons[type] || 'info'}" class="w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm font-medium">${message}</span>
        `;
        container.appendChild(toast);
        lucide.createIcons();
        setTimeout(() => { toast.classList.add('hiding'); setTimeout(() => toast.remove(), 300); }, duration);
    }

    // ============================================================
    // KEYBOARD SHORTCUTS
    // ============================================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(el => el.classList.remove('active'));
        }
    });

    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });
    });

    // ============================================================
    // SET DEFAULT MONTH ON LOAD
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const activeMonth = document.querySelector('.month-btn.active');
        if (activeMonth) {
            filterByMonth(activeMonth.dataset.month);
        }
    });
</script>
@endsection