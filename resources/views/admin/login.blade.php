<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل مدیریت | GRAFIUM</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #0a1628;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-box {
            background: #132238;
            padding: 40px;
            border-radius: 16px;
            border: 1px solid #d4a373;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .login-box h1 {
            color: #d4a373;
            text-align: center;
            font-size: 28px;
            margin-bottom: 8px;
        }
        .login-box p {
            color: #94a3b8;
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #c8c8d4;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #1a2f4a;
            border-radius: 10px;
            background: #0a1628;
            color: #fff;
            font-size: 15px;
            transition: 0.3s;
            font-family: 'Vazirmatn', sans-serif;
        }
        .form-group input:focus {
            border-color: #d4a373;
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.1);
        }
        .form-group input::placeholder {
            color: #64748b;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #d4a373, #b8874a);
            border: none;
            border-radius: 10px;
            color: #0a1628;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            font-family: 'Vazirmatn', sans-serif;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(212, 163, 115, 0.3);
        }
        .error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 12px;
            text-align: center;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            color: #64748b;
            font-size: 14px;
        }
        .back-link a {
            color: #d4a373;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🛡️ پنل مدیریت</h1>
        <p>برای ورود، اطلاعات خود را وارد کنید</p>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="form-group">
                <label>📧 ایمیل</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@grafium.ir" required>
            </div>

            <div class="form-group">
                <label>🔑 رمز عبور</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            <button type="submit" class="btn-login">🚀 ورود به پنل</button>
        </form>

        <div class="back-link">
            <a href="{{ route('home') }}">← بازگشت به سایت</a>
        </div>
    </div>
</body>
</html>