<?php

/** @var $this yii\web\View */
/** @var $artistRequest app\models\OwnerRequest */

use app\helpers\Html;
use app\models\Artist;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Request Artist Ownership | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>
            Request artist page ownership
        </h1>
    </div>
</div>
<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'request-artist'
    ]); ?>
        <div class="col-sm-12">
            <?= $form->field($artistRequest, 'fk')->dropDownList(
                ArrayHelper::map(
                    Artist::find()->where(['managed_by' => null])->all(),
                    'artist_id',
                    'name'
                ),
                ['prompt' => '-- Select Artist --']
            ); ?>
        </div>
        <div class="col-sm-12">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
