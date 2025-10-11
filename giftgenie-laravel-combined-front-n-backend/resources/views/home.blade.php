<x-app-layout>
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10"></div>
        
        <div class="container mx-auto px-4 py-20 md:py-32">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                        Find the 
                        <span style="background-image: linear-gradient(90deg,var(--primary-start),var(--primary-end)); -webkit-background-clip: text; background-clip: text; color: transparent;">
                            Perfect Gift
                        </span> 
                        with AI
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Let our AI-powered assistant help you discover unique, personalized gift ideas
                        for any occasion. Just describe the person, and we'll do the rest!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('gifts') }}" class="gg-primary-gradient px-8 py-3 rounded-lg font-semibold transition-all inline-flex items-center justify-center text-white hover:shadow-lg">
                            Start Finding Gifts 
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        @guest
                        <a href="{{ route('register') }}" class="border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                            Sign Up Free
                        </a>
                        @endguest
                    </div>
                </div>

                <div class="relative">
                    <img src="/assets/hero-gifts.jpg" alt="Beautiful gift boxes" class="rounded-2xl shadow-2xl w-full object-cover h-96">
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-white">How It Works</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">Three simple steps to the perfect gift</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Describe</h3>
                    <p class="text-gray-600 dark:text-gray-300">Tell us about the person you're shopping for</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Discover</h3>
                    <p class="text-gray-600 dark:text-gray-300">Get personalized gift recommendations</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Delight</h3>
                    <p class="text-gray-600 dark:text-gray-300">Give the perfect gift and make them smile</p>
                </div>
            </div>
        </div>
    </section>
</div>
</x-app-layout>
