<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'desk_id',
        'reservation_date',
        'shift',
        'shift_persian',
        'start_time',
        'end_time',
        'total_price',
        'status',
        'payment_status',
        'cancel_reason',
        'cancelled_at',
        'reserved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function desk()
    {
        return $this->belongsTo(Desk::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}