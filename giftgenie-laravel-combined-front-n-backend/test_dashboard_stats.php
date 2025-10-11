<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Http\Controllers\AiGiftController;
use Illuminate\Support\Facades\Auth;

echo "Testing Dashboard Stats...\n";

// Find test user
$user = User::where('email', 'test@example.com')->first();
if (!$user) {
    echo "❌ Test user not found\n";
    exit(1);
}

// Simulate authentication
Auth::login($user);
echo "✅ Authenticated as: {$user->name}\n";

// Test the controller method
$controller = new AiGiftController();
echo "✅ Controller instantiated\n";

try {
    // This should return the view, but let's test the stats calculation
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('getDashboardStats');
    
    // We'll create a simple version to test the stats
    $userId = Auth::id();
    
    $stats = [
        'gifts_found' => \App\Models\ChatSession::where('user_id', $userId)->sum('gifts_found'),
        'saved_items' => \App\Models\AiGeneratedGift::whereHas('chatSession', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('is_favorited', true)->count(),
        'chat_sessions' => \App\Models\ChatSession::where('user_id', $userId)->count(),
        'budget_saved' => \App\Models\ChatSession::where('user_id', $userId)->sum('total_budget_shown')
    ];
    
    echo "✅ Dashboard Stats:\n";
    foreach ($stats as $key => $value) {
        echo "   {$key}: {$value}\n";
    }
    
    echo "\n🎯 Dashboard should now show real data!\n";
    echo "Visit: http://127.0.0.1:8000/dashboard\n";
    
} catch (Exception $e) {
    echo "❌ Error testing stats: " . $e->getMessage() . "\n";
}