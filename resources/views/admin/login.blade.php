<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل مدیریت | GRAFIUM</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: { 900: '#0a1628', 800: '#0f1f33', 700: '#132238', 600: '#1a2f4a' },
                        blue: { 400: '#60a5fa', 500: '#3b82f6' },
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
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #0a1628;
            color: #e2e8f0;
            direction: rtl;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #132238;
            border: 1px solid #1a2f4a;
            border-radius: 20px;
            padding: 40px 36px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .login-box .logo { text-align: center; margin-bottom: 28px; }
        .login-box .logo h1 { font-size: 28px; font-weight: 800; color: #60a5fa; }
        .login-box .logo p { font-size: 13px; color: #64748b; margin-top: 4px; }

        .login-box .form-group { margin-bottom: 18px; }
        .login-box .form-group label { display: block; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 5px; }
        .login-box .form-group input {
            width: 100%; padding: 12px 16px; background: #0a1628;
            border: 1px solid #1a2f4a; border-radius: 10px; color: #e2e8f0;
            font-size: 14px; font-family: 'Vazirmatn', sans-serif;
            transition: all 0.2s;
        }
        .login-box .form-group input:focus { outline: none; border-color: #60a5fa; box-shadow: 0 0 0 3px rgba(96,165,250,0.1); }
        .login-box .form-group input::placeholder { color: #475569; }

        .login-box .btn-login {
            width: 100%; padding: 14px; background: #3b82f6;
            border: none; border-radius: 10px; color: white;
            font-size: 16px; font-weight: 700; font-family: 'Vazirmatn', sans-serif;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .login-box .btn-login:hover { background: #2563eb; transform: translateY(-2px); box-shadow: 0 8px 30px rgba(59,130,246,0.3); }

        .login-box .error-msg {
            background: rgba(244,63,94,0.1); border: 1px solid rgba(244,63,94,0.2);
            border-radius: 10px; padding: 12px 16px; color: #fb7185;
            font-size: 13px; margin-bottom: 18px; display: flex; align-items: center; gap: 10px;
        }

        .login-box .back-link { text-align: center; margin-top: 18px; font-size: 14px; color: #64748b; }
        .login-box .back-link a { color: #60a5fa; text-decoration: none; }
        .login-box .back-link a:hover { text-decoration: underline; }

        @media (max-width: 480px) { .login-box { padding: 28px 20px; } }
    </style>
</head>
<body>

    <div class="login-box">

        <div class="logo">
            <i data-lucide="shield" class="w-12 h-12 text-blue-400 mx-auto mb-2"></i>
            <h1>پنل مدیریت</h1>
            <p>GRAFIUM</p>
        </div>

        @if ($errors->any())
            <div class="error-msg">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="form-group">
                <label>ایمیل</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@grafium.ir" required autofocus />
            </div>

            <div class="form-group">
                <label>رمز عبور</label>
                <input type="password" name="password" placeholder="••••••••" required />
            </div>

            <button type="submit" class="btn-login">
                <i data-lucide="log-in" class="w-5 h-5"></i>
                ورود به پنل
            </button>

        </form>

        <div class="back-link">
            <a href="{{ route('home') }}">← بازگشت به سایت</a>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>