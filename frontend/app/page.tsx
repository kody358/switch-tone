'use client';

import { Suspense } from "react";
import { useSwitches } from "@/hooks/useSwitches";
import { SwitchCard } from "@/components/SwitchCard";
import { SearchBar } from "@/components/SearchBar";
import { FilterBar } from "@/components/FilterBar";

export default function Home({
  searchParams,
}: {
  searchParams: { [key: string]: string | string[] | undefined };
}) {
  // URL パラメータから検索・フィルター条件を取得
  const search = typeof searchParams.search === "string" ? searchParams.search : "";
  const typeFilter = typeof searchParams.type === "string" ? searchParams.type.split(",") : [];
  const brandFilter = typeof searchParams.brand === "string" ? searchParams.brand.split(",") : [];
  const priceFilter = typeof searchParams.price === "string" ? searchParams.price.split(",") : [];

  // API からデータを取得
  const { switches, loading, error } = useSwitches({
    search,
    type: typeFilter.length > 0 ? typeFilter : undefined,
    brand: brandFilter.length > 0 ? brandFilter : undefined,
    price: priceFilter.length > 0 ? priceFilter : undefined,
  });

  if (error) {
    return (
      <div className="container px-4 py-8 mx-auto">
        <div className="text-center py-12">
          <h3 className="text-xl font-semibold mb-2 text-red-600">エラーが発生しました</h3>
          <p className="text-muted-foreground">{error}</p>
        </div>
      </div>
    );
  }

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
            {loading ? (
              <p className="text-muted-foreground">読み込み中...</p>
            ) : (
              <p className="text-muted-foreground">
                {switches.length} {switches.length === 1 ? 'switch' : 'switches'} found
              </p>
            )}
          </div>

          {loading ? (
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              {[...Array(8)].map((_, index) => (
                <div key={index} className="animate-pulse">
                  <div className="bg-gray-200 h-48 rounded-lg mb-4"></div>
                  <div className="bg-gray-200 h-4 rounded mb-2"></div>
                  <div className="bg-gray-200 h-4 rounded w-2/3"></div>
                </div>
              ))}
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              {switches.map((keySwitch) => (
                <SwitchCard key={keySwitch.id} keySwitch={keySwitch} />
              ))}
            </div>
          )}

          {!loading && switches.length === 0 && (
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