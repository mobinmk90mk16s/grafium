<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpLog;
use App\Models\PendingChatId;
use App\Services\BaleOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{
    protected BaleOtpService $bale;

    public function __construct(BaleOtpService $bale)
    {
        $this->bale = $bale;
    }

    /**
     * ارسال کد OTP
     */
    public function send(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:20',
        ]);

        $phone = $this->normalizePhone($request->phone);

        // ============================================================
        // Rate limit: حداکثر ۳ بار در ۵ دقیقه
        // ============================================================
        $recentCount = OtpLog::forPhone($phone)->recent(5)->count();

        if ($recentCount >= config('services.bale.max_otp_per_5min', 3)) {
            return response()->json([
                'success' => false,
                'message' => 'تعداد درخواست‌ها بیش از حد مجاز است. لطفاً ۵ دقیقه دیگر تلاش کنید.',
            ], 429);
        }

        // ============================================================
        // پیدا کردن یا ساخت کاربر
        // ============================================================
        $user = User::firstOrCreate(
            ['phone' => $phone],
            [
                'name' => 'کاربر ' . substr($phone, -4),
                'status' => 'active',
                'is_verified' => 0,
            ]
        );

        // ============================================================
        // چک: آیا chat_id داره؟
        // ============================================================
        if (!$user->bale_chat_id) {
            // ذخیره شماره به عنوان pending
            PendingChatId::cleanOld();
            PendingChatId::create([
                'phone' => $phone,
                'expires_at' => now()->addMinutes(10),
            ]);

            return response()->json([
                'success' => false,
                'needs_bot_start' => true,
                'message' => 'برای دریافت کد، ابتدا بازوی ما را در بله استارت کنید.',
                'bot_link' => $this->bale->getBotLink(),
            ]);
        }

        // ============================================================
        // تولید کد ۶ رقمی
        // ============================================================
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // ارسال از طریق بله
        $sent = $this->bale->sendOtp($user->bale_chat_id, $code);

        if (!$sent) {
            Log::warning("OTP send failed for {$phone}, chat_id: {$user->bale_chat_id}");

            return response()->json([
                'success' => false,
                'message' => 'خطا در ارسال کد. لطفاً مطمئن شوید بازو را استارت کرده‌اید و دوباره تلاش کنید.',
            ], 500);
        }

        // ============================================================
        // ذخیره کد در دیتابیس
        // ============================================================
        $user->update([
            'otp_code' => Hash::make($code),
            'otp_expires_at' => now()->addSeconds(config('services.bale.otp_ttl', 300)),
        ]);

        OtpLog::create([
            'phone' => $phone,
            'code' => $code,
            'ip' => $request->ip(),
            'status' => 'sent',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'کد ورود به بله شما ارسال شد.',
            'phone' => $phone,
        ]);
    }

    /**
     * تأیید کد OTP و ورود
     */
    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string|size:6',
        ]);

        $phone = $this->normalizePhone($request->phone);

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'کاربر یافت نشد. لطفاً دوباره شماره را وارد کنید.',
            ], 404);
        }

        if (!$user->otp_code || !$user->otp_expires_at) {
            return response()->json([
                'success' => false,
                'message' => 'کدی برای این شماره ارسال نشده است.',
            ], 400);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            $user->clearOtp();

            return response()->json([
                'success' => false,
                'message' => 'کد منقضی شده است. لطفاً کد جدید دریافت کنید.',
            ], 400);
        }

        if (!Hash::check($request->code, $user->otp_code)) {
            return response()->json([
                'success' => false,
                'message' => 'کد وارد شده صحیح نیست.',
            ], 400);
        }

        // ============================================================
        // ورود موفق
        // ============================================================
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'phone_verified_at' => now(),
            'last_login' => now(),
        ]);

        OtpLog::forPhone($phone)
            ->where('status', 'sent')
            ->update(['status' => 'verified']);

        Auth::login($user, true);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'ورود با موفقیت انجام شد.',
            'redirect' => route('dashboard'),
            'user' => [
                'id' => $user->id,
                'name' => $user->display_name,
            ],
        ]);
    }

    /**
     * بررسی: آیا کاربر chat_id داره؟
     * Frontend هر ۲-۳ ثانیه این رو چک می‌کنه
     */
    public function checkChatId(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $this->normalizePhone($request->phone);

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'has_chat_id' => false,
                'message' => 'کاربر یافت نشد.',
            ]);
        }

        return response()->json([
            'success' => true,
            'has_chat_id' => !is_null($user->bale_chat_id),
        ]);
    }

    /**
     * عادی‌سازی شماره موبایل
     * ۰۹۱۲... → 98912...
     */
    protected function normalizePhone(string $phone): string
    {
        // حذف کاراکترهای غیرعددی
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // ۰۹۱۲... → 98912...
        if (str_starts_with($phone, '0')) {
            $phone = '98' . substr($phone, 1);
        }

        // 912... → 98912...
        if (strlen($phone) === 10 && str_starts_with($phone, '9')) {
            $phone = '98' . $phone;
        }

        return $phone;
    }
}