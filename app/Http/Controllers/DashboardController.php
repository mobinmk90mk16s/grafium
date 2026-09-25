<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Invoice;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ============================================================
        // آمار
        // ============================================================
        $stats = [
            'active_reservations' => Reservation::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'active'])
                ->count(),

            'completed_reservations' => Reservation::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),

            'pending_invoices' => Invoice::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),

            'pending_invoices_amount' => Invoice::where('user_id', $user->id)
                ->where('status', 'pending')
                ->sum('final_amount'),

            'total_paid' => Invoice::where('user_id', $user->id)
                ->where('status', 'paid')
                ->sum('final_amount'),
        ];

        // ============================================================
        // رزروهای فعال
        // ============================================================
        $activeReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'active'])
            ->with(['service'])
            ->orderBy('reservation_date', 'asc')
            ->limit(5)
            ->get();

        // ============================================================
        // رزروهای گذشته
        // ============================================================
        $pastReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'expired'])
            ->with(['service'])
            ->orderBy('reservation_date', 'desc')
            ->limit(5)
            ->get();

        // ============================================================
        // فاکتورها
        // ============================================================
        $invoices = Invoice::where('user_id', $user->id)
            ->with('reservation.service')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ============================================================
        // نمودار
        // ============================================================
        $chartData = $this->getMonthlyReservationsChart($user->id);

        // ============================================================
        // اعلان‌ها
        // ============================================================
        $notifications = $this->getNotifications($user->id, $activeReservations);

        return view('dashboard', compact(
            'user',
            'stats',
            'activeReservations',
            'pastReservations',
            'invoices',
            'chartData',
            'notifications'
        ));
    }

    /**
     * نمودار رزروهای ماهانه
     */
    private function getMonthlyReservationsChart($userId): array
    {
        $labels = [];
        $counts = [];
        $persianMonths = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $jalali = $this->gregorianToJalali(
                (int) $date->format('Y'),
                (int) $date->format('n'),
                (int) $date->format('j')
            );

            $labels[] = $persianMonths[$jalali['month'] - 1];

            $count = Reservation::where('user_id', $userId)
                ->whereYear('reservation_date', $date->year)
                ->whereMonth('reservation_date', $date->month)
                ->count();

            $counts[] = $count;
        }

        return [
            'labels' => $labels,
            'counts' => $counts,
        ];
    }

    /**
     * اعلان‌ها
     */
    private function getNotifications($userId, $activeReservations): array
    {
        $notifications = [];

        $pendingInvoices = Invoice::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        if ($pendingInvoices > 0) {
            $notifications[] = [
                'type' => 'warning',
                'icon' => 'fa-file-invoice-dollar',
                'title' => 'فاکتور پرداخت‌نشده',
                'message' => "شما {$pendingInvoices} فاکتور پرداخت‌نشده دارید.",
                'link' => route('invoices.index'),
            ];
        }

        // رزرو نزدیک - اصلاح شده
        foreach ($activeReservations as $res) {
            try {
                $dateStr = $res->reservation_date instanceof \Carbon\Carbon 
                    ? $res->reservation_date->format('Y-m-d') 
                    : Carbon::parse($res->reservation_date)->format('Y-m-d');
                
                $timeStr = $res->start_time 
                    ? ($res->start_time instanceof \Carbon\Carbon 
                        ? $res->start_time->format('H:i:s') 
                        : Carbon::parse($res->start_time)->format('H:i:s'))
                    : '08:00:00';

                $reservationDateTime = Carbon::parse($dateStr . ' ' . $timeStr);
                $hoursLeft = now()->diffInHours($reservationDateTime, false);

                if ($hoursLeft > 0 && $hoursLeft <= 24) {
                    $notifications[] = [
                        'type' => 'info',
                        'icon' => 'fa-clock',
                        'title' => 'رزرو نزدیک',
                        'message' => "رزرو شما برای " . ($res->service->title ?? 'خدمت') . " کمتر از ۲۴ ساعت دیگه شروع می‌شه!",
                        'link' => route('reservations.show', $res->id),
                    ];
                    break;
                }
            } catch (\Exception $e) {
                // skip اگه خطا خورد
                continue;
            }
        }

        if ($activeReservations->isEmpty() && empty($notifications)) {
            $notifications[] = [
                'type' => 'success',
                'icon' => 'fa-star',
                'title' => 'خوش آمدید!',
                'message' => 'برای شروع، یک خدمت رزرو کنید.',
                'link' => route('services'),
            ];
        }

        return $notifications;
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

    /**
     * لغو رزرو
     */
    public function cancelReservation($id)
    {
        $user = Auth::user();
        $reservation = Reservation::where('user_id', $user->id)->findOrFail($id);

        if (!in_array($reservation->status, ['pending', 'active'])) {
            return response()->json([
                'success' => false,
                'message' => 'این رزرو قابل لغو نیست.',
            ], 400);
        }

        try {
            $dateStr = $reservation->reservation_date instanceof \Carbon\Carbon 
                ? $reservation->reservation_date->format('Y-m-d') 
                : Carbon::parse($reservation->reservation_date)->format('Y-m-d');
            
            $timeStr = $reservation->start_time 
                ? ($reservation->start_time instanceof \Carbon\Carbon 
                    ? $reservation->start_time->format('H:i:s') 
                    : Carbon::parse($reservation->start_time)->format('H:i:s'))
                : '08:00:00';

            $reservationDateTime = Carbon::parse($dateStr . ' ' . $timeStr);
            $hoursLeft = now()->diffInHours($reservationDateTime, false);

            if ($hoursLeft < 24) {
                return response()->json([
                    'success' => false,
                    'message' => 'لغو رزرو کمتر از ۲۴ ساعت قبل امکان‌پذیر نیست.',
                ], 400);
            }
        } catch (\Exception $e) {
            // در صورت خطا، اجازه لغو بدیم
        }

        $reservation->update([
            'status' => 'cancelled',
            'cancel_reason' => 'لغو توسط کاربر',
            'cancelled_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'رزرو با موفقیت لغو شد.',
        ]);
    }
}