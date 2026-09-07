@extends('admin.layouts.admin')

@section('title', 'داشبورد مدیریت | GRAFIUM')

@section('content')
    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
        <div>
            <div class="flex items-center gap-3">
                <i data-lucide="layout-dashboard" class="w-6 h-6 text-blue-400"></i>
                <h1 class="text-2xl font-extrabold text-white">داشبورد</h1>
            </div>
            <p class="text-sm text-[#475569] mt-0.5 mr-9">نمای کلی از وضعیت سیستم</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
            <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
        </div>
    </div>

    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <!-- مدیران -->
        <div class="stat-card bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-5 hover:border-blue-400/30 transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-white">{{ $stats['total_admins'] ?? 0 }}</span>
                    <p class="text-xs font-medium text-blue-400 mt-0.5">مدیران</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-500/10 flex items-center justify-center">
                    <i data-lucide="user-cog" class="w-6 h-6 text-blue-400"></i>
                </div>
            </div>
        </div>

        <!-- کاربران -->
        <div class="stat-card bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-5 hover:border-emerald-400/30 transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-white">{{ $stats['total_users'] ?? 0 }}</span>
                    <p class="text-xs font-medium text-emerald-400 mt-0.5">کاربران</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-emerald-400"></i>
                </div>
            </div>
        </div>

        <!-- رزروها -->
        <div class="stat-card bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-5 hover:border-amber-400/30 transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-white">{{ $stats['total_reservations'] ?? 0 }}</span>
                    <p class="text-xs font-medium text-amber-400 mt-0.5">رزروها</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center">
                    <i data-lucide="calendar-check" class="w-6 h-6 text-amber-400"></i>
                </div>
            </div>
        </div>

        <!-- فاکتورها -->
        <div class="stat-card bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-5 hover:border-rose-400/30 transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-white">{{ $stats['total_invoices'] ?? 0 }}</span>
                    <p class="text-xs font-medium text-rose-400 mt-0.5">فاکتورها</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-rose-500/10 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-rose-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== SECOND ROW STATS ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <!-- رزرو فعال -->
        <div class="stat-card bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-5 hover:border-emerald-400/30 transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-emerald-400">{{ $stats['active_reservations'] ?? 0 }}</span>
                    <p class="text-xs font-medium text-emerald-400/80 mt-0.5">رزرو فعال</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-emerald-400"></i>
                </div>
            </div>
        </div>

        <!-- در انتظار -->
        <div class="stat-card bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-5 hover:border-amber-400/30 transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-amber-400">{{ $stats['pending_reservations'] ?? 0 }}</span>
                    <p class="text-xs font-medium text-amber-400/80 mt-0.5">در انتظار</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-amber-400"></i>
                </div>
            </div>
        </div>

        <!-- پرداخت شده -->
        <div class="stat-card bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-5 hover:border-emerald-400/30 transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-emerald-400">{{ $stats['paid_invoices'] ?? 0 }}</span>
                    <p class="text-xs font-medium text-emerald-400/80 mt-0.5">پرداخت شده</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                    <i data-lucide="credit-card" class="w-6 h-6 text-emerald-400"></i>
                </div>
            </div>
        </div>

        <!-- در انتظار پرداخت -->
        <div class="stat-card bg-[#0f1f33] border border-[#1a2f4a] rounded-xl p-5 hover:border-amber-400/30 transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-amber-400">{{ $stats['pending_invoices'] ?? 0 }}</span>
                    <p class="text-xs font-medium text-amber-400/80 mt-0.5">در انتظار پرداخت</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center">
                    <i data-lucide="hourglass" class="w-6 h-6 text-amber-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== WELCOME & CHARTS ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Welcome -->
        <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-6 lg:col-span-2">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user" class="w-6 h-6 text-blue-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">خوش آمدید، {{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</h2>
                    <p class="text-[#94a3b8] mt-1">به پنل مدیریت GRAFIUM خوش آمدید.</p>
                    <div class="flex items-center gap-2 mt-3 text-xs text-[#475569]">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>آخرین ورود: {{ Auth::guard('admin')->user()->last_login ?? 'اولین ورود' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-6">
            <h3 class="text-sm font-bold text-white mb-3">دسترسی سریع</h3>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('admin.services.index') }}" class="bg-[#1a2f4a] hover:bg-[#2a4a6a] transition p-3 rounded-xl text-center">
                    <i data-lucide="settings" class="w-5 h-5 text-blue-400 mx-auto"></i>
                    <span class="text-xs text-[#94a3b8] mt-1 block">خدمات</span>
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="bg-[#1a2f4a] hover:bg-[#2a4a6a] transition p-3 rounded-xl text-center">
                    <i data-lucide="calendar-check" class="w-5 h-5 text-emerald-400 mx-auto"></i>
                    <span class="text-xs text-[#94a3b8] mt-1 block">رزروها</span>
                </a>
                <a href="{{ route('admin.admins.index') }}" class="bg-[#1a2f4a] hover:bg-[#2a4a6a] transition p-3 rounded-xl text-center">
                    <i data-lucide="user-cog" class="w-5 h-5 text-violet-400 mx-auto"></i>
                    <span class="text-xs text-[#94a3b8] mt-1 block">مدیران</span>
                </a>
                <a href="{{ route('admin.calendar') }}" class="bg-[#1a2f4a] hover:bg-[#2a4a6a] transition p-3 rounded-xl text-center">
                    <i data-lucide="calendar" class="w-5 h-5 text-amber-400 mx-auto"></i>
                    <span class="text-xs text-[#94a3b8] mt-1 block">تقویم</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== RECENT RESERVATIONS ===== -->
    <div class="bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <i data-lucide="clock" class="w-5 h-5 text-blue-400"></i>
                <h3 class="text-base font-bold text-white">آخرین رزروها</h3>
            </div>
            <span class="text-xs text-[#475569]">{{ isset($stats['recent_reservations']) ? $stats['recent_reservations']->count() : 0 }} رزرو</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[#1a2f4a]">
                        <th class="text-right py-2 px-3 text-[#64748b] font-semibold">کاربر</th>
                        <th class="text-right py-2 px-3 text-[#64748b] font-semibold">میز</th>
                        <th class="text-right py-2 px-3 text-[#64748b] font-semibold">تاریخ</th>
                        <th class="text-right py-2 px-3 text-[#64748b] font-semibold">شیفت</th>
                        <th class="text-right py-2 px-3 text-[#64748b] font-semibold">وضعیت</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($stats['recent_reservations']) && $stats['recent_reservations']->count() > 0)
                        @foreach($stats['recent_reservations'] as $res)
                        <tr class="border-b border-[#132238]">
                            <td class="py-2 px-3 text-[#cbd5e1]">{{ $res->user->name ?? 'نامشخص' }}</td>
                            <td class="py-2 px-3 text-[#cbd5e1]">میز {{ $res->desk->desk_number ?? '—' }}</td>
                            <td class="py-2 px-3 text-[#cbd5e1]">{{ $res->reservation_date ?? '—' }}</td>
                            <td class="py-2 px-3 text-[#cbd5e1]">{{ $res->shift_persian ?? '—' }}</td>
                            <td class="py-2 px-3">
                                <span class="badge badge-{{ $res->status }}">
                                    @switch($res->status)
                                        @case('active') فعال @break
                                        @case('pending') در انتظار @break
                                        @case('cancelled') لغو شده @break
                                        @case('completed') تکمیل شده @break
                                        @default {{ $res->status }}
                                    @endswitch
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-6 text-[#475569]">
                                <i data-lucide="calendar-off" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i>
                                <p>هیچ رزروی یافت نشد</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection