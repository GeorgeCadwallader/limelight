<?php

$config = [
    'id' => 'limelight',
    'name' => 'Limelight',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => require(__DIR__ . '/parts/aliases.php'),
    'timeZone' => 'Europe/London',
    'components' => [
        'authManager' => ['class' => 'yii\rbac\DbManager'],
        'request' => [
            'enableCsrfCookie' => YII_ENV_TEST,
            'parsers' => ['application/json' => 'yii\web\JsonParser'],

            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'FD58zX_qSI0xG1VzOyP4kgtoW39wR-Lr',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'authTimeout' => 60 * 45,
        ],
        'assetManager' => [
            'bundles' => false,
            'linkAssets' => true,
        ],
        'errorHandler' => ['errorAction' => 'site/error'],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => env('YII_FILE_TRANSPORT', false),
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => env('EMAIL_SMPT_HOST', 'localhost'),
            //     'port' => '25',
            // ],
        ],
        'log' => [
            'traceLevel' => (YII_DEBUG) ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.env('DB_HOST', 'localhost').';dbname='.env('DB_NAME'),
            'username' => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'enableSchemaCache' => env('DB_CACHE'),
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__.'/parts/urlRules.php'),
        ],
    ],
    'params' => require(__DIR__.'/parts/params.php'),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    if (class_exists('yii\debug\Module')) {
        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '*'],
            'panels' => [
                'user' => [
                    'class' => 'yii\debug\panels\UserPanel',
                    'ruleUserSwitch' => ['allow' => true],
                    'filterColumns' => [
                        'user_id',
                        'first_name',
                        'last_name',
                        'email',
                    ],
                ],
            ],
        ];
    }

    if (class_exists('yii\gii\Module')) {
        $config['bootstrap'][] = 'gii';
        $config['modules']['gii'] = [
            'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '*'],
        ];
    }
}

return $config;
