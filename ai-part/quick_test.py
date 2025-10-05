#!/usr/bin/env python3
"""
Quick test to verify the API is working correctly
"""

import requests
import json

API_BASE = "http://localhost:5001/api"


def test_health():
    """Test health endpoint"""
    try:
        response = requests.get(f"{API_BASE}/health")
        if response.status_code == 200:
            print("✅ Health check passed")
            return True
        else:
            print(f"❌ Health check failed: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Health check error: {e}")
        return False


def test_chat():
    """Test chat endpoint"""
    try:
        data = {
            "message": "I need chocolate for my friend's birthday",
            "context": "",
            "preferences": {"budget": "$20-50"}
        }

        response = requests.post(f"{API_BASE}/chat", json=data)

        if response.status_code == 200:
            result = response.json()
            print("✅ Chat endpoint working")
            print(f"   Response: {result.get('response', '')[:100]}...")
            print(f"   Questions: {len(result.get('questions', []))}")
            print(
                f"   Recommendations: {len(result.get('recommendations', {}))}")

            if result.get('recommendations'):
                print("   Categories:", list(result['recommendations'].keys()))

            return result.get('recommendations', {})
        else:
            print(f"❌ Chat failed: {response.status_code}")
            print(f"   Error: {response.text}")
            return {}
    except Exception as e:
        print(f"❌ Chat error: {e}")
        return {}


def test_products(recommendations):
    """Test product search"""
    if not recommendations:
        print("⚠️  No recommendations to test with")
        return

    try:
        data = {"recommendations": recommendations}
        response = requests.post(f"{API_BASE}/search-products", json=data)

        if response.status_code == 200:
            result = response.json()
            print("✅ Product search working")
            print(f"   Total products: {result.get('total_products', 0)}")
            print(f"   Categories: {result.get('total_categories', 0)}")

            for category, products in result.get('products', {}).items():
                print(f"   {category}: {len(products)} items")
                for product in products[:1]:  # Show first product
                    print(f"     - {product.get('name', '')[:40]}...")
                    print(f"       Price: {product.get('price', 'N/A')}")
        else:
            print(f"❌ Product search failed: {response.status_code}")
            print(f"   Error: {response.text}")
    except Exception as e:
        print(f"❌ Product search error: {e}")


if __name__ == "__main__":
    print("🧪 Testing GiftGenie API")
    print("=" * 40)

    # Test health
    if not test_health():
        print("\n❌ Server not running. Please start with: python app.py")
        exit(1)

    print()

    # Test chat
    recommendations = test_chat()

    print()

    # Test products
    test_products(recommendations)

    print("\n" + "=" * 40)
    print("✨ API test complete!")
