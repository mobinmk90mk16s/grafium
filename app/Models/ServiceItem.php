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

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * رابطه با زمان‌بندی‌ها
     */
    public function schedulings()
    {
        return $this->hasMany(Scheduling::class);
    }

    /**
     * زمان‌بندی‌های آینده
     */
    public function upcomingSchedulings()
    {
        return $this->schedulings()->where('date_time', '>=', now());
    }

    // ============================================================
    // متدهای کمکی
    // ============================================================

    public function getStatusPersianAttribute()
    {
        return $this->status === 'active' ? 'فعال' : 'غیرفعال';
    }

    public function getStatusBadgeClassAttribute()
    {
        return $this->status === 'active' ? 'badge-active' : 'badge-inactive';
    }

    // ============================================================
    // اسکوپ‌ها
    // ============================================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}