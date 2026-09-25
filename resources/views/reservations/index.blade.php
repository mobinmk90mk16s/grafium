<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>رزروهای من | GRAFIUM</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --gold: #d4a373;
            --gold-dark: #b8874a;
            --gold-gradient: linear-gradient(135deg, #d4a373, #b8874a);
            --navy-gradient: linear-gradient(135deg, #0a1628, #1a2f4a);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --border: #e4e7ec;
            --shadow: 0 4px 30px rgba(10, 22, 40, 0.08);
            --radius: 20px;
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
        }

        a { text-decoration: none; color: inherit; }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        .page-header {
            background: var(--navy-gradient);
            padding: 60px 0 100px;
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at 80% 30%, rgba(212, 163, 115, 0.15), transparent 50%);
        }
        .page-header-content {
            position: relative; z-index: 1;
            text-align: center; color: #fff;
        }
        .page-header-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: var(--gold-gradient);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
            box-shadow: 0 0 50px rgba(212, 163, 115, 0.4);
            border: 3px solid rgba(255, 255, 255, 0.15);
        }
        .page-header h1 { font-size: 30px; font-weight: 800; margin-bottom: 8px; }
        .page-header p { color: rgba(255, 255, 255, 0.6); font-size: 14px; }

        .content-wrapper {
            margin-top: -50px;
            position: relative;
            z-index: 2;
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-title i { color: var(--gold); }

        .res-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            margin-bottom: 14px;
            transition: all 0.35s;
            overflow: hidden;
            position: relative;
            display: block;
        }
        .res-card:hover {
            transform: translateX(-6px);
            border-color: var(--gold);
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.15);
        }
        .res-card::before {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 4px;
            background: var(--status-color, #60a5fa);
        }

        .res-inner {
            display: grid;
            grid-template-columns: 60px 1fr auto;
            gap: 18px;
            align-items: center;
            padding: 20px 24px;
        }

        .res-icon {
            width: 60px; height: 60px;
            border-radius: 16px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.25);
        }

        .res-info { min-width: 0; }
        .res-title { font-size: 15px; font-weight: 800; margin-bottom: 6px; }
        .res-meta {
            display: flex; flex-wrap: wrap; gap: 12px;
            font-size: 12px; color: var(--text-muted);
        }
        .res-meta span { display: inline-flex; align-items: center; gap: 5px; }
        .res-meta i { color: var(--gold); font-size: 11px; }

        .res-side {
            display: flex; flex-direction: column;
            align-items: flex-end; gap: 8px;
        }
        .badge {
            padding: 5px 14px; border-radius: 9999px;
            font-size: 11px; font-weight: 700;
            white-space: nowrap;
        }
        .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
        .badge-active { background: rgba(52, 211, 153, 0.15); color: #34d399; }
        .badge-completed { background: rgba(96, 165, 250, 0.15); color: #60a5fa; }
        .badge-cancelled { background: rgba(244, 63, 94, 0.15); color: #fb7185; }
        .badge-expired { background: rgba(148, 163, 184, 0.15); color: #94a3b8; }

        .res-price {
            font-size: 14px; font-weight: 800;
            color: var(--gold-dark);
        }
        [data-theme="dark"] .res-price { color: var(--gold); }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px dashed var(--border);
        }
        .empty-icon {
            width: 100px; height: 100px;
            border-radius: 30px;
            background: linear-gradient(135deg, rgba(212, 163, 115, 0.1), rgba(212, 163, 115, 0.03));
            border: 2px dashed rgba(212, 163, 115, 0.3);
            color: var(--gold);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 40px;
            margin-bottom: 20px;
        }
        .empty-state h4 { font-size: 18px; font-weight: 800; margin-bottom: 8px; }
        .empty-state p { font-size: 14px; color: var(--text-muted); margin-bottom: 20px; }
        .empty-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 12px 28px; border-radius: 9999px;
            background: var(--gold-gradient); color: #fff;
            font-weight: 700; font-size: 14px;
            box-shadow: 0 8px 22px rgba(212, 163, 115, 0.3);
            transition: all 0.3s;
        }
        .empty-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(212, 163, 115, 0.5); }

        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .res-inner { grid-template-columns: 50px 1fr; gap: 12px; padding: 16px; }
            .res-side { grid-column: 1 / -1; flex-direction: row; justify-content: space-between; width: 100%; padding-top: 12px; border-top: 1px dashed var(--border); }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <section class="page-header">
        <div class="container page-header-content">
            <div class="page-header-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h1>رزروهای من</h1>
            <p>مدیریت رزروهای فعال و گذشته شما</p>
        </div>
    </section>

    <div class="container content-wrapper">

        {{-- ===== رزروهای فعال ===== --}}
        @if($activeReservations->count() > 0)
            <h2 class="section-title">
                <i class="fas fa-clock"></i>
                رزروهای فعال
            </h2>

            @foreach($activeReservations as $res)
                @php
                    $statusColors = [
                        'pending' => '#fbbf24',
                        'active' => '#34d399',
                    ];
                    $color = $statusColors[$res->status] ?? '#60a5fa';
                @endphp
                <a href="{{ route('reservations.show', $res->id) }}" class="res-card" style="--status-color: {{ $color }};">
                    <div class="res-inner">
                        <div class="res-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="res-info">
                            <div class="res-title">{{ $res->service->title ?? 'خدمت' }}</div>
                            <div class="res-meta">
                                <span><i class="fas fa-calendar"></i> {{ $res->reservation_date ? $res->reservation_date->format('Y/m/d') : '—' }}</span>
                                <span><i class="fas fa-clock"></i> {{ $res->shift_persian ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="res-side">
                            <span class="badge badge-{{ $res->status }}">
                                {{ $res->status_persian ?? $res->status }}
                            </span>
                            <span class="res-price">{{ number_format($res->total_price) }} ت</span>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif

        {{-- ===== رزروهای گذشته ===== --}}
        @if($pastReservations->count() > 0)
            <h2 class="section-title" style="margin-top: 40px;">
                <i class="fas fa-history"></i>
                رزروهای گذشته
            </h2>

            @foreach($pastReservations as $res)
                @php
                    $statusColors = [
                        'completed' => '#34d399',
                        'cancelled' => '#fb7185',
                        'expired' => '#94a3b8',
                    ];
                    $color = $statusColors[$res->status] ?? '#60a5fa';
                @endphp
                <a href="{{ route('reservations.show', $res->id) }}" class="res-card" style="--status-color: {{ $color }};">
                    <div class="res-inner">
                        <div class="res-icon">
                            <i class="fas fa-{{ $res->status === 'cancelled' ? 'times-circle' : 'check-circle' }}"></i>
                        </div>
                        <div class="res-info">
                            <div class="res-title">{{ $res->service->title ?? 'خدمت' }}</div>
                            <div class="res-meta">
                                <span><i class="fas fa-calendar"></i> {{ $res->reservation_date ? $res->reservation_date->format('Y/m/d') : '—' }}</span>
                            </div>
                        </div>
                        <div class="res-side">
                            <span class="badge badge-{{ $res->status }}">
                                {{ $res->status_persian ?? $res->status }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach

            @if($pastReservations->hasPages())
                <div style="margin-top: 20px; text-align: center;">
                    {{ $pastReservations->links() }}
                </div>
            @endif
        @endif

        {{-- ===== Empty State ===== --}}
        @if($activeReservations->count() === 0 && $pastReservations->count() === 0)
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h4>هنوز رزروی نداری!</h4>
                <p>برای شروع، یه خدمت رزرو کن</p>
                <a href="{{ route('services') }}" class="empty-btn">
                    <i class="fas fa-plus"></i>
                    مشاهده خدمات
                </a>
            </div>
        @endif

    </div>

</body>
</html>