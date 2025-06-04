export interface KeySwitch {
  id: number;
  name: string;
  brand: string;
  type: string; // Linear, Tactile, Clicky
  price?: number;
  imageUrl?: string;
  description?: string;
  createdAt: Date;
}

export interface Review {
  id: number;
  switchId: number;
  userId: number;
  pitch: number; // -100 to 100, where negative is low pitch, positive is high pitch
  depth: number; // -100 to 100, where negative is thin, positive is thick
  text: string;
  likes: number;
  createdAt: Date;
}

export interface User {
  id: number;
  name: string;
  avatar?: string;
  bio?: string;
  reviewCount: number;
  createdAt: Date;
}

export interface SoundProfile {
  pitch: number; // -100 to 100
  depth: number; // -100 to 100
}