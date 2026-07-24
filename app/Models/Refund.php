<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'return_id',
        'order_id',
        'payment_transaction_id',
        'amount',
        'method',
        'status',
        'refund_code',
        'refunded_at',
        'created_at'
    ];

    protected $casts = [
        'refunded_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function returnRequest()
    {
        return $this->belongsTo(OrderReturn::class, 'return_id');
    }

    public function transaction()
    {
        return $this->belongsTo(PaymentTransaction::class, 'payment_transaction_id');
    }
}
