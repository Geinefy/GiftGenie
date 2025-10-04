#!/usr/bin/env python3
"""Add more diverse products to the database."""

import sqlite3

def add_more_products():
    # Additional products for better variety
    additional_products = [
        {
            'title': 'Sony WH-1000XM4 Wireless Noise Canceling Headphones',
            'description': 'Industry-leading noise cancellation with Dual Noise Sensor technology. Up to 30-hour battery life.',
            'price': 279.99,
            'image_url': 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=300',
            'source_url': 'https://www.sony.com/electronics/headband-headphones/wh-1000xm4',
            'category': 'Electronics',
            'keywords': 'sony headphones wireless noise canceling bluetooth premium'
        },
        {
            'title': 'Kindle Paperwhite E-reader',
            'description': 'Waterproof, 6.8" display, and weeks of battery life. Perfect for book lovers.',
            'price': 139.99,
            'image_url': 'https://images.unsplash.com/photo-1481277542470-605612bd2d61?w=300',
            'source_url': 'https://www.amazon.com/kindle-paperwhite',
            'category': 'Books & Media',
            'keywords': 'kindle paperwhite ereader books reading waterproof amazon'
        },
        {
            'title': 'Yeti Rambler 20 oz Tumbler',
            'description': 'Double-wall vacuum insulated stainless steel tumbler. Keeps drinks hot or cold.',
            'price': 34.95,
            'image_url': 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=300',
            'source_url': 'https://www.yeti.com/drinkware/tumblers/21071500021.html',
            'category': 'Sports & Fitness',  
            'keywords': 'yeti rambler tumbler insulated stainless steel drinks coffee'
        },
        {
            'title': 'Lego Creator Expert Flower Bouquet',
            'description': 'Build your own flower bouquet that never wilts. Perfect for display or gifting.',
            'price': 59.99,
            'image_url': 'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=300',
            'source_url': 'https://www.lego.com/en-us/product/flower-bouquet-10280',
            'category': 'Toys & Games',
            'keywords': 'lego creator flowers bouquet building toys gifts decoration'
        },
        {
            'title': 'Hamilton Beach Professional Blender',
            'description': 'Powerful 1400-watt motor with multiple speed settings. Perfect for smoothies and soups.',
            'price': 89.95,
            'image_url': 'https://images.unsplash.com/photo-1585515656973-794576e35b4d?w=300',
            'source_url': 'https://hamiltonbeach.com/professional-blender-58850',
            'category': 'Kitchen',
            'keywords': 'hamilton beach blender professional kitchen smoothie powerful motor'
        },
        {
            'title': 'Adidas Ultraboost 22 Running Shoes',
            'description': 'Responsive cushioning and energy return. Perfect for running and everyday wear.',
            'price': 189.95,
            'image_url': 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300',
            'source_url': 'https://www.adidas.com/us/ultraboost-22-shoes',
            'category': 'Fashion & Accessories',
            'keywords': 'adidas ultraboost running shoes athletic footwear sports comfort'
        },
        {
            'title': 'Anthropologie Capri Blue Candle',
            'description': 'Hand-poured soy candle with volcano scent. Burns for up to 85 hours.',
            'price': 36.00,
            'image_url': 'https://images.unsplash.com/photo-1602874801006-41b46a0b4a4c?w=300',
            'source_url': 'https://www.anthropologie.com/candles-fragrance',
            'category': 'Home & Garden',
            'keywords': 'anthropologie candle capri blue volcano scent home fragrance soy'
        }
    ]

    # Add to database
    conn = sqlite3.connect('data/products.db')
    cursor = conn.cursor()

    for product in additional_products:
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

    print(f'Added {len(additional_products)} additional products to database')

    # Check total count
    conn = sqlite3.connect('data/products.db')
    cursor = conn.cursor()
    cursor.execute('SELECT COUNT(*) FROM products')
    total = cursor.fetchone()[0]
    conn.close()

    print(f'Total products in database: {total}')

if __name__ == "__main__":
    add_more_products()