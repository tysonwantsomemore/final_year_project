<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'material',
        'care_instruction',
        'base_price',
        'sale_price',
        'gender',
        'status',
        'is_featured',
        'published_at'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizeGuides()
    {
        return $this->hasMany(ProductSizeGuide::class);
    }

    public function tags()
    {
        return $this->belongsToMany(ProductTag::class, 'product_tag_items', 'product_id', 'tag_id');
    }

    public function collections()
    {
        return $this->belongsToMany(ProductCollection::class, 'product_collection_items', 'product_id', 'collection_id')
            ->withPivot('sort_order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
