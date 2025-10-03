import requests
from bs4 import BeautifulSoup
import time
import random
import logging
from typing import List, Dict, Optional

import re
from urllib.parse import quote

# Import the new API integrations
from api_integrations import ProductAPIManager
import cloudscraper  # Optional for eBay scraping
from bs4 import BeautifulSoup
import time
import random
import logging
from typing import List, Dict, Optional
from fake_useragent import UserAgent  # Optional for random user agents
import re
from urllib.parse import quote

# Optional Selenium imports - will work without Chrome driver
try:
    from selenium import webdriver
    from selenium.webdriver.chrome.options import Options
    from selenium.webdriver.common.by import By
    from selenium.webdriver.support.ui import WebDriverWait
    from selenium.webdriver.support import expected_conditions as EC
    from webdriver_manager.chrome import ChromeDriverManager
    from selenium.webdriver.chrome.service import Service
    SELENIUM_AVAILABLE = True
except ImportError:
    SELENIUM_AVAILABLE = False
    print("⚠️  Selenium not available - using basic scraping only")

# Optional undetected Chrome driver - fallback if not available
try:
    import undetected_chromedriver as uc
    UC_AVAILABLE = True
except ImportError:
    UC_AVAILABLE = False
    print("⚠️  Undetected Chrome driver not available - using basic scraping only")

logger = logging.getLogger(__name__)


