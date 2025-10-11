<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\ChatSession;
use App\Models\AiGeneratedGift;
use Illuminate\Support\Facades\Auth;

echo "Creating sample data for dashboard testing...\n";

// Find or create a test user
$user = User::where('email', 'test@example.com')->first();
if (!$user) {
    echo "Please create a test user first by registering at the application.\n";
    exit(1);
}

echo "Found user: {$user->name} ({$user->email})\n";

// Create sample chat sessions
echo "Creating sample chat sessions...\n";

$session1 = ChatSession::create([
    'user_id' => $user->id,
    'session_uuid' => \Illuminate\Support\Str::uuid()->toString(),
    'initial_prompt' => 'Birthday gift for my mom who loves gardening, budget $50',
    'context' => json_encode(['budget' => 50, 'occasion' => 'birthday', 'relationship' => 'mother']),
    'ai_response' => json_encode(['response' => 'Great gift ideas for gardening enthusiasts!']),
    'gifts_found' => 6,
    'total_budget_shown' => 300,
    'status' => 'completed'
]);

$session2 = ChatSession::create([
    'user_id' => $user->id,
    'session_uuid' => \Illuminate\Support\Str::uuid()->toString(),
    'initial_prompt' => 'Anniversary gift for my wife, budget $100',
    'context' => json_encode(['budget' => 100, 'occasion' => 'anniversary', 'relationship' => 'wife']),
    'ai_response' => json_encode(['response' => 'Romantic anniversary gift suggestions!']),
    'gifts_found' => 8,
    'total_budget_shown' => 500,
    'status' => 'completed'
]);

echo "Created chat sessions.\n";

// Create sample AI generated gifts
echo "Creating sample AI generated gifts...\n";

$gifts = [
    [
        'name' => 'Herb Garden Starter Kit',
        'description' => 'Complete kit with seeds, pots, and soil for starting herbs',
        'price' => 29.99,
        'image_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500',
        'product_url' => '#',
        'source' => 'amazon',
        'is_favorited' => true,
    ],
    [
        'name' => 'Premium Garden Tool Set',
        'description' => 'High-quality stainless steel gardening tools',
        'price' => 45.99,
        'image_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500',
        'product_url' => '#',
        'source' => 'amazon',
        'is_favorited' => false,
    ],
    [
        'name' => 'Romantic Dinner Candle Set',
        'description' => 'Elegant scented candles for romantic evenings',
        'price' => 24.99,
        'image_url' => 'https://images.unsplash.com/photo-1602874801006-52e635f5cd64?w=500',
        'product_url' => '#',
        'source' => 'amazon',
        'is_favorited' => true,
    ],
    [
        'name' => 'Jewelry Box with Mirror',
        'description' => 'Beautiful wooden jewelry box with velvet interior',
        'price' => 79.99,
        'image_url' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=500',
        'product_url' => '#',
        'source' => 'amazon',
        'is_favorited' => true,
    ]
];

foreach ($gifts as $index => $giftData) {
    $sessionId = $index < 2 ? $session1->id : $session2->id;
    
    AiGeneratedGift::create(array_merge($giftData, [
        'chat_session_id' => $sessionId,
        'metadata' => json_encode(['rating' => 4.5, 'reviews' => rand(100, 1000)])
    ]));
}

echo "Created AI generated gifts.\n";

echo "Sample data created successfully!\n";
echo "Now visit http://127.0.0.1:8000/dashboard to see the data.\n";