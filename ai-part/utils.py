import re
import logging
from typing import Dict, List, Any

logger = logging.getLogger(__name__)


def validate_recommendations(recommendations: Dict) -> bool:
    """
    Validate that recommendations have the correct format
    """
    if not isinstance(recommendations, dict):
        return False

    if not recommendations:
        return False

    for key, value in recommendations.items():
        if not isinstance(key, str) or not isinstance(value, str):
            return False

        if not key.strip() or not value.strip():
            return False

    return True


def format_response(ai_response: Dict) -> Dict:
    """
    Format AI response to ensure consistency
    """
    formatted = {
        'questions': ai_response.get('questions', []),
        'recommendations': ai_response.get('recommendations', {}),
        'response': ai_response.get('response', ''),
        'success': True
    }

    # Ensure questions is a list
    if not isinstance(formatted['questions'], list):
        formatted['questions'] = []

    # Ensure recommendations is a dict
    if not isinstance(formatted['recommendations'], dict):
        formatted['recommendations'] = {}

    # Clean up recommendations keys (convert to snake_case)
    cleaned_recommendations = {}
    for key, value in formatted['recommendations'].items():
        clean_key = clean_category_name(key)
        cleaned_recommendations[clean_key] = str(value).strip()

    formatted['recommendations'] = cleaned_recommendations

    return formatted


def clean_category_name(category: str) -> str:
    """
    Clean and normalize category names to snake_case
    """
    if not isinstance(category, str):
        return str(category)

    # Convert to lowercase and replace spaces/special chars with underscores
    cleaned = re.sub(r'[^a-zA-Z0-9\s]', '', category.lower())
    cleaned = re.sub(r'\s+', '_', cleaned.strip())

    # Remove multiple underscores
    cleaned = re.sub(r'_+', '_', cleaned)

    # Remove leading/trailing underscores
    cleaned = cleaned.strip('_')

    return cleaned or 'unknown_category'


def extract_price_value(price_string: str) -> float:
    """
    Extract numeric price value from price string
    """
    if not price_string:
        return 0.0

    # Remove currency symbols and extract numbers
    price_match = re.search(r'[\d,]+\.?\d*', str(price_string))

    if price_match:
        try:
            # Remove commas and convert to float
            price_value = float(price_match.group(0).replace(',', ''))
            return price_value
        except ValueError:
            pass

    return 0.0


def format_price(price: Any) -> str:
    """
    Format price consistently
    """
    if isinstance(price, (int, float)):
        return f"${price:.2f}"

    if isinstance(price, str):
        # If it already has currency symbol, return as is
        if '$' in price or '€' in price or '£' in price:
            return price

        # Try to extract number and format
        try:
            price_value = extract_price_value(price)
            return f"${price_value:.2f}" if price_value > 0 else price
        except:
            return price

    return "Price not available"


def sanitize_product_name(name: str) -> str:
    """
    Sanitize and clean product names
    """
    if not isinstance(name, str):
        return str(name)

    # Remove excessive whitespace
    name = ' '.join(name.split())

    # Remove common unwanted prefixes/suffixes
    unwanted_patterns = [
        r'^(New Listing:?\s*)',
        r'^(SPONSORED:?\s*)',
        r'^(Ad\s*)',
        r'\s*\(Ad\)$',
        r'\s*- Sponsored$'
    ]

    for pattern in unwanted_patterns:
        name = re.sub(pattern, '', name, flags=re.IGNORECASE)

    # Limit length
    if len(name) > 150:
        name = name[:147] + "..."

    return name.strip()


def validate_url(url: str) -> bool:
    """
    Validate if URL is properly formatted
    """
    if not isinstance(url, str):
        return False

    url_pattern = re.compile(
        r'^https?://'  # http:// or https://
        # domain...
        r'(?:(?:[A-Z0-9](?:[A-Z0-9-]{0,61}[A-Z0-9])?\.)+[A-Z]{2,6}\.?|'
        r'localhost|'  # localhost...
        r'\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})'  # ...or ip
        r'(?::\d+)?'  # optional port
        r'(?:/?|[/?]\S+)$', re.IGNORECASE)

    return url_pattern.match(url) is not None


def log_performance(func_name: str, duration: float, success: bool = True):
    """
    Log performance metrics
    """
    status = "SUCCESS" if success else "FAILED"
    logger.info(f"[PERFORMANCE] {func_name}: {duration:.2f}s - {status}")


def create_error_response(error_message: str, error_code: int = 500) -> Dict:
    """
    Create standardized error response
    """
    return {
        'success': False,
        'error': error_message,
        'error_code': error_code,
        'questions': [],
        'recommendations': {},
        'response': 'Sorry, I encountered an error processing your request.'
    }


def filter_products_by_quality(products: List[Dict]) -> List[Dict]:
    """
    Filter products based on quality criteria
    """
    filtered_products = []

    for product in products:
        # Check if product has essential information
        if not product.get('name') or not product.get('price'):
            continue

        # Check name length (avoid very short or very long names)
        name_length = len(product['name'].strip())
        if name_length < 5 or name_length > 200:
            continue

        # Check if price is reasonable (avoid $0.00 or extremely high prices)
        price_value = extract_price_value(product['price'])
        if price_value <= 0 or price_value > 10000:
            continue

        # Check URL validity
        if not validate_url(product.get('url', '')):
            continue

        filtered_products.append(product)

    return filtered_products


def merge_similar_products(products: List[Dict]) -> List[Dict]:
    """
    Remove very similar products to provide variety
    """
    if len(products) <= 1:
        return products

    unique_products = []
    seen_names = set()

    for product in products:
        # Create a simplified version of the name for comparison
        simple_name = re.sub(r'[^a-zA-Z0-9\s]', '', product['name'].lower())
        simple_name = ' '.join(simple_name.split()[:5])  # Use first 5 words

        # Check if we've seen a very similar product
        is_similar = False
        for seen in seen_names:
            # Calculate simple similarity
            common_words = set(simple_name.split()) & set(seen.split())
            if len(common_words) >= 3:  # If 3+ words in common, consider similar
                is_similar = True
                break

        if not is_similar:
            unique_products.append(product)
            seen_names.add(simple_name)

    return unique_products
