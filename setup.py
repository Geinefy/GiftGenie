"""
Setup script for Gift Suggestion App
Initializes the database and loads sample data.
"""

import os
import sys
import logging

# Add current directory to Python path
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from database import DatabaseManager
from scrapers.product_scraper import ProductScraper

# Configure logging
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')
logger = logging.getLogger(__name__)

def setup_database():
    """Set up the database with initial data."""
    try:
        logger.info("Setting up database...")
        
        # Initialize database manager
        db = DatabaseManager()
        
        # Create database and tables
        db.init_database()
        logger.info("Database tables created successfully")
        
        # Check if we already have data
        product_count = db.get_product_count()
        if product_count > 0:
            logger.info(f"Database already has {product_count} products")
            return True
        
        # Load sample data
        logger.info("Loading sample data...")
        scraper = ProductScraper()
        sample_products = scraper.load_sample_data()
        
        # Insert into database
        db.insert_products(sample_products)
        logger.info(f"Successfully inserted {len(sample_products)} sample products")
        
        return True
        
    except Exception as e:
        logger.error(f"Database setup failed: {str(e)}")
        return False

def verify_setup():
    """Verify that the setup was successful."""
    try:
        logger.info("Verifying setup...")
        
        # Test database connection
        db = DatabaseManager()
        product_count = db.get_product_count()
        logger.info(f"Database contains {product_count} products")
        
        # Test categories
        categories = db.get_categories()
        logger.info(f"Available categories: {', '.join(categories)}")
        
        # Test recommendation engine
        from recommendation_engine import RecommendationEngine
        engine = RecommendationEngine()
        logger.info("Recommendation engine initialized successfully")
        
        # Test a simple recommendation
        products = db.get_all_products()
        if products:
            recommendations = engine.get_recommendations(products[:5], "test query", max_results=3)
            logger.info(f"Generated {len(recommendations)} test recommendations")
        
        logger.info("✅ Setup verification completed successfully!")
        return True
        
    except Exception as e:
        logger.error(f"Setup verification failed: {str(e)}")
        return False

def create_directories():
    """Create necessary directories."""
    directories = ['data', 'logs']
    
    for directory in directories:
        if not os.path.exists(directory):
            os.makedirs(directory)
            logger.info(f"Created directory: {directory}")

def main():
    """Main setup function."""
    print("🔧 Setting up Gift Suggestion App")
    print("=" * 40)
    
    # Create directories
    create_directories()
    
    # Setup database
    if not setup_database():
        print("❌ Database setup failed!")
        sys.exit(1)
    
    # Verify setup
    if not verify_setup():
        print("❌ Setup verification failed!")
        sys.exit(1)
    
    print("\n✅ Setup completed successfully!")
    print("\nNext steps:")
    print("1. Run the application: python app.py")
    print("2. Open your browser to: http://localhost:5000")
    print("3. Or run the demo: python demo.py")

if __name__ == "__main__":
    main()