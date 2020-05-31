<?php

/** @var $this yii\web\View */
/** @var $model app\models\Artist */

use app\helpers\ArtistHelper;
use app\models\ReviewArtist;
use kartik\rating\StarRating;

use yii\helpers\Url;

$artist = $model;

$url = ArtistHelper::imageUrl($artist);

?>

<a
    href="<?= Url::to(['/artist/view', 'artist_id' => $artist->artist_id]); ?>"
    class="contained-link"
    data-pjax="0"
>
    <div
        class="contained-image limelight-box-shadow"
        style="background-image:url(<?= Url::to($url); ?>)"
    >
        <div class="contained-content">
            <div class="contained-content-inner p-3">
                <div>
                    <h3 class="d-inline-block"><?= $artist->name; ?></h3>
                    <?= ArtistHelper::verifiedArtistOwner($artist); ?>
                </div>
                <?= StarRating::widget([
                    'name' => 'contained-artist-'.$artist->artist_id,
                    'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
                <strong>( <?= ($artist->reviewCount === 1) ? $artist->reviewCount.' review' : $artist->reviewCount.' reviews'; ?> )</strong>
            </div>
        </div>
    </div>
</a>
