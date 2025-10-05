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
    """Health check endpoint - used by Laravel backend to verify AI service status"""
    try:
        # Test that services can be initialized
        services_status = {
            'gemini_service': 'available' if gemini_service else 'unavailable',
            'product_scraper': 'available' if product_scraper else 'unavailable'
        }

        return jsonify({
            'status': 'healthy',
            'service': 'GiftGenie AI API',
            'version': '1.0.0',
            'services': services_status,
            'port': os.getenv('PORT', 5001)
        })
    except Exception as e:
        logger.error(f"Health check failed: {str(e)}")
        return jsonify({
            'status': 'unhealthy',
            'service': 'GiftGenie AI API',
            'error': str(e)
        }), 503


@app.route('/api/chat', methods=['POST'])
def chat():
    """
    Process user message and generate gift recommendations
    Backend Integration: Laravel expects 'message' and 'session_id', returns 'response' and 'questions'
    """
    try:
        data = request.get_json()

        if not data or 'message' not in data:
            return jsonify({
                'success': False,
                'error': 'Message is required'
            }), 400

        user_message = data['message']
        session_id = data.get('session_id', '')
        context = data.get('context', '')
        user_preferences = data.get('preferences', {})

        logger.info(
            f"Processing chat request (session: {session_id[:8]}...): {user_message[:100]}...")

        # Generate AI response with recommendations
        ai_response = gemini_service.generate_gift_recommendations(
            user_message,
            context,
            user_preferences
        )

        if not ai_response:
            return jsonify({
                'success': False,
                'error': 'Failed to generate recommendations'
            }), 500

        # Format and validate the response
        formatted_response = format_response(ai_response)

        # Ensure response format matches what Laravel backend expects
        response_data = {
            'success': True,
            'response': formatted_response.get('response', ''),
            'questions': formatted_response.get('questions', []),
            'recommendations': formatted_response.get('recommendations', {}),
            'session_id': session_id,
            'timestamp': formatted_response.get('timestamp')
        }

        logger.info(
            f"Chat response generated successfully for session {session_id[:8]}...")
        return jsonify(response_data)

    except Exception as e:
        logger.error(f"Error in chat endpoint: {str(e)}")
        return jsonify({
            'success': False,
            'error': 'Internal server error'
        }), 500


@app.route('/api/search-products', methods=['POST'])
def search_products():
    """
    Search for products based on query or recommendations
    Backend Integration: Laravel sends 'query' and 'max_results', expects 'products' array
    Legacy Support: Also handles 'recommendations' format for direct frontend calls
    """
    try:
        data = request.get_json()

        if not data:
            return jsonify({
                'success': False,
                'error': 'Request data is required'
            }), 400

        # Handle Laravel backend format (query + max_results)
        if 'query' in data:
            query = data['query']
            max_results = data.get('max_results', 6)

            logger.info(
                f"Searching products for query: '{query}' (max: {max_results})")

            try:
                # Search products using the query
                products = product_scraper.search_products(
                    query, max_results=max_results
                )

                logger.info(
                    f"Found {len(products)} products for query: '{query}'")

                return jsonify({
                    'success': True,
                    'products': products,
                    'total_products': len(products),
                    'query': query
                })

            except Exception as e:
                logger.error(
                    f"Error searching products for query '{query}': {str(e)}")
                return jsonify({
                    'success': False,
                    'error': f'Product search failed: {str(e)}'
                }), 500

        # Handle legacy recommendations format (for direct frontend calls)
        elif 'recommendations' in data:
            recommendations = data['recommendations']

            if not validate_recommendations(recommendations):
                return jsonify({
                    'success': False,
                    'error': 'Invalid recommendations format'
                }), 400

            logger.info(
                f"Searching products for {len(recommendations)} categories...")

            # Search for products for each recommendation
            all_products = {}
            total_products = 0

            for item_type, search_keywords in recommendations.items():
                try:
                    products = product_scraper.search_products(
                        search_keywords, max_results=3)
                    all_products[item_type] = products
                    total_products += len(products)
                    logger.info(
                        f"Found {len(products)} products for {item_type}")
                except Exception as e:
                    logger.error(
                        f"Error searching products for {item_type}: {str(e)}")
                    all_products[item_type] = []

            return jsonify({
                'success': True,
                'products': all_products,
                'total_categories': len(all_products),
                'total_products': total_products
            })

        else:
            return jsonify({
                'success': False,
                'error': 'Either query or recommendations is required'
            }), 400

    except Exception as e:
        logger.error(f"Error in search-products endpoint: {str(e)}")
        return jsonify({
            'success': False,
            'error': 'Internal server error'
        }), 500


