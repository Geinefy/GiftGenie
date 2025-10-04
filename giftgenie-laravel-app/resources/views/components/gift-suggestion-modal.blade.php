<!-- Floating Button -->
<div class="fixed bottom-6 right-6 z-50">
    <button id="giftSuggestionBtn" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-full p-4 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
        </svg>
    </button>
</div>

<!-- Modal -->
<div id="giftSuggestionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-2 md:top-10 mx-auto p-3 md:p-5 border w-full max-w-6xl shadow-lg rounded-md bg-white min-h-screen md:min-h-0">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b">
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
                <form id="giftSuggestionForm" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Recipient -->
                        <div>
                            <label for="recipient" class="block text-sm font-medium text-gray-700 mb-2">
                                Who is this gift for?
                            </label>
                            <select id="recipient" name="recipient" class="w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select recipient</option>
                                <option value="friend">Friend</option>
                                <option value="mother">Mother</option>
                                <option value="father">Father</option>
                                <option value="sibling">Sibling</option>
                                <option value="colleague">Colleague</option>
                                <option value="partner">Partner</option>
                                <option value="couple">Couple</option>
                            </select>
                        </div>

                        <!-- Occasion -->
                        <div>
                            <label for="occasion" class="block text-sm font-medium text-gray-700 mb-2">
                                What's the occasion?
                            </label>
                            <select id="occasion" name="occasion" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select occasion</option>
                                <option value="birthday">Birthday</option>
                                <option value="graduation">Graduation</option>
                                <option value="wedding">Wedding</option>
                                <option value="mothers day">Mother's Day</option>
                                <option value="fathers day">Father's Day</option>
                                <option value="promotion">Promotion</option>
                                <option value="work anniversary">Work Anniversary</option>
                                <option value="thank you">Thank You</option>
                                <option value="new year">New Year</option>
                                <option value="festival">Festival</option>
                            </select>
                        </div>

                        <!-- Budget Range -->
                        <div>
                            <label for="min_budget" class="block text-sm font-medium text-gray-700 mb-2">
                                Minimum Budget ($)
                            </label>
                            <input type="number" id="min_budget" name="min_budget" min="0" step="0.01" class="w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="max_budget" class="block text-sm font-medium text-gray-700 mb-2">
                                Maximum Budget ($)
                            </label>
                            <input type="number" id="max_budget" name="max_budget" min="0" step="0.01" class="w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Country -->
                        <div class="md:col-span-2">
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                Country
                            </label>
                            <select id="country" name="country" class="w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select country</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="USA">USA</option>
                                <option value="UK">UK</option>
                                <option value="India">India</option>
                                <option value="Canada">Canada</option>
                                <option value="Australia">Australia</option>
                            </select>
                        </div>
                        
                        <!-- Prompt / Custom Input for AI -->
                        <div class="md:col-span-2">
                            <label for="prompt" class="block text-sm font-medium text-gray-700 mb-2">
                                Prompt / Gift details (optional)
                            </label>
                            <textarea id="prompt" name="prompt" rows="3" placeholder="Describe the recipient, preferences, or a specific prompt for AI-driven scraping later" class="w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center pt-4">
                        <div class="flex gap-3">
                            <button type="submit" id="searchBtn" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-md font-medium transition-all duration-300">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Find Perfect Gifts
                            </span>
                            </button>

                            <!-- Save Chat / Favorite Chat Button -->
                            <button type="button" id="saveChatBtn" title="Save this search/chat to Favorite Chats" class="bg-white border border-gray-300 text-gray-700 px-4 py-3 rounded-md hover:bg-gray-50 transition-all duration-200">
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
            <div class="w-full lg:w-80 border-t lg:border-t-0 lg:border-l pt-4 lg:pt-0 lg:pl-4">
                <!-- History Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold">Search History</h4>
                        <button id="clearHistoryBtn" class="text-sm text-red-600 hover:text-red-800">Clear All</button>
                    </div>
                    <div id="historyContainer" class="space-y-2 max-h-60 overflow-y-auto">
                        <!-- History items will be populated here -->
                    </div>
                </div>

                <!-- Favorite Gifts Section (was 'Favorites') -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold">Favorite Gifts</h4>
                        <button id="clearFavoritesBtn" class="text-sm text-red-600 hover:text-red-800">Clear All</button>
                    </div>
                    <div id="favoritesContainer" class="space-y-2 max-h-60 overflow-y-auto">
                        <!-- Favorite gifts will be populated here -->
                    </div>
                </div>

                <!-- Favorite Chats Section -->
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold">Favorite Chats</h4>
                        <button id="clearFavoriteChatsBtn" class="text-sm text-red-600 hover:text-red-800">Clear All</button>
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

    const FAVORITE_CHATS_KEY = 'giftgenie:favoriteChats';

    // Open modal
    btn.onclick = function() {
        modal.classList.remove('hidden');
        loadHistory();
        loadFavorites();
        loadFavoriteChats();
    }

    // Close modal
    closeModal.onclick = function() {
        modal.classList.add('hidden');
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
            suggestions.forEach(gift => {
                const giftCard = createGiftCard(gift);
                suggestionsGrid.appendChild(giftCard);
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
                <button onclick="toggleFavorite(${gift.id})" class="absolute top-2 right-2 p-1 bg-white rounded-full shadow-md hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <button onclick="removeFromFavorites(${gift.id})" class="text-red-500 hover:text-red-700 ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
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
        loadBtn.className = 'text-sm text-blue-600 hover:underline';
        loadBtn.innerText = 'Load';
        loadBtn.onclick = function() {
            document.getElementById('recipient').value = chat.recipient;
            document.getElementById('occasion').value = chat.occasion;
            document.getElementById('min_budget').value = chat.min_budget;
            document.getElementById('max_budget').value = chat.max_budget;
            document.getElementById('country').value = chat.country;
            document.getElementById('prompt').value = chat.prompt || '';
        };

        const delBtn = document.createElement('button');
        delBtn.className = 'text-sm text-red-600 hover:underline';
        delBtn.innerText = 'Delete';
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

    // Global functions for favorites
    window.toggleFavorite = function(giftId) {
        fetch('/api/favorites', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ gift_id: giftId })
        })
        .then(() => loadFavorites())
        .catch(error => console.error('Error adding to favorites:', error));
    };

    window.removeFromFavorites = function(giftId) {
        fetch(`/api/favorites/${giftId}`, { method: 'DELETE' })
        .then(() => loadFavorites())
        .catch(error => console.error('Error removing from favorites:', error));
    };

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