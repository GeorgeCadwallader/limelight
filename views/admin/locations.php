<?php

use app\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap4\Breadcrumbs;

/** @var $this yii\web\View */
/** @var $regionFilterModel app\models\search\RegionSearch */
/** @var $regionDataProvider yii\data\ActiveDataProvider */
/** @var $countyFilterModel app\models\search\CountySearch */
/** @var $countyDataProvider yii\data\ActiveDataProvider */

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
                    'label' => 'Locations'
                ]
            ]
        ]); ?>
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
            'pager' => Yii::$app->params['paginationConfig'],
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
            'pager' => Yii::$app->params['paginationConfig'],
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
