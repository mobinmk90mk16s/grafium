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
        // اعتبارسنجی
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // اطلاعات ورود
        $credentials = $request->only('email', 'password');

        // تلاش برای ورود با گارد admin
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            
            // دریافت کاربر ادمین
            $admin = Auth::guard('admin')->user();
            
            // چک کن که ادمین فعال باشه
            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'حساب کاربری شما غیرفعال شده است.',
                ])->withInput($request->only('email', 'remember'));
            }

            // به‌روزرسانی آخرین ورود
            $admin->update(['last_login' => now()]);

            // ریدایرکت به داشبورد ادمین
            return redirect()->route('admin.dashboard');
        }

        // اگر لاگین ناموفق بود
        return back()->withErrors([
            'email' => 'ایمیل یا رمز عبور اشتباه است.',
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