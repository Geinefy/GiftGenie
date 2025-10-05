import * as React from "react";
import { APIStatus } from "@/components/APIStatus";
import { GiftGrid } from "@/components/gifts/GiftGrid";
import type { GiftItem } from "@/components/gifts/GiftCard";

export const Gifts: React.FC = () => {
  // Mock data — later can be fetched from backend
  const [gifts] = React.useState<GiftItem[]>([
    {
      id: "1",
      name: "Wireless Noise-Cancelling Headphones",
      price: 299.99,
      image: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500",
      url: "#",
      description: "Premium audio quality with active noise cancellation",
    },
    {
      id: "2",
      name: "Smartwatch Fitness Tracker",
      price: 249.99,
      image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500",
      url: "#",
      description: "Track your health and stay connected",
    },
    {
      id: "3",
      name: "Artisan Coffee Gift Set",
      price: 49.99,
      image: "https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=500",
      url: "#",
      description: "Curated selection of world-class beans",
    },
    {
      id: "4",
      name: "Leather Messenger Bag",
      price: 189.99,
      image: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=500",
      url: "#",
      description: "Handcrafted genuine leather bag",
    },
    {
      id: "5",
      name: "Portable Bluetooth Speaker",
      price: 129.99,
      image: "https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500",
      url: "#",
      description: "Crystal clear sound, anywhere you go",
    },
    {
      id: "6",
      name: "Gourmet Chocolate Box",
      price: 39.99,
      image: "https://images.unsplash.com/photo-1511381939415-e44015466834?w=500",
      url: "#",
      description: "Premium handcrafted chocolates",
    },
  ]);

  return (
    <div className="container mx-auto px-4 py-8 space-y-6">
      {/* API connectivity check (hits /api/ping) */}
      <APIStatus />

      <header className="mb-2">
        <h1 className="text-3xl font-bold">Gift Suggestions</h1>
        <p className="text-muted-foreground">
          Browse personalized gift recommendations or use the chat to refine your search.
        </p>
      </header>

      <GiftGrid gifts={gifts} />
    </div>
  );
};
