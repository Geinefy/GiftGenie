<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gift;

class GiftSuggestionController extends Controller
{
    public function getSuggestions(Request $request)
    {
        $request->validate([
            'recipient' => 'required|string',
            'occasion' => 'required|string',
            'min_budget' => 'required|numeric|min:0',
            'max_budget' => 'required|numeric|min:0',
            'country' => 'required|string'
        ]);

        $query = Gift::query();

        // Filter by recipient
        $query->where('recipient', $request->recipient);

        // Filter by occasion
        $query->where('occasion', $request->occasion);

        // Filter by country
        $query->where('country', $request->country);

        // Filter by budget range
        $query->where(function ($q) use ($request) {
            $q->where(function ($subQ) use ($request) {
                // Gift's price range overlaps with user's budget
                $subQ->where('min_price', '<=', $request->max_budget)
                     ->where('max_price', '>=', $request->min_budget);
            });
        });

        $suggestions = $query->limit(12)->get();

        // Store search in session for history
        $this->storeSearchHistory($request);

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions,
            'count' => $suggestions->count()
        ]);
    }

    public function getSearchHistory(Request $request)
    {
        $history = session('gift_search_history', []);
        return response()->json(['history' => array_reverse($history)]);
    }

    public function clearHistory(Request $request)
    {
        session()->forget('gift_search_history');
        return response()->json(['success' => true]);
    }

    public function addToFavorites(Request $request)
    {
        $request->validate([
            'gift_id' => 'required|exists:gifts,id'
        ]);

        $favorites = session('gift_favorites', []);
        
        if (!in_array($request->gift_id, $favorites)) {
            $favorites[] = $request->gift_id;
            session(['gift_favorites' => $favorites]);
        }

        return response()->json(['success' => true]);
    }

    public function removeFromFavorites(Request $request)
    {
        $request->validate([
            'gift_id' => 'required|integer'
        ]);

        $favorites = session('gift_favorites', []);
        $favorites = array_filter($favorites, fn($id) => $id != $request->gift_id);
        session(['gift_favorites' => array_values($favorites)]);

        return response()->json(['success' => true]);
    }

    public function getFavorites(Request $request)
    {
        $favoriteIds = session('gift_favorites', []);
        $favorites = Gift::whereIn('id', $favoriteIds)->get();
        
        return response()->json(['favorites' => $favorites]);
    }

    public function clearFavorites(Request $request)
    {
        session()->forget('gift_favorites');
        return response()->json(['success' => true]);
    }

    private function storeSearchHistory(Request $request)
    {
        $history = session('gift_search_history', []);
        
        $searchData = [
            'recipient' => $request->recipient,
            'occasion' => $request->occasion,
            'min_budget' => $request->min_budget,
            'max_budget' => $request->max_budget,
            'country' => $request->country,
            'timestamp' => now()->toDateTimeString()
        ];

        // Add to beginning of array
        array_unshift($history, $searchData);

        // Keep only last 10 searches
        $history = array_slice($history, 0, 10);

        session(['gift_search_history' => $history]);
    }
}
