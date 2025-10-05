<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GiftController extends Controller
{
    private $aiPartBaseUrl;

    public function __construct()
    {
        // AI-Part service URL - make this configurable
        $this->aiPartBaseUrl = env('AI_PART_URL', 'http://localhost:5001');
    }

    /**
     * Start a new chat conversation
     */
    public function startChat(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string',
            'user_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Generate session ID if not provided
            $sessionId = $request->session_id ?: Str::uuid()->toString();

            // Call AI-Part service
            $response = Http::timeout(60)->post("{$this->aiPartBaseUrl}/api/chat", [
                'message' => $request->message,
                'session_id' => $sessionId
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI service unavailable'
                ], 503);
            }

            $aiResponse = $response->json();

            // Store in history
            $history = UserHistory::create([
                'user_id' => $request->user_id,
                'session_id' => $sessionId,
                'query' => $request->message,
                'ai_response' => $aiResponse,
                'fetched_items' => [], // Will be populated when products are fetched
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'session_id' => $sessionId,
                    'history_id' => $history->id,
                    'response' => $aiResponse['response'] ?? '',
                    'questions' => $aiResponse['questions'] ?? [],
                    'timestamp' => $history->created_at->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Search for gift products
     */
    public function searchProducts(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|max:500',
            'session_id' => 'required|string',
            'history_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Check if we have cached results for this query
            $cachedHistory = UserHistory::where('session_id', $request->session_id)
                ->where('query', $request->query)
                ->whereNotNull('fetched_items')
                ->whereJsonLength('fetched_items', '>', 0)
                ->first();

            if ($cachedHistory) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'products' => $cachedHistory->fetched_items,
                        'cached' => true,
                        'timestamp' => $cachedHistory->created_at->toISOString()
                    ]
                ]);
            }

            // Call AI-Part service for product search
            $response = Http::timeout(60)->post("{$this->aiPartBaseUrl}/api/search-products", [
                'query' => $request->query,
                'max_results' => $request->max_results ?? 6
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product search service unavailable'
                ], 503);
            }

            $products = $response->json()['products'] ?? [];

            // Update history with fetched items
            if ($request->history_id) {
                $history = UserHistory::find($request->history_id);
                if ($history) {
                    $history->update(['fetched_items' => $products]);
                }
            } else {
                // Create new history entry
                UserHistory::create([
                    'session_id' => $request->session_id,
                    'query' => $request->query,
                    'ai_response' => ['type' => 'product_search'],
                    'fetched_items' => $products,
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $products,
                    'cached' => false,
                    'timestamp' => now()->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get user/session history
     */
    public function getHistory(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required_without:user_id|string',
            'user_id' => 'required_without:session_id|string',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $limit = $request->limit ?? 10;

            if ($request->user_id) {
                $history = UserHistory::getByUser($request->user_id, $limit);
            } else {
                $history = UserHistory::getBySession($request->session_id, $limit);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'history' => $history->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'query' => $item->query,
                            'ai_response' => $item->ai_response,
                            'fetched_items' => $item->fetched_items,
                            'timestamp' => $item->created_at->toISOString()
                        ];
                    })
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Health check for AI service
     */
    public function healthCheck(): JsonResponse
    {
        try {
            $response = Http::timeout(5)->get("{$this->aiPartBaseUrl}/api/health");
            
            return response()->json([
                'success' => true,
                'ai_service' => [
                    'status' => $response->successful() ? 'online' : 'offline',
                    'response_time' => $response->transferStats->getTransferTime() ?? 0
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'ai_service' => [
                    'status' => 'offline',
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }
}
