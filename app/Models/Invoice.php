<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'user_id',
        'reservation_id',
        'invoice_number',
        'title',
        'description',
        'amount',
        'tax',
        'discount',
        'final_amount',
        'status',
        'payment_method',
        'payment_date',
        'due_date',
        'issued_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}