<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Desk;
use App\Models\Reservation;
use App\Models\Invoice;
use App\Models\Booking;

class AdminController extends Controller
{
    /**
     * نمایش صفحه اصلی پنل ادمین (داشبورد)
     */
    public function index()
    {
        // ============================================================
        // آمار واقعی از دیتابیس
        // ============================================================
        $stats = [
            // کاربران و مدیران
            'total_users' => User::count(),
            'total_admins' => Admin::count(),

            // رزروها
            'total_reservations' => Reservation::count(),
            'active_reservations' => Reservation::where('status', 'active')->count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'completed_reservations' => Reservation::where('status', 'completed')->count(),
            'cancelled_reservations' => Reservation::where('status', 'cancelled')->count(),

            // فاکتورها
            'total_invoices' => Invoice::count(),
            'paid_invoices' => Invoice::where('status', 'paid')->count(),
            'pending_invoices' => Invoice::where('status', 'pending')->count(),

            // درآمد
            'total_income' => Invoice::where('status', 'paid')->sum('final_amount'),

            // رزروهای امروز
            'today_reservations' => Reservation::whereDate('created_at', today())->count(),

            // کاربران جدید امروز
            'today_new_users' => User::whereDate('created_at', today())->count(),

            // کل bookings پرداخت‌شده
            'total_bookings_paid' => Booking::where('status', 'paid')->count(),
        ];

        // ============================================================
        // آخرین رزروها (از جدول reservations)
        // ============================================================
        $recentReservations = Reservation::with(['user', 'service', 'desk'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // ============================================================
        // آخرین فاکتورها (اختیاری)
        // ============================================================
        $recentInvoices = Invoice::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.panel', compact(
            'stats',
            'recentReservations',
            'recentInvoices'
        ));
    }

    /**
     * نمایش لیست مدیران
     */
    public function adminsList()
    {
        $admins = Admin::all();
        return view('admin.admins', compact('admins'));
    }

    public function create()
    {
        $admins = Admin::all();
        return view('admin.admins', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,manager,support',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => 1,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'مدیر جدید با موفقیت ایجاد شد.');
    }

    public function show($id)
    {
        $admin = Admin::findOrFail($id);
        $admins = Admin::all();
        return view('admin.admins', compact('admin', 'admins'));
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $admins = Admin::all();
        return view('admin.admins', compact('admin', 'admins'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,manager,support',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')
            ->with('success', 'مدیر با موفقیت به‌روزرسانی شد.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if (Admin::count() <= 1) {
            return back()->with('error', 'حداقل یک ادمین باید در سیستم وجود داشته باشد.');
        }

        $admin->delete();
        return redirect()->route('admin.admins.index')
            ->with('success', 'مدیر با موفقیت حذف شد.');
    }

    // ============================================================
    // مدیریت کاربران عادی
    // ============================================================

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function userShow($id)
    {
        $user = User::findOrFail($id);
        $reservations = $user->reservations;
        $invoices = $user->invoices;
        return view('admin.users', compact('user', 'reservations', 'invoices'));
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'blocked']);
        return back()->with('success', 'کاربر با موفقیت مسدود شد.');
    }

    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return back()->with('success', 'کاربر با موفقیت فعال شد.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت حذف شد.');
    }

    // ============================================================
    // مدیریت میزها
    // ============================================================

    public function desks()
    {
        $desks = Desk::all();
        return view('admin.desks', compact('desks'));
    }

    public function deskCreate()
    {
        return view('admin.desks');
    }

    public function deskStore(Request $request)
    {
        $request->validate([
            'desk_number' => 'required|integer|unique:desks',
            'name' => 'required|string|max:100',
            'floor' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'price_per_shift' => 'required|numeric|min:0',
            'has_monitor' => 'boolean',
            'has_printer' => 'boolean',
            'is_available' => 'boolean',
        ]);

        Desk::create($request->all());
        return redirect()->route('admin.desks.index')->with('success', 'میز با موفقیت ایجاد شد.');
    }

    public function deskEdit($id)
    {
        $desk = Desk::findOrFail($id);
        return view('admin.desks', compact('desk'));
    }

    public function deskUpdate(Request $request, $id)
    {
        $desk = Desk::findOrFail($id);

        $request->validate([
            'desk_number' => 'required|integer|unique:desks,desk_number,' . $id,
            'name' => 'required|string|max:100',
            'floor' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'price_per_shift' => 'required|numeric|min:0',
            'has_monitor' => 'boolean',
            'has_printer' => 'boolean',
            'is_available' => 'boolean',
        ]);

        $desk->update($request->all());
        return redirect()->route('admin.desks.index')->with('success', 'میز با موفقیت به‌روزرسانی شد.');
    }

    public function deskDestroy($id)
    {
        $desk = Desk::findOrFail($id);
        $desk->delete();
        return redirect()->route('admin.desks.index')->with('success', 'میز با موفقیت حذف شد.');
    }

    // ============================================================
    // مدیریت رزروها
    // ============================================================

    public function reservations()
    {
        $reservations = Reservation::with(['user', 'desk'])->get();
        return view('admin.reservations', compact('reservations'));
    }

    public function updateReservationStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled,expired',
        ]);

        $reservation->update(['status' => $request->status]);
        return back()->with('success', 'وضعیت رزرو با موفقیت به‌روزرسانی شد.');
    }

    public function deleteReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'رزرو با موفقیت حذف شد.');
    }

    // ============================================================
    // مدیریت فاکتورها
    // ============================================================

    public function invoices()
    {
        $invoices = Invoice::with('user')->get();
        return view('admin.invoices', compact('invoices'));
    }

    public function updateInvoiceStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,paid,cancelled,refunded',
        ]);

        $invoice->update(['status' => $request->status]);
        return back()->with('success', 'وضعیت فاکتور با موفقیت به‌روزرسانی شد.');
    }

    public function deleteInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'فاکتور با موفقیت حذف شد.');
    }
}