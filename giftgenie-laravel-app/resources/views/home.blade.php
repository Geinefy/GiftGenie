<x-app-layout>
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-background to-purple-50 -z-10"></div>
        
        <div class="container mx-auto px-4 py-20 md:py-32">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                        Find the 
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Perfect Gift
                        </span> 
                        with AI
                    </h1>
                    <p class="text-lg text-gray-600">
                        Let our AI-powered assistant help you discover unique, personalized gift ideas
                        for any occasion. Just describe the person, and we'll do the rest!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/gifts" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-all inline-flex items-center justify-center">
                            Start Finding Gifts 
                            <i data-lucide="arrow-right" class="ml-2 w-4 h-4"></i>
                        </a>
                        <a href="/auth" class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                            Sign Up Free
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <img src="/assets/hero-gifts.jpg" alt="Beautiful gift boxes" class="rounded-2xl shadow-glow w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">How It Works</h2>
                <p class="text-xl text-gray-600">Three simple steps to the perfect gift</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="sparkles" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Describe</h3>
                    <p class="text-gray-600">Tell us about the person you're shopping for</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="gift" class="w-8 h-8 text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Discover</h3>
                    <p class="text-gray-600">Get personalized gift recommendations</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="heart" class="w-8 h-8 text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Delight</h3>
                    <p class="text-gray-600">Give the perfect gift and make them smile</p>
                </div>
            </div>
        </div>
    </section>
</div>
</x-app-layout>
