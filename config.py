"""
Configuration settings for the Gift Suggestion App
"""

import os

class Config:
    """Base configuration class."""
    SECRET_KEY = os.environ.get('SECRET_KEY') or 'your-secret-key-change-in-production'
    # Use in-memory database for temporary session storage
    DATABASE_PATH = ':memory:'  # SQLite in-memory database
    
    # Google Gemini API settings (disabled for now)
    GEMINI_API_KEY = None  # Disabled - using web scraping only
    GEMINI_MODEL = 'gemini-1.5-flash'
    
    # Web scraping settings
    SCRAPING_DELAY = 2  # Delay between requests in seconds (increased for respect)
    MAX_RESULTS_PER_SEARCH = 15
    REQUEST_TIMEOUT = 15
    CACHE_REFRESH_INTERVAL = 1800  # 30 minutes in seconds
    MIN_PRODUCTS_THRESHOLD = 5  # Minimum products before refresh
    
    # Recommendation settings
    TFIDF_MAX_FEATURES = 5000
    TFIDF_NGRAM_RANGE = (1, 2)
    SIMILARITY_THRESHOLD = 0.1
    
    # Pagination settings
    PRODUCTS_PER_PAGE = 12
    
    # Rate limiting
    RATE_LIMIT_PER_MINUTE = 60
    
    # Country-specific e-commerce sites (focused on Bangladesh)
    COUNTRY_SITES = {
        'Bangladesh': {
            'primary': ['daraz.com.bd', 'pickaboo.com', 'ajkerdeal.com', 'rokomari.com'],
            'secondary': ['bagdoom.com', 'othoba.com', 'kaymu.com.bd', 'bikroy.com']
        },
        'US': {
            'primary': ['amazon.com', 'ebay.com', 'walmart.com'],
            'secondary': ['target.com', 'bestbuy.com']
        },
        'India': {
            'primary': ['amazon.in', 'flipkart.com', 'snapdeal.com'],
            'secondary': ['myntra.com', 'nykaa.com']
        }
    }
    
    # Bangladeshi site-specific scraping rules
    BD_SCRAPING_RULES = {
        'daraz.com.bd': {
            'search_url': 'https://www.daraz.com.bd/catalog/?q={query}',
            'product_selector': '.c2prKC',
            'title_selector': '.c16H9d',
            'price_selector': '.c13VH6',
            'image_selector': '.c1ZEkC img',
            'link_selector': 'a'
        },
        'pickaboo.com': {
            'search_url': 'https://www.pickaboo.com/search?q={query}',
            'product_selector': '.product-item',
            'title_selector': '.product-title',
            'price_selector': '.price',
            'image_selector': '.product-image img',
            'link_selector': 'a'
        }
    }

class DevelopmentConfig(Config):
    """Development configuration."""
    DEBUG = True
    
class ProductionConfig(Config):
    """Production configuration."""
    DEBUG = False
    
# Default configuration
config = {
    'development': DevelopmentConfig,
    'production': ProductionConfig,
    'default': DevelopmentConfig
}