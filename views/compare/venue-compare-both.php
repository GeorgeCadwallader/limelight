<?php

use app\helpers\VenueHelper;
use app\helpers\Html;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $venueOne app\models\Venue */
/** @var $venueTwo app\models\Venue */

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Compare Hub',
                    'url' => Url::to('/compare')
                ],
                [
                    'label' => 'Compare Venues',
                    'url' => Url::to('/compare/venue')
                ],
                ['label' => 'Compare: '.$venueOne->name.' and '.$venueTwo->name]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Compare: <?= $venueOne->name; ?> and <?= $venueTwo->name; ?></h1>
    </div>
</div>
<div class="row mt-5">
    <div class="col-sm-4">
        <?= Html::img(VenueHelper::imageUrl($venueOne), ['class' => 'img-fluid']); ?>
        <h2 class="text-center my-3"><?= $venueOne->name; ?></h2>
        <?= Html::a('Compare this venue with someone different', ['/compare/venue', 'venue_id_one' => $venueOne->venue_id], ['class' => 'btn btn-primary']); ?>
    </div>
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
        <?= Html::img(VenueHelper::imageUrl($venueTwo), ['class' => 'img-fluid']); ?>
        <h2 class="text-center my-3"><?= $venueTwo->name; ?></h2>
        <?= Html::a('Compare this venue with someone different', ['/compare/venue', 'venue_id_one' => $venueTwo->venue_id], ['class' => 'btn btn-primary']); ?>
    </div>
</div>
<?= $this->render('venue-compare-results', compact('venueOne', 'venueTwo')); ?>