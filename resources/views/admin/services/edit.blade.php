<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ویرایش خدمت | GRAFIUM</title>

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

        .form-card {
            background: #0f1f33; border: 1px solid #1a2f4a; border-radius: 16px; padding: 28px;
            max-width: 800px; margin: 0 auto;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 5px; }

        .input-dark {
            background: #0a1628; border: 1px solid #1a2f4a; border-radius: 8px; padding: 10px 14px;
            color: #e2e8f0; font-size: 13px; width: 100%; transition: border 0.2s; font-family: 'Vazirmatn', sans-serif;
        }
        .input-dark:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .input-dark::placeholder { color: #475569; }

        .btn-blue { background: #1a2f4a; color: #60a5fa; border: 1px solid #2a4a6a; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-blue:hover { background: #2a4a6a; border-color: #3a5a7a; }

        .btn-emerald { background: rgba(52, 211, 153, 0.08); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-emerald:hover { background: rgba(52, 211, 153, 0.15); }

        .btn-rose { background: rgba(244, 63, 94, 0.08); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-rose:hover { background: rgba(244, 63, 94, 0.15); }

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

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; border-left: none; border-bottom: 1px solid #1a2f4a; }
            .main-content { margin-right: 0 !important; padding: 16px !important; }
            .form-card { padding: 16px; }
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
                    <i data-lucide="pencil" class="w-6 h-6 text-blue-400"></i>
                    <h1 class="text-2xl font-extrabold text-white">ویرایش خدمت</h1>
                </div>
                <p class="text-sm text-[#475569] mt-0.5 mr-9">ویرایش اطلاعات خدمت "{{ $service->title }}"</p>
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

        @if($errors->any())
            <div class="alert alert-error">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <ul class="list-disc pr-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ===== FORM ===== -->
        <div class="form-card">
            <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="form-group lg:col-span-2">
                        <label>عنوان خدمت</label>
                        <input type="text" name="title" class="input-dark" value="{{ old('title', $service->title) }}" required />
                    </div>

                    <div class="form-group">
                        <label>نوع خدمت</label>
                        <select name="type" class="input-dark" required>
                            <option value="shift" {{ old('type', $service->type) == 'shift' ? 'selected' : '' }}>شیفتی</option>
                            <option value="hourly" {{ old('type', $service->type) == 'hourly' ? 'selected' : '' }}>ساعتی</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>وضعیت</label>
                        <select name="status" class="input-dark" required>
                            <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>فعال</option>
                            <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>قیمت (تومان)</label>
                        <input type="number" name="price" class="input-dark" value="{{ old('price', $service->price) }}" required />
                    </div>

                    <div class="form-group">
                        <label>آیکون</label>
                        <input type="text" name="icon" class="input-dark" value="{{ old('icon', $service->icon) }}" placeholder="مثال: desk, armchair, cpu, monitor, camera" />
                    </div>

                    <div class="form-group">
                        <label>مکان</label>
                        <input type="text" name="place" class="input-dark" value="{{ old('place', $service->place) }}" placeholder="مکان خدمت" />
                    </div>

                    <div class="form-group lg:col-span-2">
                        <label>توضیحات</label>
                        <textarea name="description" class="input-dark" rows="3">{{ old('description', $service->description) }}</textarea>
                    </div>

                    <div class="form-group lg:col-span-2">
                        <label>تنظیمات پیشرفته (JSON)</label>
                        <textarea name="config" class="input-dark" rows="4" placeholder='{"shift_price": {"morning": 250000, "afternoon": 300000}}'>{{ old('config', $service->config ? json_encode($service->config, JSON_PRETTY_PRINT) : '') }}</textarea>
                        <p class="text-xs text-[#475569] mt-1">تنظیمات پیشرفته را به صورت JSON وارد کنید (اختیاری)</p>
                    </div>
                </div>

                <div class="flex gap-3 mt-4 pt-4 border-t border-[#1a2f4a]">
                    <button type="submit" class="btn-emerald">
                        <i data-lucide="save" class="w-4 h-4"></i> ذخیره تغییرات
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="btn-rose">
                        <i data-lucide="x" class="w-4 h-4"></i> انصراف
                    </a>
                </div>
            </form>
        </div>

    </main>

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

</body>
</html>