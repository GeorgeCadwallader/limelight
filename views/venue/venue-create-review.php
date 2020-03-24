<?php

/** @var $newReview app\models\VenueReview */

use app\helpers\Html;

use kartik\rating\StarRating;

use yii\bootstrap4\ActiveForm;

?>

<div class="card card-body">
    <h2 class="text-primary mb-0">Create your review</h2>
    <div class="alert alert-primary alert-dismissible fade show my-4">
        We at <?= Yii::$app->name; ?> want to know what you think of this venue.
        <br><br>
        Leave a basic review by adding a paragraph about what you thought and leave
        your overall rating by leaving between 0 and 5 stars.
        <br><br>
        If you want to leave a bigger review, click the advanced button and you will
        be able to pinpoint your review into subcategories. Filling in this section will
        provide us with the ability to provide more information to our members about our
        Artists and Venues.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'create-review',
    ]); ?>
        <?= $form->field($newReview, 'content')->textarea(['rows' => 5]); ?>
        <?= $form->field($newReview, 'overall_rating')->widget(StarRating::class,
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
            <?= $form->field($newReview, 'service')->widget(StarRating::class,
                Yii::$app->params['reviewVenueNew']
            ); ?>
            <?= $form->field($newReview, 'location')->widget(StarRating::class,
                Yii::$app->params['reviewVenueNew']
            ); ?>
            <?= $form->field($newReview, 'value')->widget(StarRating::class,
                    Yii::$app->params['reviewVenueNew']
            ); ?>
            <?= $form->field($newReview, 'cleanliness')->widget(StarRating::class,
                Yii::$app->params['reviewVenueNew']
            ); ?>
            <?= $form->field($newReview, 'size')->widget(StarRating::class,
                Yii::$app->params['reviewVenueNew']
            ); ?>
        </div>
        <div class="my-4 text-right">
            <?= Html::submitButton('Save Review', ['class' => 'btn btn-primary']); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
