<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\ChatSession;

echo "Finding test session for found-gifts page...\n";

// Find test user and their sessions
$user = User::where('email', 'test@example.com')->first();
if (!$user) {
    echo "❌ Test user not found\n";
    exit(1);
}

echo "✅ Found user: {$user->name}\n";

$sessions = ChatSession::where('user_id', $user->id)->get();
echo "✅ Found {$sessions->count()} chat sessions\n";

if ($sessions->count() > 0) {
    $session = $sessions->first();
    echo "📋 Sample session UUID: {$session->session_uuid}\n";
    echo "🔗 Test URL: http://127.0.0.1:8000/found-gifts?session={$session->session_uuid}\n";
    echo "💡 Gifts in this session: {$session->aiGeneratedGifts->count()}\n";
} else {
    echo "⚠️ No sessions found, please make a search first\n";
}