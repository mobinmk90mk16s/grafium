<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>رزرو {{ $item->title }} | GRAFIUM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --deep-navy: #0a1628;
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
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font: "Vazirmatn", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #132238;
            --text: #f0f0f0;
            --text-muted: #a0a0a0;
            --border: #1a2f4a;
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        }

        body {
            font-family: var(--font);
            background: var(--bg-body);
            color: var(--text);
            direction: rtl;
            transition: background 0.4s, color 0.4s;
            line-height: 1.7;
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .container-wide { max-width: 1600px; margin: 0 auto; padding: 0 20px; }

        /* ===== HEADER ===== */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212, 163, 115, 0.15);
            padding: 8px 0;
        }
        [data-theme="light"] .header {
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid var(--border);
        }
        .header-inner { display: flex; align-items: center; justify-content: space-between; }
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo-img { height: 50px; width: auto; }
        .nav-desktop ul { display: flex; gap: 28px; }
        .nav-desktop a {
            font-weight: 500; font-size: 15px;
            color: rgba(255, 255, 255, 0.7);
            transition: color 0.3s;
        }
        [data-theme="light"] .nav-desktop a { color: var(--deep-navy); }
        .nav-desktop a:hover, .nav-desktop a.active { color: var(--gold); }
        .header-actions { display: flex; align-items: center; gap: 12px; }
        .theme-toggle {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: transparent; color: #fff; cursor: pointer;
            font-size: 18px; display: flex; align-items: center; justify-content: center;
        }
        [data-theme="light"] .theme-toggle { border-color: var(--border); color: var(--deep-navy); }
        .theme-toggle:hover { border-color: var(--gold); color: var(--gold); }
        .menu-toggle { display: none; font-size: 24px; background: none; border: none; color: #fff; cursor: pointer; }
        [data-theme="light"] .menu-toggle { color: var(--deep-navy); }

        /* ===== BREADCRUMB ===== */
        .breadcrumb-bar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
        }
        .breadcrumb {
            display: flex; align-items: center; gap: 10px;
            font-size: 14px; color: var(--text-muted); flex-wrap: wrap;
        }
        .breadcrumb a { color: var(--text-muted); transition: color 0.3s; display: inline-flex; align-items: center; gap: 6px; }
        .breadcrumb a:hover { color: var(--gold); }
        .breadcrumb i { font-size: 12px; }
        .breadcrumb .current { color: var(--text); font-weight: 600; }

        /* ===== RESERVE PAGE ===== */
        .reserve-page { padding: 40px 0 60px; }

        .reserve-header {
            display: flex; align-items: center; gap: 20px;
            margin-bottom: 30px;
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px solid var(--border);
            padding: 24px;
            box-shadow: var(--shadow);
            flex-wrap: wrap;
        }
        .reserve-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: var(--gold-gradient);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 30px;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.3);
            flex-shrink: 0;
        }
        .reserve-info { flex: 1; min-width: 200px; }
        .reserve-info h1 { font-size: 26px; font-weight: 800; margin-bottom: 6px; }
        .reserve-info p { font-size: 14px; color: var(--text-muted); }
        .reserve-info .service-name { color: var(--gold-dark); font-weight: 700; }
        [data-theme="dark"] .reserve-info .service-name { color: var(--gold); }

        .type-indicator {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px; border-radius: 9999px;
            font-size: 12px; font-weight: 700;
        }
        .type-shift { background: rgba(96, 165, 250, 0.15); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.3); }
        .type-hourly { background: rgba(167, 139, 250, 0.15); color: #a78bfa; border: 1px solid rgba(167, 139, 250, 0.3); }

        /* ===== WRAPPER ===== */
        .reserve-wrapper {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 24px;
            align-items: start;
        }
        .reserve-wrapper.hourly-layout { grid-template-columns: 1fr 280px; }

        /* ===== TABLE BOX ===== */
        .table-box {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        .table-box-header {
            background: var(--navy-gradient);
            color: #fff;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .table-box-header h3 {
            font-size: 17px; font-weight: 700;
            display: flex; align-items: center; gap: 10px;
        }
        .table-box-header h3 i { color: var(--gold); }
        .table-box-header .hint { font-size: 12px; color: rgba(255,255,255,0.6); }

        .table-scroll {
            max-height: 640px;
            overflow: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--gold) transparent;
        }
        .table-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
        .table-scroll::-webkit-scrollbar-track { background: transparent; }
        .table-scroll::-webkit-scrollbar-thumb {
            background: rgba(212, 163, 115, 0.4);
            border-radius: 4px;
        }
        .table-scroll::-webkit-scrollbar-thumb:hover { background: rgba(212, 163, 115, 0.7); }

        .reserve-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .reserve-table thead {
            background: var(--bg-body);
            position: sticky; top: 0; z-index: 5;
        }
        .reserve-table th {
            padding: 14px 6px;
            font-weight: 700;
            color: var(--text);
            border-bottom: 2px solid var(--gold);
            text-align: center;
            font-size: 12px;
            white-space: nowrap;
        }
        .reserve-table td {
            padding: 8px 4px;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }
        .reserve-table tbody tr:hover { background: rgba(212, 163, 115, 0.04); }

        /* جدول ساعتی */
        .reserve-table.hourly-table { table-layout: fixed; }
        .reserve-table.hourly-table th:first-child,
        .reserve-table.hourly-table td:first-child { width: 135px; }
        .reserve-table.hourly-table th,
        .reserve-table.hourly-table td { padding: 6px 2px; }
        .reserve-table.hourly-table .hour-cell {
            min-width: 0;
            padding: 8px 2px;
            font-size: 11px;
            border-width: 1.5px;
        }

        /* جدول شیفتی */
        .reserve-table.shift-table { table-layout: fixed; }
        .reserve-table.shift-table th:first-child,
        .reserve-table.shift-table td:first-child { width: 160px; }
        .reserve-table.shift-table th,
        .reserve-table.shift-table td { padding: 10px 8px; }

        /* DATE CELL */
        .date-cell {
            font-weight: 600;
            font-size: 12px;
            color: var(--text);
            white-space: nowrap;
            text-align: right !important;
            position: sticky;
            right: 0;
            background: var(--bg-card);
            z-index: 2;
            border-left: 1px solid var(--border);
            padding: 8px 10px !important;
        }
        .date-cell.today { color: var(--gold-dark); }
        [data-theme="dark"] .date-cell.today { color: var(--gold); }
        .date-cell.holiday { color: #fb7185; }
        .date-cell .date-line { display: block; font-size: 12px; font-weight: 700; }
        .date-cell .weekday-line { display: block; font-size: 10px; color: var(--text-muted); margin-top: 2px; }

        /* SHIFT CELLS */
        .shift-cell {
            border-radius: 8px;
            padding: 12px 8px;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
            gap: 3px;
            align-items: center;
        }
        .shift-cell .label { font-size: 12px; font-weight: 700; }
        .shift-cell .time { font-size: 10px; opacity: 0.75; }

        /* HOUR CELLS */
        .hour-cell {
            border-radius: 6px;
            padding: 10px 2px;
            font-weight: 700;
            font-size: 11px;
            transition: all 0.2s;
            cursor: pointer;
            border: 1.5px solid transparent;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* STATUS */
        .status-available {
            background: rgba(52, 211, 153, 0.1);
            color: #34d399;
            border-color: rgba(52, 211, 153, 0.3);
        }
        .status-available:hover {
            background: rgba(52, 211, 153, 0.2);
            transform: scale(1.04);
        }
        .status-reserved {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
            border-color: rgba(251, 191, 36, 0.3);
            cursor: not-allowed;
        }
        .status-maintenance {
            background: rgba(251, 113, 133, 0.15);
            color: #fb7185;
            border-color: rgba(251, 113, 133, 0.3);
            cursor: not-allowed;
        }
        .status-blocked {
            background: rgba(148, 163, 184, 0.15);
            color: #94a3b8;
            border-color: rgba(148, 163, 184, 0.3);
            cursor: not-allowed;
        }
        .status-expired {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
            border-color: rgba(107, 114, 128, 0.2);
            cursor: not-allowed;
            opacity: 0.6;
        }
        .status-holiday {
            background: rgba(244, 63, 94, 0.08);
            color: #fb7185;
            border-color: rgba(244, 63, 94, 0.15);
            cursor: not-allowed;
            font-size: 10px;
        }
        .status-selected {
            background: var(--gold-gradient);
            color: #fff;
            border-color: var(--gold);
            transform: scale(1.04);
            box-shadow: 0 4px 15px rgba(212, 163, 115, 0.4);
        }

        /* SUMMARY */
        .summary-box {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px solid var(--gold);
            padding: 24px;
            box-shadow: 0 8px 32px rgba(212, 163, 115, 0.1);
            position: sticky;
            top: 100px;
        }
        .summary-title {
            font-size: 18px; font-weight: 800;
            color: var(--gold-dark);
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        [data-theme="dark"] .summary-title { color: var(--gold); }

        .summary-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 10px 0; font-size: 14px;
        }
        .summary-row .label { color: var(--text-muted); }
        .summary-row .value { font-weight: 700; color: var(--text); }
        .summary-row .value.gold { color: var(--gold-dark); font-size: 16px; }
        [data-theme="dark"] .summary-row .value.gold { color: var(--gold); }

        .summary-divider {
            border: none;
            border-top: 1px dashed var(--border);
            margin: 16px 0;
        }

        .summary-btn {
            width: 100%; padding: 14px;
            border-radius: 12px; border: none;
            background: var(--gold-gradient); color: #fff;
            font-family: var(--font);
            font-size: 15px; font-weight: 700;
            cursor: pointer; transition: var(--transition);
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 8px;
        }
        .summary-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(212, 163, 115, 0.35);
        }
        .summary-btn:disabled { opacity: 0.5; cursor: not-allowed; }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .reserve-wrapper,
            .reserve-wrapper.hourly-layout { grid-template-columns: 1fr 260px; }
            .reserve-table.hourly-table .hour-cell { font-size: 10px; padding: 6px 1px; }
            .reserve-table.hourly-table th:first-child,
            .reserve-table.hourly-table td:first-child { width: 120px; }
        }
        @media (max-width: 1000px) {
            .reserve-wrapper,
            .reserve-wrapper.hourly-layout { grid-template-columns: 1fr; }
            .summary-box { position: static; }
        }
        @media (max-width: 768px) {
            .container, .container-wide { padding: 0 12px; }
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .reserve-header { padding: 18px; }
            .reserve-icon { width: 56px; height: 56px; font-size: 24px; }
            .reserve-info h1 { font-size: 20px; }
            .reserve-table th, .reserve-table td { font-size: 10px; padding: 4px 2px; }
            .date-cell { font-size: 10px !important; padding: 6px 6px !important; }
            .date-cell .date-line { font-size: 10px; }
            .date-cell .weekday-line { font-size: 8px; }
            .reserve-table.hourly-table th:first-child,
            .reserve-table.hourly-table td:first-child { width: 90px; }
            .reserve-table.hourly-table .hour-cell { font-size: 9px; padding: 5px 1px; }
        }
    </style>
</head>
<body>

    <!-- ===== HEADER ===== -->
    <header class="header">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium" class="logo-img" />
            </a>
            <nav class="nav-desktop">
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
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            </div>
        </div>
    </header>

    <!-- ===== BREADCRUMB ===== -->
    <div class="breadcrumb-bar">
        <div class="container-wide">
            <div class="breadcrumb">
                <a href="{{ route('home') }}"><i class="fas fa-home"></i> خانه</a>
                <i class="fas fa-chevron-left"></i>
                <a href="{{ route('services') }}">خدمات</a>
                <i class="fas fa-chevron-left"></i>
                <a href="{{ route('services.show', $service->id) }}">{{ $service->title }}</a>
                <i class="fas fa-chevron-left"></i>
                <span class="current">{{ $item->title }}</span>
            </div>
        </div>
    </div>

    <!-- ===== RESERVE PAGE ===== -->
    <section class="reserve-page">
        <div class="container-wide">

            <div class="reserve-header">
                <div class="reserve-icon">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="reserve-info">
                    <h1>{{ $item->title }}</h1>
                    <p>
                        <span class="service-name">{{ $service->title }}</span>
                        @if($item->place)
                            • <i class="fas fa-map-marker-alt"></i> {{ $item->place }}
                        @endif
                    </p>
                </div>
                <div>
                    @if($service->type === 'shift')
                        <span class="type-indicator type-shift"><i class="fas fa-clock"></i> تعرفه شیفتی</span>
                    @else
                        <span class="type-indicator type-hourly"><i class="fas fa-hourglass-half"></i> تعرفه ساعتی</span>
                    @endif
                </div>
            </div>

            <div class="reserve-wrapper {{ $service->type === 'hourly' ? 'hourly-layout' : '' }}">

                <div class="table-box">
                    <div class="table-box-header">
                        <h3>
                            <i class="fas fa-calendar-alt"></i>
                            @if($service->type === 'shift')
                                انتخاب شیفت
                            @else
                                انتخاب ساعت
                            @endif
                        </h3>
                        <span class="hint">۳۰ روز آینده</span>
                    </div>

                    <div class="table-scroll">
                        @if($service->type === 'shift')
                            {{-- ===== جدول شیفتی ===== --}}
                            <table class="reserve-table shift-table">
                                <thead>
                                    <tr>
                                        <th style="text-align: right;">تاریخ</th>
                                        @foreach($shifts as $shift)
                                            <th>
                                                {{ $shift['label'] }}
                                                <div style="font-size:10px; opacity:0.6; font-weight:500; margin-top:2px;">
                                                    {{ $shift['time'] }}
                                                </div>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($days as $day)
                                        <tr>
                                            <td class="date-cell {{ $day['is_today'] ? 'today' : '' }} {{ $day['is_holiday'] ? 'holiday' : '' }}">
                                                <span class="date-line">{{ $day['jalali_day'] }} {{ $day['jalali_month_name'] }}</span>
                                                <span class="weekday-line">{{ $day['weekday_name'] }} @if($day['is_today']) • امروز @endif</span>
                                            </td>

                                            @foreach($shifts as $shift)
                                                @php
                                                    $dateKey = $day['iso'];
                                                    $shiftKey = $shift['key'];

                                                    $expired = false;
                                                    if ($day['is_today']) {
                                                        $currentHour = $now->hour;
                                                        if ($currentHour >= $shift['end_hour']) {
                                                            $expired = true;
                                                        }
                                                    }

                                                    // ✅ فقط از دیتابیس
                                                    $sch = $scheduleMap[$dateKey][$shiftKey] ?? null;

                                                    if ($day['is_holiday']) {
                                                        $cellClass = 'status-holiday';
                                                        $cellText = 'تعطیل';
                                                        $cellTime = '';
                                                        $selectable = false;
                                                    } elseif ($expired) {
                                                        $cellClass = 'status-expired';
                                                        $cellText = 'منقضی';
                                                        $cellTime = '';
                                                        $selectable = false;
                                                    } elseif ($sch === null) {
                                                        $cellClass = 'status-blocked';
                                                        $cellText = '—';
                                                        $cellTime = '';
                                                        $selectable = false;
                                                    } else {
                                                        $status = $sch['status'];

                                                        switch ($status) {
                                                            case 'available':
                                                                $cellClass = 'status-available';
                                                                $cellText = 'قابل رزرو';
                                                                break;
                                                            case 'reserved':
                                                                $cellClass = 'status-reserved';
                                                                $cellText = 'رزرو شده';
                                                                break;
                                                            case 'maintenance':
                                                                $cellClass = 'status-maintenance';
                                                                $cellText = 'تعمیرات';
                                                                break;
                                                            case 'blocked':
                                                                $cellClass = 'status-blocked';
                                                                $cellText = 'مسدود';
                                                                break;
                                                            default:
                                                                $cellClass = 'status-blocked';
                                                                $cellText = '—';
                                                        }
                                                        $cellTime = $shift['time'];
                                                        $selectable = ($status === 'available');
                                                    }
                                                @endphp
                                                <td>
                                                    <div
                                                        class="shift-cell {{ $cellClass }}"
                                                        data-date="{{ $day['iso'] }}"
                                                        data-shift="{{ $shift['key'] }}"
                                                        data-type="shift"
                                                        data-price="{{ $shiftPrice }}"
                                                        data-selectable="{{ $selectable ? '1' : '0' }}"
                                                    >
                                                        <span class="label">{{ $cellText }}</span>
                                                        @if($cellTime)
                                                            <span class="time">{{ $cellTime }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            {{-- ===== جدول ساعتی ===== --}}
                            <table class="reserve-table hourly-table">
                                <thead>
                                    <tr>
                                        <th style="text-align: right;">تاریخ</th>
                                        @foreach($hourlySlots as $hour)
                                            <th>{{ $hour }}:۰۰</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($days as $day)
                                        <tr>
                                            <td class="date-cell {{ $day['is_today'] ? 'today' : '' }} {{ $day['is_holiday'] ? 'holiday' : '' }}">
                                                <span class="date-line">{{ $day['jalali_day'] }} {{ $day['jalali_month_name'] }}</span>
                                                <span class="weekday-line">{{ $day['weekday_name'] }} @if($day['is_today']) • امروز @endif</span>
                                            </td>

                                            @foreach($hourlySlots as $hour)
                                                @php
                                                    $dateKey = $day['iso'];

                                                    $expired = false;
                                                    if ($day['is_today']) {
                                                        $currentHour = $now->hour;
                                                        if ($currentHour >= ($hour + 1)) {
                                                            $expired = true;
                                                        }
                                                    }

                                                    // ✅ فقط از دیتابیس
                                                    $sch = $scheduleMap[$dateKey][$hour] ?? null;

                                                    if ($day['is_holiday']) {
                                                        $cellClass = 'status-holiday';
                                                        $cellText = '—';
                                                        $selectable = false;
                                                    } elseif ($expired) {
                                                        $cellClass = 'status-expired';
                                                        $cellText = '—';
                                                        $selectable = false;
                                                    } elseif ($sch === null) {
                                                        $cellClass = 'status-blocked';
                                                        $cellText = '—';
                                                        $selectable = false;
                                                    } else {
                                                        $status = $sch['status'];

                                                        switch ($status) {
                                                            case 'available':
                                                                $cellClass = 'status-available';
                                                                $cellText = 'آزاد';
                                                                break;
                                                            case 'reserved':
                                                                $cellClass = 'status-reserved';
                                                                $cellText = 'پر';
                                                                break;
                                                            case 'maintenance':
                                                                $cellClass = 'status-maintenance';
                                                                $cellText = 'تعمیر';
                                                                break;
                                                            case 'blocked':
                                                                $cellClass = 'status-blocked';
                                                                $cellText = '×';
                                                                break;
                                                            default:
                                                                $cellClass = 'status-blocked';
                                                                $cellText = '—';
                                                        }
                                                        $selectable = ($status === 'available');
                                                    }
                                                @endphp
                                                <td>
                                                    <div
                                                        class="hour-cell {{ $cellClass }}"
                                                        data-date="{{ $day['iso'] }}"
                                                        data-hour="{{ $hour }}"
                                                        data-type="hourly"
                                                        data-price="{{ $hourlyPrice }}"
                                                        data-selectable="{{ $selectable ? '1' : '0' }}"
                                                    >
                                                        {{ $cellText }}
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <div class="summary-box">
                    <h3 class="summary-title">
                        <i class="fas fa-receipt"></i>
                        خلاصه رزرو
                    </h3>

                    <div class="summary-row">
                        <span class="label">
                            @if($service->type === 'shift')
                                تعداد شیفت:
                            @else
                                تعداد ساعت:
                            @endif
                        </span>
                        <span class="value" id="selectedCount">۰</span>
                    </div>

                    <div class="summary-row">
                        <span class="label">تعرفه:</span>
                        <span class="value">
                            @if($service->type === 'shift')
                                {{ number_format($shiftPrice) }} تومان / شیفت
                            @else
                                {{ number_format($hourlyPrice) }} تومان / ساعت
                            @endif
                        </span>
                    </div>

                    @if($pricingPlan)
                    <div class="summary-row">
                        <span class="label">پلن:</span>
                        <span class="value">{{ $pricingPlan->title }}</span>
                    </div>
                    @endif

                    <hr class="summary-divider" />

                    <div class="summary-row">
                        <span class="label">مبلغ کل:</span>
                        <span class="value gold" id="totalPrice">۰ تومان</span>
                    </div>

                    <button class="summary-btn" id="payBtn" disabled>
                        <i class="fas fa-credit-card"></i>
                        پرداخت و رزرو
                    </button>
                </div>

            </div>
        </div>
    </section>

    <script>
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

        (function() {
            const serviceType = "{{ $service->type }}";
            const unitPrice = serviceType === 'shift' ? Number("{{ $shiftPrice }}") : Number("{{ $hourlyPrice }}");
            const selectedCells = new Set();

            const selectedCountEl = document.getElementById('selectedCount');
            const totalPriceEl = document.getElementById('totalPrice');
            const payBtn = document.getElementById('payBtn');

            function formatNumber(n) { return n.toLocaleString('fa-IR'); }

            function updateSummary() {
                const count = selectedCells.size;
                const total = count * unitPrice;
                selectedCountEl.textContent = formatNumber(count);
                totalPriceEl.textContent = formatNumber(total) + ' تومان';
                payBtn.disabled = count === 0;
            }

            function getCellKey(cell) {
                if (cell.dataset.type === 'shift') {
                    return cell.dataset.date + '|shift|' + cell.dataset.shift;
                }
                return cell.dataset.date + '|hourly|' + cell.dataset.hour;
            }

            function toggleCell(cell) {
                const key = getCellKey(cell);

                if (selectedCells.has(key)) {
                    selectedCells.delete(key);
                    cell.classList.remove('status-selected');
                    cell.classList.add('status-available');
                    if (cell.dataset.type === 'shift') {
                        cell.innerHTML = '<span class="label">قابل رزرو</span>';
                    } else {
                        cell.textContent = 'آزاد';
                    }
                } else {
                    selectedCells.add(key);
                    cell.classList.remove('status-available');
                    cell.classList.add('status-selected');
                    if (cell.dataset.type === 'shift') {
                        cell.innerHTML = '<span class="label">انتخاب ✓</span>';
                    } else {
                        cell.textContent = '✓';
                    }
                }

                updateSummary();
            }

            document.querySelectorAll('.shift-cell[data-selectable="1"], .hour-cell[data-selectable="1"]').forEach(cell => {
                cell.addEventListener('click', () => toggleCell(cell));
            });

            payBtn.addEventListener('click', () => {
                if (selectedCells.size === 0) return;

                const cells = Array.from(selectedCells).map(k => {
                    const [date, type, value] = k.split('|');
                    return { date, type, value };
                });

                alert(
                    'رزرو شما آماده ثبت است!\n\n' +
                    'تعداد: ' + selectedCells.size + '\n' +
                    'مبلغ کل: ' + formatNumber(selectedCells.size * unitPrice) + ' تومان\n\n' +
                    '⚠️ این بخش در فاز بعدی به درگاه پرداخت متصل می‌شود.'
                );

                console.log('Selected cells:', cells);
            });

            updateSummary();
        })();

        console.log('✅ Reserve page loaded successfully!');
    </script>

</body>
</html>
