<?php

/** @var $this yii\web\View */
/** @var $contactForm app\models\Contact */

use app\helpers\Html;

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Breadcrumbs;

$this->title = 'Contact Us | '.Yii::$app->name;

?>
<div class="row">
    <?= Breadcrumbs::widget([
        'links' => [
            ['label' => 'Contact Us']
        ]
    ]); ?>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1>Contact Us</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
        ]); ?>
            <?= $form->field($contactForm, 'first_name')->textInput(['autoFocus' => true]); ?>
            <?= $form->field($contactForm, 'last_name')->textInput(); ?>
            <?= $form->field($contactForm, 'email')->input('email'); ?>
            <?= $form->field($contactForm, 'message')->textarea(); ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
