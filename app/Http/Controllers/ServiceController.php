<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\Scheduling;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * نمایش لیست خدمات فعال
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');

        $query = Service::where('status', 'active');

        if (in_array($type, ['shift', 'hourly'])) {
            $query->where('type', $type);
        }

        $services = $query->orderByRaw("FIELD(type, 'shift', 'hourly')")
            ->orderBy('title')
            ->get();

        $stats = [
            'total' => Service::where('status', 'active')->count(),
            'shift' => Service::where('status', 'active')->where('type', 'shift')->count(),
            'hourly' => Service::where('status', 'active')->where('type', 'hourly')->count(),
        ];

        return view('services', compact('services', 'stats', 'type'));
    }

    /**
     * نمایش صفحه جزئیات خدمت (لیست آیتم‌ها / میزها)
     */
    public function show($id)
    {
        $service = Service::with(['activeItems' => function ($query) {
            $query->orderBy('order');
        }])->where('status', 'active')->findOrFail($id);

        $now = now();
        foreach ($service->activeItems as $item) {
            $item->is_busy_now = Scheduling::where('service_item_id', $item->id)
                ->where('date_time', '<=', $now)
                ->where('end_time', '>=', $now)
                ->whereIn('status', ['reserved', 'maintenance', 'blocked'])
                ->exists();

            $item->upcoming_count = Scheduling::where('service_item_id', $item->id)
                ->where('date_time', '>', $now)
                ->where('status', 'reserved')
                ->count();
        }

        return view('services.show', compact('service'));
    }

    /**
     * نمایش صفحه رزرو (جدول شیفت‌ها / ساعت‌ها)
     */
    public function reserve($serviceId, $itemId)
    {
        $service = Service::where('status', 'active')->findOrFail($serviceId);
        $item = ServiceItem::where('service_id', $serviceId)
            ->where('status', 'active')
            ->findOrFail($itemId);

        // خودکار: اگه اسلات نبود، بساز
        $this->ensureSlotsForItem($item, $service, 30);

        // پلن قیمت‌گذاری پیش‌فرض
        $pricingPlan = $service->pricingPlans()
            ->where('status', 'active')
            ->where('is_default', 1)
            ->first();

        if (!$pricingPlan) {
            $pricingPlan = $service->pricingPlans()
                ->where('status', 'active')
                ->first();
        }

        $shiftPrice = $pricingPlan ? $pricingPlan->price : $service->price;
        $hourlyPrice = $pricingPlan ? $pricingPlan->price : $service->price;

        $now = Carbon::now();

        // ============================================================
        // ساخت آرایه روزها (۳۰ روز آینده)
        // ============================================================
        $days = [];
        $persianMonths = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
        $dayNamesFull = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'];

        for ($i = 0; $i < 30; $i++) {
            $date = $now->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');

            $jalali = $this->gregorianToJalali(
                (int) $date->format('Y'),
                (int) $date->format('n'),
                (int) $date->format('j')
            );

            $weekdayIndex = $date->dayOfWeek;
            $weekdayIndex = ($weekdayIndex + 1) % 7;

            $days[] = [
                'iso' => $dateStr,
                'jalali_year' => $jalali['year'],
                'jalali_month' => $jalali['month'],
                'jalali_day' => $jalali['day'],
                'jalali_month_name' => $persianMonths[$jalali['month'] - 1],
                'weekday_name' => $dayNamesFull[$date->dayOfWeek],
                'label' => $dayNamesFull[$date->dayOfWeek] . ' ' . $jalali['day'] . ' ' . $persianMonths[$jalali['month'] - 1],
                'is_today' => $i === 0,
                'is_holiday' => $weekdayIndex === 6,
            ];
        }

        // ============================================================
        // شیفت‌ها
        // ============================================================
        $shifts = [
            [
                'key' => 'morning',
                'label' => 'شیفت صبح',
                'time' => '۸ - ۱۴',
                'start_hour' => 8,
                'end_hour' => 14,
            ],
            [
                'key' => 'afternoon',
                'label' => 'شیفت عصر',
                'time' => '۱۵ - ۲۱',
                'start_hour' => 15,
                'end_hour' => 21,
            ],
        ];

        // ============================================================
        // ساعت‌ها
        // ============================================================
        $hourlySlots = [8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20];

        // ============================================================
        // پیدا کردن سبد فعال کاربر (اگه لاگینه)
        // ============================================================
        $userCart = null;
        if (Auth::check()) {
            $userCart = Booking::where('user_id', Auth::id())
                ->where('status', 'cart')
                ->latest()
                ->first();
        }

        // ============================================================
        // دریافت زمان‌بندی‌ها از دیتابیس
        // ============================================================
        $schedulings = Scheduling::where('service_item_id', $itemId)
            ->where('date_time', '>=', $now->copy()->startOfDay())
            ->where('date_time', '<', $now->copy()->addDays(30)->endOfDay())
            ->orderBy('date_time')
            ->get();

        $scheduleMap = [];

        foreach ($schedulings as $sch) {
            $dateKey = $sch->date_time->format('Y-m-d');
            $startHour = (int) $sch->date_time->format('H');
            $endHour = (int) $sch->end_time->format('H');

            // تشخیص اینکه آیا این اسلات توی سبد خود کاربره؟
            $isMine = $userCart && $sch->booking_id == $userCart->id;

            if ($service->type === 'shift') {
                foreach ($shifts as $shift) {
                    if ($startHour >= $shift['start_hour'] && $startHour < $shift['end_hour']) {
                        $scheduleMap[$dateKey][$shift['key']] = [
                            'status' => $sch->status,
                            'start_hour' => $startHour,
                            'end_hour' => $endHour,
                            'id' => $sch->id,
                            'is_mine' => $isMine,
                        ];
                        break;
                    }
                }
            } else {
                for ($h = $startHour; $h < $endHour; $h++) {
                    $scheduleMap[$dateKey][$h] = [
                        'status' => $sch->status,
                        'start_hour' => $startHour,
                        'end_hour' => $endHour,
                        'id' => $sch->id,
                        'is_mine' => $isMine,
                    ];
                }
            }
        }

        return view('services.reserve', compact(
            'service',
            'item',
            'pricingPlan',
            'shiftPrice',
            'hourlyPrice',
            'days',
            'shifts',
            'hourlySlots',
            'scheduleMap',
            'now'
        ));
    }

    /**
     * اطمینان از وجود اسلات‌ها برای یک item
     */
    private function ensureSlotsForItem($item, $service, $daysCount = 30)
    {
        $startDate = Carbon::today();

        for ($i = 0; $i < $daysCount; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');

            if ($service->type === 'shift') {
                $slots = [
                    ['start' => '08:00', 'end' => '14:00'],
                    ['start' => '15:00', 'end' => '21:00'],
                ];
            } else {
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

                $exists = Scheduling::where('service_item_id', $item->id)
                    ->where('date_time', $start)
                    ->exists();

                if (!$exists) {
                    Scheduling::create([
                        'service_item_id' => $item->id,
                        'date_time' => $start,
                        'end_time' => $dateStr . ' ' . $slot['end'] . ':00',
                        'status' => 'available',
                    ]);
                }
            }
        }
    }

    /**
     * تبدیل میلادی به شمسی
     */
    private function gregorianToJalali($gy, $gm, $gd)
    {
        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        $jy = ($gy <= 1600) ? 0 : 979;
        $gy -= ($gy <= 1600) ? 621 : 1600;
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = (365 * $gy) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100)) + ((int)(($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];
        $jy += 33 * ((int)($days / 12053));
        $days %= 12053;
        $jy += 4 * ((int)($days / 1461));
        $days %= 1461;
        if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }
        $jm = ($days < 186) ? 1 + (int)($days / 31) : 7 + (int)(($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));

        return ['year' => $jy, 'month' => $jm, 'day' => $jd];
    }
}