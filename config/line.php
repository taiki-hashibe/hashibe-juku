<?php

return [
    'link' => env('LINE_LINK'),
    'login' => [
        'channel_id' => env('LINE_LOGIN_CHANNEL_ID'),
        'channel_secret' => env('LINE_LOGIN_CHANNEL_SECRET'),
        'callback_url' => env('LINE_LOGIN_CALLBACK_URL'),
    ],
    'messaging_api' => [
        'channel_id' => env('LINE_MESSAGING_API_CHANNEL_ID'),
        'channel_secret' => env('LINE_MESSAGING_API_CHANNEL_SECRET'),
        'channel_access_token' => env('LINE_MESSAGING_API_CHANNEL_ACCESS_TOKEN'),
    ],
    'liff' => [
        'step_id' => env('LINE_LIFF_STEP_ID')
    ],
    'my_id' => env('LINE_MY_ID'),
    'video' => [
        '1' => env('LINE_VIDEO_PATH_1'),
        '2' => env('LINE_VIDEO_PATH_2')
    ]
];
