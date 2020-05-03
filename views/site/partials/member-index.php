<?php

/** @var $this yii\web\View */
/** @var $member app\models\User */

use app\models\Artist;
use app\models\Venue;

use yii\helpers\ArrayHelper;

$discoverArtistQuery = Artist::find()
    ->joinWith('genre')
    ->where([
        'OR',
        ['IN', '{{%artist_genre}}.[[genre_id]]', ArrayHelper::map($member->genre, 'name', 'genre_id')],
        ['IN', '{{%genre}}.[[parent_id]]', ArrayHelper::map($member->genre, 'name', 'genre_id')]
    ])
    ->limit(6)
    ->all();

$discoverVenueQuery = Venue::find()
    ->joinWith(['data', 'genre'])
    ->where([
        'OR',
        ['=', '{{%venue_data}}.[[county_id]]', $member->userData->county_id],
        ['IN', '{{%genre}}.[[parent_id]]', ArrayHelper::map($member->genre, 'name', 'genre_id')]
    ])
    ->limit(6)
    ->all();

?>

<div class="row mb-5">
    <div class="col-sm-12">
        <h1>Welcome back <?= $member->username; ?>!</h1>
    </div>
</div>
<?php if (!empty($discoverArtistQuery)) { ?>
    <div class="row">
        <div class="col-sm-12 mb-3">
            <h3>Here are some Artists we think you'd like</h3>
            <small>
                <a href="/faq" title="Find out how we calculate your interests">
                    How did we figure this out?
                </a>
            </small>
        </div>
    </div>
    <div class="row">
        <?php foreach ($discoverArtistQuery as $model) { ?>
            <?php 
                // $hasReviewed = ReviewArtist::find()
                //     ->where(['artist_id' => $model->artist_id])
                //     ->andWhere(['created_by' => $member->user_id])
                //     ->exists();
            ?>
            <div class="col-sm-4 mb-3">
                <?= $this->render('/artist/artist-contained', compact('model')); ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<div class="row">
    <div class="jumbotron jumbotron-fluid">
        <h2 class="display-4">Learn more about the process behind <?= Yii::$app->name; ?></h2>
        <p class="lead">
            Explore our FAQ page to find out why we do the things that we do and how
            we get the best experience for our members.
        </p>
        <hr class="my-4">
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="/faq" role="button">Learn more</a>
        </p>
    </div>
</div>
<?php if (!empty($discoverVenueQuery)) { ?>
    <div class="row mt-3">
        <div class="col-sm-12 mb-3">
            <h3>Here are some Venues we think you'd like</h3>
            <a href="/faq" title="Find out how we calculate your interests">
                How did we figure this out?
            </a>
        </div>
    </div>
    <div class="row">
        <?php foreach ($discoverVenueQuery as $model) { ?>
            <?php 
                // $hasReviewed = ReviewVenue::find()
                //     ->where(['venue_id' => $model->venue_id])
                //     ->andWhere(['created_by' => $member->user_id])
                //     ->exists();
            ?>
            <div class="col-sm-4 mb-3">
                <?= $this->render('/venue/venue-contained', compact('model')); ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>