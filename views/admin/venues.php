<?php

use app\helpers\Html;
use app\models\User;
use app\models\Venue;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\Dropdown;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $venueFilterModel app\models\search\VenueSearch */
/** @var $venueDataProvider yii\data\ActiveDataProvider */

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
                    'label' => 'Venues'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-8">
        <h1>Venue Management</h1>
    </div>
    <div class="col-sm-4 text-sm-right">
        <?= Html::a(
            'Create new Venue',
            '/admin/add-venue',
            ['class' => 'btn btn-primary']
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
            'dataProvider' => $venueDataProvider,
            'filterModel' => $venueFilterModel,
            'columns' => [
                [
                    'attribute' => 'name',
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => Venue::$statuses,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by status...'
                    ],
                    'value' => function ($model) {
                        $status = ArrayHelper::getValue($model::$statuses, $model->status);

                        if ($model->status === $model::STATUS_ACTIVE) {
                            return Html::tag(
                                'span',
                                $status,
                                ['class' => 'text-success font-weight-bold']
                            );
                        }

                        if ($model->status === $model::STATUS_UNVERIFIED) {
                            return Html::tag(
                                'span',
                                $status,
                                ['class' => 'text-warning font-weight-bold']
                            );
                        }

                        return Html::tag(
                            'span',
                            $status,
                            ['class' => 'text-danger font-weight-bold']
                        );
                    }
                ],
                [
                    'attribute' => 'managed_by',
                    'label' => 'Owner',
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'placeholder' => 'Search by owner...'
                    ],
                    'value' => function ($model) {
                        $manager = User::findOne($model->managed_by);

                        if ($manager === null) {
                            return;
                        }

                        return $manager->username.' ('.$manager->email.')';
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
                                    'label' => 'View',
                                    'url' => [
                                        '/venue/view',
                                        'venue_id' => $model->venue_id
                                    ]
                                ],
                                [
                                    'label' => 'Edit',
                                    'url' => [
                                        '/venue/edit',
                                        'venue_id' => $model->venue_id
                                    ]
                                ],
                                [
                                    'label' => 'Set status: Active',
                                    'url' => [
                                        '/admin/set-venue-status',
                                        'venue_id' => $model->venue_id,
                                        'status' => $model::STATUS_ACTIVE
                                    ],
                                    'linkOptions' => [
                                        'data' => [
                                            'method' => 'POST'
                                        ],
                                    ],
                                ],
                                [
                                    'label' => 'Set status: Unverified',
                                    'url' => [
                                        '/admin/set-venue-status',
                                        'venue_id' => $model->venue_id,
                                        'status' => $model::STATUS_UNVERIFIED
                                    ],
                                    'linkOptions' => [
                                        'data' => [
                                            'method' => 'POST'
                                        ],
                                    ],
                                ],
                                [
                                    'label' => 'Set status: Deactivated',
                                    'url' => [
                                        '/admin/set-venue-status',
                                        'venue_id' => $model->venue_id,
                                        'status' => $model::STATUS_DEACTIVATED
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
            ],
        ]); ?>
    </div>
</div>