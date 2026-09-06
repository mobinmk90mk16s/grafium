<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>مدیریت آیتم‌ها | {{ $service->title }} | GRAFIUM</title>

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

        .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

        .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

        .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

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
        }
        .action-buttons .btn-action:hover {
            transform: translateY(-2px);
        }
        .action-buttons .btn-action-edit {
            background: rgba(59, 130, 246, 0.08);
            color: #60a5fa;
            border-color: rgba(59, 130, 246, 0.2);
        }
        .action-buttons .btn-action-edit:hover {
            background: rgba(59, 130, 246, 0.15);
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
                    <i data-lucide="grid" class="w-6 h-6 text-violet-400"></i>
                    <h1 class="text-2xl font-extrabold text-white">آیتم‌های خدمت</h1>
                    <span class="text-sm text-[#475569]">({{ $service->title }})</span>
                </div>
                <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت آیتم‌های مربوط به {{ $service->title }}</p>
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
                <span class="label">کل آیتم‌ها</span>
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
            <input type="text" id="searchInput" placeholder="جستجو در آیتم‌ها..." onkeyup="filterTable()" class="w-48" />
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
                <i data-lucide="plus" class="w-4 h-4"></i> آیتم جدید
            </button>
        </div>

        <!-- ===== TABLE ===== -->
        <div class="table-wrap">
            <div class="overflow-x-auto">
                <table id="itemsTable">
                    <thead>
                        <tr>
                            <th style="min-width:40px;">#</th>
                            <th style="min-width:150px;">عنوان</th>
                            <th style="min-width:150px;">مکان</th>
                            <th style="min-width:200px;">توضیحات</th>
                            <th style="min-width:80px;">وضعیت</th>
                            <th style="min-width:200px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr data-status="{{ $item->status }}" data-search="{{ $item->title }} {{ $item->place }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-medium">{{ $item->title }}</td>
                            <td>{{ $item->place ?? '—' }}</td>
                            <td class="text-right max-w-xs truncate">{{ $item->description ?? '—' }}</td>
                            <td>
                                <span class="badge badge-{{ $item->status }}">
                                    {{ $item->status === 'active' ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <!-- دکمه ویرایش -->
                                    <button onclick="openEditModal({{ $item->id }})" class="btn-action btn-action-edit" title="ویرایش">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </button>

                                    <!-- دکمه تغییر وضعیت -->
                                    <button onclick="toggleStatus({{ $item->id }})" class="btn-action btn-action-toggle" title="{{ $item->status === 'active' ? 'غیرفعال کردن' : 'فعال کردن' }}">
                                        <i data-lucide="{{ $item->status === 'active' ? 'pause-circle' : 'play-circle' }}" class="w-4 h-4"></i>
                                    </button>

                                    <!-- دکمه حذف -->
                                    <button onclick="deleteItem({{ $item->id }})" class="btn-action btn-action-delete" title="حذف">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-[#475569]">
                                <i data-lucide="grid" class="w-12 h-12 mx-auto text-[#475569] mb-3"></i>
                                <p>هیچ آیتمی یافت نشد</p>
                                <p class="text-xs mt-1">برای افزودن آیتم جدید، روی دکمه "آیتم جدید" کلیک کنید</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- ============================================================
    MODAL: افزودن/ویرایش آیتم
    ============================================================ -->
    <div id="itemModal" class="modal-overlay">
        <div class="modal-box">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="{{ isset($item) ? 'pencil' : 'plus' }}" class="w-5 h-5 text-violet-400"></i>
                    <h3 class="text-xl font-bold text-white" id="modalTitle">افزودن آیتم جدید</h3>
                </div>
                <button onclick="closeModal()" class="text-[#64748b] hover:text-white transition">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="itemForm" method="POST">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">عنوان آیتم</label>
                        <input type="text" id="itemTitle" name="title" class="input-dark" placeholder="مثال: میز شماره ۱" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">مکان</label>
                        <input type="text" id="itemPlace" name="place" class="input-dark" placeholder="مثال: سالن اصلی، ردیف اول" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">توضیحات</label>
                        <textarea id="itemDescription" name="description" class="input-dark" rows="2" placeholder="توضیحات آیتم..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#94a3b8] mb-1">وضعیت</label>
                        <select id="itemStatus" name="status" class="input-dark">
                            <option value="active">فعال</option>
                            <option value="inactive">غیرفعال</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 mt-6 pt-4 border-t border-[#1a2f4a]">
                    <button type="submit" class="btn-emerald w-full justify-center" id="submitBtn">
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
            const rows = document.querySelectorAll('#itemsTable tbody tr');

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
            document.getElementById('modalTitle').textContent = 'افزودن آیتم جدید';
            document.getElementById('submitBtn').innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> ذخیره';
            document.getElementById('itemForm').action = "{{ route('admin.service-items.store', $service->id) }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('itemTitle').value = '';
            document.getElementById('itemPlace').value = '';
            document.getElementById('itemDescription').value = '';
            document.getElementById('itemStatus').value = 'active';
            document.getElementById('itemModal').classList.add('active');
            lucide.createIcons();
        }

        function openEditModal(id) {
            // دریافت اطلاعات از جدول
            const row = document.querySelector(`tr[data-id="${id}"]`) || document.querySelector(`tr:has(td:contains("${id}"))`);

            fetch(`/admin/service-items/{{ $service->id }}/${id}/edit`)
                .then(response => response.text())
                .then(html => {
                    // استخراج دیتا از HTML
                    const temp = document.createElement('div');
                    temp.innerHTML = html;

                    const title = temp.querySelector('[name="title"]')?.value || '';
                    const place = temp.querySelector('[name="place"]')?.value || '';
                    const description = temp.querySelector('[name="description"]')?.value || '';
                    const status = temp.querySelector('[name="status"]')?.value || 'active';

                    document.getElementById('modalTitle').textContent = 'ویرایش آیتم';
                    document.getElementById('submitBtn').innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> ذخیره تغییرات';
                    document.getElementById('itemForm').action = `/admin/service-items/{{ $service->id }}/${id}`;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('itemTitle').value = title;
                    document.getElementById('itemPlace').value = place;
                    document.getElementById('itemDescription').value = description;
                    document.getElementById('itemStatus').value = status;

                    document.getElementById('itemModal').classList.add('active');
                    lucide.createIcons();
                })
                .catch(() => {
                    showToast('خطا در بارگذاری اطلاعات', 'error');
                });
        }

        function closeModal() {
            document.getElementById('itemModal').classList.remove('active');
        }

        // ============================================================
        // TOGGLE STATUS
        // ============================================================
        function toggleStatus(id) {
            if (!confirm('آیا از تغییر وضعیت این آیتم اطمینان دارید؟')) return;

            fetch(`/admin/service-items/{{ $service->id }}/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('وضعیت آیتم با موفقیت تغییر کرد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در تغییر وضعیت', 'error'));
        }

        // ============================================================
        // DELETE ITEM
        // ============================================================
        function deleteItem(id) {
            if (!confirm('آیا از حذف این آیتم اطمینان دارید؟')) return;

            fetch(`/admin/service-items/{{ $service->id }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('آیتم با موفقیت حذف شد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در حذف آیتم', 'error'));
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