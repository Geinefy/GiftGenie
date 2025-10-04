#!/usr/bin/env python3
"""Debug script to test search functionality."""

from app import get_products_from_db, recommendation_engine

def test_search():
    # Get products from database
    products = get_products_from_db()
    print(f"Found {len(products)} products in database")
    
    print("\nSample products:")
    for i, product in enumerate(products[:5]):
        print(f"{i+1}. {product.get('title', 'Unknown')}")
        print(f"   Category: {product.get('category', 'N/A')}")
        print(f"   Keywords: {product.get('keywords', 'N/A')}")
        print(f"   Price: ${product.get('price', 0)}")
        print()
    
    # Test search
    search_terms = ["headphones", "electronics", "apple", "kitchen", "fitness"]
    
    for term in search_terms:
        print(f"\nTesting search for: '{term}'")
        recommendations = recommendation_engine.get_recommendations(products, term, None, None)
        print(f"Found {len(recommendations)} recommendations")
        
        for i, rec in enumerate(recommendations[:3]):
            score = rec.get('similarity_score', 0)
            print(f"  {i+1}. {rec.get('title', 'Unknown')} (Score: {score:.3f})")

if __name__ == "__main__":
    test_search()