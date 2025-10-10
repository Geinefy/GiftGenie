<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Gift Suggestions</h1>
        <p class="text-gray-600">
            Browse personalized gift recommendations or use the chat to refine your search
        </p>
    </div>
    
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">Gift Suggestions</h2>
            <select class="border border-gray-300 rounded-md px-3 py-2" id="sortSelect">
                <option value="relevance">Relevance</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="giftsGrid">
            @foreach($gifts as $gift)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow gift-card" 
                     data-price="{{ is_array($gift) ? $gift['price'] : $gift->price }}">
                    <img src="{{ is_array($gift) ? $gift['image_url'] : $gift->image_url }}" 
                         alt="{{ is_array($gift) ? $gift['name'] : $gift->name }}" 
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">{{ is_array($gift) ? $gift['name'] : $gift->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ is_array($gift) ? $gift['description'] : $gift->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">${{ number_format(is_array($gift) ? $gift['price'] : $gift->price, 2) }}</span>
                            <a href="{{ is_array($gift) ? $gift['product_url'] : $gift->product_url }}" 
                               class="gg-primary-gradient text-white px-4 py-2 rounded-md text-sm transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(empty($gifts))
            <div class="text-center py-12">
                <p class="text-gray-500">No gifts found. Start chatting to get personalized suggestions!</p>
            </div>
        @endif
    </div>
</div>

<script>
document.getElementById('sortSelect').addEventListener('change', function() {
    const sortBy = this.value;
    const grid = document.getElementById('giftsGrid');
    const cards = Array.from(grid.children);
    
    cards.sort((a, b) => {
        const priceA = parseFloat(a.dataset.price);
        const priceB = parseFloat(b.dataset.price);
        
        switch(sortBy) {
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
</script>
</x-app-layout>
