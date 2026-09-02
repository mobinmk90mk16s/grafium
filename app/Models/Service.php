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

    // رابطه با رزروها
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // اسکوپ: خدمات فعال
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // اسکوپ: خدمات شیفتی
    public function scopeShift($query)
    {
        return $query->where('type', 'shift');
    }

    // اسکوپ: خدمات ساعتی
    public function scopeHourly($query)
    {
        return $query->where('type', 'hourly');
    }

    // دریافت نوع به فارسی
    public function getTypePersianAttribute()
    {
        return $this->type === 'shift' ? 'شیفتی' : 'ساعتی';
    }

    // دریافت وضعیت به فارسی
    public function getStatusPersianAttribute()
    {
        return $this->status === 'active' ? 'فعال' : 'غیرفعال';
    }

    // فرمت قیمت
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price) . ' تومان';
    }
}