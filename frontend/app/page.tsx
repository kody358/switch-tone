import { Suspense } from "react";
import { switches } from "@/lib/data";
import { SwitchCard } from "@/components/SwitchCard";
import { SearchBar } from "@/components/SearchBar";
import { FilterBar } from "@/components/FilterBar";

export default function Home({
  searchParams,
}: {
  searchParams: { [key: string]: string | string[] | undefined };
}) {
  // Get search query from URL params
  const search = typeof searchParams.search === "string" ? searchParams.search : "";

  // Get filter params from URL
  const typeFilter = typeof searchParams.type === "string" ? searchParams.type.split(",") : [];
  const brandFilter = typeof searchParams.brand === "string" ? searchParams.brand.split(",") : [];
  const priceFilter = typeof searchParams.price === "string" ? searchParams.price.split(",") : [];

  // Filter switches based on search and filters
  const filteredSwitches = switches.filter((keySwitch) => {
    // Search filter
    if (search && !keySwitch.name.toLowerCase().includes(search.toLowerCase()) && 
        !keySwitch.brand.toLowerCase().includes(search.toLowerCase())) {
      return false;
    }

    // Type filter
    if (typeFilter.length > 0 && !typeFilter.includes(keySwitch.type.toLowerCase())) {
      return false;
    }

    // Brand filter
    if (brandFilter.length > 0 && !brandFilter.includes(keySwitch.brand.toLowerCase())) {
      return false;
    }

    // Price filter (simplified implementation)
    if (priceFilter.length > 0) {
      if (priceFilter.includes("budget") && (keySwitch.price && keySwitch.price > 0.5)) {
        return false;
      }
      if (priceFilter.includes("mid-range") && (keySwitch.price && (keySwitch.price <= 0.5 || keySwitch.price > 1))) {
        return false;
      }
      if (priceFilter.includes("premium") && (keySwitch.price && keySwitch.price <= 1)) {
        return false;
      }
    }

    return true;
  });

  return (
    <div className="container px-4 py-8 mx-auto">
      <section className="mb-12">
        <div className="text-center max-w-3xl mx-auto mb-8">
          <h1 className="text-4xl font-bold tracking-tight mb-3">
            Discover Key Switch Sound Profiles
          </h1>
          <p className="text-muted-foreground text-lg">
            Explore and compare the acoustic characteristics of mechanical keyboard switches
          </p>
        </div>

        <div className="flex flex-col space-y-6 max-w-5xl mx-auto">
          <div className="flex justify-center">
            <SearchBar />
          </div>
          <div className="w-full">
            <FilterBar />
          </div>
        </div>
      </section>

      <Suspense fallback={<div>Loading switches...</div>}>
        <section>
          <div className="flex items-center justify-between mb-6">
            <h2 className="text-2xl font-bold">Key Switches</h2>
            <p className="text-muted-foreground">
              {filteredSwitches.length} {filteredSwitches.length === 1 ? 'switch' : 'switches'} found
            </p>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {filteredSwitches.map((keySwitch) => (
              <SwitchCard key={keySwitch.id} keySwitch={keySwitch} />
            ))}
          </div>

          {filteredSwitches.length === 0 && (
            <div className="text-center py-12">
              <h3 className="text-xl font-semibold mb-2">No switches found</h3>
              <p className="text-muted-foreground">
                Try adjusting your search or filters
              </p>
            </div>
          )}
        </section>
      </Suspense>
    </div>
  );
}