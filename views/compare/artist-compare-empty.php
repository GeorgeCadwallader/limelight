<?php

use app\helpers\Html;
use app\models\Artist;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$artists = ArrayHelper::map(Artist::find()->where(['status' => Artist::STATUS_ACTIVE])->all(), 'artist_id', 'name');

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Compare Hub',
                    'url' => Url::to('/compare')
                ],
                ['label' => 'Compare Artists']
            ]
        ]); ?>
    </div>
</div>
<div class="jumbotron">
    <h1 class="display-4">Compare Artists</h1>
    <p class="lead">Compare artists and get predicted feedback informing you of their qualities</p>
    <hr class="my-4">
    <p>
        We know how much tickets to see artists can cost so at <?= Yii::$app->name; ?> we want to make
        sure you are getting your moneys worth. Introducing our <strong>Comparison Wizard</strong>,
        select two artists in the dropdown below, we'll do some calculations and inform you on which
        one we think is better to go and see!
    </p>
</div>
<div class="row">
    <div class="col-sm-6">
        <label class="my-2" for="artistOne">Artist One</label>
        <?= Html::dropDownList(
            'artistOne',
            null,
            $artists,
            [
                'class' => 'compare-artist-select compare-artist-select-one custom-select',
                'prompt' => '-- Select artist --'
            ]
        ); ?>
    </div>
    <div class="col-sm-6">
        <label class="my-2" for="artistTwo">Artist Two</label>
        <?= Html::dropDownList(
            'artistTwo',
            null,
            $artists,
            [
                'class' => 'compare-artist-select compare-artist-select-two custom-select',
                'prompt' => '-- Select artist -- '
            ]
        ); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?= Html::a('Compare', '/compare/artist', ['class' => 'btn btn-primary compare-artist-link']); ?>
    </div>
</div>