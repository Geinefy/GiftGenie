#!/usr/bin/env python3
"""
Simple test script to verify GiftGenie AI system setup
"""

from dotenv import load_dotenv
import sys
import os

print("🔍 GiftGenie AI System Test")
print("=" * 40)

# Test 1: Check if we're in the right directory
print("1. Checking current directory...")
current_dir = os.getcwd()
print(f"   Current directory: {current_dir}")

if "ai-part" in current_dir:
    print("   ✅ In ai-part directory")
else:
    print("   ❌ Not in ai-part directory")
    print("   Please run: cd ai-part")
    sys.exit(1)

# Test 2: Check if key files exist
print("\n2. Checking key files...")
key_files = ['app.py', 'gemini_service.py',
             'product_scraper.py', 'utils.py', '.env']
for file in key_files:
    if os.path.exists(file):
        print(f"   ✅ {file} found")
    else:
        print(f"   ❌ {file} missing")

# Test 3: Check imports
print("\n3. Checking Python imports...")
try:
    import flask
    print("   ✅ Flask imported")
except ImportError:
    print("   ❌ Flask not available")

try:
    import flask_cors
    print("   ✅ Flask-CORS imported")
except ImportError:
    print("   ❌ Flask-CORS not available")

try:
    import google.generativeai
    print("   ✅ Google Generative AI imported")
except ImportError:
    print("   ❌ Google Generative AI not available")

try:
    import requests
    print("   ✅ Requests imported")
except ImportError:
    print("   ❌ Requests not available")

try:
    from bs4 import BeautifulSoup
    print("   ✅ BeautifulSoup imported")
except ImportError:
    print("   ❌ BeautifulSoup not available")

# Test 4: Check environment variables
print("\n4. Checking environment variables...")
load_dotenv()

gemini_key = os.getenv('GEMINI_API_KEY')
if gemini_key and gemini_key != 'your_api_key_here' and gemini_key != 'your_gemini_api_key_here':
    print("   ✅ GEMINI_API_KEY is set")
else:
    print("   ⚠️  GEMINI_API_KEY not set or using placeholder")
    print("   Please edit .env file and add your Gemini API key")

# Test 5: Test basic Flask app creation
print("\n5. Testing Flask app creation...")
try:
    from flask import Flask
    test_app = Flask(__name__)
    print("   ✅ Flask app created successfully")
except Exception as e:
    print(f"   ❌ Flask app creation failed: {e}")

print("\n" + "=" * 40)
print("🎯 Next steps:")
print("1. Make sure you're in the ai-part directory: cd ai-part")
print("2. Activate virtual environment: .\\venv\\Scripts\\Activate.ps1")
print("3. Set your Gemini API key in .env file")
print("4. Run: python app.py")
print("\n✨ If all tests pass, your system should work!")
