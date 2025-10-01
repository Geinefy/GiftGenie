import { Button } from "@/components/ui/button";
import { ArrowRight, Sparkles, Gift, Heart } from "lucide-react";
import { Link } from "react-router-dom";
import heroImage from "@/assets/hero-gifts.jpg";

export const Home = () => {
  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-br from-primary/10 via-background to-secondary/10 -z-10" />
        
        <div className="container mx-auto px-4 py-20 md:py-32">
          <div className="grid md:grid-cols-2 gap-12 items-center">
            <div className="space-y-6">
              <h1 className="text-4xl md:text-6xl font-bold leading-tight">
                Find the{" "}
                <span className="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                  Perfect Gift
                </span>{" "}
                with AI
              </h1>
              <p className="text-lg text-muted-foreground">
                Let our AI-powered assistant help you discover unique, personalized gift ideas
                for any occasion. Just describe the person, and we'll do the rest!
              </p>
              <div className="flex flex-col sm:flex-row gap-4">
                <Button variant="hero" size="lg" asChild>
                  <Link to="/gifts">
                    Start Finding Gifts <ArrowRight className="ml-2" />
                  </Link>
                </Button>
                <Button variant="outline" size="lg" asChild>
                  <Link to="/auth">Sign Up Free</Link>
                </Button>
              </div>
            </div>

            <div className="relative">
              <img
                src={heroImage}
                alt="Beautiful gift boxes"
                className="rounded-2xl shadow-[var(--shadow-glow)] w-full"
              />
            </div>
          </div>
        </div>
      </section>

      {/* How It Works */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center mb-12">
            How It Works
          </h2>
          
          <div className="grid md:grid-cols-3 gap-8">
            <div className="text-center space-y-4">
              <div className="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto">
                <Sparkles className="w-8 h-8 text-primary-foreground" />
              </div>
              <h3 className="text-xl font-semibold">1. Describe the Person</h3>
              <p className="text-muted-foreground">
                Tell our AI about the recipient - their interests, age, and the occasion
              </p>
            </div>

            <div className="text-center space-y-4">
              <div className="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto">
                <Gift className="w-8 h-8 text-primary-foreground" />
              </div>
              <h3 className="text-xl font-semibold">2. Get Suggestions</h3>
              <p className="text-muted-foreground">
                Receive personalized gift recommendations tailored to your needs
              </p>
            </div>

            <div className="text-center space-y-4">
              <div className="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto">
                <Heart className="w-8 h-8 text-primary-foreground" />
              </div>
              <h3 className="text-xl font-semibold">3. Make Their Day</h3>
              <p className="text-muted-foreground">
                Purchase the perfect gift and create unforgettable memories
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center text-primary-foreground">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              Ready to Find the Perfect Gift?
            </h2>
            <p className="text-lg mb-8 opacity-90">
              Join thousands of happy gift-givers who found exactly what they needed
            </p>
            <Button variant="secondary" size="lg" asChild>
              <Link to="/gifts">
                Get Started Now <ArrowRight className="ml-2" />
              </Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  );
};
