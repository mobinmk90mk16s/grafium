<header class="header" id="header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium Logo" class="logo-img" />
        </a>
        <nav class="nav-desktop">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">خانه</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">درباره ما</a></li>
                <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">خدمات</a></li>
                <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">بلاگ</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">تماس</a></li>
            </ul>
        </nav>
        <div class="header-actions">
            <button class="theme-toggle" id="themeToggle"><i class="fas fa-moon"></i></button>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-gold">داشبورد</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-gold-outline">خروج</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-gold">ورود</a>
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
                <a href="{{ route('login') }}" class="btn btn-gold">ورود</a>
            @endauth
        </div>
    </div>
</header>