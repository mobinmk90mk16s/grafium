<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BaleOtpService
{
    protected string $token;
    protected string $baseUrl;
    protected string $botLink;

    public function __construct()
    {
        $this->token = config('services.bale.token');
        $this->baseUrl = config('services.bale.base_url');
        $this->botLink = config('services.bale.bot_link');
    }

    /**
     * ارسال کد OTP از طریق بله
     */
    public function sendOtp(string $chatId, string $code): bool
    {
        try {
            $message = "🔐 کد ورود شما به GRAFIUM\n\n"
                . "کد: <code>{$code}</code>\n\n"
                . "⏱ این کد ۵ دقیقه اعتبار دارد.\n"
                . "🔒 کد را در اختیار هیچ‌کس قرار ندهید.";

            $response = Http::timeout(10)->post(
                "{$this->baseUrl}/bot{$this->token}/sendMessage",
                [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ]
            );

            if ($response->successful() && $response->json('ok') === true) {
                Log::info("Bale OTP sent successfully to chat_id: {$chatId}");
                return true;
            }

            Log::error("Bale OTP failed: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("Bale OTP exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * دریافت آپدیت‌ها از بله (برای گرفتن chat_id)
     */
    public function getUpdates(int $offset = 0): array
    {
        try {
            $response = Http::timeout(10)->get(
                "{$this->baseUrl}/bot{$this->token}/getUpdates",
                [
                    'offset' => $offset,
                    'timeout' => 3,
                ]
            );

            if ($response->successful() && $response->json('ok') === true) {
                return $response->json('result') ?? [];
            }

            return [];

        } catch (\Exception $e) {
            Log::error("Bale getUpdates exception: " . $e->getMessage());
            return [];
        }
    }

    /**
     * دریافت اطلاعات بات
     */
    public function getMe(): ?array
    {
        try {
            $response = Http::timeout(10)->get(
                "{$this->baseUrl}/bot{$this->token}/getMe"
            );

            return $response->successful() ? $response->json('result') : null;

        } catch (\Exception $e) {
            Log::error("Bale getMe exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * ثبت Webhook
     */
    public function setWebhook(string $url): bool
    {
        try {
            $response = Http::timeout(10)->post(
                "{$this->baseUrl}/bot{$this->token}/setWebhook",
                ['url' => $url]
            );

            if ($response->successful() && $response->json('ok') === true) {
                Log::info("Webhook set successfully: {$url}");
                return true;
            }

            Log::error("setWebhook failed: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("setWebhook exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * حذف Webhook
     */
    public function removeWebhook(): bool
    {
        try {
            $response = Http::timeout(10)->post(
                "{$this->baseUrl}/bot{$this->token}/deleteWebhook"
            );

            return $response->successful() && $response->json('ok') === true;

        } catch (\Exception $e) {
            Log::error("deleteWebhook exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * ارسال پیام متنی ساده
     */
    public function sendMessage(string $chatId, string $text, string $parseMode = 'HTML'): bool
    {
        try {
            $response = Http::timeout(10)->post(
                "{$this->baseUrl}/bot{$this->token}/sendMessage",
                [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'parse_mode' => $parseMode,
                ]
            );

            return $response->successful() && $response->json('ok') === true;

        } catch (\Exception $e) {
            Log::error("Bale sendMessage exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * دریافت لینک بات
     */
    public function getBotLink(): string
    {
        return $this->botLink;
    }
}