<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Api\GiftController;
use Carbon\Carbon;

// Health check
Route::get('/ping', fn() => response()->json([
    'ok' => true,
    'time' => Carbon::now('Asia/Dhaka')->toDateTimeString(),
], 200));

// Legacy routes (keep for backward compatibility)
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);

// Gift API Routes - Robust and loosely coupled
Route::prefix('v1/gifts')->group(function () {
    // Core gift functionality
    Route::post('/chat', [GiftController::class, 'startChat']);
    Route::post('/search', [GiftController::class, 'searchProducts']);
    Route::get('/history', [GiftController::class, 'getHistory']);
    
    // System health
    Route::get('/health', [GiftController::class, 'healthCheck']);
});

