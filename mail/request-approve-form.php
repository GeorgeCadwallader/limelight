<?php

/**
 *
 * @var yii\web\View $this
 * @var bool $isArtist
 * 
 * @var app\models\Artist $page
 *     or
 * @var app\models\Venue $page
 */

$urlManager = Yii::$app->urlManager;

?>

<h1>Your request on <?= Yii::$app->name; ?> for <?= $page->name; ?> has been accepted.</h1>

<br><br>

<p>Click the link below to login and start populating your new <?= ($isArtist) ? 'artist' : 'venue' ?> page</p>

<a href=<?= $urlManager->createAbsoluteUrl('/'); ?>><?= $urlManager->createAbsoluteUrl('/'); ?></a>
