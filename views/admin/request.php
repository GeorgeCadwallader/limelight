<?php

use app\helpers\Html;
use app\models\Artist;
use app\models\OwnerRequest;
use app\models\Venue;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\Dropdown;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $requestFilterModel app\models\search\RequestSearch */
/** @var $requestDataProvider yii\data\ActiveDataProvider */

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Admin Dashboard',
                    'url' => Url::to('/admin'),
                ],
                ['label' => 'Ownership Requests']
            ],
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Ownership Requests</h1>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?= GridView::widget([
            'dataProvider' => $requestDataProvider,
            'filterModel' => $requestFilterModel,
            'columns' => [
                'owner_request_id',
                [
                    'attribute' => 'fk',
                    'value' => function ($model) {
                        if ($model->type === $model::TYPE_ARTIST) {
                            $artist = Artist::find()
                                ->where(['artist_id' => $model->fk])
                                ->one();

                            return $artist->name;
                        }

                        $venue = Venue::find()
                            ->where(['venue_id' => $model->fk])
                            ->one();

                        return $venue->name;
                    }
                ],
                [
                    'attribute' => 'type',
                    'format' => 'raw',
                    'filter' => OwnerRequest::$types,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by type...'
                    ],
                    'value' => function ($model) {
                        $type = ArrayHelper::getValue($model::$types, $model->type);

                        if ($model->type === $model::TYPE_ARTIST) {
                            return Html::tag(
                                'span',
                                $type,
                                ['class' => 'text-success font-weight-bold']
                            );
                        }

                        return Html::tag(
                            'span',
                            $type,
                            ['class' => 'text-warning font-weight-bold']
                        );
                    }
                ],
                [
                    'class' => ActionColumn::class,
                    'header' => 'Edit',
                    'template' => '{menu}',
                    'buttons' => [
                        'menu' => function ($url, $model, $index): string {
                            $items = [
                                [
                                    'label' => 'Approve request',
                                    'url' => [
                                        '/admin/request-approve',
                                        'owner_request_id' => $model->owner_request_id
                                    ],
                                    'linkOptions' => [
                                        'data' => [
                                            'method' => 'POST'
                                        ],
                                    ],
                                ],
                            ];

                            return Html::button(
                                Html::icon('ellipsis-h', ['class' => 'text-white']),
                                [
                                    'data-toggle' => 'dropdown',
                                    'class' => 'btn btn-primary'
                                ]
                            ).Dropdown::widget([
                                'items' => $items
                            ]);
                        }
                    ]
                ]
            ]
        ]); ?>
    </div>
</div>
