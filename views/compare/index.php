<?php

/** @var $this yii\web\View */

use app\helpers\Html;
use yii\bootstrap4\Breadcrumbs;

$this->title = Yii::$app->name.' | Compare artist and venues';

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                ['label' => 'Compare Hub']
            ]
        ]); ?>
    </div>
</div>
<div class="jumbotron limelight-box-shadow rounded my-5">
    <h1 class="display-4">Compare Hub</h1>
    <p class="lead">Compare artists or venues based on our information</p>
    <hr class="my-4">
    <p>
        At <?= Yii::$app->name; ?> we know how much going to see an artist costs, so
        we want you to get your experience at full value! You will be asked to select two
        artists or two venues, we will complete some calculations and then inform you what
        we think based off of our data.
        <br><br>
        Let's get started, would you like to compare artists or venues?
    </p>
    <div class="lead row my-5">
        <div class="col-sm-6 text-center mb-4">
            <?= Html::a('Artists', '/compare/artist', ['class' => 'btn btn-primary btn-lg']); ?>
        </div>
        <div class="col-sm-6 text-center mb-4">
            <?= Html::a('Venues', '/compare/venue', ['class' => 'btn btn-primary btn-lg']); ?>       
        </div>
    </div>
</div>
