@extends('admin.layouts.admin')

@section('title', 'مدیریت رزروها | GRAFIUM')

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
    .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
    .badge-cancelled { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); }
    .badge-completed { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
    .badge-expired { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }
    .badge-paid { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-unpaid { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
    .badge-refunded { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }

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
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-bar .w-48 { width: 100%; }
        .stats-banner { grid-template-columns: repeat(2, 1fr); }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
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
@endsection