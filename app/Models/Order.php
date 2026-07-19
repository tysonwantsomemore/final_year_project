<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_note',
        'payment_method',
        'payment_status',
        'total_amount',
        'shipping_fee',
        'voucher_id'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
