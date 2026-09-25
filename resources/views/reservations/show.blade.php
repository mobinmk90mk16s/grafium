<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>جزئیات رزرو | GRAFIUM</title>
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
        .container { max-width: 900px; margin: 0 auto; padding: 0 20px; }

        .page-header {
            background: var(--navy-gradient);
            padding: 50px 0 90px;
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
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            color: #fff;
        }
        .page-header-content h1 {
            font-size: 24px; font-weight: 800;
            display: flex; align-items: center; gap: 12px;
        }
        .page-header-content h1 i { color: var(--gold); }
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff; font-size: 13px; font-weight: 700;
            transition: all 0.3s;
        }
        .back-btn:hover { background: rgba(212, 163, 115, 0.2); border-color: var(--gold); }

        .content-wrapper {
            margin-top: -50px;
            position: relative;
            z-index: 2;
            margin-bottom: 60px;
        }

        .res-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .res-top {
            padding: 40px;
            text-align: center;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(212, 163, 115, 0.04) 0%, transparent 100%);
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 22px; border-radius: 9999px;
            font-size: 13px; font-weight: 700;
            margin-bottom: 20px;
        }
        .status-badge.pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
        .status-badge.active { background: rgba(52, 211, 153, 0.15); color: #34d399; }
        .status-badge.completed { background: rgba(96, 165, 250, 0.15); color: #60a5fa; }
        .status-badge.cancelled { background: rgba(244, 63, 94, 0.15); color: #fb7185; }
        .status-badge.expired { background: rgba(148, 163, 184, 0.15); color: #94a3b8; }

        .res-icon-big {
            width: 90px; height: 90px;
            border-radius: 24px;
            background: var(--gold-gradient);
            color: #fff; font-size: 36px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.4);
        }
        .res-title-big {
            font-size: 24px; font-weight: 800;
            margin-bottom: 8px;
        }
        .res-amount-big {
            font-size: 28px; font-weight: 900;
            color: var(--gold-dark);
        }
        [data-theme="dark"] .res-amount-big { color: var(--gold); }

        .res-body { padding: 30px 40px; }

        .section-label {
            font-size: 13px; font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 14px;
            display: flex; align-items: center; gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section-label i { color: var(--gold); }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 30px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border-radius: 12px;
            background: var(--bg-body);
            border: 1px solid var(--border);
        }
        .info-item .label { font-size: 13px; color: var(--text-muted); }
        .info-item .value { font-size: 14px; font-weight: 700; }

        .sched-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 30px;
        }
        .sched-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: var(--bg-body);
            border: 1px solid var(--border);
            border-radius: 12px;
        }
        .sched-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: #fbbf24;
            flex-shrink: 0;
        }
        .sched-content { flex: 1; }
        .sched-title { font-weight: 700; font-size: 14px; margin-bottom: 2px; }
        .sched-time { font-size: 12px; color: var(--text-muted); }

        .action-btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 10px; padding: 14px 24px;
            border-radius: 14px; border: none;
            cursor: pointer; font-family: inherit;
            font-weight: 700; font-size: 14px;
            transition: all 0.35s;
        }
        .btn-danger {
            background: rgba(244, 63, 94, 0.1);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.2);
        }
        .btn-danger:hover { background: rgba(244, 63, 94, 0.2); }
        .btn-gold {
            background: var(--gold-gradient);
            color: #fff;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.3);
        }
        .btn-gold:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(212, 163, 115, 0.5); }

        .res-actions {
            padding: 0 40px 40px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .res-top { padding: 30px 20px; }
            .res-body { padding: 24px 20px; }
            .res-actions { padding: 0 20px 30px; flex-direction: column; }
            .info-grid { grid-template-columns: 1fr; }
            .res-amount-big { font-size: 22px; }
            .res-title-big { font-size: 20px; }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <section class="page-header">
        <div class="container page-header-content">
            <h1><i class="fas fa-calendar-check"></i> جزئیات رزرو</h1>
            <a href="{{ route('reservations.index') }}" class="back-btn">
                <i class="fas fa-arrow-right"></i>
                بازگشت
            </a>
        </div>
    </section>

    <div class="container content-wrapper">
        <div class="res-card">

            {{-- ===== TOP ===== --}}
            <div class="res-top">
                <div class="status-badge {{ $reservation->status }}">
                    <i class="fas fa-circle" style="font-size: 8px;"></i>
                    {{ $reservation->status_persian ?? $reservation->status }}
                </div>
                <div class="res-icon-big">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="res-title-big">{{ $reservation->service->title ?? 'خدمت' }}</div>
                <div class="res-amount-big">{{ number_format($reservation->total_price) }} تومان</div>
            </div>

            {{-- ===== BODY ===== --}}
            <div class="res-body">

                {{-- اطلاعات رزرو --}}
                <div class="section-label">
                    <i class="fas fa-info-circle"></i>
                    اطلاعات رزرو
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">تاریخ رزرو</span>
                        <span class="value">
                            {{ $reservation->reservation_date ? $reservation->reservation_date->format('Y/m/d') : '—' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="label">شیفت</span>
                        <span class="value">{{ $reservation->shift_persian ?? '—' }}</span>
                    </div>
                    @if($reservation->start_time)
                        <div class="info-item">
                            <span class="label">ساعت شروع</span>
                            <span class="value">{{ $reservation->start_time->format('H:i') }}</span>
                        </div>
                    @endif
                    @if($reservation->end_time)
                        <div class="info-item">
                            <span class="label">ساعت پایان</span>
                            <span class="value">{{ $reservation->end_time->format('H:i') }}</span>
                        </div>
                    @endif
                </div>

                {{-- آیتم‌های رزرو --}}
                @if($schedulings->count() > 0)
                    <div class="section-label">
                        <i class="fas fa-list"></i>
                        آیتم‌های رزرو
                    </div>
                    <div class="sched-list">
                        @foreach($schedulings as $sch)
                            <div class="sched-item">
                                <div class="sched-dot"></div>
                                <div class="sched-content">
                                    <div class="sched-title">
                                        {{ $sch->serviceItem->title ?? 'آیتم' }}
                                    </div>
                                    <div class="sched-time">
                                        <i class="fas fa-calendar" style="color: var(--gold);"></i>
                                        {{ $sch->jalali_date }}
                                        |
                                        <i class="fas fa-clock" style="color: var(--gold);"></i>
                                        {{ $sch->date_time ? $sch->date_time->format('H:i') : '—' }}
                                        تا
                                        {{ $sch->end_time ? $sch->end_time->format('H:i') : '—' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- فاکتور --}}
                @if($reservation->invoice)
                    <div class="section-label">
                        <i class="fas fa-file-invoice"></i>
                        فاکتور
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="label">شماره فاکتور</span>
                            <span class="value" style="font-family: monospace; direction: ltr;">{{ $reservation->invoice->invoice_number }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">وضعیت فاکتور</span>
                            <span class="value">
                                {{ $reservation->invoice->status === 'paid' ? 'پرداخت شده' : ($reservation->invoice->status === 'pending' ? 'در انتظار' : 'لغو شده') }}
                            </span>
                        </div>
                    </div>
                @endif

            </div>

            {{-- ===== ACTIONS ===== --}}
            <div class="res-actions">
                @if($reservation->invoice)
                    <a href="{{ route('invoices.show', $reservation->invoice->id) }}" class="action-btn btn-gold">
                        <i class="fas fa-file-invoice"></i>
                        مشاهده فاکتور
                    </a>
                @endif

                @if($canCancel)
                    <button type="button" class="action-btn btn-danger" onclick="cancelReservation({{ $reservation->id }})">
                        <i class="fas fa-times"></i>
                        لغو رزرو
                    </button>
                @endif
            </div>

        </div>
    </div>

    <script>
        async function cancelReservation(id) {
            if (!confirm('آیا از لغو این رزرو اطمینان دارید؟')) return;

            try {
                const res = await fetch(`/reservations/${id}/cancel`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                const data = await res.json();

                if (data.success) {
                    if (window.showAuthToast) window.showAuthToast(data.message, 'success');
                    setTimeout(() => window.location.href = '{{ route("reservations.index") }}', 900);
                } else {
                    if (window.showAuthToast) window.showAuthToast(data.message, 'error');
                }
            } catch (err) {
                if (window.showAuthToast) window.showAuthToast('خطا در ارتباط با سرور', 'error');
            }
        }
    </script>

</body>
</html>