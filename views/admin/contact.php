<?php

/** @var $this yii\web\View */
/** @var $contactFilterModel app\models\search\ContactSearch */
/** @var $contactDataProvider yii\data\ActiveDataProvider */

use app\helpers\Html;
use app\models\Contact;

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
                    'label' => 'Contact Messages'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Contact Messages</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
            'dataProvider' => $contactDataProvider,
            'filterModel' => $contactFilterModel,
            'columns' => [
                ['attribute' => 'contact_id'],
                ['attribute' => 'first_name'],
                ['attribute' => 'last_name'],
                ['attribute' => 'email'],
                ['attribute' => 'message'],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => Contact::$statuses,
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
                                    'label' => 'Set status: Unread',
                                    'url' => [
                                        '/admin/set-contact-status',
                                        'contact_id' => $model->contact_id,
                                        'status' => Contact::STATUS_UNREAD
                                    ]
                                ],
                                [
                                    'label' => 'Set status: Resolved',
                                    'url' => [
                                        '/admin/set-contact-status',
                                        'contact_id' => $model->contact_id,
                                        'status' => Contact::STATUS_RESOLVED
                                    ]
                                ],
                                [
                                    'label' => 'Set status: Deactivated',
                                    'url' => [
                                        '/admin/set-contact-status',
                                        'contact_id' => $model->contact_id,
                                        'status' => Contact::STATUS_DEACTIVATED
                                    ]
                                ],
                                [
                                    'label' => 'Reply',
                                    'url' => [
                                        '/admin/reply-contact-message',
                                        'contact_id' => $model->contact_id
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