<?php

/** @var $this yii\web\View */
/** @var $artist app\models\Artist */
/** @var $newReview app\models\ReviewArtist */

use app\auth\Item;
use app\helpers\Html;
use app\models\ReviewArtist;
use kartik\rating\StarRating;
use yii\bootstrap\ActiveForm;

$reviews = ReviewArtist::find()->where(['artist_id' => $artist->artist_id])->all();

$hasReviewed = ReviewArtist::find()
    ->where(['artist_id' => $artist->artist_id])
    ->andWhere(['created_by' => Yii::$app->user->id])
    ->exists();

$this->title = $artist->name.' | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>
            <?= $artist->name; ?>
        </h1>
    </div>
</div>
<div class="row my-4">
    <?php foreach ($reviews as $review) { ?>
        <?= $this->render('artist-review-single', compact('review')); ?>
    <?php } ?>
</div>
<div class="row">
    <?php if (Yii::$app->user->can(Item::ROLE_MEMBER) && !$hasReviewed) { ?>
        <div class="col-sm-12">
            <?= Html::a(
                'Leave Review',
                '#leaveReview',
                [
                    'class' => 'btn btn-primary',
                    'data-toggle' => 'collapse',
                ]
            ); ?>
            <div class="collapse" id="leaveReview">
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
        </div>
    <?php } ?>
</div>
