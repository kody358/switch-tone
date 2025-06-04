import { notFound } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import { 
  getSwitchById, 
  getReviewsBySwitchId, 
  getUserById, 
  getAverageSoundProfile,
  switches 
} from "@/lib/data";
import { SoundChart } from "@/components/SoundChart";
import { ReviewCard } from "@/components/ReviewCard";
import { Button } from "@/components/ui/button";
import { ChevronLeft, PlusCircle } from "lucide-react";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";

export async function generateStaticParams() {
  return switches.map((keySwitch) => ({
    id: keySwitch.id.toString()
  }));
}

export default function SwitchPage({ params }: { params: { id: string } }) {
  const switchId = parseInt(params.id);
  const keySwitch = getSwitchById(switchId);
  
  if (!keySwitch) {
    notFound();
  }
  
  const reviews = getReviewsBySwitchId(switchId);
  const averageSoundProfile = getAverageSoundProfile(switchId);
  
  return (
    <div className="container px-4 py-8 mx-auto">
      <div className="mb-6">
        <Link href="/" className="flex items-center text-muted-foreground hover:text-foreground transition-colors">
          <ChevronLeft className="mr-1 h-4 w-4" />
          Back to all switches
        </Link>
      </div>
      
      <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <div className="flex flex-col">
          <div className="rounded-lg overflow-hidden border bg-card mb-4">
            {keySwitch.imageUrl ? (
              <Image
                src={keySwitch.imageUrl}
                alt={keySwitch.name}
                width={600}
                height={600}
                className="w-full h-auto object-cover"
              />
            ) : (
              <div className="aspect-square bg-muted flex items-center justify-center">
                <span className="text-muted-foreground">No image available</span>
              </div>
            )}
          </div>
          
          <div className="flex flex-wrap gap-2">
            <Badge>{keySwitch.type}</Badge>
            <Badge variant="outline">{keySwitch.brand}</Badge>
            {keySwitch.price && (
              <Badge variant="secondary">${keySwitch.price.toFixed(2)} per switch</Badge>
            )}
          </div>
        </div>
        
        <div>
          <h1 className="text-3xl font-bold mb-2">{keySwitch.name}</h1>
          <p className="text-muted-foreground mb-4">{keySwitch.brand}</p>
          
          {keySwitch.description && (
            <p className="mb-6">{keySwitch.description}</p>
          )}
          
          <Card className="mb-6">
            <CardHeader>
              <CardTitle className="text-lg">Average Sound Profile</CardTitle>
            </CardHeader>
            <CardContent className="flex justify-center">
              <SoundChart 
                value={averageSoundProfile} 
                size="lg"
              />
            </CardContent>
          </Card>
          
          <Link href={`/switches/${switchId}/review`}>
            <Button className="w-full">
              <PlusCircle className="mr-2 h-4 w-4" />
              Add Your Review
            </Button>
          </Link>
        </div>
      </div>
      
      <Separator className="my-8" />
      
      <section>
        <h2 className="text-2xl font-bold mb-6">Reviews ({reviews.length})</h2>
        
        {reviews.length > 0 ? (
          <div className="space-y-6">
            {reviews.map((review) => {
              const user = getUserById(review.userId);
              if (!user) return null;
              
              return (
                <ReviewCard 
                  key={review.id} 
                  review={review} 
                  user={user} 
                />
              );
            })}
          </div>
        ) : (
          <div className="text-center py-12 border rounded-lg bg-card">
            <h3 className="text-xl font-semibold mb-2">No reviews yet</h3>
            <p className="text-muted-foreground mb-4">
              Be the first to review this switch!
            </p>
            <Link href={`/switches/${switchId}/review`}>
              <Button>
                <PlusCircle className="mr-2 h-4 w-4" />
                Add Review
              </Button>
            </Link>
          </div>
        )}
      </section>
    </div>
  );
}