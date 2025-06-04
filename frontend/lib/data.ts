import { KeySwitch, Review, User } from './types';

export const switches: KeySwitch[] = [
  {
    id: 1,
    name: "Gateron Yellow",
    brand: "Gateron",
    type: "Linear",
    price: 0.35,
    imageUrl: "https://images.pexels.com/photos/1772123/pexels-photo-1772123.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
    description: "A budget-friendly linear switch known for its smooth operation and medium spring weight. Popular for both typing and gaming.",
    createdAt: new Date('2024-01-10')
  },
  {
    id: 2,
    name: "Cherry MX Blue",
    brand: "Cherry",
    type: "Clicky",
    price: 0.70,
    imageUrl: "https://images.pexels.com/photos/3654903/pexels-photo-3654903.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
    description: "The classic clicky switch with a distinctive tactile bump and audible click. Favored by typists who enjoy acoustic feedback.",
    createdAt: new Date('2024-01-15')
  },
  {
    id: 3,
    name: "HMX Sunset Gleam",
    brand: "HMX",
    type: "Linear",
    price: 1.20,
    imageUrl: "https://images.pexels.com/photos/1194713/pexels-photo-1194713.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
    description: "A premium linear switch with a unique sound signature. Features a long-pole stem and factory lubrication.",
    createdAt: new Date('2024-02-01')
  },
  {
    id: 4,
    name: "Boba U4T",
    brand: "Gazzew",
    type: "Tactile",
    price: 0.85,
    imageUrl: "https://images.pexels.com/photos/1420709/pexels-photo-1420709.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
    description: "A highly tactile switch with minimal pre-travel and a 'thocky' sound profile. Popular in the custom keyboard community.",
    createdAt: new Date('2024-02-10')
  },
  {
    id: 5,
    name: "Kailh Box White",
    brand: "Kailh",
    type: "Clicky",
    price: 0.60,
    imageUrl: "https://images.pexels.com/photos/4792729/pexels-photo-4792729.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
    description: "A snappy clicky switch with a crisp sound and IP56 dust and water resistance. Features Kailh's box design for stability.",
    createdAt: new Date('2024-01-20')
  },
  {
    id: 6,
    name: "Akko CS Silver",
    brand: "Akko",
    type: "Linear",
    price: 0.40,
    imageUrl: "https://images.pexels.com/photos/5082576/pexels-photo-5082576.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
    description: "A light linear switch with quick actuation. Designed for gaming with a shortened travel distance.",
    createdAt: new Date('2024-03-01')
  }
];

export const users: User[] = [
  {
    id: 1,
    name: "KeyboardEnthusiast",
    avatar: "https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=600",
    bio: "Mechanical keyboard enthusiast since 2015. I love linear switches and custom builds.",
    reviewCount: 15,
    createdAt: new Date('2023-06-10')
  },
  {
    id: 2,
    name: "ThockySounds",
    avatar: "https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=600",
    bio: "Always on the hunt for the perfect thocky sound profile. I review switches from a sound perspective.",
    reviewCount: 8,
    createdAt: new Date('2023-08-15')
  },
  {
    id: 3,
    name: "ClackyTypist",
    avatar: "https://images.pexels.com/photos/937481/pexels-photo-937481.jpeg?auto=compress&cs=tinysrgb&w=600",
    bio: "Programmer by day, keyboard builder by night. I prefer clicky switches with high tactility.",
    reviewCount: 12,
    createdAt: new Date('2023-07-20')
  }
];

export const reviews: Review[] = [
  {
    id: 1,
    switchId: 1,
    userId: 1,
    pitch: -40,
    depth: 30,
    text: "Smooth linear action with a surprisingly deep sound for a budget switch. Perfectly lubed from factory.",
    likes: 15,
    createdAt: new Date('2024-01-20')
  },
  {
    id: 2,
    switchId: 1,
    userId: 2,
    pitch: -20,
    depth: 40,
    text: "Gateron Yellows have a pleasant lower-pitched sound compared to most linears. Good thock when mounted on the right plate.",
    likes: 8,
    createdAt: new Date('2024-01-25')
  },
  {
    id: 3,
    switchId: 2,
    userId: 3,
    pitch: 70,
    depth: -50,
    text: "Classic Blue sound - high-pitched click with a thin profile. Exactly what you'd expect, very consistent clicky experience.",
    likes: 5,
    createdAt: new Date('2024-02-05')
  },
  {
    id: 4,
    switchId: 3,
    userId: 1,
    pitch: 10,
    depth: 60,
    text: "These produce an incredibly satisfying deep sound with just a hint of higher pitch on upstroke. Worth the premium price.",
    likes: 20,
    createdAt: new Date('2024-02-15')
  },
  {
    id: 5,
    switchId: 4,
    userId: 2,
    pitch: -10,
    depth: 80,
    text: "The U4Ts have the deepest, thockiest sound profile I've ever heard from a tactile. No spring ping whatsoever.",
    likes: 25,
    createdAt: new Date('2024-02-20')
  },
  {
    id: 6,
    switchId: 5,
    userId: 3,
    pitch: 85,
    depth: -30,
    text: "Sharp, crisp clicking with a light, thin sound profile. Very satisfying for those who enjoy audible feedback.",
    likes: 7,
    createdAt: new Date('2024-02-08')
  },
  {
    id: 7,
    switchId: 6,
    userId: 1,
    pitch: 20,
    depth: -20,
    text: "Light and snappy with a surprisingly balanced sound. Not too high-pitched for a speed switch.",
    likes: 12,
    createdAt: new Date('2024-03-10')
  }
];

// Helper functions
export const getSwitchById = (id: number): KeySwitch | undefined => {
  return switches.find(s => s.id === id);
};

export const getReviewsBySwitchId = (switchId: number): Review[] => {
  return reviews.filter(r => r.switchId === switchId);
};

export const getUserById = (id: number): User | undefined => {
  return users.find(u => u.id === id);
};

export const getReviewsByUserId = (userId: number): Review[] => {
  return reviews.filter(r => r.userId === userId);
};

export const getAverageSoundProfile = (switchId: number): { pitch: number; depth: number } => {
  const switchReviews = getReviewsBySwitchId(switchId);
  
  if (switchReviews.length === 0) {
    return { pitch: 0, depth: 0 };
  }
  
  const totalPitch = switchReviews.reduce((sum, review) => sum + review.pitch, 0);
  const totalDepth = switchReviews.reduce((sum, review) => sum + review.depth, 0);
  
  return {
    pitch: Math.round(totalPitch / switchReviews.length),
    depth: Math.round(totalDepth / switchReviews.length)
  };
};