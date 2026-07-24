<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image_url', 'status', 'start_at', 'end_at'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_collection_items', 'collection_id', 'product_id')
            ->withPivot('sort_order');
    }
}
