<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking_items';

    protected $fillable = [
        'booking_id',
        'scheduling_id',
        'price',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    // ============================================================
    // روابط
    // ============================================================

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function scheduling()
    {
        return $this->belongsTo(Scheduling::class);
    }
}