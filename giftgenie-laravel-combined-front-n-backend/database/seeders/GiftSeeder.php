<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gifts = [
            // Electronics for Friends
            [
                'name' => 'Wireless Noise-Cancelling Headphones',
                'description' => 'Premium audio quality with active noise cancellation, perfect for music lovers',
                'min_price' => 250.00,
                'max_price' => 350.00,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                'category' => 'Electronics',
                'recipient' => 'friend',
                'occasion' => 'birthday',
                'country' => 'USA'
            ],
            [
                'name' => 'Smartwatch Fitness Tracker',
                'description' => 'Track health metrics and stay connected on the go',
                'min_price' => 200.00,
                'max_price' => 300.00,
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                'category' => 'Electronics',
                'recipient' => 'friend',
                'occasion' => 'graduation',
                'country' => 'Canada'
            ],
            
            // Gifts for Mother
            [
                'name' => 'Luxury Silk Scarf',
                'description' => 'Elegant handcrafted silk scarf with beautiful patterns',
                'min_price' => 80.00,
                'max_price' => 150.00,
                'image_url' => 'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=500',
                'category' => 'Fashion',
                'recipient' => 'mother',
                'occasion' => 'birthday',
                'country' => 'UK'
            ],
            [
                'name' => 'Artisan Tea Collection',
                'description' => 'Curated selection of premium teas from around the world',
                'min_price' => 40.00,
                'max_price' => 80.00,
                'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=500',
                'category' => 'Food & Drink',
                'recipient' => 'mother',
                'occasion' => 'mothers day',
                'country' => 'India'
            ],
            
            // Professional/Colleague Gifts
            [
                'name' => 'Leather Portfolio Bag',
                'description' => 'Professional leather bag perfect for business meetings',
                'min_price' => 150.00,
                'max_price' => 250.00,
                'image_url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=500',
                'category' => 'Professional',
                'recipient' => 'colleague',
                'occasion' => 'promotion',
                'country' => 'Australia'
            ],
            [
                'name' => 'Premium Pen Set',
                'description' => 'Elegant fountain pen set in luxury gift box',
                'min_price' => 60.00,
                'max_price' => 120.00,
                'image_url' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=500',
                'category' => 'Professional',
                'recipient' => 'colleague',
                'occasion' => 'work anniversary',
                'country' => 'Bangladesh'
            ],
            
            // Wedding Gifts
            [
                'name' => 'Crystal Wine Decanter Set',
                'description' => 'Elegant crystal decanter with matching glasses',
                'min_price' => 100.00,
                'max_price' => 200.00,
                'image_url' => 'https://images.unsplash.com/photo-1569529465841-dfecdab7503b?w=500',
                'category' => 'Home & Garden',
                'recipient' => 'couple',
                'occasion' => 'wedding',
                'country' => 'USA'
            ],
            [
                'name' => 'Bamboo Cutting Board Set',
                'description' => 'Sustainable bamboo cutting boards with serving accessories',
                'min_price' => 50.00,
                'max_price' => 100.00,
                'image_url' => 'https://images.unsplash.com/photo-1556909114-7b224d2d4877?w=500',
                'category' => 'Home & Garden',
                'recipient' => 'couple',
                'occasion' => 'wedding',
                'country' => 'Canada'
            ],
            
            // Budget-friendly options
            [
                'name' => 'Gourmet Chocolate Box',
                'description' => 'Premium handcrafted chocolates in beautiful packaging',
                'min_price' => 25.00,
                'max_price' => 50.00,
                'image_url' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=500',
                'category' => 'Food & Drink',
                'recipient' => 'friend',
                'occasion' => 'thank you',
                'country' => 'UK'
            ],
            [
                'name' => 'Portable Phone Charger',
                'description' => 'High-capacity power bank with fast charging capability',
                'min_price' => 30.00,
                'max_price' => 60.00,
                'image_url' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500',
                'category' => 'Electronics',
                'recipient' => 'friend',
                'occasion' => 'birthday',
                'country' => 'India'
            ],
            
            // More diverse options
            [
                'name' => 'Yoga Mat & Accessories Set',
                'description' => 'Premium yoga mat with blocks, strap, and carrying bag',
                'min_price' => 70.00,
                'max_price' => 120.00,
                'image_url' => 'https://images.unsplash.com/photo-1506629905607-89d2f8c90a98?w=500',
                'category' => 'Health & Fitness',
                'recipient' => 'friend',
                'occasion' => 'new year',
                'country' => 'Australia'
            ],
            [
                'name' => 'Traditional Handicraft Item',
                'description' => 'Beautiful handcrafted traditional art piece',
                'min_price' => 40.00,
                'max_price' => 80.00,
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500',
                'category' => 'Art & Crafts',
                'recipient' => 'mother',
                'occasion' => 'festival',
                'country' => 'Bangladesh'
            ]
        ];

        foreach ($gifts as $gift) {
            \App\Models\Gift::create($gift);
        }
    }
}
