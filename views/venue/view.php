<?php

/** @var $this yii\web\View */
/** @var $venue app\models\Venue */
/** @var $newReview app\models\ReviewVenue */
/** @var $reviewDataProvider app\models\search\ReviewVenue */
/** @var $reviewReport app\models\ReviewReport */

use app\auth\Item;
use app\helpers\VenueHelper;
use app\helpers\Html;
use app\models\ReviewVenue;

use kartik\rating\StarRating;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$reviews = ReviewVenue::find()->where(['venue_id' => $venue->venue_id])->all();

$hasReviewed = ReviewVenue::find()
    ->where(['venue_id' => $venue->venue_id])
    ->andWhere(['created_by' => Yii::$app->user->id])
    ->exists();

$venueImg = VenueHelper::imageUrl($venue);

$this->title = $venue->name.' | '.Yii::$app->name;

?>

<div class="row mb-3">
    <div class="col-sm-12">
        <?php if (VenueHelper::canEdit($venue)) { ?>
            <?= Html::a(
                'Edit '.$venue->name,
                ['/venue/edit', 'venue_id' => $venue->venue_id],
                ['class' => 'btn btn-primary view-edit-button']
            ); ?>
        <?php } ?>
    </div>
</div>
<div class="row">
    <?= Breadcrumbs::widget([
        'links' => [
            [
                'label' => 'Venue',
                'url' => Url::to('/venue')
            ],
            [
                'label' => 'View Venue: '.$venue->name
            ]
        ]
    ]); ?>
</div>
<div class="row">
    <div class="col-md-4">
        <div style="position: sticky; top: 100px;">
            <?= Html::img($venueImg, ['class' => 'img-fluid mb-3']); ?>
            <h1 class="my-2 d-inline-block"><?= $venue->name; ?></h1>
            <?= VenueHelper::verifiedVenueOwner($venue); ?>
            <?php foreach ($venue->genre as $genre) { ?>
                <?= Html::a($genre->name, ['/genre/view', 'genre_id' => $genre->genre_id], ['class' => 'btn btn-primary']); ?>
            <?php } ?>
            <p class="my-3">
                <?= ($venue->data->description) ?? Html::encode($venue->data->description); ?>
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
                    <?= VenueHelper::getShareButtons($venue); ?>
                </div>
            </div>
            <?= StarRating::widget([
                'name' => 'review-venue-'.$venue->venue_id,
                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_OVERALL),
                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
            ]); ?>
            <?= $this->render('./partials/criteria', compact('venue')); ?>
        </div>
    </div>
    <div class="col-md-8">
        <?php Pjax::begin(['id'=>'venueSingle', 'enablePushState' => true, 'timeout' => 5000]); ?>
            <?= ListView::widget([
                    'dataProvider' => $reviewDataProvider,
                    'itemView' => 'venue-review-single',
                    'options' => ['class' => 'list-view row pjax-refresh-item'],
                    'summaryOptions' => ['class' => 'summary w-100 px-3'],
                    'itemOptions' => ['class' => 'col-sm-12 my-4'],
                    'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
                    'viewParams' => compact('reviewReport')
                ]
            ); ?>
        <?php Pjax::end(); ?>
        <?php if (Yii::$app->user->can(Item::ROLE_MEMBER) && !$hasReviewed) { ?>
            <?= $this->render('venue-create-review', compact('newReview')); ?>
        <?php } ?>
    </div>
</div>
