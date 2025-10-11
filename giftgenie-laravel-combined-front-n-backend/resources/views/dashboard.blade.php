<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-gray-600">Welcome back! Here's your gift-finding overview.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stats Cards -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer" onclick="viewAllFoundGifts()">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Gifts Found</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['gifts_found'] ?? 0 }}</p>
                            @if(($stats['gifts_found'] ?? 0) > 0)
                                <p class="text-xs text-blue-600 mt-1">Click to view all</p>
                            @endif
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            @if(($stats['gifts_found'] ?? 0) > 0)
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                                    </path>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('favorites') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow block">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Saved Items</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['saved_items'] ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-1">Click to view favorites</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </a>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Chat Sessions</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['chat_sessions'] ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Budget Saved</p>
                            <p class="text-3xl font-bold text-gray-900">
                                ${{ number_format($stats['budget_saved'] ?? 0, 0) }}</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Searches -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Recent Searches</h2>
                    <div class="space-y-3">
                        @forelse($recentSessions as $session)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-1">
                                    <p class="font-medium">
                                        {{ \Illuminate\Support\Str::limit($session->initial_prompt, 50) }}</p>
                                    <p class="text-sm text-gray-600">{{ $session->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-blue-600 text-sm">{{ $session->gifts_found ?? 0 }} results</span>
                                    @if(($session->gifts_found ?? 0) > 0)
                                        <a href="{{ route('found.gifts') }}?session={{ $session->session_uuid }}"
                                           class="inline-flex items-center px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-500">No searches yet. Start by <a href="{{ route('gifts') }}"
                                        class="text-blue-600 underline">finding gifts</a>!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Saved Gifts -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Saved Gifts</h2>
                    <div class="space-y-3">
                        @forelse($recentFavorites as $gift)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <img src="{{ $gift->image_url ?? 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=60' }}"
                                    alt="{{ $gift->name }}" class="w-12 h-12 rounded object-cover">
                                <div class="flex-1">
                                    <p class="font-medium">{{ \Illuminate\Support\Str::limit($gift->name, 30) }}</p>
                                    <p class="text-sm text-gray-600">${{ number_format($gift->price, 2) }}</p>
                                </div>
                                <button onclick="toggleAiFavorite({{ $gift->id }})" class="text-red-500 hover:text-red-700"
                                    title="Remove from favorites">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.653 16.915l-.005-.003-.019-.01a15.256 15.256 0 01-.648-.373c-.38-.22-.89-.53-1.477-.903C6.045 14.48 4 12.84 4 10.5a4.5 4.5 0 019 0c0 2.34-2.045 3.98-3.504 5.126a15.247 15.247 0 01-2.124 1.286l-.019.01-.005.003h-.002a.5.5 0 01-.338 0z" />
                                    </svg>
                                </button>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-500">No saved gifts yet. Start by <a href="{{ route('gifts') }}"
                                        class="text-blue-600 underline">finding gifts</a> and clicking the heart icon!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle favorite function for dashboard
        function toggleAiFavorite(giftId) {
            fetch(`/toggle-favorite/${giftId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to update the saved items list
                        window.location.reload();
                    } else {
                        alert('Failed to update favorite status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update favorite status');
                });
        }

        // View all found gifts function
        function viewAllFoundGifts() {
            @if(($stats['gifts_found'] ?? 0) > 0)
                @if(isset($recentSessions) && $recentSessions->count() > 0)
                    // Redirect to the most recent session's found gifts
                    window.location.href = '{{ route("found.gifts") }}?session={{ $recentSessions->first()->session_uuid }}';
                @else
                    // Fallback: redirect to gifts page to start new search
                    window.location.href = '{{ route("gifts") }}';
                @endif
            @else
                // No gifts found, redirect to gifts page to start searching
                window.location.href = '{{ route("gifts") }}';
            @endif
        }
    </script>
</x-app-layout>