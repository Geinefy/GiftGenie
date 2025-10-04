#!/usr/bin/env python3
"""Debug the recommendation engine similarity calculation."""

from app import get_products_from_db
from recommendation_engine import RecommendationEngine

def debug_similarity():
    # Get products
    products = get_products_from_db()
    query = "headphones"
    
    print(f"Testing similarity calculation for query: '{query}'")
    print(f"Number of products: {len(products)}")
    print()
    
    # Create recommendation engine
    rec_engine = RecommendationEngine()
    
    # Test the similarity calculation method directly
    try:
        similarities = rec_engine.calculate_similarity_scores(products, query)
        print(f"Similarity scores: {similarities}")
        
        # Show each product with its score
        for i, (product, score) in enumerate(zip(products, similarities)):
            print(f"{i}: {product.get('title', 'Unknown')} -> Score: {score:.4f}")
            
            # Show the text that's being used for comparison
            text_parts = [
                product.get('title', ''),
                product.get('description', ''),
                product.get('category', ''),
                product.get('keywords', '')
            ]
            combined_text = ' '.join(filter(None, text_parts))
            processed_text = rec_engine.preprocess_text(combined_text)
            print(f"   Processed text: {processed_text[:100]}...")
            print()
            
    except Exception as e:
        print(f"Error in similarity calculation: {e}")
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    debug_similarity()