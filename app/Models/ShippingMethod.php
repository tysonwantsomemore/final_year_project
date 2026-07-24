<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = ['code', 'name', 'fee', 'estimated_days', 'status'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
