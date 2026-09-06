<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceItem;

class ServiceItemController extends Controller
{
    /**
     * نمایش لیست آیتم‌های یک خدمت
     */
    public function index($serviceId)
    {
        $service = Service::with('items')->findOrFail($serviceId);
        $items = $service->items;

        $stats = [
            'total' => $items->count(),
            'active' => $items->where('status', 'active')->count(),
            'inactive' => $items->where('status', 'inactive')->count(),
        ];

        return view('admin.service-items.index', compact('service', 'items', 'stats'));
    }

    /**
     * ذخیره آیتم جدید
     */
    public function store(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'place' => 'nullable|string|max:255',
        ]);

        // پیدا کردن آخرین order
        $lastOrder = ServiceItem::where('service_id', $serviceId)->max('order') ?? 0;

        ServiceItem::create([
            'service_id' => $serviceId,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'place' => $request->place,
            'order' => $lastOrder + 1,
        ]);

        return redirect()->route('admin.service-items.index', $serviceId)
            ->with('success', 'آیتم با موفقیت اضافه شد.');
    }

    /**
     * نمایش فرم ویرایش آیتم
     */
    public function edit($serviceId, $id)
    {
        $service = Service::findOrFail($serviceId);
        $item = ServiceItem::findOrFail($id);

        return view('admin.service-items.partials.modal', compact('service', 'item'));
    }

    /**
     * به‌روزرسانی آیتم
     */
    public function update(Request $request, $serviceId, $id)
    {
        $item = ServiceItem::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'place' => 'nullable|string|max:255',
        ]);

        $item->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'place' => $request->place,
        ]);

        return redirect()->route('admin.service-items.index', $serviceId)
            ->with('success', 'آیتم با موفقیت به‌روزرسانی شد.');
    }

    /**
     * تغییر وضعیت آیتم (فعال/غیرفعال)
     */
    public function toggleStatus($serviceId, $id)
    {
        $item = ServiceItem::findOrFail($id);
        $item->update([
            'status' => $item->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت آیتم با موفقیت تغییر کرد.',
            'new_status' => $item->status,
        ]);
    }

    /**
     * حذف آیتم
     */
    public function destroy($serviceId, $id)
    {
        $item = ServiceItem::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.service-items.index', $serviceId)
            ->with('success', 'آیتم با موفقیت حذف شد.');
    }

  
    public function reorder(Request $request, $serviceId)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:service_items,id',
        ]);

        foreach ($request->order as $index => $id) {
            ServiceItem::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'ترتیب آیتم‌ها با موفقیت تغییر کرد.',
        ]);
    }
}