@app.route('/api/generate-questions', methods=['POST'])
def generate_questions():
    """
    Generate follow-up questions based on user input
    """
    try:
        data = request.get_json()

        if not data or 'message' not in data:
            return jsonify({
                'success': False,
                'error': 'Message is required'
            }), 400

        user_message = data['message']
        context = data.get('context', '')

        logger.info("Generating follow-up questions...")

        questions = gemini_service.generate_follow_up_questions(
            user_message, context)

        return jsonify({
            'success': True,
            'questions': questions,
            'count': len(questions)
        })

    except Exception as e:
        logger.error(f"Error in generate-questions endpoint: {str(e)}")
        return jsonify({
            'success': False,
            'error': 'Internal server error'
        }), 500


@app.route('/api/process-query', methods=['POST'])
def process_query():
    """
    Process a complete query with both AI response and product search
    This endpoint is designed for the Laravel backend to get everything needed for database storage
    """
    try:
        data = request.get_json()

        if not data or 'message' not in data:
            return jsonify({
                'success': False,
                'error': 'Message is required'
            }), 400

        user_message = data['message']
        session_id = data.get('session_id', '')
        max_results = data.get('max_results', 6)
        context = data.get('context', '')

        logger.info(
            f"Processing complete query (session: {session_id[:8]}...): {user_message[:100]}...")

        # Step 1: Generate AI response
        ai_response = gemini_service.generate_gift_recommendations(
            user_message, context, data.get('preferences', {}))

        if not ai_response:
            return jsonify({
                'success': False,
                'error': 'Failed to generate AI response'
            }), 500

        formatted_response = format_response(ai_response)

        # Step 2: Search for products if we have recommendations
        products = []
        if formatted_response.get('recommendations'):
            try:
                # Convert recommendations to search query
                search_terms = []
                for category, description in formatted_response['recommendations'].items():
                    search_terms.append(f"{category} {description}")

                # Limit to avoid too long queries
                search_query = " ".join(search_terms[:3])
                products = product_scraper.search_products(
                    search_query, max_results=max_results)

                logger.info(
                    f"Found {len(products)} products for complete query")

            except Exception as e:
                logger.warning(
                    f"Product search failed for complete query: {str(e)}")
                products = []

        # Step 3: Return complete response for database storage
        complete_response = {
            'success': True,
            'ai_response': {
                'response': formatted_response.get('response', ''),
                'questions': formatted_response.get('questions', []),
                'recommendations': formatted_response.get('recommendations', {}),
                'timestamp': formatted_response.get('timestamp')
            },
            'products': products,
            'session_id': session_id,
            'query': user_message,
            'total_products': len(products)
        }

        logger.info(
            f"Complete query processed successfully for session {session_id[:8]}...")
        return jsonify(complete_response)

    except Exception as e:
        logger.error(f"Error in process-query endpoint: {str(e)}")
        return jsonify({
            'success': False,
            'error': 'Internal server error'
        }), 500


@app.errorhandler(404)
def not_found(error):
    return jsonify({'error': 'Endpoint not found'}), 404


@app.errorhandler(500)
def internal_error(error):
    return jsonify({'error': 'Internal server error'}), 500


if __name__ == '__main__':
    port = int(os.getenv('PORT', 5001))  # Changed from 5000 to 5001
    debug = os.getenv('FLASK_DEBUG', 'False').lower() == 'true'

    logger.info("=" * 60)
    logger.info("🤖 GiftGenie AI API - Backend Integration Ready")
    logger.info("=" * 60)
    logger.info(f"📡 Port: {port}")
    logger.info(f"🔧 Debug: {debug}")
    logger.info(
        f"🔑 Gemini API: {'✅ Configured' if os.getenv('GEMINI_API_KEY') else '❌ Missing'}")
    logger.info("📍 Available Endpoints:")
    logger.info("   • GET  /api/health - Health check")
    logger.info("   • POST /api/chat - AI chat (Laravel integration)")
    logger.info(
        "   • POST /api/search-products - Product search (Laravel integration)")
    logger.info("   • POST /api/process-query - Complete query processing")
    logger.info("   • POST /api/generate-questions - Follow-up questions")
    logger.info("🔗 Backend Integration: Ready for Laravel on port 8000")
    logger.info("=" * 60)

    try:
        app.run(host='0.0.0.0', port=port, debug=debug)
    except OSError as e:
        if "Address already in use" in str(e) or "access" in str(e).lower():
            logger.error(
                f"Port {port} is already in use. Trying port {port + 1}...")
            app.run(host='0.0.0.0', port=port + 1, debug=debug)
        else:
            raise
