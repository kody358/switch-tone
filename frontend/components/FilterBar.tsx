"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { X } from "lucide-react";

interface FilterOption {
  label: string;
  value: string;
  category: string;
}

const filterOptions: FilterOption[] = [
  { label: "Linear", value: "linear", category: "type" },
  { label: "Tactile", value: "tactile", category: "type" },
  { label: "Clicky", value: "clicky", category: "type" },
  { label: "Gateron", value: "gateron", category: "brand" },
  { label: "Cherry", value: "cherry", category: "brand" },
  { label: "Kailh", value: "kailh", category: "brand" },
  { label: "Gazzew", value: "gazzew", category: "brand" },
  { label: "Budget", value: "budget", category: "price" },
  { label: "Mid-range", value: "mid-range", category: "price" },
  { label: "Premium", value: "premium", category: "price" },
];

export function FilterBar() {
  const [activeFilters, setActiveFilters] = useState<FilterOption[]>([]);
  const router = useRouter();
  
  const handleFilterClick = (filter: FilterOption) => {
    // Check if filter is already active
    const isActive = activeFilters.some(
      (f) => f.value === filter.value && f.category === filter.category
    );
    
    if (isActive) {
      // Remove filter
      setActiveFilters(
        activeFilters.filter(
          (f) => !(f.value === filter.value && f.category === filter.category)
        )
      );
    } else {
      // Add filter
      setActiveFilters([...activeFilters, filter]);
    }
  };
  
  const handleRemoveFilter = (filter: FilterOption) => {
    setActiveFilters(
      activeFilters.filter(
        (f) => !(f.value === filter.value && f.category === filter.category)
      )
    );
  };
  
  const clearFilters = () => {
    setActiveFilters([]);
  };
  
  const applyFilters = () => {
    const params = new URLSearchParams();
    
    // Group filters by category
    const filtersByCategory: Record<string, string[]> = {};
    
    activeFilters.forEach((filter) => {
      if (!filtersByCategory[filter.category]) {
        filtersByCategory[filter.category] = [];
      }
      filtersByCategory[filter.category].push(filter.value);
    });
    
    // Add filters to params
    Object.entries(filtersByCategory).forEach(([category, values]) => {
      params.set(category, values.join(","));
    });
    
    router.push(`/?${params.toString()}`);
  };
  
  return (
    <div className="flex flex-col space-y-3 w-full">
      <div className="flex flex-wrap gap-2">
        {filterOptions.map((filter) => (
          <Button
            key={`${filter.category}-${filter.value}`}
            variant={
              activeFilters.some(
                (f) => f.value === filter.value && f.category === filter.category
              )
                ? "secondary"
                : "outline"
            }
            size="sm"
            onClick={() => handleFilterClick(filter)}
            className="text-xs"
          >
            {filter.label}
          </Button>
        ))}
      </div>
      
      {activeFilters.length > 0 && (
        <div className="flex flex-col space-y-3">
          <div className="flex flex-wrap gap-2">
            {activeFilters.map((filter) => (
              <Badge
                key={`active-${filter.category}-${filter.value}`}
                variant="secondary"
                className="flex items-center gap-1"
              >
                {filter.label}
                <X
                  className="h-3 w-3 cursor-pointer"
                  onClick={() => handleRemoveFilter(filter)}
                />
              </Badge>
            ))}
            <Button
              variant="ghost"
              size="sm"
              onClick={clearFilters}
              className="text-xs h-6"
            >
              Clear all
            </Button>
          </div>
          
          <Button onClick={applyFilters} className="w-full sm:w-auto">
            Apply Filters
          </Button>
        </div>
      )}
    </div>
  );
}