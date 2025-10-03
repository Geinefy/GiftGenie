#!/usr/bin/env python3
"""
Quick validation script to check if all components are properly set up
"""

import sys
import os
import json
from pathlib import Path


def check_python_backend():
    """Check Python backend setup"""
    print("🐍 Checking Python Backend...")

    # Check if we're in the right directory
    if not os.path.exists('requirements.txt'):
        print("❌ Not in ai-part directory or requirements.txt missing")
        return False

    # Check if .env exists
    if not os.path.exists('.env'):
        print("⚠️  .env file missing - you'll need to create one with GEMINI_API_KEY")
    else:
        print("✅ .env file found")

    # Check if virtual environment exists
    if os.path.exists('venv'):
        print("✅ Virtual environment found")
    else:
        print("⚠️  Virtual environment not found - run setup.bat first")

    # Try importing key modules
    try:
        import flask
        import google.generativeai
        import requests
        import bs4
        print("✅ Key Python packages available")
    except ImportError as e:
        print(f"❌ Missing Python package: {e}")
        return False

    # Check if app.py can be imported
    try:
        import app
        print("✅ Flask app can be imported")
    except Exception as e:
        print(f"⚠️  Flask app import issue: {e}")

    return True


def check_frontend():
    """Check frontend setup"""
    print("\n⚛️  Checking Frontend...")

    frontend_path = Path("../frontend")

    # Check if package.json exists
    if not (frontend_path / "package.json").exists():
        print("❌ Frontend package.json not found")
        return False

    print("✅ package.json found")

    # Check if node_modules exists
    if (frontend_path / "node_modules").exists():
        print("✅ node_modules found")
    else:
        print("⚠️  node_modules not found - run 'npm install' in frontend directory")

    # Check key files
    key_files = [
        "src/App.tsx",
        "src/components/chat/ChatWidget.tsx",
        "src/components/chat/ChatMessage.tsx",
        "src/services/giftService.ts"
    ]

    for file in key_files:
        if (frontend_path / file).exists():
            print(f"✅ {file} found")
        else:
            print(f"❌ {file} missing")
            return False

    return True


def check_configuration():
    """Check configuration files"""
    print("\n⚙️  Checking Configuration...")

    # Check config.json
    if os.path.exists('config.json'):
        try:
            with open('config.json', 'r') as f:
                config = json.load(f)
            print("✅ config.json is valid JSON")
        except json.JSONDecodeError:
            print("❌ config.json has invalid JSON")
    else:
        print("❌ config.json missing")

    # Check .env
    if os.path.exists('.env'):
        with open('.env', 'r') as f:
            env_content = f.read()

        if 'GEMINI_API_KEY=' in env_content and 'your_gemini_api_key_here' not in env_content:
            print("✅ GEMINI_API_KEY appears to be set")
        else:
            print("⚠️  GEMINI_API_KEY not properly configured")

    return True


def main():
    """Run all checks"""
    print("🔍 GiftGenie System Validation")
    print("=" * 40)

    backend_ok = check_python_backend()
    frontend_ok = check_frontend()
    config_ok = check_configuration()

    print("\n" + "=" * 40)
    print("📋 Summary:")

    if backend_ok:
        print("✅ Python Backend: Ready")
    else:
        print("❌ Python Backend: Issues found")

    if frontend_ok:
        print("✅ React Frontend: Ready")
    else:
        print("❌ React Frontend: Issues found")

    if config_ok:
        print("✅ Configuration: Ready")
    else:
        print("❌ Configuration: Issues found")

    print("\n🚀 Next Steps:")
    if backend_ok and frontend_ok and config_ok:
        print("1. Start backend: python app.py")
        print("2. Start frontend: cd ../frontend && npm run dev")
        print("3. Open: http://localhost:5173")
    else:
        print("1. Fix the issues above")
        print("2. Run setup.bat if you haven't already")
        print("3. Make sure to set your GEMINI_API_KEY in .env")


if __name__ == "__main__":
    main()
