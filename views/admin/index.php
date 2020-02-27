<?php

use app\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var $this yii\web\View */
/** @var $regionFilterModel app\models\search\RegionSearch */
/** @var $regionDataProvider yii\data\ActiveDataProvider */
/** @var $countyFilterModel app\models\search\CountySearch */
/** @var $countyDataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.' | Admin panel';

?>

<div class="row mb-4">
    <div class="col-sm-12">
        <h1>Admin panel</h1>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?= Html::a(
            'Create new Admin',
            '/admin/admin-create',
            ['class' => 'btn btn-primary']
        ); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-8">
        <h2>Regions</h2>
    </div>
    <div class="col-sm-4 text-sm-right">
        <?= Html::a(
            'Create new Region',
            '/admin/add-region',
            ['class' => 'btn btn-primary']
        ); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?= GridView::widget([
            'dataProvider' => $regionDataProvider,
            'filterModel' => $regionFilterModel,
            'columns' => [
                ['attribute' => 'name'],
                [
                    'class' => ActionColumn::class,
                    'header' => 'Edit',
                    'template' => '{menu}',
                    'buttons' => [
                        'menu' => function ($url, $model, $index): string {
                            return Html::a(
                                Html::icon('pencil'),
                                [
                                    '/admin/edit-region',
                                    'region_id' => $model->region_id
                                ],
                                ['class' => 'btn btn-primary']
                            );
                        }
                    ]
                ]
            ],
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <h2>Counties</h2>
    </div>
    <div class="col-sm-4 text-sm-right">
        <?= Html::a(
            'Create new County',
            '/admin/add-county',
            ['class' => 'btn btn-primary']
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
            'dataProvider' => $countyDataProvider,
            'filterModel' => $countyFilterModel,
            'columns' => [
                ['attribute' => 'name'],
                [
                    'label' => 'Region',
                    'value' => function ($model) {
                        return $model->region->name;
                    }
                ],
                [
                    'class' => ActionColumn::class,
                    'header' => 'Edit',
                    'template' => '{menu}',
                    'buttons' => [
                        'menu' => function ($url, $model, $index): string {
                            return Html::a(
                                Html::icon('pencil'),
                                [
                                    '/admin/edit-county',
                                    'county_id' => $model->county_id
                                ],
                                ['class' => 'btn btn-primary']
                            );
                        }
                    ]
                ]
            ],
        ]); ?>
    </div>
</div>
