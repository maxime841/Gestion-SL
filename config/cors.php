<?php

return [
    'paths' => [
        '*', 
        'sanctum/csrf-cookie'
    ],
    'allowed_methods' => [ //'GET, POST, PUT, PATCH, DELETE, OPTIONS'
        'GET', 
        'POST', 
        'PUT', 
        'PATCH', 
        'DELETE', 
        'OPTIONS'
    ],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => [//  'Content-Type, Authorization, Accept'
        '*'
    ],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];

