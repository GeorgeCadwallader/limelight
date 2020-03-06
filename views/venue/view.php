<?php

/** @var $this yii\web\View */
/** @var $venue app\models\Venue */
/** @var $newReview app\models\ReviewVenue */

use app\auth\Item;
use app\helpers\Html;
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

$this->title = $venue->name.' | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>
            <?= $venue->name; ?>
        </h1>
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
<div class="row my-4">
    <?php foreach ($reviews as $review) { ?>
        <?= $this->render('venue-review-single', compact('review')); ?>
    <?php } ?>
</div>
<div class="row">
    <?php if (Yii::$app->user->can(Item::ROLE_MEMBER) && !$hasReviewed) { ?>
        <div class="col-sm-12">
            <div class="card card-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'create-review',
                ]); ?>
                    <?= $form->field($newReview, 'content')->textarea(); ?>
                    <?= $form->field($newReview, 'overall_rating')->widget(StarRating::class, [
                        'pluginOptions' => [
                            'filledStar' => '<i class="fa fa-star"></i>',
                            'emptyStar' => '<i class="fa fa-star"></i>',
                            'min' => 0,
                            'max' => 5,
                            'step' => 0.5,
                            'showCaption' => false,
                        ]
                    ]); ?>
                    <?= Html::submitButton('Save Review', ['class' => 'btn btn-primary']); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php } ?>
</div>
