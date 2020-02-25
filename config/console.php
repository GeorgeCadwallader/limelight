<?php

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => require(__DIR__.'/parts/aliases.php'),
    'timeZone' => 'Europe/London',
    'components' => [
        'authManager' => ['class' => 'yii\rbac\DbManager'],
        'cache' => ['class' => 'yii\caching\FileCache'],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'app\core\Mailer',
            'useFileTransport' => env('YII_FILE_TRANSPORT', false),
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('EMAIL_SMPT_HOST', 'localhost'),
                'port' => '25',
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
            'baseUrl' => env('APP_BASE_URL'),
            'hostInfo' => env('APP_BASE_URL'),
            'rules' => require(__DIR__.'/parts/urlRules.php'),
        ],
    ],
    'params' => require(__DIR__ . '/parts/params.php'),
];

if (YII_ENV_DEV) {
    Yii::setAlias('tests', dirname(__DIR__).'/tests');

    if (class_exists('yii\gii\Module')) {
        $config['bootstrap'][] = 'gii';
        $config['modules']['gii'] = ['class' => 'yii\gii\Module'];
    }

    \yii\helpers\ArrayHelper::setValue(
        $config,
        'controllerMap.fixture',
        ['class' => 'app\commands\FixtureController']
    );
}

return $config;

