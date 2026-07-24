<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_name_snapshot',
        'sku_snapshot',
        'size_name_snapshot',
        'color_name_snapshot',
        'quantity',
        'price_at_purchase',
        'total_price',
        'created_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function returnItems()
    {
        return $this->hasMany(ReturnItem::class);
    }
}
