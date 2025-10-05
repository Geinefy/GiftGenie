<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // <-- এখানে 8080 যোগ করো
    'allowed_origins' => [
        'http://localhost:8080',
        'http://127.0.0.1:8080', // (ঐচ্ছিক, আলাদা করে 127.0.0.1 ব্যবহার করলে)
    ],

    // চাইলে প্যাটার্ন ব্যবহার করে 5173/8080 দুইটাই কাভার করতে পারো:
    // 'allowed_origins_patterns' => ['#^https?://(localhost|127\.0\.0\.1):(5173|8080)$#'],
    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,

    // কুকি/সেশন লাগলে true, না লাগলে false-ই থাকুক
    'supports_credentials' => false,
];
