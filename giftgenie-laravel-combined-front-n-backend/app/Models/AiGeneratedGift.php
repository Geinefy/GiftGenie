<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiGeneratedGift extends Model
{
    protected $fillable = [
        'chat_session_id',
        'name',
        'description',
        'price',
        'image_url',
        'product_url',
        'source',
        'metadata',
        'is_favorited'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'metadata' => 'array',
        'is_favorited' => 'boolean',
    ];

    public function chatSession(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class);
    }

    public function toggleFavorite(): bool
    {
        $this->is_favorited = !$this->is_favorited;
        return $this->save();
    }
}
