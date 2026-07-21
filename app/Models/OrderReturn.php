<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'order_id',
        'user_id',
        'return_code',
        'reason',
        'status',
        'admin_note',
        'requested_at',
        'approved_at',
        'resolved_at',
        'cancelled_at'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'resolved_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ReturnItem::class, 'return_id');
    }

    public function refund()
    {
        return $this->hasOne(Refund::class, 'return_id');
    }
}
