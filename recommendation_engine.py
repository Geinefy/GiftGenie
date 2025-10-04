"""
Recommendation Engine Module
Handles product recommendation logic using TF-IDF and similarity matching.
"""

import re
import logging
from typing import List, Dict, Optional
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import numpy as np

logger = logging.getLogger(__name__)

class RecommendationEngine:
    """Provides product recommendations based on user queries."""
    
    def __init__(self):
        self.vectorizer = TfidfVectorizer(
            stop_words='english',
            max_features=5000,
            ngram_range=(1, 2),
            lowercase=True
        )
        
    def preprocess_text(self, text: str) -> str:
        """Clean and preprocess text for better matching."""
        if not text:
            return ""
        
        # Convert to lowercase and remove special characters
        text = re.sub(r'[^a-zA-Z0-9\s]', ' ', text.lower())
        # Remove extra whitespace
        text = re.sub(r'\s+', ' ', text.strip())
        
        return text
    
    def extract_keywords(self, text: str) -> List[str]:
        """Extract important keywords from text."""
        # Simple keyword extraction based on common gift/product terms
        keywords = []
        
        # Price-related terms
        price_terms = ['cheap', 'expensive', 'affordable', 'budget', 'premium', 'luxury']
        
        # Occasion terms
        occasion_terms = ['birthday', 'wedding', 'anniversary', 'christmas', 'valentine', 
                         'graduation', 'baby shower', 'housewarming', 'retirement']
        
        # Interest terms
        interest_terms = ['tech', 'technology', 'fitness', 'cooking', 'music', 'art',
                         'sports', 'reading', 'gaming', 'travel', 'fashion', 'beauty']
        
        # Category terms
        category_terms = ['electronics', 'kitchen', 'home', 'clothing', 'books',
                         'toys', 'games', 'health', 'garden', 'jewelry']
        
        text_lower = text.lower()
        for term_list in [price_terms, occasion_terms, interest_terms, category_terms]:
            for term in term_list:
                if term in text_lower:
                    keywords.append(term)
        
        return keywords
    
    def calculate_similarity_scores(self, products: List[Dict], query: str) -> List[float]:
        """Calculate similarity scores between query and products."""
        if not products or not query:
            return [0.0] * len(products)
        
        try:
            # Prepare product texts for comparison
            product_texts = []
            for product in products:
                # Combine title, description, category, and keywords
                text_parts = [
                    product.get('title', ''),
                    product.get('description', ''),
                    product.get('category', ''),
                    product.get('keywords', '')
                ]
                combined_text = ' '.join(filter(None, text_parts))
                product_texts.append(self.preprocess_text(combined_text))
            
            # Add query to the corpus
            query_processed = self.preprocess_text(query)
            all_texts = product_texts + [query_processed]
            
            # Calculate TF-IDF vectors
            tfidf_matrix = self.vectorizer.fit_transform(all_texts)
            
            # Calculate cosine similarity between query and each product
            query_vector = tfidf_matrix[-1]  # Last vector is the query
            product_vectors = tfidf_matrix[:-1]  # All except the last are products
            
            similarities = cosine_similarity(query_vector, product_vectors).flatten()
            
            return similarities.tolist()
            
        except Exception as e:
            logger.error(f"Error calculating similarity scores: {str(e)}")
            return [0.0] * len(products)
    
    def apply_price_filter(self, products: List[Dict], min_price: Optional[float], 
                          max_price: Optional[float]) -> List[Dict]:
        """Filter products by price range."""
        if min_price is None and max_price is None:
            return products
        
        filtered_products = []
        for product in products:
            price = product.get('price', 0)
            
            if min_price is not None and price < min_price:
                continue
            if max_price is not None and price > max_price:
                continue
                
            filtered_products.append(product)
        
        return filtered_products
    
    def boost_exact_matches(self, products: List[Dict], query: str, scores: List[float]) -> List[float]:
        """Boost scores for products with exact keyword matches."""
        query_words = set(query.lower().split())
        boosted_scores = scores.copy()
        
        for i, product in enumerate(products):
            product_text = (
                f"{product.get('title', '')} {product.get('description', '')} "
                f"{product.get('category', '')} {product.get('keywords', '')}"
            ).lower()
            
            # Count exact word matches
            product_words = set(product_text.split())
            exact_matches = len(query_words.intersection(product_words))
            
            if exact_matches > 0:
                # Boost score based on number of exact matches
                boost_factor = 1 + (exact_matches * 0.2)
                boosted_scores[i] *= boost_factor
        
        return boosted_scores
    
    def get_recommendations(self, products: List[Dict], query: str, 
                          min_price: Optional[float] = None, 
                          max_price: Optional[float] = None,
                          max_results: int = 20) -> List[Dict]:
        """Get product recommendations based on user query and filters."""
        
        if not products:
            logger.warning("No products available for recommendations")
            return []
        
        if not query:
            logger.warning("Empty query provided")
            return products[:max_results]
        
        try:
            # Apply price filter first
            filtered_products = self.apply_price_filter(products, min_price, max_price)
            
            if not filtered_products:
                logger.info("No products match the price filter")
                return []
            
            # Calculate similarity scores
            similarity_scores = self.calculate_similarity_scores(filtered_products, query)
            
            # Boost scores for exact matches
            boosted_scores = self.boost_exact_matches(filtered_products, query, similarity_scores)
            
            # Combine products with their scores
            product_scores = list(zip(filtered_products, boosted_scores))
            
            # Filter out products with 0% match (score <= 0.001)
            product_scores = [(product, score) for product, score in product_scores if score > 0.001]
            
            # Sort by score (descending) - this ensures best matches come first
            product_scores.sort(key=lambda x: x[1], reverse=True)
            
            # Extract top recommendations
            recommendations = []
            for product, score in product_scores[:max_results]:
                product_copy = product.copy()
                product_copy['relevance_score'] = round(score, 3)
                
                # Add explanation for why this product matches
                product_copy['match_reason'] = self.generate_match_explanation(
                    product, query, score
                )
                
                recommendations.append(product_copy)
            
            logger.info(f"Generated {len(recommendations)} recommendations for query: '{query}'")
            return recommendations
            
        except Exception as e:
            logger.error(f"Error generating recommendations: {str(e)}")
            return products[:max_results]
    
    def generate_match_explanation(self, product: Dict, query: str, score: float) -> str:
        """Generate explanation for why a product matches the query."""
        if score < 0.1:
            return "Basic match based on category and general relevance."
        
        query_words = set(query.lower().split())
        product_text = (
            f"{product.get('title', '')} {product.get('description', '')} "
            f"{product.get('keywords', '')}"
        ).lower()
        
        matched_words = []
        for word in query_words:
            if word in product_text and len(word) > 2:  # Skip short words
                matched_words.append(word)
        
        if matched_words:
            if len(matched_words) == 1:
                return f"Matches your search for '{matched_words[0]}'."
            else:
                return f"Strong match for {', '.join(matched_words[:3])}."
        
        # Category-based explanation
        category = product.get('category', '').lower()
        if any(word in category for word in query_words):
            return f"Recommended based on {category} category match."
        
        return "Recommended based on content similarity and relevance."
    
    def get_trending_products(self, products: List[Dict], limit: int = 10) -> List[Dict]:
        """Get trending/popular products (simple implementation)."""
        # Simple trending logic based on price and category diversity
        if not products:
            return []
        
        # Sort by a combination of factors (price, category diversity)
        trending = sorted(products, key=lambda x: (-x.get('price', 0), x.get('title', '')))
        
        return trending[:limit]