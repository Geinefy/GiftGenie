# GiftGenie - Enhanced Product Image Fetching

This document explains how to set up real product image fetching for the GiftGenie application using free APIs and improved scraping methods.

## Overview

The current implementation provides multiple approaches for fetching real product images:

1. **Free API Services** (Recommended)
2. **Enhanced Web Scraping** (Fallback)
3. **High-Quality Placeholder Images** (Default)

## Free API Setup (Recommended)

### 1. SerpAPI - Google Shopping Results

**Best option for real product images**

- **Free Tier**: 250 searches per month
- **Sign up**: https://serpapi.com/
- **Features**: Real product images, prices, ratings, merchant info

**Setup Steps:**

1. Create account at https://serpapi.com/
2. Get your API key from dashboard
3. Add to `ai-part/config.py`: `SERPAPI_KEY = "your_key_here"`

### 2. Amazon Product Advertising API

**Official Amazon product data**

- **Cost**: Free with Amazon Associates account
- **Sign up**: https://affiliate-program.amazon.com/
- **Features**: Official product data, images, prices

**Setup Steps:**

1. Apply for Amazon Associates program
2. Get approved (requires active website/blog)
3. Get API credentials from Amazon Developer Console
4. Add tag to `ai-part/config.py`: `AMAZON_ASSOCIATES_TAG = "your_tag"`

### 3. eBay Browse API

**Official eBay product data**

- **Free Tier**: Available
- **Sign up**: https://developer.ebay.com/
- **Features**: Real eBay listings, images, prices

**Setup Steps:**

1. Create eBay Developer account
2. Create application to get API keys
3. Use Browse API for public product data

## Alternative Free APIs

### RapidAPI Marketplace

- Various marketplace APIs available
- Some free tiers available
- Sign up: https://rapidapi.com/

### ScrapFly

- Web scraping with anti-bot bypass
- Free tier available
- Good for marketplace scraping

## Current Implementation Features

### Enhanced Scraping (No API keys needed)

- Improved image URL extraction
- Better error handling
- High-quality fallback images from Unsplash
- Multiple source integration

### Sample Data Quality

- Category-specific images (headphones, watches, books, etc.)
- Realistic pricing
- Proper product names
- Source attribution

## File Structure

```
ai-part/
├── api_integrations.py     # Enhanced API manager
├── product_scraper.py      # Main scraper with API integration
├── config.py              # API configuration
└── app.py                 # Flask server
```

## Usage

### With API Keys (Recommended)

1. Add API keys to `config.py`
2. Restart Flask server
3. Real product images will be fetched automatically

### Without API Keys (Current)

1. Enhanced placeholder images from Unsplash
2. Category-specific image matching
3. Realistic sample product data

## API Key Priority

1. **SerpAPI** - Best for real product images (250/month free)
2. **Amazon Associates** - Official Amazon data (free but requires approval)
3. **Enhanced Scraping** - Improved fallback methods
4. **Unsplash Images** - High-quality placeholders

## Testing the Implementation

### Test with API Keys

```python
# The system will automatically detect and use available API keys
# Products will have real images from Google Shopping/Amazon
```

### Test without API Keys

```python
# System falls back to enhanced scraping and Unsplash images
# Still provides high-quality, category-matched images
```

## Legal Considerations

### Allowed:

- Using official API services (SerpAPI, Amazon Associates, eBay Browse API)
- Scraping publicly available data for personal/educational use
- Using Unsplash images (free license)

### Best Practices:

- Respect rate limits
- Don't overload servers
- Use official APIs when available
- Cache results to reduce API calls

## Image Quality Improvements

### Before (Previous Implementation)

- Generic placeholder images
- Broken image links
- Poor visual quality

### After (Current Implementation)

- Category-specific images
- High-resolution Unsplash photos
- Real product images when APIs are available
- Fallback chain for reliability

## Performance Optimization

### Caching Strategy

- Cache API responses for 1 hour
- Cache images for faster loading
- Implement rate limiting

### Error Handling

- Graceful fallback to next source
- Detailed error logging
- Retry mechanisms for failed requests

## Monitoring and Analytics

### Track API Usage

- Monitor API call counts
- Track success/failure rates
- Optimize based on performance

### Image Quality Metrics

- Track broken image rates
- Monitor user engagement with products
- A/B test different image sources

## Next Steps for Production

1. **Implement Caching**: Add Redis for API response caching
2. **Add Rate Limiting**: Prevent API quota exhaustion
3. **Image CDN**: Use CloudFlare or similar for image optimization
4. **Database Storage**: Store product data for faster retrieval
5. **Analytics**: Track which sources perform best

## Support

For issues or questions:

1. Check the Flask server logs
2. Verify API key configuration
3. Test individual API endpoints
4. Check network connectivity and firewall settings

This implementation provides a robust foundation for real product image fetching while maintaining fallback options for reliability.
