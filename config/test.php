<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'authManager' => ['class' => 'yii\rbac\DbManager'],
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        // 'assetManager' => [
        //     'basePath' => __DIR__ . '/../web/assets',
        //     'bundles' => false,
        // ],
        'assetManager' => [
            'bundles' => [false],
            'linkAssets' => false,
        ],
        'urlManager' => [
            'showScriptName' => true,
            'enablePrettyUrl' => true,
            'rules' => [
                'debug/<controller>/<action>' => 'debug/<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
