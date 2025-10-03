#!/usr/bin/env python3
"""
GiftGenie AI API Test Script
Test the various endpoints and functionality
"""

import requests
import json
import time

BASE_URL = "http://localhost:5000"


def test_health_check():
    """Test the health check endpoint"""
    print("🔍 Testing health check...")
    try:
        response = requests.get(f"{BASE_URL}/api/health")
        if response.status_code == 200:
            print("✅ Health check passed")
            print(f"   Response: {response.json()}")
        else:
            print(f"❌ Health check failed: {response.status_code}")
    except Exception as e:
        print(f"❌ Health check error: {str(e)}")


def test_chat_endpoint():
    """Test the chat endpoint"""
    print("\n🤖 Testing chat endpoint...")

    test_message = "I need a gift for my tech-savvy brother who loves gaming"

    try:
        response = requests.post(f"{BASE_URL}/api/chat", json={
            "message": test_message,
            "context": "",
            "preferences": {"budget": "50-100"}
        })

        if response.status_code == 200:
            data = response.json()
            print("✅ Chat endpoint working")
            print(f"   Questions: {data.get('questions', [])}")
            print(f"   Recommendations: {data.get('recommendations', {})}")
            print(f"   Response: {data.get('response', '')[:100]}...")
            return data.get('recommendations', {})
        else:
            print(f"❌ Chat endpoint failed: {response.status_code}")
            print(f"   Error: {response.text}")
            return {}
    except Exception as e:
        print(f"❌ Chat endpoint error: {str(e)}")
        return {}


def test_product_search(recommendations):
    """Test the product search endpoint"""
    print("\n🛍️ Testing product search...")

    if not recommendations:
        print("❌ No recommendations to test with")
        return

    try:
        response = requests.post(f"{BASE_URL}/api/search-products", json={
            "recommendations": recommendations
        })

        if response.status_code == 200:
            data = response.json()
            print("✅ Product search working")
            print(f"   Total categories: {data.get('total_categories', 0)}")
            print(f"   Total products: {data.get('total_products', 0)}")

            for category, products in data.get('products', {}).items():
                print(f"   {category}: {len(products)} products")
                for product in products[:2]:  # Show first 2 products
                    print(f"     - {product.get('name', '')[:50]}...")
                    print(f"       Price: {product.get('price', 'N/A')}")
                    print(f"       Source: {product.get('source', 'N/A')}")
        else:
            print(f"❌ Product search failed: {response.status_code}")
            print(f"   Error: {response.text}")
    except Exception as e:
        print(f"❌ Product search error: {str(e)}")


def test_questions_endpoint():
    """Test the questions generation endpoint"""
    print("\n❓ Testing questions endpoint...")

    try:
        response = requests.post(f"{BASE_URL}/api/generate-questions", json={
            "message": "I want to buy a gift",
            "context": ""
        })

        if response.status_code == 200:
            data = response.json()
            print("✅ Questions endpoint working")
            print(f"   Generated {data.get('count', 0)} questions:")
            for i, question in enumerate(data.get('questions', []), 1):
                print(f"     {i}. {question}")
        else:
            print(f"❌ Questions endpoint failed: {response.status_code}")
            print(f"   Error: {response.text}")
    except Exception as e:
        print(f"❌ Questions endpoint error: {str(e)}")


def main():
    """Run all tests"""
    print("🚀 Starting GiftGenie AI API Tests\n")
    print("=" * 50)

    # Test health check first
    test_health_check()

    # Test chat endpoint and get recommendations
    recommendations = test_chat_endpoint()

    # Test product search with recommendations
    test_product_search(recommendations)

    # Test questions endpoint
    test_questions_endpoint()

    print("\n" + "=" * 50)
    print("✨ Tests completed!")
    print("\nTo manually test the API:")
    print(f"   Health: GET {BASE_URL}/api/health")
    print(f"   Chat: POST {BASE_URL}/api/chat")
    print(f"   Search: POST {BASE_URL}/api/search-products")
    print(f"   Questions: POST {BASE_URL}/api/generate-questions")


if __name__ == "__main__":
    main()
