<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServicePricingPlan;

class PricingPlanController extends Controller
{
    /**
     * نمایش لیست پلن‌های قیمت‌گذاری یک خدمت
     */
    public function index($serviceId)
    {
        $service = Service::with('pricingPlans')->findOrFail($serviceId);
        $plans = $service->pricingPlans;

        $stats = [
            'total' => $plans->count(),
            'active' => $plans->where('status', 'active')->count(),
            'inactive' => $plans->where('status', 'inactive')->count(),
        ];

        return view('admin.pricing-plans.index', compact('service', 'plans', 'stats'));
    }

    /**
     * ذخیره پلن جدید
     */
    public function store(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:hour,shift,day,month',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'is_default' => 'boolean',
            'features' => 'nullable|json',
        ]);

        // اگر پلن پیش‌فرض هست، سایر پلن‌ها رو غیرپیش‌فرض کن
        if ($request->is_default) {
            ServicePricingPlan::where('service_id', $serviceId)->update(['is_default' => 0]);
        }

        ServicePricingPlan::create([
            'service_id' => $serviceId,
            'title' => $request->title,
            'price' => $request->price,
            'duration' => $request->duration,
            'duration_type' => $request->duration_type,
            'description' => $request->description,
            'status' => $request->status,
            'is_default' => $request->is_default ?? 0,
            'features' => $request->features ? json_decode($request->features, true) : null,
        ]);

        return redirect()->route('admin.pricing-plans.index', $serviceId)
            ->with('success', 'پلن قیمت‌گذاری با موفقیت اضافه شد.');
    }

    /**
     * به‌روزرسانی پلن
     */
    public function update(Request $request, $serviceId, $id)
    {
        $plan = ServicePricingPlan::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:hour,shift,day,month',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'is_default' => 'boolean',
            'features' => 'nullable|json',
        ]);

        // اگر پلن پیش‌فرض هست، سایر پلن‌ها رو غیرپیش‌فرض کن
        if ($request->is_default) {
            ServicePricingPlan::where('service_id', $serviceId)->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $plan->update([
            'title' => $request->title,
            'price' => $request->price,
            'duration' => $request->duration,
            'duration_type' => $request->duration_type,
            'description' => $request->description,
            'status' => $request->status,
            'is_default' => $request->is_default ?? 0,
            'features' => $request->features ? json_decode($request->features, true) : null,
        ]);

        return redirect()->route('admin.pricing-plans.index', $serviceId)
            ->with('success', 'پلن قیمت‌گذاری با موفقیت به‌روزرسانی شد.');
    }

    /**
     * تغییر وضعیت پلن
     */
    public function toggleStatus($serviceId, $id)
    {
        $plan = ServicePricingPlan::findOrFail($id);
        $plan->update(['status' => $plan->status === 'active' ? 'inactive' : 'active']);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت پلن با موفقیت تغییر کرد.',
            'new_status' => $plan->status,
        ]);
    }

    /**
     * حذف پلن (با شرط حداقل یک پلن)
     */
    public function destroy($serviceId, $id)
    {
        $plan = ServicePricingPlan::findOrFail($id);

        // بررسی حداقل یک پلن
        $planCount = ServicePricingPlan::where('service_id', $serviceId)->count();
        if ($planCount <= 1) {
            return redirect()->route('admin.pricing-plans.index', $serviceId)
                ->with('error', 'هر خدمت باید حداقل یک پلن داشته باشد. امکان حذف آخرین پلن وجود ندارد.');
        }

        $plan->delete();

        return redirect()->route('admin.pricing-plans.index', $serviceId)
            ->with('success', 'پلن قیمت‌گذاری با موفقیت حذف شد.');
    }

    /**
     * تنظیم پلن به عنوان پیش‌فرض
     */
    public function setDefault($serviceId, $id)
    {
        // غیرپیش‌فرض کردن همه پلن‌ها
        ServicePricingPlan::where('service_id', $serviceId)->update(['is_default' => 0]);

        // تنظیم پلن مورد نظر به عنوان پیش‌فرض
        $plan = ServicePricingPlan::findOrFail($id);
        $plan->update(['is_default' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'پلن پیش‌فرض با موفقیت تنظیم شد.',
        ]);
    }

    /**
     * نمایش فرم ویرایش پلن (برای مودال)
     */
    public function edit($serviceId, $id)
    {
        $plan = ServicePricingPlan::findOrFail($id);
        return view('admin.pricing-plans.partials.edit', compact('plan', 'serviceId'));
    }
}