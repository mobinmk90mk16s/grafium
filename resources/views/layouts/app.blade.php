<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'GRAFIUM | سالن کار اشتراکی گرافیکی')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />

    @stack('styles')
</head>
<body>

    <!-- ===== HEADER ===== -->
    <header class="header" id="header">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Grafium Logo" class="logo-img" />
            </a>
            <nav class="nav-desktop" id="navDesktop">
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">خانه</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">درباره ما</a></li>
                    <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">خدمات</a></li>
                    <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">بلاگ</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">تماس</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle"><i class="fas fa-moon"></i></button>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-gold">داشبورد</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold" id="openModalBtn">ورود</a>
                @endauth
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <ul>
                <li><a href="{{ route('home') }}">خانه</a></li>
                <li><a href="{{ route('about') }}">درباره ما</a></li>
                <li><a href="{{ route('services') }}">خدمات</a></li>
                <li><a href="{{ route('blog') }}">بلاگ</a></li>
                <li><a href="{{ route('contact') }}">تماس</a></li>
            </ul>
            <div class="mobile-auth">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-gold">داشبورد</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold" id="openModalBtnMobile">ورود</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ===== CONTENT ===== -->
    @yield('content')

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo"><img src="{{ asset('images/logo.png') }}" alt="Grafium Logo" class="logo-img" /></a>
                    <p>اولین سالن کار اشتراکی گرافیکی در شهر</p>
                    <div class="footer-social">
                        <a href="#"><i class="fas fa-comment"></i></a>
                        <a href="#"><i class="fas fa-check-circle"></i></a>
                        <a href="#"><i class="fas fa-video"></i></a>
                        <a href="#"><i class="fas fa-share-alt"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>لینک‌های مفید</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">خانه</a></li>
                        <li><a href="{{ route('about') }}">درباره ما</a></li>
                        <li><a href="{{ route('services') }}">خدمات</a></li>
                        <li><a href="{{ route('blog') }}">بلاگ</a></li>
                        <li><a href="{{ route('contact') }}">تماس</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>اطلاعات تماس</h4>
                    <ul>
                        <li><i class="fas fa-map-pin"></i> خیابان اصلی، پلاک ۱۲۳</li>
                        <li><i class="fas fa-phone"></i> ۰۲۱-۱۲۳۴-۵۶۷۸</li>
                        <li><i class="fas fa-envelope"></i> info@grafium.ir</li>
                    </ul>
                </div>
                <div class="footer-trust">
                    <h4>نمادهای اعتماد</h4>
                    <div class="trust-icons"><span>نماد ۱</span><span>نماد ۲</span><span>نماد ۳</span></div>
                </div>
            </div>
            <div class="footer-bottom"><p>&copy; ۲۰۲۶ تمامی حقوق برای <span class="gold-text">GRAFIUM</span> محفوظ است.</p></div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>