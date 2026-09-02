<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>مدیریت رزروها | GRAFIUM</title>

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
            border-bottom: 1px solid #1a2f4a;
        }
        .table-wrap tbody td { padding: 12px 16px; border-bottom: 1px solid #132238; color: #cbd5e1; vertical-align: middle; text-align: center; }
        .table-wrap tbody tr { transition: background 0.15s; }
        .table-wrap tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

        .badge {
            padding: 4px 14px; border-radius: 9999px; font-size: 11px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
        }
        .badge-active { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
        .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
        .badge-cancelled { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); }
        .badge-completed { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
        .badge-expired { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }

        .badge-paid { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
        .badge-unpaid { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
        .badge-refunded { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }

        .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

        .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

        .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

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
        .action-buttons button {
            padding: 4px 10px; border-radius: 6px; border: 1px solid transparent;
            font-size: 12px; cursor: pointer; transition: 0.2s;
            font-family: 'Vazirmatn', sans-serif; display: inline-flex; align-items: center; gap: 4px;
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

        .pagination-bar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 20px; background: #0a1628; border-radius: 12px;
            border: 1px solid #1a2f4a; margin-top: 16px; flex-wrap: wrap; gap: 12px;
        }
        .pagination-bar .page-info { color: #64748b; font-size: 13px; }
        .pagination-bar .page-btns { display: flex; gap: 6px; flex-wrap: wrap; }
        .pagination-bar .page-btns button {
            padding: 6px 14px; border-radius: 6px; border: 1px solid #1a2f4a;
            background: transparent; color: #94a3b8; cursor: pointer; transition: 0.2s;
            font-family: 'Vazirmatn', sans-serif; font-size: 13px;
        }
        .pagination-bar .page-btns button:hover { background: #1a2f4a; color: #fff; }
        .pagination-bar .page-btns button.active { background: #3b82f6; color: #fff; border-color: #3b82f6; }

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
            .table-wrap { overflow-x: auto; }
            .table-wrap table { font-size: 11px; }
            .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
            .filter-bar { flex-direction: column; align-items: stretch; }
            .pagination-bar { flex-direction: column; align-items: center; }
            .stats-banner { grid-template-columns: repeat(2, 1fr); }
            .toast-item { min-width: auto; max-width: 90%; }
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
                        <a href="{{ route('admin.reservations.index') }}" class="menu-item active flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
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
                    <i data-lucide="calendar-check" class="w-6 h-6 text-emerald-400"></i>
                    <h1 class="text-2xl font-extrabold text-white">مدیریت رزروها</h1>
                </div>
                <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت همه رزروهای سیستم</p>
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
                <span class="label">کل رزروها</span>
            </div>
            <div class="stat-item">
                <span class="num" style="color: #34d399;">{{ $stats['active'] ?? 0 }}</span>
                <span class="label">فعال</span>
            </div>
            <div class="stat-item">
                <span class="num" style="color: #fbbf24;">{{ $stats['pending'] ?? 0 }}</span>
                <span class="label">در انتظار</span>
            </div>
            <div class="stat-item">
                <span class="num" style="color: #60a5fa;">{{ $stats['completed'] ?? 0 }}</span>
                <span class="label">تکمیل شده</span>
            </div>
            <div class="stat-item">
                <span class="num" style="color: #fb7185;">{{ $stats['cancelled'] ?? 0 }}</span>
                <span class="label">لغو شده</span>
            </div>
            <div class="stat-item">
                <span class="num" style="color: #60a5fa;">{{ $stats['today'] ?? 0 }}</span>
                <span class="label">رزرو امروز</span>
            </div>
        </div>

        <!-- ===== FILTER BAR ===== -->
        <div class="filter-bar">
            <input type="text" id="searchInput" placeholder="جستجو در رزروها..." onkeyup="filterTable()" class="w-48" />
            <select id="statusFilter" onchange="filterTable()" class="filter-select">
                <option value="all">همه وضعیت‌ها</option>
                <option value="active">فعال</option>
                <option value="pending">در انتظار</option>
                <option value="completed">تکمیل شده</option>
                <option value="cancelled">لغو شده</option>
                <option value="expired">منقضی</option>
            </select>
            <button class="btn-blue" onclick="filterTable()">
                <i data-lucide="search" class="w-4 h-4"></i> جستجو
            </button>
            <button class="btn-rose" onclick="resetFilters()">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> بازنشانی
            </button>
        </div>

        <!-- ===== TABLE ===== -->
        <div class="table-wrap">
            <div class="overflow-x-auto">
                <table id="reservationsTable">
                    <thead>
                        <tr>
                            <th style="min-width:40px;">#</th>
                            <th style="min-width:100px;">کاربر</th>
                            <th style="min-width:120px;">خدمت</th>
                            <th style="min-width:100px;">تاریخ</th>
                            <th style="min-width:80px;">شیفت</th>
                            <th style="min-width:100px;">قیمت</th>
                            <th style="min-width:80px;">وضعیت</th>
                            <th style="min-width:80px;">پرداخت</th>
                            <th style="min-width:120px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                        <tr data-status="{{ $reservation->status }}" data-search="{{ $reservation->user->name ?? '' }} {{ $reservation->service->title ?? '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation->user->name ?? 'کاربر حذف شده' }}</td>
                            <td>{{ $reservation->service->title ?? 'بدون خدمت' }}</td>
                            <td>{{ $reservation->reservation_date ?? '—' }}</td>
                            <td>{{ $reservation->shift_persian ?? '—' }}</td>
                            <td class="font-bold text-emerald-400">{{ number_format($reservation->total_price) }} تومان</td>
                            <td>
                                <span class="badge badge-{{ $reservation->status }}">
                                    {{ $reservation->status_persian ?? $reservation->status }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $reservation->payment_status }}">
                                    {{ $reservation->payment_status_persian ?? $reservation->payment_status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button onclick="updateStatus({{ $reservation->id }})" class="text-amber-400 hover:text-amber-300 transition">
                                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    </button>
                                    <button onclick="deleteReservation({{ $reservation->id }})" class="text-rose-400 hover:text-rose-300 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-12 text-[#475569]">
                                <i data-lucide="calendar-check" class="w-12 h-12 mx-auto text-[#475569] mb-3"></i>
                                <p>هیچ رزروی یافت نشد</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== PAGINATION ===== -->
        @if($reservations->hasPages())
        <div class="pagination-bar">
            <span class="page-info">نمایش {{ $reservations->firstItem() ?? 0 }} - {{ $reservations->lastItem() ?? 0 }} از {{ $reservations->total() }} رزرو</span>
            <div class="page-btns">
                {{ $reservations->links() }}
            </div>
        </div>
        @endif

    </main>

    <!-- ============================================================
    SCRIPTS
    ============================================================ -->
    <script>
        lucide.createIcons();

        // ===== FILTER TABLE =====
        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const status = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#reservationsTable tbody tr');

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

        // ===== UPDATE STATUS =====
        function updateStatus(id) {
            const statuses = ['pending', 'active', 'completed', 'cancelled', 'expired'];
            const labels = ['در انتظار', 'فعال', 'تکمیل شده', 'لغو شده', 'منقضی'];

            // یک پیام ساده برای انتخاب وضعیت
            const choice = prompt('وضعیت جدید را وارد کنید:\n1. در انتظار\n2. فعال\n3. تکمیل شده\n4. لغو شده\n5. منقضی', '2');

            if (!choice) return;

            const index = parseInt(choice) - 1;
            if (index < 0 || index >= statuses.length) {
                showToast('وضعیت نامعتبر', 'error');
                return;
            }

            const newStatus = statuses[index];

            fetch(`/admin/reservations/${id}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('وضعیت رزرو با موفقیت تغییر کرد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در تغییر وضعیت', 'error'));
        }

        // ===== DELETE RESERVATION =====
        function deleteReservation(id) {
            if (!confirm('آیا از حذف این رزرو اطمینان دارید؟')) return;

            fetch(`/admin/reservations/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('رزرو با موفقیت حذف شد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در حذف رزرو', 'error'));
        }

        // ===== TOAST =====
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
    </script>

</body>
</html>