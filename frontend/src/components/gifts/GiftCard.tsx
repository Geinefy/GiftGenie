import { ExternalLink } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardFooter } from "@/components/ui/card";

export interface GiftItem {
  id: string;
  name: string;
  price: number;
  image: string;
  url: string;
  description?: string;
}

interface GiftCardProps {
  gift: GiftItem;
}

export const GiftCard = ({ gift }: GiftCardProps) => {
  return (
    <Card className="overflow-hidden hover:shadow-[var(--shadow-glow)] transition-all duration-300 hover:scale-105">
      <div className="aspect-square overflow-hidden bg-muted">
        <img
          src={gift.image}
          alt={gift.name}
          className="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
        />
      </div>
      <CardContent className="p-4">
        <h3 className="font-semibold text-lg mb-2 line-clamp-2">{gift.name}</h3>
        {gift.description && (
          <p className="text-sm text-muted-foreground line-clamp-2 mb-2">{gift.description}</p>
        )}
        <p className="text-2xl font-bold text-primary">${gift.price.toFixed(2)}</p>
      </CardContent>
      <CardFooter className="p-4 pt-0">
        <Button
          variant="hero"
          className="w-full"
          asChild
        >
          <a href={gift.url} target="_blank" rel="noopener noreferrer">
            Buy Now <ExternalLink className="w-4 h-4 ml-2" />
          </a>
        </Button>
      </CardFooter>
    </Card>
  );
};
