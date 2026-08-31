<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>داشبورد بلاگ | GRAFIUM</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: { 900: '#0a1628', 800: '#0f1f33', 700: '#132238', 600: '#1a2f4a' },
                        blue: { 400: '#60a5fa', 500: '#3b82f6' },
                        emerald: { 400: '#34d399' },
                        rose: { 400: '#fb7185' },
                        amber: { 400: '#fbbf24' },
                        violet: { 400: '#a78bfa' },
                    },
                    fontFamily: { vazir: ['Vazirmatn', 'sans-serif'] }
                }
            }
        }
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Vazirmatn', sans-serif; background: #080e1a; color: #e2e8f0; direction: rtl; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0a1628; }
        ::-webkit-scrollbar-thumb { background: #1a2f4a; border-radius: 10px; }

        .sidebar { scrollbar-width: thin; scrollbar-color: #1a2f4a transparent; }
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: #1a2f4a; border-radius: 10px; }

        .menu-item { transition: all 0.2s ease; position: relative; cursor: pointer; }
        .menu-item:hover { background: rgba(255, 255, 255, 0.04); color: #f1f5f9; }
        .menu-item.active { background: rgba(59, 130, 246, 0.08); color: #60a5fa; }
        .menu-item.active i { color: #60a5fa; }
        .menu-item .menu-indicator {
            position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 24px; background: #3b82f6; border-radius: 0 4px 4px 0;
            opacity: 0; transition: opacity 0.2s;
        }
        .menu-item.active .menu-indicator { opacity: 1; }

        .avatar-icon { width: 36px; height: 36px; border-radius: 50%; background: #1a2f4a; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 16px; }

        .card {
            background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 16px; padding: 24px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .card:hover { border-color: #2a4a6a; transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.4); }

        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;
        }
        .stat-card {
            background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 14px; padding: 20px;
            text-align: center; transition: all 0.3s;
        }
        .stat-card:hover { border-color: #2a4a6a; transform: translateY(-2px); }
        .stat-card .number { font-size: 28px; font-weight: 800; color: #60a5fa; display: block; }
        .stat-card .label { font-size: 13px; color: #64748b; }

        .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

        .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

        .badge {
            padding: 4px 14px; border-radius: 9999px; font-size: 11px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
        }
        .badge-published { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
        .badge-draft { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }
        .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
        .badge-archived { background: rgba(239, 68, 68, 0.15); color: #fb7185; border: 1px solid rgba(239, 68, 68, 0.2); }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        .alert-success {
            background: rgba(52, 211, 153, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.2);
            color: #34d399;
        }
        .alert-error {
            background: rgba(244, 63, 94, 0.12);
            border: 1px solid rgba(244, 63, 94, 0.2);
            color: #fb7185;
        }

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; border-left: none; border-bottom: 1px solid #1a2f4a; }
            .main-content { margin-right: 0 !important; padding: 16px !important; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar fixed right-0 top-0 w-[270px] h-screen bg-[#0a1628] border-l border-[#1a2f4a] p-4 overflow-y-auto z-50">
        <div class="text-center mb-6 pb-4 border-b border-[#1a2f4a]">
            <div class="flex items-center justify-center gap-2">
                <i data-lucide="gem" class="w-6 h-6 text-blue-400"></i>
                <h2 class="text-2xl font-extrabold text-white tracking-tight">GRAFIUM</h2>
            </div>
            <p class="text-[11px] text-[#475569] mt-1">پنل مدیریت</p>
        </div>

        <nav class="space-y-5">
            <div>
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">بلاگ</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('admin.blog.dashboard') }}" class="menu-item active flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 text-[#60a5fa]"></i> داشبورد بلاگ
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog.posts') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="newspaper" class="w-5 h-5 text-[#60a5fa]"></i> همه پست‌ها
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog.categories.index') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="folder" class="w-5 h-5 text-[#60a5fa]"></i> دسته‌بندی‌ها
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog.tags.index') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="tag" class="w-5 h-5 text-[#60a5fa]"></i> تگ‌ها
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog.comments.index') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="message-square" class="w-5 h-5 text-[#60a5fa]"></i> نظرات
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">ابزارها</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('admin.calendar') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="calendar" class="w-5 h-5 text-[#60a5fa]"></i> تقویم
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
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

    <!-- ===== MAIN CONTENT ===== -->
    <main class="mr-[270px] p-6 min-h-screen main-content">

        <!-- HEADER -->
        <div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
            <div>
                <div class="flex items-center gap-3">
                    <i data-lucide="layout-dashboard" class="w-6 h-6 text-blue-400"></i>
                    <h1 class="text-2xl font-extrabold text-white">داشبورد بلاگ</h1>
                </div>
                <p class="text-sm text-[#475569] mt-0.5 mr-9">نمای کلی از وضعیت بلاگ</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
                <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
            </div>
        </div>

        <!-- ===== ALERT MESSAGES ===== -->
        @if(session('success'))
            <div class="alert alert-success">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- ===== STATS ===== -->
        <div class="stats-grid">
            <div class="stat-card">
                <span class="number" style="color: #60a5fa;">{{ $stats['total'] ?? 0 }}</span>
                <span class="label">کل پست‌ها</span>
            </div>
            <div class="stat-card">
                <span class="number" style="color: #34d399;">{{ $stats['published'] ?? 0 }}</span>
                <span class="label">منتشر شده</span>
            </div>
            <div class="stat-card">
                <span class="number" style="color: #94a3b8;">{{ $stats['draft'] ?? 0 }}</span>
                <span class="label">پیش‌نویس</span>
            </div>
            <div class="stat-card">
                <span class="number" style="color: #fbbf24;">{{ $stats['pending'] ?? 0 }}</span>
                <span class="label">در انتظار</span>
            </div>
            <div class="stat-card">
                <span class="number" style="color: #a78bfa;">{{ $stats['total_comments'] ?? 0 }}</span>
                <span class="label">نظرات</span>
            </div>
            <div class="stat-card">
                <span class="number" style="color: #fb7185;">{{ $stats['pending_comments'] ?? 0 }}</span>
                <span class="label">نظرات در انتظار</span>
            </div>
        </div>

        <!-- ===== QUICK ACCESS CARDS ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.blog.create') }}" class="card">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                        <i data-lucide="plus" class="w-6 h-6 text-emerald-400"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold">پست جدید</h3>
                        <p class="text-xs text-[#64748b]">ایجاد پست جدید</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.blog.posts') }}" class="card">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                        <i data-lucide="newspaper" class="w-6 h-6 text-blue-400"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold">همه پست‌ها</h3>
                        <p class="text-xs text-[#64748b]">مشاهده همه پست‌ها</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.blog.categories.index') }}" class="card">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                        <i data-lucide="folder" class="w-6 h-6 text-emerald-400"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold">دسته‌بندی‌ها</h3>
                        <p class="text-xs text-[#64748b]">مدیریت دسته‌بندی‌ها</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.blog.comments.index') }}" class="card">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-violet-500/10 flex items-center justify-center">
                        <i data-lucide="message-square" class="w-6 h-6 text-violet-400"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold">نظرات</h3>
                        <p class="text-xs text-[#64748b]">مدیریت نظرات</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- ===== RECENT POSTS ===== -->
        <div class="mt-6 bg-[#0f1f33] border border-[#1a2f4a] rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-blue-400"></i>
                    <h3 class="text-base font-bold text-white">آخرین پست‌ها</h3>
                </div>
                <a href="{{ route('admin.blog.posts') }}" class="text-sm text-blue-400 hover:text-blue-300 transition">
                    مشاهده همه
                    <i data-lucide="arrow-left" class="w-4 h-4 inline"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#1a2f4a]">
                            <th class="text-right py-2 px-3 text-[#64748b] font-semibold">عنوان</th>
                            <th class="text-right py-2 px-3 text-[#64748b] font-semibold">وضعیت</th>
                            <th class="text-right py-2 px-3 text-[#64748b] font-semibold">تاریخ</th>
                            <th class="text-right py-2 px-3 text-[#64748b] font-semibold">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr class="border-b border-[#132238]">
                            <td class="py-2 px-3 text-[#cbd5e1]">{{ $post->title }}</td>
                            <td class="py-2 px-3">
                                <span class="badge badge-{{ $post->status }}">
                                    @switch($post->status)
                                        @case('published') منتشر شده @break
                                        @case('draft') پیش‌نویس @break
                                        @case('pending') در انتظار @break
                                        @case('archived') بایگانی @break
                                        @default {{ $post->status }}
                                    @endswitch
                                </span>
                            </td>
                            <td class="py-2 px-3 text-[#94a3b8]">{{ $post->created_at ? $post->created_at->format('Y/m/d') : '—' }}</td>
                            <td class="py-2 px-3">
                                <div class="flex items-center gap-2 justify-center">
                                    <a href="{{ route('admin.blog.edit', $post->id) }}" class="text-blue-400 hover:text-blue-300 transition">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این پست اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-rose-300 transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-[#475569]">هیچ پستی یافت نشد</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>