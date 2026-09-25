<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
        'is_verified',
        'status',
        'last_login',
        'otp_code',
        'otp_expires_at',
        'phone_verified_at',
        'bale_chat_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'last_login' => 'datetime',
            'otp_expires_at' => 'datetime',
            'phone_verified_at' => 'datetime',
        ];
    }

    // ============================================================
    // روابط
    // ============================================================

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function blogComments()
    {
        return $this->hasMany(BlogComment::class);
    }

    // ============================================================
    // متدهای کمکی OTP
    // ============================================================

    public function hasVerifiedPhone(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function hasBaleStarted(): bool
    {
        return !is_null($this->bale_chat_id);
    }

    public function hasValidOtp(): bool
    {
        return $this->otp_code
            && $this->otp_expires_at
            && now()->lessThan($this->otp_expires_at);
    }

    public function clearOtp(): void
    {
        $this->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name ?: 'کاربر ' . substr($this->phone ?? '', -4);
    }
}