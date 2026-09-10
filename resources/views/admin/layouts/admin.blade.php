<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت | GRAFIUM')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: { 900: '#0a1628', 800: '#0f1f33', 700: '#132238', 600: '#1a2f4a', 500: '#2a4a6a' },
                        blue: { 400: '#60a5fa', 500: '#3b82f6' },
                        emerald: { 400: '#34d399' },
                        rose: { 400: '#fb7185' },
                        amber: { 400: '#fbbf24' },
                        violet: { 400: '#a78bfa' },
                        gold: { 400: '#d4a373', 500: '#b8874a' },
                    },
                    fontFamily: { vazir: ['Vazirmatn', 'sans-serif'] }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0a1628; }
        ::-webkit-scrollbar-thumb { background: #1a2f4a; border-radius: 10px; }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #080e1a;
            color: #e2e8f0;
            direction: rtl;
        }

        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: #1a2f4a transparent;
        }
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: #1a2f4a; border-radius: 10px; }

        .menu-item {
            transition: all 0.2s ease;
            position: relative;
            cursor: pointer;
        }
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #f1f5f9;
        }
        .menu-item.active {
            background: rgba(59, 130, 246, 0.08);
            color: #60a5fa;
        }
        .menu-item.active i {
            color: #60a5fa;
        }
        .menu-item .menu-indicator {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: #3b82f6;
            border-radius: 0 4px 4px 0;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .menu-item.active .menu-indicator {
            opacity: 1;
        }

        .avatar-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #1a2f4a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-size: 16px;
        }

        .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

        .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

        .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

        .btn-gold { background: rgba(212, 163, 115, 0.08); color: #d4a373; border: 1px solid rgba(212, 163, 115, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-gold:hover { background: rgba(212, 163, 115, 0.15); }

        .btn-violet { background: rgba(167, 139, 250, 0.08); color: #a78bfa; border: 1px solid rgba(167, 139, 250, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-violet:hover { background: rgba(167, 139, 250, 0.15); }

        .badge {
            padding: 4px 14px; border-radius: 9999px; font-size: 11px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
        }
        .badge-active { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
        .badge-inactive { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }
        .badge-shift { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
        .badge-hourly { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }

        @stack('styles')
    </style>
</head>
<body>

    <!-- ============================================================
    ✅ سایدبار - جای درست (بلافاصله بعد از body)
    ============================================================ -->
    @include('admin.partials.sidebar')

    <!-- ============================================================
    محتوای اصلی
    ============================================================ -->
    <main class="mr-[270px] p-6 min-h-screen">
        @yield('content')
    </main>

    <!-- ============================================================
    اسکریپت‌ها
    ============================================================ -->
    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')

</body>
</html>