<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Scheduling;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * لیست فاکتورهای کاربر
     */
    public function index()
    {
        $user = Auth::user();

        $invoices = Invoice::where('user_id', $user->id)
            ->with('reservation.service')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Invoice::where('user_id', $user->id)->count(),
            'paid' => Invoice::where('user_id', $user->id)->where('status', 'paid')->count(),
            'pending' => Invoice::where('user_id', $user->id)->where('status', 'pending')->count(),
            'total_paid' => Invoice::where('user_id', $user->id)->where('status', 'paid')->sum('final_amount'),
        ];

        return view('invoices.index', compact('invoices', 'stats'));
    }

    /**
     * نمایش جزئیات یک فاکتور
     */
    public function show($id)
    {
        $user = Auth::user();

        $invoice = Invoice::where('user_id', $user->id)
            ->with(['reservation.service', 'reservation.desk'])
            ->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    /**
     * پرداخت فاکتور (Mock - بعداً به درگاه وصل میشه)
     */
    public function pay(Request $request, $id)
    {
        $user = Auth::user();
        $invoice = Invoice::where('user_id', $user->id)->findOrFail($id);

        if ($invoice->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'این فاکتور قبلاً پرداخت شده است.',
            ], 400);
        }

        // ============================================================
        // TODO: اتصال به درگاه پرداخت
        // ============================================================
        // فعلاً به صورت Mock پرداخت رو تایید می‌کنیم

        DB::beginTransaction();
        try {
            // ۱. آپدیت فاکتور
            $invoice->update([
                'status' => 'paid',
                'payment_method' => 'online',
                'payment_date' => now(),
            ]);

            // ۲. آپدیت رزرو
            if ($invoice->reservation) {
                $invoice->reservation->update([
                    'payment_status' => 'paid',
                    'status' => 'active',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'پرداخت با موفقیت انجام شد.',
                'redirect' => route('invoices.show', $invoice->id),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'خطا در پرداخت: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * دانلود PDF فاکتور (فعلاً HTML ساده)
     */
    public function download($id)
    {
        $user = Auth::user();
        $invoice = Invoice::where('user_id', $user->id)
            ->with(['reservation.service', 'user'])
            ->findOrFail($id);

        // فعلاً فقط نمایش می‌ده (بعداً PDF می‌سازیم)
        return view('invoices.pdf', compact('invoice'));
    }
}