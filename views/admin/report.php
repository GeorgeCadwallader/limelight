<?php

/** @var $this yii\web\View */
/** @var $reportFilterModel app\models\search\ReportSearch */
/** @var $reportDataProvider yii\data\ActiveDataProvider */

use app\helpers\Html;
use app\models\Artist;
use app\models\ReviewReport;
use app\models\ReviewTone;
use app\models\Venue;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\Dropdown;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Manage Review Reports | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Admin Dashboard',
                    'url' => Url::to('/admin'),
                ],
                ['label' => 'Manage Review Reports']
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Review Reports</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
            'pager' => Yii::$app->params['paginationConfig'],
            'dataProvider' => $reportDataProvider,
            'filterModel' => $reportFilterModel,
            'columns' => [
                [
                    'attribute' => 'Venue/Artist name',
                    'value' => function ($model) {
                        if ($model->type === ReviewReport::TYPE_ARTIST) {
                            $context = Artist::findOne($model->fk);
                        } else {
                            $context = Venue::findOne($model->fk);
                        }

                        return $context->name;
                    }
                ],
                [
                    'attribute' => 'type',
                    'filter' => ReviewReport::$types,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by type...'
                    ],
                    'value' => function ($model) {
                        $type = ArrayHelper::getValue($model::$types, $model->type);
                        return $type;
                    }
                ],
                [
                    'attribute' => 'context',
                    'label' => 'Context',
                    'filter' => ReviewReport::$contexts,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by context...'
                    ],
                    'value' => function ($model) {
                        $context = ArrayHelper::getValue($model::$contexts, $model->context);
                        return $context;
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => ReviewReport::$statuses,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by status...'
                    ],
                    'value' => function ($model) {
                        $status = ArrayHelper::getValue($model::$statuses, $model->status);

                        if ($model->status === $model::STATUS_RESOLVED) {
                            return Html::tag(
                                'span',
                                $status,
                                ['class' => 'text-info font-weight-bold']
                            );
                        }

                        return Html::tag(
                            'span',
                            $status,
                            ['class' => 'text-success font-weight-bold']
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
                                    'label' => 'View tonality report',
                                    'url' => [
                                        '/admin/view-tonality-report',
                                        'fk' => $model->fk,
                                        'type' => $model->type
                                    ]
                                ],
                                [
                                    'label' => 'Set status: Resolved',
                                    'url' => [
                                        '/admin/set-report-status',
                                        'review_report_id' => $model->review_report_id,
                                        'status' => ReviewReport::STATUS_RESOLVED
                                    ]
                                ],
                                [
                                    'label' => 'Set status: Active',
                                    'url' => [
                                        '/admin/set-report-status',
                                        'review_report_id' => $model->review_report_id,
                                        'status' => ReviewReport::STATUS_ACTIVE
                                    ]
                                ],
                                [
                                    'label' => 'Deactivate review',
                                    'url' => [
                                        '/admin/deactivate-review',
                                        'fk' => $model->fk,
                                        'type' => $model->type
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
            ],
        ]); ?>
    </div>
</div>