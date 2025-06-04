"use client";

import Image from "next/image";
import Link from "next/link";
import { KeySwitch } from "@/lib/types";
import { SoundChart } from "./SoundChart";
import { getAverageSoundProfile } from "@/lib/data";
import { cn } from "@/lib/utils";
import { Badge } from "@/components/ui/badge";
import { motion } from "framer-motion";

interface SwitchCardProps {
  keySwitch: KeySwitch;
  className?: string;
}

export function SwitchCard({ keySwitch, className }: SwitchCardProps) {
  const avgProfile = getAverageSoundProfile(keySwitch.id);
  
  // Determine badge color based on switch type
  const getBadgeVariant = (type: string) => {
    switch (type.toLowerCase()) {
      case "linear":
        return "default";
      case "tactile":
        return "secondary";
      case "clicky":
        return "destructive";
      default:
        return "outline";
    }
  };

  return (
    <motion.div
      initial={{ opacity: 0, y: 10 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.3 }}
      whileHover={{ y: -5 }}
    >
      <Link href={`/switches/${keySwitch.id}`}>
        <div className={cn(
          "group relative overflow-hidden rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-md",
          className
        )}>
          <div className="aspect-square overflow-hidden bg-muted">
            {keySwitch.imageUrl ? (
              <Image
                src={keySwitch.imageUrl}
                alt={keySwitch.name}
                width={300}
                height={300}
                className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
              />
            ) : (
              <div className="flex h-full items-center justify-center bg-muted">
                <span className="text-muted-foreground">No image</span>
              </div>
            )}
          </div>
          
          <div className="p-4">
            <div className="mb-2 flex items-center justify-between">
              <h3 className="font-semibold truncate">{keySwitch.name}</h3>
              <Badge variant={getBadgeVariant(keySwitch.type)}>
                {keySwitch.type}
              </Badge>
            </div>
            
            <p className="text-sm text-muted-foreground mb-2">{keySwitch.brand}</p>
            
            {keySwitch.price && (
              <p className="text-sm font-medium mb-3">${keySwitch.price.toFixed(2)} per switch</p>
            )}
            
            <div className="flex items-center justify-center mt-2">
              <SoundChart 
                value={avgProfile} 
                size="sm" 
                showLabels={false}
                className="scale-75 origin-center -my-8"
              />
            </div>
          </div>
        </div>
      </Link>
    </motion.div>
  );
}