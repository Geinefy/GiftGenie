#!/usr/bin/env python3
"""Debug TF-IDF and similarity calculation."""

from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import numpy as np

def test_tfidf():
    # Sample data
    documents = [
        "apple airpods wireless headphones bluetooth noise cancellation",
        "instant pot pressure cooker kitchen appliance cooking", 
        "fitbit fitness tracker health monitor gps heart rate",
        "nintendo switch oled gaming console handheld games",
        "headphones"  # This is our query
    ]
    
    print("Documents:")
    for i, doc in enumerate(documents):
        print(f"{i}: {doc}")
    print()
    
    # Create TF-IDF vectorizer
    vectorizer = TfidfVectorizer(
        stop_words='english',
        max_features=5000,
        ngram_range=(1, 2),
        lowercase=True
    )
    
    # Fit and transform
    tfidf_matrix = vectorizer.fit_transform(documents)
    print(f"TF-IDF matrix shape: {tfidf_matrix.shape}")
    print(f"Feature names: {vectorizer.get_feature_names_out()[:10]}")
    print()
    
    # Get query vector (last document)
    query_vector = tfidf_matrix[-1]
    product_vectors = tfidf_matrix[:-1]
    
    print(f"Query vector shape: {query_vector.shape}")
    print(f"Product vectors shape: {product_vectors.shape}")
    
    # Calculate similarities
    similarities = cosine_similarity(query_vector, product_vectors).flatten()
    print(f"Similarities: {similarities}")
    
    # Show which document matches best
    for i, sim in enumerate(similarities):
        print(f"Document {i}: {documents[i][:50]}... -> Similarity: {sim:.4f}")

if __name__ == "__main__":
    test_tfidf()