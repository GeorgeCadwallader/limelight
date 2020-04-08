<?php

/** @var $this yii\web\View */
/** @var $member app\models\User */

use app\helpers\Html;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Rate Venues & Artists Live</h1>
        <p>Welcome back <?= $member->username; ?>!</p>
        <p>A review platform for live music events with User Experience at center stage</p>
        <?= Html::a('Get started', '/register', ['class' => 'btn btn-primary']); ?>
    </div>
</div>