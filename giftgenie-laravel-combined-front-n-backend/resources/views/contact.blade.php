<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 sm:p-8">
                    <!-- Header Section -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Get in Touch</h1>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">
                            Have questions, suggestions, or need help finding the perfect gift? We'd love to hear from you!
                        </p>
                    </div>

                    <!-- Contact Form -->
                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-accent-4 focus:border-accent-4 dark:bg-gray-700 dark:text-gray-100 @error('name') border-red-500 @enderror"
                                    placeholder="Enter your full name"
                                    required
                                >
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-accent-4 focus:border-accent-4 dark:bg-gray-700 dark:text-gray-100 @error('email') border-red-500 @enderror"
                                    placeholder="Enter your email address"
                                    required
                                >
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Subject Field -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="subject" 
                                name="subject" 
                                value="{{ old('subject') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-accent-4 focus:border-accent-4 dark:bg-gray-700 dark:text-gray-100 @error('subject') border-red-500 @enderror"
                                placeholder="What's this about?"
                                required
                            >
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message Field -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="6"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-accent-4 focus:border-accent-4 dark:bg-gray-700 dark:text-gray-100 resize-vertical @error('message') border-red-500 @enderror"
                                placeholder="Tell us how we can help you..."
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Minimum 10 characters required
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button 
                                type="submit" 
                                class="gg-primary-gradient font-medium py-3 px-8 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-accent-4 focus:ring-offset-2 dark:focus:ring-offset-gray-800 hover:opacity-90"
                            >
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Send Message
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Contact Information -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
                    <div class="bg-cyan-100 dark:bg-cyan-900 p-3 rounded-full w-12 h-12 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Email Support</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Get help via email within 24 hours
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
                    <div class="bg-teal-100 dark:bg-teal-900 p-3 rounded-full w-12 h-12 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Help Center</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Browse our FAQ and guides
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
                    <div class="bg-pink-100 dark:bg-pink-900 p-3 rounded-full w-12 h-12 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Quick Response</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Fast support for urgent issues
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>