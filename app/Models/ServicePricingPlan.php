<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePricingPlan extends Model
{
    use HasFactory;

    protected $table = 'service_pricing_plans';

    protected $fillable = [
        'service_id',
        'title',
        'price',
        'duration',
        'duration_type',
        'description',
        'status',
        'is_default',
        'features',
    ];

    protected $casts = [
        'price' => 'integer',
        'duration' => 'integer',
        'is_default' => 'boolean',
        'features' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getStatusPersianAttribute()
    {
        return $this->status === 'active' ? 'فعال' : 'غیرفعال';
    }

    public function getStatusBadgeClassAttribute()
    {
        return $this->status === 'active' ? 'badge-active' : 'badge-inactive';
    }

    public function getDurationTypePersianAttribute()
    {
        $types = [
            'hour' => 'ساعت',
            'shift' => 'شیفت',
            'day' => 'روز',
            'month' => 'ماه',
        ];
        return $types[$this->duration_type] ?? $this->duration_type;
    }

    public function getDurationTextAttribute()
    {
        return $this->duration . ' ' . $this->duration_type_persian;
    }

    public function getPriceFormattedAttribute()
    {
        return number_format($this->price) . ' تومان';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}