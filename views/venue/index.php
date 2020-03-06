<?php

/** @var $this yii\web\View */

use app\models\Venue;
use yii\bootstrap4\Breadcrumbs;

$artists = Venue::find()->where(['status' => Venue::STATUS_ACTIVE])->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Venues',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <h1>Venues</h1>
    </div>
</div>
<div class="row my-3">
    <?php foreach ($venues as $venue) { ?>
        <div class="col-sm-4">
            <?= $this->render('venue-contained', compact('venue')); ?>
        </div>
    <?php } ?>
</div>
