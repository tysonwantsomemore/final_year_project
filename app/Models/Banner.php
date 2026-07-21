<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'image_url', 'link_url', 'season',
        'start_date', 'end_date', 'sort_order', 'is_active'
    ];
}
