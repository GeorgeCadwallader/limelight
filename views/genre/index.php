<?php

/** @var $this yii\web\View */

use app\helpers\Html;
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
    <div class="col-sm-12 mb-4">
        <h2>Top level genres</h2>
    </div>
    <?php foreach ($genres as $genre) { ?>
        <div class="col-sm-4">
            <?= Html::a($genre->name, ['/genre/view', 'genre_id' => $genre->genre_id], ['class' => 'h3']); ?>
        </div>
    <?php } ?>
</div>
