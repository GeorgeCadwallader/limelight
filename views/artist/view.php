<?php

/** @var $this yii\web\View */
/** @var $artist app\models\Artist */

$this->title = $artist->name.' | '.Yii::$app->name;

?>

<h1><?= $artist->name; ?></h1>