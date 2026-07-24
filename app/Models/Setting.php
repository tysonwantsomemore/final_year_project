<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['setting_key', 'setting_value', 'data_type', 'is_public'];

    protected $casts = [
        'is_public' => 'boolean'
    ];
}
