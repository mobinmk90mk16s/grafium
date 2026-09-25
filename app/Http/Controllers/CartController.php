<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Scheduling;
use App\Models\ServiceItem;
use App\Models\Reservation;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * افزودن آیتم‌ها به سبد خرید
     */
    public function add(Request $request)
    {
        $request->validate([
            'scheduling_ids' => 'required|array|min:1',
            'scheduling_ids.*' => 'required|integer|exists:scheduling,id',
        ]);

        $user = Auth::user();
        $schedulingIds = $request->scheduling_ids;

        DB::beginTransaction();

        try {
            // ۱. پاکسازی سبدهای منقضی کاربر
            $this->expireUserCarts($user->id);

            // ۲. بررسی اینکه همه‌ی آیتم‌ها هنوز آزاد هستن
            $schedulings = Scheduling::whereIn('id', $schedulingIds)
                ->where('status', 'available')
                ->where('date_time', '>', now())
                ->get();

            if ($schedulings->count() !== count($schedulingIds)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'برخی از آیتم‌های انتخابی دیگه در دسترس نیستن.',
                ], 409);
            }

            // ۳. پیدا کردن یا ساخت سبد خرید
            $cart = Booking::getOrCreateCart($user->id);

            // ۴. محاسبه قیمت هر اسلات
            $totalAdded = 0;

            foreach ($schedulings as $scheduling) {
                // بررسی اینکه قبلاً توی سبد نباشه
                $exists = BookingItem::where('booking_id', $cart->id)
                    ->where('scheduling_id', $scheduling->id)
                    ->exists();

                if ($exists) continue;

                // محاسبه قیمت از pricing plan
                $price = $this->getSchedulingPrice($scheduling);

                BookingItem::create([
                    'booking_id' => $cart->id,
                    'scheduling_id' => $scheduling->id,
                    'price' => $price,
                ]);

                // تغییر وضعیت scheduling به pending
                $scheduling->update([
                    'status' => 'pending',
                    'booking_id' => $cart->id,
                ]);

                $totalAdded += $price;
            }

            // ۵. بروزرسانی مجموع و انقضا
            $cart->update([
                'total_amount' => $cart->items()->sum('price'),
                'expires_at' => now()->addMinutes(4),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'آیتم‌ها به سبد خرید اضافه شدن.',
                'cart_count' => $cart->items()->count(),
                'total_amount' => (int) $cart->total_amount,
                'expires_at' => $cart->expires_at ? $cart->expires_at->toISOString() : null,
                'remaining_seconds' => $cart->remaining_seconds,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'خطا در افزودن به سبد خرید: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * حذف آیتم از سبد
     */
    public function remove(Request $request)
    {
        $request->validate([
            'scheduling_id' => 'required|integer|exists:scheduling,id',
        ]);

        $user = Auth::user();

        $cart = Booking::where('user_id', $user->id)
            ->where('status', 'cart')
            ->latest()
            ->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'سبدی یافت نشد.'], 404);
        }

        DB::beginTransaction();
        try {
            $item = BookingItem::where('booking_id', $cart->id)
                ->where('scheduling_id', $request->scheduling_id)
                ->first();

            if (!$item) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'آیتم یافت نشد.'], 404);
            }

            // آزادسازی scheduling
            Scheduling::where('id', $request->scheduling_id)
                ->update(['status' => 'available', 'booking_id' => null]);

            $item->delete();

            // بروزرسانی مجموع
            $cart->update(['total_amount' => $cart->items()->sum('price')]);

            // اگه سبد خالی شد، انقضا رو ریست کن
            $remaining = $cart->items()->count();
            if ($remaining === 0) {
                $cart->update(['expires_at' => now()->addMinutes(4)]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'آیتم از سبد حذف شد.',
                'cart_count' => $remaining,
                'total_amount' => (int) $cart->total_amount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'خطا در حذف آیتم.'], 500);
        }
    }

    /**
     * دریافت محتوای سبد خرید
     */
    public function items()
    {
        $user = Auth::user();

        $cart = Booking::where('user_id', $user->id)
            ->where('status', 'cart')
            ->latest()
            ->first();

        if (!$cart) {
            return response()->json([
                'success' => true,
                'items' => [],
                'total_amount' => 0,
                'cart_count' => 0,
                'remaining_seconds' => 0,
            ]);
        }

        // بررسی انقضا
        if ($cart->isExpired()) {
            $this->expireCart($cart);
            return response()->json([
                'success' => true,
                'items' => [],
                'total_amount' => 0,
                'cart_count' => 0,
                'remaining_seconds' => 0,
                'expired' => true,
            ]);
        }

        $items = $cart->items()->with(['scheduling.serviceItem.service'])->get()->map(function ($item) {
            $sch = $item->scheduling;
            if (!$sch) return null;

            $serviceItem = $sch->serviceItem;
            $service = $serviceItem->service ?? null;

            return [
                'id' => $item->id,
                'scheduling_id' => $sch->id,
                'service_title' => $service->title ?? '—',
                'item_title' => $serviceItem->title ?? '—',
                'item_place' => $serviceItem->place ?? '',
                'jalali_date' => $sch->jalali_date,
                'time_start' => $sch->date_time ? $sch->date_time->format('H:i') : '—',
                'time_end' => $sch->end_time ? $sch->end_time->format('H:i') : '—',
                'price' => (int) $item->price,
                'price_formatted' => number_format($item->price),
            ];
        })->filter()->values();

        return response()->json([
            'success' => true,
            'items' => $items,
            'total_amount' => (int) $cart->total_amount,
            'total_formatted' => number_format($cart->total_amount),
            'cart_count' => $items->count(),
            'remaining_seconds' => $cart->remaining_seconds,
        ]);
    }

    /**
     * بررسی وضعیت اسلات‌ها
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'scheduling_ids' => 'required|array',
            'scheduling_ids.*' => 'integer',
        ]);

        $user = Auth::user();
        $userCart = Booking::where('user_id', $user->id)->where('status', 'cart')->latest()->first();

        $schedulings = Scheduling::whereIn('id', $request->scheduling_ids)->get();

        $result = [];
        foreach ($schedulings as $s) {
            $isMine = $userCart && $s->booking_id == $userCart->id;
            $result[$s->id] = [
                'status' => $s->status,
                'is_mine' => $isMine,
            ];
        }

        return response()->json([
            'success' => true,
            'schedulings' => $result,
        ]);
    }

    /**
     * رفتن به صفحه پرداخت (ساخت فاکتور از سبد)
     */
    public function checkout()
    {
        $user = Auth::user();

        $cart = Booking::where('user_id', $user->id)
            ->where('status', 'cart')
            ->with(['items.scheduling.serviceItem.service'])
            ->latest()
            ->first();

        // اگه سبد خالی یا منقضی باشه
        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('services')
                ->with('error', 'سبد خرید شما خالی است.');
        }

        if ($cart->isExpired()) {
            $this->expireCart($cart);
            return redirect()->route('services')
                ->with('error', 'زمان سبد خرید شما به پایان رسیده. لطفاً دوباره انتخاب کنید.');
        }

        DB::beginTransaction();
        try {
            // ۱. محاسبه مجموع
            $totalAmount = $cart->items()->sum('price');

            // ۲. اولین آیتم برای استخراج اطلاعات
            $firstItem = $cart->items->first();
            $firstScheduling = $firstItem->scheduling;

            if (!$firstScheduling) {
                throw new \Exception('اطلاعات زمان‌بندی یافت نشد.');
            }

            $serviceItem = $firstScheduling->serviceItem;
            if (!$serviceItem) {
                throw new \Exception('اطلاعات آیتم خدمت یافت نشد.');
            }

            $service = $serviceItem->service;
            if (!$service) {
                throw new \Exception('اطلاعات خدمت یافت نشد.');
            }

            $serviceId = $service->id;

            // ۳. ساخت Reservation تجمیعی (بدون desk_id)
            $reservationData = [
                'user_id' => $user->id,
                'service_id' => $serviceId,
                'reservation_date' => $firstScheduling->date_time->format('Y-m-d'),
                'shift' => 'full_day',
                'shift_persian' => 'چندگانه',
                'start_time' => $firstScheduling->date_time,
                'end_time' => $firstScheduling->end_time,
                'total_price' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'reserved_at' => now(),
            ];

            // فقط اگه ستون desk_id توی جدول هست، اضافه کن
            if (\Schema::hasColumn('reservations', 'desk_id')) {
                $reservationData['desk_id'] = null;
            }

            $reservation = Reservation::create($reservationData);

            // ۴. ساخت فاکتور
            $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT);

            $invoiceData = [
                'user_id' => $user->id,
                'reservation_id' => $reservation->id,
                'invoice_number' => $invoiceNumber,
                'title' => 'رزرو ' . ($service->title ?? 'خدمت'),
                'description' => $cart->items()->count() . ' آیتم رزرو شده',
                'amount' => $totalAmount,
                'tax' => 0,
                'discount' => 0,
                'final_amount' => $totalAmount,
                'status' => 'pending',
                'due_date' => now()->addHours(24),
                'issued_at' => now(),
            ];

            $invoice = Invoice::create($invoiceData);

            // ۵. انتقال آیتم‌ها از cart به reservation
            foreach ($cart->items as $item) {
                $scheduling = $item->scheduling;

                if ($scheduling) {
                    $schedulingData = [
                        'status' => 'reserved',
                    ];

                    if (\Schema::hasColumn('scheduling', 'reservation_id')) {
                        $schedulingData['reservation_id'] = $reservation->id;
                    }

                    if (\Schema::hasColumn('scheduling', 'booking_id')) {
                        $schedulingData['booking_id'] = null;
                    }

                    $scheduling->update($schedulingData);
                }
            }

            // ۶. آپدیت cart
            $cart->update([
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('invoices.show', $invoice->id)
                ->with('success', 'سفارش شما ثبت شد. لطفاً فاکتور را پرداخت کنید.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Checkout failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'cart_id' => $cart->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('services')
                ->with('error', 'خطا در ثبت سفارش: ' . $e->getMessage());
        }
    }

    /**
     * پاک کردن سبدهای منقضی کاربر
     */
    private function expireUserCarts(int $userId): void
    {
        $expiredCarts = Booking::where('user_id', $userId)
            ->where('status', 'cart')
            ->where('expires_at', '<', now())
            ->get();

        foreach ($expiredCarts as $cart) {
            $this->expireCart($cart);
        }
    }

    /**
     * منقضی کردن یک سبد
     */
    private function expireCart(Booking $cart): void
    {
        DB::beginTransaction();
        try {
            Scheduling::where('booking_id', $cart->id)
                ->where('status', 'pending')
                ->update(['status' => 'available', 'booking_id' => null]);

            $cart->items()->delete();

            $cart->update([
                'status' => 'expired',
                'total_amount' => 0,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * محاسبه قیمت یک اسلات
     */
    private function getSchedulingPrice(Scheduling $scheduling): int
    {
        $serviceItem = $scheduling->serviceItem;
        if (!$serviceItem) return 0;

        $service = $serviceItem->service;
        if (!$service) return 0;

        $plan = $service->pricingPlans()
            ->where('status', 'active')
            ->where('is_default', 1)
            ->first();

        if (!$plan) {
            $plan = $service->pricingPlans()->where('status', 'active')->first();
        }

        if ($plan) return (int) $plan->price;

        return (int) $service->price;
    }
}