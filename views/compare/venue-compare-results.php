<?php

use app\helpers\VenueHelper;
use app\models\ReviewVenue;

use kartik\rating\StarRating;

use yii\helpers\Inflector;

/** @var $this yii\web\View */
/** @var $venueOne app\models\Venue */
/** @var $venueTwo app\models\Venue */

$venueOneReviews = ReviewVenue::find()
    ->where(['venue_id' => $venueOne->venue_id])
    ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(4)
    ->all();

$venueTwoReviews = ReviewVenue::find()
    ->where(['venue_id' => $venueTwo->venue_id])
    ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(4)
    ->all();

?>

<table class="table table-responsive-md my-5">
    <tbody>
        <tr class="text-center">
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_OVERALL); ?>"> </td>
            <td id="filler" > </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_OVERALL); ?></h4>
            </td>
            <td id="filler" > </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_OVERALL); ?>"> </td>
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_SERVICE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_SERVICE); ?>"> </td>
            <td id="filler" > </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SERVICE); ?></h4>
            </td>
            <td id="filler" > </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_SERVICE); ?>" > </td>
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_SERVICE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_LOCATION),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_LOCATION); ?>"> </td>
            <td id="filler" > </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_LOCATION); ?></h4>
            </td>
            <td id="filler" > </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_LOCATION); ?>" > </td>
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_LOCATION),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_VALUE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_VALUE); ?>" > </td>
            <td id="filler" > </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_VALUE); ?></h4>
            </td>
            <td id="filler" > </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_VALUE); ?>" > </td>
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_VALUE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_CLEANLINESS),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?>"> </td>
            <td id="filler" > </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?></h4>
            </td>
            <td id="filler" > </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?>"> </td>
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_CLEANLINESS),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_SIZE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorvenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_SIZE); ?>"> </td>
            <td id="filler" > </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SIZE); ?></h4>
            </td>
            <td id="filler" > </td>
            <td id="filler" class="<?= VenueHelper::getCompareColorvenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_SIZE); ?>"> </td>
            <td >
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_SIZE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
    </tbody>
</table>
<div class="row my-5">
    <div class="col-lg-6">
        <h3>Latest <?= $venueOne->name; ?> reviews</h3>
        <?php foreach ($venueOneReviews as $model) {
            echo $this->render('../event/partials/review-venue-view', compact('model'));
        } ?>
    </div>
    <div class="col-lg-6">
        <h3>Latest <?= $venueTwo->name; ?> reviews</h3>
        <?php foreach ($venueTwoReviews as $model) {
            echo $this->render('../event/partials/review-venue-view', compact('model'));
        } ?>
    </div>
</div>