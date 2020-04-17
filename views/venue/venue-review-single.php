<?php

use app\helpers\BadgeHelper;
use app\helpers\Html;
use app\helpers\UserDataHelper;
use app\models\UserVote;

use kartik\rating\StarRating;
use yii\helpers\StringHelper;

/** @var $this yii\web\View */
/** @var $review app\models\ReviewVenue */

$review = $model;

$date = Yii::$app->formatter->asDate($review->created_at, 'php:d/m/Y');

$hasUpvoted = UserVote::find()
    ->where([
        'AND',
        ['review_venue_id' => $review->review_venue_id],
        ['created_by' => Yii::$app->user->id],
        ['type' => UserVote::TYPE_UPVOTE]
    ]);

$hasDownvoted = UserVote::find()
->where([
    'AND',
    ['review_venue_id' => $review->review_venue_id],
    ['created_by' => Yii::$app->user->id],
    ['type' => UserVote::TYPE_DOWNVOTE]
]);

$favouriteGenre = $review->creator->genre;

?>

<div class="col-md-12 review-single-container py-3">
    <div class="row <?= 'review-view-container-'.$review->review_venue_id; ?>">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12 text-right mb-3">
                    <?php if ($review->creator->user_id === Yii::$app->user->id) { ?>
                        <?= Html::a(
                            'Edit Review'.Html::icon('pencil', ['class' => 'pl-3']),
                            '#edit',
                            [
                                'class' => 'review-edit-btn btn btn-primary',
                                'data-review-id' => $review->review_venue_id
                            ]
                        ); ?>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <h3><?= Html::a($review->creator->username, ['/profile/view', 'user_id' => $review->creator->user_id]); ?></h3>
                    <?= BadgeHelper::displayBadges($review->creator); ?>
                </div>
                <div class="col-sm-3">
                    <strong>
                        <?= $date; ?>
                    </strong>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= StarRating::widget([
                        'name' => 'review-'.$review->venue->venue_id.'-'.$review->creator->user_id,
                        'value' => $review->overall_rating,
                        'pluginOptions' => Yii::$app->params['reviewVenueDisplay'],
                    ]); ?>
                    <?= Html::img(UserDataHelper::imageUrl($review->creator->userData), ['class' => 'img-fluid my-3']); ?>
                    <?php if (!empty($favouriteGenre)) { ?>
                        <p class="mt-3">Favourite Genre</p>
                        <?= Html::a(
                            $favouriteGenre[0]->name,
                            [
                                '/genre/view',
                                'genre_id' => $favouriteGenre[0]->genre_id
                            ],
                            ['class' => 'btn btn-primary']
                        ); ?>
                    <?php } ?>
                </div>
                <div class="col-sm-9 px-md-4">
                    <?php if (StringHelper::countWords($review->content) > 50) { ?>
                        <?= Html::readMore($review->content, $review->review_venue_id); ?>
                    <?php } else { ?>
                        <?= Html::tag('p', $review->content, ['class' => 'my-4']); ?>
                    <?php } ?>
                    <?= Html::tag('p', $review->upvotes.' member(s) found this helpful', ['class' => 'my-4']); ?>
                    <p>
                        Did you find this review helpful?
                        <?= Html::a(
                            'Yes',
                            [
                                '/review/upvote',
                                'review_id' => $review->review_venue_id,
                                'isArtist' => false
                            ],
                            ['class' => ($hasUpvoted->exists()) ? 'btn btn-primary mx-2 disabled' : 'btn btn-primary mx-2']
                        ); ?>
                        <?= Html::a(
                            'No',
                            [
                                '/review/downvote',
                                'review_id' => $review->review_venue_id,
                                'isArtist' => false
                            ],
                            ['class' => ($hasDownvoted->exists()) ? 'btn btn-primary mx-2 disabled' : 'btn btn-primary mx-2']
                        ); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php if ($review->creator->user_id === Yii::$app->user->id) { ?>
        <div class="row review-edit-container review-edit-container-<?= $review->review_venue_id; ?>">
            <div class="col-sm-12">
                <?= $this->render('./partials/venue-review-edit', compact('review')); ?>
            </div>
        </div>
    <?php } ?>
</div>
