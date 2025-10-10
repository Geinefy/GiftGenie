<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'min_price',
        'max_price',
        'recipient',
        'occasion',
        'country',
        'category'
    ];

    protected $casts = [
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2'
    ];
}
