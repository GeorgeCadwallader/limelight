<?php

/** @var $this yii\web\View */
/** @var $event app\models\Event */

use app\helpers\Html;
use app\models\Artist;
use app\models\Venue;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Create Event | '.Yii::$app->name;

$artists = ArrayHelper::map(
    Artist::find()->where(['status' => Artist::STATUS_ACTIVE])->all(),
    'artist_id',
    'name'
);

$venues = ArrayHelper::map(
    Venue::find()->where(['status' => Venue::STATUS_ACTIVE])->all(),
    'venue_id',
    'name'
);

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Create Event</h1>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'id' => 'create-event'
]); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($event, 'artist_id')->dropDownList($artists, ['prompt' => '-- Select Artist --']); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($event, 'venue_id')->dropDownList($venues, ['prompt' => '-- Select Venue --']); ?>
        </div>
        <div class="col-sm-12">
            <?= Html::submitButton('Create', [
                'class' => 'btn btn-primary'
            ]); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>