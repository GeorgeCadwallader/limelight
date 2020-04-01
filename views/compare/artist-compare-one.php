<?php

/** @var $artistOne app\models\Artist */

use app\helpers\Html;
use app\models\Artist;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$query = Artist::find()->where(['status' => Artist::STATUS_ACTIVE]);

$artists = ArrayHelper::map($query->all(), 'artist_id', 'name');

$filteredArtists = ArrayHelper::map($query->andWhere(['!=', 'artist_id', $artistOne->artist_id])->all(), 'artist_id', 'name');

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
    <div class="col-sm-12">
        <div class="alert alert-primary" role="alert">
            It seems you already have one artist filled in, great! Fill in the other field to
            complete the comparison.
        </div>
    </div>
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
                'prompt' => '-- Select artist --',
                'disabled' => true,
                'options' => [
                    $artistOne->artist_id => ['selected' => true]
                ]
            ]
        ); ?>
    </div>
    <div class="col-sm-6">
        <label class="my-2" for="artistTwo">Artist Two</label>
        <?= Html::dropDownList(
            'artistTwo',
            null,
            $filteredArtists,
            [
                'class' => 'compare-artist-select compare-artist-select-two custom-select',
                'prompt' => '-- Select artist -- '
            ]
        ); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?= Html::a('Compare', ['/compare/artist', 'artist_id_one' => $artistOne->artist_id], ['class' => 'btn btn-primary compare-artist-link']); ?>
    </div>
</div>