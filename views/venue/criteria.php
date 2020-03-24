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
    data-target="#review-view-button"
    aria-expanded="false"
    aria-controls="review-view-button"
>
    More
</button>
<div class="collapse view-criteria-container" id="review-view-button">
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SERVICE); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-venue-'.$venue->venue_id,
            'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_SERVICE),
            'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
        ]); ?>
    </div>
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_LOCATION); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-venue-'.$venue->venue_id,
            'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_LOCATION),
            'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
        ]); ?>
    </div>
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_VALUE); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-venue-'.$venue->venue_id,
            'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_VALUE),
            'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
        ]); ?>
    </div>
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-venue-'.$venue->venue_id,
            'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_CLEANLINESS),
            'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
        ]); ?>
    </div>
    <div class="my-3">
        <h4 class="m-0"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SIZE); ?></h4>
        <?= StarRating::widget([
            'name' => 'review-venue-'.$venue->venue_id,
            'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_SIZE),
            'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
        ]); ?>
    </div>
</div>