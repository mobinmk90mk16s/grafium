<?php

namespace App\Console\Commands;

use App\Services\BaleOtpService;
use App\Models\User;
use App\Models\PendingChatId;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BalePoller extends Command
{
    protected $signature = 'bale:poll 
                            {--interval=2 : فاصله بین هر پول به ثانیه}
                            {--once : فقط یک بار اجرا کن}';

    protected $description = 'دریافت پیام‌های بله از طریق getUpdates (Polling)';

    protected BaleOtpService $bale;
    protected int $lastOffset = 0;

    public function __construct(BaleOtpService $bale)
    {
        parent::__construct();
        $this->bale = $bale;
    }

    public function handle(): int
    {
        $interval = (int) $this->option('interval');
        $once = $this->option('once');

        // بازیابی offset قبلی
        $this->lastOffset = (int) Cache::get('bale_poll_offset', 0);

        $this->info("🤖 Bale Poller started (interval: {$interval}s)");
        $this->line("   Last offset: {$this->lastOffset}");
        $this->newLine();

        if ($once) {
            $this->poll();
            return 0;
        }

        // حلقه بی‌پایان
        while (true) {
            try {
                $this->poll();
            } catch (\Exception $e) {
                Log::error("Bale poller error: " . $e->getMessage());
                $this->error("❌ خطا: " . $e->getMessage());
            }

            sleep($interval);
        }

        return 0;
    }

    protected function poll(): void
    {
        $updates = $this->bale->getUpdates($this->lastOffset);

        if (empty($updates)) {
            return;
        }

        foreach ($updates as $update) {
            $updateId = $update['update_id'] ?? 0;
            $this->processUpdate($update);
            
            // بروزرسانی offset
            $this->lastOffset = $updateId + 1;
            Cache::put('bale_poll_offset', $this->lastOffset, now()->addDays(7));
        }
    }

    protected function processUpdate(array $update): void
    {
        if (!isset($update['message'])) {
            return;
        }

        $message = $update['message'];
        $chatId = $message['chat']['id'] ?? null;
        $text = trim($message['text'] ?? '');
        $firstName = $message['from']['first_name'] ?? 'دوست عزیز';

        if (!$chatId) return;

        // /start
        if (str_starts_with($text, '/start')) {
            $this->handleStart($chatId, $firstName);
        }
    }

    protected function handleStart($chatId, $firstName): void
    {
        $chatIdStr = (string) $chatId;

        // چک: قبلاً ثبت شده؟
        $existingUser = User::where('bale_chat_id', $chatIdStr)->first();

        if ($existingUser) {
            $this->bale->sendMessage(
                $chatId,
                "👋 سلام <b>{$firstName}</b>!\n\n"
                . "شما قبلاً در GRAFIUM ثبت‌نام کرده‌اید.\n"
                . "حالا به سایت برگردید و کد ورود دریافت کنید."
            );
            $this->line("   ℹ️  User already exists: {$existingUser->phone}");
            return;
        }

        // چک: کسی pending هست؟
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
            $this->line("   ℹ️  No pending phone found");
            return;
        }

        // پیدا کردن کاربر
        $user = User::where('phone', $pending->phone)->first();

        if (!$user) {
            $this->bale->sendMessage(
                $chatId,
                "❌ خطا: کاربر با این شماره یافت نشد.\nلطفاً دوباره در سایت تلاش کنید."
            );
            return;
        }

        // ذخیره chat_id
        $user->update(['bale_chat_id' => $chatIdStr]);
        $pending->delete();

        $this->bale->sendMessage(
            $chatId,
            "✅ <b>{$firstName} عزیز، خوش آمدید!</b>\n\n"
            . "شماره شما با موفقیت ثبت شد.\n\n"
            . "حالا به سایت برگردید و روی «استارت کردم، دوباره تلاش کن» کلیک کنید."
        );

        $this->info("   ✅ chat_id saved: {$user->phone} → {$chatIdStr}");
        Log::info("Bale chat_id saved via polling", [
            'phone' => $user->phone,
            'chat_id' => $chatIdStr,
        ]);
    }
}