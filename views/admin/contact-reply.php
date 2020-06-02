<?php

/** @var $this yii\web\View */
/** @var $contactMessage app\models\Contact */
/** @var $contactReply app\models\ContactReply */

use app\helpers\Html;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

$this->title = 'Contact Reply | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Admin Dashboard',
                    'url' => Url::to('/admin'),
                ],
                [
                    'label' => 'Contact Reply'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Contact Reply - <?= $contactMessage->first_name.' '.$contactMessage->last_name; ?></h1>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h2>Message Details</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <strong class="mr-2">First Name: </strong>
                <?= Html::tag('span', $contactMessage->first_name); ?>
            </li>
            <li class="list-group-item">
                <strong class="mr-2">Last Name: </strong>
                <?= Html::tag('span', $contactMessage->last_name); ?>
            </li>
            <li class="list-group-item">
                <strong class="mr-2">Email: </strong>
                <?= Html::tag('span', $contactMessage->email); ?>
            </li>
            <li class="list-group-item">
                <strong class="mr-2">Message: </strong>
                <?= Html::tag('span', $contactMessage->message); ?>
            </li>
        </ul>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h2>Reply</h2>
        <?php $form = ActiveForm::begin([
            'id' => 'contact-reply-form'
        ]); ?>
            <?= $form->field($contactReply, 'message')->widget(TinyMce::class,
                Yii::$app->params['richtextOptions']
            )->label(false); ?>
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>