<?php

/** @var $this yii\web\View */
/** @var $memberRequestFilterModel app\models\search\MemberRequestSearch */
/** @var $memberRequestDataProvider yii\data\ActiveDataProvider */

use app\helpers\Html;
use app\models\MemberRequest;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\Dropdown;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


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
                    'label' => 'Member Requests'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1 class="font-weight-bold">Member Requests</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
            'pager' => Yii::$app->params['paginationConfig'],
            'dataProvider' => $memberRequestDataProvider,
            'filterModel' => $memberRequestFilterModel,
            'columns' => [
                ['attribute' => 'member_request_id'],
                ['attribute' => 'request_name'],
                [
                    'attribute' => 'type',
                    'filter' => MemberRequest::$types,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'prompt' => 'Filter by type...'
                    ],
                    'value' => function ($model) {
                        return MemberRequest::$types[$model->type];
                    }
                ],
                ['attribute' => 'request_count'],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => MemberRequest::$statuses,
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
                                ['class' => 'text-info font-weight-bold']
                            );
                        }

                        if ($model->status === $model::STATUS_DEACTIVATED) {
                            return Html::tag(
                                'span',
                                $status,
                                ['class' => 'text-warning font-weight-bold']
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
                                    'label' => 'Set status: Deactivated',
                                    'url' => [
                                        '/member-request/set-status',
                                        'member_request_id' => $model->member_request_id,
                                        'status' => MemberRequest::STATUS_DEACTIVATED
                                    ]
                                ],
                                [
                                    'label' => 'Set status: Active',
                                    'url' => [
                                        '/member-request/set-status',
                                        'member_request_id' => $model->member_request_id,
                                        'status' => MemberRequest::STATUS_ACTIVE
                                    ]
                                ],
                                [
                                    'label' => 'Approve and create request',
                                    'url' => [
                                        '/member-request/approve-request',
                                        'member_request_id' => $model->member_request_id,
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