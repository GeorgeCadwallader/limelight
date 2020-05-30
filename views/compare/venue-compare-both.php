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
    <div class="col-md-4">
        <div
            class="compare-image"
            style="background-image:url('<?= VenueHelper::imageUrl($venueOne); ?>')"
        >
        </div>
        <div class="mt-3">
            <h2 class="text-center my-3 d-inline"><?= $venueOne->name; ?></h2>
            <?= Html::a(
                Html::icon('plus').Html::tag('div', 'Compare this Venue a different one', ['class' => 'tooltip']),
                ['/compare/venue', 'venue_id_one' => $venueOne->venue_id],
                ['class' => 'btn btn-primary limelight-tooltip ml-3']
            ); ?>
        </div>
    </div>
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div
            class="compare-image"
            style="background-image:url('<?= VenueHelper::imageUrl($venueTwo); ?>')"
        >
        </div>
        <div class="mt-3">
            <h2 class="text-center my-3 d-inline"><?= $venueTwo->name; ?></h2>
            <?= Html::a(
                Html::icon('plus').Html::tag('div', 'Compare this Venue a different one', ['class' => 'tooltip']),
                ['/compare/venue', 'venue_id_one' => $venueTwo->venue_id],
                ['class' => 'btn btn-primary limelight-tooltip ml-3']
            ); ?>
        </div>
    </div>
</div>
<?= $this->render('venue-compare-results', compact('venueOne', 'venueTwo')); ?>