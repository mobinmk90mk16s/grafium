@extends('admin.layouts.admin')

@section('title', 'مدیریت کاربران | GRAFIUM')

@section('content')
<style>
    /* ===== STATS BANNER ===== */
    .stats-banner {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }
    .stat-box {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        animation: cardIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    }
    .stat-box:nth-child(1) { animation-delay: 0.05s; }
    .stat-box:nth-child(2) { animation-delay: 0.1s; }
    .stat-box:nth-child(3) { animation-delay: 0.15s; }
    .stat-box:nth-child(4) { animation-delay: 0.2s; }
    @keyframes cardIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .stat-box::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 90px; height: 90px;
        background: radial-gradient(circle, var(--accent, #60a5fa), transparent 70%);
        opacity: 0.08;
        transition: transform 0.5s;
    }
    .stat-box:hover {
        transform: translateY(-4px);
        border-color: var(--accent);
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }
    .stat-box:hover::before { transform: scale(1.5); opacity: 0.15; }
    .stat-box.blue { --accent: #60a5fa; }
    .stat-box.emerald { --accent: #34d399; }
    .stat-box.slate { --accent: #94a3b8; }
    .stat-box.rose { --accent: #fb7185; }
    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 13px;
        background: color-mix(in srgb, var(--accent) 15%, transparent);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        border: 1px solid color-mix(in srgb, var(--accent) 25%, transparent);
        transition: transform 0.4s;
    }
    .stat-box:hover .stat-icon { transform: scale(1.1) rotate(-8deg); }
    .stat-info { flex: 1; min-width: 0; }
    .stat-num {
        font-size: 24px;
        font-weight: 900;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 2px;
        transition: color 0.3s;
    }
    .stat-box:hover .stat-num { color: var(--accent); }
    .stat-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 700;
    }

    /* ===== TABLE ===== */
    .table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #1a2f4a;
        background: #0f1f33;
        animation: cardIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.25s backwards;
    }
    .table-wrap table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-wrap thead {
        background: #0a1628;
        border-bottom: 1px solid #1a2f4a;
    }
    .table-wrap thead th {
        padding: 14px 16px;
        text-align: center;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        white-space: nowrap;
    }
    .table-wrap tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #132238;
        color: #cbd5e1;
        vertical-align: middle;
        text-align: center;
    }
    .table-wrap tbody tr {
        transition: all 0.25s;
    }
    .table-wrap tbody tr:last-child td { border-bottom: none; }
    .table-wrap tbody tr:hover {
        background: rgba(52, 211, 153, 0.04);
    }

    /* ===== USER CELL ===== */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: flex-start;
    }
    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: linear-gradient(135deg, #34d399, #10b981);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 6px 16px rgba(52, 211, 153, 0.3);
        transition: transform 0.4s;
    }
    .table-wrap tbody tr:hover .user-avatar {
        transform: scale(1.08) rotate(-6deg);
    }
    .user-info { min-width: 0; text-align: right; }
    .user-name {
        font-weight: 700;
        color: #fff;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .user-email {
        font-size: 11px;
        color: #64748b;
        direction: ltr;
        text-align: right;
        font-family: monospace;
    }

    /* ===== BADGE ===== */
    .badge {
        padding: 5px 14px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }
    .badge-active { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.25); }
    .badge-inactive { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.25); }
    .badge-blocked { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.25); }

    /* ===== BUTTONS ===== */
    .btn-blue {
        background: #1a2f4a;
        color: #60a5fa;
        border: 1px solid #2a4a6a;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.25s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Vazirmatn', sans-serif;
        text-decoration: none;
    }
    .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; transform: translateY(-2px); }

    .btn-rose {
        background: rgba(244, 63, 94, 0.1);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.25);
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        transition: all 0.25s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Vazirmatn', sans-serif;
        text-decoration: none;
    }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.2); transform: translateY(-2px); }

    /* ===== ACTION BUTTONS ===== */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .action-buttons button {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: all 0.25s;
        cursor: pointer;
        font-family: 'Vazirmatn', sans-serif;
        background: transparent;
    }
    .action-buttons button.block-btn {
        color: #fb7185;
        background: rgba(244, 63, 94, 0.1);
        border-color: rgba(244, 63, 94, 0.2);
    }
    .action-buttons button.block-btn:hover {
        background: #f43f5e;
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(244, 63, 94, 0.4);
    }
    .action-buttons button.unblock-btn {
        color: #34d399;
        background: rgba(52, 211, 153, 0.1);
        border-color: rgba(52, 211, 153, 0.2);
    }
    .action-buttons button.unblock-btn:hover {
        background: #10b981;
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(52, 211, 153, 0.4);
    }
    .action-buttons button.delete-btn {
        color: #94a3b8;
        background: rgba(148, 163, 184, 0.1);
        border-color: rgba(148, 163, 184, 0.2);
    }
    .action-buttons button.delete-btn:hover {
        background: #475569;
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(71, 85, 105, 0.4);
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
        border-radius: 14px;
        border: 1px solid #1a2f4a;
        margin-bottom: 20px;
        animation: cardIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s backwards;
    }
    .filter-bar input, .filter-bar select {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 10px;
        padding: 10px 14px;
        color: #e2e8f0;
        font-size: 13px;
        font-family: 'Vazirmatn', sans-serif;
        transition: all 0.25s;
    }
    .filter-bar input:focus, .filter-bar select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .filter-bar .w-48 { width: 12rem; }

    /* ===== TOAST ===== */
    .toast-container {
        position: fixed; bottom: 24px; left: 24px; z-index: 9999;
        display: flex; flex-direction: column; gap: 8px;
    }
    .toast-item {
        padding: 14px 20px; border-radius: 14px;
        min-width: 300px; max-width: 450px;
        backdrop-filter: blur(8px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        animation: toastSlide 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        display: flex; align-items: center; gap: 12px;
        border: 1px solid rgba(255,255,255,0.06);
        font-weight: 600;
    }
    .toast-item.hiding { animation: toastOut 0.3s ease forwards; }
    @keyframes toastSlide { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes toastOut { to { opacity: 0; transform: translateX(100px); } }

    .toast-success { background: rgba(52, 211, 153, 0.15); border-color: rgba(52, 211, 153, 0.3); color: #34d399; }
    .toast-error { background: rgba(244, 63, 94, 0.15); border-color: rgba(244, 63, 94, 0.3); color: #fb7185; }
    .toast-info { background: rgba(59, 130, 246, 0.15); border-color: rgba(59, 130, 246, 0.3); color: #60a5fa; }

    /* ===== ALERT ===== */
    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 16px;
        display: flex;
        align-items: center; gap: 10px;
        font-size: 14px;
        font-weight: 600;
        animation: cardIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .alert-success { background: rgba(52, 211, 153, 0.12); border: 1px solid rgba(52, 211, 153, 0.2); color: #34d399; }
    .alert-error { background: rgba(244, 63, 94, 0.12); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185; }

    /* ===== EMPTY STATE ===== */
    .empty-cell {
        text-align: center !important;
        padding: 60px 20px !important;
    }
    .empty-cell i {
        width: 56px;
        height: 56px;
        color: #334155;
        margin: 0 auto 14px;
        display: block;
    }
    .empty-cell p {
        color: #64748b;
        font-size: 15px;
        font-weight: 600;
    }

    /* ===== PAGINATION ===== */
    .pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: #0a1628;
        border-radius: 12px;
        border: 1px solid #1a2f4a;
        margin-top: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pagination-bar .page-info { color: #64748b; font-size: 13px; font-weight: 600; }
    .pagination-bar .page-btns { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
    .pagination-bar .page-btns nav { display: flex; gap: 4px; }
    .pagination-bar .page-btns a, .pagination-bar .page-btns span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 10px;
        border: 1px solid #1a2f4a;
        background: transparent;
        color: #94a3b8;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.25s;
    }
    .pagination-bar .page-btns a:hover {
        background: #1a2f4a;
        color: #fff;
    }
    .pagination-bar .page-btns span[aria-current="page"] span {
        background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
        color: #fff !important;
        border-color: transparent !important;
    }
    .pagination-bar svg { width: 14px; height: 14px; }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 10px 8px; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-bar .w-48 { width: 100%; }
        .stats-banner { grid-template-columns: repeat(2, 1fr); }
        .toast-item { min-width: auto; max-width: 90%; }
        .pagination-bar { flex-direction: column; align-items: center; }
    }
    @media (max-width: 480px) {
        .table-wrap table { font-size: 10px; }
        .stats-banner { grid-template-columns: 1fr; }
        .user-avatar { width: 32px; height: 32px; font-size: 13px; }
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
    <div class="stat-box blue">
        <div class="stat-icon"><i data-lucide="users" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ isset($users) ? $users->total() : 0 }}</div>
            <div class="stat-label">کل کاربران</div>
        </div>
    </div>
    <div class="stat-box emerald">
        <div class="stat-icon"><i data-lucide="check-circle" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ isset($users) ? $users->where('status', 'active')->count() : 0 }}</div>
            <div class="stat-label">فعال</div>
        </div>
    </div>
    <div class="stat-box slate">
        <div class="stat-icon"><i data-lucide="user-x" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ isset($users) ? $users->where('status', 'inactive')->count() : 0 }}</div>
            <div class="stat-label">غیرفعال</div>
        </div>
    </div>
    <div class="stat-box rose">
        <div class="stat-icon"><i data-lucide="ban" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ isset($users) ? $users->where('status', 'blocked')->count() : 0 }}</div>
            <div class="stat-label">مسدود</div>
        </div>
    </div>
