<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\SearchHistory;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class GiftSuggestionController extends Controller
{
    public function getSuggestions(Request $request)
    {
        $request->validate([
            'occasion' => 'required|string',
            'recipient' => 'nullable|string',
            'min_budget' => 'nullable|numeric|min:0',
            'max_budget' => 'nullable|numeric|min:0',
            'country' => 'nullable|string'
        ]);

        $query = Gift::query();

        // Filter by occasion (required)
        $query->where('occasion', $request->occasion);

        // Optional filters
        if ($request->filled('recipient')) {
            $query->where('recipient', $request->recipient);
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Filter by budget range only if both provided
        if ($request->filled('min_budget') && $request->filled('max_budget')) {
            $min = $request->min_budget;
            $max = $request->max_budget;
            $query->where(function ($q) use ($min, $max) {
                $q->where(function ($subQ) use ($min, $max) {
                    // Gift's price range overlaps with user's budget
                    $subQ->where('min_price', '<=', $max)
                         ->where('max_price', '>=', $min);
                });
            });
        }

        $suggestions = $query->limit(12)->get();

    // Store search in session or DB for history (include prompt)
    $this->storeSearchHistory($request);

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions,
            'count' => $suggestions->count()
        ]);
    }

    public function getSearchHistory(Request $request)
    {
        if (Auth::check()) {
            $histories = SearchHistory::where('user_id', Auth::id())->latest()->limit(10)->get();
            return response()->json(['history' => $histories]);
        }

        $history = session('gift_search_history', []);
        return response()->json(['history' => array_reverse($history)]);
    }

    public function clearHistory(Request $request)
    {
        if (Auth::check()) {
            SearchHistory::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('gift_search_history');
        }
        return response()->json(['success' => true]);
    }

    public function addToFavorites(Request $request)
    {
        $request->validate([
            'gift_id' => 'required|exists:gifts,id'
        ]);
        if (Auth::check()) {
            Favorite::firstOrCreate([
                'user_id' => Auth::id(),
                'gift_id' => $request->gift_id
            ], [
                'note' => $request->note ?? null
            ]);
        } else {
            $favorites = session('gift_favorites', []);
            if (!in_array($request->gift_id, $favorites)) {
                $favorites[] = $request->gift_id;
                session(['gift_favorites' => $favorites]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function removeFromFavorites(Request $request)
    {
        $request->validate([
            'gift_id' => 'required|integer'
        ]);
        if (Auth::check()) {
            Favorite::where('user_id', Auth::id())->where('gift_id', $request->gift_id)->delete();
        } else {
            $favorites = session('gift_favorites', []);
            $favorites = array_filter($favorites, fn($id) => $id != $request->gift_id);
            session(['gift_favorites' => array_values($favorites)]);
        }

        return response()->json(['success' => true]);
    }

    public function getFavorites(Request $request)
    {
        if (Auth::check()) {
            $favorites = Favorite::with('gift')->where('user_id', Auth::id())->get()->map(fn($f) => $f->gift);
            return response()->json(['favorites' => $favorites]);
        }

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
        $data = [
            'recipient' => $request->recipient,
            'occasion' => $request->occasion,
            'min_budget' => $request->min_budget,
            'max_budget' => $request->max_budget,
            'country' => $request->country,
            'prompt' => $request->prompt ?? null,
        ];

        if (Auth::check()) {
            // Persist to DB
            SearchHistory::create(array_merge($data, ['user_id' => Auth::id()]));
            // Trim to last 10
            $idsToKeep = SearchHistory::where('user_id', Auth::id())->latest()->limit(10)->pluck('id');
            SearchHistory::where('user_id', Auth::id())->whereNotIn('id', $idsToKeep)->delete();
        } else {
            $history = session('gift_search_history', []);
            $searchData = array_merge($data, ['timestamp' => now()->toDateTimeString()]);

            // Add to beginning of array
            array_unshift($history, $searchData);

            // Keep only last 10 searches
            $history = array_slice($history, 0, 10);

            session(['gift_search_history' => $history]);
        }
    }
}
