"""
Demo script for the Gift Suggestion App
This script demonstrates the basic functionality of the application.
"""

import sys
import os
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from recommendation_engine import RecommendationEngine
from scrapers.product_scraper import ProductScraper
from database import DatabaseManager

def demo_recommendation_engine():
    """Demonstrate the recommendation engine functionality."""
    print("🔍 Testing Recommendation Engine")
    print("=" * 40)
    
    engine = RecommendationEngine()
    scraper = ProductScraper()
    
    # Load sample products
    products = scraper.load_sample_data()
    print(f"Loaded {len(products)} sample products")
    
    # Test queries
    test_queries = [
        "wireless headphones for music",
        "fitness tracker health",
        "coffee gift birthday",
        "luxury kitchen gadgets",
        "tech gadgets under 100"
    ]
    
    for query in test_queries:
        print(f"\n🔎 Query: '{query}'")
        recommendations = engine.get_recommendations(products, query, max_results=3)
        
        for i, product in enumerate(recommendations[:3], 1):
            print(f"  {i}. {product['title']}")
            print(f"     Price: ${product['price']:.2f}")
            print(f"     Match: {product['relevance_score']:.3f}")
            print(f"     Reason: {product['match_reason']}")
            print()

def demo_database():
    """Demonstrate database functionality."""
    print("💾 Testing Database Operations")
    print("=" * 40)
    
    db = DatabaseManager()
    scraper = ProductScraper()
    
    # Initialize database
    db.init_database()
    print("Database initialized")
    
    # Load and insert sample data
    products = scraper.load_sample_data()
    db.insert_products(products)
    print(f"Inserted {len(products)} products")
    
    # Test queries
    print(f"Total products in database: {db.get_product_count()}")
    print(f"Available categories: {', '.join(db.get_categories())}")
    
    # Search products
    search_results = db.search_products("wireless")
    print(f"Found {len(search_results)} products matching 'wireless'")
    
    for product in search_results[:2]:
        print(f"  - {product['title']} (${product['price']:.2f})")

def demo_price_filtering():
    """Demonstrate price filtering."""
    print("💰 Testing Price Filtering")
    print("=" * 40)
    
    engine = RecommendationEngine()
    scraper = ProductScraper()
    products = scraper.load_sample_data()
    
    # Test different price ranges
    price_ranges = [
        (0, 50, "Under $50"),
        (50, 100, "$50 - $100"),
        (100, 200, "$100 - $200"),
        (200, None, "Over $200")
    ]
    
    for min_price, max_price, label in price_ranges:
        filtered = engine.apply_price_filter(products, min_price, max_price)
        print(f"{label}: {len(filtered)} products")
        
        for product in filtered[:2]:
            print(f"  - {product['title']} (${product['price']:.2f})")
        print()

def demo_similarity_calculation():
    """Demonstrate similarity calculation."""
    print("🎯 Testing Similarity Calculation")
    print("=" * 40)
    
    engine = RecommendationEngine()
    
    # Test products
    test_products = [
        {
            'title': 'Wireless Bluetooth Headphones',
            'description': 'High-quality audio experience with noise cancellation',
            'category': 'Electronics',
            'keywords': 'wireless bluetooth headphones music audio'
        },
        {
            'title': 'Coffee Maker Machine',
            'description': 'Perfect brewing for coffee enthusiasts',
            'category': 'Kitchen',
            'keywords': 'coffee maker brewing kitchen appliance'
        },
        {
            'title': 'Fitness Tracker Watch',
            'description': 'Health monitoring and activity tracking',
            'category': 'Electronics',
            'keywords': 'fitness tracker health watch sports'
        }
    ]
    
    queries = [
        "bluetooth headphones music",
        "coffee brewing machine",
        "fitness health tracker"
    ]
    
    for query in queries:
        print(f"\nQuery: '{query}'")
        scores = engine.calculate_similarity_scores(test_products, query)
        
        for i, (product, score) in enumerate(zip(test_products, scores)):
            print(f"  {product['title']}: {score:.3f}")

def main():
    """Run all demos."""
    print("🎁 Gift Suggestion App Demo")
    print("=" * 50)
    print()
    
    try:
        demo_recommendation_engine()
        print("\n" + "=" * 50 + "\n")
        
        demo_database()
        print("\n" + "=" * 50 + "\n")
        
        demo_price_filtering()
        print("\n" + "=" * 50 + "\n")
        
        demo_similarity_calculation()
        
        print("\n✅ All demos completed successfully!")
        print("\nTo run the web application:")
        print("  python app.py")
        print("\nThen open: http://localhost:5000")
        
    except Exception as e:
        print(f"❌ Demo failed with error: {str(e)}")
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    main()