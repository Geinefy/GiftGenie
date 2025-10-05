<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // <-- এখানে 8080 যোগ করো
    'allowed_origins' => [
        'http://localhost:3000',  // React dev server default
        'http://localhost:5173',  // Vite dev server default
        'http://localhost:8080',  // Alternative port
        'http://127.0.0.1:3000',
        'http://127.0.0.1:5173',
        'http://127.0.0.1:8080',
    ],

    'allowed_origins_patterns' => [
        '#^https?://(localhost|127\.0\.0\.1):(3000|5173|8080)$#'
    ],

    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,

    // কুকি/সেশন লাগলে true, না লাগলে false-ই থাকুক
    'supports_credentials' => false,
];
