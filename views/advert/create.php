<?php

/** @var $this yii\web\View */
/** @var $advert app\models\Advert */

use app\helpers\Html;
use app\models\Advert;
use app\models\Genre;
use app\models\Region;

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Create Advert | '.Yii::$app->name;

$regions = ArrayHelper::map(Region::find()->all(), 'region_id', 'name');
$genres = ArrayHelper::map(Genre::find()->all(), 'genre_id', 'name');

?>

<div class="row mb-3">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Advert Dashboard',
                    'url' => Url::to('/advert')
                ],
                [
                    'label' => 'Create Advert',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Create Advert</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-primary" role="alert">
            You have chosen to create an advert of the type <strong><?= Advert::$advertTypes[$advert->advert_type]; ?></strong>
            <br><br>
            If this is not correct, please click <a href="/advert">here</a> to choose another advert type.
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <?php $form = ActiveForm::begin([
            'id' => 'advert-payment-form',
            'options' => [
                'class' => 'form-tooltip',
            ],
            'fieldConfig' => [
                'template' => "{label}{hint}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}",
            ]
        ]); ?>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($advert, 'message')->textarea()
                        ->hint(Html::infoHint('The message that will be displayed on your advert. Leave blank to use your artist or venue name')); ?>
                </div>
            </div>
            <?php if ($advert->advert_type !== Advert::ADVERT_TYPE_GLOBAL) { ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?php if ($advert->advert_type === Advert::ADVERT_TYPE_GENRE) {
                            echo $form->field($advert, 'genre_id')->dropDownList($genres);
                        } elseif ($advert->advert_type === Advert::ADVERT_TYPE_LOCATION) {
                            echo $form->field($advert, 'region_id')->dropDownList($regions);
                        } ?>  
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-primary" role="alert">
                        Because <?= Yii::$app->name; ?> is currently in a beta phase we currently do not take real payments, therefore
                        our PayPal is currently on 'Sandbox' mode which means specific test credentials are required to make this payment.
                        <br><br>
                        To gain access to the sandbox credentials in order to create an advert please get in contact with our admins via the form on
                        <a href="/contact">this page</a> and specify the subject of 'ADVERT REQUEST' at the top of your message. We will get back to you
                        as soon as we can.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= Html::submitButton('Create Advert', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>