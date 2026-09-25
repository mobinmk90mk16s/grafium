<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>رزرو {{ $item->title }} | GRAFIUM</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --deep-navy: #0a1628;
            --navy-800: #0f1f33;
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
            --font: "Vazirmatn", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #0f1f33;
            --text: #f0f0f0;
            --text-muted: #94a3b8;
            --border: #1a2f4a;
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        }

        body {
            font-family: var(--font);
            background: var(--bg-body);
            color: var(--text);
            direction: rtl;
            line-height: 1.7;
            min-height: 100vh;
            transition: background 0.4s, color 0.4s;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .container-wide { max-width: 1600px; margin: 0 auto; padding: 0 20px; }

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

        /* ===== STATUS ===== */
        .status-available {
            background: rgba(52, 211, 153, 0.1);
            color: #34d399;
            border-color: rgba(52, 211, 153, 0.3);
        }
        .status-available:hover {
            background: rgba(52, 211, 153, 0.2);
            transform: scale(1.04);
        }

        /* در حال رزرو توسط دیگران - نارنجی */
        .status-pending-other {
            background: rgba(251, 146, 60, 0.15);
            color: #fb923c;
            border-color: rgba(251, 146, 60, 0.3);
            cursor: not-allowed;
        }

        /* در حال رزرو برای شما - زرد */
        .status-pending-mine {
            background: rgba(250, 204, 21, 0.18);
            color: #facc15;
            border-color: rgba(250, 204, 21, 0.4);
            cursor: not-allowed;
        }

        /* رزرو شده نهایی */
        .status-reserved {
            background: rgba(244, 63, 94, 0.15);
            color: #fb7185;
            border-color: rgba(244, 63, 94, 0.3);
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

        /* ===== SUMMARY BOX ===== */
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
            cursor: pointer; transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 8px;
            box-shadow: 0 8px 24px rgba(212, 163, 115, 0.3);
        }
        .summary-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(212, 163, 115, 0.45);
        }
        .summary-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .summary-btn.loading { pointer-events: none; opacity: 0.7; }

        /* ===== GUEST OVERLAY ===== */
        .guest-overlay {
            position: fixed; inset: 0;
            background: rgba(10, 22, 40, 0.4);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 5000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.4s;
        }
        .guest-overlay.active {
            display: flex;
            opacity: 1;
        }
        .guest-modal {
            background: var(--bg-card);
            border-radius: 24px;
            padding: 40px 32px;
            max-width: 440px;
            width: 100%;
            text-align: center;
            border: 2px solid var(--gold);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
            transform: scale(0.9);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .guest-overlay.active .guest-modal { transform: scale(1); }

        .guest-icon {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #fff; font-size: 34px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 22px;
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.4);
        }
        .guest-modal h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 10px;
        }
        .guest-modal p {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 24px;
            line-height: 1.8;
        }
        .guest-modal .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px 24px;
            border-radius: 14px;
            background: var(--gold-gradient);
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.35);
            font-family: inherit;
            margin-bottom: 10px;
        }
        .guest-modal .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 45px rgba(212, 163, 115, 0.5);
        }
        .guest-modal .btn-secondary {
            background: transparent;
            color: var(--text-muted);
            box-shadow: none;
            font-size: 13px;
            padding: 10px;
        }
        .guest-modal .btn-secondary:hover {
            color: var(--gold);
            box-shadow: none;
            transform: none;
        }

        /* ===== RESPONSIVE ===== */
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

    @include('partials.header')

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

            <!-- ===== HEADER ===== -->
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

            <!-- ===== WRAPPER ===== -->
            <div class="reserve-wrapper {{ $service->type === 'hourly' ? 'hourly-layout' : '' }}">

                <!-- ===== TABLE ===== -->
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

                                                    $sch = $scheduleMap[$dateKey][$shiftKey] ?? null;

                                                    if ($day['is_holiday']) {
                                                        $cellClass = 'status-holiday';
                                                        $cellText = 'تعطیل';
                                                        $cellTime = '';
                                                        $selectable = false;
                                                        $schedulingId = null;
                                                        $status = 'holiday';
                                                    } elseif ($expired) {
                                                        $cellClass = 'status-expired';
                                                        $cellText = 'منقضی';
                                                        $cellTime = '';
                                                        $selectable = false;
                                                        $schedulingId = null;
                                                        $status = 'expired';
                                                    } elseif ($sch === null) {
                                                        $cellClass = 'status-blocked';
                                                        $cellText = '—';
                                                        $cellTime = '';
                                                        $selectable = false;
                                                        $schedulingId = null;
                                                        $status = 'none';
                                                    } else {
                                                        $status = $sch['status'];
                                                        $schedulingId = $sch['id'];
                                                        $isMine = $sch['is_mine'] ?? false;

                                                        if ($status === 'available') {
                                                            $cellClass = 'status-available';
                                                            $cellText = 'قابل رزرو';
                                                            $selectable = true;
                                                        } elseif ($status === 'pending') {
                                                            if ($isMine) {
                                                                $cellClass = 'status-pending-mine';
                                                                $cellText = 'در حال رزرو برای شما';
                                                            } else {
                                                                $cellClass = 'status-pending-other';
                                                                $cellText = 'در حال رزرو';
                                                            }
                                                            $selectable = false;
                                                        } elseif ($status === 'reserved') {
                                                            $cellClass = 'status-reserved';
                                                            $cellText = 'رزرو شده';
                                                            $selectable = false;
                                                        } elseif ($status === 'maintenance') {
                                                            $cellClass = 'status-maintenance';
                                                            $cellText = 'تعمیرات';
                                                            $selectable = false;
                                                        } elseif ($status === 'blocked') {
                                                            $cellClass = 'status-blocked';
                                                            $cellText = 'مسدود';
                                                            $selectable = false;
                                                        } else {
                                                            $cellClass = 'status-blocked';
                                                            $cellText = '—';
                                                            $selectable = false;
                                                        }
                                                        $cellTime = $shift['time'];
                                                    }
                                                @endphp
                                                <td>
                                                    <div
                                                        class="shift-cell {{ $cellClass }}"
                                                        data-date="{{ $day['iso'] }}"
                                                        data-shift="{{ $shift['key'] }}"
                                                        data-type="shift"
                                                        data-scheduling-id="{{ $schedulingId }}"
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

                                                    $sch = $scheduleMap[$dateKey][$hour] ?? null;

                                                    if ($day['is_holiday']) {
                                                        $cellClass = 'status-holiday';
                                                        $cellText = '—';
                                                        $selectable = false;
                                                        $schedulingId = null;
                                                        $status = 'holiday';
                                                    } elseif ($expired) {
                                                        $cellClass = 'status-expired';
                                                        $cellText = '—';
                                                        $selectable = false;
                                                        $schedulingId = null;
                                                        $status = 'expired';
                                                    } elseif ($sch === null) {
                                                        $cellClass = 'status-blocked';
                                                        $cellText = '—';
                                                        $selectable = false;
                                                        $schedulingId = null;
                                                        $status = 'none';
                                                    } else {
                                                        $status = $sch['status'];
                                                        $schedulingId = $sch['id'];
                                                        $isMine = $sch['is_mine'] ?? false;

                                                        if ($status === 'available') {
                                                            $cellClass = 'status-available';
                                                            $cellText = 'آزاد';
                                                            $selectable = true;
                                                        } elseif ($status === 'pending') {
                                                            if ($isMine) {
                                                                $cellClass = 'status-pending-mine';
                                                                $cellText = 'برای شما';
                                                            } else {
                                                                $cellClass = 'status-pending-other';
                                                                $cellText = 'در حال رزرو';
                                                            }
                                                            $selectable = false;
                                                        } elseif ($status === 'reserved') {
                                                            $cellClass = 'status-reserved';
                                                            $cellText = 'پر';
                                                            $selectable = false;
                                                        } elseif ($status === 'maintenance') {
                                                            $cellClass = 'status-maintenance';
                                                            $cellText = 'تعمیر';
                                                            $selectable = false;
                                                        } elseif ($status === 'blocked') {
                                                            $cellClass = 'status-blocked';
                                                            $cellText = '×';
                                                            $selectable = false;
                                                        } else {
                                                            $cellClass = 'status-blocked';
                                                            $cellText = '—';
                                                            $selectable = false;
                                                        }
                                                    }
                                                @endphp
                                                <td>
                                                    <div
                                                        class="hour-cell {{ $cellClass }}"
                                                        data-date="{{ $day['iso'] }}"
                                                        data-hour="{{ $hour }}"
                                                        data-type="hourly"
                                                        data-scheduling-id="{{ $schedulingId }}"
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

                <!-- ===== SUMMARY ===== -->
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

                    <button class="summary-btn" id="addToCartBtn" disabled>
                        <i class="fas fa-cart-plus"></i>
                        <span>افزودن به سبد خرید</span>
                    </button>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== GUEST OVERLAY ===== -->
    @guest
    <div class="guest-overlay" id="guestOverlay">
        <div class="guest-modal">
            <div class="guest-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h3>ورود به حساب کاربری</h3>
            <p>برای مشاهده و رزرو زمان‌های موجود، لطفاً ابتدا وارد حساب کاربری خود شوید.</p>
            <button type="button" class="btn" id="guestLoginBtn">
                <i class="fas fa-sign-in-alt"></i>
                <span>ورود / ثبت‌نام</span>
            </button>
            <button type="button" class="btn btn-secondary" id="guestCancelBtn">
                بازگشت به صفحه قبل
            </button>
        </div>
    </div>
    @endguest

    <script>
        (function() {
            'use strict';

            const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
            const serviceType = "{{ $service->type }}";
            const unitPrice = serviceType === 'shift' ? Number("{{ $shiftPrice }}") : Number("{{ $hourlyPrice }}");

            const selectedCells = new Set();
            const selectedSchedulingIds = new Map(); // key -> scheduling_id

            const selectedCountEl = document.getElementById('selectedCount');
            const totalPriceEl = document.getElementById('totalPrice');
            const addToCartBtn = document.getElementById('addToCartBtn');

            // ============================================================
            // GUEST OVERLAY
            // ============================================================
            @guest
            const guestOverlay = document.getElementById('guestOverlay');
            const guestLoginBtn = document.getElementById('guestLoginBtn');
            const guestCancelBtn = document.getElementById('guestCancelBtn');

            // نمایش overlay بعد از ۵۰۰ میلی‌ثانیه
            setTimeout(() => {
                guestOverlay?.classList.add('active');
                document.body.style.overflow = 'hidden';
            }, 500);

            guestLoginBtn?.addEventListener('click', () => {
                window.location.href = '{{ route("home") }}?open_login=1';
            });

            guestCancelBtn?.addEventListener('click', () => {
                if (document.referrer) {
                    window.location.href = document.referrer;
                } else {
                    window.location.href = '{{ route("services.show", $service->id) }}';
                }
            });
            @endguest

            // ============================================================
            // HELPERS
            // ============================================================
            function formatNumber(n) {
                return Number(n).toLocaleString('fa-IR');
            }

            function getCellKey(cell) {
                if (cell.dataset.type === 'shift') {
                    return cell.dataset.date + '|shift|' + cell.dataset.shift;
                }
                return cell.dataset.date + '|hourly|' + cell.dataset.hour;
            }

            function updateSummary() {
                const count = selectedCells.size;
                const total = count * unitPrice;

                selectedCountEl.textContent = formatNumber(count);
                totalPriceEl.textContent = formatNumber(total) + ' تومان';
                addToCartBtn.disabled = count === 0;
            }

            // ============================================================
            // CELL SELECTION
            // ============================================================
            function toggleCell(cell) {
                if (!isAuthenticated) {
                    // برای مهمان، کلیک روی سلول هم overlay رو نشون میده
                    return;
                }

                const key = getCellKey(cell);
                const schedulingId = parseInt(cell.dataset.schedulingId);

                if (selectedCells.has(key)) {
                    selectedCells.delete(key);
                    selectedSchedulingIds.delete(key);
                    cell.classList.remove('status-selected');
                    cell.classList.add('status-available');
                    if (cell.dataset.type === 'shift') {
                        cell.innerHTML = '<span class="label">قابل رزرو</span>';
                    } else {
                        cell.textContent = 'آزاد';
                    }
                } else {
                    selectedCells.add(key);
                    selectedSchedulingIds.set(key, schedulingId);
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

            // اتصال کلیک به سلول‌های انتخابی
            document.querySelectorAll('.shift-cell[data-selectable="1"], .hour-cell[data-selectable="1"]').forEach(cell => {
                cell.addEventListener('click', () => toggleCell(cell));
            });

            // ============================================================
            // ADD TO CART
            // ============================================================
            addToCartBtn?.addEventListener('click', async () => {
                if (!isAuthenticated) {
                    window.location.href = '{{ route("home") }}?open_login=1';
                    return;
                }

                if (selectedCells.size === 0) return;

                const schedulingIds = Array.from(selectedSchedulingIds.values());

                addToCartBtn.disabled = true;
                addToCartBtn.classList.add('loading');
                addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>در حال افزودن...</span>';

                try {
                    const res = await fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ scheduling_ids: schedulingIds }),
                    });

                    const data = await res.json();

                    if (data.success) {
                        window.showAuthToast(data.message || 'به سبد خرید اضافه شد', 'success');

                        // بروزرسانی badge سبد
                        if (window.CartAPI) {
                            window.CartAPI.updateCartBadge(data.cart_count);
                        }

                        // پاک کردن انتخاب‌ها
                        selectedCells.clear();
                        selectedSchedulingIds.clear();

                        // رفرش سلول‌ها
                        document.querySelectorAll('.shift-cell, .hour-cell').forEach(cell => {
                            cell.classList.remove('status-selected');
                        });

                        // بعد از ۱ ثانیه، صفحه reload تا وضعیت درست بشه
                        setTimeout(() => window.location.reload(), 800);

                    } else {
                        window.showAuthToast(data.message || 'خطا در افزودن به سبد', 'error');

                        // اگه بعضی آیتم‌ها رزرو شدن، reload کن
                        if (res.status === 409) {
                            setTimeout(() => window.location.reload(), 1500);
                        }
                    }
                } catch (err) {
                    window.showAuthToast('خطا در ارتباط با سرور', 'error');
                } finally {
                    addToCartBtn.disabled = false;
                    addToCartBtn.classList.remove('loading');
                    addToCartBtn.innerHTML = '<i class="fas fa-cart-plus"></i><span>افزودن به سبد خرید</span>';
                }
            });

            // ============================================================
            // CANCEL HANDLER (وقتی آیتم از سبد حذف شد)
            // ============================================================
            window.onCartItemRemoved = function(schedulingId) {
                // پیدا کردن سلول مربوطه و رفرش
                setTimeout(() => window.location.reload(), 500);
            };

            // ============================================================
            // INIT
            // ============================================================
            updateSummary();

        })();
    </script>

</body>
</html>