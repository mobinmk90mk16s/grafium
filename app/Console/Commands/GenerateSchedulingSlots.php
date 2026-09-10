<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\Scheduling;
use Carbon\Carbon;

class GenerateSchedulingSlots extends Command
{
    protected $signature = 'scheduling:generate-slots 
                            {--days=30 : تعداد روزهای آینده}
                            {--item= : فقط برای یک آیتم خاص (id)}
                            {--fresh : پاک کردن اسلات‌های موجود و ساخت مجدد}';

    protected $description = 'ساخت اسلات‌های زمان‌بندی برای همه آیتم‌های خدمات فعال';

    public function handle()
    {
        $days = (int) $this->option('days');
        $itemId = $this->option('item');
        $fresh = $this->option('fresh');

        $this->info("🚀 شروع ساخت اسلات‌ها برای {$days} روز آینده...");

        // دریافت items
        $query = ServiceItem::with('service')->where('status', 'active');
        if ($itemId) {
            $query->where('id', $itemId);
        }
        $items = $query->get();

        if ($items->isEmpty()) {
            $this->error('❌ هیچ آیتم فعالی یافت نشد.');
            return 1;
        }

        $totalCreated = 0;

        foreach ($items as $item) {
            $service = $item->service;
            if (!$service || $service->status !== 'active') continue;

            // پاک کردن قبلی‌ها (اگه fresh)
            if ($fresh) {
                $deleted = Scheduling::where('service_item_id', $item->id)
                    ->where('status', 'available')
                    ->where('date_time', '>=', now())
                    ->delete();
                $this->line("   🗑️  پاک شد: {$deleted} اسلات قدیمی");
            }

            $created = $this->generateForItem($item, $service, $days);
            $totalCreated += $created;
            $this->line("   ✅ {$item->title} ({$service->title}) - {$created} اسلات جدید");
        }

        $this->newLine();
        $this->info("🎉 تمام شد! مجموع: {$totalCreated} اسلات ایجاد شد.");

        return 0;
    }

    private function generateForItem($item, $service, $daysCount)
    {
        $startDate = Carbon::today();
        $created = 0;

        for ($i = 0; $i < $daysCount; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');

            if ($service->type === 'shift') {
                // دو شیفت
                $slots = [
                    ['start' => '08:00', 'end' => '14:00'],
                    ['start' => '15:00', 'end' => '21:00'],
                ];
            } else {
                // ساعتی: ۱۲ اسلات
                $slots = [];
                foreach ([8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20] as $hour) {
                    $slots[] = [
                        'start' => str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00',
                        'end' => str_pad($hour + 1, 2, '0', STR_PAD_LEFT) . ':00',
                    ];
                }
            }

            foreach ($slots as $slot) {
                $start = $dateStr . ' ' . $slot['start'] . ':00';
                $end = $dateStr . ' ' . $slot['end'] . ':00';

                // بررسی موجود بودن
                $exists = Scheduling::where('service_item_id', $item->id)
                    ->where('date_time', $start)
                    ->exists();

                if (!$exists) {
                    Scheduling::create([
                        'service_item_id' => $item->id,
                        'date_time' => $start,
                        'end_time' => $end,
                        'status' => 'available',
                    ]);
                    $created++;
                }
            }
        }

        return $created;
    }
}