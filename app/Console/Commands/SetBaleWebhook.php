<?php

namespace App\Console\Commands;

use App\Services\BaleOtpService;
use Illuminate\Console\Command;

class SetBaleWebhook extends Command
{
    protected $signature = 'bale:set-webhook {url}';
    protected $description = 'ثبت Webhook برای بازوی بله';

    public function handle(BaleOtpService $bale): int
    {
        $url = $this->argument('url');

        $this->info("🔄 در حال ثبت Webhook...");
        $this->line("   URL: {$url}");

        $me = $bale->getMe();
        if (!$me) {
            $this->error('❌ اتصال به بله برقرار نشد. توکن را بررسی کنید.');
            return 1;
        }

        $this->line("   Bot: @{$me['username']}");

        if ($bale->setWebhook($url)) {
            $this->info("✅ Webhook با موفقیت ثبت شد!");
            return 0;
        }

        $this->error("❌ ثبت Webhook ناموفق بود. لاگ‌ها را بررسی کنید.");
        return 1;
    }
}