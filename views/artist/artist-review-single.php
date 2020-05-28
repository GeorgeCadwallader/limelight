<?php

use app\helpers\BadgeHelper;
use app\helpers\Html;
use app\helpers\UserDataHelper;
use app\models\ReviewReport;
use app\models\UserVote;

use kartik\rating\StarRating;
use yii\bootstrap4\ActiveForm;

/** @var $this yii\web\View */
/** @var $review app\models\ReviewArtist */
/** @var $reviewReport app\models\ReviewReport */

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
            <div class="row mb-2">
                <div class="col-sm-12 text-right">
                    <div class="dropdown">
                        <button
                            class="btn btn-primary"
                            type="button"
                            id="reviewOptions-<?= $review->review_artist_id; ?>"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <?= Html::icon('ellipsis-h'); ?>
                        </button>
                        <div class="dropdown-menu text-center" aria-labelledby="reviewOptions-<?= $review->review_artist_id; ?>">
                            <?php if ($review->creator->user_id === Yii::$app->user->id) { ?>
                                <?= Html::a(
                                    'Edit'.Html::icon('pencil', ['class' => 'pl-3']),
                                    '#edit',
                                    [
                                        'class' => 'review-edit-btn btn text-primary',
                                        'data-review-id' => $review->review_artist_id,
                                        'data-pjax' => '0'
                                    ]
                                ); ?>
                            <?php } else { ?>
                                <?= Html::button(
                                    'Report'.Html::icon('flag', ['class' => 'pl-3']),
                                    [
                                        'class' => 'btn text-primary',
                                        'data-pjax' => '0',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#reviewModalArtist-'.$review->review_artist_id
                                    ]
                                ); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-7 col-md-8">
                    <h3><?= Html::a($review->creator->username, ['/profile/view', 'user_id' => $review->creator->user_id], ['data-pjax' => '0']); ?></h3>
                    <?= BadgeHelper::displayBadges($review->creator); ?>
                </div>
                <div class="col-sm-5 col-md-4 text-sm-right">
                    <strong>
                        <?= $date; ?>
                    </strong>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-4">
                    <?= StarRating::widget([
                        'name' => 'review-'.$review->artist->artist_id.'-'.$review->creator->user_id,
                        'value' => $review->overall_rating,
                        'pluginOptions' => Yii::$app->params['reviewArtistDisplay'],
                    ]); ?>
                    <?= Html::img(UserDataHelper::imageUrl($review->creator->userData), ['class' => 'img-fluid my-3 img-responsive']); ?>
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
                <div class="col-sm-7 col-md-8 px-md-4">
                    <?= Html::tag('div', $review->content, ['class' => 'my-4 review-text-content']); ?>
                    <?= Html::button('Read More ...', ['class' => 'btn btn-sm btn-primary read-more-btn']); ?>
                    <?= Html::tag('p', $review->upvotes.' member(s) found this helpful', ['class' => 'my-4']); ?>
                    <p>
                        Did you find this review helpful?
                        <?= Html::a(
                            Html::icon('thumbs-up'),
                            [
                                '/review/upvote',
                                'review_id' => $review->review_artist_id,
                                'isArtist' => true
                            ],
                            ['class' => ($hasUpvoted->exists()) ? 'btn btn-primary mx-2 disabled' : 'btn btn-primary mx-2', 'data-pjax' => '0']
                        ); ?>
                        <?= Html::a(
                            Html::icon('thumbs-down'),
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
    <?php } else { ?>
        <div
            class="modal fade"
            id="<?= 'reviewModalArtist-'.$review->review_artist_id; ?>"
            tabindex="-1"
            role="dialog"
            aria-labelledby="reviewModalArtistLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalArtistLabel">Report Review</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-primary" role="alert">
                            As hard as we work behind the scences to make <?= Yii::$app->name; ?> a friendly place
                            we need your help. Select a reason for your report underneath and one of our admins will
                            be notified of the report.
                            <br><br>
                            Your report will also be checked against what our machine learning tools think about the
                            textual content of the review.
                            <br><br>
                            Thank you for making <?= Yii::$app->name; ?> a safer and better place!
                        </div>
                        <?php $reportForm = ActiveForm::begin([
                            'id' => 'review-report-artist-'.$review->review_artist_id,
                            'action' => ['/review/report-artist-review', 'review_artist_id' => $review->review_artist_id]
                        ]); ?>
                            <?= $reportForm->field($reviewReport, 'context')
                                ->dropDownList(ReviewReport::$contexts, ['prompt' => 'Select Reason ...']);
                            ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <?= Html::submitButton('Submit Report', ['class' => 'btn btn-primary']); ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
