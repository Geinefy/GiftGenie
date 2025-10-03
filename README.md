# GiftGenie - AI-Powered Gift Recommendation System

## 🎁 Overview

GiftGenie is a complete gift recommendation system that combines a React frontend with a Python AI backend to provide personalized gift suggestions. The system uses Google Gemini AI to understand user preferences and web scraping to find actual products from various marketplaces.

## 🏗️ Architecture

```
GiftGenie/
├── frontend/          # React + TypeScript frontend
│   ├── src/
│   │   ├── components/
│   │   │   ├── chat/   # Chat widget components
│   │   │   └── gifts/  # Gift display components
│   │   ├── services/   # API service layer
│   │   └── pages/      # Application pages
│   └── ...
├── ai-part/           # Python AI backend
│   ├── app.py         # Flask API server
│   ├── gemini_service.py  # AI recommendation service
│   ├── product_scraper.py # Web scraping service
│   └── utils.py       # Utility functions
└── backend/          # Laravel/Django backend (future)
```

## 🚀 Features

### Frontend Features

- **Interactive Chat Interface**: Modern chat widget for user interaction
- **Real-time AI Responses**: Powered by Google Gemini AI
- **Product Display**: Beautiful cards showing product images, prices, and links
- **Question Suggestions**: AI-generated follow-up questions
- **Responsive Design**: Works on desktop and mobile
- **TypeScript**: Full type safety

### Backend Features

- **AI-Powered Recommendations**: Uses Google Gemini to understand preferences
- **Multi-Source Product Search**: Scrapes Amazon, eBay, and AliExpress
- **Smart Question Generation**: Asks relevant follow-up questions
- **RESTful API**: Clean API endpoints for frontend integration
- **Error Handling**: Robust error handling and logging
- **Configurable**: Easy configuration through environment variables

## 📋 Prerequisites

### Frontend

- Node.js 18+
- npm or yarn or bun

### Backend

- Python 3.8+
- pip (Python package manager)
- Google Gemini API key

## 🛠️ Installation & Setup

### 1. Python Backend Setup

```bash
# Navigate to the AI backend directory
cd ai-part

# Create virtual environment
python -m venv venv

# Activate virtual environment
# On Windows:
venv\Scripts\activate
# On macOS/Linux:
source venv/bin/activate

# Install dependencies
pip install -r requirements.txt

# Create environment file
cp .env.example .env

# Edit .env and add your Gemini API key
# GEMINI_API_KEY=your_gemini_api_key_here
```

### 2. Get Gemini API Key

1. Go to [Google AI Studio](https://makersuite.google.com/app/apikey)
2. Create a new API key
3. Copy the API key to your `.env` file

### 3. Start the Python Server

```bash
# Option 1: Use the batch script (Windows)
start_server.bat

# Option 2: Run directly
python app.py

# The server will start on http://localhost:5000
```

### 4. Frontend Setup

```bash
# Navigate to the frontend directory
cd frontend

# Install dependencies
npm install
# or
bun install

# Start the development server
npm run dev
# or
bun dev

# The frontend will start on http://localhost:5173
```

## 🔧 Configuration

### Python Backend Configuration

Edit `ai-part/.env`:

```env
GEMINI_API_KEY=your_gemini_api_key_here
FLASK_ENV=development
FLASK_DEBUG=True
```

Edit `ai-part/config.json` for advanced settings:

```json
{
  "server": {
    "host": "0.0.0.0",
    "port": 5000,
    "debug": true
  },
  "scraping": {
    "max_results_per_source": 3,
    "timeout_seconds": 10,
    "retry_attempts": 2
  },
  "ai": {
    "max_questions": 4,
    "max_recommendations": 6,
    "temperature": 0.7
  }
}
```

### Frontend Configuration

The frontend automatically connects to the Python API at `http://localhost:5000`.
To change this, edit `frontend/src/services/giftService.ts`:

```typescript
const API_BASE_URL = "http://your-python-server:5000/api";
```

## 🌐 API Endpoints

### Health Check

```http
GET /api/health
```

### Chat with AI

```http
POST /api/chat
Content-Type: application/json

{
  "message": "I need a gift for my tech-savvy brother",
  "context": "Previous conversation context",
  "preferences": {"budget": "50-100"}
}
```

### Search Products

```http
POST /api/search-products
Content-Type: application/json

{
  "recommendations": {
    "tech_gadgets": "wireless headphones",
    "books": "programming books"
  }
}
```

### Generate Questions

```http
POST /api/generate-questions
Content-Type: application/json

{
  "message": "I want to buy a gift",
  "context": ""
}
```

## 🧪 Testing

### Test the Python API

```bash
cd ai-part
python test_api.py
```

### Test the Frontend

```bash
cd frontend
npm run build  # Test build
npm run lint   # Check code quality
```

## 🛒 Supported Marketplaces

Currently supported:

- **Amazon**: Product search and details
- **eBay**: Auction and Buy-It-Now items
- **AliExpress**: International marketplace

## 🤖 AI Capabilities

The system uses Google Gemini AI to:

- Understand user preferences and context
- Generate relevant follow-up questions
- Create structured gift recommendations
- Provide friendly, conversational responses

## 📱 User Experience Flow

1. **User opens chat widget**
2. **Describes gift recipient or occasion**
3. **AI asks clarifying questions**
4. **User provides additional details**
5. **AI generates gift category recommendations**
6. **System searches for actual products**
7. **User sees product cards with images, prices, and links**
8. **User can click to visit marketplace**

## 🔮 Future Enhancements

### Planned Features

- **Laravel/Django Backend**: User accounts and chat history
- **Advanced Filtering**: Price range, brand preferences
- **Wishlist System**: Save favorite products
- **Social Integration**: Share gift ideas
- **Mobile App**: React Native mobile application
- **More Marketplaces**: Etsy, Target, Walmart integration
- **AI Improvements**: Better context understanding
- **Analytics**: Track popular gifts and trends

### Database Schema (Future)

```sql
-- Users table
users: id, email, name, preferences, created_at

-- Conversations table
conversations: id, user_id, title, context, created_at

-- Messages table
messages: id, conversation_id, role, content, metadata

-- Products table
products: id, name, price, image_url, marketplace_url, source

-- Recommendations table
recommendations: id, conversation_id, category, products, created_at
```

## 🐛 Troubleshooting

### Common Issues

**"Failed to get response"**

- Check if Python server is running on port 5000
- Verify Gemini API key is set correctly
- Check network connectivity

**"No products found"**

- Some marketplaces may block requests
- Try different search terms
- Check scraper logs for errors

**CORS Issues**

- Backend includes CORS headers
- Check if frontend URL is correct

**Rate Limiting**

- Gemini API has rate limits
- Add delays between requests if needed

### Debug Mode

Enable debug logging in Python:

```python
import logging
logging.basicConfig(level=logging.DEBUG)
```

## 📄 License

This project is licensed under the MIT License.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📞 Support

For issues and questions:

- Create a GitHub issue
- Check the troubleshooting section
- Review API documentation

---

**Happy Gift Finding! 🎁**
