<?php

/** @var $this yii\web\View */
/** @var $artist app\models\search\Artist */

use app\helpers\Html;

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Create Artist</h1>
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
                    'label' => 'Artists Management',
                    'url' => Url::to('/admin/artist')
                ],
                [
                    'label' => 'Create Artist'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'create-artist'
    ]); ?>
        <div class="col-sm-12">
            <?= $form->field($artist, 'name'); ?>
        </div>
        <div class="col-sm-12">
            <?= Html::submitButton(
                'Create',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
