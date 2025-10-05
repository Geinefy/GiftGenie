import { useState, useEffect } from "react";
import { GiftGrid } from "@/components/gifts/GiftGrid";
import { GiftItem } from "@/components/gifts/GiftCard";
import { Product } from "@/services/giftService";
import { Button } from "@/components/ui/button";
import { MessageCircle, RefreshCw } from "lucide-react";
import { toast } from "sonner";

export const Gifts = () => {
  const [gifts, setGifts] = useState<GiftItem[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [categories, setCategories] = useState<string[]>([]);

  useEffect(() => {
    loadGiftSuggestions();
  }, []);

  const loadGiftSuggestions = () => {
    try {
      const storedSuggestions = sessionStorage.getItem('giftSuggestions');
      
      if (storedSuggestions) {
        const products: Record<string, Product[]> = JSON.parse(storedSuggestions);
        const categoryList = Object.keys(products);
        setCategories(categoryList);
        
        // Convert products to GiftItem format
        const allGifts: GiftItem[] = [];
        let idCounter = 1;
        
        Object.entries(products).forEach(([category, productList]) => {
          productList.forEach((product) => {
            // Extract price number from string like "$25.99"
            const priceMatch = product.price.match(/[\d,]+\.?\d*/);
            const priceNumber = priceMatch ? parseFloat(priceMatch[0].replace(',', '')) : 0;
            
            allGifts.push({
              id: `${idCounter++}`,
              name: product.name,
              price: priceNumber,
              image: product.image || 'https://via.placeholder.com/400x400?text=No+Image',
              url: product.url,
              description: `${category.replace(/_/g, ' ')} from ${product.source}`
            });
          });
        });
        
        setGifts(allGifts);
        toast.success(`Loaded ${allGifts.length} gift suggestions!`);
      } else {
        // Show default/fallback gifts if no suggestions
        setGifts([
          {
            id: "default-1",
            name: "No suggestions yet",
            price: 0,
            image: "https://via.placeholder.com/400x400?text=Ask+for+Suggestions",
            url: "#",
            description: "Use the chat to get personalized gift recommendations!"
          }
        ]);
      }
    } catch (error) {
      console.error('Error loading suggestions:', error);
      toast.error('Failed to load gift suggestions');
    } finally {
      setIsLoading(false);
    }
  };

  const clearSuggestions = () => {
    sessionStorage.removeItem('giftSuggestions');
    setGifts([]);
    setCategories([]);
    toast.success('Suggestions cleared! Use the chat to get new recommendations.');
  };

  if (isLoading) {
    return (
      <div className="container mx-auto px-4 py-8">
        <div className="flex items-center justify-center h-64">
          <RefreshCw className="w-8 h-8 animate-spin text-primary" />
          <span className="ml-2 text-lg">Loading gift suggestions...</span>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto px-4 py-8">
      <div className="mb-8">
        <div className="flex items-center justify-between mb-4">
          <div>
            <h1 className="text-3xl font-bold mb-2">Gift Suggestions</h1>
            <p className="text-muted-foreground">
              {gifts.length > 0 && gifts[0].id !== 'default-1' 
                ? `Found ${gifts.length} personalized recommendations across ${categories.length} categories`
                : "Browse personalized gift recommendations or use the chat to get suggestions"
              }
            </p>
          </div>
          
          {gifts.length > 0 && gifts[0].id !== 'default-1' && (
            <div className="flex gap-2">
              <Button
                variant="outline"
                onClick={clearSuggestions}
                className="flex items-center gap-2"
              >
                <RefreshCw className="w-4 h-4" />
                Clear & Get New
              </Button>
            </div>
          )}
        </div>
        
        {categories.length > 0 && (
          <div className="flex flex-wrap gap-2 mb-4">
            {categories.map((category) => (
              <span 
                key={category}
                className="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm capitalize"
              >
                {category.replace(/_/g, ' ')}
              </span>
            ))}
          </div>
        )}
      </div>
      
      {gifts.length === 0 ? (
        <div className="text-center py-16">
          <MessageCircle className="w-16 h-16 mx-auto text-muted-foreground mb-4" />
          <h2 className="text-2xl font-semibold mb-2">No Suggestions Yet</h2>
          <p className="text-muted-foreground mb-4">
            Use the chat widget to tell me about the person you're shopping for!
          </p>
        </div>
      ) : (
        <GiftGrid gifts={gifts} />
      )}
    </div>
  );
};
