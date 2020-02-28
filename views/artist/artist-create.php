<?php

/** @var $this yii\web\View */
/** @var $artist app\models\Artist */

use app\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Create Artist | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Create your artist page</h1>
    </div>
</div>
<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'create-artist'
    ]); ?>
        <div class="col-sm-12">
            <?= $form->field($artist, 'name')->textInput(['autoFocus' => true]); ?>
        </div>
        <div class="col-sm-12">
            <?= Html::submitButton('Create', [
                'class' => 'btn btn-primary'
            ]); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>