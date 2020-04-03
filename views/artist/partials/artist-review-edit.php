<?php

/** @var $review app\models\ReviewArtist */

use app\helpers\Html;

use kartik\rating\StarRating;

use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin([
        'id' => 'edit-review',
        'action' => ['/review/edit-artist', 'review_id' => $review->review_artist_id],
        'options' => ['method' => 'post']
    ]); ?>
    <div class="text-right">
        <?= Html::a(
            'Cancel'.Html::icon('times', ['class' => 'pl-3']),
            '#edit',
            [
                'class' => 'review-edit-btn btn btn-primary',
                'data-review-id' => $review->review_artist_id,
            ]
        ); ?>
    </div>
    <?= $form->field($review, 'content')->textarea(['rows' => 5]); ?>
    <?= $form->field($review, 'overall_rating')->widget(StarRating::class,
        Yii::$app->params['reviewArtistNew']
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
        <?= $form->field($review, 'energy')->widget(StarRating::class,
            Yii::$app->params['reviewArtistNew']
        ); ?>
        <?= $form->field($review, 'vocals')->widget(StarRating::class,
            Yii::$app->params['reviewArtistNew']
        ); ?>
        <?= $form->field($review, 'sound')->widget(StarRating::class,
                Yii::$app->params['reviewArtistNew']
        ); ?>
        <?= $form->field($review, 'stage_presence')->widget(StarRating::class,
            Yii::$app->params['reviewArtistNew']
        ); ?>
        <?= $form->field($review, 'song_aesthetic')->widget(StarRating::class,
            Yii::$app->params['reviewArtistNew']
        ); ?>
    </div>
    <div class="my-4 text-right">
        <?= Html::submitButton('Save Review', ['class' => 'btn btn-primary']); ?>
    </div>
<?php ActiveForm::end(); ?>