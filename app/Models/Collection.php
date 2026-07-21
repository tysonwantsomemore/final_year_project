<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'thumbnail_url'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'collection_product');
    }
}
