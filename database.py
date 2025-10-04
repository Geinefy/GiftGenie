"""
Database utilities for the Gift Suggestion App
"""

import sqlite3
import logging
from typing import List, Dict
import os

logger = logging.getLogger(__name__)

class DatabaseManager:
    """Manages database operations for the application."""
    
    def __init__(self, db_path: str = None):
        if db_path is None:
            db_path = os.path.join(os.path.dirname(__file__), 'data', 'products.db')
        self.db_path = db_path
        self.ensure_data_directory()
        
    def ensure_data_directory(self):
        """Ensure the data directory exists."""
        data_dir = os.path.dirname(self.db_path)
        if not os.path.exists(data_dir):
            os.makedirs(data_dir)
    
    def get_connection(self):
        """Get a database connection."""
        return sqlite3.connect(self.db_path)
    
    def init_database(self):
        """Initialize the database with required tables."""
        conn = self.get_connection()
        cursor = conn.cursor()
        
        # Products table
        cursor.execute('''
            CREATE TABLE IF NOT EXISTS products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                description TEXT,
                price REAL,
                image_url TEXT,
                source_url TEXT,
                category TEXT,
                keywords TEXT,
                scraped_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ''')
        
        # Search history table (optional)
        cursor.execute('''
            CREATE TABLE IF NOT EXISTS search_history (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                query TEXT,
                filters TEXT,
                results_count INTEGER,
                search_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ''')
        
        # Create indexes for better performance
        cursor.execute('CREATE INDEX IF NOT EXISTS idx_products_category ON products(category)')
        cursor.execute('CREATE INDEX IF NOT EXISTS idx_products_price ON products(price)')
        cursor.execute('CREATE INDEX IF NOT EXISTS idx_products_title ON products(title)')
        
        conn.commit()
        conn.close()
        logger.info("Database initialized successfully")
    
    def insert_products(self, products: List[Dict]):
        """Insert multiple products into the database."""
        conn = self.get_connection()
        cursor = conn.cursor()
        
        for product in products:
            cursor.execute('''
                INSERT OR REPLACE INTO products 
                (title, description, price, image_url, source_url, category, keywords)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ''', (
                product.get('title', ''),
                product.get('description', ''),
                product.get('price', 0),
                product.get('image_url', ''),
                product.get('source_url', ''),
                product.get('category', ''),
                product.get('keywords', '')
            ))
        
        conn.commit()
        conn.close()
        logger.info(f"Inserted {len(products)} products into database")
    
    def get_all_products(self) -> List[Dict]:
        """Retrieve all products from the database."""
        conn = self.get_connection()
        cursor = conn.cursor()
        
        cursor.execute('''
            SELECT title, description, price, image_url, source_url, category, keywords
            FROM products
            ORDER BY updated_at DESC
        ''')
        
        products = []
        for row in cursor.fetchall():
            products.append({
                'title': row[0],
                'description': row[1],
                'price': row[2],
                'image_url': row[3],
                'source_url': row[4],
                'category': row[5],
                'keywords': row[6]
            })
        
        conn.close()
        return products
    
    def get_products_by_category(self, category: str) -> List[Dict]:
        """Get products filtered by category."""
        conn = self.get_connection()
        cursor = conn.cursor()
        
        cursor.execute('''
            SELECT title, description, price, image_url, source_url, category, keywords
            FROM products
            WHERE category LIKE ?
            ORDER BY updated_at DESC
        ''', (f'%{category}%',))
        
        products = []
        for row in cursor.fetchall():
            products.append({
                'title': row[0],
                'description': row[1],
                'price': row[2],
                'image_url': row[3],
                'source_url': row[4],
                'category': row[5],
                'keywords': row[6]
            })
        
        conn.close()
        return products
    
    def get_products_by_price_range(self, min_price: float, max_price: float) -> List[Dict]:
        """Get products within a price range."""
        conn = self.get_connection()
        cursor = conn.cursor()
        
        cursor.execute('''
            SELECT title, description, price, image_url, source_url, category, keywords
            FROM products
            WHERE price BETWEEN ? AND ?
            ORDER BY price ASC
        ''', (min_price, max_price))
        
        products = []
        for row in cursor.fetchall():
            products.append({
                'title': row[0],
                'description': row[1],
                'price': row[2],
                'image_url': row[3],
                'source_url': row[4],
                'category': row[5],
                'keywords': row[6]
            })
        
        conn.close()
        return products
    
    def search_products(self, query: str, limit: int = 100) -> List[Dict]:
        """Search products using full-text search."""
        conn = self.get_connection()
        cursor = conn.cursor()
        
        # Simple text search across title, description, and keywords
        search_query = f'%{query}%'
        cursor.execute('''
            SELECT title, description, price, image_url, source_url, category, keywords
            FROM products
            WHERE title LIKE ? OR description LIKE ? OR keywords LIKE ?
            ORDER BY 
                CASE 
                    WHEN title LIKE ? THEN 1
                    WHEN keywords LIKE ? THEN 2
                    ELSE 3
                END,
                updated_at DESC
            LIMIT ?
        ''', (search_query, search_query, search_query, search_query, search_query, limit))
        
        products = []
        for row in cursor.fetchall():
            products.append({
                'title': row[0],
                'description': row[1],
                'price': row[2],
                'image_url': row[3],
                'source_url': row[4],
                'category': row[5],
                'keywords': row[6]
            })
        
        conn.close()
        return products
    
    def clear_products(self):
        """Clear all products from the database."""
        conn = self.get_connection()
        cursor = conn.cursor()
        cursor.execute('DELETE FROM products')
        conn.commit()
        conn.close()
        logger.info("Cleared all products from database")
    
    def get_product_count(self) -> int:
        """Get the total number of products in the database."""
        conn = self.get_connection()
        cursor = conn.cursor()
        cursor.execute('SELECT COUNT(*) FROM products')
        count = cursor.fetchone()[0]
        conn.close()
        return count
    
    def get_categories(self) -> List[str]:
        """Get all unique categories from the database."""
        conn = self.get_connection()
        cursor = conn.cursor()
        cursor.execute('SELECT DISTINCT category FROM products WHERE category IS NOT NULL')
        categories = [row[0] for row in cursor.fetchall()]
        conn.close()
        return categories