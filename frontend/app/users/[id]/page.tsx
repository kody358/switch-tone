import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import { getUserById, getReviewsByUserId, getSwitchById } from "@/lib/data";
import { SoundChart } from "@/components/SoundChart";
import { ReviewCard } from "@/components/ReviewCard";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { formatDistanceToNow } from "date-fns";

export default function UserPage({ params }: { params: { id: string } }) {
  const userId = parseInt(params.id);
  const user = getUserById(userId);
  
  if (!user) {
    notFound();
  }
  
  const reviews = getReviewsByUserId(userId);
  
  return (
    <div className="container px-4 py-8 mx-auto">
      <Card className="mb-8">
        <CardContent className="pt-6">
          <div className="flex flex-col md:flex-row items-center md:items-start gap-6">
            <Avatar className="h-24 w-24">
              <AvatarImage src={user.avatar} alt={user.name} />
              <AvatarFallback className="text-2xl">{user.name.slice(0, 2).toUpperCase()}</AvatarFallback>
            </Avatar>
            
            <div className="flex-1 text-center md:text-left">
              <h1 className="text-3xl font-bold mb-2">{user.name}</h1>
              <p className="text-muted-foreground mb-4">
                Member since {formatDistanceToNow(user.createdAt, { addSuffix: true })}
              </p>
              
              {user.bio && (
                <p className="mb-4">{user.bio}</p>
              )}
              
              <div className="flex flex-wrap gap-4 justify-center md:justify-start">
                <div className="text-center">
                  <p className="text-2xl font-bold">{user.reviewCount}</p>
                  <p className="text-sm text-muted-foreground">Reviews</p>
                </div>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>
      
      <Tabs defaultValue="sound-profiles" className="w-full">
        <TabsList className="grid w-full grid-cols-2 mb-8">
          <TabsTrigger value="sound-profiles">Sound Profiles</TabsTrigger>
          <TabsTrigger value="reviews">Reviews</TabsTrigger>
        </TabsList>
        
        <TabsContent value="sound-profiles" className="space-y-4">
          <h2 className="text-2xl font-bold mb-6">Sound Profiles</h2>
          
          {reviews.length > 0 ? (
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              {reviews.map((review) => {
                const keySwitch = getSwitchById(review.switchId);
                if (!keySwitch) return null;
                
                return (
                  <Link 
                    key={review.id}
                    href={`/switches/${keySwitch.id}`}
                    className="block"
                  >
                    <Card className="h-full hover:shadow-md transition-shadow">
                      <CardHeader className="pb-2">
                        <CardTitle className="text-base">{keySwitch.name}</CardTitle>
                        <CardDescription>{keySwitch.brand}</CardDescription>
                      </CardHeader>
                      <CardContent>
                        <div className="flex justify-center">
                          <SoundChart 
                            value={{ pitch: review.pitch, depth: review.depth }} 
                            size="sm"
                            showLabels={false}
                          />
                        </div>
                      </CardContent>
                    </Card>
                  </Link>
                );
              })}
            </div>
          ) : (
            <div className="text-center py-12 border rounded-lg">
              <h3 className="text-xl font-semibold mb-2">No sound profiles yet</h3>
              <p className="text-muted-foreground">
                This user hasn't created any sound profiles
              </p>
            </div>
          )}
        </TabsContent>
        
        <TabsContent value="reviews" className="space-y-4">
          <h2 className="text-2xl font-bold mb-6">Reviews</h2>
          
          {reviews.length > 0 ? (
            <div className="space-y-6">
              {reviews.map((review) => {
                const keySwitch = getSwitchById(review.switchId);
                if (!keySwitch) return null;
                
                return (
                  <ReviewCard 
                    key={review.id} 
                    review={review} 
                    user={user} 
                    keySwitch={keySwitch}
                    showSwitch={true}
                  />
                );
              })}
            </div>
          ) : (
            <div className="text-center py-12 border rounded-lg">
              <h3 className="text-xl font-semibold mb-2">No reviews yet</h3>
              <p className="text-muted-foreground">
                This user hasn't written any reviews
              </p>
            </div>
          )}
        </TabsContent>
      </Tabs>
    </div>
  );
}