@extends('admin.layouts.admin')

@section('title', 'مدیریت کاربران | GRAFIUM')

@section('content')
<style>
    /* ===== STATS BANNER ===== */
    .stats-banner {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        padding: 16px 20px;
        background: #0f1f33;
        border-radius: 12px;
        border: 1px solid #1a2f4a;
        margin-bottom: 20px;
    }
    .stats-banner .stat-item { text-align: center; }
    .stats-banner .stat-item .num { font-size: 20px; font-weight: 700; color: #60a5fa; }
    .stats-banner .stat-item .label { font-size: 11px; color: #64748b; }

    /* ===== TABLE ===== */
    .table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #1a2f4a;
        background: #0f1f33;
    }
    .table-wrap table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-wrap thead {
        background: #0a1628;
        border-bottom: 1px solid #1a2f4a;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .table-wrap thead th {
        padding: 14px 16px;
        text-align: center;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        border-bottom: 1px solid #1a2f4a;
        white-space: nowrap;
    }
    .table-wrap tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #132238;
        color: #cbd5e1;
        vertical-align: middle;
        text-align: center;
    }
    .table-wrap tbody tr { transition: background 0.15s; }
    .table-wrap tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

    /* ===== BADGE ===== */
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
    .badge-active { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-inactive { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }
    .badge-blocked { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); }

    /* ===== BUTTONS ===== */
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
    .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

    .btn-emerald {
        background: rgba(52, 211, 153, 0.08);
        color: #34d399;
        border: 1px solid rgba(52, 211, 153, 0.2);
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
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

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
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    .btn-amber {
        background: rgba(251, 191, 36, 0.08);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.2);
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
    .btn-amber:hover { background: rgba(251, 191, 36, 0.15); }

    /* ===== ACTION BUTTONS ===== */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .action-buttons button {
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid transparent;
        font-size: 12px;
        cursor: pointer;
        transition: 0.2s;
        font-family: 'Vazirmatn', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* ===== TOAST ===== */
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

    /* ===== ALERT ===== */
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

    /* ===== FILTER BAR ===== */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        padding: 16px 20px;
        background: #0a1628;
        border-radius: 12px;
        border: 1px solid #1a2f4a;
        margin-bottom: 20px;
    }
    .filter-bar input, .filter-bar select {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 8px;
        padding: 8px 14px;
        color: #e2e8f0;
        font-size: 13px;
        font-family: 'Vazirmatn', sans-serif;
    }
    .filter-bar input:focus, .filter-bar select:focus {
        outline: none;
        border-color: #3b82f6;
    }
    .filter-bar .w-48 { width: 12rem; }

    /* ===== PAGINATION ===== */
    .pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px;
        background: #0a1628;
        border-radius: 12px;
        border: 1px solid #1a2f4a;
        margin-top: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pagination-bar .page-info { color: #64748b; font-size: 13px; }
    .pagination-bar .page-btns { display: flex; gap: 6px; flex-wrap: wrap; }
    .pagination-bar .page-btns button {
        padding: 6px 14px;
        border-radius: 6px;
        border: 1px solid #1a2f4a;
        background: transparent;
        color: #94a3b8;
        cursor: pointer;
        transition: 0.2s;
        font-family: 'Vazirmatn', sans-serif;
        font-size: 13px;
    }
    .pagination-bar .page-btns button:hover { background: #1a2f4a; color: #fff; }
    .pagination-bar .page-btns button.active { background: #3b82f6; color: #fff; border-color: #3b82f6; }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .stats-banner { grid-template-columns: repeat(2, 1fr); }
        .toast-item { min-width: auto; max-width: 90%; }
        .pagination-bar { flex-direction: column; align-items: center; }
    }
    @media (max-width: 480px) {
        .table-wrap table { font-size: 10px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 6px 4px; }
        .stats-banner { grid-template-columns: 1fr; }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="users" class="w-6 h-6 text-emerald-400"></i>
            <h1 class="text-2xl font-extrabold text-white">مدیریت کاربران</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت همه کاربران ثبت‌نام شده در سیستم</p>
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
        <span class="num">{{ isset($users) ? $users->total() : 0 }}</span>
        <span class="label">کل کاربران</span>
    </div>
    <div class="stat-item">
        <span class="num" style="color: #34d399;">{{ isset($users) ? $users->where('status', 'active')->count() : 0 }}</span>
        <span class="label">فعال</span>
    </div>
    <div class="stat-item">
        <span class="num" style="color: #94a3b8;">{{ isset($users) ? $users->where('status', 'inactive')->count() : 0 }}</span>
        <span class="label">غیرفعال</span>
    </div>
    <div class="stat-item">
        <span class="num" style="color: #fb7185;">{{ isset($users) ? $users->where('status', 'blocked')->count() : 0 }}</span>
        <span class="label">مسدود</span>
    </div>
</div>

<!-- ===== FILTER BAR ===== -->
<div class="filter-bar">
    <input type="text" id="searchInput" placeholder="جستجو در کاربران..." onkeyup="filterTable()" class="w-48" />
    <select id="statusFilter" onchange="filterTable()" class="filter-select">
        <option value="all">همه وضعیت‌ها</option>
        <option value="active">فعال</option>
        <option value="inactive">غیرفعال</option>
        <option value="blocked">مسدود</option>
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
        <table id="usersTable">
            <thead>
                <tr>
                    <th style="min-width:40px;">#</th>
                    <th style="min-width:150px;">کاربر</th>
                    <th style="min-width:180px;">ایمیل</th>
                    <th style="min-width:100px;">شماره تماس</th>
                    <th style="min-width:100px;">وضعیت</th>
                    <th style="min-width:120px;">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($users) && $users->count() > 0)
                    @foreach($users as $index => $user)
                    <tr data-status="{{ $user->status }}" data-search="{{ $user->name }} {{ $user->email }}">
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-[#1a2f4a] flex items-center justify-center text-[10px] text-[#60a5fa] font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $user->status }}">
                                @switch($user->status)
                                    @case('active') فعال @break
                                    @case('inactive') غیرفعال @break
                                    @case('blocked') مسدود @break
                                    @default {{ $user->status }}
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($user->status != 'blocked')
                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از مسدود کردن این کاربر اطمینان دارید؟')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-rose-400 hover:text-rose-300 transition">
                                            <i data-lucide="ban" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از فعال کردن این کاربر اطمینان دارید؟')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-emerald-400 hover:text-emerald-300 transition">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:text-rose-300 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center py-12 text-[#475569]">
                            <i data-lucide="users" class="w-12 h-12 mx-auto text-[#475569] mb-3"></i>
                            <p>هیچ کاربری یافت نشد</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- ===== PAGINATION ===== -->
@if(isset($users) && $users->hasPages())
<div class="pagination-bar">
    <span class="page-info">نمایش {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} از {{ $users->total() }} کاربر</span>
    <div class="page-btns">
        {{ $users->links() }}
    </div>
</div>
@endif

<!-- ============================================================
TOAST
============================================================ -->
<div id="toastContainer" class="toast-container"></div>

<!-- ============================================================
SCRIPTS
============================================================ -->
<script>
    lucide.createIcons();

    // ===== FILTER TABLE =====
    function filterTable() {
        const search = document.getElementById('searchInput')?.value?.toLowerCase() || '';
        const status = document.getElementById('statusFilter')?.value || 'all';
        const rows = document.querySelectorAll('#usersTable tbody tr');

        rows.forEach(row => {
            const name = row.dataset.search?.toLowerCase() || '';
            const rowStatus = row.dataset.status || '';
            let show = true;

            if (search && !name.includes(search)) {
                show = false;
            }
            if (status !== 'all' && rowStatus !== status) {
                show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    function resetFilters() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        
        if (searchInput) searchInput.value = '';
        if (statusFilter) statusFilter.value = 'all';
        
        filterTable();
        showToast('فیلترها بازنشانی شدند', 'info');
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
@endsection