<?php

/** @var $this yii\web\View */
/** @var $venue app\models\search\Venue */

use app\helpers\Html;

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Create Venue</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Admin Dashboard',
                    'url' => Url::to('/admin'),
                ],
                [
                    'label' => 'Venue Management',
                    'url' => Url::to('/admin/venue')
                ],
                [
                    'label' => 'Create Venue'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'create-venue'
    ]); ?>
        <div class="col-sm-12">
            <?= $form->field($venue, 'name'); ?>
        </div>
        <div class="col-sm-12">
            <?= Html::submitButton(
                'Create',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
