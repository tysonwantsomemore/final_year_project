<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_id',
        'method',
        'amount',
        'transaction_code',
        'status',
        'paid_at',
        'raw_response',
        'created_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
