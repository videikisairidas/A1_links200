<?php 
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login-submit', 'logout'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://127.0.0.1:5173',
        "*"
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0, // cache preflight for 24 hours

    'supports_credentials' => true ,//false
    // 'Access-Control-Allow-Credentials' => true, //false
];
