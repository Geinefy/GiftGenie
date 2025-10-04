"""
Simple tests for the Gift Suggestion App
"""

import unittest
import json
import sys
import os

# Add the parent directory to the path so we can import our modules
sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

from app import app
from recommendation_engine import RecommendationEngine
from scrapers.product_scraper import ProductScraper

class TestGiftSuggestionApp(unittest.TestCase):
    """Test cases for the Gift Suggestion App."""
    
    def setUp(self):
        """Set up test fixtures."""
        app.config['TESTING'] = True
        self.client = app.test_client()
        self.recommendation_engine = RecommendationEngine()
        self.scraper = ProductScraper()
    
    def test_home_page(self):
        """Test that the home page loads successfully."""
        response = self.client.get('/')
        self.assertEqual(response.status_code, 200)
        self.assertIn(b'Gift Finder', response.data)
    
    def test_health_endpoint(self):
        """Test the health check endpoint."""
        response = self.client.get('/health')
        self.assertEqual(response.status_code, 200)
        data = json.loads(response.data)
        self.assertEqual(data['status'], 'healthy')
    
    def test_search_endpoint_empty_query(self):
        """Test search endpoint with empty query."""
        response = self.client.post('/search', 
            json={
                'query': '',
                'occasion': '',
                'interests': ''
            })
        self.assertEqual(response.status_code, 400)
    
    def test_search_endpoint_valid_query(self):
        """Test search endpoint with valid query."""
        response = self.client.post('/search',
            json={
                'query': 'headphones',
                'occasion': '',
                'interests': 'music'
            })
        self.assertEqual(response.status_code, 200)
        data = json.loads(response.data)
        self.assertIn('products', data)
        self.assertIn('total', data)
    
    def test_recommendation_engine(self):
        """Test the recommendation engine."""
        products = [
            {
                'title': 'Wireless Headphones',
                'description': 'Great for music lovers',
                'price': 79.99,
                'category': 'Electronics',
                'keywords': 'wireless headphones music audio'
            },
            {
                'title': 'Coffee Maker',
                'description': 'Perfect for coffee enthusiasts',
                'price': 129.99,
                'category': 'Kitchen',
                'keywords': 'coffee maker brewing kitchen'
            }
        ]
        
        recommendations = self.recommendation_engine.get_recommendations(
            products, 'wireless headphones music'
        )
        
        self.assertGreater(len(recommendations), 0)
        self.assertIn('relevance_score', recommendations[0])
        self.assertIn('match_reason', recommendations[0])
    
    def test_price_filtering(self):
        """Test price filtering functionality."""
        products = [
            {'title': 'Cheap Item', 'price': 10.99},
            {'title': 'Medium Item', 'price': 50.99},
            {'title': 'Expensive Item', 'price': 200.99}
        ]
        
        filtered = self.recommendation_engine.apply_price_filter(
            products, min_price=20.0, max_price=100.0
        )
        
        self.assertEqual(len(filtered), 1)
        self.assertEqual(filtered[0]['title'], 'Medium Item')
    
    def test_sample_data_loading(self):
        """Test that sample data can be loaded."""
        sample_data = self.scraper.load_sample_data()
        self.assertGreater(len(sample_data), 0)
        
        # Check required fields
        for product in sample_data:
            self.assertIn('title', product)
            self.assertIn('price', product)
            self.assertIn('category', product)
    
    def test_text_preprocessing(self):
        """Test text preprocessing functionality."""
        raw_text = "This is a TEST with Special!@# Characters and   Extra Spaces"
        processed = self.recommendation_engine.preprocess_text(raw_text)
        
        self.assertNotIn('!@#', processed)
        self.assertNotIn('  ', processed)  # No double spaces
        self.assertEqual(processed, processed.lower())


class TestProductScraper(unittest.TestCase):
    """Test cases for the Product Scraper."""
    
    def setUp(self):
        """Set up test fixtures."""
        self.scraper = ProductScraper()
    
    def test_price_extraction(self):
        """Test price extraction from text."""
        test_cases = [
            ('$79.99', 79.99),
            ('Price: $129.00', 129.00),
            ('€45.50', 45.50),
            ('No price', 0.0),
            ('', 0.0)
        ]
        
        for text, expected in test_cases:
            result = self.scraper.extract_price(text)
            self.assertEqual(result, expected)
    
    def test_text_cleaning(self):
        """Test text cleaning functionality."""
        dirty_text = "  This   has\n\n  extra   whitespace  "
        clean_text = self.scraper.clean_text(dirty_text)
        
        self.assertEqual(clean_text, "This has extra whitespace")


if __name__ == '__main__':
    # Create a simple test runner
    print("Running Gift Suggestion App Tests...")
    print("=" * 50)
    
    unittest.main(verbosity=2)