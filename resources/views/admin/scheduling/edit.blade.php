@extends('admin.layouts.admin')

@section('title', 'ویرایش زمان‌بندی | GRAFIUM')

@section('content')
<style>
    .form-card {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 16px;
        padding: 28px;
        max-width: 800px;
        margin: 0 auto;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .form-group label i { width: 14px; height: 14px; }

    .input-dark {
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 8px;
        padding: 10px 14px;
        color: #e2e8f0;
        font-size: 13px;
        width: 100%;
        transition: border 0.2s;
        font-family: 'Vazirmatn', sans-serif;
    }
    .input-dark:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .input-dark::placeholder { color: #475569; }

    .select-box {
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 10px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.25s;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .select-box:hover { border-color: #2a4a6a; background: #0f1f33; }
    .select-box.active { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .select-box .placeholder { color: #475569; font-size: 13px; }
    .select-box .value { color: #e2e8f0; font-size: 13px; font-weight: 600; }
    .select-box .icon-wrap { color: #64748b; }

    .slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 10px;
        padding: 14px;
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 10px;
        margin-top: 10px;
    }
    .slot-btn {
        padding: 10px 8px;
        background: #0f1f33;
        border: 1.5px solid #1a2f4a;
        border-radius: 8px;
        color: #cbd5e1;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Vazirmatn', sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
    }
    .slot-btn .slot-time { font-size: 14px; font-weight: 700; }
    .slot-btn .slot-status { font-size: 10px; opacity: 0.7; }
    .slot-btn:hover:not(.disabled) { border-color: #3b82f6; background: rgba(59, 130, 246, 0.08); }
    .slot-btn.selected {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-color: #3b82f6;
        color: #fff;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .status-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    .status-card {
        padding: 14px 10px;
        background: #0a1628;
        border: 1.5px solid #1a2f4a;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.25s;
        text-align: center;
        font-family: 'Vazirmatn', sans-serif;
        color: #cbd5e1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }
    .status-card i { font-size: 18px; }
    .status-card .label { font-size: 12px; font-weight: 600; }
    .status-card:hover { border-color: #2a4a6a; background: #0f1f33; }
    .status-card.selected {
        color: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    .status-card.selected.status-available { background: rgba(52, 211, 153, 0.15); border-color: #34d399; color: #34d399; }
    .status-card.selected.status-reserved { background: rgba(251, 191, 36, 0.15); border-color: #fbbf24; color: #fbbf24; }
    .status-card.selected.status-maintenance { background: rgba(244, 63, 94, 0.15); border-color: #fb7185; color: #fb7185; }
    .status-card.selected.status-blocked { background: rgba(148, 163, 184, 0.15); border-color: #94a3b8; color: #94a3b8; }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .modal-overlay.active { display: flex; opacity: 1; }
    .calendar-modal {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 18px;
        padding: 24px;
        max-width: 560px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        transform: scale(0.9);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .modal-overlay.active .calendar-modal { transform: scale(1); }

    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #1a2f4a;
    }
    .calendar-header h3 {
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .calendar-header .close-btn {
        background: transparent;
        border: 1px solid #1a2f4a;
        border-radius: 8px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        cursor: pointer;
        transition: all 0.2s;
    }
    .calendar-header .close-btn:hover { background: rgba(244, 63, 94, 0.1); border-color: #fb7185; color: #fb7185; }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
        margin-bottom: 12px;
    }
    .calendar-weekdays span {
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        padding: 6px 0;
    }
    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
    }
    .cal-day {
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        background: #0a1628;
        border: 1.5px solid #1a2f4a;
        color: #cbd5e1;
        position: relative;
        font-family: 'Vazirmatn', sans-serif;
        padding: 4px;
    }
    .cal-day .num { font-size: 14px; font-weight: 700; }
    .cal-day .mname { font-size: 9px; opacity: 0.6; margin-top: 1px; }
    .cal-day:hover:not(.empty):not(.disabled) {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.08);
        transform: scale(1.05);
    }
    .cal-day.empty { background: transparent; border: none; cursor: default; }
    .cal-day.disabled {
        opacity: 0.3;
        cursor: not-allowed;
        background: #0a1628;
    }
    .cal-day.selected {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-color: #3b82f6;
        color: #fff;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        transform: scale(1.05);
    }
    .cal-day.today {
        border-color: #d4a373;
        color: #d4a373;
    }
    .cal-day.holiday { color: #fb7185; }
    .cal-day.selected.holiday { color: #fff; }

    .calendar-footer {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #1a2f4a;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .calendar-footer .info { color: #64748b; font-size: 12px; }
    .calendar-footer .btn-confirm {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        font-family: 'Vazirmatn', sans-serif;
        transition: all 0.2s;
    }
    .calendar-footer .btn-confirm:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4); }
    .calendar-footer .btn-confirm:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

    .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 10px 22px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-family: 'Vazirmatn', sans-serif; }
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }
    .btn-emerald:disabled { opacity: 0.4; cursor: not-allowed; }

    .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 10px 22px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-family: 'Vazirmatn', sans-serif; }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    .avatar-icon { width: 36px; height: 36px; border-radius: 50%; background: #1a2f4a; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 16px; }

    .info-box {
        padding: 12px 16px;
        background: rgba(96, 165, 250, 0.06);
        border: 1px solid rgba(96, 165, 250, 0.2);
        border-radius: 10px;
        color: #93c5fd;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }
    .info-box i { flex-shrink: 0; }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .form-card { padding: 18px; }
        .status-grid { grid-template-columns: repeat(2, 1fr); }
        .slots-grid { grid-template-columns: repeat(3, 1fr); }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="pencil" class="w-6 h-6 text-blue-400"></i>
            <h1 class="text-2xl font-extrabold text-white">ویرایش زمان‌بندی</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">ویرایش اطلاعات زمان‌بندی</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
        <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
    </div>
</div>

<!-- ===== FORM ===== -->
<div class="form-card">
    <form action="{{ route('admin.scheduling.update', $schedule->id) }}" method="POST" id="schedulingForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="service_item_id" id="serviceItemInput" value="{{ $schedule->service_item_id }}">
        <input type="hidden" name="date_time" id="dateTimeInput" value="{{ $schedule->date_time ? $schedule->date_time->format('Y-m-d\TH:i') : '' }}">
        <input type="hidden" name="end_time" id="endTimeInput" value="{{ $schedule->end_time ? $schedule->end_time->format('Y-m-d\TH:i') : '' }}">
        <input type="hidden" name="status" id="statusInput" value="{{ $schedule->status }}">

        <!-- ===== Step 1: انتخاب آیتم خدمت ===== -->
        <div class="form-group">
            <label><i data-lucide="package"></i> آیتم خدمت</label>
            <select id="serviceItemSelect" class="input-dark" required>
                <option value="">— انتخاب آیتم خدمت —</option>
                @foreach($serviceItems as $item)
                    <option
                        value="{{ $item->id }}"
                        data-service-id="{{ $item->service_id }}"
                        data-service-title="{{ $item->service->title ?? '' }}"
                        data-service-type="{{ $item->service->type ?? 'shift' }}"
                        data-item-title="{{ $item->title }}"
                        {{ $schedule->service_item_id == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->title }} — {{ $item->service->title ?? 'بدون خدمت' }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- ===== Info Box ===== -->
        <div class="info-box" id="typeInfoBox" style="display:none;">
            <i data-lucide="info" class="w-4 h-4"></i>
            <span id="typeInfoText"></span>
        </div>

        <!-- ===== Step 2: انتخاب تاریخ ===== -->
        <div class="form-group">
            <label><i data-lucide="calendar"></i> تاریخ</label>
            <div class="select-box" id="datePickerTrigger">
                <span class="value" id="datePickerText">{{ $schedule->date_time ? $schedule->date_time->format('Y/m/d') : 'انتخاب کنید' }}</span>
                <i data-lucide="calendar" class="w-4 h-4 icon-wrap"></i>
            </div>
        </div>

        <!-- ===== Step 3: انتخاب زمان ===== -->
        <div class="form-group" id="timeSection">
            <label><i data-lucide="clock"></i> زمان</label>
            <div id="slotsContainer" class="slots-grid"></div>
        </div>

        <!-- ===== Step 4: وضعیت ===== -->
        <div class="form-group" id="statusSection">
            <label><i data-lucide="activity"></i> وضعیت</label>
            <div class="status-grid">
                <div class="status-card status-available {{ $schedule->status == 'available' ? 'selected' : '' }}" data-status="available">
                    <i data-lucide="check-circle"></i>
                    <span class="label">قابل رزرو</span>
                </div>
                <div class="status-card status-reserved {{ $schedule->status == 'reserved' ? 'selected' : '' }}" data-status="reserved">
                    <i data-lucide="clock"></i>
                    <span class="label">رزرو شده</span>
                </div>
                <div class="status-card status-maintenance {{ $schedule->status == 'maintenance' ? 'selected' : '' }}" data-status="maintenance">
                    <i data-lucide="wrench"></i>
                    <span class="label">تعمیرات</span>
                </div>
                <div class="status-card status-blocked {{ $schedule->status == 'blocked' ? 'selected' : '' }}" data-status="blocked">
                    <i data-lucide="ban"></i>
                    <span class="label">مسدود</span>
                </div>
            </div>
        </div>

        <!-- ===== Step 5: توضیحات ===== -->
        <div class="form-group" id="noteSection">
            <label><i data-lucide="file-text"></i> توضیحات (اختیاری)</label>
            <textarea name="note" class="input-dark" rows="3" placeholder="توضیحات اضافی...">{{ $schedule->note }}</textarea>
        </div>

        <!-- ===== Actions ===== -->
        <div class="flex gap-3 mt-6 pt-4 border-t border-[#1a2f4a]">
            <button type="submit" class="btn-emerald" id="submitBtn">
                <i data-lucide="save" class="w-4 h-4"></i> ذخیره تغییرات
            </button>
            <a href="{{ route('admin.scheduling.index') }}" class="btn-rose">
                <i data-lucide="x" class="w-4 h-4"></i> انصراف
            </a>
        </div>

        @if($errors->any())
        <div class="mt-4 p-3 bg-rose-500/10 border border-rose-500/20 rounded-lg text-rose-400 text-sm">
            <ul class="list-disc pr-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
</div>

<!-- ============================================================
MODAL تقویم
============================================================ -->
<div class="modal-overlay" id="calendarModal">
    <div class="calendar-modal">
        <div class="calendar-header">
            <h3><i data-lucide="calendar-days"></i> انتخاب تاریخ</h3>
            <button type="button" class="close-btn" id="closeCalendar">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div style="margin-bottom:14px; display:flex; align-items:center; justify-content:space-between; gap:10px;">
            <button type="button" id="prevMonth" class="close-btn" style="width:36px;height:36px;">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
            <div style="color:#e2e8f0; font-weight:700; font-size:15px;" id="monthTitle">ماه</div>
            <button type="button" id="nextMonth" class="close-btn" style="width:36px;height:36px;">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="calendar-weekdays">
            <span>شنبه</span>
            <span>یک‌شنبه</span>
            <span>دوشنبه</span>
            <span>سه‌شنبه</span>
            <span>چهارشنبه</span>
            <span>پنج‌شنبه</span>
            <span>جمعه</span>
        </div>

        <div class="calendar-days" id="calendarDays"></div>

        <div class="calendar-footer">
            <div class="info" id="calendarInfo">روزی انتخاب نشده</div>
            <button type="button" class="btn-confirm" id="confirmDate" disabled>
                تایید
            </button>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    // ============================================================
    // ماه‌های شمسی
    // ============================================================
    const persianMonths = [
        { name: 'فروردین', days: 31 },
        { name: 'اردیبهشت', days: 31 },
        { name: 'خرداد', days: 31 },
        { name: 'تیر', days: 31 },
        { name: 'مرداد', days: 31 },
        { name: 'شهریور', days: 31 },
        { name: 'مهر', days: 30 },
        { name: 'آبان', days: 30 },
        { name: 'آذر', days: 30 },
        { name: 'دی', days: 30 },
        { name: 'بهمن', days: 30 },
        { name: 'اسفند', days: 29 },
    ];

    // ============================================================
    // تبدیل دقیق میلادی به شمسی
    // ============================================================
    function gregorianToJalali(gy, gm, gd) {
        const g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        let jy = (gy <= 1600) ? 0 : 979;
        gy -= (gy <= 1600) ? 621 : 1600;
        const gy2 = (gm > 2) ? (gy + 1) : gy;
        let days = (365 * gy) + (Math.floor((gy2 + 3) / 4)) - (Math.floor((gy2 + 99) / 100)) + (Math.floor((gy2 + 399) / 400)) - 80 + gd + g_d_m[gm - 1];
        jy += 33 * (Math.floor(days / 12053));
        days %= 12053;
        jy += 4 * (Math.floor(days / 1461));
        days %= 1461;
        if (days > 365) {
            jy += Math.floor((days - 1) / 365);
            days = (days - 1) % 365;
        }
        const jm = (days < 186) ? 1 + Math.floor(days / 31) : 7 + Math.floor((days - 186) / 30);
        const jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));
        return { jy, jm, jd };
    }

    // تبدیل شمسی به میلادی
    function jalaliToGregorian(jy, jm, jd) {
        jy += 1595;
        let days = -355668 + (365 * jy) + ((Math.floor(jy / 33)) * 8) + Math.floor(((jy % 33) + 3) / 4) + jd + ((jm < 7) ? (jm - 1) * 31 : ((jm - 7) * 30) + 186);
        let gy = 400 * Math.floor(days / 146097);
        days %= 146097;
        if (days > 36524) {
            gy += 100 * Math.floor(--days / 36524);
            days %= 36524;
            if (days >= 365) days++;
        }
        gy += 4 * Math.floor(days / 1461);
        days %= 1461;
        if (days > 365) {
            gy += Math.floor((days - 1) / 365);
            days = (days - 1) % 365;
        }
        let gd = days + 1;
        const sal_a = [0, 31, ((gy % 4 === 0 && gy % 100 !== 0) || (gy % 400 === 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        let gm;
        for (gm = 1; gm <= 12; gm++) {
            if (gd <= sal_a[gm]) break;
            gd -= sal_a[gm];
        }
        return { gy, gm, gd };
    }

    // ============================================================
    // امروز (شمسی)
    // ============================================================
    function getCurrentPersianDate() {
        const now = new Date();
        const j = gregorianToJalali(now.getFullYear(), now.getMonth() + 1, now.getDate());
        return { year: j.jy, month: j.jm - 1, day: j.jd };
    }

    const todayJalali = getCurrentPersianDate();

    // ============================================================
    // داده‌های اولیه از سرور
    // ============================================================
    const initialDateTime = @json($schedule->date_time ? $schedule->date_time->format('Y-m-d\TH:i') : null);
    const initialEndTime  = @json($schedule->end_time ? $schedule->end_time->format('Y-m-d\TH:i') : null);
    const initialStatus   = @json($schedule->status);
    const initialItemId   = {{ $schedule->service_item_id }};

    // ============================================================
    // State
    // ============================================================
    const state = {
        serviceItemId: initialItemId,
        serviceType: null,
        selectedDate: null,
        selectedStartHour: null,
        selectedEndHour: null,
        currentYear: todayJalali.year,
        currentMonth: todayJalali.month,
        tempSelectedDate: null,
    };

    // ============================================================
    // شیفت‌ها
    // ============================================================
    const SHIFTS = [
        { key: 'morning', label: 'شیفت ۱', start: 8, end: 14, slots: [8, 9, 10, 11, 12, 13] },
        { key: 'afternoon', label: 'شیفت ۲', start: 15, end: 21, slots: [15, 16, 17, 18, 19, 20] },
    ];

    // ============================================================
    // DOM
    // ============================================================
    const serviceItemSelect = document.getElementById('serviceItemSelect');
    const typeInfoBox = document.getElementById('typeInfoBox');
    const typeInfoText = document.getElementById('typeInfoText');
    const datePickerTrigger = document.getElementById('datePickerTrigger');
    const datePickerText = document.getElementById('datePickerText');
    const timeSection = document.getElementById('timeSection');
    const slotsContainer = document.getElementById('slotsContainer');
    const statusSection = document.getElementById('statusSection');
    const noteSection = document.getElementById('noteSection');
    const submitBtn = document.getElementById('submitBtn');
    const calendarModal = document.getElementById('calendarModal');
    const calendarDays = document.getElementById('calendarDays');
    const monthTitle = document.getElementById('monthTitle');
    const calendarInfo = document.getElementById('calendarInfo');
    const confirmDate = document.getElementById('confirmDate');

    const serviceItemInput = document.getElementById('serviceItemInput');
    const dateTimeInput = document.getElementById('dateTimeInput');
    const endTimeInput = document.getElementById('endTimeInput');
    const statusInput = document.getElementById('statusInput');

    // ============================================================
    // init: بارگذاری مقادیر اولیه
    // ============================================================
    function initFromSchedule() {
        // انتخاب آیتم
        const opt = serviceItemSelect.options[serviceItemSelect.selectedIndex];
        if (opt && opt.value) {
            state.serviceType = opt.dataset.serviceType || 'shift';
            serviceItemInput.value = opt.value;

            // Info Box
            typeInfoBox.style.display = 'flex';
            if (state.serviceType === 'shift') {
                typeInfoText.textContent = `نوع تعرفه: شیفتی — دو شیفت در روز قابل رزرو است (۸-۱۴ و ۱۵-۲۱)`;
            } else {
                typeInfoText.textContent = `نوع تعرفه: ساعتی — انتخاب ساعت شروع و پایان (۸-۱۳ و ۱۵-۲۰)`;
            }

            datePickerTrigger.style.opacity = '1';
            datePickerTrigger.style.pointerEvents = 'auto';
        }

        // parse تاریخ
        if (initialDateTime) {
            const [datePart, timePart] = initialDateTime.split('T');
            const [gy, gm, gd] = datePart.split('-').map(Number);
            const [hh] = timePart.split(':').map(Number);

            const j = gregorianToJalali(gy, gm, gd);
            const monthName = persianMonths[j.jm - 1].name;

            state.selectedDate = {
                year: j.jy,
                month: j.jm - 1,
                day: j.jd,
                monthName: monthName,
                iso: datePart,
                jsDate: new Date(gy, gm - 1, gd),
            };

            state.selectedStartHour = hh;

            // تعیین end hour
            if (initialEndTime) {
                const [, eTime] = initialEndTime.split('T');
                const [eh] = eTime.split(':').map(Number);
                state.selectedEndHour = eh;
            }

            // نمایش در باکس
            datePickerText.textContent = `${j.jd} ${monthName} ${j.jy}`;
            datePickerText.className = 'value';
            datePickerTrigger.classList.add('active');

            // رندر اسلات‌ها
            renderTimeSlots();

            // علامت‌گذاری اسلات انتخاب‌شده
            if (state.serviceType === 'shift') {
                const startHour = state.selectedStartHour;
                const shift = SHIFTS.find(s => s.start === startHour);
                if (shift) {
                    const btn = slotsContainer.querySelector(`.slot-btn[data-start="${shift.start}"]`);
                    if (btn) btn.classList.add('selected');
                }
            } else {
                const startHour = state.selectedStartHour;
                const endHour = state.selectedEndHour || (startHour + 1);
                const shift = SHIFTS.find(s => s.slots.includes(startHour));
                if (shift) {
                    shift.slots.forEach(h => {
                        if (h >= startHour && h < endHour) {
                            const btn = slotsContainer.querySelector(`.slot-btn[data-hour="${h}"]`);
                            if (btn) btn.classList.add('selected');
                        }
                    });
                }
            }

            // نمایش بخش‌ها
            timeSection.style.display = 'block';
            statusSection.style.display = 'block';
            noteSection.style.display = 'block';
            submitBtn.disabled = false;
        }
    }

    // اجرای اولیه
    initFromSchedule();

    // ============================================================
    // تغییر آیتم خدمت
    // ============================================================
    serviceItemSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        if (!opt.value) {
            resetForm();
            return;
        }

        state.serviceItemId = opt.value;
        state.serviceType = opt.dataset.serviceType || 'shift';

        serviceItemInput.value = opt.value;

        typeInfoBox.style.display = 'flex';
        if (state.serviceType === 'shift') {
            typeInfoText.textContent = `نوع تعرفه: شیفتی — دو شیفت در روز قابل رزرو است (۸-۱۴ و ۱۵-۲۱)`;
        } else {
            typeInfoText.textContent = `نوع تعرفه: ساعتی — انتخاب ساعت شروع و پایان (۸-۱۳ و ۱۵-۲۰)`;
        }

        datePickerTrigger.style.opacity = '1';
        datePickerTrigger.style.pointerEvents = 'auto';

        // اگه تاریخ انتخاب شده، اسلات‌ها رو دوباره رندر کن
        if (state.selectedDate) {
            state.selectedStartHour = null;
            state.selectedEndHour = null;
            renderTimeSlots();
            timeSection.style.display = 'block';
            statusSection.style.display = 'none';
            noteSection.style.display = 'none';
            submitBtn.disabled = true;
        }
    });

    function resetForm() {
        state.serviceItemId = null;
        state.serviceType = null;
        state.selectedDate = null;
        state.selectedStartHour = null;
        state.selectedEndHour = null;

        serviceItemInput.value = '';
        dateTimeInput.value = '';
        endTimeInput.value = '';

        typeInfoBox.style.display = 'none';
        datePickerTrigger.style.opacity = '0.5';
        datePickerTrigger.style.pointerEvents = 'none';
        datePickerText.textContent = 'ابتدا آیتم خدمت را انتخاب کنید';
        datePickerText.className = 'placeholder';

        timeSection.style.display = 'none';
        statusSection.style.display = 'none';
        noteSection.style.display = 'none';
        submitBtn.disabled = true;
    }

    // ============================================================
    // Modal
    // ============================================================
    datePickerTrigger.addEventListener('click', () => {
        if (!state.serviceItemId) return;

        // اگه تاریخ انتخاب شده، بریم به همون ماه
        if (state.selectedDate) {
            state.currentYear = state.selectedDate.year;
            state.currentMonth = state.selectedDate.month;
        }

        state.tempSelectedDate = state.selectedDate ? { ...state.selectedDate } : null;
        renderCalendar();
        calendarModal.classList.add('active');
        lucide.createIcons();
    });

    document.getElementById('closeCalendar').addEventListener('click', () => {
        calendarModal.classList.remove('active');
    });

    calendarModal.addEventListener('click', (e) => {
        if (e.target === calendarModal) calendarModal.classList.remove('active');
    });

    document.getElementById('prevMonth').addEventListener('click', () => {
        state.currentMonth--;
        if (state.currentMonth < 0) {
            state.currentMonth = 11;
            state.currentYear--;
        }
        renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        state.currentMonth++;
        if (state.currentMonth > 11) {
            state.currentMonth = 0;
            state.currentYear++;
        }
        renderCalendar();
    });

    // ============================================================
    // رندر تقویم
    // ============================================================
    function renderCalendar() {
        const month = persianMonths[state.currentMonth];
        monthTitle.textContent = `${month.name} ${state.currentYear}`;

        calendarDays.innerHTML = '';

        const gFirst = jalaliToGregorian(state.currentYear, state.currentMonth + 1, 1);
        const gDate = new Date(gFirst.gy, gFirst.gm - 1, gFirst.gd);

        let firstWeekday = gDate.getDay();
        firstWeekday = (firstWeekday + 1) % 7;

        for (let i = 0; i < firstWeekday; i++) {
            const empty = document.createElement('div');
            empty.className = 'cal-day empty';
            calendarDays.appendChild(empty);
        }

        for (let d = 1; d <= month.days; d++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'cal-day';
            dayEl.dataset.day = d;

            const g = jalaliToGregorian(state.currentYear, state.currentMonth + 1, d);
            const jsDate = new Date(g.gy, g.gm - 1, g.gd);

            const isToday = (state.currentYear === todayJalali.year && state.currentMonth === todayJalali.month && d === todayJalali.day);
            if (isToday) dayEl.classList.add('today');

            const weekday = (jsDate.getDay() + 1) % 7;
            if (weekday === 6) dayEl.classList.add('holiday');

            // در edit، تاریخ گذشته غیرفعال نمی‌شه (چون ممکنه رکورد قبلی باشه)
            // فقط اگه بخوای می‌تونی فعال کنی

            if (state.tempSelectedDate && state.tempSelectedDate.year === state.currentYear && state.tempSelectedDate.month === state.currentMonth && state.tempSelectedDate.day === d) {
                dayEl.classList.add('selected');
            }

            dayEl.innerHTML = `<span class="num">${d}</span><span class="mname">${month.name.slice(0, 3)}</span>`;

            dayEl.addEventListener('click', () => {
                selectDate(d, month.name, jsDate, g);
            });

            calendarDays.appendChild(dayEl);
        }
    }

    function selectDate(day, monthName, jsDate, g) {
        const iso = `${g.gy}-${String(g.gm).padStart(2, '0')}-${String(g.gd).padStart(2, '0')}`;

        state.tempSelectedDate = {
            year: state.currentYear,
            month: state.currentMonth,
            day: day,
            monthName: monthName,
            jsDate: jsDate,
            iso: iso,
        };
        renderCalendar();

        calendarInfo.textContent = `${day} ${monthName} ${state.currentYear}`;
        confirmDate.disabled = false;
    }

    confirmDate.addEventListener('click', () => {
        if (!state.tempSelectedDate) return;

        state.selectedDate = { ...state.tempSelectedDate };

        datePickerText.textContent = `${state.selectedDate.day} ${state.selectedDate.monthName} ${state.selectedDate.year}`;
        datePickerText.className = 'value';
        datePickerTrigger.classList.add('active');

        calendarModal.classList.remove('active');

        renderTimeSlots();
        timeSection.style.display = 'block';
        statusSection.style.display = 'none';
        noteSection.style.display = 'none';
        submitBtn.disabled = true;
        state.selectedStartHour = null;
        state.selectedEndHour = null;
    });

    // ============================================================
    // اسلات‌های زمانی
    // ============================================================
    function renderTimeSlots() {
        slotsContainer.innerHTML = '';

        if (state.serviceType === 'shift') {
            SHIFTS.forEach(shift => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'slot-btn';
                btn.dataset.start = shift.start;
                btn.dataset.end = shift.end;
                btn.innerHTML = `
                    <span class="slot-time">${shift.label}</span>
                    <span class="slot-status">${shift.start} - ${shift.end}</span>
                `;
                btn.addEventListener('click', () => {
                    selectShift(shift);
                });
                slotsContainer.appendChild(btn);
            });
        } else {
            SHIFTS.forEach(shift => {
                const header = document.createElement('div');
                header.style.gridColumn = '1 / -1';
                header.style.color = '#94a3b8';
                header.style.fontSize = '12px';
                header.style.fontWeight = '700';
                header.style.marginTop = '6px';
                header.innerHTML = `ساعت‌های ${shift.label}`;
                slotsContainer.appendChild(header);

                shift.slots.forEach(hour => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'slot-btn';
                    btn.dataset.hour = hour;
                    btn.innerHTML = `
                        <span class="slot-time">${hour}:۰۰</span>
                        <span class="slot-status">${hour + 1}:۰۰</span>
                    `;
                    btn.addEventListener('click', () => {
                        selectHour(hour);
                    });
                    slotsContainer.appendChild(btn);
                });
            });
        }
    }

    function selectShift(shift) {
        slotsContainer.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));

        const selected = slotsContainer.querySelector(`.slot-btn[data-start="${shift.start}"]`);
        if (selected) selected.classList.add('selected');

        state.selectedStartHour = shift.start;
        state.selectedEndHour = shift.end;

        updateHiddenInputs();
        statusSection.style.display = 'block';
        noteSection.style.display = 'block';
        submitBtn.disabled = false;
        lucide.createIcons();
    }

    function selectHour(hour) {
        const shift = SHIFTS.find(s => s.slots.includes(hour));
        if (!shift) return;

        slotsContainer.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));

        if (state.selectedStartHour === null || !shift.slots.includes(state.selectedStartHour)) {
            state.selectedStartHour = hour;
            state.selectedEndHour = null;
        } else if (state.selectedEndHour === null) {
            if (hour < state.selectedStartHour) {
                [state.selectedStartHour, hour] = [hour, state.selectedStartHour];
            }
            state.selectedEndHour = hour + 1;
        } else {
            state.selectedStartHour = hour;
            state.selectedEndHour = null;
        }

        const start = state.selectedStartHour;
        const end = state.selectedEndHour !== null ? state.selectedEndHour : start + 1;

        shift.slots.forEach(h => {
            if (h >= start && h < end) {
                const btn = slotsContainer.querySelector(`.slot-btn[data-hour="${h}"]`);
                if (btn) btn.classList.add('selected');
            }
        });

        if (state.selectedEndHour !== null) {
            updateHiddenInputs();
            statusSection.style.display = 'block';
            noteSection.style.display = 'block';
            submitBtn.disabled = false;
        } else {
            statusSection.style.display = 'none';
            noteSection.style.display = 'none';
            submitBtn.disabled = true;
        }

        lucide.createIcons();
    }

    // ============================================================
    // input hidden
    // ============================================================
    function updateHiddenInputs() {
        if (!state.selectedDate || state.selectedStartHour === null) return;

        const d = state.selectedDate;
        const startH = String(state.selectedStartHour).padStart(2, '0');
        const endH = state.selectedEndHour !== null ? String(state.selectedEndHour).padStart(2, '0') : String(state.selectedStartHour + 1).padStart(2, '0');

        dateTimeInput.value = `${d.iso}T${startH}:00`;
        endTimeInput.value = `${d.iso}T${endH}:00`;
    }

    // ============================================================
    // وضعیت
    // ============================================================
    document.querySelectorAll('.status-card').forEach(card => {
        card.addEventListener('click', function () {
            document.querySelectorAll('.status-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            statusInput.value = this.dataset.status;
        });
    });

</script>

@endsection