<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $fillable = ['name', 'slug', 'status'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag_items', 'tag_id', 'product_id');
    }
}
