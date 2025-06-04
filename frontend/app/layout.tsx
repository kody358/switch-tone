import './globals.css';
import type { Metadata } from 'next';
import { Inter } from 'next/font/google';
import { ThemeProvider } from '@/components/ThemeProvider';
import Link from 'next/link';
import { Keyboard } from 'lucide-react';
import { ThemeToggle } from '@/components/ThemeToggle';

const inter = Inter({ subsets: ['latin'] });

export const metadata: Metadata = {
  title: 'KeySound - Mechanical Key Switch Sound Reviews',
  description: 'Review and explore the sound profiles of mechanical keyboard switches',
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en" suppressHydrationWarning>
      <body className={inter.className}>
        <ThemeProvider attribute="class" defaultTheme="system" enableSystem>
          <div className="flex min-h-screen flex-col">
            <header className="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
              <div className="container flex h-16 items-center justify-between">
                <Link href="/" className="flex items-center space-x-2">
                  <Keyboard className="h-6 w-6" />
                  <span className="font-bold text-lg">KeySound</span>
                </Link>
                
                <nav className="hidden md:flex items-center space-x-6 text-sm font-medium">
                  <Link href="/" className="transition-colors hover:text-foreground/80">
                    Home
                  </Link>
                  <Link href="/users/1" className="transition-colors hover:text-foreground/80">
                    Profile
                  </Link>
                </nav>
                
                <div className="flex items-center space-x-2">
                  <ThemeToggle />
                </div>
              </div>
            </header>
            
            <main className="flex-1">
              {children}
            </main>
            
            <footer className="border-t py-6 md:py-0">
              <div className="container flex flex-col md:h-16 items-center md:flex-row md:justify-between">
                <p className="text-sm text-muted-foreground md:text-base py-4">
                  &copy; {new Date().getFullYear()} KeySound. All rights reserved.
                </p>
                <div className="flex items-center space-x-4 text-sm text-muted-foreground md:text-base py-4">
                  <Link href="/" className="hover:underline">
                    Terms
                  </Link>
                  <Link href="/" className="hover:underline">
                    Privacy
                  </Link>
                </div>
              </div>
            </footer>
          </div>
        </ThemeProvider>
      </body>
    </html>
  );
}