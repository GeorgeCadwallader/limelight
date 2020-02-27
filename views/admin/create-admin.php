<?php

/** @var $this yii\web\View */

use app\helpers\Html;
use yii\bootstrap\ActiveForm;

/** @var $user app\models\User */

$this->title = 'Create new Admin';

?>

<div class="row">
    <div class="col-sm-12">
        <h1>
            <?= $this->title; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-primary" role="alert">
            Enter the new admins username and email, they will
            then be sent a conformation email to set their password
            and will then become an active user on Limelight
        </div>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'id' => 'admin-create-form'
]); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($user, 'username')->textInput(['autoFocus' => true]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($user, 'email')->input('email'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= Html::submitButton('Create', [
                'class' => 'btn btn-primary',
            ]); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>