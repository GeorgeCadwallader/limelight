<?php

use app\helpers\Html;
use app\models\Venue;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$venues = ArrayHelper::map(Venue::find()->where(['status' => Venue::STATUS_ACTIVE])->all(), 'venue_id', 'name');

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Compare Hub',
                    'url' => Url::to('/compare')
                ],
                ['label' => 'Compare Venues']
            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 p-3 limelight-box-shadow rounded my-5">
        <h1 class="display-4">Compare Venues</h1>
        <p class="lead">Compare venues and get predicted feedback informing you of their qualities</p>
        <hr class="my-4">
        <p>
            We know how much tickets to see artists can cost so at <?= Yii::$app->name; ?> we want to make
            sure you are getting your moneys worth. Introducing our <strong>Comparison Wizard</strong>,
            select two venues in the dropdown below, we'll do some calculations and inform you on which
            one we think is better to go and see!
        </p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <label class="my-2" for="venueOne">Venue One</label>
        <?= Html::dropDownList(
            'venueOne',
            null,
            $venues,
            [
                'class' => 'compare-venue-select compare-venue-select-one custom-select',
                'prompt' => '-- Select venue --'
            ]
        ); ?>
    </div>
    <div class="col-sm-6">
        <label class="my-2" for="venueTwo">Venue Two</label>
        <?= Html::dropDownList(
            'venueTwo',
            null,
            $venues,
            [
                'class' => 'compare-venue-select compare-venue-select-two custom-select',
                'prompt' => '-- Select venue -- '
            ]
        ); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?= Html::a('Compare', '/compare/venue', ['class' => 'btn btn-primary compare-venue-link']); ?>
    </div>
</div>