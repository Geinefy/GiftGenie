<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'recipient', 'occasion', 'min_budget', 'max_budget', 'country', 'prompt'
    ];
}
