<?php

use app\helpers\Html;
use app\models\Artist;
use app\models\Genre;
use app\models\Venue;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $genre app\models\Genre */
/** @var $adverts app\models\Advert */

$this->title = 'View Genre - '.$genre->name.' | '.Yii::$app->name;

$mainGenre = $genre;

$childrenGenres = Genre::find()
    ->where(['parent_id' => $mainGenre->genre_id])
    ->limit(6)
    ->all();

$artistGenres = Artist::find()
    ->joinWith('genre')
    ->where(['{{%artist_genre}}.[[genre_id]]' => $mainGenre->genre_id])
    ->andWhere(['status' => Artist::STATUS_ACTIVE])
    ->limit(6)
    ->all();

$venueGenre = Venue::find()
    ->joinWith('genre')
    ->where(['{{%venue_genre}}.[[genre_id]]' => $mainGenre->genre_id])
    ->andWhere(['status' => Venue::STATUS_ACTIVE])
    ->limit(6)
    ->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Genres',
                    'url' => Url::to('/genre')
                ],
                ['label' => 'View Genre: '.$mainGenre->name]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1><?= $mainGenre->name; ?></h1>
    </div>
</div>
<?php if (!empty($childrenGenres)) { ?>
    <div class="row mt-3 mb-4">
        <div class="col-sm-12 mb-4">
            <h2><?= $mainGenre->name.' sub-genres'; ?></h2>
        </div>
        <?php foreach ($childrenGenres as $childGenre) { ?>
            <div class="col-sm-4">
                <?= Html::a($childGenre->name, ['/genre/view', 'genre_id' => $childGenre->genre_id], ['class' => 'h3']); ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<?php if (!empty($adverts)) { ?>
    <div class="row">
    <?php foreach ($adverts as $model) { ?>
        <div class="col-md-3">
            <?= $this->render('../advert/partials/advert-single', compact('model')); ?>
        </div>
    <?php } ?>
    </div>
<?php } ?>
<?php if (!empty($artistGenres)) { ?>
    <div class="row my-5">
        <div class="col-sm-12">
            <h2>Artists with this genre</h2>
        </div>
        <?php foreach ($artistGenres as $model) { ?>
            <div class="col-sm-4">
                <?= $this->render('../artist/artist-contained', compact('model')); ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<?php if (!empty($venueGenre)) { ?>
    <div class="row my-5">
        <div class="col-sm-12">
            <h2>Venues with this genre</h2>
        </div>
        <?php foreach ($venueGenre as $model) { ?>
            <div class="col-sm-4">
                <?= $this->render('../venue/venue-contained', compact('model')); ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>