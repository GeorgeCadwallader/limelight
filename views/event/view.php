<?php

/** @var $this yii\web\View */
/** @var $event app\models\Event */

use app\helpers\EventHelper;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

$this->title = 'View '.EventHelper::eventName($event).' | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Events',
                    'url' => Url::to('/event')
                ],
                ['label' => 'View: '.EventHelper::eventName($event)]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <h1><?= EventHelper::eventName($event); ?></h1>
    </div>
</div>
