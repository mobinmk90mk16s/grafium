<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'status',
        'expires_at',
        'total_amount',
        'paid_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'total_amount' => 'integer',
    ];

    // ============================================================
    // روابط
    // ============================================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    // ============================================================
    // اسکوپ‌ها
    // ============================================================

    public function scopeCart($query)
    {
        return $query->where('status', 'cart');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['cart', 'pending'])
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    // ============================================================
    // متدهای کمکی
    // ============================================================

    public function isExpired(): bool
    {
        return $this->status === 'cart'
            && $this->expires_at
            && now()->greaterThan($this->expires_at);
    }

    public function getRemainingSecondsAttribute(): int
    {
        if (!$this->expires_at) return 0;
        $seconds = now()->diffInSeconds($this->expires_at, false);
        return max(0, (int) $seconds);
    }

    public function getStatusPersianAttribute(): string
    {
        $statuses = [
            'cart' => 'در سبد خرید',
            'pending' => 'در انتظار پرداخت',
            'paid' => 'پرداخت شده',
            'expired' => 'منقضی شده',
            'cancelled' => 'لغو شده',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    // ============================================================
    // پیدا کردن سبد فعال کاربر
    // ============================================================

    public static function getActiveCart(int $userId): ?self
    {
        return static::where('user_id', $userId)
            ->where('status', 'cart')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->first();
    }

    public static function getOrCreateCart(int $userId): self
    {
        $cart = static::getActiveCart($userId);

        if (!$cart) {
            $cart = static::create([
                'user_id' => $userId,
                'status' => 'cart',
                'expires_at' => now()->addMinutes(4),
            ]);
        }

        return $cart;
    }
}