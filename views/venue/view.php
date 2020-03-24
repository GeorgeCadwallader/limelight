<?php

/** @var $this yii\web\View */
/** @var $venue app\models\Venue */
/** @var $newReview app\models\ReviewVenue */

use app\auth\Item;
use app\helpers\Html;
use app\helpers\VenueHelper;
use app\models\ReviewVenue;

use kartik\rating\StarRating;

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$reviews = ReviewVenue::find()->where(['venue_id' => $venue->venue_id])->all();

$hasReviewed = ReviewVenue::find()
    ->where(['venue_id' => $venue->venue_id])
    ->andWhere(['created_by' => Yii::$app->user->id])
    ->exists();

$venueImg = ($venue->data->profile_path) ? Yii::$app->request->baseUrl.'/images/venue/'.$venue->data->profile_path : '/images/venue-placeholder.png';

$this->title = $venue->name.' | '.Yii::$app->name;

?>

<div class="row mb-3">
    <div class="col-sm-12">
        <h1>
            <?= $venue->name; ?>
        </h1>
        <?php if (VenueHelper::canEdit($venue)) { ?>
            <?= Html::a(
                'Edit '.$venue->name,
                ['/venue/edit', 'venue_id' => $venue->venue_id],
                ['class' => 'btn btn-primary view-edit-button']
            ); ?>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Venues',
                    'url' => Url::to('/venue')
                ],
                [
                    'label' => 'View Venue: '.$venue->name
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row bg-white p-3">
    <div class="col-sm-4">
        <?= Html::img($venueImg, ['class' => 'img-fluid']); ?>
        <h1 class="my-2"><?= $venue->name; ?></h1>
        <?= StarRating::widget([
            'name' => 'review-venue-'.$venue->venue_id,
            'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_OVERALL),
            'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
        ]); ?>
        <?= $this->render('criteria', compact('venue')); ?>
    </div>
    <div class="col-sm-8">
        <ul class="list-group">
            <h4>Genres</h4>
            <?php foreach ($venue->genre as $genre) { ?>
                <li class="list-group-item">
                    <strong><?= $genre->name; ?></strong>
                </li>
            <?php } ?>
        </ul>
        <p><?= ($venue->data->description) ?? Html::encode($venue->data->description); ?></p>
    </div>
</div>
<div class="row my-4">
    <?php foreach ($reviews as $review) { ?>
        <?= $this->render('venue-review-single', compact('review')); ?>
    <?php } ?>
</div>
<div class="row">
    <?php if (Yii::$app->user->can(Item::ROLE_MEMBER) && !$hasReviewed) { ?>
        <?= $this->render('venue-create-review', compact('newReview')); ?>
    <?php } ?>
</div>
