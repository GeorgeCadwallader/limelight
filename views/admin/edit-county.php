<?php

/** @var $county app\models\County */
/** @var $edit bool */

use app\helpers\Html;
use app\models\Region;

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$regions = ArrayHelper::map(Region::find()->all(), 'region_id', 'name');

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
                    'label' => 'Locations page',
                    'url' => Url::to('/admin/locations')
                ],
                [
                    'label' => 'Create County',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1>
            <?= ($edit) ? 'Edit '.$county->name : 'Create County'; ?>
        </h1>
    </div>
</div>
<?php $form = ActiveForm::begin([
        'id' => 'county-form',
    ]); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($county, 'name')->textInput(['autofocus' => true]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($county, 'region_id')->dropDownList($regions, ['prompt' => '-- Select Region --']); ?>
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
