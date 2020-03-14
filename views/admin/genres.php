<?php

use app\helpers\Html;
use app\models\Genre;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\Dropdown;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $genreFilterModel app\models\search\GenreSearch */
/** @var $genreDataProvider yii\data\ActiveDataProvider */

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
                    'label' => 'Genres'
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-8">
        <h1>Genre Management</h1>
    </div>
    <div class="col-sm-4 text-sm-right">
        <?= Html::a(
            'Create new Genre',
            '/admin/add-genre',
            ['class' => 'btn btn-primary']
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
            'dataProvider' => $genreDataProvider,
            'filterModel' => $genreFilterModel,
            'columns' => [
                [
                    'attribute' => 'name',
                ],
                [
                    'attribute' => 'parent_id',
                    'label' => 'Parent',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->parent_id === null) {
                            $genreParent = '(none)';
                        } else {
                            $genreParent = Genre::findOne($model->parent_id);
                            $genreParent = $genreParent->name;
                        }

                        return Html::tag(
                            'span',
                            $genreParent,
                            ['class' => 'text-primary font-weight-bold']
                        );
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
                                    '/admin/edit-genre',
                                    'genre_id' => $model->genre_id
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