<?php

/** @var $this yii\web\View */

use app\models\Artist;

use yii\bootstrap4\Breadcrumbs;

$artists = Artist::find()->where(['status' => Artist::STATUS_ACTIVE])->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Artists',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <h1>Artists</h1>
    </div>
</div>
<div class="row my-3">
    <?php foreach ($artists as $artist) { ?>
        <div class="col-sm-4">
            <?= $this->render('artist-contained', compact('artist')); ?>
        </div>
    <?php } ?>
</div>
