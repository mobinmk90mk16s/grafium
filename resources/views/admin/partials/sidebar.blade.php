<aside class="sidebar fixed right-0 top-0 w-[270px] h-screen bg-[#0a1628] border-l border-[#1a2f4a] p-4 overflow-y-auto z-50">
    <div class="text-center mb-6 pb-4 border-b border-[#1a2f4a]">
        <div class="flex items-center justify-center gap-2">
            <i data-lucide="gem" class="w-6 h-6 text-blue-400"></i>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">GRAFIUM</h2>
        </div>
        <p class="text-[11px] text-[#475569] mt-1">پنل مدیریت</p>
    </div>

    <nav class="space-y-5">

        <!-- ============================================================
        بخش اصلی
        ============================================================ -->
        <div>
            <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">اصلی</p>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 text-[#60a5fa]"></i> داشبورد
                        <span class="menu-indicator"></span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ============================================================
        بخش مدیریت
        ============================================================ -->
        <div>
            <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">مدیریت</p>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('admin.admins.index') }}" class="menu-item {{ request()->routeIs('admin.admins*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="user-cog" class="w-5 h-5 text-[#60a5fa]"></i> مدیران
                        <span class="menu-indicator"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="users" class="w-5 h-5 text-[#60a5fa]"></i> کاربران
                        <span class="menu-indicator"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services.index') }}" class="menu-item {{ request()->routeIs('admin.services*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="settings" class="w-5 h-5 text-[#60a5fa]"></i> خدمات
                        <span class="menu-indicator"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reservations.index') }}" class="menu-item {{ request()->routeIs('admin.reservations*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="calendar-check" class="w-5 h-5 text-[#60a5fa]"></i> رزروها
                        <span class="menu-indicator"></span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ============================================================
        بخش بلاگ
        ============================================================ -->
        <div>
            <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">بلاگ</p>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('admin.blog.posts') }}" class="menu-item {{ request()->routeIs('admin.blog.posts') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="newspaper" class="w-5 h-5 text-[#60a5fa]"></i> همه پست‌ها
                        <span class="menu-indicator"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.blog.categories.index') }}" class="menu-item {{ request()->routeIs('admin.blog.categories*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="folder" class="w-5 h-5 text-[#60a5fa]"></i> دسته‌بندی‌ها
                        <span class="menu-indicator"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.blog.tags.index') }}" class="menu-item {{ request()->routeIs('admin.blog.tags.index') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="tag" class="w-5 h-5 text-[#60a5fa]"></i> تگ‌ها
                        <span class="menu-indicator"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.blog.comments.index') }}" class="menu-item {{ request()->routeIs('admin.blog.comments*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="star" class="w-5 h-5 text-[#60a5fa]"></i> نظرات
                        <span class="menu-indicator"></span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ============================================================
        بخش ابزارها
        ============================================================ -->
        <div>
            <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">ابزارها</p>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('admin.calendar') }}" class="menu-item {{ request()->routeIs('admin.calendar*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="calendar" class="w-5 h-5 text-[#60a5fa]"></i> تقویم
                        <span class="menu-indicator"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.scheduling.index') }}" class="menu-item {{ request()->routeIs('admin.scheduling*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                        <i data-lucide="clock" class="w-5 h-5 text-[#60a5fa]"></i> زمان‌بندی
                        <span class="menu-indicator"></span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ============================================================
        بخش خروج
        ============================================================ -->
        <form action="{{ route('admin.logout') }}" method="POST" class="pt-4 border-t border-[#1a2f4a]">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:bg-rose-500/10 transition w-full text-sm font-medium">
                <i data-lucide="log-out" class="w-5 h-5"></i> خروج از پنل
            </button>
        </form>

    </nav>
</aside>