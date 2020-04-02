<?php

use app\helpers\VenueHelper;
use app\models\ReviewVenue;

use kartik\rating\StarRating;

use yii\helpers\Inflector;

/** @var $this yii\web\View */
/** @var $venueOne app\models\Venue */
/** @var $venueTwo app\models\Venue */

?>

<table class="table table-responsive-md my-5">
    <tbody>
        <tr class="text-center">
            <td class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_OVERALL); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_OVERALL); ?></h4>
            </td>
            <td class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_OVERALL); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_SERVICE); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_SERVICE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SERVICE); ?></h4>
            </td>
            <td class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_SERVICE); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_SERVICE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_LOCATION); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_LOCATION),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_LOCATION); ?></h4>
            </td>
            <td class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_LOCATION); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_LOCATION),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_VALUE); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_VALUE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_VALUE); ?></h4>
            </td>
            <td class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_VALUE); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_VALUE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= VenueHelper::getCompareColorVenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_CLEANLINESS),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?></h4>
            </td>
            <td class="<?= VenueHelper::getCompareColorVenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_CLEANLINESS),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= VenueHelper::getCompareColorvenueOne($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_SIZE); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueOne->venue_id,
                    'value' => VenueHelper::averageRating($venueOne, ReviewVenue::REVIEW_VENUE_SIZE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SIZE); ?></h4>
            </td>
            <td class="<?= VenueHelper::getCompareColorvenueTwo($venueOne, $venueTwo, ReviewVenue::REVIEW_VENUE_SIZE); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-venue-'.$venueTwo->venue_id,
                    'value' => VenueHelper::averageRating($venueTwo, ReviewVenue::REVIEW_VENUE_SIZE),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
            </td>
        </tr>
    </tbody>
</table>