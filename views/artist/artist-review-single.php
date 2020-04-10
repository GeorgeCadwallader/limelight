<?php

use app\helpers\BadgeHelper;
use app\helpers\Html;
use app\helpers\UserDataHelper;
use app\models\UserVote;

use kartik\rating\StarRating;

/** @var $this yii\web\View */
/** @var $review app\models\ReviewArtist */

$review = $model;

$date = Yii::$app->formatter->asDate($review->created_at, 'php:d/m/Y');

$hasUpvoted = UserVote::find()
    ->where([
        'AND',
        ['review_artist_id' => $review->review_artist_id],
        ['created_by' => Yii::$app->user->id],
        ['type' => UserVote::TYPE_UPVOTE]
    ]);

$hasDownvoted = UserVote::find()
->where([
    'AND',
    ['review_artist_id' => $review->review_artist_id],
    ['created_by' => Yii::$app->user->id],
    ['type' => UserVote::TYPE_DOWNVOTE]
]);

?>

<div class="col-sm-12 review-single-container">
    <div class="row <?= 'review-view-container-'.$review->review_artist_id; ?>">
        <div class="col-sm-3">
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
                'name' => 'review-'.$review->artist->artist_id.'-'.$review->creator->user_id,
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
        <div class="col-sm-9">
            <?php if ($review->creator->user_id === Yii::$app->user->id) { ?>
                <div class="text-right">
                    <?= Html::a(
                        'Edit Review'.Html::icon('pencil', ['class' => 'pl-3']),
                        '#edit',
                        [
                            'class' => 'review-edit-btn btn btn-primary',
                            'data-review-id' => $review->review_artist_id
                        ]
                    ); ?>
                </div>
            <?php } ?>
            <h5>
                <?= $date; ?>
            </h5>
            <p class="my-3">
                <?= ($review->content) ? $review->content : ''; ?>
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
                        'review_id' => $review->review_artist_id,
                        'isArtist' => true
                    ],
                    ['class' => ($hasUpvoted->exists()) ? 'btn btn-primary mx-2 disabled' : 'btn btn-primary mx-2']
                ); ?>
                <?= Html::a(
                    'No',
                    [
                        '/review/downvote',
                        'review_id' => $review->review_artist_id,
                        'isArtist' => true
                    ],
                    ['class' => ($hasDownvoted->exists()) ? 'btn btn-primary mx-2 disabled' : 'btn btn-primary mx-2']
                ); ?>
            </p>
        </div>
    </div>
    <?php if ($review->creator->user_id === Yii::$app->user->id) { ?>
        <div class="row review-edit-container review-edit-container-<?= $review->review_artist_id; ?>">
            <div class="col-sm-12">
                <?= $this->render('./partials/artist-review-edit', compact('review')); ?>
            </div>
        </div>
    <?php } ?>
</div>
