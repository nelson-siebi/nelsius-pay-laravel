<?php

return [
    'public_key'     => env('NELSIUS_PUBLIC_KEY', ''),
    'secret_key'     => env('NELSIUS_SECRET_KEY', ''),
    'base_url'       => env('NELSIUS_BASE_URL', 'https://api.nelsiuspay.com/api/v1'),
    'webhook_secret' => env('NELSIUS_WEBHOOK_SECRET', ''),
    'timeout'        => env('NELSIUS_TIMEOUT', 30),
];
