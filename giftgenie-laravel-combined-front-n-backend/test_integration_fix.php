<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\ChatSession;
use App\Models\AiGeneratedGift;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Test database integration for AI generated gifts

echo "Testing AI Gift Integration...\n";

try {
    // Create a test user (or use existing)
    $user = User::first();
    if (!$user) {
        echo "No users found. Please create a user first.\n";
        exit(1);
    }

    echo "Using user: {$user->name} (ID: {$user->id})\n";

    // Create test chat session
    $chatSession = ChatSession::create([
        'user_id' => $user->id,
        'session_uuid' => 'test-' . uniqid(),
        'initial_prompt' => 'Test prompt for integration',
        'context' => ['test' => true],
        'status' => 'completed'
    ]);

    echo "Created chat session: {$chatSession->session_uuid}\n";

    // Test AI-like product structure (mimicking the API response)
    $testProducts = [
        'electronics' => [
            [
                'name' => 'Test Wireless Headphones',
                'price' => '89.99',
                'description' => 'High-quality wireless headphones for testing',
                'image_url' => 'https://example.com/image1.jpg',
                'product_url' => 'https://example.com/product1',
                'source' => 'test_api',
                'rating' => 4.5,
                'reviews' => 120
            ]
        ],
        'lifestyle' => [
            [
                'name' => 'Test Essential Oil Diffuser',
                'price' => '$45.99',
                'description' => 'Aromatherapy diffuser for relaxation',
                'image_url' => 'https://example.com/image2.jpg',
                'product_url' => 'https://example.com/product2',
                'source' => 'test_api',
                'rating' => 4.7,
                'reviews' => 85
            ]
        ]
    ];

    // Process products like the controller does
    $productsToSave = [];
    foreach ($testProducts as $categoryName => $categoryProducts) {
        if (is_array($categoryProducts)) {
            foreach ($categoryProducts as $product) {
                if (is_array($product) && isset($product['name'])) {
                    $product['category'] = $categoryName;
                    $productsToSave[] = $product;
                }
            }
        }
    }

    echo "Products to save: " . count($productsToSave) . "\n";

    // Create gifts in database
    $gifts = [];
    foreach ($productsToSave as $product) {
        // Extract price like the controller does
        $price = preg_replace('/[^0-9.]/', '', $product['price']);
        $price = (float) $price ?: 0;

        $gift = AiGeneratedGift::create([
            'chat_session_id' => $chatSession->id,
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $price,
            'image_url' => $product['image_url'],
            'product_url' => $product['product_url'],
            'source' => $product['source'],
            'metadata' => [
                'category' => $product['category'],
                'rating' => $product['rating'] ?? null,
                'reviews' => $product['reviews'] ?? null,
            ]
        ]);

        $gifts[] = $gift;
        echo "Created gift: {$gift->name} - \${$gift->price}\n";
    }

    // Verify retrieval
    $retrievedGifts = $chatSession->aiGeneratedGifts;
    echo "Retrieved {$retrievedGifts->count()} gifts from database\n";

    foreach ($retrievedGifts as $gift) {
        echo "- {$gift->name}: \${$gift->price} (Category: {$gift->metadata['category']})\n";
    }

    // Test favorite functionality
    $firstGift = $retrievedGifts->first();
    if ($firstGift) {
        $firstGift->toggleFavorite();
        echo "Toggled favorite for: {$firstGift->name} - Favorited: " . ($firstGift->is_favorited ? 'Yes' : 'No') . "\n";
    }

    echo "\n✅ Integration test completed successfully!\n";
    echo "Database structure is working correctly with AI API response format.\n";

} catch (Exception $e) {
    echo "\n❌ Test failed with error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}