<?php

/** @var $this yii\web\View */
/** @var $userData app\models\UserData */

use app\helpers\Html;
use app\models\County;
use conquer\select2\Select2Widget;
use dosamigos\datepicker\DatePicker;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = Yii::$app->name.' | Edit '.$userData->user->username;

$counties = ArrayHelper::map(County::find()->all(), 'county_id', 'name');

?>

<div class="container">
    <h1><?= Html::tag('h1', 'Editing '.$userData->user->username); ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'edit-form',
    ]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($userData, 'first_name')->textInput(['autofocus' => true]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($userData, 'last_name')->textInput(); ?>
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
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-primary',
                ]); ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>