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

$favouriteGenre = $review->creator->genre;

?>

<div class="col-md-12 review-single-container py-3">
    <div class="row <?= 'review-view-container-'.$review->review_artist_id; ?>">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12 text-right mb-3">
                    <?php if ($review->creator->user_id === Yii::$app->user->id) { ?>
                        <?= Html::a(
                            'Edit Review'.Html::icon('pencil', ['class' => 'pl-3']),
                            '#edit',
                            [
                                'class' => 'review-edit-btn btn btn-primary',
                                'data-review-id' => $review->review_artist_id,
                                'data-pjax' => '0'
                            ]
                        ); ?>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <h3><?= Html::a($review->creator->username, ['/profile/view', 'user_id' => $review->creator->user_id], ['data-pjax' => '0']); ?></h3>
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
                        'name' => 'review-'.$review->artist->artist_id.'-'.$review->creator->user_id,
                        'value' => $review->overall_rating,
                        'pluginOptions' => Yii::$app->params['reviewArtistDisplay'],
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
                            ['class' => 'btn btn-primary', 'data-pjax' => '0']
                        ); ?>
                    <?php } ?>
                </div>
                <div class="col-sm-9 px-md-4">
                    <?= Html::tag('div', $review->content, ['class' => 'my-4 review-text-content']); ?>
                    <?= Html::button('Read More ...', ['class' => 'btn btn-sm btn-primary read-more-btn']); ?>
                    <?= Html::tag('p', $review->upvotes.' member(s) found this helpful', ['class' => 'my-4']); ?>
                    <p>
                        Did you find this review helpful?
                        <?= Html::a(
                            'Yes',
                            [
                                '/review/upvote',
                                'review_id' => $review->review_artist_id,
                                'isArtist' => true
                            ],
                            ['class' => ($hasUpvoted->exists()) ? 'btn btn-primary mx-2 disabled' : 'btn btn-primary mx-2', 'data-pjax' => '0']
                        ); ?>
                        <?= Html::a(
                            'No',
                            [
                                '/review/downvote',
                                'review_id' => $review->review_artist_id,
                                'isArtist' => true
                            ],
                            ['class' => ($hasDownvoted->exists()) ? 'btn btn-primary mx-2 disabled' : 'btn btn-primary mx-2', 'data-pjax' => '0']
                        ); ?>
                    </p>
                </div>
            </div>
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
