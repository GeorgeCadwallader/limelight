<?php

/** @var $this yii\web\View */
/** @var $model app\models\Venue */

use app\helpers\VenueHelper;

use kartik\rating\StarRating;

use yii\helpers\Url;

$venue = $model;

$url = VenueHelper::imageUrl($venue);

?>

<a
    href="<?= Url::to(['/venue/view', 'venue_id' => $venue->venue_id]); ?>"
    class="contained-link"
>
    <div
        class="contained-image"
        style="background-image:url(<?= Url::to($url); ?>)"
    >
        <div class="contained-content">
            <div class="contained-content-inner p-3">
                <h3><?= $venue->name; ?></h3>
                <?= StarRating::widget([
                    'name' => 'contained-venue-'.$venue->venue_id,
                    'value' => VenueHelper::averageOverallRating($venue),
                    'pluginOptions' => [
                        'filledStar' => '<i class="fa fa-star"></i>',
                        'emptyStar' => '<i class="fa fa-star"></i>',
                        'readonly' => true,
                        'showClear' => false,
                        'showCaption' => false,
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</a>
