<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * نمایش صفحه ویرایش پروفایل
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * به‌روزرسانی اطلاعات کاربر
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($user->id),
            ],
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'نام الزامی است.',
            'email.email' => 'ایمیل معتبر نیست.',
            'email.unique' => 'این ایمیل قبلاً استفاده شده است.',
            'phone.required' => 'شماره موبایل الزامی است.',
            'phone.unique' => 'این شماره موبایل قبلاً استفاده شده است.',
            'avatar.image' => 'فایل باید تصویر باشد.',
            'avatar.max' => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',
        ]);

        // ===== آپلود آواتار =====
        if ($request->hasFile('avatar')) {
            // پاک کردن آواتار قدیمی
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $file = $request->file('avatar');
            $filename = 'avatars/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('avatars', basename($filename), 'public');
            $validated['avatar'] = $filename;
        }

        $user->update($validated);

        // اگه درخواست AJAX بود
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'اطلاعات با موفقیت به‌روزرسانی شد.',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null,
                ],
            ]);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'اطلاعات با موفقیت به‌روزرسانی شد.');
    }

    /**
     * تغییر رمز عبور (اختیاری — چون OTP داریم)
     */
    public function updatePassword(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'شما با OTP وارد شده‌اید و نیازی به رمز عبور ندارید.',
        ], 400);
    }
}