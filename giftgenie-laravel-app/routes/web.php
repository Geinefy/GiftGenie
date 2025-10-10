<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GiftsController;
use App\Http\Controllers\GiftSuggestionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gifts', [GiftsController::class, 'index'])->name('gifts');

// Gift Suggestion API routes
Route::post('/api/gift-suggestions', [GiftSuggestionController::class, 'getSuggestions'])->name('api.gift-suggestions');
Route::get('/api/search-history', [GiftSuggestionController::class, 'getSearchHistory'])->name('api.search-history');
Route::delete('/api/search-history', [GiftSuggestionController::class, 'clearHistory'])->name('api.clear-history');
Route::post('/api/favorites', [GiftSuggestionController::class, 'addToFavorites'])->name('api.add-favorite');
Route::delete('/api/favorites/{gift_id}', [GiftSuggestionController::class, 'removeFromFavorites'])->name('api.remove-favorite');
Route::get('/api/favorites', [GiftSuggestionController::class, 'getFavorites'])->name('api.get-favorites');
Route::delete('/api/favorites', [GiftSuggestionController::class, 'clearFavorites'])->name('api.clear-favorites');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';
