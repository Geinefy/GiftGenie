<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Found Gifts') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">{{ $totalFound ?? 0 }} gifts found</span>
                @if(isset($sessionId))
                    <span class="text-xs text-gray-500">Session: {{ substr($sessionId, 0, 8) }}...</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- AI Response Section -->
            @if(isset($aiResponse['response']))
                <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-blue-800 mb-2">AI Recommendation</h3>
                            <p class="text-blue-700">{{ $aiResponse['response'] }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filter and Sort Section -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex flex-wrap items-center space-x-4">
                        <h3 class="font-medium text-gray-900">Filter & Sort:</h3>

                        <!-- Budget Filter -->
                        <select id="budgetFilter" class="rounded-md border-gray-300 text-sm">
                            <option value="">All Budgets</option>
                            <option value="0-25">Under $25</option>
                            <option value="25-50">$25 - $50</option>
                            <option value="50-100">$50 - $100</option>
                            <option value="100-200">$100 - $200</option>
                            <option value="200+">$200+</option>
                        </select>

                        <!-- Sort Options -->
                        <select id="sortGifts" class="rounded-md border-gray-300 text-sm">
                            <option value="relevance">Sort by Relevance</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="name">Name: A to Z</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button onclick="toggleView('grid')" id="gridView" class="p-2 rounded-md bg-blue-100 text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </button>
                        <button onclick="toggleView('list')" id="listView" class="p-2 rounded-md bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Gifts Grid -->
            @if(isset($gifts) && count($gifts) > 0)
                <div id="giftsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($gifts as $gift)
                        <div class="gift-card group bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden"
                             data-price="{{ $gift->price }}"
                             data-name="{{ strtolower($gift->name) }}">

                            <!-- Animated Gift Box with Favorite Button -->
                            <div class="relative">
                                <div class="gift-box-container">
                                    <!-- Sparkles for extra delight -->
                                    <div class="gift-box-sparkles">
                                        <div class="sparkle"></div>
                                        <div class="sparkle"></div>
                                        <div class="sparkle"></div>
                                        <div class="sparkle"></div>
                                    </div>
                                    
                                    <!-- Closed Gift Box (Base) -->
                                    <div class="gift-box-base gift-box-pulse"
                                         style="background-image: url('{{ asset('assets/gift-placeholder.jpeg') }}');">
                                    </div>
                                    
                                    <!-- Opened Gift Box Lid (Shows on hover) -->
                                    <div class="gift-box-lid"
                                         style="background-image: url('{{ asset('assets/gift-placeholder-lid-open.png') }}');">
                                    </div>

                                    <!-- Gift Name Overlay (appears on hover) -->
                                    <div class="absolute bottom-4 left-4 right-4 bg-black bg-opacity-50 text-white text-sm p-2 rounded transform translate-y-full opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                        <p class="font-medium truncate">{{ $gift->name }}</p>
                                    </div>
                                </div>

                                @auth
                                    <button onclick="toggleAiFavorite({{ $gift->id }})"
                                            class="absolute top-3 right-3 p-2 bg-white bg-opacity-90 rounded-full shadow-lg hover:bg-opacity-100 hover:shadow-xl transition-all transform hover:scale-110 z-10"
                                            id="favorite-btn-{{ $gift->id }}"
                                            title="{{ $gift->is_favorited ? 'Remove from favorites' : 'Add to favorites' }}">
                                        <svg class="w-6 h-6 transition-colors {{ $gift->is_favorited ? 'text-red-500' : 'text-gray-400 hover:text-red-400' }}"
                                             fill="{{ $gift->is_favorited ? 'currentColor' : 'none' }}"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                @else
                                    <!-- Show login prompt for guests -->
                                    <div class="absolute top-3 right-3 p-2 bg-blue-100 bg-opacity-90 rounded-full shadow-lg z-10">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endauth
                            </div>

                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">{{ $gift->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ \Illuminate\Support\Str::limit($gift->description, 100) }}</p>

                                <!-- Gift Metadata -->
                                @if($gift->metadata && is_array($gift->metadata))
                                    <div class="flex items-center gap-2 mb-3 text-xs text-gray-500">
                                        @if(isset($gift->metadata['rating']))
                                            <div class="flex items-center">
                                                <span class="text-yellow-500">★</span>
                                                <span class="ml-1">{{ $gift->metadata['rating'] }}</span>
                                            </div>
                                        @endif
                                        @if(isset($gift->metadata['reviews']))
                                            <span>{{ number_format($gift->metadata['reviews']) }} reviews</span>
                                        @endif
                                        @if($gift->source)
                                            <span class="bg-gray-100 px-2 py-1 rounded">{{ ucfirst($gift->source) }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-center justify-between">
                                    <div class="text-2xl font-bold text-blue-600">${{ number_format($gift->price, 2) }}</div>
                                    @if($gift->product_url && $gift->product_url !== '#')
                                        <a href="{{ $gift->product_url }}" target="_blank"
                                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                            View Product
                                        </a>
                                    @else
                                        <button class="bg-gray-300 text-gray-600 px-4 py-2 rounded-lg cursor-not-allowed text-sm font-medium">
                                            Not Available
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Gifts Found -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No gifts found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria or budget.</p>
                    <div class="mt-6">
                        <a href="{{ route('gifts') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Search Again
                        </a>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row sm:justify-between items-center space-y-4 sm:space-y-0">
                <div class="flex space-x-4">
                    <a href="{{ route('gifts') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        New Search
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7"></path>
                        </svg>
                        Dashboard
                    </a>
                </div>

                @if(isset($gifts) && count($gifts) > 0)
                    <div class="text-sm text-gray-500">
                        Total Budget: ${{ number_format($totalBudget ?? 0, 2) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Filter and sort functionality
        document.getElementById('budgetFilter').addEventListener('change', filterGifts);
        document.getElementById('sortGifts').addEventListener('change', sortGifts);

        function filterGifts() {
            const budgetFilter = document.getElementById('budgetFilter').value;
            const cards = document.querySelectorAll('.gift-card');

            cards.forEach(card => {
                const price = parseFloat(card.dataset.price);
                let show = true;

                if (budgetFilter) {
                    if (budgetFilter === '0-25') show = price <= 25;
                    else if (budgetFilter === '25-50') show = price > 25 && price <= 50;
                    else if (budgetFilter === '50-100') show = price > 50 && price <= 100;
                    else if (budgetFilter === '100-200') show = price > 100 && price <= 200;
                    else if (budgetFilter === '200+') show = price > 200;
                }

                card.style.display = show ? 'block' : 'none';
            });
        }

        function sortGifts() {
            const sortBy = document.getElementById('sortGifts').value;
            const grid = document.getElementById('giftsGrid');
            const cards = Array.from(document.querySelectorAll('.gift-card'));

            cards.sort((a, b) => {
                const priceA = parseFloat(a.dataset.price);
                const priceB = parseFloat(b.dataset.price);
                const nameA = a.dataset.name;
                const nameB = b.dataset.name;

                switch (sortBy) {
                    case 'price-low': return priceA - priceB;
                    case 'price-high': return priceB - priceA;
                    case 'name': return nameA.localeCompare(nameB);
                    default: return 0;
                }
            });

            cards.forEach(card => grid.appendChild(card));
        }

        function toggleView(viewType) {
            const grid = document.getElementById('giftsGrid');
            const gridBtn = document.getElementById('gridView');
            const listBtn = document.getElementById('listView');

            if (viewType === 'grid') {
                grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6';
                gridBtn.className = 'p-2 rounded-md bg-blue-100 text-blue-600';
                listBtn.className = 'p-2 rounded-md bg-gray-100 text-gray-600';
            } else {
                grid.className = 'space-y-4';
                gridBtn.className = 'p-2 rounded-md bg-gray-100 text-gray-600';
                listBtn.className = 'p-2 rounded-md bg-blue-100 text-blue-600';
            }
        }

        // Toggle favorite function
        function toggleAiFavorite(giftId) {
            const button = document.getElementById(`favorite-btn-${giftId}`);
            if (!button) {
                console.error('Favorite button not found for gift ID:', giftId);
                return;
            }

            const heartIcon = button.querySelector('svg');

            // Show loading state
            button.disabled = true;
            button.style.opacity = '0.6';

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
                    // Update heart appearance with better styling
                    if (data.is_favorited) {
                        heartIcon.classList.remove('text-gray-400', 'hover:text-red-400');
                        heartIcon.classList.add('text-red-500');
                        heartIcon.setAttribute('fill', 'currentColor');
                        button.setAttribute('title', 'Remove from favorites');

                        // Add a subtle animation
                        button.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            button.style.transform = 'scale(1)';
                        }, 200);

                    } else {
                        heartIcon.classList.remove('text-red-500');
                        heartIcon.classList.add('text-gray-400', 'hover:text-red-400');
                        heartIcon.setAttribute('fill', 'none');
                        button.setAttribute('title', 'Add to favorites');
                    }

                    // Show success message
                    showToast(data.message, 'success');

                } else {
                    showToast(data.message || 'Failed to update favorite status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to update favorite status. Please try again.', 'error');
            })
            .finally(() => {
                button.disabled = false;
                button.style.opacity = '1';
            });
        }

        // Toast notification function
        function showToast(message, type = 'info') {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.toast-notification');
            existingToasts.forEach(toast => toast.remove());

            // Create new toast
            const toast = document.createElement('div');
            toast.className = `toast-notification fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 shadow-lg transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            toast.style.transform = 'translateX(100%)';
            toast.textContent = message;

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 10);

            // Remove after 3 seconds
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }


    </script>
</x-app-layout>