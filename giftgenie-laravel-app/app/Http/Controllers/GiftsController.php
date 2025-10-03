<?php

namespace App\Http\Controllers;

use App\Models\Gift;

class GiftsController extends Controller
{
    public function index()
    {
        // Get gifts from database, fallback to mock data if empty
        $gifts = Gift::all();
        
        if ($gifts->isEmpty()) {
            // Mock data as fallback
            $gifts = collect([
                [
                    'id' => '1',
                    'name' => 'Wireless Noise-Cancelling Headphones',
                    'price' => 299.99,
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                    'product_url' => '#',
                    'description' => 'Premium audio quality with active noise cancellation'
                ],
                [
                    'id' => '2',
                    'name' => 'Smartwatch Fitness Tracker',
                    'price' => 249.99,
                    'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                    'product_url' => '#',
                    'description' => 'Track your health and stay connected'
                ],
                [
                    'id' => '3',
                    'name' => 'Artisan Coffee Gift Set',
                    'price' => 49.99,
                    'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=500',
                    'product_url' => '#',
                    'description' => 'Curated selection of world-class beans'
                ],
                [
                    'id' => '4',
                    'name' => 'Leather Messenger Bag',
                    'price' => 189.99,
                    'image_url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=500',
                    'product_url' => '#',
                    'description' => 'Handcrafted genuine leather bag'
                ],
                [
                    'id' => '5',
                    'name' => 'Portable Bluetooth Speaker',
                    'price' => 129.99,
                    'image_url' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500',
                    'product_url' => '#',
                    'description' => 'Crystal clear sound, anywhere you go'
                ],
                [
                    'id' => '6',
                    'name' => 'Gourmet Chocolate Box',
                    'price' => 39.99,
                    'image_url' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=500',
                    'product_url' => '#',
                    'description' => 'Premium handcrafted chocolates'
                ],
            ]);
        }

        return view('gifts', compact('gifts'));
    }
}
