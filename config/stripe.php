<?php

return [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    'product' => env('STRIPE_PRODUCT'),
    'price' => env('STRIPE_PRICE'),
];
