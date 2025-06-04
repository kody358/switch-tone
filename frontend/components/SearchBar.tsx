"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Search } from "lucide-react";

export function SearchBar() {
  const [query, setQuery] = useState("");
  const router = useRouter();
  
  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    if (query.trim()) {
      router.push(`/?search=${encodeURIComponent(query)}`);
    }
  };
  
  return (
    <form onSubmit={handleSearch} className="relative w-full max-w-md">
      <div className="relative">
        <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
        <Input
          type="text"
          placeholder="Search key switches..."
          value={query}
          onChange={(e) => setQuery(e.target.value)}
          className="pl-10 pr-16 h-10 w-full"
        />
        <Button 
          type="submit" 
          size="sm" 
          className="absolute right-1 top-1/2 -translate-y-1/2 h-8"
        >
          Search
        </Button>
      </div>
    </form>
  );
}