<!-- Floating Button -->
<div class="fixed bottom-6 right-6 z-50">
    <button id="giftSuggestionBtn" class="gg-primary-gradient text-white rounded-full p-4 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
        </svg>
    </button>
</div>

<!-- Modal -->
<div id="giftSuggestionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-2 md:top-10 mx-auto p-3 md:p-5 border w-full max-w-6xl shadow-lg rounded-md bg-white min-h-screen md:min-h-0 gg-modal">
    <!-- Modal Header -->
    <div class="flex items-center justify-between pb-4 border-b gg-sep">
            <h3 class="text-xl font-semibold text-gray-900">
                🎁 Find Perfect Gifts
            </h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">
                &times;
            </button>
        </div>

        <!-- Modal Body -->
        <div class="flex flex-col lg:flex-row">
            <!-- Main Form Area -->
            <div class="flex-1 p-2 md:p-4">
                <!-- Gift Suggestion Form -->
                <form id="giftSuggestionForm" class="space-y-6">
                    @csrf
                    
                    <!-- Large Text Input -->
                    <div class="mb-6">
                        <textarea id="aiPrompt" name="prompt"
                            placeholder="Describe who you're shopping for... (e.g., 'My tech-savvy brother who loves gaming and gadgets, budget around $50-100')"
                            class="w-full h-32 p-4 border-2 border-gray-200 rounded-xl resize-none text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                            maxlength="500"></textarea>
                        <div class="text-right mt-2">
                            <span class="text-sm text-gray-400" id="charCount">0/500</span>
                        </div>
                    </div>

                    <!-- Find Gifts Button -->
                    <div class="text-center mb-8">
                        <button type="submit" id="searchBtn"
                            class="gg-primary-gradient font-semibold px-12 py-4 rounded-xl text-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
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
                    <div class="text-center mb-6">
                        <button type="button" id="toggleOptions"
                            class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 font-medium flex items-center justify-center mx-auto transition-colors cursor-pointer">
                            <span class="mr-2">Want to be more specific? Select from below options</span>
                            <svg id="toggleIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Collapsible Additional Options -->
                    <div id="additionalOptions" class="hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Budget Range -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Budget Range</label>
                                <select name="budget"
                                    class="w-full p-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Occasion</label>
                                <select name="occasion"
                                    class="w-full p-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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

                        <!-- Save Chat Button in Additional Options -->
                        <div class="flex justify-center pt-4">
                            <button type="button" id="saveChatBtn" title="Save this search/chat to Favorite Chats" class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.966a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.967c.3.922-.755 1.688-1.54 1.118L10 13.348l-3.952 2.874c-.784.57-1.84-.196-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2.05 9.393c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69L9.05 2.927z"/>
                                    </svg>
                                    Save Chat
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Loading State -->
                <div id="loadingState" class="hidden text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-gray-600">Finding perfect gifts for you...</p>
                </div>

                <!-- Suggestions Results -->
                <div id="suggestionsContainer" class="hidden mt-6">
                    <h4 class="text-lg font-semibold mb-4">Gift Suggestions</h4>
                    <div id="suggestionsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Suggestions will be populated here -->
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-80 border-t lg:border-t-0 lg:border-l pt-6 lg:pt-0 lg:pl-4 lg:m-2 gg-sep">
                <!-- History Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold">Search History</h4>
                        <button id="clearHistoryBtn" class="text-sm text-gray-400 hover:text-gray-200">🗑️ Clear All</button>
                    </div>
                    <div id="historyContainer" class="space-y-2 max-h-60 overflow-y-auto mt-3">
                        <!-- History items will be populated here -->
                    </div>
                </div>

                <!-- Favorite Gifts Section (was 'Favorites') -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold">Favorite Gifts</h4>
                        <button id="clearFavoritesBtn" class="text-sm text-gray-400 hover:text-gray-200">🗑️ Clear All</button>
                    </div>
                    <div id="favoritesContainer" class="space-y-2 max-h-60 overflow-y-auto">
                        <!-- Favorite gifts will be populated here -->
                    </div>
                </div>

                <!-- Favorite Chats Section -->
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold">Favorite Chats</h4>
                        <button id="clearFavoriteChatsBtn" class="text-sm text-gray-400 hover:text-gray-200">🗑️ Clear All</button>
                    </div>
                    <div id="favoriteChatsContainer" class="space-y-2 max-h-60 overflow-y-auto">
                        <!-- Favorite chats will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Define global functions first to prevent "not defined" errors
    window.toggleFavorite = function(giftId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        fetch('/api/favorites', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ gift_id: giftId })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Favorite toggled:', data);
            // Reload favorites if we're in the favorites tab
            if (document.getElementById('favoritesContainer')) {
                loadFavorites();
            }
        })
        .catch(error => {
            console.error('Error toggling favorite:', error);
        });
    };

    window.removeFromFavorites = function(giftId) {
        fetch(`/api/favorites/${giftId}`, { 
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(() => {
            if (document.getElementById('favoritesContainer')) {
                loadFavorites();
            }
        })
        .catch(error => console.error('Error removing from favorites:', error));
    };
    
    const modal = document.getElementById('giftSuggestionModal');
    const btn = document.getElementById('giftSuggestionBtn');
    const closeModal = document.getElementById('closeModal');
    const form = document.getElementById('giftSuggestionForm');
    const loadingState = document.getElementById('loadingState');
    const suggestionsContainer = document.getElementById('suggestionsContainer');
    const suggestionsGrid = document.getElementById('suggestionsGrid');
    const historyContainer = document.getElementById('historyContainer');
    const favoritesContainer = document.getElementById('favoritesContainer');
    const favoriteChatsContainer = document.getElementById('favoriteChatsContainer');
    const saveChatBtn = document.getElementById('saveChatBtn');
    const clearFavoriteChatsBtn = document.getElementById('clearFavoriteChatsBtn');
    const aiPrompt = document.getElementById('aiPrompt');
    const charCount = document.getElementById('charCount');

    const FAVORITE_CHATS_KEY = 'giftgenie:favoriteChats';

    // Character count functionality
    aiPrompt.addEventListener('input', function() {
        const currentLength = this.value.length;
        charCount.textContent = `${currentLength}/500`;
        
        // Change color if approaching limit
        if (currentLength > 450) {
            charCount.classList.add('text-red-500');
        } else if (currentLength > 400) {
            charCount.classList.add('text-yellow-500');
        } else {
            charCount.classList.remove('text-red-500', 'text-yellow-500');
        }
    });

    // Simple direct toggle functionality - avoid complex setup
    function initializeModalToggle() {
        console.log('Initializing modal toggle...');
        
        // Use querySelector to be more specific and avoid conflicts
        const modal = document.getElementById('giftSuggestionModal');
        if (!modal) {
            console.error('Modal not found');
            return;
        }
        
        const toggleBtn = modal.querySelector('#toggleOptions');
        const additionalOpts = modal.querySelector('#additionalOptions');
        const toggleIcn = modal.querySelector('#toggleIcon');
        
        console.log('Modal toggle elements:', {
            toggleBtn: !!toggleBtn,
            additionalOpts: !!additionalOpts,
            toggleIcn: !!toggleIcn
        });
        
        if (toggleBtn && additionalOpts && toggleIcn) {
            // Remove any existing onclick
            toggleBtn.onclick = null;
            
            // Add the click handler directly
            toggleBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('Modal toggle clicked');
                const isHidden = additionalOpts.classList.contains('hidden');
                
                if (isHidden) {
                    additionalOpts.classList.remove('hidden');
                    toggleIcn.style.transform = 'rotate(180deg)';
                    console.log('Modal options opened');
                } else {
                    additionalOpts.classList.add('hidden');
                    toggleIcn.style.transform = 'rotate(0deg)';
                    console.log('Modal options closed');
                }
            };
            
            console.log('Modal toggle initialized successfully');
            return true;
        } else {
            console.error('Modal toggle elements not found');
            return false;
        }
    }
    
    // Open modal with subtle animation
    btn.onclick = function() {
        console.log('Opening gift suggestion modal...');
        modal.classList.remove('hidden');
        const content = modal.querySelector('.relative');
        if (content) {
            content.classList.add('gg-modal');
            // force reflow then open
            void content.offsetWidth;
            content.classList.add('gg-modal-open');
        }
        
        // Initialize toggle immediately after modal is shown
        setTimeout(() => {
            initializeModalToggle();
        }, 100);
        
        loadHistory();
        loadFavorites();
        loadFavoriteChats();
    }

    // Close modal with reverse animation
    closeModal.onclick = function() {
        const content = modal.querySelector('.relative');
        if (content) {
            content.classList.remove('gg-modal-open');
            setTimeout(() => { modal.classList.add('hidden'); }, 240);
        } else {
            modal.classList.add('hidden');
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }

    // Form submission
    form.onsubmit = function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = {
            recipient: formData.get('recipient'),
            occasion: formData.get('occasion'),
            min_budget: formData.get('min_budget'),
            max_budget: formData.get('max_budget'),
            country: formData.get('country'),
            prompt: formData.get('prompt'),
            _token: formData.get('_token')
        };

        // Show loading state
        loadingState.classList.remove('hidden');
        suggestionsContainer.classList.add('hidden');

        // Make API request
        fetch('/api/gift-suggestions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            loadingState.classList.add('hidden');
            
            if (result.success) {
                displaySuggestions(result.suggestions);
                loadHistory(); // Refresh history
            } else {
                alert('Error fetching suggestions. Please try again.');
            }
        })
        .catch(error => {
            loadingState.classList.add('hidden');
            console.error('Error:', error);
            alert('Error fetching suggestions. Please try again.');
        });
    };

    // Save Chat to Favorite Chats (localStorage)
    saveChatBtn.onclick = function() {
        const formData = new FormData(form);
        const chat = {
            recipient: formData.get('recipient') || '',
            occasion: formData.get('occasion') || '',
            min_budget: formData.get('min_budget') || '',
            max_budget: formData.get('max_budget') || '',
            country: formData.get('country') || '',
            prompt: formData.get('prompt') || '',
            timestamp: new Date().toISOString()
        };

        const chats = JSON.parse(localStorage.getItem(FAVORITE_CHATS_KEY) || '[]');
        chats.unshift(chat); // newest first
        localStorage.setItem(FAVORITE_CHATS_KEY, JSON.stringify(chats));
        loadFavoriteChats();
        // small feedback
        saveChatBtn.innerText = 'Saved';
        setTimeout(() => { saveChatBtn.innerHTML = '<span class="flex items-center">\n                                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">\n                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.966a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.967c.3.922-.755 1.688-1.54 1.118L10 13.348l-3.952 2.874c-.784.57-1.84-.196-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2.05 9.393c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69L9.05 2.927z"/>\n                                    </svg>\n                                    Save Chat\n                                </span>'; }, 1200);
    };

    // Display suggestions
    function displaySuggestions(suggestions) {
        suggestionsGrid.innerHTML = '';
        
        if (!suggestions || suggestions.length === 0) {
            suggestionsGrid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No gifts found matching your criteria. Try adjusting your filters.</div>';
        } else {
            suggestions.forEach((gift, i) => {
                const giftCard = createGiftCard(gift);
                suggestionsGrid.appendChild(giftCard);
                // Add animation classes after append so animation runs
                requestAnimationFrame(() => {
                    giftCard.classList.add('gg-elevate', 'gg-appear', 'gg-appear-delay-' + ((i % 3) + 1));
                });
            });
        }
        
        suggestionsContainer.classList.remove('hidden');
    }

    // Create gift card element
    function createGiftCard(gift) {
    const card = document.createElement('div');
    card.className = 'bg-white border rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300';
        
        card.innerHTML = `
            <div class="relative">
                ${gift.image_url ? `<img src="${gift.image_url}" alt="${gift.name}" class="w-full h-32 object-cover">` : '<div class="w-full h-32 bg-gray-200 flex items-center justify-center text-gray-500">No Image</div>'}
                <button onclick="toggleFavorite(${gift.id})" class="absolute top-2 right-2 p-1 rounded-full shadow-md transition-colors duration-200 bg-transparent hover:bg-gray-100 dark:hover:bg-opacity-10">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <h5 class="font-semibold text-gray-900 mb-2">${gift.name}</h5>
                <p class="text-sm text-gray-600 mb-2">${gift.description}</p>
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-blue-600">$${gift.min_price} - $${gift.max_price}</span>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">${gift.category}</span>
                </div>
            </div>
        `;
        
        return card;
    }

    // Load search history
    function loadHistory() {
        fetch('/api/search-history')
        .then(response => response.json())
        .then(result => {
            historyContainer.innerHTML = '';
            
            if (!result.history || result.history.length === 0) {
                historyContainer.innerHTML = '<div class="text-sm text-gray-500 text-center py-4">No search history</div>';
            } else {
                result.history.forEach(search => {
                    const historyItem = createHistoryItem(search);
                    historyContainer.appendChild(historyItem);
                });
            }
        })
        .catch(error => console.error('Error loading history:', error));
    }

    // Create history item
    function createHistoryItem(search) {
        const item = document.createElement('div');
        item.className = 'bg-gray-50 p-3 rounded-md cursor-pointer hover:bg-gray-100 transition-colors duration-200';
        
        item.innerHTML = `
            <div class="text-sm">
                <div class="font-medium">${search.recipient} • ${search.occasion}</div>
                <div class="text-gray-600">$${search.min_budget} - $${search.max_budget} • ${search.country}</div>
                <div class="text-xs text-gray-500">${new Date(search.timestamp).toLocaleDateString()}</div>
            </div>
        `;
        
        item.onclick = function() {
            // Fill form with history data
            document.getElementById('recipient').value = search.recipient;
            document.getElementById('occasion').value = search.occasion;
            document.getElementById('min_budget').value = search.min_budget;
            document.getElementById('max_budget').value = search.max_budget;
            document.getElementById('country').value = search.country;
            if (search.prompt) {
                document.getElementById('prompt').value = search.prompt;
            }
        };
        
        return item;
    }

    // Load favorites
    function loadFavorites() {
        fetch('/api/favorites')
        .then(response => response.json())
        .then(result => {
            favoritesContainer.innerHTML = '';
            
            if (!result.favorites || result.favorites.length === 0) {
                favoritesContainer.innerHTML = '<div class="text-sm text-gray-500 text-center py-4">No favorites yet</div>';
            } else {
                result.favorites.forEach(gift => {
                    const favoriteItem = createFavoriteItem(gift);
                    favoritesContainer.appendChild(favoriteItem);
                });
            }
        })
        .catch(error => console.error('Error loading favorites:', error));
    }

    // Create favorite item
    function createFavoriteItem(gift) {
        const item = document.createElement('div');
        item.className = 'bg-gray-50 p-3 rounded-md';
        
        item.innerHTML = `
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="font-medium text-sm">${gift.name}</div>
                    <div class="text-xs text-gray-600">$${gift.min_price} - $${gift.max_price}</div>
                </div>
                <button onclick="removeFromFavorites(${gift.id})" class="ml-2 text-gray-400 hover:text-gray-200" title="Remove">
                    🗑️
                </button>
            </div>
        `;
        
        return item;
    }

    // Favorite Chats: load from localStorage
    function loadFavoriteChats() {
        const chats = JSON.parse(localStorage.getItem(FAVORITE_CHATS_KEY) || '[]');
        favoriteChatsContainer.innerHTML = '';

        if (!chats || chats.length === 0) {
            favoriteChatsContainer.innerHTML = '<div class="text-sm text-gray-500 text-center py-4">No favorite chats yet</div>';
            return;
        }

        chats.forEach((chat, idx) => {
            const node = createFavoriteChatItem(chat, idx);
            favoriteChatsContainer.appendChild(node);
        });
    }

    function createFavoriteChatItem(chat, index) {
        const item = document.createElement('div');
        item.className = 'bg-gray-50 p-3 rounded-md flex items-start justify-between gap-2';

        const title = (chat.recipient || chat.occasion) ? `${chat.recipient || ''} ${chat.occasion ? '• ' + chat.occasion : ''}` : (chat.prompt ? chat.prompt.slice(0, 50) + (chat.prompt.length>50? '...':'') : 'Saved Chat');

        const left = document.createElement('div');
        left.className = 'flex-1';
        left.innerHTML = `<div class="font-medium text-sm">${escapeHtml(title)}</div><div class="text-xs text-gray-600">${chat.prompt ? escapeHtml(chat.prompt.slice(0,80)) : ''}</div>`;

        const actions = document.createElement('div');
        actions.className = 'flex flex-col items-end gap-2';

        const loadBtn = document.createElement('button');
        loadBtn.className = 'p-1 rounded-md text-blue-600 hover:bg-blue-50 dark:hover:bg-opacity-10';
        loadBtn.title = 'Load';
        loadBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M12 3l9 9-9 9"/></svg>`;
        loadBtn.onclick = function() {
            document.getElementById('recipient').value = chat.recipient;
            document.getElementById('occasion').value = chat.occasion;
            document.getElementById('min_budget').value = chat.min_budget;
            document.getElementById('max_budget').value = chat.max_budget;
            document.getElementById('country').value = chat.country;
            document.getElementById('prompt').value = chat.prompt || '';
        };

    const delBtn = document.createElement('button');
    delBtn.className = 'p-1 rounded-md text-gray-400 hover:bg-gray-100 dark:hover:bg-opacity-10';
    delBtn.title = 'Delete';
    delBtn.innerHTML = '🗑️';
        delBtn.onclick = function() {
            if (!confirm('Delete this favorite chat?')) return;
            const chats = JSON.parse(localStorage.getItem(FAVORITE_CHATS_KEY) || '[]');
            chats.splice(index, 1);
            localStorage.setItem(FAVORITE_CHATS_KEY, JSON.stringify(chats));
            loadFavoriteChats();
        };

        actions.appendChild(loadBtn);
        actions.appendChild(delBtn);

        item.appendChild(left);
        item.appendChild(actions);

        return item;
    }

    // Clear history
    document.getElementById('clearHistoryBtn').onclick = function() {
        if (confirm('Are you sure you want to clear search history?')) {
            fetch('/api/search-history', { method: 'DELETE' })
            .then(() => loadHistory())
            .catch(error => console.error('Error clearing history:', error));
        }
    };

    // Clear favorites
    document.getElementById('clearFavoritesBtn').onclick = function() {
        if (confirm('Are you sure you want to clear all favorites?')) {
            fetch('/api/favorites', { method: 'DELETE' })
            .then(() => loadFavorites())
            .catch(error => console.error('Error clearing favorites:', error));
        }
    };

    // Clear favorite chats (localStorage)
    clearFavoriteChatsBtn.onclick = function() {
        if (!confirm('Clear all favorite chats?')) return;
        localStorage.removeItem(FAVORITE_CHATS_KEY);
        loadFavoriteChats();
    };

    // Global functions are now defined at the top of the script

    // small helper to escape HTML when injecting text
    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe.replace(/[&<>"'`]/g, function(m) {
            return ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;',
                '`': '&#96;'
            })[m];
        });
    }
});
</script>