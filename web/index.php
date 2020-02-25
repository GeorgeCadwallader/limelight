<?php

$rootDir = dirname(__DIR__);

include $rootDir.'/bootstrap.php';
$config = include $rootDir.'/config/web.php';

$app = new yii\web\Application($config);

$app->on(\yii\web\Application::EVENT_AFTER_REQUEST, function (\yii\base\Event $event) {
    $headers = $event->sender->response->headers;
    $headers->setDefault('X-Content-Type-Options', 'nosniff');
    $headers->setDefault('Strict-Transport-Security', 'max-age=2592000;');
    $headers->setDefault('X-XSS-Protection', '1; mode=block');

    if (YII_ENV_PROD) {
        $headers->setDefault('X-Frame-Options', 'DENY');
    }

    if (!$event->sender->request->isAjax) {
        $event->sender->user->setReturnUrl($event->sender->request->url);
    }
});

$app->run();
