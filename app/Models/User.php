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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'last_login' => 'datetime',
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
}