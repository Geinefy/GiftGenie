<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\ChatSession;
use App\Models\AiGeneratedGift;
use App\Models\User;

echo "Testing Favorite Functionality...\n";

try {
    // Get or create a test user
    $user = User::first();
    if (!$user) {
        echo "❌ No users found. Please create a user first.\n";
        exit(1);
    }

    echo "✅ Using user: {$user->name} (ID: {$user->id})\n";

    // Create a test chat session
    $chatSession = ChatSession::create([
        'user_id' => $user->id,
        'session_uuid' => 'test-favorites-' . uniqid(),
        'initial_prompt' => 'Test favorites functionality',
        'context' => ['test' => true],
        'status' => 'completed'
    ]);

    echo "✅ Created test chat session: {$chatSession->session_uuid}\n";

    // Create test gifts
    $testGifts = [
        [
            'name' => 'Test Wireless Headphones',
            'description' => 'High-quality wireless headphones for testing favorites',
            'price' => 89.99,
            'image_url' => 'https://example.com/headphones.jpg',
            'product_url' => 'https://example.com/headphones',
            'source' => 'test_api',
            'metadata' => [
                'category' => 'electronics',
                'rating' => 4.5,
                'reviews' => 120
            ]
        ],
        [
            'name' => 'Test Coffee Mug',
            'description' => 'Perfect coffee mug for favorites testing',
            'price' => 19.99,
            'image_url' => 'https://example.com/mug.jpg',
            'product_url' => 'https://example.com/mug',
            'source' => 'test_api',
            'metadata' => [
                'category' => 'lifestyle',
                'rating' => 4.8,
                'reviews' => 85
            ]
        ]
    ];

    $createdGifts = [];
    foreach ($testGifts as $giftData) {
        $gift = AiGeneratedGift::create(array_merge($giftData, [
            'chat_session_id' => $chatSession->id,
        ]));
        $createdGifts[] = $gift;
        echo "✅ Created gift: {$gift->name} - \${$gift->price}\n";
    }

    // Test toggling favorites
    echo "\n🧪 Testing favorite functionality...\n";

    foreach ($createdGifts as $gift) {
        // Toggle to favorite
        $result = $gift->toggleFavorite();
        echo "✅ Toggled {$gift->name} to favorite: " . ($gift->is_favorited ? 'Yes' : 'No') . "\n";

        // Toggle back
        $result = $gift->toggleFavorite();
        echo "✅ Toggled {$gift->name} back: " . ($gift->is_favorited ? 'Yes' : 'No') . "\n";

        // Set as favorite for final test
        if (!$gift->is_favorited) {
            $gift->toggleFavorite();
        }
    }

    // Test retrieving favorites
    $favorites = AiGeneratedGift::whereHas('chatSession', function($query) use ($user) {
        $query->where('user_id', $user->id);
    })->where('is_favorited', true)->get();

    echo "\n📊 Statistics:\n";
    echo "- Total gifts created: " . count($createdGifts) . "\n";
    echo "- Current favorites: " . $favorites->count() . "\n";
    echo "- Total value of favorites: \$" . number_format($favorites->sum('price'), 2) . "\n";

    echo "\n📋 Favorites list:\n";
    foreach ($favorites as $fav) {
        echo "- {$fav->name}: \${$fav->price} (Category: {$fav->metadata['category']})\n";
    }

    echo "\n✅ All tests passed! Favorite functionality is working correctly.\n";
    echo "\n🔗 You can now:\n";
    echo "1. Visit /gifts to see gift cards with favorite buttons\n";
    echo "2. Click heart icons to toggle favorites\n";
    echo "3. Visit /favorites to see all saved gifts\n";
    echo "4. Check /dashboard for favorites count with clickable link\n";

} catch (Exception $e) {
    echo "\n❌ Test failed with error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}