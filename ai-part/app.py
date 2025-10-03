from flask import Flask, request, jsonify
from flask_cors import CORS
from dotenv import load_dotenv
import os
import logging
from gemini_service import GeminiService
from product_scraper import ProductScraper
from utils import validate_recommendations, format_response

# Load environment variables
load_dotenv()

# Initialize Flask app
app = Flask(__name__)
CORS(app)

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Initialize services
gemini_service = GeminiService(os.getenv('GEMINI_API_KEY'))
product_scraper = ProductScraper()


@app.route('/api/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'service': 'GiftGenie AI API',
        'version': '1.0.0'
    })


@app.route('/api/chat', methods=['POST'])
def chat():
    """
    Process user message and generate gift recommendations
    """
    try:
        data = request.get_json()

        if not data or 'message' not in data:
            return jsonify({'error': 'Message is required'}), 400

        user_message = data['message']
        context = data.get('context', '')
        user_preferences = data.get('preferences', {})

        logger.info(f"Processing chat request: {user_message[:100]}...")

        # Generate AI response with recommendations
        ai_response = gemini_service.generate_gift_recommendations(
            user_message,
            context,
            user_preferences
        )

        if not ai_response:
            return jsonify({'error': 'Failed to generate recommendations'}), 500

        # Format and validate the response
        formatted_response = format_response(ai_response)

        return jsonify(formatted_response)

    except Exception as e:
        logger.error(f"Error in chat endpoint: {str(e)}")
        return jsonify({'error': 'Internal server error'}), 500


@app.route('/api/search-products', methods=['POST'])
def search_products():
    """
    Search for products based on gift recommendations
    """
    try:
        data = request.get_json()

        if not data or 'recommendations' not in data:
            return jsonify({'error': 'Recommendations are required'}), 400

        recommendations = data['recommendations']

        if not validate_recommendations(recommendations):
            return jsonify({'error': 'Invalid recommendations format'}), 400

        logger.info(
            f"Searching products for {len(recommendations)} categories...")

        # Search for products for each recommendation
        all_products = {}

        for item_type, search_keywords in recommendations.items():
            try:
                products = product_scraper.search_products(
                    search_keywords, max_results=3)
                all_products[item_type] = products
                logger.info(f"Found {len(products)} products for {item_type}")
            except Exception as e:
                logger.error(
                    f"Error searching products for {item_type}: {str(e)}")
                all_products[item_type] = []

        return jsonify({
            'products': all_products,
            'total_categories': len(all_products),
            'total_products': sum(len(products) for products in all_products.values())
        })

    except Exception as e:
        logger.error(f"Error in search-products endpoint: {str(e)}")
        return jsonify({'error': 'Internal server error'}), 500


@app.route('/api/generate-questions', methods=['POST'])
def generate_questions():
    """
    Generate follow-up questions based on user input
    """
    try:
        data = request.get_json()

        if not data or 'message' not in data:
            return jsonify({'error': 'Message is required'}), 400

        user_message = data['message']
        context = data.get('context', '')

        logger.info("Generating follow-up questions...")

        questions = gemini_service.generate_follow_up_questions(
            user_message, context)

        return jsonify({
            'questions': questions,
            'count': len(questions)
        })

    except Exception as e:
        logger.error(f"Error in generate-questions endpoint: {str(e)}")
        return jsonify({'error': 'Internal server error'}), 500


@app.errorhandler(404)
def not_found(error):
    return jsonify({'error': 'Endpoint not found'}), 404


@app.errorhandler(500)
def internal_error(error):
    return jsonify({'error': 'Internal server error'}), 500


if __name__ == '__main__':
    port = int(os.getenv('PORT', 5001))  # Changed from 5000 to 5001
    debug = os.getenv('FLASK_DEBUG', 'False').lower() == 'true'

    logger.info(f"Starting GiftGenie AI API on port {port}")
    try:
        app.run(host='0.0.0.0', port=port, debug=debug)
    except OSError as e:
        if "Address already in use" in str(e) or "access" in str(e).lower():
            logger.error(
                f"Port {port} is already in use. Trying port {port + 1}...")
            app.run(host='0.0.0.0', port=port + 1, debug=debug)
        else:
            raise
