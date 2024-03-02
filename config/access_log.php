<?php

return [
    'ignore_ips' => env('ACCESS_LOG_IGNORE') ? array_map('trim', explode(',', env('ACCESS_LOG_IGNORE'))) : [],
    'route_names' => [
        'home' => 'トップページ',
        ''
    ]
];
