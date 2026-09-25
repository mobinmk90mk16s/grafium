<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Scheduling;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * لیست رزروهای کاربر
     */
    public function index()
    {
        $user = Auth::user();

        $activeReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'active'])
            ->with(['service'])
            ->orderBy('reservation_date', 'asc')
            ->get();

        $pastReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'expired'])
            ->with(['service'])
            ->orderBy('reservation_date', 'desc')
            ->paginate(10);

        return view('reservations.index', compact('activeReservations', 'pastReservations'));
    }

    /**
     * نمایش جزئیات یک رزرو
     */
    public function show($id)
    {
        $user = Auth::user();

        $reservation = Reservation::where('user_id', $user->id)
            ->with(['service', 'invoice'])
            ->findOrFail($id);

        // پیدا کردن scheduling های این رزرو
        $schedulings = Scheduling::where('reservation_id', $reservation->id)
            ->with(['serviceItem.service'])
            ->orderBy('date_time')
            ->get();

        // محاسبه ساعت باقی‌مانده
        $hoursLeft = null;
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
        } catch (\Exception $e) {
            $hoursLeft = null;
        }

        $canCancel = in_array($reservation->status, ['pending', 'active']) 
            && $hoursLeft !== null 
            && $hoursLeft >= 24;

        return view('reservations.show', compact(
            'reservation',
            'schedulings',
            'hoursLeft',
            'canCancel'
        ));
    }

    /**
     * فرم ساخت رزرو جدید (اختیاری)
     */
    public function create()
    {
        return redirect()->route('services');
    }

    /**
     * ذخیره رزرو (اختیاری)
     */
    public function store(Request $request)
    {
        return redirect()->route('services');
    }

    /**
     * لغو رزرو
     */
    public function cancel(Request $request, $id)
    {
        $user = Auth::user();
        $reservation = Reservation::where('user_id', $user->id)->findOrFail($id);

        if (!in_array($reservation->status, ['pending', 'active'])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'این رزرو قابل لغو نیست.',
                ], 400);
            }
            return back()->with('error', 'این رزرو قابل لغو نیست.');
        }

        // چک ساعت
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
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لغو رزرو کمتر از ۲۴ ساعت قبل امکان‌پذیر نیست.',
                    ], 400);
                }
                return back()->with('error', 'لغو رزرو کمتر از ۲۴ ساعت قبل امکان‌پذیر نیست.');
            }
        } catch (\Exception $e) {
            // ادامه بده
        }

        // لغو
        $reservation->update([
            'status' => 'cancelled',
            'cancel_reason' => 'لغو توسط کاربر',
            'cancelled_at' => now(),
        ]);

        // آزادسازی scheduling‌ها
        Scheduling::where('reservation_id', $reservation->id)
            ->update([
                'status' => 'available',
                'reservation_id' => null,
            ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'رزرو با موفقیت لغو شد.',
            ]);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'رزرو با موفقیت لغو شد.');
    }

    /**
     * حذف رزرو
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $reservation = Reservation::where('user_id', $user->id)->findOrFail($id);

        // فقط رزروهای لغو شده یا منقضی قابل حذف هستن
        if (!in_array($reservation->status, ['cancelled', 'expired'])) {
            return back()->with('error', 'فقط رزروهای لغو شده یا منقضی قابل حذف هستن.');
        }

        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'رزرو با موفقیت حذف شد.');
    }
}