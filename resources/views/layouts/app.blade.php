<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GRAFIUM')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: { 900: '#0a1628', 800: '#0f1f33', 700: '#132238', 600: '#1a2f4a', 500: '#2a4a6a' },
                        gold: { 300: '#d4a373', 400: '#c4915e', 500: '#b8874a' },
                        dark: { 300: '#94a3b8', 400: '#64748b', 500: '#1a2f4a' },
                    },
                    fontFamily: { vazir: ['Vazirmatn', 'sans-serif'] }
                }
            }
        }
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Vazirmatn', sans-serif; direction: rtl; background: #f5f7fa; color: #0a1628; transition: background 0.4s, color 0.4s; }
        [data-theme="dark"] body { background: #0a1628; color: #f0f0f0; }

        .header {
            position: sticky; top: 0; z-index: 1000;
            background: rgba(10, 22, 40, 0.95); backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212, 163, 115, 0.15);
            padding: 8px 0;
            transition: background 0.4s, border-color 0.4s;
        }
        [data-theme="light"] .header { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid #e4e7ec; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .header-inner { display: flex; align-items: center; justify-content: space-between; }

        .logo { display: flex; align-items: center; gap: 10px; font-size: 22px; font-weight: 800; }
        .logo-img { height: 50px; width: auto; object-fit: contain; }

        .nav-desktop ul { display: flex; gap: 28px; }
        .nav-desktop a {
            font-weight: 500; font-size: 15px; position: relative; transition: color 0.3s;
            color: rgba(255, 255, 255, 0.7);
        }
        [data-theme="light"] .nav-desktop a { color: #0a1628; }
        .nav-desktop a::after {
            content: ''; position: absolute; bottom: -4px; right: 0; width: 0; height: 2px;
            background: linear-gradient(135deg, #d4a373, #b8874a); transition: width 0.3s;
        }
        .nav-desktop a:hover::after, .nav-desktop a.active::after { width: 100%; }
        .nav-desktop a:hover, .nav-desktop a.active { color: #d4a373; }

        .header-actions { display: flex; align-items: center; gap: 12px; }
        .theme-toggle {
            width: 40px; height: 40px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2);
            background: transparent; color: #fff; cursor: pointer; font-size: 18px;
            display: flex; align-items: center; justify-content: center; transition: 0.3s;
        }
        [data-theme="light"] .theme-toggle { border-color: #e4e7ec; color: #0a1628; }
        .theme-toggle:hover { border-color: #d4a373; color: #d4a373; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 28px; border-radius: 40px; font-weight: 600; font-size: 14px;
            transition: 0.3s; cursor: pointer; border: 2px solid transparent;
            background: linear-gradient(135deg, #d4a373, #b8874a); color: #fff;
        }
        .btn:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 30px rgba(212,163,115,0.3); }
        .btn-gold { background: linear-gradient(135deg, #d4a373, #b8874a); border-color: #d4a373; }
        .btn-gold-outline { background: transparent; color: #d4a373; border: 2px solid #d4a373; }
        .btn-gold-outline:hover { background: linear-gradient(135deg, #d4a373, #b8874a); color: #fff; }
        .btn-white { background: #fff; color: #0a1628; }
        .btn-white:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(255,255,255,0.2); }

        .menu-toggle { display: none; font-size: 24px; background: none; border: none; color: #fff; cursor: pointer; }
        [data-theme="light"] .menu-toggle { color: #0a1628; }

        .mobile-menu {
            display: none; flex-direction: column; gap: 16px; padding: 20px;
            background: var(--bg-card); border-top: 1px solid var(--border);
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu ul { display: flex; flex-direction: column; gap: 12px; }
        .mobile-menu a { font-weight: 500; font-size: 16px; }
        .mobile-auth { display: flex; gap: 12px; }

        .footer {
            background: #0a1628; color: #c8c8d4; padding: 60px 0 20px;
            margin-top: 40px; border-top: 2px solid #d4a373;
        }
        .footer-grid {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px;
            padding-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.06);
            text-align: center;
        }
        .footer-brand .logo { justify-content: center; }
        .footer-brand p { font-size: 14px; max-width: 300px; margin: 0 auto 16px; color: rgba(255,255,255,0.5); }
        .footer-social { display: flex; gap: 12px; justify-content: center; }
        .footer-social a {
            width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.04);
            display: flex; align-items: center; justify-content: center; color: #c8c8d4; transition: 0.3s;
        }
        .footer-social a:hover { background: #d4a373; color: #fff; }
        .footer-links h4, .footer-contact h4, .footer-trust h4 { color: #fff; font-size: 16px; margin-bottom: 16px; }
        .footer-links ul, .footer-contact ul { display: flex; flex-direction: column; gap: 10px; align-items: center; }
        .footer-links a, .footer-contact li { font-size: 14px; color: #94a3b8; }
        .footer-links a:hover { color: #d4a373; }
        .footer-contact li { display: flex; align-items: center; gap: 10px; }
        .footer-contact li i { color: #d4a373; width: 20px; }
        .trust-icons { display: flex; gap: 16px; flex-wrap: wrap; justify-content: center; }
        .trust-icons span { background: rgba(255,255,255,0.04); padding: 8px 16px; border-radius: 8px; font-size: 13px; color: #94a3b8; }
        .footer-bottom { text-align: center; padding-top: 20px; font-size: 14px; color: #64748b; }
        .gold-text { background: linear-gradient(135deg, #d4a373, #b8874a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: block; }
            .footer-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .logo-img { height: 40px; }
            .btn { padding: 8px 16px; font-size: 12px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.scripts')
    @stack('scripts')

</body>
</html>