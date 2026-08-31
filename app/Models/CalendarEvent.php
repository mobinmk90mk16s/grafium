<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $table = 'calendar_events';

    protected $fillable = [
        'year',
        'month',
        'day',
        'day_name',
        'holy_day',
        'occasion',
        'occasion_type',
        'miladi_date',
        'miladi_year',
        'miladi_month',
        'miladi_day',
        'is_weekend',
        'description',
    ];

    protected $casts = [
        'holy_day' => 'boolean',
        'is_weekend' => 'boolean',
    ];

    protected $attributes = [
        'occasion_type' => 'normal',
        'holy_day' => 0,
        'is_weekend' => 0,
    ];

    // ============================================================
    // اسکوپ‌ها
    // ============================================================

    public function scopeForMonth($query, $year, $month)
    {
        return $query->where('year', $year)->where('month', $month);
    }

    public function scopeForDay($query, $year, $month, $day)
    {
        return $query->where('year', $year)->where('month', $month)->where('day', $day);
    }

    public function scopeHolidays($query)
    {
        return $query->where('holy_day', 1);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('occasion_type', $type);
    }

    public function scopeNormalDays($query)
    {
        return $query->whereNull('occasion')->orWhere('occasion', '');
    }

    public function scopeHasOccasion($query)
    {
        return $query->whereNotNull('occasion')->where('occasion', '!=', '');
    }

    // ============================================================
    // متدهای کمکی
    // ============================================================

    public function isNormal()
    {
        return empty($this->occasion) || $this->occasion_type == 'normal';
    }

    public function isHoliday()
    {
        return $this->holy_day == 1;
    }

    public function isWeekend()
    {
        return $this->is_weekend == 1;
    }

    public function getTypeLabelAttribute()
    {
        $labels = [
            'normal' => 'عادی',
            'birth' => 'ولادت',
            'death' => 'شهادت',
            'event' => 'مناسبت',
            'holiday' => 'تعطیل',
            'national' => 'ملی',
        ];
        return $labels[$this->occasion_type] ?? 'مناسبت';
    }

    public function getTypeClassAttribute()
    {
        $classes = [
            'normal' => 'badge-normal',
            'birth' => 'badge-birth',
            'death' => 'badge-death',
            'event' => 'badge-event',
            'holiday' => 'badge-holiday',
            'national' => 'badge-national',
        ];
        return $classes[$this->occasion_type] ?? 'badge-event';
    }

    public function getFullTitleAttribute()
    {
        $parts = [];
        if ($this->year) $parts[] = $this->year;
        if ($this->month) $parts[] = $this->month;
        if ($this->day) $parts[] = $this->day;
        if ($this->occasion) $parts[] = '- ' . $this->occasion;
        return implode(' ', $parts);
    }
}