<?php

/** @var $this yii\web\View */
/** @var $model app\models\Venue */

use app\helpers\VenueHelper;
use app\models\ReviewVenue;
use kartik\rating\StarRating;

use yii\helpers\Url;

$venue = $model;

$url = VenueHelper::imageUrl($venue);

?>

<a
    href="<?= Url::to(['/venue/view', 'venue_id' => $venue->venue_id]); ?>"
    class="contained-link"
    data-pjax="0"
>
    <div
        class="contained-image limelight-box-shadow"
        style="background-image:url(<?= Url::to($url); ?>)"
    >
        <div class="contained-content">
            <div class="contained-content-inner p-3">
                <div>
                    <h3 class="d-inline-block"><?= $venue->name; ?></h3>
                    <?= VenueHelper::verifiedVenueOwner($venue); ?>
                </div>
                <?= StarRating::widget([
                    'name' => 'contained-venue-'.$venue->venue_id,
                    'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                ]); ?>
                <strong>( <?= ($venue->reviewCount === 1) ? $venue->reviewCount.' review' : $venue->reviewCount.' reviews'; ?> )</strong>
            </div>
        </div>
    </div>
</a>
