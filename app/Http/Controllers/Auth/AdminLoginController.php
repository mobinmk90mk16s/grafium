<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * نمایش فرم لاگین ادمین
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * پردازش لاگین ادمین
     */
    public function login(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // تلاش برای ورود با گارد admin
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'is_active' => 1 // فقط ادمین‌های فعال میتونن وارد بشن
        ], $request->remember)) {

            // آپدیت زمان آخرین ورود
            $admin = Auth::guard('admin')->user();
            $admin->update(['last_login' => now()]);

            // ریدایرکت به پنل ادمین
            return redirect()->route('admin.dashboard');
        }

        // اگر لاگین ناموفق بود
        return back()->withErrors([
            'email' => 'ایمیل یا رمز عبور اشتباه است یا حساب کاربری شما غیرفعال می‌باشد.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * خروج ادمین
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}