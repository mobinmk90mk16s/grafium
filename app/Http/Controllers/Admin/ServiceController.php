<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Reservation;

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

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:shift,hourly',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric|min:0',
            'place' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'config' => 'nullable|json',
        ]);

        $service->update([
            'title' => $request->title,
            'type' => $request->type,
            'status' => $request->status,
            'price' => $request->price,
            'place' => $request->place,
            'description' => $request->description,
            'icon' => $request->icon,
            'config' => $request->config ? json_decode($request->config, true) : null,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'خدمت با موفقیت به‌روزرسانی شد.');
    }

    /**
     * تغییر وضعیت خدمت (فعال/غیرفعال)
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
     * نمایش لیست رزروها
     */
    public function reservations()
    {
        $reservations = Reservation::with(['user', 'service', 'desk'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Reservation::count(),
            'active' => Reservation::where('status', 'active')->count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'completed' => Reservation::where('status', 'completed')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
            'today' => Reservation::whereDate('reservation_date', today())->count(),
        ];

        $services = Service::all();

        return view('admin.reservations.index', compact('reservations', 'stats', 'services'));
    }

    /**
     * تغییر وضعیت رزرو
     */
    public function updateReservationStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled,expired',
        ]);

        $reservation->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت رزرو با موفقیت تغییر کرد.'
        ]);
    }

    /**
     * حذف رزرو
     */
    public function deleteReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'رزرو با موفقیت حذف شد.');
    }
}