</div>

<!-- ===== FILTER BAR ===== -->
<div class="filter-bar">
    <input type="text" id="searchInput" placeholder="جستجو در کاربران..." onkeyup="filterTable()" class="w-48" />
    <select id="statusFilter" onchange="filterTable()">
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
                    <th style="min-width:50px;">#</th>
                    <th style="min-width:200px;">کاربر</th>
                    <th style="min-width:180px;">شماره تماس</th>
                    <th style="min-width:110px;">وضعیت</th>
                    <th style="min-width:140px;">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($users) && $users->count() > 0)
                    @foreach($users as $index => $user)
                    <tr data-status="{{ $user->status }}" data-search="{{ $user->name }} {{ $user->email }} {{ $user->phone }}">
                        <td style="color:#64748b;font-weight:700;">{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-family: monospace; direction: ltr; color: #cbd5e1;">
                                {{ $user->phone ?? '—' }}
                            </span>
                        </td>
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
                                        <button type="submit" class="block-btn" title="مسدود کردن">
                                            <i data-lucide="ban" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از فعال کردن این کاربر اطمینان دارید؟')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="unblock-btn" title="رفع مسدودی">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" title="حذف">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="empty-cell">
                            <i data-lucide="users"></i>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });

    // ===== FILTER TABLE =====
    function filterTable() {
        const search = document.getElementById('searchInput')?.value?.toLowerCase() || '';
        const status = document.getElementById('statusFilter')?.value || 'all';
        const rows = document.querySelectorAll('#usersTable tbody tr');

        rows.forEach(row => {
            const name = row.dataset.search?.toLowerCase() || '';
            const rowStatus = row.dataset.status || '';
            let show = true;

            if (search && !name.includes(search)) show = false;
            if (status !== 'all' && rowStatus !== status) show = false;

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