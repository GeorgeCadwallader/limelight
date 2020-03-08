<?php

use app\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $requestForm app\models\forms\RequsetPasswordResetForm */

$this->title = 'Request Password Reset | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Login',
                    'url' => Url::to('/site/login')
                ],
                [
                    'label' => 'Request Password Reset'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1>Request password reset</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php $form = ActiveForm::begin([
            'id' => 'request-password-reset'
        ]); ?>

        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($requestForm, 'email')->textInput(['autofocus' => true]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
