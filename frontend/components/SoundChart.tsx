"use client";

import { useEffect, useRef, useState } from "react";
import { SoundProfile } from "@/lib/types";
import { cn } from "@/lib/utils";

interface SoundChartProps {
  value?: SoundProfile;
  averageValue?: SoundProfile;
  onChange?: (value: SoundProfile) => void;
  size?: "sm" | "md" | "lg";
  interactive?: boolean;
  showLabels?: boolean;
  className?: string;
}

export function SoundChart({
  value = { pitch: 0, depth: 0 },
  averageValue,
  onChange,
  size = "md",
  interactive = false,
  showLabels = true,
  className,
}: SoundChartProps) {
  const chartRef = useRef<HTMLDivElement>(null);
  const [chartSize, setChartSize] = useState<number>(0);

  const sizeMap = {
    sm: "w-[200px] h-[200px]",
    md: "w-[300px] h-[300px] sm:w-[350px] sm:h-[350px]",
    lg: "w-[350px] h-[350px] sm:w-[400px] sm:h-[400px]",
  };

  // Resize observer to update chart size
  useEffect(() => {
    if (!chartRef.current) return;

    const updateChartSize = () => {
      if (chartRef.current) {
        setChartSize(chartRef.current.offsetWidth);
      }
    };

    updateChartSize();

    const resizeObserver = new ResizeObserver(updateChartSize);
    resizeObserver.observe(chartRef.current);

    return () => {
      if (chartRef.current) {
        resizeObserver.unobserve(chartRef.current);
      }
    };
  }, []);

  // Convert coordinates from chart position to data values (-100 to 100)
  const positionToValue = (x: number, y: number): SoundProfile => {
    if (!chartRef.current) return { pitch: 0, depth: 0 };

    const rect = chartRef.current.getBoundingClientRect();
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;

    // Calculate pitch and depth as percentages (-100 to 100)
    const pitch = Math.round(((x - rect.left - centerX) / centerX) * 100);
    const depth = Math.round(((centerY - (y - rect.top)) / centerY) * 100);

    // Clamp values between -100 and 100
    return {
      pitch: Math.max(-100, Math.min(100, pitch)),
      depth: Math.max(-100, Math.min(100, depth)),
    };
  };

  // Convert data values (-100 to 100) to pixel positions
  const valueToPosition = (profile: SoundProfile) => {
    if (!chartSize) return { x: "50%", y: "50%" };

    const centerPoint = chartSize / 2;
    const x = centerPoint + (profile.pitch / 100) * centerPoint;
    const y = centerPoint - (profile.depth / 100) * centerPoint;

    // Return as percentage
    return {
      x: `${(x / chartSize) * 100}%`,
      y: `${(y / chartSize) * 100}%`,
    };
  };

  const handleChartClick = (e: React.MouseEvent<HTMLDivElement>) => {
    if (!interactive || !onChange) return;
    
    const newValue = positionToValue(e.clientX, e.clientY);
    onChange(newValue);
  };

  const mainPosition = valueToPosition(value);
  const averagePosition = averageValue ? valueToPosition(averageValue) : null;

  return (
    <div className={cn("relative flex flex-col items-center", className)}>
      <div
        ref={chartRef}
        className={cn(
          "relative border border-border rounded-md bg-card",
          sizeMap[size]
        )}
        onClick={handleChartClick}
      >
        {/* Grid lines */}
        <div className="absolute inset-0 flex items-center justify-center">
          <div className="w-full h-[1px] bg-muted"></div>
        </div>
        <div className="absolute inset-0 flex items-center justify-center">
          <div className="h-full w-[1px] bg-muted"></div>
        </div>

        {/* Subtle grid */}
        <div className="absolute inset-0 grid grid-cols-4 grid-rows-4">
          {[...Array(9)].map((_, i) => (
            <div
              key={`grid-h-${i}`}
              className="absolute w-full h-[1px] bg-muted/30"
              style={{ top: `${(i + 1) * 10}%` }}
            ></div>
          ))}
          {[...Array(9)].map((_, i) => (
            <div
              key={`grid-v-${i}`}
              className="absolute h-full w-[1px] bg-muted/30"
              style={{ left: `${(i + 1) * 10}%` }}
            ></div>
          ))}
        </div>

        {/* Axes with arrows */}
        <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
          <div className="w-full h-[2px] bg-muted-foreground flex items-center">
            <div className="absolute left-1 w-2 h-2 border-t-[2px] border-l-[2px] border-muted-foreground -rotate-45"></div>
            <div className="absolute right-1 w-2 h-2 border-t-[2px] border-r-[2px] border-muted-foreground rotate-45"></div>
          </div>
        </div>
        <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
          <div className="h-full w-[2px] bg-muted-foreground flex flex-col justify-between">
            <div className="absolute top-1 left-1/2 -translate-x-1/2 w-2 h-2 border-t-[2px] border-l-[2px] border-muted-foreground rotate-45"></div>
            <div className="absolute bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 border-b-[2px] border-l-[2px] border-muted-foreground -rotate-45"></div>
          </div>
        </div>

        {/* Average value dot */}
        {averageValue && (
          <div
            className="absolute w-4 h-4 rounded-full bg-chart-1 border-2 border-white shadow-md transform -translate-x-1/2 -translate-y-1/2 transition-all duration-200 z-10"
            style={{
              left: averagePosition.x,
              top: averagePosition.y,
            }}
          >
            <div className="absolute -top-8 left-1/2 -translate-x-1/2 bg-card p-1 rounded shadow-md text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
              <span className="font-medium">Average</span>
              <div className="text-[10px]">
                <div>Pitch: {averageValue.pitch}</div>
                <div>Depth: {averageValue.depth}</div>
              </div>
            </div>
          </div>
        )}

        {/* Main value dot */}
        <div
          className={cn(
            "absolute w-4 h-4 rounded-full bg-chart-2 border-2 border-white shadow-md transform -translate-x-1/2 -translate-y-1/2 transition-all duration-200 z-20",
            interactive && "cursor-pointer"
          )}
          style={{
            left: mainPosition.x,
            top: mainPosition.y,
          }}
        >
          <div className="absolute -top-8 left-1/2 -translate-x-1/2 bg-card p-1 rounded shadow-md text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
            <span className="font-medium">Your Rating</span>
            <div className="text-[10px]">
              <div>Pitch: {value.pitch}</div>
              <div>Depth: {value.depth}</div>
            </div>
          </div>
        </div>
      </div>

      {/* Labels */}
      {showLabels && (
        <>
          <div className="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-16 text-sm font-medium text-muted-foreground whitespace-nowrap">
            PITCH LOWER
          </div>
          <div className="absolute right-0 top-1/2 -translate-y-1/2 translate-x-16 text-sm font-medium text-muted-foreground whitespace-nowrap">
            PITCH HIGHER
          </div>
          <div className="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-6 text-sm font-medium text-muted-foreground whitespace-nowrap">
            DEPTH THINNER
          </div>
          <div className="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-6 text-sm font-medium text-muted-foreground whitespace-nowrap">
            DEPTH THICKER
          </div>
        </>
      )}

      {/* Coordinates display (for interactive charts) */}
      {interactive && (
        <div className="mt-4 flex items-center justify-center space-x-4 text-sm">
          <div className="flex flex-col items-center">
            <span className="text-muted-foreground">Pitch</span>
            <span className="font-medium">{value.pitch}</span>
          </div>
          <div className="flex flex-col items-center">
            <span className="text-muted-foreground">Depth</span>
            <span className="font-medium">{value.depth}</span>
          </div>
        </div>
      )}
    </div>
  );
}