<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold mb-4 text-gray-800">My Favorite Gifts</h1>
            <p class="text-lg text-gray-600">
                Your saved gift ideas and favorites
            </p>
        </div>

        <!-- Stats Bar -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $favorites->count() }}</div>
                    <div class="text-gray-600">Saved Gifts</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">${{ number_format($favorites->sum('price'), 2) }}</div>
                    <div class="text-gray-600">Total Value</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600">${{ $favorites->count() > 0 ? number_format($favorites->avg('price'), 2) : '0.00' }}</div>
                    <div class="text-gray-600">Avg Price</div>
                </div>
                <div class="flex gap-2">
                    <button onclick="clearAllFavorites()" class="bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200 transition-colors">
                        Clear All
                    </button>
                    <a href="{{ route('gifts') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Find More Gifts
                    </a>
                </div>
            </div>
        </div>

        <!-- Favorites Grid -->
        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="favoritesGrid">
                @foreach($favorites as $gift)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow gift-card"
                         data-gift-id="{{ $gift->id }}">

                        <!-- Gift Image with Remove Button -->
                        <div class="relative">
                            <img src="{{ $gift->image_url }}"
                                 alt="{{ $gift->name }}"
                                 class="w-full h-48 object-cover">

                            <!-- Remove from Favorites Button -->
                            <button onclick="toggleAiFavorite({{ $gift->id }})"
                                    class="absolute top-2 right-2 p-2 bg-white bg-opacity-90 rounded-full shadow-md hover:bg-opacity-100 transition-all"
                                    id="favorite-btn-{{ $gift->id }}"
                                    title="Remove from favorites">
                                <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 20 20">
                                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                          fill="currentColor"/>
                                </svg>
                            </button>

                            <!-- Category Badge -->
                            @if(isset($gift->metadata['category']))
                                <div class="absolute top-2 left-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $gift->metadata['category'])) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2">{{ $gift->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($gift->description, 100) }}</p>

                            <!-- Gift Metadata -->
                            @if(isset($gift->metadata) && is_array($gift->metadata))
                                <div class="flex items-center gap-2 mb-3 text-xs text-gray-500">
                                    @if(isset($gift->metadata['rating']))
                                        <div class="flex items-center">
                                            <span class="text-yellow-500">★</span>
                                            <span class="ml-1">{{ $gift->metadata['rating'] }}</span>
                                        </div>
                                    @endif
                                    @if(isset($gift->metadata['reviews']))
                                        <span>({{ $gift->metadata['reviews'] }} reviews)</span>
                                    @endif
                                </div>
                            @endif

                            <!-- Price and Actions -->
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($gift->price, 2) }}</span>
                                @if($gift->source)
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $gift->source }}</span>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ $gift->product_url }}"
                                   target="_blank"
                                   class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-md text-sm text-center transition-colors hover:from-blue-700 hover:to-purple-700">
                                    View Details
                                </a>
                                <button onclick="shareGift({{ $gift->id }})"
                                        class="bg-gray-100 text-gray-700 px-3 py-2 rounded-md text-sm hover:bg-gray-200 transition-colors"
                                        title="Share gift">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Date Added -->
                            <div class="text-xs text-gray-400 mt-2">
                                Saved {{ $gift->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination if needed -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">Showing {{ $favorites->count() }} favorite gifts</p>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mb-8">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-500 mb-2">No favorite gifts yet</h3>
                    <p class="text-gray-400 mb-6">Start exploring gifts and save your favorites for later!</p>
                    <a href="{{ route('gifts') }}"
                       class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg text-lg transition-colors hover:from-blue-700 hover:to-purple-700">
                        Find Perfect Gifts
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        function toggleAiFavorite(giftId) {
            const button = document.getElementById(`favorite-btn-${giftId}`);
            const giftCard = document.querySelector(`[data-gift-id="${giftId}"]`);

            // Show loading state
            button.disabled = true;

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
                    if (!data.is_favorited) {
                        // Item was unfavorited, remove it from the grid
                        if (giftCard) {
                            giftCard.style.transition = 'opacity 0.3s ease-out';
                            giftCard.style.opacity = '0';
                            setTimeout(() => {
                                giftCard.remove();
                                // Check if grid is empty now
                                const remainingCards = document.querySelectorAll('.gift-card');
                                if (remainingCards.length === 0) {
                                    location.reload(); // Reload to show empty state
                                }
                            }, 300);
                        }
                    }

                    // Show success message
                    showMessage(data.message, 'success');
                } else {
                    showMessage('Failed to update favorite status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Failed to update favorite status', 'error');
            })
            .finally(() => {
                button.disabled = false;
            });
        }

        function clearAllFavorites() {
            if (confirm('Are you sure you want to remove all favorites? This action cannot be undone.')) {
                const favoriteIds = Array.from(document.querySelectorAll('.gift-card')).map(card =>
                    card.getAttribute('data-gift-id')
                );

                let removedCount = 0;
                favoriteIds.forEach(giftId => {
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
                        removedCount++;
                        if (removedCount === favoriteIds.length) {
                            // All items processed, reload page
                            location.reload();
                        }
                    });
                });
            }
        }

        function shareGift(giftId) {
            const giftCard = document.querySelector(`[data-gift-id="${giftId}"]`);
            const giftName = giftCard.querySelector('h3').textContent;
            const giftUrl = giftCard.querySelector('a').href;

            if (navigator.share) {
                navigator.share({
                    title: `Check out this gift: ${giftName}`,
                    text: `I found this great gift idea: ${giftName}`,
                    url: giftUrl
                });
            } else {
                // Fallback - copy to clipboard
                navigator.clipboard.writeText(`${giftName} - ${giftUrl}`).then(() => {
                    showMessage('Gift link copied to clipboard!', 'success');
                });
            }
        }

        function showMessage(message, type = 'info') {
            // Create and show a toast message
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            toast.textContent = message;

            document.body.appendChild(toast);

            // Remove after 3 seconds
            setTimeout(() => {
                toast.style.transition = 'opacity 0.3s ease-out';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</x-app-layout>