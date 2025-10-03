import { useState, useRef, useEffect } from "react";
import { MessageCircle, X, Send, Loader2, ShoppingBag, Gift } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { ScrollArea } from "@/components/ui/scroll-area";
import { ChatMessage } from "./ChatMessage";
import { cn } from "@/lib/utils";
import { toast } from "sonner";
import { useNavigate } from "react-router-dom";
import { giftService, type ChatResponse, type Product } from "@/services/giftService";

interface Message {
  role: "user" | "assistant";
  content: string;
  timestamp: Date;
  questions?: string[];
  recommendations?: Record<string, string>;
  products?: Record<string, Product[]>;
}

export const ChatWidget = () => {
  const navigate = useNavigate();
  const [isOpen, setIsOpen] = useState(false);
  const [messages, setMessages] = useState<Message[]>([
    {
      role: "assistant",
      content: "Hi! I'm here to help you find the perfect gift. Tell me about the person you're shopping for!",
      timestamp: new Date(),
    },
  ]);
  const [input, setInput] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const [isSearchingProducts, setIsSearchingProducts] = useState(false);
  const [context, setContext] = useState("");
  const [allProducts, setAllProducts] = useState<Record<string, Product[]>>({});
  const [hasRecommendations, setHasRecommendations] = useState(false);
  const scrollRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (scrollRef.current) {
      scrollRef.current.scrollTop = scrollRef.current.scrollHeight;
    }
  }, [messages]);

  const handleSend = async () => {
    if (!input.trim() || isLoading) return;

    const userMessage: Message = {
      role: "user",
      content: input,
      timestamp: new Date(),
    };

    setMessages((prev) => [...prev, userMessage]);
    const currentInput = input;
    setInput("");
    setIsLoading(true);

    try {
      // Send message to our Python API
      const response = await giftService.sendChatMessage(currentInput, context);
      
      if (!response.success) {
        throw new Error("Failed to get AI response");
      }

      // Create assistant message with AI response
      const assistantMessage: Message = {
        role: "assistant",
        content: response.response || "I've generated some gift recommendations for you!",
        timestamp: new Date(),
        questions: response.questions,
        recommendations: response.recommendations,
      };

      setMessages((prev) => [...prev, assistantMessage]);
      
      // Update context for next message
      setContext(prev => prev + "\nUser: " + currentInput + "\nAssistant: " + response.response);

      // If we have recommendations, search for products
      if (response.recommendations && Object.keys(response.recommendations).length > 0) {
        await searchForProducts(response.recommendations);
      }

    } catch (error) {
      console.error("Chat error:", error);
      toast.error("Failed to get response. Please make sure the AI server is running.");
      
      // Add error message
      setMessages((prev) => [...prev, {
        role: "assistant",
        content: "Sorry, I'm having trouble connecting to the AI service. Please make sure the Python API server is running on localhost:5000.",
        timestamp: new Date(),
      }]);
    } finally {
      setIsLoading(false);
    }
  };

  const searchForProducts = async (recommendations: Record<string, string>) => {
    setIsSearchingProducts(true);
    
    try {
      const productResponse = await giftService.searchProducts(recommendations);
      
      if (productResponse.products && Object.keys(productResponse.products).length > 0) {
        // Store products globally for navigation to gifts page
        setAllProducts(productResponse.products);
        setHasRecommendations(true);
        
        // Add products message
        const productsMessage: Message = {
          role: "assistant",
          content: `I found ${productResponse.total_products} products across ${productResponse.total_categories} categories!`,
          timestamp: new Date(),
          products: productResponse.products,
        };

        setMessages((prev) => [...prev, productsMessage]);
        toast.success(`Found ${productResponse.total_products} gift suggestions!`);
      } else {
        toast.error("No products found for the recommendations.");
      }
    } catch (error) {
      console.error("Product search error:", error);
      toast.error("Failed to search for products.");
    } finally {
      setIsSearchingProducts(false);
    }
  };

  const handleViewSuggestions = () => {
    if (Object.keys(allProducts).length > 0) {
      // Store products in sessionStorage to access from gifts page
      sessionStorage.setItem('giftSuggestions', JSON.stringify(allProducts));
      navigate('/gifts');
      setIsOpen(false);
    } else {
      toast.error("No suggestions available. Please ask for gift recommendations first!");
    }
  };

  const handleQuestionClick = (question: string) => {
    setInput(question);
  };

  return (
    <>
      {/* Floating Button */}
      <Button
        onClick={() => setIsOpen(!isOpen)}
        className={cn(
          "fixed bottom-6 right-6 w-14 h-14 rounded-full shadow-[var(--shadow-glow)] z-50 transition-all",
          isOpen && "scale-0"
        )}
        size="icon"
        variant="hero"
      >
        <MessageCircle className="w-6 h-6" />
      </Button>

      {/* Chat Panel */}
      <div
        className={cn(
          "fixed bottom-0 right-0 w-full md:w-96 h-[600px] md:h-[700px] bg-card border-l border-t border-border shadow-2xl transition-transform duration-300 z-50 flex flex-col",
          isOpen ? "translate-x-0" : "translate-x-full"
        )}
      >
        {/* Header */}
        <div className="flex items-center justify-between p-4 border-b border-border bg-gradient-to-r from-primary/10 to-secondary/10">
          <div className="flex items-center gap-2">
            <MessageCircle className="w-5 h-5 text-primary" />
            <h3 className="font-semibold">Gift Assistant</h3>
          </div>
          <div className="flex items-center gap-2">
            {hasRecommendations && (
              <Button
                variant="ghost"
                size="sm"
                onClick={handleViewSuggestions}
                className="text-primary hover:text-primary/80"
              >
                <Gift className="w-4 h-4 mr-1" />
                View Suggestions
              </Button>
            )}
            <Button
              variant="ghost"
              size="icon"
              onClick={() => setIsOpen(false)}
            >
              <X className="w-5 h-5" />
            </Button>
          </div>
        </div>

        {/* Messages */}
        <ScrollArea className="flex-1 p-4" ref={scrollRef}>
          <div className="space-y-4">
            {messages.map((message, index) => (
              <ChatMessage 
                key={index} 
                message={message} 
                onQuestionClick={handleQuestionClick}
              />
            ))}
            {isLoading && (
              <div className="flex justify-start">
                <div className="bg-muted rounded-lg p-3 flex items-center gap-2">
                  <Loader2 className="w-4 h-4 animate-spin text-primary" />
                  <span className="text-sm text-muted-foreground">Thinking...</span>
                </div>
              </div>
            )}
            {isSearchingProducts && (
              <div className="flex justify-start">
                <div className="bg-muted rounded-lg p-3 flex items-center gap-2">
                  <ShoppingBag className="w-4 h-4 text-primary" />
                  <Loader2 className="w-4 h-4 animate-spin text-primary" />
                  <span className="text-sm text-muted-foreground">Searching for products...</span>
                </div>
              </div>
            )}
          </div>
        </ScrollArea>

        {/* Input */}
        <div className="p-4 border-t border-border bg-muted/30">
          <div className="flex gap-2">
            <Input
              value={input}
              onChange={(e) => setInput(e.target.value)}
              onKeyPress={(e) => e.key === "Enter" && handleSend()}
              placeholder="Describe the person or occasion..."
              disabled={isLoading}
              className="flex-1"
            />
            <Button
              onClick={handleSend}
              disabled={!input.trim() || isLoading}
              size="icon"
            >
              <Send className="w-4 h-4" />
            </Button>
          </div>
        </div>
      </div>
    </>
  );
};
