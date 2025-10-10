<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

use Carbon\Carbon;

Route::get('/ping', fn() => response()->json([
    'ok' => false,
    'time' => Carbon::now('Asia/Dhaka')->toDateTimeString(),
], 200));

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);

