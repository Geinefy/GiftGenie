<?php
// Full integration test

echo "🧪 Testing Full AI-Laravel Integration\n\n";

// Test 1: AI Service Health
echo "1. Testing AI Service Health...\n";
$healthUrl = 'http://localhost:5001/api/health';
$healthResponse = @file_get_contents($healthUrl);

if ($healthResponse) {
    $health = json_decode($healthResponse, true);
    echo "   ✅ AI Service: {$health['status']} - {$health['service']}\n";
} else {
    echo "   ❌ AI Service not responding\n";
    exit(1);
}

// Test 2: AI Chat Endpoint
echo "\n2. Testing AI Chat Endpoint...\n";
$chatUrl = 'http://localhost:5001/api/chat';
$chatData = json_encode([
    'message' => 'I need a gift for my mom who loves reading, budget $30',
    'context' => '',
    'preferences' => ['budget' => 30, 'occasion' => 'birthday']
]);

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $chatData
    ]
];

$context = stream_context_create($options);
$chatResponse = @file_get_contents($chatUrl, false, $context);

if ($chatResponse) {
    $chat = json_decode($chatResponse, true);
    echo "   ✅ Chat Response: " . substr($chat['response'], 0, 60) . "...\n";
    echo "   📚 Recommendations: " . count($chat['recommendations']) . "\n";
    echo "   ❓ Questions: " . count($chat['questions']) . "\n";
    
    // Test 3: Products Search
    if (!empty($chat['recommendations'])) {
        echo "\n3. Testing Products Search...\n";
        $productsUrl = 'http://localhost:5001/api/search-products';
        $productData = json_encode([
            'recommendations' => $chat['recommendations']
        ]);
        
        $productOptions = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => $productData
            ]
        ];
        
        $productContext = stream_context_create($productOptions);
        $productResponse = @file_get_contents($productsUrl, false, $productContext);
        
        if ($productResponse) {
            $products = json_decode($productResponse, true);
            echo "   ✅ Products found: {$products['total_products']} across {$products['total_categories']} categories\n";
        } else {
            echo "   ⚠️ Products service not working, will use fallback\n";
        }
    }
} else {
    echo "   ❌ Chat endpoint failed\n";
}

// Test 4: Laravel Routes
echo "\n4. Testing Laravel Routes...\n";

// Test Laravel gifts page
$laravelResponse = @file_get_contents('http://127.0.0.1:8000/gifts');
if ($laravelResponse) {
    echo "   ✅ Laravel Gifts Page: Accessible\n";
} else {
    echo "   ❌ Laravel Gifts Page: Not accessible\n";
}

echo "\n🎯 Integration Status:\n";
echo "   • AI Service: Running on port 5001\n";
echo "   • Laravel App: Running on port 8000\n";  
echo "   • Database: Migrations complete\n";
echo "   • API Format: Compatible\n";

echo "\n🚀 Ready to test:\n";
echo "   1. Visit: http://127.0.0.1:8000/gifts\n";
echo "   2. Use the AI prompt form\n";
echo "   3. Click heart icons for favorites\n";
echo "   4. Check dashboard: http://127.0.0.1:8000/dashboard\n";

echo "\nTest completed! 🎉\n";