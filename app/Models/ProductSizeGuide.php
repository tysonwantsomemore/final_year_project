<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSizeGuide extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'size_id',
        'shoulder_cm',
        'chest_cm',
        'shirt_length_cm',
        'sleeve_length_cm',
        'height_min',
        'height_max',
        'weight_min',
        'weight_max'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
