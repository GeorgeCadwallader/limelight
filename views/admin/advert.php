<?php

use app\helpers\Html;
use app\models\Advert;
use app\models\Genre;
use app\models\Region;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Dropdown;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $advertFilterModel app\models\search\AdvertSearch */
/** @var $advertDataProvider yii\data\ActiveDataProvider */

$this->title = 'Advert Management | '.Yii::$app->name;

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
                    'label' => 'Advert Management'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Advert Management</h1>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?= GridView::widget([
            'pager' => Yii::$app->params['paginationConfig'],
            'dataProvider' => $advertDataProvider,
            'filterModel' => $advertFilterModel,
            'columns' => [
                'advert_id',
                [
                    'attribute' => 'fk',
                    'label' => 'Name',
                    'value' => function ($model) {
                        if ($model->type === $model::TYPE_ARTIST) {
                            return $model->artist->name;
                        }
                        
                        return $model->venue->name;
                    }
                ],
                [
                    'attribute' => 'message',
                    'filterInputOptions' => ['class' => 'form-control'],
                ],
                [
                    'attribute' => 'appearances'
                ],
                [
                    'attribute' => 'type',
                    'format' => 'raw',
                    'filter' => Advert::$types,
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
                    'attribute' => 'advert_type',
                    'filter' => Advert::$advertTypes,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by advert type'
                    ],
                    'value' => function ($model) {
                        return Advert::$advertTypes[$model->advert_type];
                    }
                ],
                [
                    'attribute' => 'region_id',
                    'label' => 'Region',
                    'filter' => ArrayHelper::map(Region::find()->all(), 'region_id', 'name'),
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by advert type'
                    ],
                    'value' => function ($model) {
                        if ($model->region) {
                            return $model->region->name;
                        }

                        return 'N/A';
                    }
                ],
                [
                    'attribute' => 'genre_id',
                    'label' => 'Genre',
                    'filter' => ArrayHelper::map(Genre::find()->all(), 'genre_id', 'name'),
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by advert type'
                    ],
                    'value' => function ($model) {
                        if ($model->genre) {
                            return $model->genre->name;
                        }

                        return 'N/A';
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => Advert::$statuses,
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

                        return Html::tag(
                            'span',
                            $status,
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
                                    'label' => 'Activate advert',
                                    'url' => [
                                        '/admin/change-advert-status',
                                        'status' => Advert::STATUS_ACTIVE,
                                        'advert_id' => $model->advert_id
                                    ]
                                ],
                                [
                                    'label' => 'Deactivate advert',
                                    'url' => [
                                        '/admin/change-advert-status',
                                        'status' => Advert::STATUS_INACTIVE,
                                        'advert_id' => $model->advert_id
                                    ]
                                ]
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