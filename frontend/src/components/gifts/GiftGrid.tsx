import { useState } from "react";
import { GiftCard, GiftItem } from "./GiftCard";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

interface GiftGridProps {
  gifts: GiftItem[];
}

type SortOption = "relevance" | "price-low" | "price-high";

export const GiftGrid = ({ gifts }: GiftGridProps) => {
  const [sortBy, setSortBy] = useState<SortOption>("relevance");

  const sortedGifts = [...gifts].sort((a, b) => {
    switch (sortBy) {
      case "price-low":
        return a.price - b.price;
      case "price-high":
        return b.price - a.price;
      default:
        return 0;
    }
  });

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">Gift Suggestions</h2>
        <Select value={sortBy} onValueChange={(value) => setSortBy(value as SortOption)}>
          <SelectTrigger className="w-[180px]">
            <SelectValue placeholder="Sort by" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="relevance">Relevance</SelectItem>
            <SelectItem value="price-low">Price: Low to High</SelectItem>
            <SelectItem value="price-high">Price: High to Low</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {sortedGifts.map((gift) => (
          <GiftCard key={gift.id} gift={gift} />
        ))}
      </div>

      {gifts.length === 0 && (
        <div className="text-center py-12">
          <p className="text-muted-foreground">No gifts found. Start chatting to get personalized suggestions!</p>
        </div>
      )}
    </div>
  );
};
