<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $genre app\models\Genre */

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Genres',
                    'url' => Url::to('/genre')
                ],
                ['label' => 'View Genre: '.$genre->name]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1><?= $genre->name; ?></h1>
    </div>
</div>