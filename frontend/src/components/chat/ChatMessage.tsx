import { cn } from "@/lib/utils";
import { Bot, User, ExternalLink, ShoppingBag, HelpCircle } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import type { Product } from "@/services/giftService";

interface Message {
  role: "user" | "assistant";
  content: string;
  timestamp: Date;
  questions?: string[];
  recommendations?: Record<string, string>;
  products?: Record<string, Product[]>;
}

interface ChatMessageProps {
  message: Message;
  onQuestionClick?: (question: string) => void;
}

export const ChatMessage = ({ message, onQuestionClick }: ChatMessageProps) => {
  const isUser = message.role === "user";

  return (
    <div className={cn("flex gap-3", isUser ? "justify-end" : "justify-start")}>
      {!isUser && (
        <div className="w-8 h-8 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center flex-shrink-0 mt-1">
          <Bot className="w-4 h-4 text-primary-foreground" />
        </div>
      )}
      
      <div
        className={cn(
          "max-w-[85%] rounded-lg shadow-[var(--shadow-soft)]",
          isUser
            ? "bg-gradient-to-r from-primary to-secondary text-primary-foreground p-3"
            : "bg-card border border-border"
        )}
      >
        {/* Message content */}
        {!isUser ? (
          <div className="p-3">
            <p className="text-sm whitespace-pre-wrap">{message.content}</p>
            
            {/* Questions */}
            {message.questions && message.questions.length > 0 && (
              <div className="mt-3">
                <div className="flex items-center gap-1 text-xs text-muted-foreground mb-2">
                  <HelpCircle className="w-3 h-3" />
                  <span>Quick questions to help me understand better:</span>
                </div>
                <div className="flex flex-wrap gap-1">
                  {message.questions.map((question, index) => (
                    <Button
                      key={index}
                      variant="outline"
                      size="sm"
                      className="text-xs h-auto py-1 px-2"
                      onClick={() => onQuestionClick?.(question)}
                    >
                      {question}
                    </Button>
                  ))}
                </div>
              </div>
            )}

            {/* Recommendations */}
            {message.recommendations && Object.keys(message.recommendations).length > 0 && (
              <div className="mt-3">
                <div className="flex items-center gap-1 text-xs text-muted-foreground mb-2">
                  <ShoppingBag className="w-3 h-3" />
                  <span>Gift categories I'm looking for:</span>
                </div>
                <div className="flex flex-wrap gap-1">
                  {Object.entries(message.recommendations).map(([category, keywords]) => (
                    <Badge key={category} variant="secondary" className="text-xs">
                      {category.replace(/_/g, ' ')}: {keywords}
                    </Badge>
                  ))}
                </div>
              </div>
            )}

            {/* Products */}
            {message.products && Object.keys(message.products).length > 0 && (
              <div className="mt-3">
                <div className="flex items-center gap-1 text-xs text-muted-foreground mb-2">
                  <ShoppingBag className="w-3 h-3" />
                  <span>Here are some great options I found:</span>
                </div>
                <div className="space-y-3">
                  {Object.entries(message.products).map(([category, products]) => (
                    <div key={category}>
                      <h4 className="text-sm font-medium capitalize mb-2">
                        {category.replace(/_/g, ' ')}
                      </h4>
                      <div className="space-y-2">
                        {products.map((product, index) => (
                          <div key={index} className="border rounded-lg p-2 bg-background/50">
                            <div className="flex gap-2">
                              {product.image && (
                                <img 
                                  src={product.image} 
                                  alt={product.name}
                                  className="w-12 h-12 rounded object-cover flex-shrink-0"
                                  onError={(e) => {
                                    (e.target as HTMLImageElement).src = 'https://via.placeholder.com/48x48?text=No+Image';
                                  }}
                                />
                              )}
                              <div className="flex-1 min-w-0">
                                <h5 className="text-sm font-medium line-clamp-2 mb-1">
                                  {product.name}
                                </h5>
                                <div className="flex items-center justify-between">
                                  <span className="text-sm font-bold text-primary">
                                    {product.price}
                                  </span>
                                  <div className="flex items-center gap-1">
                                    <Badge variant="outline" className="text-xs">
                                      {product.source}
                                    </Badge>
                                    <Button 
                                      size="sm" 
                                      variant="ghost" 
                                      className="h-6 px-2"
                                      asChild
                                    >
                                      <a 
                                        href={product.url} 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                      >
                                        <ExternalLink className="w-3 h-3" />
                                      </a>
                                    </Button>
                                  </div>
                                </div>
                                {product.rating && (
                                  <div className="text-xs text-muted-foreground">
                                    ⭐ {product.rating} {product.reviews && `(${product.reviews} reviews)`}
                                  </div>
                                )}
                              </div>
                            </div>
                          </div>
                        ))}
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            <p className="text-xs text-muted-foreground mt-2">
              {message.timestamp.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
            </p>
          </div>
        ) : (
          <div className="p-3">
            <p className="text-sm whitespace-pre-wrap">{message.content}</p>
            <p className="text-xs text-primary-foreground/70 mt-1">
              {message.timestamp.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
            </p>
          </div>
        )}
      </div>

      {isUser && (
        <div className="w-8 h-8 rounded-full bg-muted flex items-center justify-center flex-shrink-0 mt-1">
          <User className="w-4 h-4 text-muted-foreground" />
        </div>
      )}
    </div>
  );
};
