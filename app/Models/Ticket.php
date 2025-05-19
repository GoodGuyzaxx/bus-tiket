<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_id',
        'route_id',
        'seat_number',
        'price',
        'status',
        'payment_status',
    ];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
