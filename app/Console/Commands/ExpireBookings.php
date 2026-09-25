<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Scheduling;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireBookings extends Command
{
    protected $signature = 'bookings:expire';
    protected $description = 'منقضی کردن سبدهای خرید قدیمی';

    public function handle(): int
    {
        $expiredCarts = Booking::where('status', 'cart')
            ->where('expires_at', '<', now())
            ->get();

        if ($expiredCarts->isEmpty()) {
            return 0;
        }

        $count = 0;
        foreach ($expiredCarts as $cart) {
            DB::beginTransaction();
            try {
                Scheduling::where('booking_id', $cart->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'available', 'booking_id' => null]);

                $cart->items()->delete();
                $cart->update(['status' => 'expired', 'total_amount' => 0]);

                DB::commit();
                $count++;
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }

        $this->info("✅ {$count} سبد منقضی شد.");
        return 0;
    }
}