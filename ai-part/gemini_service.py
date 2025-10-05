import google.generativeai as genai
import json
import logging
from typing import Dict, List, Optional

logger = logging.getLogger(__name__)


class GeminiService:
    def __init__(self, api_key: str):
        if not api_key:
            raise ValueError("Gemini API key is required")

        genai.configure(api_key=api_key)
        self.model = genai.GenerativeModel('gemini-2.0-flash-lite')

    def generate_gift_recommendations(self, user_message: str, context: str = "", preferences: Dict = None) -> Optional[Dict]:
        """
        Generate gift recommendations based on user input and context
        """
        try:
            # Build the prompt for Gemini
            prompt = self._build_recommendation_prompt(
                user_message, context, preferences)

            # Generate response from Gemini
            response = self.model.generate_content(prompt)

            if not response or not response.text:
                logger.error("Empty response from Gemini")
                return None

            # Parse the response
            parsed_response = self._parse_gemini_response(response.text)

            return parsed_response

        except Exception as e:
            logger.error(f"Error generating recommendations: {str(e)}")
            return None

    def generate_follow_up_questions(self, user_message: str, context: str = "") -> List[str]:
        """
        Generate follow-up questions to better understand user preferences
        """
        try:
            prompt = f"""
Based on the user's message about gift giving, generate 2-4 relevant follow-up questions to better understand their needs.

User message: "{user_message}"
Context: "{context}"

Generate questions that help clarify:
- Budget range
- Recipient's interests/hobbies
- Age group
- Relationship to recipient
- Occasion
- Any specific preferences

Return only a JSON array of questions, like:
["What's your budget range?", "What are their main hobbies?"]
"""

            response = self.model.generate_content(prompt)

            if not response or not response.text:
                return []

            # Try to parse JSON response
            try:
                questions = json.loads(response.text.strip())
                if isinstance(questions, list):
                    return questions[:4]  # Limit to 4 questions
            except json.JSONDecodeError:
                # If JSON parsing fails, extract questions manually
                lines = response.text.strip().split('\n')
                questions = []
                for line in lines:
                    line = line.strip()
                    if line.startswith('"') and line.endswith('"'):
                        questions.append(line[1:-1])
                    elif line.startswith('- '):
                        questions.append(line[2:])
                return questions[:4]

            return []

        except Exception as e:
            logger.error(f"Error generating questions: {str(e)}")
            return []

    def _build_recommendation_prompt(self, user_message: str, context: str, preferences: Dict) -> str:
        """
        Build a comprehensive prompt for gift recommendations
        """
        prompt = f"""
You are an expert gift recommendation assistant. Based on the user's message and any additional context, provide gift recommendations.

User message: "{user_message}"
Context: "{context}"
User preferences: {json.dumps(preferences) if preferences else "None"}

Your response should include:
1. 2-4 follow-up questions if more information is needed
2. Gift recommendations in a specific format
3. A friendly response explaining your suggestions

For gift recommendations, provide them as key-value pairs where:
- Key: category/type of gift (e.g., "tech_gadgets", "books", "clothing")
- Value: specific search keywords that would find good products (e.g., "wireless bluetooth headphones", "mystery novels", "casual t-shirts")

Return your response in this JSON format:
{{
    "questions": ["question1", "question2"],
    "recommendations": {{
        "category1": "search keywords",
        "category2": "search keywords"
    }},
    "response": "Your friendly explanation of the suggestions"
}}

Guidelines:
- Keep categories descriptive but concise (snake_case)
- Make search keywords specific enough to find relevant products
- Include 2-5 different gift categories
- Questions should be helpful but not overwhelming
- Response should be warm and helpful

Example categories: tech_gadgets, books, home_decor, clothing, fitness_equipment, art_supplies, kitchen_tools, games, jewelry, outdoor_gear
"""
        return prompt

    def _parse_gemini_response(self, response_text: str) -> Dict:
        """
        Parse Gemini's response and ensure it has the correct format
        """
        try:
            # Clean the response text - remove markdown code blocks if present
            clean_text = response_text.strip()

            # Remove ```json and ``` markers if present
            if clean_text.startswith('```json'):
                clean_text = clean_text[7:]  # Remove ```json
            if clean_text.startswith('```'):
                clean_text = clean_text[3:]   # Remove ```
            if clean_text.endswith('```'):
                clean_text = clean_text[:-3]  # Remove ending ```

            clean_text = clean_text.strip()

            # Try to parse as JSON
            parsed = json.loads(clean_text)

            # Validate the structure
            if not isinstance(parsed, dict):
                raise ValueError("Response is not a dictionary")

            # Ensure required fields exist and add success flag
            if 'recommendations' not in parsed:
                parsed['recommendations'] = {}

            if 'questions' not in parsed:
                parsed['questions'] = []

            if 'response' not in parsed:
                parsed['response'] = "Here are some gift suggestions for you!"

            # Add success flag
            parsed['success'] = True

            # Validate recommendations format
            if not isinstance(parsed['recommendations'], dict):
                parsed['recommendations'] = {}

            # Validate questions format
            if not isinstance(parsed['questions'], list):
                parsed['questions'] = []

            logger.info(
                f"Successfully parsed response with {len(parsed['recommendations'])} recommendations")
            return parsed

        except json.JSONDecodeError as e:
            logger.warning(
                f"Failed to parse JSON response: {str(e)}, attempting manual parsing")
            return self._manual_parse_response(response_text)

    def _manual_parse_response(self, response_text: str) -> Dict:
        """
        Manually parse response if JSON parsing fails
        """
        # Default structure
        result = {
            "questions": [],
            "recommendations": {},
            "response": response_text.strip(),
            "success": True
        }

        # Try to extract structured information
        lines = response_text.split('\n')
        current_section = None

        for line in lines:
            line = line.strip()

            if 'questions:' in line.lower():
                current_section = 'questions'
            elif 'recommendations:' in line.lower():
                current_section = 'recommendations'
            elif line.startswith('- ') and current_section == 'questions':
                result['questions'].append(line[2:])
            elif ':' in line and current_section == 'recommendations':
                parts = line.split(':', 1)
                if len(parts) == 2:
                    key = parts[0].strip().lower().replace(' ', '_')
                    value = parts[1].strip()
                    result['recommendations'][key] = value

        return result
