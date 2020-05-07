<?php

/** @var $user app\models\User */

use app\helpers\BadgeHelper;
use app\helpers\Html;
use app\helpers\UserDataHelper;
use app\models\ReviewArtist;
use app\models\ReviewVenue;
use yii\bootstrap4\Breadcrumbs;

$this->title = Yii::$app->name.' | View '.$user->username.'\'s profile';

$artistReviews = ReviewArtist::find()
    ->where(['created_by' => $user->user_id])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(2)
    ->all();

$venueReviews = ReviewVenue::find()
    ->where(['created_by' => $user->user_id])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(2)
    ->all();

$reviews = array_merge($artistReviews, $venueReviews);

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'View Profile: '.$user->username,
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-md-4">
        <div class="profile-container p-4">
            <?= Html::img(UserDataHelper::imageUrl($user->userData), ['class' => 'img-fluid']); ?>
            <h2 class="my-3 font-weight-bold text-primary"><?= $user->username; ?></h2>
            <?php if (!empty($user->genre)) { ?>
                <h3 class="mt-4 text-dark-green font-weight-bold">
                    Favourite Genre
                </h3>
                <?= Html::a(
                    $user->genre[0]->name,
                    [
                        '/genre/view',
                        'genre_id' => $user->genre[0]->genre_id
                    ],
                    ['class' => 'btn btn-primary', 'data-pjax' => '0']
                ); ?>
            <?php } ?>
            <?php if (!empty($user->badges)) { ?>
                <h4 class="mt-4 text-primary font-weight-bold">
                    Badges
                </h4>
                <?= BadgeHelper::displayBadges($user); ?>
            <?php } ?>
            <?php if ($user->userData->county_id !== null) { ?>
                <h4 class="text-primary font-weight-bold mt-4">County</h4>
                <p class="text-dark-green font-weight-bold"><?= $user->userData->county->name; ?></p>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-8">
        <h1 class="text-primary font-weight-bold mt-3"><?= $user->username.'\'s Profile'; ?></h1>
        <?php if ($user->userData->bio !== null) { ?>
            <div class="profile-container p-3 my-5">
                <h2 class="text-primary font-weight-bold">Bio</h2>
                <div class="profile-bio">
                    <?= $user->userData->bio; ?>
                </div>
                <?= Html::button('Read More ...', ['class' => 'btn btn-sm btn-primary read-more-profile-btn mt-3']); ?>
            </div>
        <?php } ?>
        <?php if (!empty($reviews)) { ?>
            <h2 class="text-primary font-weight-bold">Recent Reviews</h2>
            <?php foreach ($reviews as $model) {
                if (isset($model->artist_id)) { ?>
                    <div class="my-4">
                        <?= $this->render('../artist/artist-review-single', compact('model')); ?>
                    </div>
                <?php } else { ?>
                    <div class="my-4">
                        <?= $this->render('../venue/venue-review-single', compact('model')); ?>
                    </div>
                <?php }
            } ?>
        <?php } ?>
    </div>
</div>
