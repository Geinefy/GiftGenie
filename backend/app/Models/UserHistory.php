<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'user_history';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'query',
        'ai_response',
        'fetched_items',
        'session_id',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'ai_response' => 'array',
        'fetched_items' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get user history by session ID for anonymous users
     */
    public static function getBySession($sessionId, $limit = 10)
    {
        return self::where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get user history by user ID for authenticated users
     */
    public static function getByUser($userId, $limit = 10)
    {
        return self::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
