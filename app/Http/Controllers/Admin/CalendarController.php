<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;

class CalendarController extends Controller
{
    /**
     * نمایش صفحه اصلی تقویم
     */
    public function index()
    {
        $events = CalendarEvent::all();
        return view('admin.calendar', compact('events'));
    }

    /**
     * دریافت رویدادهای یک ماه خاص (API)
     */
    public function getMonthEvents(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $events = CalendarEvent::forMonth($year, $month)->get();
        return response()->json(['success' => true, 'data' => $events]);
    }

    /**
     * دریافت رویدادهای یک روز خاص (API)
     */
    public function getDayEvents(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $events = CalendarEvent::forDay($year, $month, $day)->get();
        return response()->json(['success' => true, 'data' => $events]);
    }

    /**
     * ذخیره یک روز جدید
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:10',
            'month' => 'required|string|max:20',
            'day' => 'required|integer|min:1|max:31',
            'day_name' => 'nullable|string|max:20',
            'holy_day' => 'boolean',
            'occasion' => 'nullable|string',
            'occasion_type' => 'required|in:normal,birth,death,event,holiday,national',
            'miladi_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $event = CalendarEvent::create([
            'year' => $request->year,
            'month' => $request->month,
            'day' => $request->day,
            'day_name' => $request->day_name,
            'holy_day' => $request->holy_day ?? 0,
            'occasion' => $request->occasion,
            'occasion_type' => $request->occasion_type,
            'miladi_date' => $request->miladi_date,
            'miladi_year' => $request->miladi_date ? date('Y', strtotime($request->miladi_date)) : null,
            'miladi_month' => $request->miladi_date ? date('F', strtotime($request->miladi_date)) : null,
            'miladi_day' => $request->miladi_date ? (int) date('d', strtotime($request->miladi_date)) : null,
            'is_weekend' => 0,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'رویداد با موفقیت اضافه شد.');
    }

    /**
     * ذخیره یک ماه کامل (ایجاد همه روزهای یک ماه)
     */
    public function storeMonth(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:10',
            'month' => 'required|string|max:20',
            'month_days' => 'required|integer|min:28|max:31',
            'first_day' => 'required|string|in:شنبه,یکشنبه,دوشنبه,سه‌شنبه,چهارشنبه,پنجشنبه,جمعه',
            'miladi_start' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $year = $request->year;
        $month = $request->month;
        $days = (int) $request->month_days;
        $firstDay = $request->first_day;
        $miladiStart = $request->miladi_start ?? date('Y-m-d');
        $description = $request->description;

        // نام روزهای هفته
        $dayNames = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'];
        
        // پیدا کردن ایندکس اولین روز
        $firstDayIndex = array_search($firstDay, $dayNames);

        for ($i = 1; $i <= $days; $i++) {
            $dayIndex = ($firstDayIndex + ($i - 1)) % 7;
            $dayName = $dayNames[$dayIndex];

            $isWeekend = ($dayIndex == 6) ? 1 : 0;
            $holyDay = ($dayIndex == 6) ? 1 : 0;

            // تاریخ میلادی
            $miladiDate = date('Y-m-d', strtotime("+" . ($i - 1) . " days", strtotime($miladiStart)));

            // بررسی وجود رکورد قبلی
            $existing = CalendarEvent::where('year', $year)
                ->where('month', $month)
                ->where('day', $i)
                ->first();

            if (!$existing) {
                CalendarEvent::create([
                    'year' => $year,
                    'month' => $month,
                    'day' => $i,
                    'day_name' => $dayName,
                    'holy_day' => $holyDay,
                    'occasion' => null,
                    'occasion_type' => 'normal',
                    'miladi_date' => $miladiDate,
                    'miladi_year' => date('Y', strtotime($miladiDate)),
                    'miladi_month' => date('F', strtotime($miladiDate)),
                    'miladi_day' => (int) date('d', strtotime($miladiDate)),
                    'is_weekend' => $isWeekend,
                    'description' => $description ?? "روزهای ماه {$month}",
                ]);
            }
        }

        return redirect()->route('admin.calendar')->with('success', "ماه {$month} با {$days} روز با موفقیت اضافه شد.");
    }

    /**
     * نمایش فرم ویرایش رویداد
     */
    public function edit($id)
    {
        $event = CalendarEvent::findOrFail($id);
        return view('admin.calendar-edit', compact('event'));
    }

    /**
     * به‌روزرسانی رویداد
     */
    public function update(Request $request, $id)
    {
        $event = CalendarEvent::findOrFail($id);

        $request->validate([
            'year' => 'required|string|max:10',
            'month' => 'required|string|max:20',
            'day' => 'required|integer|min:1|max:31',
            'day_name' => 'nullable|string|max:20',
            'holy_day' => 'boolean',
            'occasion' => 'nullable|string',
            'occasion_type' => 'required|in:normal,birth,death,event,holiday,national',
            'miladi_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $event->update([
            'year' => $request->year,
            'month' => $request->month,
            'day' => $request->day,
            'day_name' => $request->day_name,
            'holy_day' => $request->holy_day ?? 0,
            'occasion' => $request->occasion,
            'occasion_type' => $request->occasion_type,
            'miladi_date' => $request->miladi_date,
            'miladi_year' => $request->miladi_date ? date('Y', strtotime($request->miladi_date)) : null,
            'miladi_month' => $request->miladi_date ? date('F', strtotime($request->miladi_date)) : null,
            'miladi_day' => $request->miladi_date ? (int) date('d', strtotime($request->miladi_date)) : null,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.calendar')->with('success', 'رویداد با موفقیت ویرایش شد.');
    }

    /**
     * حذف رویداد (تبدیل به روز عادی)
     */
    public function destroy($id)
    {
        $event = CalendarEvent::findOrFail($id);
        $event->update([
            'occasion' => null,
            'occasion_type' => 'normal',
            'holy_day' => 0,
            'description' => null,
        ]);
        return response()->json(['success' => true, 'message' => 'رویداد به روز عادی تبدیل شد.']);
    }

    /**
     * حذف فیزیکی رویداد
     */
    public function forceDelete($id)
    {
        $event = CalendarEvent::findOrFail($id);
        $event->delete();
        return redirect()->back()->with('success', 'رویداد با موفقیت حذف شد.');
    }

    /**
     * تغییر وضعیت تعطیلی روز
     */
    public function toggleHoliday($id)
    {
        $event = CalendarEvent::findOrFail($id);
        $event->update(['holy_day' => !$event->holy_day]);
        return response()->json(['success' => true, 'message' => 'وضعیت تعطیلی تغییر کرد.']);
    }
}