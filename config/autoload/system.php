<?php
declare(strict_types=1);

return [
    'jwt' => [
        'key' => env('JWT_KEY', 'jwt'),
        'expire' => env('JWT_EXPIRE', 86400),
    ],
    'captcha' => [
        'prefix' => 'captcha:',
        'ttl' => env('CAPTCHA_TTL', 300),
        'charset' => env('CAPTCHA_CHARSET', '123456789'),
    ],
    'login' => [
        'reset' => 'admin:reset:',
        'token' => 'admin:token:'
    ]
];
