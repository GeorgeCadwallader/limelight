<?php

/** @var $genre app\models\Genre */
/** @var $edit bool */

use app\helpers\Html;
use app\models\Genre;

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

if ($edit) {
    $query = Genre::find()->andWhere(['!=', 'genre_id', $genre->genre_id]);
} else {
    $query = Genre::find();
}

$genres = ArrayHelper::map(
    $query->all(),
    'genre_id',
    'name'
);

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
                    'label' => 'Genre page',
                    'url' => Url::to('/admin/genre')
                ],
                [
                    'label' => 'Create Genre',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1>
            <?= ($edit) ? 'Edit '.$genre->name : 'Create Genre'; ?>
        </h1>
    </div>
</div>
<?php $form = ActiveForm::begin([
        'id' => 'genre-form',
    ]); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($genre, 'name')->textInput(['autofocus' => true]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($genre, 'parent_id')->dropDownList($genres, ['prompt' => '-- Select Parent --']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= Html::submitButton(
                ($edit) ? 'Update' : 'Create',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
