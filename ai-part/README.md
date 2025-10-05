# AI Gift Recommendation API

A Python Flask API for the GiftGenie application that provides AI-powered gift recommendations and web scraping capabilities.

## Features

- **AI-Powered Recommendations**: Uses Google Gemini AI to generate personalized gift suggestions
- **Multi-Source Product Scraping**: Fetches product data from Amazon, eBay, and AliExpress
- **Smart Question Generation**: Asks relevant follow-up questions to better understand user preferences
- **Product Image & Pricing**: Returns product images, prices, and marketplace links
- **CORS-Enabled**: Ready for frontend integration

## Setup

1. Install dependencies:

```bash
pip install -r requirements.txt
```

2. Create a `.env` file with your API keys:

```
GEMINI_API_KEY=your_gemini_api_key_here
```

3. Run the server:

```bash
python app.py
```

## API Endpoints

### POST /api/chat

Generate gift recommendations based on user input and context.

**Request Body:**

```json
{
  "message": "I need a gift for my tech-savvy brother",
  "context": "Previous conversation context (optional)"
}
```

**Response:**

```json
{
  "questions": ["What's his age range?", "What's your budget?"],
  "recommendations": {
    "smartphone_accessories": "wireless charger",
    "gadgets": "smart home device"
  },
  "response": "AI generated response text"
}
```

### POST /api/search-products

Search for products based on gift recommendations.

**Request Body:**

```json
{
  "recommendations": {
    "smartphone_accessories": "wireless charger",
    "gadgets": "smart home device"
  }
}
```

**Response:**

```json
{
  "products": {
    "smartphone_accessories": [
      {
        "name": "Wireless Charging Pad",
        "price": "$25.99",
        "image": "https://...",
        "url": "https://amazon.com/...",
        "source": "amazon"
      }
    ]
  }
}
```

## Architecture

- `app.py` - Main Flask application
- `gemini_service.py` - AI recommendation service
- `scrapers/` - Web scraping modules
- `utils.py` - Utility functions
