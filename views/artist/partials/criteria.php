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
    data-target="#review-view-button-artist"
    aria-expanded="false"
    aria-controls="review-view-button"
>
    More
</button>
<div class="collapse view-criteria-container" id="review-view-button-artist">
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_ENERGY); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-artist-'.$artist->artist_id,
                'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_ENERGY),
                'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_VOCALS); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-artist-'.$artist->artist_id,
                'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_VOCALS),
                'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_SOUND); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-artist-'.$artist->artist_id,
                'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_SOUND),
                'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-artist-'.$artist->artist_id,
                'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE),
                'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-artist-'.$artist->artist_id,
                'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC),
                'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
            ]); ?>
        </div>
    </div>
</div>