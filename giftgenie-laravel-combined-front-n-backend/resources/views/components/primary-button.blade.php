<button {{ $attributes->merge(['type' => 'submit', 'class' => 'gg-primary-gradient inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
