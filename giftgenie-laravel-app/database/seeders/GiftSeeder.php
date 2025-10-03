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
            [
                'name' => 'Wireless Noise-Cancelling Headphones',
                'description' => 'Premium audio quality with active noise cancellation',
                'price' => 299.99,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                'product_url' => '#',
                'category' => 'Electronics',
                'tags' => ['audio', 'wireless', 'premium']
            ],
            [
                'name' => 'Smartwatch Fitness Tracker',
                'description' => 'Track your health and stay connected',
                'price' => 249.99,
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                'product_url' => '#',
                'category' => 'Electronics',
                'tags' => ['fitness', 'smart', 'health']
            ],
            [
                'name' => 'Artisan Coffee Gift Set',
                'description' => 'Curated selection of world-class beans',
                'price' => 49.99,
                'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=500',
                'product_url' => '#',
                'category' => 'Food & Drink',
                'tags' => ['coffee', 'artisan', 'gift set']
            ],
            [
                'name' => 'Leather Messenger Bag',
                'description' => 'Handcrafted genuine leather bag',
                'price' => 189.99,
                'image_url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=500',
                'product_url' => '#',
                'category' => 'Fashion',
                'tags' => ['leather', 'bag', 'professional']
            ],
            [
                'name' => 'Portable Bluetooth Speaker',
                'description' => 'Crystal clear sound, anywhere you go',
                'price' => 129.99,
                'image_url' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500',
                'product_url' => '#',
                'category' => 'Electronics',
                'tags' => ['audio', 'portable', 'bluetooth']
            ],
            [
                'name' => 'Gourmet Chocolate Box',
                'description' => 'Premium handcrafted chocolates',
                'price' => 39.99,
                'image_url' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=500',
                'product_url' => '#',
                'category' => 'Food & Drink',
                'tags' => ['chocolate', 'gourmet', 'sweet']
            ],
        ];

        foreach ($gifts as $gift) {
            \App\Models\Gift::create($gift);
        }
    }
}
