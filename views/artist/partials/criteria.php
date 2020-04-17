<?php

use app\helpers\ArtistHelper;
use app\models\ReviewArtist;
use kartik\rating\StarRating;
use yii\helpers\Inflector;

?>

<button
    class="btn btn-primary review-view-button my-4"
    type="button"
    data-toggle="collapse"
    data-target="#review-view-button"
    aria-expanded="false"
    aria-controls="review-view-button"
>
    More
</button>
<div class="collapse view-criteria-container" id="review-view-button">
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_ENERGY); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-artist-'.$artist->artist_id,
            'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_ENERGY),
            'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
        ]); ?>
    </div>
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_VOCALS); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-artist-'.$artist->artist_id,
            'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_VOCALS),
            'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
        ]); ?>
    </div>
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_SOUND); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-artist-'.$artist->artist_id,
            'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_SOUND),
            'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
        ]); ?>
    </div>
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-artist-'.$artist->artist_id,
            'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE),
            'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
        ]); ?>
    </div>
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-artist-'.$artist->artist_id,
            'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC),
            'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
        ]); ?>
    </div>
</div>