<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login | '.Yii::$app->name;
?>
<div class="site-login">
    <?= Breadcrumbs::widget([
        'links' => [
            [
                'label' => 'Login',
            ]
        ]
    ]); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]); ?>

        <?= $form->field($model, 'password')->passwordInput(); ?>

        <div class="form-group">
            <div class="col-lg-12 my-3">
                <?= Html::a('Forgotten your password?', '/site/request-password-reset'); ?>
            </div>
            <div class="col-lg-12">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
