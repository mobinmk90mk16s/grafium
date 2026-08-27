<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desk extends Model
{
    use HasFactory;

    protected $table = 'desks';

    protected $fillable = [
        'desk_number',
        'name',
        'floor',
        'capacity',
        'price_per_shift',
        'has_monitor',
        'has_printer',
        'is_available',
        'image',
        'description',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}