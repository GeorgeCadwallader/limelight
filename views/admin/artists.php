<?php

use app\helpers\Html;
use app\models\Artist;
use app\models\User;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\Dropdown;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $artistFilterModel app\models\search\ArtistSearch */
/** @var $artistDataProvider yii\data\ActiveDataProvider */

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
                    'label' => 'Artists'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-8">
        <h1 class="font-weight-bold">Artist Management</h1>
    </div>
    <div class="col-sm-4 text-sm-right">
        <?= Html::a(
            'Create new Artist',
            '/admin/add-artist',
            ['class' => 'btn btn-primary']
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
            'pager' => Yii::$app->params['paginationConfig'],
            'dataProvider' => $artistDataProvider,
            'filterModel' => $artistFilterModel,
            'columns' => [
                [
                    'attribute' => 'name',
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => Artist::$statuses,
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
                                        '/artist/view',
                                        'artist_id' => $model->artist_id
                                    ]
                                ],
                                [
                                    'label' => 'Edit',
                                    'url' => [
                                        '/artist/edit',
                                        'artist_id' => $model->artist_id
                                    ]
                                ],
                                [
                                    'label' => 'Set status: Active',
                                    'url' => [
                                        '/admin/set-artist-status',
                                        'artist_id' => $model->artist_id,
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
                                        '/admin/set-artist-status',
                                        'artist_id' => $model->artist_id,
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
                                        '/admin/set-artist-status',
                                        'artist_id' => $model->artist_id,
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