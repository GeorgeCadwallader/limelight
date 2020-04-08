<?php

/** @var $this yii\web\View */
/** @var $owner app\models\User */

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Rate Venues & Artists Live</h1>
        <p>Welcome back <?= $owner->username; ?>!</p>
        <p>Your Venue: <?= $owner->venue->name; ?></p>
        <p>A review platform for live music events with User Experience at center stage</p>
    </div>
</div>