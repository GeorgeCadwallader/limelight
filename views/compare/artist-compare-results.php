<?php

use app\helpers\ArtistHelper;
use app\models\ReviewArtist;

use kartik\rating\StarRating;

use yii\helpers\Inflector;

/** @var $this yii\web\View */
/** @var $artistOne app\models\Artist */
/** @var $artistTwo app\models\Artist */

?>

<table class="table table-responsive-md my-5">
    <tbody>
        <tr class="text-center">
            <td class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_OVERALL); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_OVERALL); ?></h4>
            </td>
            <td class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_OVERALL); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_OVERALL),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_ENERGY); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_ENERGY),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_ENERGY); ?></h4>
            </td>
            <td class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_ENERGY); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_ENERGY),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_VOCALS); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_VOCALS),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_VOCALS); ?></h4>
            </td>
            <td class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_VOCALS); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_VOCALS),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_SOUND); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_SOUND),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_SOUND); ?></h4>
            </td>
            <td class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_SOUND); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_SOUND),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE); ?></h4>
            </td>
            <td class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_STAGE_PRESENCE),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
        <tr class="text-center">
            <td class="<?= ArtistHelper::getCompareColorArtistOne($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistOne->artist_id,
                    'value' => ArtistHelper::averageRating($artistOne, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
            <td>
                <h4><?= Inflector::humanize(ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC); ?></h4>
            </td>
            <td class="<?= ArtistHelper::getCompareColorArtistTwo($artistOne, $artistTwo, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC); ?>">
                <?= StarRating::widget([
                    'name' => 'compare-artist-'.$artistTwo->artist_id,
                    'value' => ArtistHelper::averageRating($artistTwo, ReviewArtist::REVIEW_ARTIST_SONG_AESTHETIC),
                    'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
                ]); ?>
            </td>
        </tr>
    </tbody>
</table>