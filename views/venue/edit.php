<?php

use app\helpers\Html;
use app\models\Venue;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $venue app\models\venue */
/** @var $venueData app\models\VenueData */

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'View: '.$venue->name,
                    'url' => Url::to(['/venue/view', 'venue_id' => $venue->venue_id])
                ],
                ['label' => 'Edit: '.$venue->name]
            ]
        ]); ?>
    </div>
    <div class="col-sm-12">
        <h1>Edit <?= $venue->name; ?></h1>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <?php if ($venue->status === Venue::STATUS_UNVERIFIED) { ?>
            <div class="alert alert-warning" role="alert">
                <strong>Warning:</strong> Your venue page is still being reviewed by admins,
                it will not be viewable to anyone on the site untill it becomes activated.
                You can still edit the information of your venue page below.
            </div>
        <?php } elseif ($venue->status === Venue::STATUS_ACTIVE) { ?>
            <div class="alert alert-success" role="alert">
                Your venue page is currently active, this means it will be shown to
                everyone who accesses <?= Yii::$app->name; ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php $form = ActiveForm::begin([
            'id' => 'venue-edit-form'
            ]); ?>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($venueData, 'description')->textarea(); ?>
                </div>
                <div class="row my-3">
                    <?php if ($venueData->profile_path !== null) { ?>
                        <div class="col-sm-4">
                            <?= Html::img(Yii::$app->request->baseUrl.'/images/venue/'.$venueData->profile_path, ['class' => 'img-fluid']); ?>
                        </div>
                        <div class="col-sm-8">
                            <?= $form->field($venueData, 'imageFile')->fileInput(); ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-sm-8">
                            <?= $form->field($venueData, 'imageFile')->fileInput(); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-sm-12 my-3">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
