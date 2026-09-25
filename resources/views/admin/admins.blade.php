@extends('admin.layouts.admin')

@section('title', 'مدیریت مدیران | GRAFIUM')

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
        animation: cardIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s backwards;
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
        background: rgba(96, 165, 250, 0.04);
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
        background: linear-gradient(135deg, #a78bfa, #7c3aed);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 6px 16px rgba(167, 139, 250, 0.3);
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
    .user-phone {
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
    .badge-super_admin { background: rgba(96, 165, 250, 0.15); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.25); }
    .badge-manager { background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.25); }
    .badge-support { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.25); }

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

    .btn-emerald {
        background: rgba(52, 211, 153, 0.1);
        color: #34d399;
        border: 1px solid rgba(52, 211, 153, 0.25);
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
    .btn-emerald:hover { background: rgba(52, 211, 153, 0.2); transform: translateY(-2px); }

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
    .action-buttons a, .action-buttons button {
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
    .action-buttons a.edit-btn {
        color: #60a5fa;
        background: rgba(96, 165, 250, 0.1);
        border-color: rgba(96, 165, 250, 0.2);
    }
    .action-buttons a.edit-btn:hover {
        background: #3b82f6;
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
    }
    .action-buttons button.delete-btn {
        color: #fb7185;
        background: rgba(244, 63, 94, 0.1);
        border-color: rgba(244, 63, 94, 0.2);
    }
    .action-buttons button.delete-btn:hover {
        background: #f43f5e;
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(244, 63, 94, 0.4);
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

    /* ===== FORM CARD ===== */
    .form-card {
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 18px;
        padding: 32px;
        max-width: 720px;
        margin: 0 auto 24px;
        animation: cardIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .form-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 26px;
        padding-bottom: 20px;
        border-bottom: 1px solid #1a2f4a;
    }
    .form-card-title i {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #34d399, #10b981);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 8px 20px rgba(52, 211, 153, 0.3);
    }
    .form-card-title h2 {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
    }

    .input-dark {
        background: #0a1628;
        border: 1px solid #1a2f4a;
        border-radius: 10px;
        padding: 12px 16px;
        color: #e2e8f0;
        font-size: 13px;
        width: 100%;
        transition: all 0.25s;
        font-family: 'Vazirmatn', sans-serif;
    }
    .input-dark:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .input-dark::placeholder { color: #475569; }
    .input-dark option { background: #0a1628; color: #e2e8f0; }

    label.form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #94a3b8;
        margin-bottom: 8px;
    }

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
    .empty-cell .sub {
        color: #475569;
        font-size: 12px;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .main-content { margin-right: 0 !important; padding: 16px !important; }
        .table-wrap { overflow-x: auto; }
        .table-wrap table { font-size: 11px; }
        .table-wrap thead th, .table-wrap tbody td { padding: 10px 8px; }
        .form-card { padding: 20px; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-bar .w-48 { width: 100%; }
        .stats-banner { grid-template-columns: repeat(2, 1fr); }
        .toast-item { min-width: auto; max-width: 90%; }
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
            <i data-lucide="user-cog" class="w-6 h-6 text-violet-400"></i>
            <h1 class="text-2xl font-extrabold text-white">
                @if(isset($admin) && Route::currentRouteName() == 'admin.admins.edit')
                    ویرایش مدیر
                @elseif(Route::currentRouteName() == 'admin.admins.create')
                    افزودن مدیر جدید
                @else
                    مدیریت مدیران
                @endif
            </h1>
        </div>
        <p class="text-sm text-[#475569] mt-0.5 mr-9">
            @if(isset($admin) && Route::currentRouteName() == 'admin.admins.edit')
                ویرایش اطلاعات مدیر "{{ $admin->name }}"
            @elseif(Route::currentRouteName() == 'admin.admins.create')
                ایجاد یک مدیر جدید در سیستم
            @else
                مدیریت همه مدیران و دسترسی‌های سیستم
            @endif
        </p>
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
            <div class="stat-num">{{ isset($admins) ? $admins->count() : 0 }}</div>
            <div class="stat-label">کل مدیران</div>
        </div>
    </div>
    <div class="stat-box emerald">
        <div class="stat-icon"><i data-lucide="check-circle" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ isset($admins) ? $admins->where('is_active', 1)->count() : 0 }}</div>
            <div class="stat-label">فعال</div>
        </div>
    </div>
    <div class="stat-box slate">
        <div class="stat-icon"><i data-lucide="user-x" class="w-5 h-5"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ isset($admins) ? $admins->where('is_active', 0)->count() : 0 }}</div>
            <div class="stat-label">غیرفعال</div>
        </div>
    </div>
</div>

<!-- ============================================================
فرم افزودن/ویرایش مدیر
============================================================ -->
@if(Route::currentRouteName() == 'admin.admins.create' || Route::currentRouteName() == 'admin.admins.edit')
<div class="form-card">
    <div class="form-card-title">
        <i data-lucide="{{ isset($admin) ? 'pencil' : 'user-plus' }}"></i>
        <h2>
            {{ isset($admin) ? 'ویرایش مدیر' : 'افزودن مدیر جدید' }}
        </h2>
    </div>

    <form method="POST" action="{{ isset($admin) ? route('admin.admins.update', $admin->id) : route('admin.admins.store') }}">
        @csrf
        @if(isset($admin))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="form-label">نام کامل</label>
                <input type="text" name="name" value="{{ old('name', $admin->name ?? '') }}"
                       class="input-dark" placeholder="مثال: علی محمدی" required />
            </div>

            <div>
                <label class="form-label">ایمیل</label>
                <input type="email" name="email" value="{{ old('email', $admin->email ?? '') }}"
                       class="input-dark" placeholder="admin@example.com" required />
            </div>

            <div>
                <label class="form-label">شماره تماس</label>
                <input type="text" name="phone" value="{{ old('phone', $admin->phone ?? '') }}"
                       class="input-dark" placeholder="مثال: 09123456789" />
            </div>

            <div>
                <label class="form-label">نقش کاربری</label>
                <select name="role" class="input-dark" required>
                    <option value="super_admin" {{ old('role', $admin->role ?? '') == 'super_admin' ? 'selected' : '' }}>مدیر اصلی</option>
                    <option value="manager" {{ old('role', $admin->role ?? '') == 'manager' ? 'selected' : '' }}>مدیر</option>
                    <option value="support" {{ old('role', $admin->role ?? '') == 'support' ? 'selected' : '' }}>پشتیبان</option>
                </select>
            </div>

            <div>
                <label class="form-label">
                    {{ isset($admin) ? 'رمز عبور جدید (اختیاری)' : 'رمز عبور' }}
                </label>
                <input type="password" name="password" class="input-dark"
                       placeholder="{{ isset($admin) ? 'برای تغییر وارد کنید' : 'حداقل ۸ کاراکتر' }}"
                       {{ isset($admin) ? '' : 'required' }} />
            </div>

            @if(isset($admin))
            <div>
                <label class="form-label">وضعیت</label>
                <select name="is_active" class="input-dark">
                    <option value="1" {{ old('is_active', $admin->is_active ?? 1) == 1 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ old('is_active', $admin->is_active ?? 1) == 0 ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>
            @endif
        </div>

        <div class="flex gap-3 mt-8 pt-6 border-t border-[#1a2f4a]">
            <button type="submit" class="btn-emerald">
                <i data-lucide="save" class="w-4 h-4"></i>
                {{ isset($admin) ? 'به‌روزرسانی مدیر' : 'ایجاد مدیر' }}
            </button>
            <a href="{{ route('admin.admins.index') }}" class="btn-blue">
                <i data-lucide="arrow-right" class="w-4 h-4"></i> بازگشت
            </a>
        </div>

        @if($errors->any())
        <div class="mt-5 p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
            <ul class="list-disc pr-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
</div>
@endif

<!-- ===== FILTER BAR (فقط در حالت لیست) ===== -->
@if(Route::currentRouteName() != 'admin.admins.create' && Route::currentRouteName() != 'admin.admins.edit')
<div class="filter-bar">
    <input type="text" id="searchInput" placeholder="جستجو در مدیران..." onkeyup="filterTable()" class="w-48" />
    <select id="roleFilter" onchange="filterTable()">
        <option value="all">همه نقش‌ها</option>
        <option value="super_admin">مدیر اصلی</option>
        <option value="manager">مدیر</option>
        <option value="support">پشتیبان</option>
    </select>
    <select id="statusFilter" onchange="filterTable()">
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
    <a href="{{ route('admin.admins.create') }}" class="btn-emerald mr-auto">
        <i data-lucide="user-plus" class="w-4 h-4"></i> مدیر جدید
    </a>
</div>
@endif

<!-- ===== TABLE ===== -->
@if(Route::currentRouteName() != 'admin.admins.create' && Route::currentRouteName() != 'admin.admins.edit')
<div class="table-wrap">
    <div class="overflow-x-auto">
        <table id="adminsTable">
            <thead>
                <tr>
                    <th style="min-width:50px;">#</th>
                    <th style="min-width:200px;">مدیر</th>
                    <th style="min-width:200px;">ایمیل</th>
                    <th style="min-width:110px;">نقش</th>
                    <th style="min-width:110px;">وضعیت</th>
                    <th style="min-width:100px;">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($admins) && $admins->count() > 0)
                    @foreach($admins as $index => $adminItem)
                    <tr data-role="{{ $adminItem->role }}" data-status="{{ $adminItem->is_active ? 'active' : 'inactive' }}" data-search="{{ $adminItem->name }} {{ $adminItem->email }} {{ $adminItem->phone }}">
                        <td style="color:#64748b;font-weight:700;">{{ $index + 1 }}</td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    {{ mb_substr($adminItem->name, 0, 1) }}
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $adminItem->name }}</div>
                                    <div class="user-phone">{{ $adminItem->phone ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $adminItem->email }}</td>
                        <td>
                            <span class="badge badge-{{ $adminItem->role }}">
                                @switch($adminItem->role)
                                    @case('super_admin') مدیر اصلی @break
                                    @case('manager') مدیر @break
                                    @case('support') پشتیبان @break
                                    @default {{ $adminItem->role }}
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $adminItem->is_active ? 'active' : 'inactive' }}">
                                {{ $adminItem->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.admins.edit', $adminItem->id) }}" class="edit-btn" title="ویرایش">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                @if($adminItem->id != Auth::guard('admin')->id())
                                    <form action="{{ route('admin.admins.destroy', $adminItem->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این مدیر اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" title="حذف">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="empty-cell">
                            <i data-lucide="user-cog"></i>
                            <p>هیچ مدیری یافت نشد</p>
                            <p class="sub">برای افزودن مدیر جدید، روی دکمه "مدیر جدید" کلیک کنید</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
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
        const role = document.getElementById('roleFilter')?.value || 'all';
        const status = document.getElementById('statusFilter')?.value || 'all';
        const rows = document.querySelectorAll('#adminsTable tbody tr');

        rows.forEach(row => {
            const name = row.dataset.search?.toLowerCase() || '';
            const rowRole = row.dataset.role || '';
            const rowStatus = row.dataset.status || '';
            let show = true;

            if (search && !name.includes(search)) show = false;
            if (role !== 'all' && rowRole !== role) show = false;
            if (status !== 'all' && rowStatus !== status) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    function resetFilters() {
        const searchInput = document.getElementById('searchInput');
        const roleFilter = document.getElementById('roleFilter');
        const statusFilter = document.getElementById('statusFilter');
        
        if (searchInput) searchInput.value = '';
        if (roleFilter) roleFilter.value = 'all';
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