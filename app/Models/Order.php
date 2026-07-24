<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'user_address_id',
        'voucher_id',
        'shipping_method_id',
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address_snapshot',
        'subtotal',
        'discount_amount',
        'shipping_fee',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'note',
        'cancelled_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function voucherUsages()
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function returns()
    {
        return $this->hasMany(OrderReturn::class, 'order_id');
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
