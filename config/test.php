<?php

defined('YII_ENV') or define('YII_ENV', 'test');

require dirname(__DIR__).'/bootstrap.php';

$config = require __DIR__.'/web.php';

\yii\helpers\ArrayHelper::setValue($config, 'components.db', [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.env('DB_HOST', 'localhost').';dbname='.env('DB_NAME_TEST'),
    'username' => env('DB_USER'),
    'password' => env('DB_PASSWORD'),

    'enableSchemaCache' => env('DB_CACHE'),
]);

return $config;
