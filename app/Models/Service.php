<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'type',
        'status',
        'config',
        'place',
        'description',
        'price',
        'icon',
    ];

    protected $casts = [
        'config' => 'array',
        'price' => 'integer',
    ];

    // ============================================================
    // روابط (Relationships)
    // ============================================================

    /**
     * رابطه با رزروها
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * رابطه با آیتم‌های خدمت
     */
    public function items()
    {
        return $this->hasMany(ServiceItem::class)->orderBy('order', 'asc');
    }

    /**
     * آیتم‌های فعال
     */
    public function activeItems()
    {
        return $this->items()->where('status', 'active');
    }

    /**
     * رابطه با پلن‌های قیمت‌گذاری
     */
    public function pricingPlans()
    {
        return $this->hasMany(ServicePricingPlan::class);
    }

    /**
     * پلن‌های فعال
     */
    public function activePricingPlans()
    {
        return $this->pricingPlans()->where('status', 'active');
    }

    /**
     * پلن پیش‌فرض
     */
    public function defaultPricingPlan()
    {
        return $this->pricingPlans()->where('is_default', true)->first();
    }

    // ============================================================
    // متدهای کمکی (Helpers)
    // ============================================================

    /**
     * دریافت نوع به فارسی
     */
    public function getTypePersianAttribute()
    {
        return $this->type === 'shift' ? 'شیفتی' : 'ساعتی';
    }

    /**
     * دریافت وضعیت به فارسی
     */
    public function getStatusPersianAttribute()
    {
        return $this->status === 'active' ? 'فعال' : 'غیرفعال';
    }

    /**
     * فرمت قیمت
     */
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price) . ' تومان';
    }

    /**
     * تعداد آیتم‌های فعال
     */
    public function getActiveItemsCountAttribute()
    {
        return $this->activeItems()->count();
    }

    /**
     * تعداد کل آیتم‌ها
     */
    public function getItemsCountAttribute()
    {
        return $this->items()->count();
    }

    /**
     * تعداد پلن‌ها
     */
    public function getPricingPlansCountAttribute()
    {
        return $this->pricingPlans()->count();
    }

    // ============================================================
    // اسکوپ‌ها (Scopes)
    // ============================================================

    /**
     * اسکوپ: خدمات فعال
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * اسکوپ: خدمات غیرفعال
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * اسکوپ: خدمات شیفتی
     */
    public function scopeShift($query)
    {
        return $query->where('type', 'shift');
    }

    /**
     * اسکوپ: خدمات ساعتی
     */
    public function scopeHourly($query)
    {
        return $query->where('type', 'hourly');
    }
}