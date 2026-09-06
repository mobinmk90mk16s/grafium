<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;

    protected $table = 'service_items';

    protected $fillable = [
        'service_id',
        'title',
        'description',
        'status',
        'place',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'service_id' => 'integer',
    ];

    // ============================================================
    // روابط
    // ============================================================

    /**
     * رابطه با خدمت
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // ============================================================
    // متدهای کمکی
    // ============================================================

    /**
     * دریافت وضعیت به فارسی
     */
    public function getStatusPersianAttribute()
    {
        return $this->status === 'active' ? 'فعال' : 'غیرفعال';
    }

    /**
     * دریافت کلاس بج وضعیت
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->status === 'active' ? 'badge-active' : 'badge-inactive';
    }

    // ============================================================
    // اسکوپ‌ها
    // ============================================================

    /**
     * اسکوپ: آیتم‌های فعال
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * اسکوپ: آیتم‌های غیرفعال
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * اسکوپ: مرتب‌سازی بر اساس order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}