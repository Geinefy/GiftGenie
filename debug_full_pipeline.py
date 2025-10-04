#!/usr/bin/env python3
"""Debug the full recommendation pipeline."""

from app import get_products_from_db
from recommendation_engine import RecommendationEngine

def debug_full_pipeline():
    products = get_products_from_db()
    query = "headphones"
    
    print(f"Testing full recommendation pipeline for query: '{query}'")
    print(f"Number of products: {len(products)}")
    print()
    
    rec_engine = RecommendationEngine()
    
    # Step 1: Test similarity scores
    print("Step 1: Calculate similarity scores")
    similarities = rec_engine.calculate_similarity_scores(products, query)
    print(f"Raw similarities: {similarities}")
    print()
    
    # Step 2: Test boost exact matches
    print("Step 2: Boost exact matches")
    boosted = rec_engine.boost_exact_matches(products, query, similarities)
    print(f"Boosted scores: {boosted}")
    print()
    
    # Step 3: Test full get_recommendations
    print("Step 3: Full get_recommendations")
    recommendations = rec_engine.get_recommendations(products, query, None, None)
    print(f"Number of recommendations: {len(recommendations)}")
    
    for i, rec in enumerate(recommendations):
        print(f"{i}: {rec.get('title', 'Unknown')}")
        print(f"   Relevance score: {rec.get('relevance_score', 'N/A')}")
        print(f"   Match reason: {rec.get('match_reason', 'N/A')}")
        print()

if __name__ == "__main__":
    debug_full_pipeline()