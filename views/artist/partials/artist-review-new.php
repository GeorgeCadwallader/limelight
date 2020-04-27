<?php

/** @var $newReview app\models\ReviewArtist */

use app\helpers\Html;
use dosamigos\tinymce\TinyMce;
use kartik\rating\StarRating;

use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin([
        'id' => 'create-review',
    ]); ?>
    <?= $form->field($newReview, 'content')->widget(TinyMce::class, 
        Yii::$app->params['richtextOptions']
    ); ?>
    <?= $form->field($newReview, 'overall_rating')->widget(StarRating::class,
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
        <?= $form->field($newReview, 'energy')->widget(StarRating::class,
            Yii::$app->params['reviewArtistNew']
        ); ?>
        <?= $form->field($newReview, 'vocals')->widget(StarRating::class,
            Yii::$app->params['reviewArtistNew']
        ); ?>
        <?= $form->field($newReview, 'sound')->widget(StarRating::class,
                Yii::$app->params['reviewArtistNew']
        ); ?>
        <?= $form->field($newReview, 'stage_presence')->widget(StarRating::class,
            Yii::$app->params['reviewArtistNew']
        ); ?>
        <?= $form->field($newReview, 'song_aesthetic')->widget(StarRating::class,
            Yii::$app->params['reviewArtistNew']
        ); ?>
    </div>
    <div class="my-4 text-right">
        <?= Html::submitButton('Create Review', ['class' => 'btn btn-primary']); ?>
    </div>
<?php ActiveForm::end(); ?>