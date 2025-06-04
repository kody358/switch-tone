"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import Link from "next/link";
import { SoundChart } from "@/components/SoundChart";
import { getSwitchById } from "@/lib/data";
import { SoundProfile } from "@/lib/types";
import { Button } from "@/components/ui/button";
import { Textarea } from "@/components/ui/textarea";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { ChevronLeft } from "lucide-react";
import { toast } from "sonner";

export default function ReviewPage({ params }: { params: { id: string } }) {
  const switchId = parseInt(params.id);
  const keySwitch = getSwitchById(switchId);
  const router = useRouter();
  
  const [soundProfile, setSoundProfile] = useState<SoundProfile>({ pitch: 0, depth: 0 });
  const [reviewText, setReviewText] = useState("");
  const [isSubmitting, setIsSubmitting] = useState(false);
  
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!reviewText.trim()) {
      toast.error("Please add some text to your review");
      return;
    }
    
    setIsSubmitting(true);
    
    // Simulate API call
    await new Promise((resolve) => setTimeout(resolve, 1000));
    
    // Since this is a prototype, we'll just redirect back to the switch page
    toast.success("Review submitted successfully!");
    router.push(`/switches/${switchId}`);
  };
  
  if (!keySwitch) {
    return (
      <div className="container py-8">
        <h1>Switch not found</h1>
        <Link href="/">Go back home</Link>
      </div>
    );
  }
  
  return (
    <div className="container px-4 py-8 mx-auto max-w-3xl">
      <div className="mb-6">
        <Link 
          href={`/switches/${switchId}`} 
          className="flex items-center text-muted-foreground hover:text-foreground transition-colors"
        >
          <ChevronLeft className="mr-1 h-4 w-4" />
          Back to {keySwitch.name}
        </Link>
      </div>
      
      <h1 className="text-3xl font-bold mb-6">Review {keySwitch.brand} {keySwitch.name}</h1>
      
      <form onSubmit={handleSubmit}>
        <Card className="mb-8">
          <CardHeader>
            <CardTitle>Sound Profile</CardTitle>
            <CardDescription>
              Click on the chart to set your sound rating for this switch
            </CardDescription>
          </CardHeader>
          <CardContent className="flex flex-col items-center">
            <SoundChart 
              value={soundProfile}
              onChange={setSoundProfile}
              size="lg"
              interactive={true}
              showLabels={true}
            />
          </CardContent>
        </Card>
        
        <Card className="mb-8">
          <CardHeader>
            <CardTitle>Your Review</CardTitle>
            <CardDescription>
              Describe your experience with this switch
            </CardDescription>
          </CardHeader>
          <CardContent>
            <Textarea
              placeholder="Share your thoughts on how this switch sounds and feels..."
              value={reviewText}
              onChange={(e) => setReviewText(e.target.value)}
              className="min-h-[150px]"
            />
          </CardContent>
        </Card>
        
        <div className="flex justify-end">
          <Button 
            type="submit" 
            size="lg" 
            disabled={isSubmitting}
          >
            {isSubmitting ? "Submitting..." : "Submit Review"}
          </Button>
        </div>
      </form>
    </div>
  );
}