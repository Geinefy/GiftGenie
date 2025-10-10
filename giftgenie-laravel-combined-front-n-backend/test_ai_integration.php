<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Http\Request;
use App\Http\Controllers\AiGiftController;

// Create a simple test to verify AI integration
echo "Testing AI Integration...\n";

// Test AI service connection
$aiServiceUrl = 'http://localhost:5001/api/health';
$response = @file_get_contents($aiServiceUrl);

if ($response) {
    echo "✓ AI Service is running on localhost:5001\n";
    $decoded = json_decode($response, true);
    if (isset($decoded['status'])) {
        echo "  Status: " . $decoded['status'] . "\n";
        echo "  Service: " . $decoded['service'] . "\n";
    }
} else {
    echo "✗ AI Service is not accessible on localhost:5001\n";
    echo "Please make sure the AI service is running.\n";
    exit(1);
}

// Test chat endpoint
$chatUrl = 'http://localhost:5001/api/chat';
$data = json_encode([
    'message' => 'Suggest a gift for my mom who loves gardening, budget $50',
    'context' => '',
    'preferences' => ['budget' => 50, 'occasion' => 'birthday']
]);

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $data
    ]
];

$context = stream_context_create($options);
$chatResponse = @file_get_contents($chatUrl, false, $context);

if ($chatResponse) {
    echo "✓ AI Chat endpoint is working\n";
    $decoded = json_decode($chatResponse, true);
    if (isset($decoded['response'])) {
        echo "  Sample response: " . substr($decoded['response'], 0, 100) . "...\n";
    }
    if (isset($decoded['recommendations'])) {
        echo "  Generated " . count($decoded['recommendations']) . " recommendations\n";
    }
} else {
    echo "✗ AI Chat endpoint is not working\n";
}

// Test search-products endpoint if we have recommendations
if (isset($decoded['recommendations']) && $decoded['recommendations']) {
    $productsUrl = 'http://localhost:5001/api/search-products';
    $productData = json_encode([
        'recommendations' => $decoded['recommendations']
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
        echo "✓ AI Products endpoint is working\n";
        $decoded2 = json_decode($productResponse, true);
        if (isset($decoded2['total_products'])) {
            echo "  Found " . $decoded2['total_products'] . " total products across " . $decoded2['total_categories'] . " categories\n";
        }
    } else {
        echo "✗ AI Products endpoint is not working\n";
    }
} else {
    echo "⚠ Skipping products test - no recommendations from chat endpoint\n";
}

echo "\nAI Integration Test Complete!\n";
echo "\nYou can now:\n";
echo "1. Visit http://127.0.0.1:8000/gifts\n";
echo "2. Use the AI prompt form to search for gifts\n";
echo "3. Toggle favorites by clicking heart icons\n";
echo "4. Visit http://127.0.0.1:8000/dashboard for analytics\n";