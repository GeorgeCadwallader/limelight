<?php

return [
    // 'payPalClientId' => env('PAYPAL_CLIENT_ID'),
    // 'payPalClientSecret' => env('PAYPAL_SECRET'),

    'adminEmail' => env('APP_EMAIL_ADMIN'),
    'senderEmail' => env('APP_EMAIL_ADMIN'),
    'senderName' => env('APP_EMAIL_ADMIN'),
    // 'bsVersion' => '4.x',
    'bsDependencyEnabled' => false,

    'user.activationTokenExpire' => 60 * 60 * 24 * 7,

    'reviewArtistNew' => [
        'pluginOptions' => [
            'filledStar' => '<i class="limelight-lime"></i>',
            'emptyStar' => '<i class="limelight-lime-empty"></i>',
            'min' => 0,
            'max' => 5,
            'step' => 0.5,
            'showCaption' => false,
        ]
    ],

    'reviewVenueNew' => [
        'pluginOptions' => [
            'filledStar' => '<i class="limelight-lime"></i>',
            'emptyStar' => '<i class="limelight-lime-empty"></i>',
            'min' => 0,
            'max' => 5,
            'step' => 0.5,
            'showCaption' => false,
        ]
    ],

    'reviewArtistDisplay' => [
        'filledStar' => '<i class="limelight-lime"></i>',
        'emptyStar' => '<i class="limelight-lime-empty"></i>',
        'readonly' => true,
        'showClear' => false,
        'showCaption' => false,
    ],

    'reviewVenueDisplay' => [
        'filledStar' => '<i class="limelight-lime"></i>',
        'emptyStar' => '<i class="limelight-lime-empty"></i>',
        'readonly' => true,
        'showClear' => false,
        'showCaption' => false,
    ],

    'reviewVenueOverallDisplay' => [
        'filledStar' => '<i class="limelight-lime event-lime"></i>',
        'emptyStar' => '<i class="limelight-lime-empty event-lime"></i>',
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
    ],

    'paginationConfig' => [
        'options' => ['class' => 'btn-group p-3 pagination'],
        'linkContainerOptions' => ['class' => 'btn btn-primary px-3'],
        'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
        'nextPageLabel' => '<i class="fa fa-chevron-right"></i>',
    ]
];
