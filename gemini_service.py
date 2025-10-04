"""
Google Gemini API Service
Generates product suggestions based on user requirements.
"""

import google.generativeai as genai
import json
import logging
from typing import List, Dict
from config import Config

logger = logging.getLogger(__name__)

class GeminiService:
    """Service for interacting with Google Gemini API to generate product suggestions."""
    
    def __init__(self):
        """Initialize Gemini service with API key."""
        if Config.GEMINI_API_KEY == 'your-gemini-api-key-here':
            logger.warning("Gemini API key not configured. Please set GEMINI_API_KEY in config.py")
            self.model = None
        else:
            try:
                genai.configure(api_key=Config.GEMINI_API_KEY)
                self.model = genai.GenerativeModel(Config.GEMINI_MODEL)
                logger.info("Gemini API initialized successfully")
            except Exception as e:
                logger.error(f"Failed to initialize Gemini API: {str(e)}")
                self.model = None
    
    def generate_product_ideas(
        self, 
        query: str, 
        occasion: str = "", 
        interests: str = "", 
        budget_range: str = "", 
        country: str = "US"
    ) -> List[str]:
        """
        Generate product ideas based on user requirements.
        
        Args:
            query: Main search query from user
            occasion: Special occasion (birthday, christmas, etc.)
            interests: User interests (tech, fitness, etc.)
            budget_range: Budget range description
            country: Target country for localized suggestions
        
        Returns:
            List of product idea strings
        """
        if not self.model:
            logger.warning("Gemini API not available, using fallback product ideas")
            return self._get_fallback_ideas(query, occasion, interests)
        
        try:
            # Construct prompt for Gemini
            prompt = self._build_prompt(query, occasion, interests, budget_range, country)
            
            # Generate content using Gemini
            response = self.model.generate_content(prompt)
            
            # Parse response to extract product ideas
            product_ideas = self._parse_response(response.text)
            
            logger.info(f"Generated {len(product_ideas)} product ideas from Gemini")
            return product_ideas
            
        except Exception as e:
            logger.error(f"Error generating product ideas with Gemini: {str(e)}")
            return self._get_fallback_ideas(query, occasion, interests)
    
    def _build_prompt(
        self, 
        query: str, 
        occasion: str, 
        interests: str, 
        budget_range: str, 
        country: str
    ) -> str:
        """Build prompt for Gemini API."""
        prompt = f"""
You are a helpful shopping assistant. Generate a list of specific product suggestions based on the following requirements:

Main Query: {query}
Occasion: {occasion if occasion else 'General'}
Interests: {interests if interests else 'General'}
Budget: {budget_range if budget_range else 'Flexible'}
Country: {country}

Please provide 8-12 specific product suggestions that would be good gifts or purchases for this person. 
Focus on actual product names that can be searched on e-commerce websites.

Requirements:
1. Each suggestion should be 2-4 words (specific product names)
2. Consider products available in {country}
3. Make suggestions searchable on popular e-commerce sites
4. Include a variety of price ranges if no budget specified
5. Consider the occasion and interests

Format your response as a simple list, one product per line, like:
wireless bluetooth headphones
personalized coffee mug
gaming mechanical keyboard
fitness tracker watch
portable phone charger

Do not include explanations, just the product list.
"""
        return prompt
    
    def _parse_response(self, response_text: str) -> List[str]:
        """Parse Gemini response to extract product ideas."""
        try:
            # Split response into lines and clean up
            lines = response_text.strip().split('\n')
            product_ideas = []
            
            for line in lines:
                # Clean up each line
                line = line.strip()
                # Remove bullet points, numbers, dashes
                line = line.lstrip('•-*123456789. ')
                
                if line and len(line.split()) >= 2:  # At least 2 words
                    # Take first 4 words to keep it searchable
                    words = line.split()[:4]
                    product_idea = ' '.join(words).lower()
                    
                    if product_idea and product_idea not in product_ideas:
                        product_ideas.append(product_idea)
            
            # Limit to maximum 12 ideas
            return product_ideas[:12]
                        
        except Exception as e:
            logger.error(f"Error parsing Gemini response: {str(e)}")
            return []
    
    def _get_fallback_ideas(self, query: str, occasion: str, interests: str) -> List[str]:
        """Generate fallback product ideas when Gemini is not available."""
        fallback_ideas = [
            "wireless bluetooth headphones",
            "smartphone phone case",
            "portable power bank",
            "coffee travel mug",
            "desk organization set",
            "led string lights",
            "bluetooth speaker portable",
            "fitness resistance bands",
            "phone camera lens",
            "wireless charging pad"
        ]
        
        # Try to customize based on interests
        if interests:
            interest_keywords = interests.lower().split()
            if 'tech' in interest_keywords or 'gaming' in interest_keywords:
                fallback_ideas.extend([
                    "gaming mouse pad",
                    "usb cable organizer",
                    "laptop cooling stand",
                    "mechanical keyboard compact"
                ])
            elif 'fitness' in interest_keywords or 'health' in interest_keywords:
                fallback_ideas.extend([
                    "yoga exercise mat",
                    "water bottle insulated",
                    "fitness tracker band",
                    "protein shaker bottle"
                ])
            elif 'cooking' in interest_keywords or 'kitchen' in interest_keywords:
                fallback_ideas.extend([
                    "kitchen knife set",
                    "silicone baking mats",
                    "spice rack organizer",
                    "measuring cups set"
                ])
        
        return fallback_ideas[:10]