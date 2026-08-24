<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود | Grafium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap');
        * { font-family: 'Vazirmatn', sans-serif; }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 p-4">
        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-xl p-8">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-white">ورود به Grafium</h2>
                <p class="text-gray-400 text-sm mt-1">برای ورود اطلاعات خود را وارد کنید</p>
            </div>

            @if($errors->any())
                <div class="mt-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">ایمیل</label>
                    <input type="email" name="email" value="admin@grafium.ir" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition">
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">رمز عبور</label>
                    <input type="password" name="password" value="1234" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition">
                </div>
                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition transform hover:-translate-y-0.5">
                    ورود
                </button>
            </form>

            <p class="text-gray-500 text-xs text-center mt-6">سیستم مدیریت Grafium</p>
        </div>
    </div>
</body>
</html>