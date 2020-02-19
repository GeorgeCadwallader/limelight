<?php

/** @var $this yii\web\View */

use app\helpers\Html;
use app\models\County;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;

/** @var $userData app\models\UserData */

$this->title = Yii::$app->name.' | Edit '.$userData->user->username;

$counties = County::find()
    ->select(['county_id', 'name'])
    ->all();

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
                <?= $form->field($userData, 'date_of_birth')
                    ->widget(
                        DatePicker::class,
                        ['pluginOptions' => [
                            'format' => 'mm/dd/yyyy',
                            'hoursDisabled' => true,
                            'minutesDisabled' => true,
                        ]]
                    ); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($userData, 'telephone')->textInput(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php //$form->field($userData, 'county_id')->dropDownList($counties); ?>
                <?= 'county'; ?>
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