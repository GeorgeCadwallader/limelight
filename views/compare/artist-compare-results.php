<?php

use app\helpers\ArtistHelper;
use app\models\ReviewArtist;

use kartik\rating\StarRating;

use yii\helpers\Inflector;

/** @var $this yii\web\View */
/** @var $artistOne app\models\Artist */
/** @var $artistTwo app\models\Artist */

$artistOneReviews = ReviewArtist::find()
    ->where(['artist_id' => $artistOne->artist_id])
    ->andWhere(['status' => ReviewArtist::STATUS_ACTIVE])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(4)
    ->all();

$artistTwoReviews = ReviewArtist::find()
    ->where(['artist_id' => $artistTwo->artist_id])
    ->andWhere(['status' => ReviewArtist::STATUS_ACTIVE])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(4)
    ->all();

?>

<table class="table table-responsive-md my-5">
    <tbody>
        <tr class="text-center">
        
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_OVERALL); ?>"> </td>
            <td id="filler"> </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_OVERALL); ?></h4>
            </td>
            <td id="filler"> </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_OVERALL); ?>"> </td>
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_ENERGY),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_ENERGY); ?>"> </td>
            <td id="filler"> </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_ENERGY); ?></h4>
            </td>
            <td id="filler"> </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_ENERGY); ?>"> </td>
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id, 
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_ENERGY),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_VOCALS),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_VOCALS); ?>"> </td>
            <td id="filler" > </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_VOCALS); ?></h4>
            </td>
            <td id="filler"> </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_VOCALS); ?>"> </td>
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_VOCALS),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_SOUND),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_SOUND); ?>"> </td>
            <td id="filler" > </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_SOUND); ?></h4>
            </td>
            <td id="filler"> </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_SOUND); ?>"> </td>
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_SOUND),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE); ?>"> </td>
            <td id="filler"> </td>
            <td>
           
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE); ?></h4>
            </td>
            <td id="filler"> </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE); ?>"> </td>
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC); ?>"> </td>
            <td id="filler"> </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC); ?></h4>
            </td>
            <td id="filler"> </td>
            <td id="filler" class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC); ?>"> </td>
            <td>
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
    </tbody>
</table>
<div class="row my-5">
    <div class="col-lg-6">
        <h3>Latest <?= $artistOne->name; ?> reviews</h3>
        <?php foreach ($artistOneReviews as $model) {
            echo $this->render('../event/partials/review-artist-view', compact('model'));
        } ?>
    </div>
    <div class="col-lg-6">
        <h3>Latest <?= $artistTwo->name; ?> reviews</h3>
        <?php foreach ($artistTwoReviews as $model) {
            echo $this->render('../event/partials/review-artist-view', compact('model'));
        } ?>
    </div>
</div>