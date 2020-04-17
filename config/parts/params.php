<?php

return [
    'adminEmail' => env('APP_EMAIL_ADMIN'),
    'senderEmail' => env('APP_EMAIL_ADMIN'),
    'senderName' => env('APP_EMAIL_ADMIN'),
    // 'bsVersion' => '4.x',
    'bsDependencyEnabled' => false,

    'user.activationTokenExpire' => 60 * 60 * 24 * 7,

    'reviewArtistNew' => [
        'pluginOptions' => [
            'filledStar' => '<i class="fa fa-star"></i>',
            'emptyStar' => '<i class="fa fa-star"></i>',
            'min' => 0,
            'max' => 5,
            'step' => 0.5,
            'showCaption' => false,
        ]
    ],

    'reviewVenueNew' => [
        'pluginOptions' => [
            'filledStar' => '<i class="fa fa-star"></i>',
            'emptyStar' => '<i class="fa fa-star"></i>',
            'min' => 0,
            'max' => 5,
            'step' => 0.5,
            'showCaption' => false,
        ]
    ],

    'reviewArtistDisplay' => [
        'filledStar' => '<i class="fa fa-star"></i>',
        'emptyStar' => '<i class="fa fa-star"></i>',
        'readonly' => true,
        'showClear' => false,
        'showCaption' => false,
    ],

    'reviewVenueDisplay' => [
        'filledStar' => '<i class="fa fa-star"></i>',
        'emptyStar' => '<i class="fa fa-star"></i>',
        'readonly' => true,
        'showClear' => false,
        'showCaption' => false,
    ],

    'richtextOptions' => [
        'options' => [
            'rows' => 6,
        ],
        'clientOptions' => [
            'toolbar' => "undo redo | bold italic",
            'paste_data_images' => false
        ]
    ]
];
