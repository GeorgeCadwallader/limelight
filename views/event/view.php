<?php

/** @var $this yii\web\View */
/** @var $event app\models\Event */

use app\helpers\ArtistHelper;
use app\helpers\EventHelper;
use app\helpers\Html;
use app\helpers\VenueHelper;
use app\models\ReviewArtist;
use app\models\ReviewVenue;

use kartik\rating\StarRating;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

$this->title = 'View '.EventHelper::eventName($event).' | '.Yii::$app->name;

$artist = $event->artist;
$venue = $event->venue;

$artistReviews = ReviewArtist::find()
    ->where(['artist_id' => $artist->artist_id])
    ->andWhere(['status' => ReviewArtist::STATUS_ACTIVE])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(5)
    ->all();

$venueReviews = ReviewVenue::find()
    ->where(['venue_id' => $venue->venue_id])
    ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(5)
    ->all();

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
<div class="row mt-3 mb-2">
    <div class="col-sm-12">
        <h1><?= EventHelper::eventName($event); ?></h1>
    </div>
</div>
<div class="row mt-2 mb-4">
    <div class="col-sm-12">
        <div class="alert alert-primary alert-dismissible d-inline-block" role="alert">
            <?= Html::icon('fire', ['class' => 'mr-2']); ?> This event has been created <?= $event->creations; ?> time(s)!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <div class="rounded limelight-box-shadow text-center p-4">
            <h2>Event overall rating</h2>
            <div class="alert alert-primary d-inline-block" role="alert">
                Average overall rating based off of Artist and Venue overall ratings.
                <br><br>
                Based off of all our data this is how well we believe this potential event would go.
            </div>
            <?= StarRating::widget([
                'name' => 'review-event-'.$venue->venue_id,
                'value' => EventHelper::combinedAverage($artist, $venue),
                'pluginOptions' => Yii::$app->params['reviewVenueOverallDisplay']
            ]); ?>
        </div>
    </div>
</div>
<div class="row mb-3 mt-5">
    <div class="col-sm-6">
        <div
            class="contained-image rounded limelight-box-shadow"
            style="background-image: url(<?= ArtistHelper::imageUrl($artist); ?>);"
        >
        </div>
    </div>
    <div class="col-sm-6">
        <div
            class="contained-image rounded limelight-box-shadow"
            style="background-image: url(<?= VenueHelper::imageUrl($venue); ?>);"
        >
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-6">
        <?= $this->render('../artist/partials/criteria', compact('artist')); ?>
    </div>
    <div class="col-sm-6">
        <?= $this->render('../venue/partials/criteria', compact('venue')); ?>
    </div>
</div>
<div class="row my-5">
    <div class="col-lg-6">
        <h3>Latest <?= $artist->name; ?> reviews</h3>
        <?php foreach ($artistReviews as $model) {
            echo $this->render('./partials/review-artist-view', compact('model'));
        } ?>
    </div>
    <div class="col-lg-6">
        <h3>Latest <?= $venue->name; ?> reviews</h3>
        <?php foreach ($venueReviews as $model) {
            echo $this->render('./partials/review-venue-view', compact('model'));
        } ?>
    </div>
</div>
