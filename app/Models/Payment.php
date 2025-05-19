<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'order_id',
        'amount',
        'payment_type',
        'transaction_id',
        'transaction_status',
        'transaction_time',
        'status_message',
        'va_number',
        'bank',
        'payment_url',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
