<?php

/** @var $region app\models\Region */
/** @var $edit bool */

use app\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<h1>
    <?= ($edit) ? 'Edit '.$region->name : 'Create Region'; ?>
</h1>

<?php $form = ActiveForm::begin([
        'id' => 'region-form',
    ]); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($region, 'name')->textInput(['autofocus' => true]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= Html::submitButton(
                ($edit) ? 'Update' : 'Create',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>