<?php

use app\helpers\VenueHelper;
use app\models\ReviewVenue;

use kartik\rating\StarRating;

use yii\helpers\Inflector;

?>

<button
    class="btn btn-primary review-view-button my-4"
    type="button"
    data-toggle="collapse"
    data-target="#review-view-button-venue"
    aria-expanded="false"
    aria-controls="review-view-button"
>
    More
</button>
<div class="collapse view-criteria-container" id="review-view-button-venue">
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SERVICE); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-venue-'.$venue->venue_id,
                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_SERVICE),
                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_LOCATION); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-venue-'.$venue->venue_id,
                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_LOCATION),
                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_VALUE); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-venue-'.$venue->venue_id,
                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_VALUE),
                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-venue-'.$venue->venue_id,
                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_CLEANLINESS),
                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-6 d-flex">
            <h6 class="m-0 m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SIZE); ?></h6>
        </div>
        <div class="col-sm-8 col-lg-6 text-right">
            <?= StarRating::widget([
                'name' => 'review-venue-'.$venue->venue_id,
                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_SIZE),
                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
            ]); ?>
        </div>
    </div>
</div>