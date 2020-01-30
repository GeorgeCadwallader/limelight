<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\ResetPasswordForm */

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-login row align-items-center full-height justify-content-center">
    <div class="col-sm-5 panel pl-7">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Alert::widget(); ?>
        <p>Set your new password.</p>
        <p>
            This will be the password you will use to access your account.
            Once you set your new password your account will be activated, and you can log in.
        </p>
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]); ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(); ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
