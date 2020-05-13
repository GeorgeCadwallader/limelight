<?php

use app\helpers\ArtistHelper;
use app\helpers\Html;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $artistOne app\models\Artist */
/** @var $artistTwo app\models\Artist */

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
                    'label' => 'Compare Artists',
                    'url' => Url::to('/compare/artist')
                ],
                ['label' => 'Compare: '.$artistOne->name.' and '.$artistTwo->name]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Compare: <?= $artistOne->name; ?> and <?= $artistTwo->name; ?></h1>
    </div>
</div>
<div class="row mt-5">
    <div class="col-md-4">
        <div
            class="compare-image"
            style="background-image:url('<?= ArtistHelper::imageUrl($artistOne); ?>')"
        >
        </div>
        <div class="mt-3">
            <h2 class="text-center my-3 d-inline"><?= $artistOne->name; ?></h2>
            <?= Html::a(
                Html::icon('plus').Html::tag('div', 'Compare this Artist with someone new', ['class' => 'tooltip']),
                ['/compare/artist', 'artist_id_one' => $artistOne->artist_id],
                ['class' => 'btn btn-primary limelight-tooltip ml-3']
            ); ?>
        </div>
    </div>
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div
            class="compare-image"
            style="background-image:url('<?= ArtistHelper::imageUrl($artistTwo); ?>')"
        >
        </div>
        <div class="mt-3">
            <h2 class="text-center my-3 d-inline"><?= $artistTwo->name; ?></h2>
            <?= Html::a(
                Html::icon('plus').Html::tag('div', 'Compare this Artist with someone new', ['class' => 'tooltip']),
                ['/compare/artist', 'artist_id_one' => $artistTwo->artist_id],
                ['class' => 'btn btn-primary limelight-tooltip ml-3']
            ); ?>
        </div>
    </div>
</div>
<?= $this->render('artist-compare-results', compact('artistOne', 'artistTwo')); ?>