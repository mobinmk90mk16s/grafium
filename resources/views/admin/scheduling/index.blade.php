@extends('admin.layouts.admin')

@section('title', 'مدیریت زمان‌بندی | GRAFIUM')

@section('content')
<style>
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

    .badge {
        padding: 4px 14px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center; gap: 6px;
        white-space: nowrap;
    }
    .badge-available { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-reserved { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
    .badge-maintenance { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); }
    .badge-blocked { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }

    .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

    .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

    .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

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
        min-width: 140px;
    }
    .filter-bar input:focus, .filter-bar select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .filter-bar select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: left 12px center;
        padding-right: 36px;
        cursor: pointer;
    }
    .filter-bar select option {
        background: #0a1628;
        color: #e2e8f0;
    }
    .filter-bar input::placeholder {
        color: #475569;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .action-buttons a, .action-buttons button {
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
        background: transparent;
    }
    .action-buttons a:hover, .action-buttons button:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .date-cell {
        display: flex;
        flex-direction: column;
        gap: 2px;
        align-items: center;
    }
    .date-cell .jalali {
        color: #e2e8f0;
        font-weight: 600;
        font-size: 13px;
    }
    .date-cell .time {
        color: #64748b;
        font-size: 11px;
        font-family: monospace;
        direction: ltr;
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
        align-items: center; gap: 10px; font-size: 14px;
    }
    .alert-success { background: rgba(52, 211, 153, 0.12); border: 1px solid rgba(52, 211, 153, 0.2); color: #34d399; }
    .alert-error { background: rgba(244, 63, 94, 0.12); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185; }

    .avatar-icon { width: 36px; height: 36px; border-radius: 50%; background: #1a2f4a; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 16px; }

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
    .pagination-bar .page-btns nav {
        display: flex;
        gap: 4px;
    }
    .pagination-bar .page-btns a, .pagination-bar .page-btns span {
        padding: 6px 14px;
        border-radius: 6px;
        border: 1px solid #1a2f4a;
        background: transparent;
        color: #94a3b8;
        cursor: pointer;
        transition: 0.2s;
        font-family: 'Vazirmatn', sans-serif;
        font-size: 13px;
        text-decoration: none;
        display: inline-block;
    }
    .pagination-bar .page-btns a:hover { background: #1a2f4a; color: #fff; }
    .pagination-bar .page-btns .active span {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
    }
    .pagination-bar .page-btns .disabled span {
        opacity: 0.4;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-bar input, .filter-bar select { width: 100%; min-width: unset; }
        .stats-banner { grid-template-columns: repeat(2, 1fr); }
        .toast-item { min-width: auto; max-width: 90%; }
        .pagination-bar { flex-direction: column; align-items: center; }
    }
    @media (max-width: 480px) {
        .table-wrap table { font-size: 10px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 6px 4px; }
        .stats-banner { grid-template-columns: 1fr; }
        .filter-bar .btn-blue, .filter-bar .btn-rose, .filter-bar .btn-emerald {
            justify-content: center;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="clock" class="w-6 h-6 text-cyan-400"></i>
            <h1 class="text-2xl font-extrabold text-white">مدیریت زمان‌بندی</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت زمان‌بندی رزروها و برنامه‌ریزی</p>
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
        <span class="label">کل زمان‌ها</span>
    </div>
    <div class="stat-item">
        <span class="num" style="color: #34d399;">{{ $stats['available'] ?? 0 }}</span>
        <span class="label">قابل رزرو</span>
    </div>
    <div class="stat-item">
        <span class="num" style="color: #fbbf24;">{{ $stats['reserved'] ?? 0 }}</span>
        <span class="label">رزرو شده</span>
    </div>
    <div class="stat-item">
        <span class="num" style="color: #fb7185;">{{ $stats['maintenance'] ?? 0 }}</span>
        <span class="label">تعمیرات</span>
    </div>
    <div class="stat-item">
        <span class="num" style="color: #60a5fa;">{{ $stats['today'] ?? 0 }}</span>
        <span class="label">امروز</span>
    </div>
    <div class="stat-item">
        <span class="num" style="color: #a78bfa;">{{ $stats['upcoming'] ?? 0 }}</span>
        <span class="label">آینده</span>
    </div>
</div>

<!-- ===== FILTER BAR ===== -->
<div class="filter-bar">
    <input type="text" id="searchInput" placeholder="جستجو..." onkeyup="filterTable()" />
    
    <select id="statusFilter" onchange="filterTable()">
        <option value="all">همه وضعیت‌ها</option>
        <option value="available">قابل رزرو</option>
        <option value="reserved">رزرو شده</option>
        <option value="maintenance">تعمیرات</option>
        <option value="blocked">مسدود</option>
    </select>

    <select id="serviceFilter" onchange="filterTable()">
        <option value="all">همه خدمات</option>
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->title }}</option>
        @endforeach
    </select>

    <select id="itemFilter" onchange="filterTable()">
        <option value="all">همه آیتم‌ها</option>
        @foreach($serviceItems as $item)
            <option value="{{ $item->id }}">{{ $item->title }}</option>
        @endforeach
    </select>

    <button class="btn-blue" onclick="filterTable()">
        <i data-lucide="search" class="w-4 h-4"></i> جستجو
    </button>
    <button class="btn-rose" onclick="resetFilters()">
        <i data-lucide="refresh-cw" class="w-4 h-4"></i> بازنشانی
    </button>
    <a href="{{ route('admin.scheduling.create') }}" class="btn-emerald mr-auto">
        <i data-lucide="plus" class="w-4 h-4"></i> زمان‌بندی جدید
    </a>
</div>

<!-- ===== TABLE ===== -->
<div class="table-wrap">
    <div class="overflow-x-auto">
        <table id="schedulingTable">
            <thead>
                <tr>
                    <th style="min-width:40px;">#</th>
                    <th style="min-width:150px;">خدمت</th>
                    <th style="min-width:120px;">آیتم</th>
                    <th style="min-width:150px;">تاریخ</th>
                    <th style="min-width:120px;">زمان</th>
                    <th style="min-width:100px;">وضعیت</th>
                    <th style="min-width:120px;">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr 
                    data-status="{{ $schedule->status }}" 
                    data-search="{{ $schedule->serviceItem->title ?? '' }} {{ $schedule->serviceItem->service->title ?? '' }}"
                    data-service="{{ $schedule->serviceItem->service_id ?? '' }}"
                    data-item="{{ $schedule->service_item_id ?? '' }}"
                >
                    <td>{{ $schedules->firstItem() + $loop->index }}</td>
                    <td>{{ $schedule->serviceItem->service->title ?? '—' }}</td>
                    <td>{{ $schedule->serviceItem->title ?? '—' }}</td>
                    <td>
                        <div class="date-cell">
                            <span class="jalali">{{ $schedule->jalali_date ?? '—' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="date-cell">
                            <span class="time">{{ $schedule->date_time ? $schedule->date_time->format('H:i') : '—' }} - {{ $schedule->end_time ? $schedule->end_time->format('H:i') : '—' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $schedule->status }}">
                            {{ $schedule->status_persian ?? $schedule->status }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.scheduling.edit', $schedule->id) }}" class="text-blue-400 hover:text-blue-300 transition" title="ویرایش">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <button onclick="toggleStatus({{ $schedule->id }})" class="text-amber-400 hover:text-amber-300 transition" title="تغییر وضعیت">
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                            </button>
                            <form action="{{ route('admin.scheduling.destroy', $schedule->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این زمان‌بندی اطمینان دارید؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:text-rose-300 transition" title="حذف">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-[#475569]">
                        <i data-lucide="clock" class="w-12 h-12 mx-auto text-[#475569] mb-3"></i>
                        <p>هیچ زمان‌بندی یافت نشد</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== PAGINATION ===== -->
@if($schedules->hasPages())
<div class="pagination-bar">
    <span class="page-info">نمایش {{ $schedules->firstItem() ?? 0 }} - {{ $schedules->lastItem() ?? 0 }} از {{ $schedules->total() }} زمان‌بندی</span>
    <div class="page-btns">
        {{ $schedules->links() }}
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
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });

    function filterTable() {
        const search = document.getElementById('searchInput')?.value?.toLowerCase() || '';
        const status = document.getElementById('statusFilter')?.value || 'all';
        const serviceId = document.getElementById('serviceFilter')?.value || 'all';
        const itemId = document.getElementById('itemFilter')?.value || 'all';
        const rows = document.querySelectorAll('#schedulingTable tbody tr');

        rows.forEach(row => {
            const text = row.dataset.search?.toLowerCase() || '';
            const rowStatus = row.dataset.status || '';
            const rowService = row.dataset.service || '';
            const rowItem = row.dataset.item || '';
            
            let show = true;

            if (search && !text.includes(search)) {
                show = false;
            }
            if (status !== 'all' && rowStatus !== status) {
                show = false;
            }
            if (serviceId !== 'all' && rowService !== serviceId) {
                show = false;
            }
            if (itemId !== 'all' && rowItem !== itemId) {
                show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    function resetFilters() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const serviceFilter = document.getElementById('serviceFilter');
        const itemFilter = document.getElementById('itemFilter');
        
        if (searchInput) searchInput.value = '';
        if (statusFilter) statusFilter.value = 'all';
        if (serviceFilter) serviceFilter.value = 'all';
        if (itemFilter) itemFilter.value = 'all';
        
        filterTable();
        showToast('فیلترها بازنشانی شدند', 'info');
    }

    function toggleStatus(id) {
        if (!confirm('آیا از تغییر وضعیت این زمان‌بندی اطمینان دارید؟')) return;

        fetch(`/admin/scheduling/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('وضعیت زمان‌بندی با موفقیت تغییر کرد', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message || 'خطا در تغییر وضعیت', 'error');
            }
        })
        .catch(() => showToast('خطا در ارتباط با سرور', 'error'));
    }

    function showToast(message, type = 'info', duration = 3000) {
        const container = document.getElementById('toastContainer');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type}`;
        const icons = { success: 'check-circle', error: 'alert-circle', warning: 'alert-triangle', info: 'info' };
        toast.innerHTML = `
            <i data-lucide="${icons[type] || 'info'}" class="w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm font-medium">${message}</span>
        `;
        container.appendChild(toast);
        
        try {
            lucide.createIcons();
        } catch(e) {}
        
        setTimeout(() => { 
            toast.classList.add('hiding'); 
            setTimeout(() => toast.remove(), 300); 
        }, 3000);
    }

    document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            filterTable();
        }
    });
</script>
@endsection