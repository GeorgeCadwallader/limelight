<?php

use app\helpers\Html;
use app\models\Artist;
use app\models\Genre;

use conquer\select2\Select2Widget;

use dosamigos\tinymce\TinyMce;

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $artist app\models\Artist */
/** @var $artistData app\models\ArtistData */

$genres = ArrayHelper::map(Genre::find()->all(), 'genre_id', 'name');

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'View: '.$artist->name,
                    'url' => Url::to(['/artist/view', 'artist_id' => $artist->artist_id])
                ],
                ['label' => 'Edit: '.$artist->name]
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1>Edit <?= $artist->name; ?></h1>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <?php if ($artist->status === Artist::STATUS_UNVERIFIED) { ?>
            <div class="alert alert-warning" role="alert">
                <strong>Warning:</strong> Your artist page is still being reviewed by admins,
                it will not be viewable to anyone on the site untill it becomes activated.
                You can still edit the information of your artist page below.
            </div>
        <?php } elseif ($artist->status === Artist::STATUS_ACTIVE) { ?>
            <div class="alert alert-success" role="alert">
                Your artist page is currently active, this means it will be shown to
                everyone who accesses <?= Yii::$app->name; ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php $form = ActiveForm::begin([
            'id' => 'artist-edit-form'
            ]); ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <?php if ($artistData->profile_path !== null) { ?>
                            <div class="col-sm-5">
                                <?= Html::img(Yii::$app->request->baseUrl.'/images/artist/'.$artistData->profile_path, ['class' => 'img-fluid']); ?>
                            </div>
                            <div class="col-sm-7">
                                <?= $form->field($artistData, 'imageFile')->fileInput(); ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-sm-8">
                                <?= $form->field($artistData, 'imageFile')->fileInput(); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($artistData, 'description')->widget(TinyMce::class,
                        Yii::$app->params['richtextOptions']
                    ); ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($artistData->artist, 'genre')->widget(Select2Widget::className(), [
                            'placeholder' => 'Select genres ...',
                            'items' => $genres,
                            'multiple' => true,
                        ]
                    )->label('Choose your genres'); ?>
                </div>
                <div class="col-sm-12 my-3">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>