<?php

/** @var $this yii\web\View */
/** @var $adverts app\models\Advert */

use app\widgets\YouTubeWidget;

?>

<div class="row my-100 mb-lg-5">
  <div class="col-md-3">
    <img class="img-fluid mb-3 mb-lg-0" src="images/A4.png" alt="<?= Yii::$app->name . ' - Discover Artists and Venues'; ?>">
  </div>
  <div class="col-md-9 justify-content-center flex-column d-flex">
    <div class="featured-text text-center text-md-right">
      <h2>Rate Artists on <span class="artistRating text-primary">energy</span></h2>
    </div>
  </div>
</div>
<div class="row">
  <?php foreach ($adverts as $model) { ?>
    <div class="col-md-3">
      <?= $this->render('../../advert/partials/advert-single', compact('model')); ?>
    </div>
  <?php } ?>
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
<div class="row my-100">
  <div class="col-md-9 justify-content-center flex-column d-flex">
    <div class="featured-text text-center text-md-left">
      <h2>Rate Venues on <span class="venueRating text-primary">service</span></h2>
    </div>
  </div>
  <div class="col-md-3" style="text-align: right;">
    <img class="img-fluid mb-3 mb-lg-0" src="images/A5.png" alt="<?= Yii::$app->name . ' - Read our best reviews'; ?>">
  </div>
</div>
<div class="row my-100">
  <div class="jumbotron jumbotron-fluid limelight-box-shadow rounded">
    <h2 class="display-5 font-weight-bold text-primary">Learn more about the process behind <?= Yii::$app->name; ?></h2>
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