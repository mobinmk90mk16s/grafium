<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpLog extends Model
{
    use HasFactory;

    protected $table = 'otp_logs';

    protected $fillable = [
        'phone',
        'code',
        'ip',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================================
    // اسکوپ‌ها
    // ============================================================

    public function scopeRecent($query, int $minutes = 5)
    {
        return $query->where('created_at', '>', now()->subMinutes($minutes));
    }

    public function scopeForPhone($query, string $phone)
    {
        return $query->where('phone', $phone);
    }
}