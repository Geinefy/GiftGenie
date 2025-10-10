// API base URL - change this to match your Python API server
const API_BASE_URL = 'http://localhost:5001/api';

export interface ChatResponse {
  questions: string[];
  recommendations: Record<string, string>;
  response: string;
  success: boolean;
}

export interface ProductSearchResponse {
  products: Record<string, Product[]>;
  total_categories: number;
  total_products: number;
}

export interface Product {
  name: string;
  price: string;
  image: string;
  url: string;
  source: string;
  rating?: number;
  reviews?: number;
  shipping?: string;
}

export interface QuestionsResponse {
  questions: string[];
  count: number;
}

class GiftRecommendationService {
  private baseUrl: string;

  constructor(baseUrl: string = API_BASE_URL) {
    this.baseUrl = baseUrl;
  }

  async sendChatMessage(
    message: string, 
    context: string = '', 
    preferences: Record<string, any> = {}
  ): Promise<ChatResponse> {
    try {
      const response = await fetch(`${this.baseUrl}/chat`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          message,
          context,
          preferences
        })
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error sending chat message:', error);
      throw error;
    }
  }

  async searchProducts(recommendations: Record<string, string>): Promise<ProductSearchResponse> {
    try {
      const response = await fetch(`${this.baseUrl}/search-products`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          recommendations
        })
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error searching products:', error);
      throw error;
    }
  }

  async generateQuestions(message: string, context: string = ''): Promise<QuestionsResponse> {
    try {
      const response = await fetch(`${this.baseUrl}/generate-questions`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          message,
          context
        })
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error generating questions:', error);
      throw error;
    }
  }

  async checkHealth(): Promise<boolean> {
    try {
      const response = await fetch(`${this.baseUrl}/health`);
      return response.ok;
    } catch (error) {
      console.error('Health check failed:', error);
      return false;
    }
  }
}

export const giftService = new GiftRecommendationService();