<?php

/** @var $this yii\web\View */
/** @var $model app\models\Advert */

use app\helpers\ArtistHelper;
use app\helpers\Html;
use app\helpers\VenueHelper;
use yii\helpers\Url;

if ($model->artist) {
    $url = Url::to(['/artist/view', 'artist_id' => $model->artist->artist_id]);
    $imgUrl = ArtistHelper::imageUrl($model->artist);
    $name = $model->artist->name;
} else {
    $url = Url::to(['/venue/view', 'venue_id' => $model->venue->venue_id]);
    $imgUrl = VenueHelper::imageUrl($model->venue);
    $name = $model->venue->name;
}

?>

<a href="<?= $url; ?>">
    <div
        class="advert-con position-relative limelight-box-shadow rounded"
        style="background-image: url('<?= $imgUrl; ?>')"
    >
        <?= Html::tag('h4', $model->message, ['class' => 'advert-message-top']); ?>
        <?= Html::tag('h4', 'View '.$name, ['class' => 'advert-message font-weight-bold']); ?>
    </div>
</a>