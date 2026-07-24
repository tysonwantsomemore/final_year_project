<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    protected $fillable = ['return_id', 'order_item_id', 'quantity', 'reason', 'condition_note'];

    public function returnRequest()
    {
        return $this->belongsTo(OrderReturn::class, 'return_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
