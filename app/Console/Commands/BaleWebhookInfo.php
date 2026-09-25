<?php

namespace App\Console\Commands;

use App\Services\BaleOtpService;
use Illuminate\Console\Command;

class BaleWebhookInfo extends Command
{
    protected $signature = 'bale:info';
    protected $description = 'نمایش اطلاعات بازوی بله';

    public function handle(BaleOtpService $bale): int
    {
        $me = $bale->getMe();

        if (!$me) {
            $this->error('❌ اتصال به بله برقرار نشد.');
            return 1;
        }

        $this->info('🤖 اطلاعات بازو:');
        $this->line("   ID: {$me['id']}");
        $this->line("   Name: {$me['first_name']}");
        $this->line("   Username: @{$me['username']}");
        $this->line("   Link: " . $bale->getBotLink());

        return 0;
    }
}