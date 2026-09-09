@extends('admin.layouts.admin')

@section('title', 'مدیریت دسته‌بندی‌ها | GRAFIUM')

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

    .badge { padding: 4px 14px; border-radius: 9999px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }

    .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

    .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

    .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

    .input-dark {
        background: #0a1628; border: 1px solid #1a2f4a; border-radius: 8px; padding: 10px 14px;
        color: #e2e8f0; font-size: 13px; width: 100%; transition: border 0.2s; font-family: 'Vazirmatn', sans-serif;
    }
    .input-dark:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .input-dark::placeholder { color: #475569; }

    .form-card {
        background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 16px; padding: 24px;
        margin-bottom: 24px;
    }

    .action-buttons {
        display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;
    }
    .action-buttons button {
        padding: 4px 10px; border-radius: 6px; border: 1px solid transparent;
        font-size: 12px; cursor: pointer; transition: 0.2s;
        font-family: 'Vazirmatn', sans-serif; display: inline-flex; align-items: center; gap: 4px;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        display: flex;
        align-items: center; gap: 10px; font-size: 14px;
    }
    .alert-success { background: rgba(52, 211, 153, 0.12); border: 1px solid rgba(52, 211, 153, 0.2); color: #34d399; }
    .alert-error { background: rgba(244, 63, 94, 0.12); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185; }

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
    }
</style>

<!-- ===== HEADER ===== -->
<div class="flex flex-wrap justify-between items-center pb-4 border-b border-[#1a2f4a] mb-6">
    <div>
        <div class="flex items-center gap-3">
            <i data-lucide="folder" class="w-6 h-6 text-emerald-400"></i>
            <h1 class="text-2xl font-extrabold text-white">مدیریت دسته‌بندی‌ها</h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">مدیریت دسته‌بندی‌های بلاگ</p>
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

<!-- ===== ADD CATEGORY FORM ===== -->
<div class="form-card">
    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
        <i data-lucide="plus" class="w-5 h-5 text-emerald-400"></i>
        افزودن دسته‌بندی جدید
    </h3>
    <form action="{{ route('admin.blog.categories.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        @csrf
        <div>
            <input type="text" name="name" class="input-dark" placeholder="نام دسته‌بندی" required />
        </div>
        <div>
            <input type="text" name="color" class="input-dark" placeholder="رنگ (مثال: #60a5fa)" />
        </div>
        <div>
            <input type="text" name="icon" class="input-dark" placeholder="آیکون (مثال: book-open)" />
        </div>
        <button type="submit" class="btn-emerald w-full justify-center">
            <i data-lucide="save" class="w-4 h-4"></i> ذخیره
        </button>
    </form>
</div>

<!-- ===== CATEGORIES TABLE ===== -->
<div class="table-wrap">
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>اسلاگ</th>
                    <th>رنگ</th>
                    <th>آیکون</th>
                    <th>تعداد پست</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span style="color: {{ $category->color }}; font-weight: 600;">
                            {{ $category->name }}
                        </span>
                    </td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        <span class="inline-block w-6 h-6 rounded-full" style="background: {{ $category->color }};"></span>
                    </td>
                    <td>
                        <i data-lucide="{{ $category->icon ?? 'folder' }}" class="w-5 h-5"></i>
                    </td>
                    <td>{{ $category->posts_count ?? 0 }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.blog.categories.edit', $category->id) }}" class="text-blue-400 hover:text-blue-300 transition">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.blog.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟')">
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
                        <i data-lucide="folder" class="w-8 h-8 mx-auto text-[#475569] mb-2"></i>
                        <p>هیچ دسته‌بندی یافت نشد</p>
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