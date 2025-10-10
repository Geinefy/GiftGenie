from gemini_service import GeminiService
import os
import sys
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

# Add current directory to path for imports
sys.path.append(os.path.dirname(os.path.abspath(__file__)))


def test_gemini():
    print("Testing Gemini API...")

    api_key = os.getenv('GEMINI_API_KEY')
    if not api_key:
        print("❌ No API key found in .env file")
        return False

    print(f"✓ Using API key: {api_key[:10]}...")

    try:
        # Initialize Gemini service
        gemini = GeminiService(api_key)
        print("✓ Gemini service initialized")

        # Test message
        test_message = "I need a gift for my mom who loves gardening, budget is $50"

        print(f"📝 Testing with message: {test_message}")

        # Generate recommendations
        result = gemini.generate_gift_recommendations(
            user_message=test_message,
            context="",
            preferences={"budget": 50, "occasion": "birthday"}
        )

        if result:
            print("✅ Gemini API is working!")
            print(
                f"Response: {result.get('response', 'No response')[:100]}...")
            print(f"Recommendations: {len(result.get('recommendations', {}))}")
            print(f"Questions: {len(result.get('questions', []))}")
            return True
        else:
            print("❌ Gemini returned no result")
            return False

    except Exception as e:
        print(f"❌ Gemini API error: {str(e)}")
        return False


if __name__ == "__main__":
    test_gemini()
