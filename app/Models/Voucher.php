<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount_percent',
        'max_discount_amount',
        'min_order_value',
        'start_date',
        'end_date',
        'usage_limit'
    ];
}
