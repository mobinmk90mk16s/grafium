<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>مدیریت مدیران | GRAFIUM</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: {
                            950: '#080e1a',
                            900: '#0a1628',
                            800: '#0f1f33',
                            700: '#132238',
                            600: '#1a2f4a',
                            500: '#2a4a6a',
                        },
                        blue: {
                            400: '#60a5fa',
                            500: '#3b82f6',
                        },
                        emerald: {
                            400: '#34d399',
                            500: '#10b981',
                        },
                        rose: {
                            400: '#fb7185',
                            500: '#f43f5e',
                        },
                    },
                    fontFamily: {
                        vazir: ['Vazirmatn', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Vazirmatn Font --}}
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
            transition: all 0.15s ease;
            position: relative;
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

        .stat-card {
            background: #0f1f33;
            border: 1px solid #1a2f4a;
            border-radius: 12px;
            padding: 20px 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover {
            border-color: #2a4a6a;
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .table-wrap {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #1a2f4a;
            background: #0f1f33;
        }
        .table-wrap table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .table-wrap thead {
            background: #0a1628;
            border-bottom: 1px solid #1a2f4a;
        }
        .table-wrap thead th {
            padding: 14px 16px;
            text-align: right;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 1px solid #1a2f4a;
            white-space: nowrap;
        }
        .table-wrap tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #132238;
            color: #cbd5e1;
            vertical-align: middle;
        }
        .table-wrap tbody tr:last-child td {
            border-bottom: none;
        }
        .table-wrap tbody tr {
            transition: background 0.15s;
        }
        .table-wrap tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .badge {
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .badge-active {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .badge-pending {
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        .badge-cancelled {
            background: rgba(244, 63, 94, 0.12);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.2);
        }
        .badge-super_admin {
            background: rgba(59, 130, 246, 0.12);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        .badge-manager {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .badge-support {
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .btn-blue {
            background: #1a2f4a;
            color: #60a5fa;
            border: 1px solid #2a4a6a;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-blue:hover {
            background: #2a4a6a;
            border-color: #3a5a7a;
        }

        .btn-emerald {
            background: rgba(16, 185, 129, 0.08);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-emerald:hover {
            background: rgba(16, 185, 129, 0.15);
        }

        .btn-rose {
            background: rgba(244, 63, 94, 0.08);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.2);
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-rose:hover {
            background: rgba(244, 63, 94, 0.15);
        }

        .input-dark {
            background: #0a1628;
            border: 1px solid #1a2f4a;
            border-radius: 8px;
            padding: 10px 14px;
            color: #e2e8f0;
            font-size: 13px;
            width: 100%;
            transition: border 0.2s;
            font-family: 'Vazirmatn', sans-serif;
        }
        .input-dark:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .input-dark::placeholder {
            color: #475569;
        }
        .input-dark option {
            background: #0a1628;
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

        .form-card {
            background: #0f1f33;
            border: 1px solid #1a2f4a;
            border-radius: 12px;
            padding: 28px;
            max-width: 700px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-left: none;
                border-bottom: 1px solid #1a2f4a;
            }
            .main-content {
                margin-right: 0 !important;
                padding: 16px !important;
            }
        }
    </style>
</head>
<body>

    <!-- ============================================================
    SIDEBAR
    ============================================================ -->
    <aside class="sidebar fixed right-0 top-0 w-[270px] h-screen bg-[#0a1628] border-l border-[#1a2f4a] p-4 overflow-y-auto z-50">
        <div class="text-center mb-6 pb-4 border-b border-[#1a2f4a]">
            <h2 class="text-2xl font-extrabold text-white tracking-tight">GRAFIUM</h2>
            <p class="text-[11px] text-[#475569] mt-1">پنل مدیریت</p>
        </div>

        <nav class="space-y-5">
            <div>
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">اصلی</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 text-[#60a5fa]"></i> داشبورد
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">کاربران</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="users" class="w-5 h-5 text-[#60a5fa]"></i> کاربران
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.admins.index') }}" class="menu-item active flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="user-cog" class="w-5 h-5 text-[#60a5fa]"></i> مدیران
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()">
                            <i data-lucide="star" class="w-5 h-5 text-[#60a5fa]"></i> نظرات
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">فروشگاه</p>
                <ul class="space-y-0.5">
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="package" class="w-5 h-5 text-[#60a5fa]"></i> محصولات<span class="menu-indicator"></span></a></li>
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="tags" class="w-5 h-5 text-[#60a5fa]"></i> دسته‌بندی‌ها<span class="menu-indicator"></span></a></li>
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="shopping-cart" class="w-5 h-5 text-[#60a5fa]"></i> سفارشات<span class="menu-indicator"></span></a></li>
                </ul>
            </div>

            <div>
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">گزارشات</p>
                <ul class="space-y-0.5">
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="chart-line" class="w-5 h-5 text-[#60a5fa]"></i> فروش<span class="menu-indicator"></span></a></li>
                </ul>
            </div>

            <div>
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">ابزارها</p>
                <ul class="space-y-0.5">
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="image" class="w-5 h-5 text-[#60a5fa]"></i> اسلایدر<span class="menu-indicator"></span></a></li>
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="calendar" class="w-5 h-5 text-[#60a5fa]"></i> تقویم<span class="menu-indicator"></span></a></li>
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="newspaper" class="w-5 h-5 text-[#60a5fa]"></i> بلاگ<span class="menu-indicator"></span></a></li>
                </ul>
            </div>

            <div>
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">سیستم</p>
                <ul class="space-y-0.5">
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="settings" class="w-5 h-5 text-[#60a5fa]"></i> تنظیمات<span class="menu-indicator"></span></a></li>
                    <li><a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition" onclick="showComingSoon()"><i data-lucide="bot" class="w-5 h-5 text-[#60a5fa]"></i> هوش مصنوعی<span class="menu-indicator"></span></a></li>
                </ul>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST" class="pt-4 border-t border-[#1a2f4a]">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:bg-rose-500/10 transition w-full text-sm font-medium">
                    <i data-lucide="log-out" class="w-5 h-5"></i> خروج از پنل
                </button>
            </form>
        </nav>
    </aside>

    <!-- ============================================================
    MAIN CONTENT
    ============================================================ -->
    <main class="mr-[270px] p-6 min-h-screen">

        <!-- HEADER -->
        <div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-white">
                    @if(isset($admin) && Route::currentRouteName() == 'admin.admins.edit')
                        ویرایش مدیر
                    @elseif(Route::currentRouteName() == 'admin.admins.create')
                        افزودن مدیر جدید
                    @else
                        مدیریت مدیران
                    @endif
                </h1>
                <p class="text-sm text-[#475569] mt-0.5">مدیریت همه مدیران و دسترسی‌های سیستم</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
                <div class="avatar-icon">
                    <i data-lucide="user-circle" class="w-5 h-5"></i>
                </div>
            </div>
        </div>

        <!-- ============================================================
        فرم افزودن/ویرایش مدیر
        ============================================================ -->
        @if(Route::currentRouteName() == 'admin.admins.create' || Route::currentRouteName() == 'admin.admins.edit')
        <div class="form-card">
            <div class="flex items-center gap-3 mb-6">
                <i data-lucide="{{ isset($admin) ? 'pencil' : 'user-plus' }}" class="w-6 h-6 text-[#60a5fa]"></i>
                <h2 class="text-xl font-bold text-white">
                    {{ isset($admin) ? 'ویرایش مدیر' : 'افزودن مدیر جدید' }}
                </h2>
            </div>

            <form method="POST" action="{{ isset($admin) ? route('admin.admins.update', $admin->id) : route('admin.admins.store') }}">
                @csrf
                @if(isset($admin))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1.5">نام کامل</label>
                        <input type="text" name="name" value="{{ old('name', $admin->name ?? '') }}" 
                               class="input-dark" placeholder="مثال: علی محمدی" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1.5">ایمیل</label>
                        <input type="email" name="email" value="{{ old('email', $admin->email ?? '') }}" 
                               class="input-dark" placeholder="admin@example.com" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1.5">شماره تماس</label>
                        <input type="text" name="phone" value="{{ old('phone', $admin->phone ?? '') }}" 
                               class="input-dark" placeholder="مثال: 09123456789" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1.5">نقش کاربری</label>
                        <select name="role" class="input-dark" required>
                            <option value="super_admin" {{ old('role', $admin->role ?? '') == 'super_admin' ? 'selected' : '' }}>مدیر اصلی</option>
                            <option value="manager" {{ old('role', $admin->role ?? '') == 'manager' ? 'selected' : '' }}>مدیر</option>
                            <option value="support" {{ old('role', $admin->role ?? '') == 'support' ? 'selected' : '' }}>پشتیبان</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1.5">
                            {{ isset($admin) ? 'رمز عبور جدید (اختیاری)' : 'رمز عبور' }}
                        </label>
                        <input type="password" name="password" class="input-dark" 
                               placeholder="{{ isset($admin) ? 'برای تغییر وارد کنید' : 'حداقل ۸ کاراکتر' }}" 
                               {{ isset($admin) ? '' : 'required' }} />
                    </div>

                    @if(isset($admin))
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1.5">وضعیت</label>
                        <select name="is_active" class="input-dark">
                            <option value="1" {{ old('is_active', $admin->is_active ?? 1) == 1 ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ old('is_active', $admin->is_active ?? 1) == 0 ? 'selected' : '' }}>غیرفعال</option>
                        </select>
                    </div>
                    @endif
                </div>

                <div class="flex gap-3 mt-6 pt-4 border-t border-[#1a2f4a]">
                    <button type="submit" class="btn-emerald">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        {{ isset($admin) ? 'به‌روزرسانی مدیر' : 'ایجاد مدیر' }}
                    </button>
                    <a href="{{ route('admin.admins.index') }}" class="btn-blue">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> بازگشت
                    </a>
                </div>

                @if($errors->any())
                <div class="mt-4 p-3 bg-rose-500/10 border border-rose-500/20 rounded-lg text-rose-400 text-sm">
                    <ul class="list-disc pr-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </form>
        </div>

        <!-- ============================================================
        لیست مدیران (زیر فرم)
        ============================================================ -->
        <div class="table-wrap mt-6">
            <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
                <span class="text-xs text-[#475569]">{{ isset($admins) ? $admins->count() : 0 }} مدیر</span>
            </div>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>مدیر</th>
                            <th>ایمیل</th>
                            <th>نقش</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($admins) && $admins->count() > 0)
                            @foreach($admins as $a)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[10px] text-[#60a5fa] font-bold">
                                            {{ substr($a->name, 0, 1) }}
                                        </div>
                                        <span>{{ $a->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $a->email }}</td>
                                <td>
                                    <span class="badge badge-{{ $a->role }}">
                                        @switch($a->role)
                                            @case('super_admin') مدیر اصلی @break
                                            @case('manager') مدیر @break
                                            @case('support') پشتیبان @break
                                            @default {{ $a->role }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $a->is_active ? 'active' : 'cancelled' }}">
                                        {{ $a->is_active ? 'فعال' : 'غیرفعال' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.admins.edit', $a->id) }}" class="text-amber-400 hover:text-amber-300 transition p-1">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        @if($a->id != Auth::guard('admin')->id())
                                        <form action="{{ route('admin.admins.destroy', $a->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این مدیر اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300 transition p-1">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-8 text-[#475569]">
                                    <i data-lucide="user-cog" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i>
                                    <p>هیچ مدیری یافت نشد</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============================================================
        صفحه لیست مدیران (وقتی در حالت index هستیم)
        ============================================================ -->
        @else
        <div class="flex flex-wrap justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-white">مدیران سیستم</h2>
                <p class="text-sm text-[#475569]">مدیریت همه مدیران و دسترسی‌های سیستم</p>
            </div>
            <a href="{{ route('admin.admins.create') }}" class="btn-emerald">
                <i data-lucide="plus" class="w-4 h-4"></i> مدیر جدید
            </a>
        </div>

        <div class="table-wrap">
            <div class="flex items-center justify-between p-4 border-b border-[#1a2f4a]">
                <span class="text-xs text-[#475569]">{{ isset($admins) ? $admins->count() : 0 }} مدیر</span>
            </div>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>مدیر</th>
                            <th>ایمیل</th>
                            <th>نقش</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($admins) && $admins->count() > 0)
                            @foreach($admins as $a)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[10px] text-[#60a5fa] font-bold">
                                            {{ substr($a->name, 0, 1) }}
                                        </div>
                                        <span>{{ $a->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $a->email }}</td>
                                <td>
                                    <span class="badge badge-{{ $a->role }}">
                                        @switch($a->role)
                                            @case('super_admin') مدیر اصلی @break
                                            @case('manager') مدیر @break
                                            @case('support') پشتیبان @break
                                            @default {{ $a->role }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $a->is_active ? 'active' : 'cancelled' }}">
                                        {{ $a->is_active ? 'فعال' : 'غیرفعال' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.admins.edit', $a->id) }}" class="text-amber-400 hover:text-amber-300 transition p-1">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        @if($a->id != Auth::guard('admin')->id())
                                        <form action="{{ route('admin.admins.destroy', $a->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این مدیر اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300 transition p-1">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-8 text-[#475569]">
                                    <i data-lucide="user-cog" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i>
                                    <p>هیچ مدیری یافت نشد</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- ============================================================
        COMING SOON OVERLAY
        ============================================================ -->
        <div id="coming-soon-overlay" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[999] hidden">
            <div class="bg-[#0f1f33] p-8 rounded-2xl border border-[#1a2f4a] max-w-md w-full mx-4 text-center">
                <div class="w-16 h-16 rounded-full bg-[#1a2f4a] flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="construction" class="w-8 h-8 text-[#60a5fa]"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">در حال توسعه</h3>
                <p class="text-[#94a3b8] mb-6">این بخش به زودی به پنل مدیریت اضافه خواهد شد.</p>
                <button onclick="hideComingSoon()" class="btn-blue w-full justify-center">متوجه شدم</button>
            </div>
        </div>

    </main>

    <!-- ============================================================
    SCRIPTS
    ============================================================ -->
    <script>
        lucide.createIcons();

        function showComingSoon() {
            document.getElementById('coming-soon-overlay').classList.remove('hidden');
        }

        function hideComingSoon() {
            document.getElementById('coming-soon-overlay').classList.add('hidden');
        }
    </script>

</body>
</html>