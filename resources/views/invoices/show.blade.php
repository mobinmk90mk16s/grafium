<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>فاکتور {{ $invoice->invoice_number }} | GRAFIUM</title>
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

        /* ===== PAGE HEADER ===== */
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
            font-size: 26px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .page-header-content h1 i { color: var(--gold); }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background: rgba(212, 163, 115, 0.2);
            border-color: var(--gold);
        }

        /* ===== INVOICE CARD ===== */
        .invoice-wrapper {
            margin-top: -50px;
            position: relative;
            z-index: 2;
            margin-bottom: 60px;
        }
        .invoice-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .invoice-top {
            padding: 40px 40px 30px;
            text-align: center;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(212, 163, 115, 0.04) 0%, transparent 100%);
            position: relative;
        }

        .invoice-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 22px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .invoice-status-badge.pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
        .invoice-status-badge.paid { background: rgba(52, 211, 153, 0.15); color: #34d399; }
        .invoice-status-badge.cancelled { background: rgba(244, 63, 94, 0.15); color: #fb7185; }
        .invoice-status-badge.refunded { background: rgba(148, 163, 184, 0.15); color: #94a3b8; }

        .invoice-big-amount {
            font-size: 42px;
            font-weight: 900;
            color: var(--gold-dark);
            margin-bottom: 8px;
            line-height: 1.1;
        }
        [data-theme="dark"] .invoice-big-amount { color: var(--gold); }

        .invoice-number-line {
            font-size: 13px;
            color: var(--text-muted);
            font-family: monospace;
            direction: ltr;
        }

        /* ===== INFO SECTIONS ===== */
        .invoice-body { padding: 30px 40px; }

        .invoice-section {
            margin-bottom: 30px;
        }
        .invoice-section:last-child { margin-bottom: 0; }

        .section-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section-label i { color: var(--gold); }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
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
        .info-item .label {
            font-size: 13px;
            color: var(--text-muted);
        }
        .info-item .value {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        /* ===== PRICE BREAKDOWN ===== */
        .price-breakdown {
            background: var(--bg-body);
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid var(--border);
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            font-size: 14px;
        }
        .price-row .label { color: var(--text-muted); }
        .price-row .value { font-weight: 700; color: var(--text); }
        .price-row.discount .value { color: #34d399; }
        .price-row.tax .value { color: #fb7185; }

        .price-divider {
            border: none;
            border-top: 1px dashed var(--border);
            margin: 10px 0;
        }

        .price-row.total {
            padding-top: 16px;
            margin-top: 6px;
            border-top: 2px solid var(--gold);
        }
        .price-row.total .label {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
        }
        .price-row.total .value {
            font-size: 22px;
            color: var(--gold-dark);
        }
        [data-theme="dark"] .price-row.total .value { color: var(--gold); }

        /* ===== ACTIONS ===== */
        .invoice-actions {
            padding: 24px 40px 40px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 24px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 15px;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
        }
        .btn-primary {
            background: var(--gold-gradient);
            color: #fff;
            box-shadow: 0 12px 32px rgba(212, 163, 115, 0.35);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 50px rgba(212, 163, 115, 0.55);
        }
        .btn-secondary {
            background: var(--bg-body);
            color: var(--text);
            border: 2px solid var(--border);
        }
        .btn-secondary:hover {
            border-color: var(--gold);
            color: var(--gold);
        }
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .page-header { padding: 40px 0 80px; }
            .page-header-content h1 { font-size: 20px; }
            .invoice-top { padding: 30px 20px 24px; }
            .invoice-big-amount { font-size: 32px; }
            .invoice-body { padding: 24px 20px; }
            .invoice-actions { padding: 20px; flex-direction: column; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <!-- ===== PAGE HEADER ===== -->
    <section class="page-header">
        <div class="container page-header-content">
            <h1><i class="fas fa-file-invoice"></i> جزئیات فاکتور</h1>
            <a href="{{ route('invoices.index') }}" class="back-btn">
                <i class="fas fa-arrow-right"></i>
                بازگشت به لیست
            </a>
        </div>
    </section>

    <div class="container">
        <div class="invoice-wrapper">
            <div class="invoice-card">

                <!-- ===== TOP ===== -->
                <div class="invoice-top">
                    @php
                        $statusLabels = [
                            'pending' => 'در انتظار پرداخت',
                            'paid' => 'پرداخت شده',
                            'cancelled' => 'لغو شده',
                            'refunded' => 'بازگشت داده شده',
                        ];
                        $statusIcons = [
                            'pending' => 'fa-clock',
                            'paid' => 'fa-check-circle',
                            'cancelled' => 'fa-times-circle',
                            'refunded' => 'fa-undo',
                        ];
                    @endphp
                    <div class="invoice-status-badge {{ $invoice->status }}">
                        <i class="fas {{ $statusIcons[$invoice->status] ?? 'fa-info-circle' }}"></i>
                        {{ $statusLabels[$invoice->status] ?? $invoice->status }}
                    </div>

                    <div class="invoice-big-amount">{{ number_format($invoice->final_amount) }} تومان</div>
                    <div class="invoice-number-line">{{ $invoice->invoice_number }}</div>
                </div>

                <!-- ===== BODY ===== -->
                <div class="invoice-body">

                    <!-- اطلاعات فاکتور -->
                    <div class="invoice-section">
                        <div class="section-label">
                            <i class="fas fa-info-circle"></i>
                            اطلاعات فاکتور
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">عنوان</span>
                                <span class="value">{{ $invoice->title ?? 'فاکتور رزرو' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">تاریخ صدور</span>
                                <span class="value">
                                    {{ $invoice->created_at ? $invoice->created_at->format('Y/m/d') : '—' }}
                                </span>
                            </div>
                            @if($invoice->payment_date)
                                <div class="info-item">
                                    <span class="label">تاریخ پرداخت</span>
                                    <span class="value">{{ $invoice->payment_date->format('Y/m/d') }}</span>
                                </div>
                            @endif
                            @if($invoice->payment_method)
                                <div class="info-item">
                                    <span class="label">روش پرداخت</span>
                                    <span class="value">
                                        @php
                                            $methods = ['cash' => 'نقدی', 'card' => 'کارت', 'online' => 'آنلاین', 'transfer' => 'انتقال'];
                                        @endphp
                                        {{ $methods[$invoice->payment_method] ?? $invoice->payment_method }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- اطلاعات رزرو -->
                    @if($invoice->reservation)
                        <div class="invoice-section">
                            <div class="section-label">
                                <i class="fas fa-calendar-check"></i>
                                اطلاعات رزرو
                            </div>
                            <div class="info-grid">
                                @if($invoice->reservation->service)
                                    <div class="info-item">
                                        <span class="label">خدمت</span>
                                        <span class="value">{{ $invoice->reservation->service->title }}</span>
                                    </div>
                                @endif
                                <div class="info-item">
                                    <span class="label">تاریخ رزرو</span>
                                    <span class="value">
                                        {{ $invoice->reservation->reservation_date ? $invoice->reservation->reservation_date->format('Y/m/d') : '—' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="label">شیفت</span>
                                    <span class="value">{{ $invoice->reservation->shift_persian ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- جزئیات قیمت -->
                    <div class="invoice-section">
                        <div class="section-label">
                            <i class="fas fa-calculator"></i>
                            جزئیات قیمت
                        </div>
                        <div class="price-breakdown">
                            <div class="price-row">
                                <span class="label">مبلغ پایه</span>
                                <span class="value">{{ number_format($invoice->amount) }} تومان</span>
                            </div>
                            @if($invoice->tax > 0)
                                <div class="price-row tax">
                                    <span class="label">مالیات</span>
                                    <span class="value">+ {{ number_format($invoice->tax) }} تومان</span>
                                </div>
                            @endif
                            @if($invoice->discount > 0)
                                <div class="price-row discount">
                                    <span class="label">تخفیف</span>
                                    <span class="value">- {{ number_format($invoice->discount) }} تومان</span>
                                </div>
                            @endif
                            <hr class="price-divider" />
                            <div class="price-row total">
                                <span class="label">مبلغ نهایی</span>
                                <span class="value">{{ number_format($invoice->final_amount) }} تومان</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ===== ACTIONS ===== -->
                <div class="invoice-actions">
                    @if($invoice->status === 'pending')
                        <button type="button" class="btn btn-primary" id="payBtn" onclick="payInvoice({{ $invoice->id }})">
                            <i class="fas fa-credit-card"></i>
                            پرداخت فاکتور
                        </button>
                    @elseif($invoice->status === 'paid')
                        <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i>
                            دانلود فاکتور
                        </a>
                    @endif
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i>
                        بازگشت
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        async function payInvoice(id) {
            if (!confirm('آیا از پرداخت این فاکتور اطمینان دارید؟')) return;

            const btn = document.getElementById('payBtn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال پرداخت...';
            }

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
                    if (window.showAuthToast) window.showAuthToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 900);
                } else {
                    if (window.showAuthToast) window.showAuthToast(data.message, 'error');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-credit-card"></i> پرداخت فاکتور';
                    }
                }
            } catch (err) {
                if (window.showAuthToast) window.showAuthToast('خطا در ارتباط با سرور', 'error');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-credit-card"></i> پرداخت فاکتور';
                }
            }
        }
    </script>

</body>
</html>