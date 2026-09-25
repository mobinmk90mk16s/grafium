<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Scheduling extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'scheduling';

    protected $fillable = [
        'service_item_id',
        'date_time',
        'end_time',
        'status',
        'reservation_id',
        'booking_id',      // برای tracking موقت سبد
        'note',
        'created_by',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // ============================================================
    // روابط
    // ============================================================

    public function serviceItem()
    {
        return $this->belongsTo(ServiceItem::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    // ============================================================
    // متدهای کمکی
    // ============================================================

    public function getStatusPersianAttribute()
    {
        $statuses = [
            'available' => 'قابل رزرو',
            'pending' => 'در حال رزرو',
            'reserved' => 'رزرو شده',
            'maintenance' => 'در حال تعمیر',
            'blocked' => 'مسدود',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'available' => 'badge-success',
            'pending' => 'badge-warning',
            'reserved' => 'badge-danger',
            'maintenance' => 'badge-danger',
            'blocked' => 'badge-secondary',
        ];
        return $classes[$this->status] ?? 'badge-secondary';
    }

    /**
     * تبدیل تاریخ میلادی به شمسی
     */
    public function getJalaliDateAttribute()
    {
        if (!$this->date_time) return null;

        $gy = (int) $this->date_time->format('Y');
        $gm = (int) $this->date_time->format('n');
        $gd = (int) $this->date_time->format('j');

        return $this->gregorianToJalali($gy, $gm, $gd);
    }

    private function gregorianToJalali($gy, $gm, $gd)
    {
        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        $jy = ($gy <= 1600) ? 0 : 979;
        $gy -= ($gy <= 1600) ? 621 : 1600;
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = (365 * $gy) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100)) + ((int)(($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];
        $jy += 33 * ((int)($days / 12053));
        $days %= 12053;
        $jy += 4 * ((int)($days / 1461));
        $days %= 1461;
        if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }
        $jm = ($days < 186) ? 1 + (int)($days / 31) : 7 + (int)(($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));

        $months = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];

        return $jd . ' ' . $months[$jm - 1] . ' ' . $jy;
    }

    // ============================================================
    // اسکوپ‌ها
    // ============================================================

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForItem($query, $itemId)
    {
        return $query->where('service_item_id', $itemId);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date_time', '>=', now());
    }
}