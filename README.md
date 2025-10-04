# Gift Suggestion App with AI-Powered Product Discovery

An intelligent web application that uses Google Gemini AI to generate product ideas and then scrapes real e-commerce websites to find actual products. The app provides a complete pipeline from user requirements to real product suggestions.

## 🚀 How It Works

1. **User Input**: User enters requirements (gift type, budget, occasion, interests, country)
2. **AI Product Ideas**: Google Gemini API generates specific product ideas based on requirements
3. **Real Product Search**: Scraper searches e-commerce sites for actual products matching the AI ideas
4. **Results Display**: Real products are displayed with name, price, link, and image

## ✨ Features

- **AI-Powered Suggestions**: Uses Google Gemini API to generate intelligent product ideas
- **Real Product Scraping**: Searches actual e-commerce websites for products
- **Country-Specific Results**: Adapts to popular e-commerce sites by country
- **Price Filtering**: Filter results by budget range
- **Responsive Design**: Works on desktop and mobile devices
- **Fallback System**: If scraping fails for one idea, continues with others
- **Multi-Source Scraping**: Searches multiple APIs and websites

## 🛠️ Installation

### Prerequisites
- Python 3.8 or higher
- Google Gemini API key (free from Google AI Studio)

### Setup Steps

1. **Clone the repository**:
```bash
git clone <repository-url>
cd gift-suggestion-app
```

2. **Install dependencies**:
```bash
pip install -r requirements.txt
```

3. **Set up Google Gemini API Key**:
   - Go to [Google AI Studio](https://aistudio.google.com/)
   - Create a free account and get your API key
   - Option 1 - Environment Variable (Recommended):
     ```bash
     # Windows PowerShell
     $env:GEMINI_API_KEY="your-actual-api-key-here"
     
     # Windows Command Prompt
     set GEMINI_API_KEY=your-actual-api-key-here
     
     # Linux/Mac
     export GEMINI_API_KEY="your-actual-api-key-here"
     ```
   - Option 2 - Edit config.py directly:
     ```python
     GEMINI_API_KEY = 'your-actual-api-key-here'
     ```

4. **Run the application**:
```bash
python app.py
```

5. **Open in browser**:
   Navigate to `http://localhost:5000`

## 🌍 Supported Countries & E-commerce Sites

The app adapts its scraping strategy based on the selected country:

| Country | Primary Sites |
|---------|---------------|
| 🇺🇸 USA | Amazon.com, eBay.com, Walmart.com |
| 🇬🇧 UK | Amazon.co.uk, eBay.co.uk, Argos.co.uk |
| 🇮🇳 India | Amazon.in, Flipkart.com, Snapdeal.com |
| 🇨🇦 Canada | Amazon.ca, eBay.ca, BestBuy.ca |
| 🇦🇺 Australia | Amazon.com.au, eBay.com.au, Catch.com.au |
| 🇧🇩 Bangladesh | Daraz.com.bd, Pickaboo.com, AjkerDeal.com |

*Note: The app uses API-based sources and demo sites for reliable results. Direct scraping of major e-commerce sites may be limited by their terms of service.*

## 📱 Usage

1. **Enter Requirements**:
   - Describe what you're looking for
   - Select occasion (birthday, christmas, etc.)
   - Add interests (tech, fitness, cooking, etc.)
   - Set budget range (optional)
   - Choose country

2. **AI Processing**:
   - App sends your requirements to Google Gemini
   - Gemini generates specific product ideas
   - Example: "wireless headphones", "coffee maker", "fitness tracker"

3. **Product Search**:
   - Scraper searches for each product idea
   - Finds real products with prices and links
   - Filters by your budget if specified

4. **View Results**:
   - Browse real products matching your needs
   - Click product links to view on original sites
   - All products show actual prices and availability

## 🔧 Configuration

### Environment Variables
- `GEMINI_API_KEY`: Your Google Gemini API key
- `SECRET_KEY`: Flask secret key (optional)

### Config File (config.py)
```python
# Google Gemini API settings
GEMINI_API_KEY = 'your-api-key-here'
GEMINI_MODEL = 'gemini-1.5-flash'

# Scraping settings
SCRAPING_DELAY = 1  # seconds between requests
MAX_RESULTS_PER_SEARCH = 20
REQUEST_TIMEOUT = 10
```

## 🏗️ Project Structure

```
gift-suggestion-app/
├── app.py                 # Main Flask application
├── config.py              # Configuration settings
├── gemini_service.py      # Google Gemini API integration
├── database.py            # Database operations
├── recommendation_engine.py # Product filtering and sorting
├── requirements.txt       # Python dependencies
├── README.md             # This file
├── scrapers/
│   ├── __init__.py
│   └── product_scraper.py # Web scraping logic
├── templates/
│   └── index.html        # Main web interface
├── static/
│   ├── style.css         # Styling
│   ├── script.js         # Frontend JavaScript
│   └── placeholder-image.svg
└── data/
    └── products.db       # SQLite database (auto-created)
```

## 🔍 Technical Details

### AI Pipeline
1. **Prompt Engineering**: Carefully crafted prompts for Gemini to generate searchable product names
2. **Response Parsing**: Extracts clean product ideas from Gemini's natural language response
3. **Fallback System**: Uses predefined product ideas if Gemini API is unavailable

### Scraping Strategy
1. **API-First Approach**: Prioritizes reliable APIs over direct website scraping
2. **Multiple Sources**: Searches FakeStore API, DummyJSON, and demo sites
3. **Error Handling**: Continues with other ideas if one product search fails
4. **Respectful Scraping**: Includes delays and respects robots.txt

### Data Flow
```
User Input → Gemini API → Product Ideas → Web Scraping → Price Filter → Display Results
```

## 🚨 Important Notes

- **API Key Required**: The app requires a valid Google Gemini API key to function
- **Rate Limits**: Google Gemini has free tier rate limits (check Google AI Studio)
- **Scraping Ethics**: The app uses APIs and demo sites to respect website terms of service
- **Local Development**: This is designed for local development, not production deployment

## 🛡️ Troubleshooting

### Common Issues

1. **"Gemini API key not configured"**:
   - Make sure you've set the GEMINI_API_KEY environment variable or updated config.py

2. **No products found**:
   - Check your internet connection
   - Verify the Gemini API key is valid
   - Try broader search terms

3. **Installation errors**:
   - Make sure you're using Python 3.8+
   - Try: `pip install --upgrade pip` then reinstall requirements

4. **Port already in use**:
   - Change the port in app.py: `app.run(port=5001)`

### Debugging
Enable verbose logging by setting:
```python
logging.basicConfig(level=logging.DEBUG)
```

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## ⚠️ Disclaimer

This application is for educational purposes. When scraping websites, always respect robots.txt files and terms of service. The app is designed to use APIs and demo sites to avoid violating website policies.