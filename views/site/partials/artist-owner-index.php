<?php

/** @var $this yii\web\View */
/** @var $owner app\models\User */

use app\helpers\ArtistHelper;
use app\helpers\Html;
use app\models\Artist;
use app\models\ReviewVenue;
use app\models\Venue;
use app\widgets\YouTubeWidget;
use yii\helpers\ArrayHelper;

$isManager = Artist::find()->where(['managed_by' => $owner->user_id])->exists();

$trendingVenuesSubQuery = ReviewVenue::find()
    ->select('venue_id')
    ->groupBy('venue_id')
    ->orderBy('COUNT(*) DESC')
    ->all();

$trendingVenues = Venue::find()
    ->where(['IN', 'venue_id', $trendingVenuesSubQuery])
    ->limit(6)
    ->all();

if ($isManager) {
    $artistGenres = ArrayHelper::map($owner->artist->genre, 'name', 'genre_id');

    $discoverVenues = Venue::find()
        ->joinWith('genre')
        ->where([
            'AND',
            ['IN', '{{%venue_genre}}.[[genre_id]]', $artistGenres]
        ])
        ->all();
}

?>

<div class="row">
    <div class="col-sm-12 mb-5">
        <h1 class="font-weight-bold">Welcome back <?= $owner->username; ?>!</h1>
    </div>
</div>

<div class="row my-100 limelight-box-shadow rounded py-4">
  <div class="col-md-6 col-lg-7 mb-sm-3">
    <?= YouTubeWidget::widget([
      'embedCode' => 'PRpxc6zUmwc',
      'playerParameters' => [
        'autoplay' => 1,
        'volume' => 0,
        'mute' => 1
      ],
      'iframeOptions' => [
        'width' => '100%',
        'height' => '400',
        'style' => ['border' => 'none']
      ]
    ]); ?>
  </div>


  <div class="col-md-6 col-lg-5">
    <div class="alert alert-primary" role="alert">
      <strong>Check out our brand new release trailer!</strong>
    </div>
    <h4 class="text-primary font-weight-bold">A Fair System for All</h4>
    <p class="text-black-50 mb-0">Here at <?= Yii::$app->name; ?> we discovered that Artists and Venues were rated solely on Events, we think this is an unfair way to review an individual artist or an individual venue </p>
    <br><br>
    <h4 class="text-primary font-weight-bold">High Quality Reviews</h4>
    <p class="text-black-50 mb-0">Our Upvote/Downvote system means that well constructed reviews are pushed to the top</p>
  </div>
</div>


<?php if ($isManager) { ?>
    <?php if (!empty($discoverVenues)) { ?>
        <div class="row">
            <div class="col-sm-12 mb-3">
                <h2>Venues on <?= Yii::$app->name; ?> your Artist page might like</h2>
                <small>
                    <a href="/faq" title="Find out how we calculate your interests">
                        How did we figure this out?
                    </a>
                </small>
            </div>
        </div>
        <div class="row">
            <?php foreach ($trendingVenues as $model) { ?>
                <div class="col-sm-6 col-md-4 mb-3">
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
                <div class="col-sm-6 col-md-4 mb-3">
                    <?= $this->render('/venue/venue-contained', compact('model')); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } ?>
<div class="row my-3">
  <?php foreach ($adverts as $model) { ?>
    <div class="col-md-3">
      <?= $this->render('../../advert/partials/advert-single', compact('model')); ?>
    </div>
  <?php } ?>
</div>
<div class="row">
    <div class="col-sm-12 rounded limelight-box-shadow">
        <h2 class="display-4">Learn more about the process behind <?= Yii::$app->name; ?></h2>
        <p class="lead">
            Explore our FAQ page to find out why we do the things that we do and how
            we get the best experience for our members.
        </p>
        <hr class="my-4">
        <p class="lead">
            <a class="btn btn-primary" href="/faq" role="button">Learn more</a>
        </p>
    </div>
</div>
