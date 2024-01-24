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
    'Access_Control_Allow_Origin' => [' http://127.0.0.1:8000'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => [//  'Content-Type, Authorization, Accept'
        '*'
    ],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];

