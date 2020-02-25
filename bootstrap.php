<?php

/**
 * @codingStandardsIgnoreStart
 */

use Dotenv\Environment\Adapter\ArrayAdapter;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Loader;

$rootDir = __DIR__;

$require = function ($file) use ($rootDir) {
    if (is_file($rootDir.$file)) {
        include $rootDir.$file;
    }
};

$require('/vendor/autoload.php');

if (!function_exists('env')) {
    function env(string $var, $default = null) {
        if (!isset($GLOBALS['__dot_env'])) {
            $loader = new Loader(
                [__DIR__ . '/.env'],
                new DotenvFactory([new ArrayAdapter])
            );

            $loader->load();
            $GLOBALS['__dot_env'] = $loader;
        } else {
            $loader = $GLOBALS['__dot_env'];
        }

        return $loader->getEnvironmentVariable($var) ?? $default;
    }
}


defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG', false));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV', 'prod'));

if (YII_ENV === 'dev') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (YII_ENV !== 'test') {
    $require('/vendor/yiisoft/yii2/Yii.php');
}
