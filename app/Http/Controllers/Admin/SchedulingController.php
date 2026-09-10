<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scheduling;
use App\Models\Service;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchedulingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Scheduling::with(['serviceItem.service'])
            ->orderBy('date_time', 'desc')
            ->paginate(15);
        
        $stats = [
            'total' => Scheduling::count(),
            'available' => Scheduling::where('status', 'available')->count(),
            'reserved' => Scheduling::where('status', 'reserved')->count(),
            'maintenance' => Scheduling::where('status', 'maintenance')->count(),
            'today' => Scheduling::whereDate('date_time', today())->count(),
            'upcoming' => Scheduling::where('date_time', '>', now())->count(),
        ];

        $services = Service::where('status', 'active')->orderBy('title')->get();
        $serviceItems = ServiceItem::where('status', 'active')->orderBy('title')->get();

        return view('admin.scheduling.index', compact('schedules', 'stats', 'services', 'serviceItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::where('status', 'active')->orderBy('title')->get();
        $serviceItems = ServiceItem::where('status', 'active')->orderBy('title')->get();
        
        return view('admin.scheduling.create', compact('services', 'serviceItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_item_id' => 'required|exists:service_items,id',
            'date_time' => 'required|date',
            'end_time' => 'required|date|after:date_time',
            'status' => 'required|in:available,reserved,maintenance,blocked',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Scheduling::create([
            'service_item_id' => $request->service_item_id,
            'date_time' => $request->date_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'note' => $request->note,
            'created_by' => auth()->guard('admin')->id(),
        ]);

        return redirect()->route('admin.scheduling.index')
            ->with('success', 'زمان‌بندی با موفقیت ایجاد شد.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $schedule = Scheduling::with(['serviceItem.service'])->findOrFail($id);
        $services = Service::where('status', 'active')->orderBy('title')->get();
        $serviceItems = ServiceItem::where('status', 'active')->orderBy('title')->get();

        return view('admin.scheduling.edit', compact('schedule', 'services', 'serviceItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $schedule = Scheduling::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'service_item_id' => 'required|exists:service_items,id',
            'date_time' => 'required|date',
            'end_time' => 'required|date|after:date_time',
            'status' => 'required|in:available,reserved,maintenance,blocked',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $schedule->update([
            'service_item_id' => $request->service_item_id,
            'date_time' => $request->date_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('admin.scheduling.index')
            ->with('success', 'زمان‌بندی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Toggle status of the specified resource.
     */
    public function toggleStatus($id)
    {
        $schedule = Scheduling::findOrFail($id);
        
        $statuses = ['available', 'reserved', 'maintenance', 'blocked'];
        $currentIndex = array_search($schedule->status, $statuses);
        $nextIndex = ($currentIndex + 1) % count($statuses);
        $newStatus = $statuses[$nextIndex];
        
        $schedule->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت به‌روزرسانی شد',
            'new_status' => $newStatus
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = Scheduling::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.scheduling.index')
            ->with('success', 'زمان‌بندی با موفقیت حذف شد.');
    }
}