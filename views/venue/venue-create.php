<?php

/** @var $this yii\web\View */
/** @var $venue app\models\Venue */

use app\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Create Venue | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Create your venue page</h1>
    </div>
</div>
<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'create-venue'
    ]); ?>
        <div class="col-sm-12">
            <?= $form->field($venue, 'name')->textInput(['autoFocus' => true]); ?>
        </div>
        <div class="col-sm-12">
            <?= Html::submitButton('Create', [
                'class' => 'btn btn-primary'
            ]); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>