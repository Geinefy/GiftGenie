<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\AiGeneratedGift;
use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftsController extends Controller
{
    public function index(Request $request)
    {
        // Check if we have a session ID from AI search
        $sessionId = $request->get('session');
        
        if ($sessionId) {
            // Get gifts from AI session
            $chatSession = ChatSession::where('session_uuid', $sessionId)->first();
            if ($chatSession) {
                $gifts = $chatSession->aiGeneratedGifts;
                return view('gifts', compact('gifts'));
            }
        }
        
        // Get recent AI generated gifts for the user, or fallback to static gifts
        $gifts = collect();
        
        if (Auth::check()) {
            $gifts = AiGeneratedGift::whereHas('chatSession', function($query) {
                $query->where('user_id', Auth::id());
            })->orderBy('created_at', 'desc')->limit(20)->get();
        }
        
        // Fallback to static gifts if no AI gifts found
        if ($gifts->isEmpty()) {
            $gifts = Gift::all();
            
            if ($gifts->isEmpty()) {
                // Mock data as fallback
                $gifts = collect([
                    (object)[
                        'id' => '1',
                        'name' => 'Wireless Noise-Cancelling Headphones',
                        'price' => 299.99,
                        'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                        'product_url' => '#',
                        'description' => 'Premium audio quality with active noise cancellation'
                    ],
                    (object)[
                    'id' => '2',
                    'name' => 'Smartwatch Fitness Tracker',
                    'price' => 249.99,
                    'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                    'product_url' => '#',
                    'description' => 'Track your health and stay connected'
                ],
                    (object)[
                    'id' => '3',
                    'name' => 'Artisan Coffee Gift Set',
                    'price' => 49.99,
                    'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=500',
                    'product_url' => '#',
                    'description' => 'Curated selection of world-class beans'
                ],
                    (object)[
                    'id' => '4',
                    'name' => 'Leather Messenger Bag',
                    'price' => 189.99,
                    'image_url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=500',
                    'product_url' => '#',
                    'description' => 'Handcrafted genuine leather bag'
                ],
                    (object)[
                    'id' => '5',
                    'name' => 'Portable Bluetooth Speaker',
                    'price' => 129.99,
                    'image_url' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500',
                    'product_url' => '#',
                    'description' => 'Crystal clear sound, anywhere you go'
                ],
                    (object)[
                    'id' => '6',
                    'name' => 'Gourmet Chocolate Box',
                    'price' => 39.99,
                    'image_url' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=500',
                    'product_url' => '#',
                    'description' => 'Premium handcrafted chocolates'
                ],
            ]);
            }
        }

        return view('gifts', compact('gifts'));
    }
}
