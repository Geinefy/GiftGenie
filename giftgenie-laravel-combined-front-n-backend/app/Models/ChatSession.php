<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    protected $fillable = [
        'user_id',
        'session_uuid',
        'initial_prompt',
        'context',
        'ai_response',
        'gifts_found',
        'total_budget_shown',
        'status'
    ];

    protected $casts = [
        'context' => 'array',
        'ai_response' => 'array',
        'gifts_found' => 'integer',
        'total_budget_shown' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function aiGeneratedGifts(): HasMany
    {
        return $this->hasMany(AiGeneratedGift::class);
    }

    public function searchHistories(): HasMany
    {
        return $this->hasMany(SearchHistory::class, 'session_uuid', 'session_uuid');
    }
}
