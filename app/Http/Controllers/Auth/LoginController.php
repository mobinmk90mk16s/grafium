<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * خروج کاربر (web guard)
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // اگه درخواست AJAX بود
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'خروج با موفقیت انجام شد.',
                'redirect' => route('home'),
            ]);
        }

        return redirect()->route('home');
    }
}