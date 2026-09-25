<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>فاکتورها | GRAFIUM</title>
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
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* ===== PAGE HEADER ===== */
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
        .page-header::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(212, 163, 115, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 163, 115, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 80%);
        }
        .page-header-content {
            position: relative; z-index: 1;
            text-align: center;
            color: #fff;
        }
        .page-header-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: var(--gold-gradient);
            color: #fff;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
            box-shadow: 0 0 50px rgba(212, 163, 115, 0.4);
            border: 3px solid rgba(255, 255, 255, 0.15);
        }
        .page-header h1 {
            font-size: 30px; font-weight: 800;
            margin-bottom: 8px;
        }
        .page-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        /* ===== STATS ===== */
        .stats-wrapper {
            margin-top: -60px;
            position: relative;
            z-index: 2;
            margin-bottom: 40px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 120px; height: 120px;
            background: radial-gradient(circle, var(--accent, #d4a373) 0%, transparent 70%);
            opacity: 0.08;
            transition: transform 0.6s;
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border-color: var(--accent, #d4a373);
        }
        .stat-card:hover::before { transform: scale(1.5); opacity: 0.15; }
        .stat-card.blue { --accent: #60a5fa; }
        .stat-card.green { --accent: #34d399; }
        .stat-card.amber { --accent: #fbbf24; }
        .stat-card.purple { --accent: #a78bfa; }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            background: color-mix(in srgb, var(--accent) 15%, transparent);
            color: var(--accent);
            margin-bottom: 16px;
        }
        .stat-value {
            font-size: 26px; font-weight: 800;
            line-height: 1.2;
            margin-bottom: 4px;
            color: var(--text);
        }
        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ===== INVOICES LIST ===== */
        .invoices-section {
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

        .invoice-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            margin-bottom: 14px;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
            position: relative;
        }
        .invoice-card:hover {
            transform: translateX(-6px);
            border-color: var(--gold);
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.15);
        }
        .invoice-card::before {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 4px;
            background: var(--status-color, #60a5fa);
        }

        .invoice-inner {
            display: grid;
            grid-template-columns: 70px 1fr auto auto;
            gap: 18px;
            align-items: center;
            padding: 20px 24px;
        }

        .invoice-icon {
            width: 60px; height: 60px;
            border-radius: 16px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.25);
        }

        .invoice-info { min-width: 0; }
        .invoice-number {
            font-size: 12px;
            color: var(--gold);
            font-weight: 700;
            font-family: monospace;
            direction: ltr;
            margin-bottom: 4px;
        }
        .invoice-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .invoice-meta {
            display: flex;
            gap: 14px;
            font-size: 12px;
            color: var(--text-muted);
            flex-wrap: wrap;
        }
        .invoice-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .invoice-meta i { color: var(--gold); font-size: 11px; }

        .invoice-amount {
            text-align: center;
            padding: 0 16px;
            border-right: 1px solid var(--border);
            border-left: 1px solid var(--border);
        }
        .invoice-amount-value {
            font-size: 18px;
            font-weight: 800;
            color: var(--gold-dark);
            white-space: nowrap;
        }
        [data-theme="dark"] .invoice-amount-value { color: var(--gold); }
        .invoice-amount-label {
            font-size: 11px;
            color: var(--text-muted);
        }

        .invoice-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }
        .badge {
            padding: 5px 14px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }
        .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); }
        .badge-paid { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.3); }
        .badge-cancelled { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.3); }
        .badge-refunded { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.3); }

        .invoice-actions {
            display: flex;
            gap: 6px;
        }
        .btn-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: rgba(212, 163, 115, 0.1);
            color: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-icon:hover {
            background: var(--gold-gradient);
            color: #fff;
            transform: scale(1.1);
        }
        .btn-pay {
            padding: 6px 14px;
            border-radius: 10px;
            background: var(--gold-gradient);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.4);
        }

        /* ===== EMPTY STATE ===== */
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
        .empty-state h4 {
            font-size: 18px; font-weight: 800;
            color: var(--text); margin-bottom: 8px;
        }
        .empty-state p {
            font-size: 14px; color: var(--text-muted);
            margin-bottom: 20px;
        }
        .empty-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 28px;
            border-radius: 9999px;
            background: var(--gold-gradient);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s;
            box-shadow: 0 8px 22px rgba(212, 163, 115, 0.3);
        }
        .empty-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.5);
        }

        /* ===== PAGINATION ===== */
        .pagination-wrap {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }
        .pagination-wrap nav { display: flex; gap: 6px; }
        .pagination-wrap a, .pagination-wrap span {
            padding: 8px 14px;
            border-radius: 10px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 13px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .pagination-wrap a:hover {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
        }
        .pagination-wrap .active span {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .invoice-inner {
                grid-template-columns: 60px 1fr;
                gap: 12px;
                padding: 16px;
            }
            .invoice-amount {
                grid-column: 1 / -1;
                border: none;
                border-top: 1px dashed var(--border);
                padding-top: 12px;
                text-align: right;
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }
            .invoice-status {
                grid-column: 1 / -1;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding-top: 8px;
                border-top: 1px solid var(--border);
            }
        }
        @media (max-width: 576px) {
            .stats-grid { grid-template-columns: 1fr; }
            .page-header { padding: 40px 0 80px; }
            .page-header h1 { font-size: 22px; }
            .page-header-icon { width: 60px; height: 60px; font-size: 24px; }
            .container { padding: 0 16px; }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <!-- ===== PAGE HEADER ===== -->
    <section class="page-header">
        <div class="container page-header-content">
            <div class="page-header-icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <h1>فاکتورهای من</h1>
            <p>مدیریت فاکتورها و پرداخت‌های شما</p>
        </div>
    </section>

    <div class="container">

        <!-- ===== STATS ===== -->
        <div class="stats-wrapper">
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">کل فاکتورها</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-value">{{ $stats['paid'] }}</div>
                    <div class="stat-label">پرداخت شده</div>
                </div>
                <div class="stat-card amber">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                    <div class="stat-label">در انتظار پرداخت</div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                    <div class="stat-value">{{ number_format($stats['total_paid']) }}</div>
                    <div class="stat-label">مجموع پرداخت (تومان)</div>
                </div>
            </div>
        </div>

        <!-- ===== INVOICES LIST ===== -->
        <div class="invoices-section">
            <h2 class="section-title">
                <i class="fas fa-list-alt"></i>
                لیست فاکتورها
            </h2>

            @forelse($invoices as $invoice)
                @php
                    $statusColors = [
                        'pending' => '#fbbf24',
                        'paid' => '#34d399',
                        'cancelled' => '#fb7185',
                        'refunded' => '#94a3b8',
                    ];
                    $statusColor = $statusColors[$invoice->status] ?? '#60a5fa';
                @endphp
                <div class="invoice-card" style="--status-color: {{ $statusColor }};">
                    <div class="invoice-inner">
                        <div class="invoice-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>

                        <div class="invoice-info">
                            <div class="invoice-number">{{ $invoice->invoice_number }}</div>
                            <div class="invoice-title">{{ $invoice->title ?? 'فاکتور رزرو' }}</div>
                            <div class="invoice-meta">
                                <span>
                                    <i class="fas fa-calendar"></i>
                                    {{ $invoice->created_at ? $invoice->created_at->format('Y/m/d') : '—' }}
                                </span>
                                @if($invoice->reservation && $invoice->reservation->service)
                                    <span>
                                        <i class="fas fa-tag"></i>
                                        {{ $invoice->reservation->service->title }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="invoice-amount">
                            <div class="invoice-amount-value">{{ number_format($invoice->final_amount) }} ت</div>
                            <div class="invoice-amount-label">مبلغ نهایی</div>
                        </div>

                        <div class="invoice-status">
                            @if($invoice->status === 'paid')
                                <span class="badge badge-paid">
                                    <i class="fas fa-check-circle"></i> پرداخت شده
                                </span>
                            @elseif($invoice->status === 'pending')
                                <span class="badge badge-pending">
                                    <i class="fas fa-clock"></i> در انتظار پرداخت
                                </span>
                            @elseif($invoice->status === 'cancelled')
                                <span class="badge badge-cancelled">
                                    <i class="fas fa-times-circle"></i> لغو شده
                                </span>
                            @else
                                <span class="badge badge-refunded">
                                    <i class="fas fa-undo"></i> بازگشت داده شده
                                </span>
                            @endif

                            <div class="invoice-actions">
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn-icon" title="مشاهده">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($invoice->status === 'pending')
                                    <button type="button" class="btn-pay" onclick="payInvoice({{ $invoice->id }})">
                                        <i class="fas fa-credit-card"></i>
                                        پرداخت
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h4>هنوز فاکتوری نداری!</h4>
                    <p>برای شروع، یه خدمت رزرو کن</p>
                    <a href="{{ route('services') }}" class="empty-btn">
                        <i class="fas fa-plus"></i>
                        مشاهده خدمات
                    </a>
                </div>
            @endforelse

            <!-- ===== PAGINATION ===== -->
            @if($invoices->hasPages())
                <div class="pagination-wrap">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>

    </div>

    <script>
        // ===== Pay Invoice =====
        async function payInvoice(id) {
            if (!confirm('آیا از پرداخت این فاکتور اطمینان دارید؟')) return;

            try {
                const res = await fetch(`/invoices/${id}/pay`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                const data = await res.json();

                if (data.success) {
                    if (window.showAuthToast) {
                        window.showAuthToast(data.message, 'success');
                    } else {
                        alert(data.message);
                    }
                    setTimeout(() => {
                        window.location.href = data.redirect || window.location.href;
                    }, 900);
                } else {
                    if (window.showAuthToast) {
                        window.showAuthToast(data.message, 'error');
                    } else {
                        alert(data.message);
                    }
                }
            } catch (err) {
                if (window.showAuthToast) {
                    window.showAuthToast('خطا در ارتباط با سرور', 'error');
                } else {
                    alert('خطا در ارتباط با سرور');
                }
            }
        }
    </script>

</body>
</html>