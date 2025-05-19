<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plate_number',
        'total_seats',
        'status',
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }
}
