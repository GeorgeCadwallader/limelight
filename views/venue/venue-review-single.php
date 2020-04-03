<?php

use app\helpers\BadgeHelper;
use app\helpers\Html;
use app\helpers\UserDataHelper;
use app\models\UserVote;

use kartik\rating\StarRating;

/** @var $this yii\web\View */
/** @var $review app\models\ReviewVenue */

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

?>

<div class="col-sm-12 review-single-container">
    <div class="row <?= 'review-view-container-'.$review->review_venue_id; ?>">
        <div class="col-sm-4">
            <?= Html::img(UserDataHelper::imageUrl($review->creator->userData), ['class' => 'img-fluid']); ?>
            <h4>
                <?= Html::a(
                    $review->creator->username,
                    [
                        '/profile/view',
                        'user_id' => $review->created_by
                    ]
                ); ?>
            </h4>
            <?= BadgeHelper::displayBadges($review->creator); ?>
            <?= StarRating::widget([
                'name' => 'review-'.$review->venue->venue_id.'-'.$review->creator->user_id,
                'value' => $review->overall_rating,
                'pluginOptions' => [
                    'filledStar' => '<i class="fa fa-star"></i>',
                    'emptyStar' => '<i class="fa fa-star"></i>',
                    'readonly' => true,
                    'showClear' => false,
                    'showCaption' => false,
                ],
            ]); ?>
        </div>
        <div class="col-sm-8">
            <?php if ($review->creator->user_id === Yii::$app->user->id) { ?>
                <div class="text-right">
                    <?= Html::a(
                        'Edit Review'.Html::icon('pencil', ['class' => 'pl-3']),
                        '#edit',
                        [
                            'class' => 'review-edit-btn btn btn-primary',
                            'data-review-id' => $review->review_venue_id
                        ]
                    ); ?>
                </div>
            <?php } ?>
            <h5>
                <?= $date; ?>
            </h5>
            <p class="my-3">
                <?= ($review->content) ? Html::encode($review->content) : ''; ?>
            </p>
            <p>
                <?= $review->upvotes.' member(s) found this helpful'; ?>
            </p>
            <p>
                Was this review helpful?
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
    <?php if ($review->creator->user_id === Yii::$app->user->id) { ?>
        <div class="row review-edit-container review-edit-container-<?= $review->review_venue_id; ?>">
            <div class="col-sm-12">
                <?= $this->render('./partials/venue-review-edit', compact('review')); ?>
            </div>
        </div>
    <?php } ?>
</div>
