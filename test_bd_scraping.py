#!/usr/bin/env python3
"""
Test script for Bangladeshi e-commerce scraping functionality
"""

import sys
import os
sys.path.append(os.path.dirname(__file__))

from scrapers.product_scraper import ProductScraper
import logging

# Configure logging
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')
logger = logging.getLogger(__name__)

def test_bangladeshi_scraping():
    """Test scraping from Bangladeshi sites."""
    
    scraper = ProductScraper()
    
    test_queries = [
        "smartphone",
        "laptop",
        "shoes",
        "books",
        "gift"
    ]
    
    print("🇧🇩 Testing Bangladeshi E-commerce Scraping")
    print("=" * 50)
    
    for query in test_queries:
        print(f"\n🔍 Searching for: '{query}'")
        print("-" * 30)
        
        try:
            # Test live scraping
            products = scraper.search_products_live(query, country='Bangladesh')
            
            if products:
                print(f"✅ Found {len(products)} products")
                
                # Show first 2 products
                for i, product in enumerate(products[:2], 1):
                    print(f"\n{i}. {product['title']}")
                    print(f"   💰 Price: {product['price']}")
                    print(f"   🏪 Source: {product.get('source', 'Unknown')}")
                    print(f"   🔗 URL: {product.get('source_url', 'N/A')[:60]}...")
            else:
                print("❌ No products found")
                
        except Exception as e:
            print(f"❌ Error: {str(e)}")
    
    print("\n" + "=" * 50)
    print("Test completed!")

def test_cache_functionality():
    """Test session cache functionality."""
    
    scraper = ProductScraper()
    
    print("\n🔄 Testing Cache Functionality")
    print("=" * 50)
    
    query = "smartphone"
    
    # First search (should scrape)
    print(f"First search for '{query}' (should scrape)...")
    start_time = __import__('time').time()
    products1 = scraper.search_products_live(query, country='Bangladesh')
    time1 = __import__('time').time() - start_time
    print(f"⏱️  Time taken: {time1:.2f} seconds")
    print(f"📦 Products found: {len(products1)}")
    
    # Second search (should use cache)
    print(f"\nSecond search for '{query}' (should use cache)...")
    start_time = __import__('time').time()
    products2 = scraper.search_products_live(query, country='Bangladesh')
    time2 = __import__('time').time() - start_time
    print(f"⏱️  Time taken: {time2:.2f} seconds")
    print(f"📦 Products found: {len(products2)}")
    
    if time2 < time1 * 0.5:  # Cache should be much faster
        print("✅ Cache is working - second search was much faster!")
    else:
        print("⚠️  Cache might not be working as expected")

if __name__ == "__main__":
    try:
        test_bangladeshi_scraping()
        test_cache_functionality()
    except KeyboardInterrupt:
        print("\n🛑 Test interrupted by user")
    except Exception as e:
        print(f"\n💥 Unexpected error: {str(e)}")