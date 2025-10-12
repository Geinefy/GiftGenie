<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Frequently Asked Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    Frequently Asked Questions
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Find answers to common questions about GiftGenie. Can't find what you're looking for? 
                    <a href="{{ route('contact') }}" class="text-accent-4 hover:opacity-80 underline">Contact us</a> 
                    for personalized help.
                </p>
            </div>

            <!-- Search FAQ -->
            <div class="mb-8">
                <div class="relative">
                    <input 
                        type="text" 
                        id="faqSearch" 
                        placeholder="Search FAQ..." 
                        class="w-full px-4 py-3 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-4 focus:border-accent-4 dark:bg-gray-700 dark:text-gray-100"
                    >
                    <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- FAQ Categories -->
            @foreach($faqs as $categoryIndex => $category)
            <div class="mb-8 faq-category" data-category="{{ strtolower(str_replace(' ', '-', $category['category'])) }}">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <!-- Category Header -->
                    <div class="gg-primary-gradient px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            @switch($categoryIndex)
                                @case(0)
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    @break
                                @case(1)
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    @break
                                @case(2)
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    @break
                                @case(3)
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 109.75 9.75A9.75 9.75 0 0012 2.25z"></path>
                                    </svg>
                            @endswitch
                            {{ $category['category'] }}
                        </h2>
                    </div>

                    <!-- Questions -->
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($category['questions'] as $questionIndex => $faq)
                        <div class="faq-item">
                            <button 
                                class="w-full px-6 py-4 text-left focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 faq-question"
                                onclick="toggleFaq('faq-{{ $categoryIndex }}-{{ $questionIndex }}')"
                            >
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 pr-4">
                                        {{ $faq['question'] }}
                                    </h3>
                                    <svg 
                                        class="w-5 h-5 text-gray-500 transform transition-transform duration-200 faq-icon" 
                                        id="icon-faq-{{ $categoryIndex }}-{{ $questionIndex }}"
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                            <div 
                                class="faq-answer hidden px-6 pb-4"
                                id="faq-{{ $categoryIndex }}-{{ $questionIndex }}"
                            >
                                <div class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Still Have Questions Section -->
            <div class="gg-primary-gradient rounded-lg p-8 text-center text-white mt-12">
                <h2 class="text-2xl font-bold mb-4">Still Have Questions?</h2>
                <p class="text-lg mb-6 opacity-90">
                    Can't find the answer you're looking for? Our support team is here to help!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a 
                        href="{{ route('contact') }}" 
                        class="bg-white text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors duration-200"
                    >
                        Contact Support
                    </a>
                    <a 
                        href="{{ route('home') }}" 
                        class="border-2 border-white text-white px-6 py-3 rounded-lg font-medium hover:bg-white hover:text-gray-800 transition-colors duration-200"
                    >
                        Start Finding Gifts
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ JavaScript -->
    <script>
        // Toggle FAQ answers
        function toggleFaq(id) {
            const answer = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                answer.classList.add('block');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                answer.classList.remove('block');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Search functionality
        document.getElementById('faqSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');
            const categories = document.querySelectorAll('.faq-category');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });

            // Hide categories that have no visible items
            categories.forEach(category => {
                const visibleItems = category.querySelectorAll('.faq-item[style="display: block"], .faq-item:not([style*="display: none"])');
                if (searchTerm === '' || visibleItems.length > 0) {
                    category.style.display = 'block';
                } else {
                    category.style.display = 'none';
                }
            });
        });

        // Expand all FAQs when searching
        document.getElementById('faqSearch').addEventListener('input', function(e) {
            if (e.target.value.length > 2) {
                document.querySelectorAll('.faq-answer.hidden').forEach(answer => {
                    answer.classList.remove('hidden');
                    answer.classList.add('block');
                });
                document.querySelectorAll('.faq-icon').forEach(icon => {
                    icon.style.transform = 'rotate(180deg)';
                });
            }
        });
    </script>
</x-app-layout>