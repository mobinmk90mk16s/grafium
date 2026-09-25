<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Scheduling;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ServiceController extends Controller
{
    /**
     * نمایش لیست خدمات
     */
    public function index()
    {
        $services = Service::all();

        $stats = [
            'total' => Service::count(),
            'active' => Service::where('status', 'active')->count(),
            'inactive' => Service::where('status', 'inactive')->count(),
            'shift' => Service::where('type', 'shift')->count(),
            'hourly' => Service::where('type', 'hourly')->count(),
        ];

        return view('admin.services.index', compact('services', 'stats'));
    }

    /**
     * نمایش فرم ویرایش خدمت
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * به‌روزرسانی خدمت
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:shift,hourly',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric|min:0',
            'place' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'config' => 'nullable|json',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $file = $request->file('image');
            $filename = 'service_' . $service->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('services', $filename, 'public');
            $validated['image'] = $path;
        }

        if ($request->filled('config')) {
            $validated['config'] = json_decode($request->config, true);
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'خدمت با موفقیت به‌روزرسانی شد.');
    }

    /**
     * تغییر وضعیت خدمت
     */
    public function toggleStatus($id)
    {
        $service = Service::findOrFail($id);
        $service->update([
            'status' => $service->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت خدمت با موفقیت تغییر کرد.'
        ]);
    }

    /**
     * حذف عکس خدمت
     */
    public function deleteImage($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->update(['image' => null]);

        return response()->json([
            'success' => true,
            'message' => 'عکس حذف شد.'
        ]);
    }

    // ============================================================
    // 📅 مدیریت رزروها (از جدول bookings)
    // ============================================================

    /**
     * نمایش لیست رزروها - از bookings
     */
    public function reservations(Request $request)
    {
        // ============================================================
        // فقط رزروهای واقعی: pending, paid, cancelled
        // (نه cart و نه expired)
        // ============================================================
        $query = Booking::with(['user', 'items.scheduling.serviceItem.service'])
            ->whereIn('status', ['pending', 'paid', 'cancelled']);

        // فیلتر وضعیت
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // جستجو
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($uq) use ($search) {
                $uq->where('name', 'LIKE', "%{$search}%")
                   ->orWhere('phone', 'LIKE', "%{$search}%")
                   ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        // آمار
        $stats = [
            'total' => Booking::whereIn('status', ['pending', 'paid', 'cancelled'])->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'paid' => Booking::where('status', 'paid')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'total_income' => Booking::where('status', 'paid')->sum('total_amount'),
        ];

        return view('admin.reservations.index', compact('bookings', 'stats'));
    }

    /**
     * دریافت جزئیات یک رزرو (AJAX)
     */
    public function reservationDetails($id)
    {
        $booking = Booking::with([
            'user',
            'items.scheduling.serviceItem.service',
        ])->findOrFail($id);

        $user = $booking->user;

        // لیست آیتم‌ها
        $items = $booking->items->map(function ($item) {
            $sch = $item->scheduling;
            if (!$sch) return null;

            $serviceItem = $sch->serviceItem;
            $service = $serviceItem->service ?? null;

            return [
                'id' => $item->id,
                'scheduling_id' => $sch->id,
                'service_title' => $service->title ?? '—',
                'service_type' => $service->type ?? 'shift',
                'item_title' => $serviceItem->title ?? '—',
                'item_place' => $serviceItem->place ?? '',
                'jalali_date' => $sch->jalali_date,
                'date_raw' => $sch->date_time ? $sch->date_time->format('Y-m-d') : null,
                'time_start' => $sch->date_time ? $sch->date_time->format('H:i') : '—',
                'time_end' => $sch->end_time ? $sch->end_time->format('H:i') : '—',
                'status' => $sch->status,
                'price' => (int) $item->price,
                'price_formatted' => number_format($item->price),
            ];
        })->filter()->values();

        $statusLabels = [
            'cart' => 'در سبد خرید',
            'pending' => 'در انتظار پرداخت',
            'paid' => 'پرداخت شده',
            'expired' => 'منقضی شده',
            'cancelled' => 'لغو شده',
        ];

        return response()->json([
            'success' => true,
            'booking' => [
                'id' => $booking->id,
                'status' => $booking->status,
                'status_label' => $statusLabels[$booking->status] ?? $booking->status,
                'total_amount' => (int) $booking->total_amount,
                'total_formatted' => number_format($booking->total_amount),
                'created_at' => $booking->created_at ? $booking->created_at->format('Y/m/d H:i') : '—',
                'paid_at' => $booking->paid_at ? $booking->paid_at->format('Y/m/d H:i') : null,
                'expires_at' => $booking->expires_at ? $booking->expires_at->format('Y/m/d H:i') : null,
                'items_count' => $items->count(),
            ],
            'user' => [
                'id' => $user->id ?? null,
                'name' => $user->name ?? 'کاربر حذف شده',
                'phone' => $user->phone ?? '—',
                'email' => $user->email ?? '—',
            ],
            'items' => $items,
        ]);
    }

    /**
     * تغییر وضعیت رزرو (bookings)
     */
    public function updateReservationStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:cart,pending,paid,expired,cancelled',
        ]);

        $oldStatus = $booking->status;
        $newStatus = $request->status;

        if ($newStatus === 'paid' && $oldStatus !== 'paid') {
            // آیتم‌ها رو reserved کن
            Scheduling::where('booking_id', $booking->id)
                ->update(['status' => 'reserved']);

            $booking->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        } elseif ($newStatus === 'expired' || $newStatus === 'cancelled') {
            // آزادسازی آیتم‌ها
            Scheduling::where('booking_id', $booking->id)
                ->update(['status' => 'available', 'booking_id' => null]);

            $booking->update(['status' => $newStatus]);
        } else {
            $booking->update(['status' => $newStatus]);
        }

        return response()->json([
            'success' => true,
            'message' => 'وضعیت رزرو با موفقیت تغییر کرد.',
        ]);
    }

    /**
     * حذف رزرو
     */
    public function deleteReservation($id)
    {
        $booking = Booking::findOrFail($id);

        // آزادسازی آیتم‌ها
        Scheduling::where('booking_id', $booking->id)
            ->update(['status' => 'available', 'booking_id' => null]);

        // حذف آیتم‌ها
        $booking->items()->delete();

        // حذف رزرو
        $booking->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'رزرو با موفقیت حذف شد.');
    }
}