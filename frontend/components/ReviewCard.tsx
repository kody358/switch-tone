"use client";

import { useState } from "react";
import { Review, User, KeySwitch } from "@/lib/types";
import { SoundChart } from "./SoundChart";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Card, CardContent, CardFooter, CardHeader } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { ThumbsUp } from "lucide-react";
import { formatDistanceToNow } from "date-fns";
import Link from "next/link";

interface ReviewCardProps {
  review: Review;
  user: User;
  keySwitch?: KeySwitch;
  showSwitch?: boolean;
}

export function ReviewCard({ review, user, keySwitch, showSwitch = false }: ReviewCardProps) {
  const [likes, setLikes] = useState(review.likes);
  const [hasLiked, setHasLiked] = useState(false);
  
  const handleLike = () => {
    if (!hasLiked) {
      setLikes(prev => prev + 1);
      setHasLiked(true);
    } else {
      setLikes(prev => prev - 1);
      setHasLiked(false);
    }
  };
  
  return (
    <Card className="w-full mb-4 overflow-hidden transition-all hover:shadow-md">
      <CardHeader className="pb-2">
        <div className="flex items-center justify-between">
          <div className="flex items-center space-x-3">
            <Link href={`/users/${user.id}`}>
              <Avatar>
                <AvatarImage src={user.avatar} alt={user.name} />
                <AvatarFallback>{user.name.slice(0, 2).toUpperCase()}</AvatarFallback>
              </Avatar>
            </Link>
            <div>
              <Link href={`/users/${user.id}`} className="font-medium hover:underline">
                {user.name}
              </Link>
              <p className="text-xs text-muted-foreground">
                {formatDistanceToNow(review.createdAt, { addSuffix: true })}
              </p>
            </div>
          </div>
          
          {showSwitch && keySwitch && (
            <Link href={`/switches/${keySwitch.id}`} className="text-sm font-medium hover:underline">
              {keySwitch.brand} {keySwitch.name}
            </Link>
          )}
        </div>
      </CardHeader>
      
      <CardContent className="pt-0">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className="flex items-center justify-center">
            <SoundChart value={{ pitch: review.pitch, depth: review.depth }} size="sm" />
          </div>
          
          <div className="flex items-center">
            <p className="text-sm">{review.text}</p>
          </div>
        </div>
      </CardContent>
      
      <CardFooter className="border-t pt-3 bg-muted/10">
        <Button 
          variant="ghost" 
          size="sm" 
          className={`flex items-center gap-1 ${hasLiked ? 'text-primary' : ''}`}
          onClick={handleLike}
        >
          <ThumbsUp className="h-4 w-4" />
          <span>{likes} helpful</span>
        </Button>
      </CardFooter>
    </Card>
  );
}