<?php

/** @var $this yii\web\View */

use app\models\Genre;

use yii\bootstrap4\Breadcrumbs;

$this->title = 'Genres | '.Yii::$app->name;

$genres = Genre::find()
    ->where(['parent_id' => null])
    ->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Genres',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1>Genres</h1>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h2>Top level genres</h2>
    </div>
    <?php foreach ($genres as $genre) { ?>
        <?= $this->render('./partials/genre-contained', compact('genre')); ?>
    <?php } ?>
</div>
