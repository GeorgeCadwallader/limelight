<?php

return [
    'adminEmail' => env('APP_EMAIL_ADMIN'),
    'senderEmail' => env('APP_EMAIL_ADMIN'),
    'senderName' => env('APP_EMAIL_ADMIN'),
    // 'bsVersion' => '4.x',
    'bsDependencyEnabled' => false,

    'user.activationTokenExpire' => 60 * 60 * 24 * 7,
];
