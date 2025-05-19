<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin',
        'destination',
        'price',
        'departure_time',
        'arrival_time',
        'bus_id',
        'status',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
