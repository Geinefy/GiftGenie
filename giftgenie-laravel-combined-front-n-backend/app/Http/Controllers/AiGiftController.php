<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\ChatSession;
use App\Models\AiGeneratedGift;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Auth;

class AiGiftController extends Controller
{
    private $aiServiceUrl = 'http://localhost:5001'; // AI-Part service URL

    public function searchGifts(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
            'budget' => 'nullable|string',
            'occasion' => 'nullable|string',
            'relationship' => 'nullable|string',
            'age' => 'nullable|string',
            'gender' => 'nullable|string',
            'interests' => 'nullable|string',
        ]);

        try {
            // Set PHP execution time limit to 180 seconds (3 minutes)
            set_time_limit(180);

            // Generate session UUID
            $sessionUuid = Str::uuid()->toString();

            // Build enhanced prompt
            $enhancedPrompt = $this->buildEnhancedPrompt($request->all());

            // Create chat session
            $chatSession = ChatSession::create([
                'user_id' => Auth::id(),
                'session_uuid' => $sessionUuid,
                'initial_prompt' => $request->prompt,
                'context' => $request->except(['_token', 'prompt']),
                'status' => 'processing_ai'
            ]);

            // Call AI service for chat with increased timeout
            try {
                $aiResponse = Http::timeout(120)->post("{$this->aiServiceUrl}/api/chat", [
                    'message' => $enhancedPrompt,
                    'session_id' => $sessionUuid
                ]);

                if (!$aiResponse->successful()) {
                    throw new \Exception('AI service returned error');
                }

                $aiData = $aiResponse->json();
            } catch (\Exception $e) {
                // Fallback to mock AI response when service is unavailable
                Log::warning('AI service unavailable, using mock response: ' . $e->getMessage());

                $aiData = [
                    'response' => "I'd be happy to help you find the perfect gifts! Based on your preferences, here are some personalized recommendations:",
                    'recommendations' => [
                        'electronics' => 'gadgets tech accessories',
                        'lifestyle' => 'home decor wellness fitness',
                        'books' => 'books reading accessories',
                        'fashion' => 'clothing accessories jewelry',
                    ]
                ];
            }

            // Update chat session with AI response
            $chatSession->update([
                'ai_response' => $aiData,
                'status' => 'searching_products'
            ]);

            // Search for products
            $gifts = [];
            $totalBudget = 0;

            try {
                $productsResponse = Http::timeout(120)->post("{$this->aiServiceUrl}/api/search-products", [
                    'recommendations' => $aiData['recommendations'] ?? [],
                ]);

                if ($productsResponse->successful()) {
                    $productsData = $productsResponse->json();
                    $products = $productsData['products'] ?? [];
                } else {
                    throw new \Exception('Products service returned error');
                }
            } catch (\Exception $e) {
                Log::warning('Products service unavailable, using mock data: ' . $e->getMessage());

                // Generate more relevant mock data based on AI recommendations
                $mockProducts = [];
                if (isset($aiData['recommendations']) && is_array($aiData['recommendations'])) {
                    foreach ($aiData['recommendations'] as $category => $keywords) {
                        $mockProducts[$category] = [
                            [
                                'name' => 'Sample ' . ucfirst(str_replace('_', ' ', $category)) . ' Item',
                                'price' => rand(20, 200) + 0.99,
                                'description' => 'AI-recommended ' . $keywords . ' - sample product while service is unavailable',
                                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                                'product_url' => '#',
                                'rating' => 4.0 + (rand(0, 10) / 10),
                                'reviews' => rand(50, 500),
                                'source' => 'mock_fallback'
                            ]
                        ];
                    }
                } else {
                    // Default fallback
                    $mockProducts = [
                        'general_gifts' => [
                            [
                                'name' => 'Gift Card',
                                'price' => 50.00,
                                'description' => 'Universal gift card - perfect when you\'re unsure',
                                'image_url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=500',
                                'product_url' => '#',
                                'rating' => 4.5,
                                'reviews' => 100,
                                'source' => 'mock_fallback'
                            ]
                        ]
                    ];
                }
                $products = $mockProducts;
            }

            if (isset($products) && $products) {

                // Update status to saving products
                $chatSession->update(['status' => 'saving_products']);

                // Save products to database - handle categorized structure from AI API
                $productsToSave = [];

                if (is_array($products)) {
                    // Handle categorized structure: {"electronics": [product1, product2], "lifestyle": [product3]}
                    foreach ($products as $categoryName => $categoryProducts) {
                        if (is_array($categoryProducts)) {
                            // It's a category with products array
                            foreach ($categoryProducts as $product) {
                                if (is_array($product) && isset($product['name'])) {
                                    // Add category info to product
                                    $product['category'] = $categoryName;
                                    $productsToSave[] = $product;
                                }
                            }
                        } else if (is_array($categoryProducts) && isset($categoryProducts['name'])) {
                            // It's a single product (shouldn't happen with current structure but handle anyway)
                            $categoryProducts['category'] = $categoryName;
                            $productsToSave[] = $categoryProducts;
                        }
                    }
                }

                Log::info('Products to save:', ['count' => count($productsToSave), 'structure' => array_keys($products)]);

                foreach ($productsToSave as $product) {
                    $price = $this->extractPrice($product['price'] ?? '0');
                    $totalBudget += $price;

                    Log::info('Creating gift:', [
                        'name' => $product['name'] ?? 'Unknown',
                        'price' => $price,
                        'category' => $product['category'] ?? 'unknown'
                    ]);

                    $gift = AiGeneratedGift::create([
                        'chat_session_id' => $chatSession->id,
                        'name' => $product['name'] ?? 'Unknown Gift',
                        'description' => $product['description'] ?? '',
                        'price' => $price,
                        'image_url' => $product['image_url'] ?? $product['image'] ?? '',
                        'product_url' => $product['product_url'] ?? $product['url'] ?? '#',
                        'source' => $product['source'] ?? 'AI_API',
                        'metadata' => [
                            'category' => $product['category'] ?? 'unknown',
                            'rating' => $product['rating'] ?? null,
                            'reviews' => $product['reviews'] ?? null,
                            'shipping' => $product['shipping'] ?? null,
                        ]
                    ]);

                    $gifts[] = $gift;
                }

                // Update session with results
                $chatSession->update([
                    'gifts_found' => count($gifts),
                    'total_budget_shown' => $totalBudget,
                    'status' => 'completed'
                ]);
            }

            // Save search history
            SearchHistory::create([
                'user_id' => Auth::id(),
                'session_uuid' => $sessionUuid,
                'prompt' => $request->prompt,
                'recipient' => $request->relationship ?? null,
                'occasion' => $request->occasion ?? null,
                'min_budget' => $this->extractMinBudget($request->budget),
                'max_budget' => $this->extractMaxBudget($request->budget),
                'results_count' => count($gifts),
            ]);

            return redirect()->route('found.gifts', ['session' => $sessionUuid]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to get gift suggestions: ' . $e->getMessage()]);
        }
    }

    public function showFoundGifts(Request $request)
    {
        $sessionId = $request->get('session');

        if (!$sessionId) {
            return redirect()->route('gifts')->with('error', 'No search session found.');
        }

        // Get the chat session
        $chatSession = ChatSession::where('session_uuid', $sessionId)->first();

        if (!$chatSession) {
            return redirect()->route('gifts')->with('error', 'Search session not found.');
        }

        // Get gifts from this session
        $gifts = $chatSession->aiGeneratedGifts;

        // Calculate total budget
        $totalBudget = $gifts->sum('price');
        $totalFound = $gifts->count();

        return view('found-gifts', [
            'gifts' => $gifts,
            'sessionId' => $sessionId,
            'aiResponse' => $chatSession->ai_response,
            'totalFound' => $totalFound,
            'totalBudget' => $totalBudget,
            'chatSession' => $chatSession
        ]);
    }

    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'gift_id' => 'required|exists:ai_generated_gifts,id'
        ]);

        try {
            $gift = AiGeneratedGift::findOrFail($request->gift_id);
            $gift->toggleFavorite();

            return response()->json([
                'success' => true,
                'is_favorited' => $gift->is_favorited,
                'message' => $gift->is_favorited ? 'Added to favorites' : 'Removed from favorites'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle favorite'
            ], 500);
        }
    }

    public function getDashboardStats()
    {
        $userId = Auth::id();

        $stats = [
            'gifts_found' => ChatSession::where('user_id', $userId)->sum('gifts_found'),
            'saved_items' => AiGeneratedGift::whereHas('chatSession', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('is_favorited', true)->count(),
            'chat_sessions' => ChatSession::where('user_id', $userId)->count(),
            'budget_saved' => ChatSession::where('user_id', $userId)->sum('total_budget_shown')
        ];

        // Get recent sessions for display
        $recentSessions = ChatSession::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent favorited gifts
        $recentFavorites = AiGeneratedGift::whereHas('chatSession', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('is_favorited', true)
            ->orderBy('updated_at', 'desc')
            ->limit(6)
            ->get();

        return view('dashboard', compact('stats', 'recentSessions', 'recentFavorites'));
    }

    public function getRecentSearches()
    {
        return SearchHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function getFavoriteGifts()
    {
        return AiGeneratedGift::whereHas('chatSession', function($query) {
            $query->where('user_id', Auth::id());
        })->where('is_favorited', true)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    private function buildEnhancedPrompt(array $data)
    {
        $prompt = $data['prompt'];

        if (!empty($data['budget'])) $prompt .= " Budget: {$data['budget']}.";
        if (!empty($data['occasion'])) $prompt .= " Occasion: {$data['occasion']}.";
        if (!empty($data['relationship'])) $prompt .= " Relationship: {$data['relationship']}.";
        if (!empty($data['age'])) $prompt .= " Age: {$data['age']}.";
        if (!empty($data['gender'])) $prompt .= " Gender: {$data['gender']}.";
        if (!empty($data['interests'])) $prompt .= " Interests: {$data['interests']}.";

        return $prompt;
    }

    private function extractPrice($priceString)
    {
        $price = preg_replace('/[^0-9.]/', '', $priceString);
        return (float) $price ?: 0;
    }

    private function extractMinBudget($budgetString)
    {
        if (empty($budgetString)) return null;

        if (strpos($budgetString, '-') !== false) {
            $parts = explode('-', $budgetString);
            return (float) $parts[0];
        }

        return null;
    }

    private function extractMaxBudget($budgetString)
    {
        if (empty($budgetString)) return null;

        if (strpos($budgetString, '-') !== false) {
            $parts = explode('-', $budgetString);
            return (float) ($parts[1] ?? $parts[0]);
        }

        if (strpos($budgetString, '+') !== false) {
            return 999999; // Represent unlimited budget
        }

        return null;
    }
}
