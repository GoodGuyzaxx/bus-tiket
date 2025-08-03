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

    // Accessor untuk format amount
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        switch ($this->transaction_status) {
            case 'settlement':
            case 'capture':
                return '<span class="badge bg-success">' . $this->transaction_status . '</span>';
            case 'pending':
                return '<span class="badge bg-warning">' . $this->transaction_status . '</span>';
            case 'deny':
            case 'cancel':
            case 'expire':
            case 'failure':
                return '<span class="badge bg-danger">' . $this->transaction_status . '</span>';
            default:
                return '<span class="badge bg-secondary">' . $this->transaction_status . '</span>';
        }
    }

    // Scope untuk filter successful payments
    public function scopeSuccessful($query)
    {
        return $query->whereIn('transaction_status', ['settlement', 'capture']);
    }

    // Scope untuk filter pending payments
    public function scopePending($query)
    {
        return $query->where('transaction_status', 'pending');
    }

    // Scope untuk filter failed payments
    public function scopeFailed($query)
    {
        return $query->whereIn('transaction_status', ['deny', 'cancel', 'expire', 'failure']);
    }

    // Scope untuk filter by date range
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Scope untuk filter by payment type
    public function scopePaymentType($query, $paymentType)
    {
        return $query->where('payment_type', $paymentType);
    }

    // Scope untuk filter by bank
    public function scopeBank($query, $bank)
    {
        return $query->where('bank', $bank);
    }

}
