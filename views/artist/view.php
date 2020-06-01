<?php

/** @var $this yii\web\View */
/** @var $artist app\models\Artist */
/** @var $newReview app\models\ReviewArtist */
/** @var $reviewDataProvider app\models\search\ReviewArtist */
/** @var $reviewReport app\models\ReviewReport */

use app\auth\Item;
use app\helpers\ArtistHelper;
use app\helpers\Html;
use app\models\ReviewArtist;

use kartik\rating\StarRating;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$reviews = ReviewArtist::find()->where(['artist_id' => $artist->artist_id])->all();

$hasReviewed = ReviewArtist::find()
    ->where(['artist_id' => $artist->artist_id])
    ->andWhere(['created_by' => Yii::$app->user->id])
    ->exists();

$artistImg = ArtistHelper::imageUrl($artist);

$this->title = $artist->name.' | '.Yii::$app->name;

?>

<div class="row mb-3">
    <div class="col-sm-12">
        <?php if (ArtistHelper::canEdit($artist)) { ?>
            <?= Html::a(
                'Edit '.$artist->name,
                ['/artist/edit', 'artist_id' => $artist->artist_id],
                ['class' => 'btn btn-primary view-edit-button']
            ); ?>
        <?php } ?>
    </div>
</div>
<div class="row">
    <?= Breadcrumbs::widget([
        'links' => [
            [
                'label' => 'Artists',
                'url' => Url::to('/artist')
            ],
            [
                'label' => 'View Artist: '.$artist->name
            ]
        ]
    ]); ?>
</div>
<div class="row">
    <div class="col-md-4">
        <div style="position: sticky; top: 100px;">
            <?= Html::img($artistImg, ['class' => 'img-fluid mb-3']); ?>
            <h1 class="my-2 d-inline-block"><?= $artist->name; ?></h1>
            <?= ArtistHelper::verifiedArtistOwner($artist); ?>
            <div class="my-3">
                <?php foreach ($artist->genre as $genre) { ?>
                    <?= Html::a($genre->name, ['/genre/view', 'genre_id' => $genre->genre_id], ['class' => 'btn btn-primary']); ?>
                <?php } ?>
            </div>
            <p class="my-3">
                <?= ($artist->data->description) ?? Html::encode($artist->data->description); ?>
            </p>
            <div class="dropdown show my-3">
                <button
                    id="social-share"
                    data-toggle="dropdown"
                    class="btn btn-primary"
                    aria-expanded="false"
                >
                    <?= Html::icon('share-alt'); ?>
                </button>
                <div class="dropdown-menu p-3" aria-labelledby="social-share">
                    <?= ArtistHelper::getShareButtons($artist); ?>
                </div>
            </div>
            <div class="my-2">
                <?= Html::a(
                    Html::icon('plus').Html::tag('div', 'Compare this artist with another artist', ['class' => 'tooltip']),
                    ['/compare/artist', 'artist_id_one' => $artist->artist_id],
                    ['class' => 'btn btn-primary limelight-tooltip m-0']
                ); ?>
            </div>
            <?= StarRating::widget([
                'name' => 'review-artist-'.$artist->artist_id,
                'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_OVERALL),
                'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
            ]); ?>
            <?= $this->render('./partials/criteria', compact('artist')); ?>
        </div>
    </div>
    <div class="col-md-8">
        <?php Pjax::begin(['id'=>'venueSingle', 'enablePushState' => true, 'timeout' => 5000]); ?>
            <?= ListView::widget([
                    'dataProvider' => $reviewDataProvider,
                    'pager' => Yii::$app->params['paginationConfig'],
                    'itemView' => 'artist-review-single',
                    'options' => ['class' => 'list-view row pjax-refresh-item'],
                    'summaryOptions' => ['class' => 'summary invisible w-100 px-3'],
                    'itemOptions' => ['class' => 'col-sm-12 my-4'],
                    'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
                    'viewParams' => compact('reviewReport')
                ]
            ); ?>
        <?php Pjax::end(); ?>
        <?php if (Yii::$app->user->can(Item::ROLE_MEMBER) && !$hasReviewed) { ?>
            <?= $this->render('artist-create-review', compact('newReview')); ?>
        <?php } ?>
    </div>
</div>
