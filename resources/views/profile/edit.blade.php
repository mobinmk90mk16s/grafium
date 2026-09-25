<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ویرایش اطلاعات | GRAFIUM</title>

    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --deep-navy: #0a1628;
            --gold: #d4a373;
            --gold-dark: #b8874a;
            --gold-light: #f0d5b0;
            --gold-gradient: linear-gradient(135deg, #d4a373, #b8874a);
            --navy-gradient: linear-gradient(135deg, #0a1628, #1a2f4a);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --border: #e4e7ec;
            --shadow: 0 4px 30px rgba(10, 22, 40, 0.08);
            --radius: 20px;
            --font: "Vazirmatn", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #0f1f33;
            --text: #f0f0f0;
            --text-muted: #94a3b8;
            --border: #1a2f4a;
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        }

        body {
            font-family: var(--font);
            background: var(--bg-body);
            color: var(--text);
            direction: rtl;
            line-height: 1.7;
            min-height: 100vh;
            transition: background 0.4s, color 0.4s;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }
        button { font-family: var(--font); cursor: pointer; border: none; background: none; }

        .container { max-width: 780px; margin: 0 auto; padding: 0 24px; }

        /* ============================================================
        PAGE HEADER
        ============================================================ */
        .page-header {
            background: var(--navy-gradient);
            padding: 60px 0 120px;
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at 80% 30%, rgba(212, 163, 115, 0.15), transparent 50%);
        }
        .page-header::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(212, 163, 115, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 163, 115, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 80%);
        }
        .page-header-content {
            position: relative; z-index: 1;
            text-align: center;
            color: #fff;
        }
        .page-header-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: var(--gold-gradient);
            color: #fff;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
            box-shadow: 0 0 50px rgba(212, 163, 115, 0.4);
            border: 3px solid rgba(255, 255, 255, 0.15);
        }
        .page-header h1 {
            font-size: 30px; font-weight: 800;
            margin-bottom: 8px;
        }
        .page-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        /* ============================================================
        PROFILE CARD
        ============================================================ */
        .profile-wrapper {
            margin-top: -70px;
            position: relative;
            z-index: 2;
            margin-bottom: 60px;
        }
        .profile-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* ===== Avatar Section ===== */
        .avatar-section {
            text-align: center;
            padding: 40px 24px 30px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(212, 163, 115, 0.04) 0%, transparent 100%);
            position: relative;
        }
        .avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 18px;
        }
        .avatar-preview {
            width: 120px; height: 120px;
            border-radius: 32px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 44px;
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.4);
            border: 4px solid var(--bg-card);
            overflow: hidden;
            transition: transform 0.4s;
        }
        .avatar-preview img {
            width: 100%; height: 100%;
            object-fit: cover;
            border-radius: 28px;
        }
        .avatar-wrapper:hover .avatar-preview {
            transform: scale(1.04);
        }
        .avatar-upload-btn {
            position: absolute;
            bottom: -8px; left: -8px;
            width: 42px; height: 42px;
            border-radius: 14px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            cursor: pointer;
            border: 3px solid var(--bg-card);
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.4);
            transition: all 0.3s;
        }
        .avatar-upload-btn:hover {
            transform: scale(1.1) rotate(-8deg);
        }
        .avatar-upload-btn input { display: none; }

        .avatar-name {
            font-size: 22px; font-weight: 800;
            margin-bottom: 4px;
        }
        .avatar-phone {
            font-size: 14px;
            color: var(--text-muted);
            direction: ltr;
            font-family: monospace;
        }

        /* ===== Form ===== */
        .profile-form {
            padding: 32px;
        }
        .form-section-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 24px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }
        .form-section-title .icon-badge {
            width: 32px; height: 32px;
            border-radius: 9px;
            background: var(--gold-gradient);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: flex; align-items: center; gap: 8px;
            font-weight: 600; font-size: 13px;
            color: var(--text);
            margin-bottom: 8px;
        }
        .form-group label i {
            color: var(--gold);
            font-size: 12px;
        }
        .form-group label .required {
            color: #fb7185;
            font-size: 12px;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--bg-body);
            color: var(--text);
            font-family: var(--font);
            font-size: 14px;
            transition: all 0.3s;
            outline: none;
        }
        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 5px rgba(212, 163, 115, 0.12);
        }
        .form-input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: var(--bg-body);
        }
        .form-input[dir="ltr"] {
            text-align: left;
            direction: ltr;
        }
        .form-textarea {
            resize: vertical;
            min-height: 90px;
        }
        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 6px;
            display: flex; align-items: center; gap: 5px;
        }

        /* ===== Actions ===== */
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }
        .btn-save {
            flex: 1;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 10px;
            padding: 14px 24px;
            border-radius: 14px;
            background: var(--gold-gradient);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.35s;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.3);
            cursor: pointer;
            border: none;
        }
        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 45px rgba(212, 163, 115, 0.5);
        }
        .btn-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .btn-cancel {
            padding: 14px 28px;
            border-radius: 14px;
            background: var(--bg-body);
            color: var(--text-muted);
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s;
            border: 2px solid var(--border);
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-cancel:hover {
            background: var(--border);
            color: var(--text);
        }

        /* ===== Alert ===== */
        .alert-box {
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13px;
            display: flex; align-items: flex-start; gap: 12px;
            margin-bottom: 20px;
            line-height: 1.7;
        }
        .alert-success {
            background: rgba(52, 211, 153, 0.1);
            border: 1px solid rgba(52, 211, 153, 0.25);
            color: #34d399;
        }
        .alert-error {
            background: rgba(244, 63, 94, 0.1);
            border: 1px solid rgba(244, 63, 94, 0.25);
            color: #fb7185;
        }
        .alert-box i { margin-top: 3px; }

        /* ============================================================
        TOAST
        ============================================================ */
        .toast-container {
            position: fixed; bottom: 30px; left: 30px;
            z-index: 99999;
            display: flex; flex-direction: column; gap: 12px;
        }
        .toast-item {
            display: flex; align-items: center; gap: 14px;
            padding: 16px 22px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            min-width: 300px; max-width: 420px;
            font-size: 14px; font-weight: 600;
            color: var(--text);
            animation: toastIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }
        .toast-item::before {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 4px;
            background: var(--toast-color);
        }
        .toast-item i { font-size: 20px; color: var(--toast-color); flex-shrink: 0; }
        .toast-success { --toast-color: #34d399; }
        .toast-error { --toast-color: #fb7185; }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(-100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 576px) {
            .container { padding: 0 16px; }
            .form-row { grid-template-columns: 1fr; }
            .page-header { padding: 40px 0 100px; }
            .page-header h1 { font-size: 24px; }
            .profile-form { padding: 22px; }
            .form-actions { flex-direction: column; }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <!-- ============================================================
    PAGE HEADER
    ============================================================ -->
    <section class="page-header">
        <div class="container page-header-content">
            <div class="page-header-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <h1>ویرایش اطلاعات</h1>
            <p>اطلاعات شخصی خود را به‌روزرسانی کنید</p>
        </div>
    </section>

    <!-- ============================================================
    PROFILE FORM
    ============================================================ -->
    <div class="container profile-wrapper">
        <div class="profile-card">

            <!-- ===== Avatar ===== -->
            <div class="avatar-section">
                <div class="avatar-wrapper">
                    <div class="avatar-preview" id="avatarPreview">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->display_name }}" />
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <label class="avatar-upload-btn" for="avatarInput" title="آپلود تصویر">
                        <i class="fas fa-camera"></i>
                        <input type="file" id="avatarInput" accept="image/*" />
                    </label>
                </div>
                <div class="avatar-name">{{ $user->display_name }}</div>
                <div class="avatar-phone">{{ $user->phone }}</div>
            </div>

            <!-- ===== Form ===== -->
            <form class="profile-form" id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="alert-box alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-box alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div id="jsAlerts"></div>

                <h3 class="form-section-title">
                    <span class="icon-badge"><i class="fas fa-user"></i></span>
                    اطلاعات شخصی
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            نام و نام خانوادگی
                            <span class="required">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" placeholder="نام خود را وارد کنید" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i>
                            شماره موبایل
                            <span class="required">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" dir="ltr" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        ایمیل (اختیاری)
                    </label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" placeholder="example@email.com" dir="ltr" />
                </div>

                <div class="form-group">
                    <label for="address">
                        <i class="fas fa-map-marker-alt"></i>
                        آدرس (اختیاری)
                    </label>
                    <textarea id="address" name="address" class="form-textarea" placeholder="آدرس خود را وارد کنید">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save" id="saveBtn">
                        <i class="fas fa-save"></i>
                        <span>ذخیره تغییرات</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        انصراف
                    </a>
                </div>
            </form>

        </div>
    </div>

    <!-- ============================================================
    TOAST
    ============================================================ -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // ============================================================
        // TOAST
        // ============================================================
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const icons = { success: 'fa-check-circle', error: 'fa-exclamation-circle', info: 'fa-info-circle' };
            const toast = document.createElement('div');
            toast.className = `toast-item toast-${type}`;
            toast.innerHTML = `<i class="fas ${icons[type]}"></i><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(-100px)';
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

        // ============================================================
        // AVATAR PREVIEW
        // ============================================================
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');

        avatarInput?.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                showToast('حجم تصویر نباید بیشتر از ۲ مگابایت باشد.', 'error');
                avatarInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (event) => {
                avatarPreview.innerHTML = `<img src="${event.target.result}" alt="preview" />`;
            };
            reader.readAsDataURL(file);
        });

        // ============================================================
        // FORM SUBMIT (AJAX)
        // ============================================================
        const profileForm = document.getElementById('profileForm');
        const saveBtn = document.getElementById('saveBtn');

        profileForm?.addEventListener('submit', async (e) => {
            e.preventDefault();

            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>در حال ذخیره...</span>';

            const formData = new FormData(profileForm);

            try {
                const res = await fetch(profileForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData,
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    showToast(data.message || 'اطلاعات با موفقیت ذخیره شد.', 'success');
                } else {
                    // خطاهای اعتبارسنجی
                    const errors = data.errors || {};
                    const firstError = Object.values(errors).flat()[0] || data.message || 'خطا در ذخیره اطلاعات';
                    showToast(firstError, 'error');
                }
            } catch (err) {
                showToast('خطا در ارتباط با سرور', 'error');
            } finally {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i><span>ذخیره تغییرات</span>';
            }
        });
    </script>

</body>
</html>