<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PendingChatId;
use App\Services\BaleOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaleWebhookController extends Controller
{
    protected BaleOtpService $bale;

    public function __construct(BaleOtpService $bale)
    {
        $this->bale = $bale;
    }

    public function handle(Request $request)
    {
        $update = $request->all();

        Log::info('Bale Webhook:', $update);

        if (!isset($update['message'])) {
            return response()->json(['ok' => true]);
        }

        $message = $update['message'];
        $chatId = $message['chat']['id'] ?? null;
        $text = trim($message['text'] ?? '');
        $firstName = $message['from']['first_name'] ?? 'دوست عزیز';

        if (!$chatId) {
            return response()->json(['ok' => true]);
        }

        // ============================================================
        // /start
        // ============================================================
        if (str_starts_with($text, '/start')) {
            $this->handleStart($chatId, $firstName);
            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => true]);
    }

    protected function handleStart($chatId, $firstName): void
    {
        // آیا این chat_id قبلاً ثبت شده؟
        $existingUser = User::where('bale_chat_id', (string) $chatId)->first();

        if ($existingUser) {
            $this->bale->sendMessage(
                $chatId,
                "👋 سلام <b>{$firstName}</b>!\n\n"
                . "شما قبلاً در GRAFIUM ثبت‌نام کرده‌اید.\n"
                . "حالا به سایت برگردید و کد ورود دریافت کنید."
            );
            return;
        }

        // آیا کسی توی pending هست؟
        PendingChatId::cleanOld();
        $pending = PendingChatId::getLatestValid();

        if (!$pending) {
            $this->bale->sendMessage(
                $chatId,
                "👋 سلام <b>{$firstName}</b>!\n\n"
                . "به بازوی GRAFIUM خوش آمدید.\n\n"
                . "⚠️ برای دریافت کد ورود:\n"
                . "۱. به سایت برگردید\n"
                . "۲. شماره موبایل خود را وارد کنید\n"
                . "۳. روی «ارسال کد» کلیک کنید\n"
                . "۴. دوباره به اینجا برگردید"
            );
            return;
        }

        // ذخیره chat_id به کاربر
        $user = User::where('phone', $pending->phone)->first();

        if (!$user) {
            $this->bale->sendMessage(
                $chatId,
                "❌ خطا: کاربر با این شماره یافت نشد.\nلطفاً دوباره در سایت تلاش کنید."
            );
            return;
        }

        $user->update(['bale_chat_id' => (string) $chatId]);

        // پاک کردن pending
        $pending->delete();

        // پیام موفقیت
        $this->bale->sendMessage(
            $chatId,
            "✅ <b>{$firstName} عزیز، خوش آمدید!</b>\n\n"
            . "شماره شما با موفقیت ثبت شد.\n\n"
            . "حالا به سایت برگردید و روی «استارت کردم، دوباره تلاش کن» کلیک کنید تا کد ورود برایتان ارسال شود."
        );

        Log::info("Bale chat_id saved", [
            'phone' => $user->phone,
            'chat_id' => $chatId,
        ]);
    }
}