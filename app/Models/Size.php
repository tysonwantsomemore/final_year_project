<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['name', 'sort_order', 'status'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
