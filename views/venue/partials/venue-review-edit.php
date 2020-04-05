<?php

use app\helpers\Html;
use kartik\rating\StarRating;
use yii\bootstrap4\ActiveForm;

$form = ActiveForm::begin([
        'id' => 'edit-review',
        'action' => ['/review/edit-venue', 'review_id' => $review->review_venue_id],
        'options' => ['method' => 'post']
    ]); ?>
    <div class="text-right">
        <?= Html::a(
            'Cancel'.Html::icon('times', ['class' => 'pl-3']),
            '#edit',
            [
                'class' => 'review-edit-btn btn btn-primary',
                'data-review-id' => $review->review_venue_id
            ]
        ); ?>
    </div>
    <?= $form->field($review, 'content')->textarea(['rows' => 5]); ?>
    <?= $form->field($review, 'overall_rating')->widget(StarRating::class,
        Yii::$app->params['reviewVenueNew']
    ); ?>
    <div class="text-left">
        <button
            class="btn btn-primary review-advanced-button my-4"
            type="button"
            data-toggle="collapse"
            data-target="#review-advanced-button"
            aria-expanded="false"
            aria-controls="review-advanced-button"
        >
            Advanced
        </button>
    </div>
    <div class="collapse" id="review-advanced-button">
        <?= $form->field($review, 'service')->widget(StarRating::class,
            Yii::$app->params['reviewVenueNew']
        ); ?>
        <?= $form->field($review, 'location')->widget(StarRating::class,
            Yii::$app->params['reviewVenueNew']
        ); ?>
        <?= $form->field($review, 'value')->widget(StarRating::class,
                Yii::$app->params['reviewVenueNew']
        ); ?>
        <?= $form->field($review, 'cleanliness')->widget(StarRating::class,
            Yii::$app->params['reviewVenueNew']
        ); ?>
        <?= $form->field($review, 'size')->widget(StarRating::class,
            Yii::$app->params['reviewVenueNew']
        ); ?>
    </div>
    <div class="my-4 text-right">
        <?= Html::submitButton('Save Review', ['class' => 'btn btn-primary']); ?>
    </div>
<?php ActiveForm::end(); ?>