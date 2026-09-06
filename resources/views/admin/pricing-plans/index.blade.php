<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>قیمت‌گذاری | {{ $service->title }} | GRAFIUM</title>

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

    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0a1628; }
        ::-webkit-scrollbar-thumb { background: #1a2f4a; border-radius: 10px; }

        body { font-family: 'Vazirmatn', sans-serif; background: #080e1a; color: #e2e8f0; direction: rtl; }

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

        .table-wrap {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #1a2f4a;
            background: #0f1f33;
        }
        .table-wrap table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table-wrap thead { background: #0a1628; border-bottom: 1px solid #1a2f4a; position: sticky; top: 0; z-index: 10; }
        .table-wrap thead th {
            padding: 14px 16px; text-align: center; font-weight: 700; font-size: 12px;
            text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8;
            border-bottom: 1px solid #1a2f4a; white-space: nowrap;
        }
        .table-wrap tbody td {
            padding: 12px 16px; border-bottom: 1px solid #132238; color: #cbd5e1; vertical-align: middle;
            text-align: center;
        }
        .table-wrap tbody tr { transition: background 0.15s; }
        .table-wrap tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

        .badge {
            padding: 4px 14px; border-radius: 9999px; font-size: 11px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
        }
        .badge-active { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
        .badge-inactive { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }
        .badge-default { background: rgba(212, 163, 115, 0.15); color: #d4a373; border: 1px solid rgba(212, 163, 115, 0.2); }

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

        .stats-banner {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px; padding: 16px 20px; background: #0f1f33;
            border-radius: 12px; border: 1px solid #1a2f4a; margin-bottom: 20px;
        }
        .stats-banner .stat-item { text-align: center; }
        .stats-banner .stat-item .num { font-size: 20px; font-weight: 700; color: #60a5fa; }
        .stats-banner .stat-item .label { font-size: 11px; color: #64748b; }

        .filter-bar {
            display: flex; flex-wrap: wrap; gap: 12px; align-items: center;
            padding: 16px 20px; background: #0a1628; border-radius: 12px;
            border: 1px solid #1a2f4a; margin-bottom: 20px;
        }
        .filter-bar input, .filter-bar select {
            background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 8px;
            padding: 8px 14px; color: #e2e8f0; font-size: 13px; font-family: 'Vazirmatn', sans-serif;
        }

        .action-buttons {
            display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;
        }
        .action-buttons .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid transparent;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Vazirmatn', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .action-buttons .btn-action:hover {
            transform: translateY(-2px);
        }

        .action-buttons .btn-action-toggle {
            background: rgba(251, 191, 36, 0.08);
            color: #fbbf24;
            border-color: rgba(251, 191, 36, 0.2);
        }
        .action-buttons .btn-action-toggle:hover {
            background: rgba(251, 191, 36, 0.15);
        }

        .action-buttons .btn-action-delete {
            background: rgba(244, 63, 94, 0.08);
            color: #fb7185;
            border-color: rgba(244, 63, 94, 0.2);
        }
        .action-buttons .btn-action-delete:hover {
            background: rgba(244, 63, 94, 0.15);
        }

        .action-buttons .btn-action-default {
            background: rgba(212, 163, 115, 0.08);
            color: #d4a373;
            border-color: rgba(212, 163, 115, 0.2);
        }
        .action-buttons .btn-action-default:hover {
            background: rgba(212, 163, 115, 0.15);
        }

        .toast-container {
            position: fixed; bottom: 24px; left: 24px; z-index: 9999;
            display: flex; flex-direction: column; gap: 8px;
        }
        .toast-item {
            padding: 14px 20px; border-radius: 12px; min-width: 300px; max-width: 450px;
            backdrop-filter: blur(8px); box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            animation: slideIn 0.4s ease forwards;
            display: flex; align-items: center; gap: 12px;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .toast-item.hiding { animation: slideOut 0.3s ease forwards; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }

        .toast-success { background: rgba(52, 211, 153, 0.15); border-color: rgba(52, 211, 153, 0.3); color: #34d399; }
        .toast-error { background: rgba(244, 63, 94, 0.15); border-color: rgba(244, 63, 94, 0.3); color: #fb7185; }
        .toast-info { background: rgba(59, 130, 246, 0.15); border-color: rgba(59, 130, 246, 0.3); color: #60a5fa; }

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

        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px);
            display: none; align-items: center; justify-content: center; z-index: 999;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 20px;
            padding: 32px; max-width: 550px; width: 90%; max-height: 90vh; overflow-y: auto;
        }

        .input-dark {
            background: #0a1628; border: 1px solid #1a2f4a; border-radius: 8px; padding: 10px 14px;
            color: #e2e8f0; font-size: 13px; width: 100%; transition: border 0.2s; font-family: 'Vazirmatn', sans-serif;
        }
        .input-dark:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .input-dark::placeholder { color: #475569; }

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; border-left: none; border-bottom: 1px solid #1a2f4a; }
            .main-content { margin-right: 0 !important; padding: 16px !important; }
            .table-wrap { overflow-x: auto; }
            .table-wrap table { font-size: 11px; }
            .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
            .filter-bar { flex-direction: column; align-items: stretch; }
            .stats-banner { grid-template-columns: repeat(2, 1fr); }
            .toast-item { min-width: auto; max-width: 90%; }
            .action-buttons .btn-action { padding: 4px 8px; font-size: 11px; }
        }
        @media (max-width: 480px) {
            .table-wrap table { font-size: 10px; }
            .table-wrap thead th, .table-wrap tbody td { padding: 6px 4px; }
            .stats-banner { grid-template-columns: 1fr; }
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
                <p class="text-[10px] font-bold text-[#475569] uppercase tracking-wider px-3 mb-2">مدیریت</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('admin.services.index') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="settings" class="w-5 h-5 text-[#60a5fa]"></i> خدمات
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reservations.index') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="calendar-check" class="w-5 h-5 text-[#60a5fa]"></i> رزروها
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

    <!-- ===== TOAST ===== -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="mr-[270px] p-6 min-h-screen main-content">

        <!-- HEADER -->
        <div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
            <div>
                <div class="flex items-center gap-3">
                    <i data-lucide="wallet" class="w-6 h-6 text-gold-400"></i>
                    <h1 class="text-2xl font-extrabold text-white">قیمت‌گذاری</h1>
                    <span class="text-sm text-[#475569]">({{ $service->title }})</span>
                </div>
                <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت پلن‌های قیمت‌گذاری {{ $service->title }}</p>
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

        <!-- ===== STATS BANNER ===== -->
        <div class="stats-banner">
            <div class="stat-item">
                <span class="num">{{ $stats['total'] ?? 0 }}</span>
                <span class="label">کل پلن‌ها</span>
            </div>
            <div class="stat-item">
                <span class="num" style="color: #34d399;">{{ $stats['active'] ?? 0 }}</span>
                <span class="label">فعال</span>
            </div>
            <div class="stat-item">
                <span class="num" style="color: #94a3b8;">{{ $stats['inactive'] ?? 0 }}</span>
                <span class="label">غیرفعال</span>
            </div>
            <div class="stat-item">
                <a href="{{ route('admin.services.index') }}" class="text-blue-400 hover:text-blue-300 text-sm">
                    <i data-lucide="arrow-right" class="w-4 h-4 inline"></i> بازگشت
                </a>
            </div>
        </div>

        <!-- ===== FILTER BAR ===== -->
        <div class="filter-bar">
            <input type="text" id="searchInput" placeholder="جستجو در پلن‌ها..." onkeyup="filterTable()" class="w-48" />
            <select id="statusFilter" onchange="filterTable()" class="filter-select">
                <option value="all">همه وضعیت‌ها</option>
                <option value="active">فعال</option>
                <option value="inactive">غیرفعال</option>
            </select>
            <button class="btn-blue" onclick="filterTable()">
                <i data-lucide="search" class="w-4 h-4"></i> جستجو
            </button>
            <button class="btn-rose" onclick="resetFilters()">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> بازنشانی
            </button>
            <button class="btn-emerald mr-auto" onclick="openCreateModal()">
                <i data-lucide="plus" class="w-4 h-4"></i> پلن جدید
            </button>
        </div>

        <!-- ===== TABLE ===== -->
        <div class="table-wrap">
            <div class="overflow-x-auto">
                <table id="plansTable">
                    <thead>
                        <tr>
                            <th style="min-width:40px;">#</th>
                            <th style="min-width:120px;">عنوان</th>
                            <th style="min-width:120px;">قیمت</th>
                            <th style="min-width:100px;">مدت</th>
                            <th style="min-width:150px;">توضیحات</th>
                            <th style="min-width:80px;">وضعیت</th>
                            <th style="min-width:80px;">پیش‌فرض</th>
                            <th style="min-width:180px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                        <tr data-status="{{ $plan->status }}" data-search="{{ $plan->title }} {{ $plan->description }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-medium">{{ $plan->title }}</td>
                            <td class="text-emerald-400 font-bold">{{ number_format($plan->price) }} تومان</td>
                            <td>{{ $plan->duration }} {{ $plan->duration_type_persian }}</td>
                            <td class="text-right max-w-xs truncate">{{ $plan->description ?? '—' }}</td>
                            <td>
                                <span class="badge badge-{{ $plan->status }}">
                                    {{ $plan->status_persian }}
                                </span>
                            </td>
                            <td>
                                @if($plan->is_default)
                                    <span class="badge badge-default">پیش‌فرض</span>
                                @else
                                    <span class="text-[#475569] text-sm">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <!-- دکمه تغییر وضعیت -->
                                    <button onclick="toggleStatus({{ $plan->id }})" class="btn-action btn-action-toggle" title="{{ $plan->status === 'active' ? 'غیرفعال کردن' : 'فعال کردن' }}">
                                        <i data-lucide="{{ $plan->status === 'active' ? 'pause-circle' : 'play-circle' }}" class="w-4 h-4"></i>
                                    </button>

                                    <!-- دکمه تنظیم به عنوان پیش‌فرض -->
                                    @if(!$plan->is_default)
                                        <button onclick="setDefault({{ $plan->id }})" class="btn-action btn-action-default" title="تنظیم به عنوان پیش‌فرض">
                                            <i data-lucide="star" class="w-4 h-4"></i>
                                        </button>
                                    @endif

                                    <!-- دکمه حذف -->
                                    <button onclick="deletePlan({{ $plan->id }})" class="btn-action btn-action-delete" title="حذف">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-[#475569]">
                                <i data-lucide="wallet" class="w-12 h-12 mx-auto text-[#475569] mb-3"></i>
                                <p>هیچ پلن قیمت‌گذاری یافت نشد</p>
                                <p class="text-xs mt-1">برای افزودن پلن جدید، روی دکمه "پلن جدید" کلیک کنید</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- ============================================================
    MODAL: افزودن/ویرایش پلن
    ============================================================ -->
    <div id="planModal" class="modal-overlay">
        <div class="modal-box">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="wallet" class="w-5 h-5 text-gold-400"></i>
                    <h3 class="text-xl font-bold text-white" id="modalTitle">افزودن پلن جدید</h3>
                </div>
                <button onclick="closeModal()" class="text-[#64748b] hover:text-white transition">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="planForm" method="POST">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">عنوان پلن</label>
                        <input type="text" id="planTitle" name="title" class="input-dark" placeholder="مثال: عادی, VIP, اقتصادی" required />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">قیمت (تومان)</label>
                            <input type="number" id="planPrice" name="price" class="input-dark" placeholder="۵۰۰۰۰۰" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">مدت زمان</label>
                            <div class="flex gap-2">
                                <input type="number" id="planDuration" name="duration" class="input-dark" value="1" min="1" style="width:60px;" />
                                <select id="planDurationType" name="duration_type" class="input-dark">
                                    <option value="hour">ساعت</option>
                                    <option value="shift">شیفت</option>
                                    <option value="day">روز</option>
                                    <option value="month">ماه</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">توضیحات</label>
                        <textarea id="planDescription" name="description" class="input-dark" rows="2" placeholder="توضیحات پلن..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">وضعیت</label>
                            <select id="planStatus" name="status" class="input-dark">
                                <option value="active">فعال</option>
                                <option value="inactive">غیرفعال</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#94a3b8] mb-1">پلن پیش‌فرض</label>
                            <select id="planDefault" name="is_default" class="input-dark">
                                <option value="0">خیر</option>
                                <option value="1">بله</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">ویژگی‌ها (JSON)</label>
                        <textarea id="planFeatures" name="features" class="input-dark" rows="3" placeholder='["اینترنت پرسرعت", "پشتیبانی ۲۴ ساعته"]'></textarea>
                        <p class="text-xs text-[#475569] mt-1">ویژگی‌ها را به صورت آرایه JSON وارد کنید (اختیاری)</p>
                    </div>
                </div>

                <div class="flex gap-3 mt-6 pt-4 border-t border-[#1a2f4a]">
                    <button type="submit" class="btn-gold w-full justify-center" id="submitBtn">
                        <i data-lucide="save" class="w-4 h-4"></i> ذخیره
                    </button>
                    <button type="button" onclick="closeModal()" class="btn-rose w-full justify-center">انصراف</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================
    SCRIPTS
    ============================================================ -->
    <script>
        lucide.createIcons();

        // ============================================================
        // FILTER TABLE
        // ============================================================
        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const status = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#plansTable tbody tr');

            rows.forEach(row => {
                const title = row.dataset.search?.toLowerCase() || '';
                const rowStatus = row.dataset.status || '';
                let show = true;

                if (search && !title.includes(search)) {
                    show = false;
                }
                if (status !== 'all' && rowStatus !== status) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = 'all';
            filterTable();
            showToast('فیلترها بازنشانی شدند', 'info');
        }

        // ============================================================
        // MODAL
        // ============================================================
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'افزودن پلن جدید';
            document.getElementById('submitBtn').innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> ذخیره';
            document.getElementById('planForm').action = "{{ route('admin.pricing-plans.store', $service->id) }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('planTitle').value = '';
            document.getElementById('planPrice').value = '';
            document.getElementById('planDuration').value = '1';
            document.getElementById('planDurationType').value = 'hour';
            document.getElementById('planDescription').value = '';
            document.getElementById('planStatus').value = 'active';
            document.getElementById('planDefault').value = '0';
            document.getElementById('planFeatures').value = '';
            document.getElementById('planModal').classList.add('active');
            lucide.createIcons();
        }

        function openEditModal(id) {
            fetch(`/admin/pricing-plans/{{ $service->id }}/${id}/edit`)
                .then(response => response.text())
                .then(html => {
                    const temp = document.createElement('div');
                    temp.innerHTML = html;

                    document.getElementById('modalTitle').textContent = 'ویرایش پلن';
                    document.getElementById('submitBtn').innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> ذخیره تغییرات';
                    document.getElementById('planForm').action = `/admin/pricing-plans/{{ $service->id }}/${id}`;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('planTitle').value = temp.querySelector('[name="title"]')?.value || '';
                    document.getElementById('planPrice').value = temp.querySelector('[name="price"]')?.value || '';
                    document.getElementById('planDuration').value = temp.querySelector('[name="duration"]')?.value || '1';
                    document.getElementById('planDurationType').value = temp.querySelector('[name="duration_type"]')?.value || 'hour';
                    document.getElementById('planDescription').value = temp.querySelector('[name="description"]')?.value || '';
                    document.getElementById('planStatus').value = temp.querySelector('[name="status"]')?.value || 'active';
                    document.getElementById('planDefault').value = temp.querySelector('[name="is_default"]')?.value || '0';
                    document.getElementById('planFeatures').value = temp.querySelector('[name="features"]')?.value || '';

                    document.getElementById('planModal').classList.add('active');
                    lucide.createIcons();
                })
                .catch(() => {
                    showToast('خطا در بارگذاری اطلاعات', 'error');
                });
        }

        function closeModal() {
            document.getElementById('planModal').classList.remove('active');
        }

        // ============================================================
        // TOGGLE STATUS
        // ============================================================
        function toggleStatus(id) {
            if (!confirm('آیا از تغییر وضعیت این پلن اطمینان دارید؟')) return;

            fetch(`/admin/pricing-plans/{{ $service->id }}/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('وضعیت پلن با موفقیت تغییر کرد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در تغییر وضعیت', 'error'));
        }

        // ============================================================
        // SET DEFAULT
        // ============================================================
        function setDefault(id) {
            if (!confirm('آیا از تنظیم این پلن به عنوان پیش‌فرض اطمینان دارید؟')) return;

            fetch(`/admin/pricing-plans/{{ $service->id }}/${id}/set-default`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('پلن پیش‌فرض با موفقیت تنظیم شد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در تنظیم پلن پیش‌فرض', 'error'));
        }

        // ============================================================
        // DELETE PLAN
        // ============================================================
        function deletePlan(id) {
            if (!confirm('آیا از حذف این پلن اطمینان دارید؟ توجه: هر خدمت باید حداقل یک پلن داشته باشد.')) return;

            fetch(`/admin/pricing-plans/{{ $service->id }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('پلن با موفقیت حذف شد', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(data.message || 'خطا در حذف پلن', 'error');
                }
            })
            .catch(() => showToast('خطا در حذف پلن', 'error'));
        }

        // ============================================================
        // TOAST
        // ============================================================
        function showToast(message, type = 'info', duration = 3000) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast-item toast-${type}`;
            const icons = { success: 'check-circle', error: 'alert-circle', warning: 'alert-triangle', info: 'info' };
            toast.innerHTML = `
                <i data-lucide="${icons[type] || 'info'}" class="w-5 h-5 flex-shrink-0"></i>
                <span class="text-sm font-medium">${message}</span>
            `;
            container.appendChild(toast);
            lucide.createIcons();
            setTimeout(() => { toast.classList.add('hiding'); setTimeout(() => toast.remove(), 300); }, duration);
        }

        // ============================================================
        // KEYBOARD SHORTCUTS
        // ============================================================
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        document.querySelector('.modal-overlay')?.addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>

</body>
</html>