<?php

/** @var $this yii\web\View */
/** @var $userData app\models\UserData */

use app\helpers\Html;
use app\models\County;
use app\models\Genre;

use conquer\select2\Select2Widget;
use dosamigos\datepicker\DatePicker;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = Yii::$app->name.' | Edit '.$userData->user->username;

$counties = ArrayHelper::map(County::find()->all(), 'county_id', 'name');

$genres = ArrayHelper::map(Genre::find()->all(), 'genre_id', 'name');

?>

<div class="container">
    <h1><?= Html::tag('h1', 'Editing '.$userData->user->username); ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'edit-form',
    ]); ?>
        <div class="row">
            <?php if ($userData->profile_path !== null) { ?>
                <div class="col-sm-4">
                    <?= Html::img(Yii::$app->request->baseUrl.'/images/user/'.$userData->profile_path, ['class' => 'img-fluid']); ?>
                </div>
                <div class="col-sm-8">
                    <?= $form->field($userData, 'imageFile')->fileInput(); ?>
                </div>
            <?php } else { ?>
                <div class="col-sm-8">
                    <?= $form->field($userData, 'imageFile')->fileInput(); ?>
                </div>
            <?php } ?>
        </div>
        <div class="row my-4">
            <div class="col-sm-6">
                <?= $form->field($userData, 'first_name')->textInput(['autofocus' => true]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($userData, 'last_name')->textInput(); ?>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-sm-12">
                <?= $form->field($userData, 'bio')->widget(TinyMce::class, 
                    Yii::$app->params['richtextOptions']
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
            <?= $form->field($userData, 'date_of_birth')->widget(
                    DatePicker::className(), [
                        'clientOptions' => [
                            'format' => 'yyyy-mm-dd'
                        ]
                ]);?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($userData, 'telephone')->textInput(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($userData, 'county_id')->widget(
                    Select2Widget::className(),
                    ['items' => $counties]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($userData->user, 'genre')->widget(Select2Widget::className(), [
                        'placeholder' => 'Select genres ...',
                        'items' => $genres,
                        'multiple' => true,
                    ]
                )->label('Choose your genres'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-primary',
                ]); ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>