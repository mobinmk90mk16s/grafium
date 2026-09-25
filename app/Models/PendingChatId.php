<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingChatId extends Model
{
    use HasFactory;

    protected $table = 'pending_chat_ids';

    protected $fillable = [
        'phone',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // ============================================================
    // اسکوپ‌ها
    // ============================================================

    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    public static function getLatestValid(): ?self
    {
        return static::valid()->latest()->first();
    }

    public static function cleanOld(): int
    {
        return static::where('created_at', '<', now()->subHours(1))->delete();
    }
}