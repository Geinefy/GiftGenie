<footer class="gg-navbar border-t gg-sep mt-8">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-sm text-gray-600">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
            <div class="flex space-x-6 text-sm">
                <a href="{{ route('faq') }}" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    FAQ
                </a>
                <a href="{{ route('contact') }}" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</footer>
