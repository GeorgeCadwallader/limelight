<?php

/** @var $this yii\web\View */
/** @var $artist app\models\Artist */
/** @var $newReview app\models\ReviewArtist */
/** @var $reviewDataProvider app\models\search\ReviewArtist */

use app\auth\Item;
use app\helpers\ArtistHelper;
use app\helpers\Html;
use app\models\ReviewArtist;

use kartik\rating\StarRating;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\ListView;

$reviews = ReviewArtist::find()->where(['artist_id' => $artist->artist_id])->all();

$hasReviewed = ReviewArtist::find()
    ->where(['artist_id' => $artist->artist_id])
    ->andWhere(['created_by' => Yii::$app->user->id])
    ->exists();

$artistImg = ($artist->data->profile_path) ? Yii::$app->request->baseUrl.'/images/artist/'.$artist->data->profile_path : '/images/venue-placeholder.png';

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
    <div class="col-sm-12">
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
</div>
<div class="row bg-white p-3">
    <div class="col-sm-4">
        <?= Html::img($artistImg, ['class' => 'img-fluid']); ?>
        <h1 class="my-2"><?= $artist->name; ?></h1>
        <?= StarRating::widget([
            'name' => 'review-artist-'.$artist->artist_id,
            'value' => ArtistHelper::averageRating($artist, ReviewArtist::REVIEW_ARTIST_OVERALL),
            'pluginOptions' => Yii::$app->params['reviewArtistDisplay']
        ]); ?>
        <?= $this->render('criteria', compact('artist')); ?>
    </div>
    <div class="col-sm-8">
        <ul class="list-group">
            <h4>Genres</h4>
            <?php foreach ($artist->genre as $genre) { ?>
                <li class="list-group-item">
                    <?= Html::a($genre->name, ['/genre/view', 'genre_id' => $genre->genre_id]); ?>
                </li>
            <?php } ?>
        </ul>
        <p><?= ($artist->data->description) ?? Html::encode($artist->data->description); ?></p>
    </div>
</div>
<div class="row my-4">
    <?= ListView::widget([
            'dataProvider' => $reviewDataProvider,
            'itemView' => 'artist-review-single',
            'options' => ['class' => 'list-view row'],
            'summaryOptions' => ['class' => 'summary w-100 px-3'],
            'itemOptions' => ['class' => 'col-sm-12 my-4'],
            'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
        ]
    ); ?>
</div>
<div class="row">
    <?php if (Yii::$app->user->can(Item::ROLE_MEMBER) && !$hasReviewed) { ?>
        <?= $this->render('artist-create-review', compact('newReview')); ?>
    <?php } ?>
</div>
