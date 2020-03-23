<?php

/** @var $this yii\web\View */
/** @var $model app\models\Artist */

use app\helpers\ArtistHelper;

use kartik\rating\StarRating;

use yii\helpers\Url;

$artist = $model;

$url = ArtistHelper::imageUrl($artist);

?>

<a
    href="<?= Url::to(['/artist/view', 'artist_id' => $artist->artist_id]); ?>"
    class="contained-link"
>
    <div
        class="contained-image"
        style="background-image:url(<?= Url::to($url); ?>)"
    >
        <div class="contained-content">
            <div class="contained-content-inner p-3">
                <h3><?= $artist->name; ?></h3>
                <?= StarRating::widget([
                    'name' => 'contained-artist-'.$artist->artist_id,
                    'value' => ArtistHelper::averageOverallRating($artist),
                    'pluginOptions' => [
                        'filledStar' => '<i class="fa fa-star"></i>',
                        'emptyStar' => '<i class="fa fa-star"></i>',
                        'readonly' => true,
                        'showClear' => false,
                        'showCaption' => false,
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</a>
