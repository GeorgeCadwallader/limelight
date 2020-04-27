<?php

/** @var $this yii\web\View */
/** @var $owner app\models\User */

use app\helpers\VenueHelper;
use app\helpers\Html;
use app\models\Artist;
use app\models\ReviewVenue;
use app\models\Venue;

use yii\helpers\ArrayHelper;

$isManager = Venue::find()->where(['managed_by' => $owner->user_id])->exists();

$trendingArtistsSubQuery = ReviewVenue::find()
    ->select('venue_id')
    ->groupBy('venue_id')
    ->orderBy('COUNT(*) DESC')
    ->all();

$trendingArtists = Venue::find()
    ->where(['IN', 'venue_id', $trendingArtistsSubQuery])
    ->limit(6)
    ->all();

if ($isManager) {
    $venueGenres = ArrayHelper::map($owner->venue->genre, 'name', 'genre_id');

    $discoverArtists = Artist::find()
        ->joinWith('genre')
        ->where([
            'AND',
            ['IN', '{{%artist_genre}}.[[genre_id]]', $venueGenres]
        ])
        ->all();
}

?>

<div class="row">
    <div class="col-sm-12 mb-5">
        <h1>Welcome back <?= $owner->username; ?>!</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mb-5">
        <div class="row">
            <div class="col-sm-12">
                <h2>Your Venue: <?= $owner->venue->name; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?= Html::img(VenueHelper::imageUrl($owner->venue), ['class' => 'img-fluid']); ?>
            </div>
            <div class="col-sm-9">
                <?= Html::a('Manage', ['/venue/edit', 'venue_id' => $owner->venue->venue_id], ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
    </div>
</div>
<?php if ($isManager) { ?>
    <?php if (!empty($discoverArtists)) { ?>
        <div class="row">
            <div class="col-sm-12 mb-3">
                <h2>Artists on <?= Yii::$app->name; ?> your Venue page might like</h2>
                <small>
                    <a href="/faq" title="Find out how we calculate your interests">
                        How did we figure this out?
                    </a>
                </small>
            </div>
        </div>
        <div class="row">
            <?php foreach ($trendingVenues as $model) { ?>
                <div class="col-sm-4 mb-3">
                    <?= $this->render('/venue/venue-contained', compact('model')); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <?php if (!empty($trendingVenues)) { ?>
        <div class="row">
            <div class="col-sm-12 mb-3">
                <h2>Trending Venues on <?= Yii::$app->name; ?></h2>
                <small>
                    <a href="/faq" title="Find out how we calculate your interests">
                        How did we figure this out?
                    </a>
                </small>
            </div>
        </div>
        <div class="row">
            <?php foreach ($trendingVenues as $model) { ?>
                <div class="col-sm-4 mb-3">
                    <?= $this->render('/venue/venue-contained', compact('model')); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
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