class ProductScraper:
    def __init__(self):
        # Optional dependencies
        try:
            from fake_useragent import UserAgent
            self.ua = UserAgent()
        except ImportError:
            self.ua = None

        try:
            import cloudscraper
            self.scraper = cloudscraper.create_scraper()
        except ImportError:
            self.scraper = None
        self.session = requests.Session()
        self._setup_session()

        # Initialize the enhanced API manager
        self.api_manager = ProductAPIManager()

    def _setup_session(self):
        """Setup requests session with headers"""
        self.session.headers.update({
            'User-Agent': self.ua.random if self.ua else 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language': 'en-US,en;q=0.5',
            'Accept-Encoding': 'gzip, deflate',
            'Connection': 'keep-alive',
            'Upgrade-Insecure-Requests': '1'
        })

    def search_products(self, search_query: str, max_results: int = 3) -> List[Dict]:
        """
        Search for products across multiple platforms using enhanced API integrations
        """
        # First try the enhanced API manager with multiple sources
        try:
            products = self.api_manager.search_products_multi_source(
                search_query, max_results)
            if products and len(products) >= max_results:
                return products[:max_results]
        except Exception as e:
            logger.error(f"Enhanced API search failed: {str(e)}")

        # Fallback to original methods if API fails
        all_products = []

        # Search Amazon
        try:
            amazon_products = self._search_amazon(search_query, max_results=2)
            all_products.extend(amazon_products)
        except Exception as e:
            logger.error(f"Amazon search failed: {str(e)}")

        # Search eBay if we need more products
        if len(all_products) < max_results:
            try:
                ebay_products = self._search_ebay(
                    search_query, max_results=max_results-len(all_products))
                all_products.extend(ebay_products)
            except Exception as e:
                logger.error(f"eBay search failed: {str(e)}")

        # Search AliExpress if we still need more
        if len(all_products) < max_results:
            try:
                ali_products = self._search_aliexpress(
                    search_query, max_results=max_results-len(all_products))
                all_products.extend(ali_products)
            except Exception as e:
                logger.error(f"AliExpress search failed: {str(e)}")

        return all_products[:max_results]

    def _search_amazon(self, query: str, max_results: int = 2) -> List[Dict]:
        """
        Search Amazon for products (simplified version)
        """
        products = []

        try:
            # For demo purposes, we'll use a simplified approach
            # In production, you might want to use the Amazon API or more sophisticated scraping

            # Sample Amazon-like data with better images
            sample_images = self._get_sample_images(query)
            sample_products = [
                {
                    "name": f"Amazon {query.title()} - Premium Quality",
                    "price": f"${random.randint(15, 200)}.{random.randint(10, 99)}",
                    "image": sample_images[0],
                    "url": f"https://amazon.com/s?k={quote(query)}",
                    "source": "amazon",
                    "rating": round(random.uniform(3.5, 5.0), 1),
                    "reviews": random.randint(50, 5000)
                },
                {
                    "name": f"{query.title()} - Best Seller on Amazon",
                    "price": f"${random.randint(10, 150)}.{random.randint(10, 99)}",
                    "image": sample_images[1],
                    "url": f"https://amazon.com/s?k={quote(query)}",
                    "source": "amazon",
                    "rating": round(random.uniform(4.0, 5.0), 1),
                    "reviews": random.randint(100, 8000)
                }
            ]

            products.extend(sample_products[:max_results])

        except Exception as e:
            logger.error(f"Error searching Amazon: {str(e)}")

        return products

    def _search_ebay(self, query: str, max_results: int = 2) -> List[Dict]:
        """
        Search eBay for products
        """
        products = []

        try:
            # eBay search URL
            search_url = f"https://www.ebay.com/sch/i.html?_nkw={quote(query)}&_sacat=0"

            response = self.scraper.get(
                search_url, timeout=10) if self.scraper else self.session.get(search_url, timeout=10)

            if response.status_code == 200:
                soup = BeautifulSoup(response.content, 'html.parser')

                # Find product listings
                items = soup.find_all(
                    'div', class_='s-item__wrapper')[:max_results]

                for item in items:
                    try:
                        # Extract product information
                        title_elem = item.find('h3', class_='s-item__title')
                        price_elem = item.find('span', class_='s-item__price')
                        image_elem = item.find('img', class_='s-item__image')
                        link_elem = item.find('a', class_='s-item__link')

                        if title_elem and price_elem:
                            title = title_elem.get_text(strip=True)
                            price = price_elem.get_text(strip=True)

                            # Try multiple image attributes and fix URL issues
                            image = ''
                            if image_elem:
                                image = (image_elem.get('src') or
                                         image_elem.get('data-src') or
                                         image_elem.get('data-original') or '')
                                # Fix image URL if it's relative or has issues
                                image = self._fix_image_url(image)

                            url = link_elem.get(
                                'href', '') if link_elem else ''

                            # Clean up title (remove "New Listing" etc.)
                            title = re.sub(
                                r'^(New Listing:|SPONSORED)', '', title).strip()

                            if title and price and 'to' not in price.lower():
                                products.append({
                                    "name": title[:100],  # Limit title length
                                    "price": price,
                                    "image": image,
                                    "url": url,
                                    "source": "ebay"
                                })

                    except Exception as e:
                        logger.warning(f"Error parsing eBay item: {str(e)}")
                        continue

        except Exception as e:
            logger.error(f"Error searching eBay: {str(e)}")

        return products

    def _search_aliexpress(self, query: str, max_results: int = 1) -> List[Dict]:
        """
        Search AliExpress for products (simplified)
        """
        products = []

        try:
            # For demo purposes, using placeholder data
            # AliExpress requires more sophisticated scraping due to their anti-bot measures

            sample_images = self._get_sample_images(query)
            sample_product = {
                "name": f"{query.title()} - AliExpress Deal",
                "price": f"${random.randint(5, 50)}.{random.randint(10, 99)}",
                "image": sample_images[2] if len(sample_images) > 2 else sample_images[0],
                "url": f"https://www.aliexpress.com/wholesale?SearchText={quote(query)}",
                "source": "aliexpress",
                "shipping": "Free shipping"
            }

            products.append(sample_product)

        except Exception as e:
            logger.error(f"Error searching AliExpress: {str(e)}")

        return products

    def _create_selenium_driver(self):
        """
        Create a Selenium Chrome driver with stealth options (if available)
        """
        if not SELENIUM_AVAILABLE:
            logger.warning(
                "Selenium not available - cannot create Chrome driver")
            return None

        try:
            if UC_AVAILABLE:
                # Use undetected Chrome driver if available
                options = uc.ChromeOptions()
                options.add_argument('--headless')
                options.add_argument('--no-sandbox')
                options.add_argument('--disable-dev-shm-usage')
                options.add_argument(
                    '--disable-blink-features=AutomationControlled')
                options.add_experimental_option(
                    "excludeSwitches", ["enable-automation"])
                options.add_experimental_option(
                    'useAutomationExtension', False)

                driver = uc.Chrome(options=options)
                driver.execute_script(
                    "Object.defineProperty(navigator, 'webdriver', {get: () => undefined})")
                return driver
            else:
                # Fallback to regular Chrome driver
                options = Options()
                options.add_argument('--headless')
                options.add_argument('--no-sandbox')
                options.add_argument('--disable-dev-shm-usage')

                service = Service(ChromeDriverManager().install())
                driver = webdriver.Chrome(service=service, options=options)
                return driver

        except Exception as e:
            logger.error(f"Error creating Chrome driver: {str(e)}")
            return None

    def _extract_price(self, price_text: str) -> str:
        """
        Extract and normalize price from text
        """
        if not price_text:
            return "Price not available"

        # Remove extra whitespace and normalize
        price_text = ' '.join(price_text.split())

        # Look for price patterns
        price_patterns = [
            r'\$[\d,]+\.?\d*',  # $XX.XX or $XX
            r'[\d,]+\.?\d*\s*USD',  # XX.XX USD
            r'US\s*\$[\d,]+\.?\d*',  # US $XX.XX
        ]

        for pattern in price_patterns:
            match = re.search(pattern, price_text)
            if match:
                return match.group(0)

        return price_text

    def _get_sample_images(self, query: str) -> List[str]:
        """
        Get sample product images based on query keywords
        """
        # Map common keywords to relevant stock images
        keyword_images = {
            'chocolate': [
                'https://images.unsplash.com/photo-1511381939415-e44015466834?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1549007994-cb92caebd54b?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1606312619070-d48b4c652a52?w=300&h=300&fit=crop'
            ],
            'headphones': [
                'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1487215078519-e21cc028cb29?w=300&h=300&fit=crop'
            ],
            'watch': [
                'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1434056886845-dac89ffe9b56?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1542496658-e33a6d0d50f6?w=300&h=300&fit=crop'
            ],
            'coffee': [
                'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=300&h=300&fit=crop'
            ],
            'book': [
                'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop'
            ],
            'speaker': [
                'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1507646227500-4d389b0012be?w=300&h=300&fit=crop'
            ]
        }

        # Default fallback images
        default_images = [
            'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=300&h=300&fit=crop',
            'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=300&h=300&fit=crop',
            'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=300&h=300&fit=crop'
        ]

        # Find matching images based on query
        query_lower = query.lower()
        for keyword, images in keyword_images.items():
            if keyword in query_lower:
                return images

        return default_images

    def _fix_image_url(self, image_url: str) -> str:
        """
        Fix and validate image URLs
        """
        if not image_url:
            return ''

        # Remove leading/trailing whitespace
        image_url = image_url.strip()

        # Skip data URLs and invalid URLs
        if image_url.startswith('data:') or len(image_url) < 10:
            return ''

        # Fix protocol-relative URLs
        if image_url.startswith('//'):
            image_url = 'https:' + image_url

        # Ensure URL starts with http/https
        if not image_url.startswith(('http://', 'https://')):
            return ''

        # Remove URL parameters that might cause issues
        if '?' in image_url:
            base_url = image_url.split('?')[0]
            # Keep the URL if it ends with common image extensions
            if base_url.lower().endswith(('.jpg', '.jpeg', '.png', '.webp', '.gif')):
                return base_url

        return image_url

    def _validate_product(self, product: Dict) -> bool:
        """
        Validate if product data is complete and valid
        """
        required_fields = ['name', 'price', 'url', 'source']

        for field in required_fields:
            if not product.get(field):
                return False

        # Check if name is reasonable length
        if len(product['name']) < 5 or len(product['name']) > 200:
            return False

        # Check if URL is valid
        if not product['url'].startswith('http'):
            return False

        return True
