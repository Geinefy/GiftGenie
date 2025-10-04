// Gift Suggestion App JavaScript

class GiftSuggestionApp {
    constructor() {
        this.currentPage = 1;
        this.hasMore = false;
        this.currentQuery = null;
        this.initEventListeners();
    }

    initEventListeners() {
        // Search form submission
        const searchForm = document.getElementById('searchForm');
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            this.performSearch();
        });

        // Sample search tags
        const sampleTags = document.querySelectorAll('.sample-tag');
        sampleTags.forEach(tag => {
            tag.addEventListener('click', () => {
                const query = tag.getAttribute('data-query');
                document.getElementById('query').value = query;
                this.performSearch();
            });
        });

        // Pagination buttons
        document.getElementById('prevBtn').addEventListener('click', () => {
            this.changePage(-1);
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            this.changePage(1);
        });

        // Removed scrape button - using live scraping automatically

        // Price range validation
        const minPriceInput = document.getElementById('minPrice');
        const maxPriceInput = document.getElementById('maxPrice');
        
        minPriceInput.addEventListener('input', this.validatePriceRange);
        maxPriceInput.addEventListener('input', this.validatePriceRange);
    }

    validatePriceRange() {
        const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
        const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;
        
        if (minPrice > maxPrice && maxPrice !== Infinity) {
            document.getElementById('maxPrice').setCustomValidity('Max price must be greater than min price');
        } else {
            document.getElementById('maxPrice').setCustomValidity('');
        }
    }

    async performSearch(page = 1) {
        const formData = this.getFormData();
        
        // Validation
        if (!formData.query.trim() && !formData.occasion.trim() && !formData.interests.trim()) {
            this.showError('Please provide some search criteria');
            return;
        }

        // Show loading
        this.showLoading();
        this.hideError();
        this.hideResults();

        try {
            const response = await fetch('/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ...formData,
                    page: page
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }

            this.displayResults(data);
            this.currentQuery = formData;
            this.currentPage = page;
            
        } catch (error) {
            console.error('Search error:', error);
            this.showError(error.message || 'An error occurred while searching. Please try again.');
        } finally {
            this.hideLoading();
        }
    }

    getFormData() {
        return {
            query: document.getElementById('query').value.trim(),
            occasion: document.getElementById('occasion').value,
            interests: document.getElementById('interests').value.trim(),
            min_price: parseFloat(document.getElementById('minPrice').value) || null,
            max_price: parseFloat(document.getElementById('maxPrice').value) || null,
            country: document.getElementById('country').value
        };
    }

    displayResults(data) {
        const resultsSection = document.getElementById('results');
        const productsGrid = document.getElementById('productsGrid');
        const resultsTitle = document.getElementById('resultsTitle');
        const resultsCount = document.getElementById('resultsCount');
        const pagination = document.getElementById('pagination');

        // Clear previous results
        productsGrid.innerHTML = '';

        // Update results info
        resultsTitle.textContent = 'Gift Suggestions';
        resultsCount.textContent = `Found ${data.total} product${data.total !== 1 ? 's' : ''} matching your criteria`;

        if (data.products.length === 0) {
            productsGrid.innerHTML = `
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>No products found</h3>
                    <p>Try adjusting your search criteria or price range</p>
                </div>
            `;
        } else {
            // Display products
            data.products.forEach((product, index) => {
                const productCard = this.createProductCard(product, index);
                productsGrid.appendChild(productCard);
            });
        }

        // Update pagination
        this.updatePagination(data);

        // Show results
        this.showResults();
        
        // Scroll to results
        resultsSection.scrollIntoView({ behavior: 'smooth' });
    }

    createProductCard(product, index) {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.style.animationDelay = `${index * 0.1}s`;

        const price = product.price ? `$${product.price.toFixed(2)}` : 'Price not available';
        const relevanceScore = product.relevance_score ? (product.relevance_score * 100).toFixed(0) : 0;
        const matchReason = product.match_reason || 'Recommended based on your search criteria';

        card.innerHTML = `
            <div class="product-image">
                <img src="${product.image_url || '/static/placeholder-image.jpg'}" 
                     alt="${product.title}" 
                     onerror="this.src='/static/placeholder-image.jpg'">
                <div class="relevance-badge">${relevanceScore}% match</div>
            </div>
            <div class="product-content">
                <h3 class="product-title">${this.escapeHtml(product.title)}</h3>
                <p class="product-description">${this.escapeHtml(product.description || 'No description available')}</p>
                <div class="product-price">${price}</div>
                <span class="product-category">${this.escapeHtml(product.category || 'General')}</span>
                <div class="match-reason">
                    <i class="fas fa-lightbulb"></i>
                    ${this.escapeHtml(matchReason)}
                </div>
                <a href="${product.source_url || '#'}" class="product-link" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-external-link-alt"></i>
                    View Product
                </a>
            </div>
        `;

        return card;
    }

    updatePagination(data) {
        const pagination = document.getElementById('pagination');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const pageInfo = document.getElementById('pageInfo');

        if (data.total > data.per_page) {
            pagination.classList.remove('hidden');
            
            // Update buttons
            prevBtn.disabled = data.page <= 1;
            nextBtn.disabled = !data.has_more;
            
            // Update page info
            const totalPages = Math.ceil(data.total / data.per_page);
            pageInfo.textContent = `Page ${data.page} of ${totalPages}`;
            
            this.hasMore = data.has_more;
        } else {
            pagination.classList.add('hidden');
        }
    }

    changePage(direction) {
        const newPage = this.currentPage + direction;
        if (newPage >= 1) {
            this.performSearch(newPage);
        }
    }

    // Removed scrapeNewProducts method - using live scraping automatically

    showLoading() {
        document.getElementById('loading').classList.remove('hidden');
    }

    hideLoading() {
        document.getElementById('loading').classList.add('hidden');
    }

    showResults() {
        document.getElementById('results').classList.remove('hidden');
    }

    hideResults() {
        document.getElementById('results').classList.add('hidden');
    }

    showError(message) {
        const errorElement = document.getElementById('errorMessage');
        errorElement.querySelector('p').textContent = message;
        errorElement.classList.remove('hidden');
    }

    hideError() {
        document.getElementById('errorMessage').classList.add('hidden');
    }

    showSuccessMessage(message) {
        // Create success message element if it doesn't exist
        let successElement = document.getElementById('successMessage');
        if (!successElement) {
            successElement = document.createElement('div');
            successElement.id = 'successMessage';
            successElement.className = 'success-message hidden';
            successElement.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <p></p>
            `;
            document.getElementById('errorMessage').parentNode.insertBefore(successElement, document.getElementById('errorMessage'));
        }
        
        successElement.querySelector('p').textContent = message;
        successElement.classList.remove('hidden');
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
            successElement.classList.add('hidden');
        }, 3000);
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Utility functions
function formatPrice(price) {
    if (!price) return 'Price not available';
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
}

function truncateText(text, maxLength = 100) {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength) + '...';
}

// Initialize app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new GiftSuggestionApp();
    
    // Add some interactive effects
    addInteractiveEffects();
});

function addInteractiveEffects() {
    // Add hover effects to form inputs
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', () => {
            input.parentElement.classList.remove('focused');
        });
    });

    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.search-btn, .sample-tag');
    buttons.forEach(button => {
        button.addEventListener('click', createRipple);
    });
}

function createRipple(event) {
    const button = event.currentTarget;
    const rect = button.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    const ripple = document.createElement('span');
    ripple.style.cssText = `
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        left: ${x}px;
        top: ${y}px;
        width: ${size}px;
        height: ${size}px;
        pointer-events: none;
    `;
    
    // Add ripple animation keyframes if not already added
    if (!document.getElementById('ripple-styles')) {
        const style = document.createElement('style');
        style.id = 'ripple-styles';
        style.textContent = `
            @keyframes ripple-animation {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    button.style.position = 'relative';
    button.style.overflow = 'hidden';
    button.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 600);
}