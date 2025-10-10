<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'gift_id', 'note'
    ];

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }
}
