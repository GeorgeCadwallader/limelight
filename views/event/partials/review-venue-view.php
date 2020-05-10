<?php

use app\helpers\Html;
use app\helpers\UserDataHelper;

use kartik\rating\StarRating;

/** @var $this yii\web\View */
/** @var $model app\models\ReviewVenue */

$review = $model;

$date = Yii::$app->formatter->asDate($review->created_at, 'php:d/m/Y');

?>

<div class="col-md-12 review-single-container py-3 my-4">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-9">
                    <h3><?= Html::a($review->creator->username, ['/profile/view', 'user_id' => $review->creator->user_id]); ?></h3>
                </div>
                <div class="col-sm-3">
                    <strong>
                        <?= $date; ?>
                    </strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    <?= StarRating::widget([
                        'name' => 'review-'.$review->venue->venue_id.'-'.$review->creator->user_id,
                        'value' => $review->overall_rating,
                        'pluginOptions' => Yii::$app->params['reviewVenueDisplay'],
                    ]); ?>
                    <?= Html::img(UserDataHelper::imageUrl($review->creator->userData), ['class' => 'img-fluid my-3', 'style' => ['max-width' => '50%']]); ?>
                </div>
                <div class="col-md-6 col-lg-7 px-md-4">
                    <?= Html::tag('div', $review->content, ['class' => 'my-4 review-text-content']); ?>
                    <?= Html::button('Read More ...', ['class' => 'btn btn-sm btn-primary read-more-btn']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
