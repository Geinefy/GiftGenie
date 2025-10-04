#!/usr/bin/env python3
"""
Gift/Product Suggestion Web App
A Flask web application that suggests products based on user requirements.
"""

from flask import Flask, render_template, request, jsonify
import sqlite3
import json
import re
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import numpy as np
from scrapers.product_scraper import ProductScraper
from recommendation_engine import RecommendationEngine
# from gemini_service import GeminiService  # Disabled for now
import os
import logging

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'

# Initialize components
scraper = ProductScraper()
recommendation_engine = RecommendationEngine()
# gemini_service = GeminiService()  # Disabled for now

def init_temp_database():
    """Initialize in-memory SQLite database for session-based caching."""
    conn = sqlite3.connect(':memory:')
    cursor = conn.cursor()
    
    cursor.execute('''
        CREATE TABLE products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT,
            price REAL,
            image_url TEXT,
            source_url TEXT,
            category TEXT,
            keywords TEXT,
            source TEXT,
            scraped_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ''')
    
    conn.commit()
    logger.info("In-memory database initialized successfully")
    return conn

# Database helper functions removed - using live scraping with session cache

@app.route('/')
def index():
    """Main page with search form."""
    return render_template('index.html')

@app.route('/search', methods=['POST'])
def search_products():
    """Search for products using live web scraping from Bangladeshi sites."""
    try:
        # Get user input
        user_input = request.json
        query = user_input.get('query', '').strip()
        min_price = user_input.get('min_price')
        max_price = user_input.get('max_price')
        occasion = user_input.get('occasion', '').strip()
        interests = user_input.get('interests', '').strip()
        country = user_input.get('country', 'Bangladesh').strip()  # Default to Bangladesh
        
        if not query and not occasion and not interests:
            return jsonify({'error': 'Please provide some search criteria'}), 400
        
        # Combine all search terms
        search_terms = f"{query} {occasion} {interests}".strip()
        
        logger.info(f"Live searching for: {search_terms} in {country}")
        
        # Perform live web scraping
        products = scraper.search_products_live(search_terms, country)
        
        if not products:
            logger.warning("No products found via scraping, using API fallback")
            # Fallback to API sources if scraping fails
            products = scraper._search_api_fallback(search_terms)
        
        # Get recommendations using the recommendation engine
        recommendations = recommendation_engine.get_recommendations(
            products, search_terms, min_price, max_price
        )
        
        # Filter out 0% matches (check both possible score field names)
        filtered_recommendations = [p for p in recommendations if p.get('relevance_score', p.get('similarity_score', 0)) > 0]
        
        # Limit results for pagination
        page = int(request.json.get('page', 1))
        per_page = 12
        start_idx = (page - 1) * per_page
        end_idx = start_idx + per_page
        
        paginated_results = filtered_recommendations[start_idx:end_idx]
        
        return jsonify({
            'products': paginated_results,
            'total': len(filtered_recommendations),
            'page': page,
            'per_page': per_page,
            'has_more': end_idx < len(filtered_recommendations)
        })
        
    except Exception as e:
        logger.error(f"Error searching products: {str(e)}")
        return jsonify({'error': 'An error occurred while searching for products'}), 500

# Removed scraping endpoint - using live scraping in search instead

# @app.route('/search-with-ai', methods=['POST'])
# def search_products_with_ai():
#     """Search for products using Gemini AI for idea generation (optional feature) - DISABLED."""
#     # This endpoint is currently disabled - using web scraping only
#     return jsonify({'error': 'AI search is currently disabled'}), 501

@app.route('/health')
def health_check():
    """Health check endpoint."""
    return jsonify({'status': 'healthy', 'message': 'Gift Suggestion App is running'})

if __name__ == '__main__':
    # Initialize in-memory database for this session
    db_conn = init_temp_database()
    logger.info("Starting Gift Suggestion App with live web scraping...")
    logger.info("Products will be fetched in real-time from Bangladeshi e-commerce sites")
    
    # Run the app
    app.run(debug=True, host='0.0.0.0', port=5000)