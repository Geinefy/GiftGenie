<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'product_url',
        'category',
        'tags'
    ];

    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:2'
    ];
}
