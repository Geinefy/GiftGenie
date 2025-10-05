// Backend API base URL - Laravel backend acts as bridge
const API_BASE_URL = 'http://localhost:8000/api/v1/gifts';

export interface ChatResponse {
  success: boolean;
  data: {
    session_id: string;
    history_id: number;
    response: string;
    questions: string[];
    timestamp: string;
  };
  message?: string;
  errors?: any;
}

export interface ProductSearchResponse {
  success: boolean;
  data: {
    products: Product[];
    cached: boolean;
    timestamp: string;
  };
  message?: string;
  errors?: any;
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
  condition?: string;
  merchant?: string;
}

export interface HistoryResponse {
  success: boolean;
  data: {
    history: HistoryItem[];
  };
  message?: string;
  errors?: any;
}

export interface HistoryItem {
  id: number;
  query: string;
  ai_response: any;
  fetched_items: Product[];
  timestamp: string;
}

export interface HealthResponse {
  success: boolean;
  ai_service: {
    status: 'online' | 'offline';
    response_time?: number;
    error?: string;
  };
}

class GiftRecommendationService {
  private baseUrl: string;
  private sessionId: string | null = null;
  private userId: string | null = null;

  constructor(baseUrl: string = API_BASE_URL) {
    this.baseUrl = baseUrl;
    // Try to get session ID from localStorage
    this.sessionId = localStorage.getItem('giftgenie_session_id');
    this.userId = localStorage.getItem('giftgenie_user_id'); // For future auth
  }

  /**
   * Start a new chat conversation with the AI
   */
  async sendChatMessage(
    message: string,
    sessionId?: string
  ): Promise<ChatResponse> {
    try {
      const response = await fetch(`${this.baseUrl}/chat`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          message,
          session_id: sessionId || this.sessionId,
          user_id: this.userId,
        })
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data: ChatResponse = await response.json();
      
      // Store session ID for future requests
      if (data.success && data.data.session_id) {
        this.sessionId = data.data.session_id;
        localStorage.setItem('giftgenie_session_id', this.sessionId);
      }

      return data;
    } catch (error) {
      console.error('Error sending chat message:', error);
      throw error;
    }
  }

  /**
   * Search for products based on user query
   */
  async searchProducts(
    query: string, 
    maxResults: number = 6,
    historyId?: number
  ): Promise<ProductSearchResponse> {
    try {
      if (!this.sessionId) {
        throw new Error('No active session. Please start a chat first.');
      }

      const response = await fetch(`${this.baseUrl}/search`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          query,
          session_id: this.sessionId,
          history_id: historyId,
          max_results: maxResults,
        })
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data: ProductSearchResponse = await response.json();
      return data;
    } catch (error) {
      console.error('Error searching products:', error);
      throw error;
    }
  }

  /**
   * Get chat and search history
   */
  async getHistory(limit: number = 10): Promise<HistoryResponse> {
    try {
      const params = new URLSearchParams({
        limit: limit.toString(),
      });

      if (this.userId) {
        params.append('user_id', this.userId);
      } else if (this.sessionId) {
        params.append('session_id', this.sessionId);
      } else {
        throw new Error('No session or user ID available');
      }

      const response = await fetch(`${this.baseUrl}/history?${params}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data: HistoryResponse = await response.json();
      return data;
    } catch (error) {
      console.error('Error fetching history:', error);
      throw error;
    }
  }

  /**
   * Check system health
   */
  async checkHealth(): Promise<HealthResponse> {
    try {
      const response = await fetch(`${this.baseUrl}/health`);
      const data: HealthResponse = await response.json();
      return data;
    } catch (error) {
      console.error('Health check failed:', error);
      return {
        success: false,
        ai_service: {
          status: 'offline',
          error: error instanceof Error ? error.message : 'Unknown error'
        }
      };
    }
  }

  /**
   * Clear session data
   */
  clearSession(): void {
    this.sessionId = null;
    localStorage.removeItem('giftgenie_session_id');
  }

  /**
   * Get current session ID
   */
  getSessionId(): string | null {
    return this.sessionId;
  }

  /**
   * Set user ID for authenticated users
   */
  setUserId(userId: string): void {
    this.userId = userId;
    localStorage.setItem('giftgenie_user_id', userId);
  }

  /**
   * Clear user data
   */
  clearUser(): void {
    this.userId = null;
    localStorage.removeItem('giftgenie_user_id');
  }
}

export const giftService = new GiftRecommendationService();