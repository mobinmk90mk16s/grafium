<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'desk_id',
        'service_id',
        'reservation_date',
        'shift',
        'shift_persian',
        'start_time',
        'end_time',
        'total_price',
        'status',
        'payment_status',
        'cancel_reason',
        'cancelled_at',
        'reserved_at',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'cancelled_at' => 'datetime',
        'reserved_at' => 'datetime',
        'total_price' => 'integer',
    ];

    // ============================================================
    // روابط (Relationships)
    // ============================================================

    /**
     * رابطه با کاربر
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * رابطه با میز
     */
    public function desk()
    {
        return $this->belongsTo(Desk::class);
    }

    /**
     * رابطه با خدمت (جدید)
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * رابطه با فاکتور
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    // ============================================================
    // متدهای کمکی (Helpers)
    // ============================================================

    /**
     * دریافت عنوان خدمت
     */
    public function getServiceTitleAttribute()
    {
        return $this->service ? $this->service->title : 'بدون خدمت';
    }

    /**
     * دریافت نام کاربر
     */
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'کاربر حذف شده';
    }

    /**
     * دریافت وضعیت به فارسی
     */
    public function getStatusPersianAttribute()
    {
        $statuses = [
            'pending' => 'در انتظار',
            'active' => 'فعال',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'expired' => 'منقضی',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * دریافت وضعیت پرداخت به فارسی
     */
    public function getPaymentStatusPersianAttribute()
    {
        $statuses = [
            'unpaid' => 'پرداخت نشده',
            'paid' => 'پرداخت شده',
            'refunded' => 'عودت داده شده',
        ];
        return $statuses[$this->payment_status] ?? $this->payment_status;
    }

    /**
     * دریافت شیفت به فارسی
     */
    public function getShiftPersianAttribute()
    {
        $shifts = [
            'morning' => 'شیفت صبح (۸-۱۴)',
            'afternoon' => 'شیفت عصر (۱۵-۲۱)',
            'full_day' => 'روز کامل',
        ];
        return $shifts[$this->shift] ?? $this->shift;
    }

    /**
     * دریافت کلاس بج وضعیت
     */
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'badge-pending',
            'active' => 'badge-active',
            'completed' => 'badge-completed',
            'cancelled' => 'badge-cancelled',
            'expired' => 'badge-expired',
        ];
        return $classes[$this->status] ?? 'badge-pending';
    }

    /**
     * دریافت کلاس بج وضعیت پرداخت
     */
    public function getPaymentBadgeClassAttribute()
    {
        $classes = [
            'unpaid' => 'badge-pending',
            'paid' => 'badge-active',
            'refunded' => 'badge-cancelled',
        ];
        return $classes[$this->payment_status] ?? 'badge-pending';
    }

    // ============================================================
    // اسکوپ‌ها (Scopes)
    // ============================================================

    /**
     * اسکوپ: رزروهای فعال
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * اسکوپ: رزروهای در انتظار
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * اسکوپ: رزروهای تکمیل شده
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * اسکوپ: رزروهای لغو شده
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * اسکوپ: رزروهای امروز
     */
    public function scopeToday($query)
    {
        return $query->whereDate('reservation_date', today());
    }

    /**
     * اسکوپ: رزروهای یک کاربر خاص
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * اسکوپ: رزروهای یک خدمت خاص
     */
    public function scopeForService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    /**
     * اسکوپ: رزروهای یک بازه زمانی
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('reservation_date', [$startDate, $endDate]);
    }
}