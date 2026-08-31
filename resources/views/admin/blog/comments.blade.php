<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>مدیریت نظرات | GRAFIUM</title>

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

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; border-left: none; border-bottom: 1px solid #1a2f4a; }
            .main-content { margin-right: 0 !important; padding: 16px !important; }
            .table-wrap { overflow-x: auto; }
            .table-wrap table { font-size: 11px; }
            .table-wrap thead th, .table-wrap tbody td { padding: 8px 6px; }
            .stats-banner { grid-template-columns: repeat(2, 1fr); }
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
                        <a href="{{ route('admin.blog.index') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="newspaper" class="w-5 h-5 text-[#60a5fa]"></i> همه پست‌ها
                            <span class="menu-indicator"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog.create') }}" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
                            <i data-lucide="plus" class="w-5 h-5 text-[#60a5fa]"></i> افزودن پست
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
                        <a href="{{ route('admin.blog.comments.index') }}" class="menu-item active flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94a3b8] text-sm font-medium transition">
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
                                        <button onclick="approveComment({{ $comment->id }})" class="text-emerald-400 hover:text-emerald-300 transition">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                        <button onclick="rejectComment({{ $comment->id }})" class="text-rose-400 hover:text-rose-300 transition">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                    <button onclick="deleteComment({{ $comment->id }})" class="text-rose-400 hover:text-rose-300 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
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

        <!-- ===== PAGINATION ===== -->
        @if($comments->hasPages())
        <div class="flex justify-between items-center mt-4 text-sm text-[#64748b]">
            <span>نمایش {{ $comments->firstItem() ?? 0 }} - {{ $comments->lastItem() ?? 0 }} از {{ $comments->total() }} نظر</span>
            <div class="flex gap-2">
                {{ $comments->links() }}
            </div>
        </div>
        @endif

    </main>

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

        function approveComment(id) {
            if (!confirm('آیا از تایید این نظر اطمینان دارید؟')) return;

            fetch(`/admin/blog/comments/${id}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('نظر با موفقیت تایید شد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در تایید نظر', 'error'));
        }

        function rejectComment(id) {
            if (!confirm('آیا از رد این نظر اطمینان دارید؟')) return;

            fetch(`/admin/blog/comments/${id}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('نظر با موفقیت رد شد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در رد نظر', 'error'));
        }

        function deleteComment(id) {
            if (!confirm('آیا از حذف این نظر اطمینان دارید؟')) return;

            fetch(`/admin/blog/comments/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('نظر با موفقیت حذف شد', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showToast('خطا در حذف نظر', 'error'));
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

</body>
</html>