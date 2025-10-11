<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4 text-gray-800">Find the Perfect Gift</h1>
            <p class="text-lg text-gray-600">
                Tell us about the person or occasion, and our AI will find amazing gift suggestions
            </p>
        </div>

        <!-- Main AI Prompt Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <!-- Large Text Input -->
            <div class="mb-6">
                <textarea id="aiPrompt"
                    placeholder="Describe who you're shopping for... (e.g., 'My tech-savvy brother who loves gaming and gadgets, budget around $50-100')"
                    class="w-full h-32 p-4 border-2 border-gray-200 rounded-xl resize-none text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                    maxlength="500"></textarea>
                <div class="text-right mt-2">
                    <span class="text-sm text-gray-400" id="charCount">0/500</span>
                </div>
            </div>

            <!-- Find Gifts Button -->
            <div class="text-center mb-8">
                <button id="findGiftsBtn"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold px-12 py-4 rounded-xl text-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Find Perfect Gifts
                    </span>
                </button>
            </div>

            <!-- Divider Line -->
            <div class="border-t border-gray-200 mb-6"></div>

            <!-- Additional Options Toggle -->
            <div class="text-center">
                <button id="toggleOptions"
                    class="text-gray-600 hover:text-gray-800 font-medium flex items-center justify-center mx-auto transition-colors">
                    <span class="mr-2">Want to be more specific? Select from below options</span>
                    <svg id="toggleIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <!-- Collapsible Additional Options -->
            <div id="additionalOptions" class="hidden mt-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Budget Range -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Budget Range</label>
                        <select name="budget"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Any Budget</option>
                            <option value="0-25">Under $25</option>
                            <option value="25-50">$25 - $50</option>
                            <option value="50-100">$50 - $100</option>
                            <option value="100-200">$100 - $200</option>
                            <option value="200+">$200+</option>
                        </select>
                    </div>

                    <!-- Occasion -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Occasion</label>
                        <select name="occasion"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Any Occasion</option>
                            <option value="birthday">Birthday</option>
                            <option value="anniversary">Anniversary</option>
                            <option value="wedding">Wedding</option>
                            <option value="graduation">Graduation</option>
                            <option value="christmas">Christmas</option>
                            <option value="valentine">Valentine's Day</option>
                            <option value="mother-day">Mother's Day</option>
                            <option value="father-day">Father's Day</option>
                        </select>
                    </div>

                    <!-- Relationship -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Relationship</label>
                        <select name="relationship"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Relationship</option>
                            <option value="spouse">Spouse/Partner</option>
                            <option value="parent">Parent</option>
                            <option value="sibling">Sibling</option>
                            <option value="child">Child</option>
                            <option value="friend">Friend</option>
                            <option value="colleague">Colleague</option>
                            <option value="boss">Boss</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>

                    <!-- Age Range -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Age Range</label>
                        <select name="age"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Any Age</option>
                            <option value="0-5">0-5 years</option>
                            <option value="6-12">6-12 years</option>
                            <option value="13-17">13-17 years</option>
                            <option value="18-25">18-25 years</option>
                            <option value="26-35">26-35 years</option>
                            <option value="36-50">36-50 years</option>
                            <option value="51-65">51-65 years</option>
                            <option value="65+">65+ years</option>
                        </select>
                    </div>

                    <!-- Gender -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Any Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <!-- Interests -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Interests</label>
                        <select name="interests"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Interest</option>
                            <option value="technology">Technology</option>
                            <option value="sports">Sports & Fitness</option>
                            <option value="books">Books & Reading</option>
                            <option value="music">Music</option>
                            <option value="art">Art & Crafts</option>
                            <option value="cooking">Cooking</option>
                            <option value="travel">Travel</option>
                            <option value="fashion">Fashion</option>
                            <option value="gaming">Gaming</option>
                            <option value="gardening">Gardening</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8" id="loadingSection" style="display: none;">
            <div class="text-center">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2" id="loadingTitle">Processing your request...</h3>
                    <p class="text-gray-600" id="loadingMessage">This may take up to 2 minutes. Please be patient.</p>
                </div>

                <!-- Progress Steps -->
                <div class="max-w-md mx-auto">
                    <div class="space-y-4">
                        <div class="flex items-center text-sm" id="step1">
                            <div class="w-4 h-4 bg-blue-600 rounded-full mr-3 step-indicator"></div>
                            <span class="text-gray-700">AI analyzing your request...</span>
                            <div class="ml-auto">
                                <div class="w-5 h-5 border-2 border-blue-600 border-t-transparent rounded-full animate-spin step-spinner"></div>
                            </div>
                        </div>

                        <div class="flex items-center text-sm" id="step2">
                            <div class="w-4 h-4 bg-gray-300 rounded-full mr-3 step-indicator"></div>
                            <span class="text-gray-500">AI recommended gifts generated</span>
                            <div class="ml-auto">
                                <svg class="w-5 h-5 text-green-500 step-check hidden" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="flex items-center text-sm" id="step3">
                            <div class="w-4 h-4 bg-gray-300 rounded-full mr-3 step-indicator"></div>
                            <span class="text-gray-500">Now searching for gifts online...</span>
                            <div class="ml-auto">
                                <svg class="w-5 h-5 text-green-500 step-check hidden" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="flex items-center text-sm" id="step4">
                            <div class="w-4 h-4 bg-gray-300 rounded-full mr-3 step-indicator"></div>
                            <span class="text-gray-500">Gifts fetched from online sources</span>
                            <div class="ml-auto">
                                <svg class="w-5 h-5 text-green-500 step-check hidden" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mt-6">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500 ease-out" id="progressBar" style="width: 0%"></div>
                    </div>
                    <div class="text-sm text-gray-500 mt-2">
                        <span id="progressText">0% Complete</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="space-y-6" id="resultsSection" style="display: none;">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Gift Suggestions</h2>
                <select class="border border-gray-300 rounded-md px-3 py-2" id="sortSelect">
                    <option value="relevance">Relevance</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="giftsGrid">
                @if(count($gifts) > 0)
                    @foreach($gifts as $gift)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow gift-card"
                            data-price="{{ is_array($gift) ? $gift['price'] : $gift->price }}">

                            <!-- Gift Image with Favorite Button -->
                            <div class="relative">
                                <img src="{{ is_array($gift) ? $gift['image_url'] : $gift->image_url }}"
                                    alt="{{ is_array($gift) ? $gift['name'] : $gift->name }}" class="w-full h-48 object-cover">

                                @auth
                                    @php
                                        $giftId = is_array($gift) ? ($gift['id'] ?? null) : $gift->id;
                                        $isFavorited = is_array($gift) ? false : (isset($gift->is_favorited) && $gift->is_favorited);
                                    @endphp
                                    @if($giftId)
                                        <button onclick="toggleAiFavorite({{ $giftId }})"
                                                class="absolute top-3 right-3 p-2 bg-white bg-opacity-90 rounded-full shadow-lg hover:bg-opacity-100 hover:shadow-xl transition-all transform hover:scale-110"
                                                id="favorite-btn-{{ $giftId }}"
                                                title="{{ $isFavorited ? 'Remove from favorites' : 'Add to favorites' }}">
                                            <svg class="w-6 h-6 transition-colors {{ $isFavorited ? 'text-red-500' : 'text-gray-400 hover:text-red-400' }}"
                                                 fill="{{ $isFavorited ? 'currentColor' : 'none' }}"
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
                                        <!-- Debug: Show when no gift ID -->
                                        <div class="absolute top-3 right-3 p-2 bg-yellow-100 rounded-full text-xs text-yellow-800">
                                            No ID
                                        </div>
                                    @endif
                                @else
                                    <!-- Show login prompt for guests -->
                                    <div class="absolute top-3 right-3 p-2 bg-blue-100 bg-opacity-90 rounded-full shadow-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endauth
                            </div>

                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">{{ is_array($gift) ? $gift['name'] : $gift->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ is_array($gift) ? $gift['description'] : $gift->description }}</p>

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
                                        @if(isset($gift->metadata['shipping']))
                                            <span class="text-green-600">{{ $gift->metadata['shipping'] }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex justify-between items-center">
                                    <span class="text-2xl font-bold text-blue-600">${{ number_format(is_array($gift) ? $gift['price'] : $gift->price, 2) }}</span>
                                    <div class="flex gap-2">
                                        @if(isset($gift->source))
                                            <span class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $gift->source }}</span>
                                        @endif
                                        <a href="{{ is_array($gift) ? $gift['product_url'] : $gift->product_url }}"
                                           target="_blank"
                                           class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-md text-sm transition-colors hover:from-blue-700 hover:to-purple-700">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-12">
                        <div class="mb-4">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-500 mb-2">No gifts found yet</h3>
                            <p class="text-gray-400">Use the AI prompt above to get personalized gift suggestions!</p>
                        </div>
                    </div>
                @endif
            </div>


        </div>
    </div>

    <script>
        // Character counter for AI prompt
        document.getElementById('aiPrompt').addEventListener('input', function () {
            const charCount = this.value.length;
            document.getElementById('charCount').textContent = charCount + '/500';

            // Change color based on character count
            const counter = document.getElementById('charCount');
            if (charCount > 450) {
                counter.classList.add('text-red-500');
                counter.classList.remove('text-gray-400');
            } else {
                counter.classList.add('text-gray-400');
                counter.classList.remove('text-red-500');
            }
        });

        // Toggle additional options
        document.getElementById('toggleOptions').addEventListener('click', function () {
            const options = document.getElementById('additionalOptions');
            const icon = document.getElementById('toggleIcon');

            if (options.classList.contains('hidden')) {
                options.classList.remove('hidden');
                options.classList.add('animate-fadeIn');
                icon.style.transform = 'rotate(180deg)';
            } else {
                options.classList.add('hidden');
                options.classList.remove('animate-fadeIn');
                icon.style.transform = 'rotate(0deg)';
            }
        });

        // Find gifts button functionality
        document.getElementById('findGiftsBtn').addEventListener('click', function () {
            const prompt = document.getElementById('aiPrompt').value.trim();

            if (!prompt) {
                alert('Please describe who you\'re shopping for to get gift suggestions.');
                return;
            }

            // Show loading section and hide search form
            showLoadingSection();

            // Show loading state
            this.innerHTML = `
        <span class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Finding Perfect Gifts...
        </span>
    `;

            this.disabled = true;

            // Collect additional options
            const budget = document.querySelector('select[name="budget"]')?.value || '';
            const occasion = document.querySelector('select[name="occasion"]')?.value || '';
            const relationship = document.querySelector('select[name="relationship"]')?.value || '';
            const age = document.querySelector('select[name="age"]')?.value || '';
            const gender = document.querySelector('select[name="gender"]')?.value || '';
            const interests = document.querySelector('select[name="interests"]')?.value || '';

            // Create form data
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('prompt', prompt);
            if (budget) formData.append('budget', budget);
            if (occasion) formData.append('occasion', occasion);
            if (relationship) formData.append('relationship', relationship);
            if (age) formData.append('age', age);
            if (gender) formData.append('gender', gender);
            if (interests) formData.append('interests', interests);

            // Make API call to Laravel backend
            fetch('{{ route("ai.search.gifts") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok');
            })
            .then(html => {
                // Replace current page content with results
                document.open();
                document.write(html);
                document.close();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to get gift suggestions. Please try again.');

                // Reset button
                this.innerHTML = `
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Find Perfect Gifts
                    </span>
                `;
                this.disabled = false;
            });
        });

        // Sorting functionality
        document.getElementById('sortSelect').addEventListener('change', function () {
            const sortBy = this.value;
            const grid = document.getElementById('giftsGrid');
            const cards = Array.from(grid.children);

            cards.sort((a, b) => {
                const priceA = parseFloat(a.dataset.price);
                const priceB = parseFloat(b.dataset.price);

                switch (sortBy) {
                    case 'price-low':
                        return priceA - priceB;
                    case 'price-high':
                        return priceB - priceA;
                    default:
                        return 0;
                }
            });

            cards.forEach(card => grid.appendChild(card));
        });

        // Add fade-in animation for additional options
        const style = document.createElement('style');
        style.textContent = `
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
        document.head.appendChild(style);

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

        // Make toggleFavorite globally available
        window.toggleFavorite = toggleFavorite;

        // Loading section management
        function showLoadingSection() {
            // Hide search form and show loading
            document.querySelector('.bg-white.rounded-2xl.shadow-lg.p-8.mb-8').style.display = 'none';
            document.getElementById('loadingSection').style.display = 'block';
            document.getElementById('resultsSection').style.display = 'none';

            // Start progress simulation
            simulateProgress();
        }

        function simulateProgress() {
            let progress = 0;
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            // Step 1: AI analyzing (0-25%)
            const step1Interval = setInterval(() => {
                progress += Math.random() * 3;
                if (progress >= 25) {
                    progress = 25;
                    clearInterval(step1Interval);
                    completeStep(1);
                    // Start step 2
                    step2Progress();
                }
                updateProgress(progress, 'AI analyzing your request...');
            }, 200);
        }

        function step2Progress() {
            let progress = 25;
            const step2Interval = setInterval(() => {
                progress += Math.random() * 2;
                if (progress >= 45) {
                    progress = 45;
                    clearInterval(step2Interval);
                    completeStep(2);
                    // Start step 3
                    step3Progress();
                }
                updateProgress(progress, 'AI recommendations generated');
            }, 300);
        }

        function step3Progress() {
            let progress = 45;
            const step3Interval = setInterval(() => {
                progress += Math.random() * 1.5;
                if (progress >= 75) {
                    progress = 75;
                    clearInterval(step3Interval);
                    completeStep(3);
                    // Start step 4
                    step4Progress();
                }
                updateProgress(progress, 'Searching for gifts online...');
            }, 400);
        }

        function step4Progress() {
            let progress = 75;
            const step4Interval = setInterval(() => {
                progress += Math.random() * 1;
                if (progress >= 95) {
                    progress = 95;
                    clearInterval(step4Interval);
                    completeStep(4);
                }
                updateProgress(progress, 'Finalizing gift selections...');
            }, 500);
        }

        function updateProgress(percentage, message) {
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            progressBar.style.width = percentage + '%';
            progressText.textContent = Math.round(percentage) + '% Complete';

            if (message) {
                document.getElementById('loadingMessage').textContent = message;
            }
        }

        function completeStep(stepNumber) {
            const step = document.getElementById('step' + stepNumber);
            const indicator = step.querySelector('.step-indicator');
            const text = step.querySelector('span');
            const spinner = step.querySelector('.step-spinner');
            const check = step.querySelector('.step-check');

            // Update indicator
            indicator.classList.remove('bg-gray-300');
            indicator.classList.add('bg-green-500');

            // Update text color
            text.classList.remove('text-gray-500');
            text.classList.add('text-gray-700');

            // Hide spinner and show check
            if (spinner) spinner.style.display = 'none';
            if (check) check.classList.remove('hidden');

            // Start next step indicator
            const nextStep = document.getElementById('step' + (stepNumber + 1));
            if (nextStep) {
                const nextIndicator = nextStep.querySelector('.step-indicator');
                const nextText = nextStep.querySelector('span');
                const nextSpinner = nextStep.querySelector('.step-spinner');

                nextIndicator.classList.remove('bg-gray-300');
                nextIndicator.classList.add('bg-blue-600');
                nextText.classList.remove('text-gray-500');
                nextText.classList.add('text-gray-700');
                if (nextSpinner) nextSpinner.style.display = 'block';
            }
        }
    </script>
</x-app-layout>