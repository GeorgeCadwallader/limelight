<?php

use app\helpers\Html;
use app\models\User;
use app\widgets\Alert;
use yii\bootstrap\ActiveForm;

/** @var $this yii\web\View */
/** @var $user app\models\User */
/** @var $registerForm app\models\forms\RegisterForm */

$this->title = 'Register';

?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <?= Alert::widget(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
    ]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($user, 'username')->textInput(['autofocus' => true]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($user, 'email')->input('email'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($registerForm, 'account_type')
                    ->dropDownList(
                        $registerForm::$accountTypes,
                        ['prompt' => '-- Select User Type --']
                    ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= Html::submitButton('Register', [
                    'class' => 'btn btn-primary',
                ]); ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
