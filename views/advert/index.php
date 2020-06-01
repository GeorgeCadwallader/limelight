<?php

/** @var $this yii\web\View */

use app\helpers\ArtistHelper;
use app\helpers\Html;
use app\helpers\VenueHelper;
use app\models\Advert;
use yii\bootstrap4\Breadcrumbs;

$this->title = 'Adverts | '.Yii::$app->name;

?>

<div class="row mb-3">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Adverts',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1 class="font-weight-bold">Adverts on <?= Yii::$app->name; ?></h1>
    </div>
</div>
<div class="row mb-2 mt-5">
    <div class="col-sm-12">
        <div class="limelight-box-shadow rounded lead p-4">
            At <?= Yii::$app->name; ?> we want a fair platform for everyone, and this includes the
            artist and venue owners.
            <br><br>
            Adverts on <?= Yii::$app->name; ?> work in a way that benefits everyone
            and gives no-one and unfair advantage. Read the information below to learn about how adverts on
            <?= Yii::$app->name; ?> works and the different types that are available.
        </div>
    </div>
</div>
<div class="row my-100">
    <div class="col-md-4">
        <?= Html::img('/images/globe.png', ['class' => 'img-fluid']); ?>
        <div class="mt-2 text-justify p-3">
            <h3>Global</h3>
            <p>This option allows for the owner to target all users on <?= Yii::$app->name; ?>.</p>
            <?php if (ArtistHelper::isOwner() || VenueHelper::isOwner()) {
                echo Html::a('Create', ['/advert/create', 'advert_type' => Advert::ADVERT_TYPE_GLOBAL], ['class' => 'btn btn-primary']);
            } ?>
        </div>
    </div>
    <div class="col-md-4">
        <?= Html::img('/images/A6.png', ['class' => 'img-fluid']); ?>
        <div class="mt-2 text-justify p-3">
            <h3>Genre</h3>
            <p>This option allows for the owner to target users with relating genres to their artist or venue.</p>
            <?php if (ArtistHelper::isOwner() || VenueHelper::isOwner()) {
                echo Html::a('Create', ['/advert/create', 'advert_type' => Advert::ADVERT_TYPE_GENRE], ['class' => 'btn btn-primary']);
            } ?>
        </div>
    </div>
    <div class="col-md-4">
        <?= Html::img('/images/A3.png', ['class' => 'img-fluid']); ?>
        <div class="mt-2 text-justify p-3">
            <h3>Location</h3>
            <p>Target <?= Yii::$app->name; ?> members who share a similar location to their artist or venue.</p>
            <?php if (ArtistHelper::isOwner() || VenueHelper::isOwner()) {
                echo Html::a('Create', ['/advert/create', 'advert_type' => Advert::ADVERT_TYPE_LOCATION], ['class' => 'btn btn-primary']);
            } ?>
        </div>
    </div>
</div>