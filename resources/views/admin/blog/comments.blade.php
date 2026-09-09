@extends('admin.layouts.admin')

@section('title', 'مدیریت نظرات | GRAFIUM')

@section('content')
<style>
    .table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #1a2f4a;
        background: #0f1f33;
    }
    .table-wrap table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-wrap thead { background: #0a1628; border-bottom: 1px solid #1a2f4a; }
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
    .badge-approved { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
    .badge-spam { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); }
    .badge-trash { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); }

    .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

    .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

    .stats-banner {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px; padding: 16px 20px; background: #0f1f33;
        border-radius: 12px; border: 1px solid #1a2f4a; margin-bottom: 20px;
    }
    .stats-banner .stat-item { text-align: center; }
    .stats-banner .stat-item .num { font-size: 20px; font-weight: 700; color: #60a5fa; }
    .stats-banner .stat-item .label { font-size: 11px; color: #64748b; }

    .action-buttons {
        display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;
    }
    .action-buttons button {
        padding: 4px 10px; border-radius: 6px; border: 1px solid transparent;
        font-size: 12px; cursor: pointer; transition: 0.2s;
        font-family: 'Vazirmatn', sans-serif; display: inline-flex; align-items: center; gap: 4px;
    }

    .filter-bar {
        display: flex; flex-wrap: wrap; gap: 12px; align-items: center;
        padding: 16px 20px; background: #0a1628; border-radius: 12px;
        border: 1px solid #1a2f4a; margin-bottom: 20px;
    }
    .filter-bar select {
        background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 8px;
        padding: 8px 14px; color: #e2e8f0; font-size: 13px; font-family: 'Vazirmatn', sans-serif;
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

    .avatar-icon { width: 36px; height: 36px; border-radius: 50%; background: #1a2f4a; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 16px; }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
        .stats-banner { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="message-square" class="w-6 h-6 text-violet-400"></i>
            <h1 class="text-2xl font-extrabold text-white">مدیریت نظرات</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت نظرات کاربران روی پست‌ها</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-[#64748b]">{{ Auth::guard('admin')->user()->name ?? 'ادمین' }}</span>
        <div class="avatar-icon"><i data-lucide="user-circle" class="w-5 h-5"></i></div>
    </div>
</div>

<!-- ===== STATS BANNER ===== -->
<div class="stats-banner">
    <div class="stat-item">
        <span class="num">{{ $stats['total'] ?? 0 }}</span>
        <span class="label">کل نظرات</span>
    </div>
    <div class="stat-item">
        <span class="num">{{ $stats['pending'] ?? 0 }}</span>
        <span class="label">در انتظار</span>
    </div>
    <div class="stat-item">
        <span class="num">{{ $stats['approved'] ?? 0 }}</span>
        <span class="label">تایید شده</span>
    </div>
    <div class="stat-item">
        <span class="num">{{ $stats['spam'] ?? 0 }}</span>
        <span class="label">اسپم</span>
    </div>
</div>

<!-- ===== FILTER BAR ===== -->
<div class="filter-bar">
    <select id="statusFilter" onchange="filterComments()" class="filter-select">
        <option value="all">همه وضعیت‌ها</option>
        <option value="pending">در انتظار</option>
        <option value="approved">تایید شده</option>
        <option value="spam">اسپم</option>
        <option value="trash">زباله</option>
    </select>
    <button class="btn-blue" onclick="filterComments()">
        <i data-lucide="search" class="w-4 h-4"></i> جستجو
    </button>
    <button class="btn-rose" onclick="resetFilters()">
        <i data-lucide="refresh-cw" class="w-4 h-4"></i> بازنشانی
    </button>
</div>

<!-- ===== COMMENTS TABLE ===== -->
<div class="table-wrap">
    <div class="overflow-x-auto">
        <table id="commentsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>پست</th>
                    <th>کاربر</th>
                    <th>نظر</th>
                    <th>تاریخ</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                <tr data-status="{{ $comment->status }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $comment->post->title ?? 'پست حذف شده' }}</td>
                    <td>{{ $comment->user->name ?? 'کاربر حذف شده' }}</td>
                    <td class="max-w-xs truncate">{{ $comment->content }}</td>
                    <td>{{ $comment->created_at ? $comment->created_at->format('Y/m/d H:i') : '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $comment->status }}">
                            @switch($comment->status)
                                @case('approved') تایید شده @break
                                @case('pending') در انتظار @break
                                @case('spam') اسپم @break
                                @case('trash') زباله @break
                                @default {{ $comment->status }}
                            @endswitch
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            @if($comment->status == 'pending')
                                <form action="{{ route('admin.blog.comments.approve', $comment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-emerald-400 hover:text-emerald-300 transition">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.blog.comments.reject', $comment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-rose-400 hover:text-rose-300 transition">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.blog.comments.destroy', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این نظر اطمینان دارید؟')">
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
                    <td colspan="7" class="text-center py-8 text-[#475569]">
                        <i data-lucide="message-square" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i>
                        <p>هیچ نظری یافت نشد</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== TOAST ===== -->
<div id="toastContainer" class="toast-container"></div>

<script>
    lucide.createIcons();

    function filterComments() {
        const status = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('#commentsTable tbody tr');

        rows.forEach(row => {
            const rowStatus = row.dataset.status || '';
            if (status === 'all' || rowStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetFilters() {
        document.getElementById('statusFilter').value = 'all';
        filterComments();
        showToast('فیلترها بازنشانی شدند', 'info');
    }

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