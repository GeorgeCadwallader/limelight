<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $emailForm app\models\forms\RequsetEmailResetForm */

use app\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Profile',
                    'url' => Url::to('/profile')
                ],
                ['label' => 'Request email reset']
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1>Request Email Change</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php $form = ActiveForm::begin([
            'id' => 'request-email-form'
        ]); ?>
            <?= $form->field($emailForm, 'email_new'); ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>