<?php

/** @var $this yii\web\View */
/** @var $venueRequest app\models\OwnerRequest */

use app\helpers\Html;
use app\models\Venue;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Request Venue Ownership | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>
            Request venue page ownership
        </h1>
    </div>
</div>
<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'request-venue'
    ]); ?>
        <div class="col-sm-12">
            <?= $form->field($venueRequest, 'fk')->dropDownList(
                ArrayHelper::map(
                    Venue::find()->where(['managed_by' => null])->all(),
                    'venue_id',
                    'name'
                ),
                ['prompt' => '-- Select Venue --']
            ); ?>
        </div>
        <div class="col-sm-12">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
