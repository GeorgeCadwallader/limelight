<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

$this->title = 'Contact Us | '.Yii::$app->name;

?>
<div class="row">
    <?= Breadcrumbs::widget([
        'links' => [
            ['label' => 'Contact Us']
        ]
    ]); ?>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1>Contact Us</h1>
    </div>
</div>
