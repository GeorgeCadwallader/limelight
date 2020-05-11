<?php

/** @var $this yii\web\View */
/** @var $event app\models\Event */

use app\components\ToneAnalyzer;
use app\helpers\EventHelper;
use app\models\ReviewArtist;
use app\models\ReviewVenue;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

$this->title = 'View '.EventHelper::eventName($event).' | '.Yii::$app->name;

$artist = $event->artist;
$venue = $event->venue;

$artistReviews = ReviewArtist::find()
    ->where(['artist_id' => $artist->artist_id])
    ->andWhere(['status' => ReviewArtist::STATUS_ACTIVE])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(5)
    ->all();

$venueReviews = ReviewVenue::find()
    ->where(['venue_id' => $venue->venue_id])
    ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(5)
    ->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Events',
                    'url' => Url::to('/event')
                ],
                ['label' => 'View: '.EventHelper::eventName($event)]
            ]
        ]); ?>
    </div>
</div>
<div class="row mt-3 mb-5">
    <div class="col-sm-12">
        <h1><?= EventHelper::eventName($event); ?></h1>
    </div>
</div>
<div class="row my-5">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="mb-3">Tonality Report</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col text-dark-green">Tone</th>
                            <th scope="col text-dark-green">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ToneAnalyzer::generateEventReport($artist, $venue) as $tone => $count) { ?>
                            <tr>
                                <td><?= ucfirst($tone); ?></td>
                                <td><?= $count; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <div class="alert alert-primary" role="alert">
                    This is a report generated of what tonalities our machine learning processes
                    have learnt from the textual content of the reviews left for this Artist and
                    Venue.
                    <br><br>
                    The tone column represents what tone was found in a review, the count column
                    indicates how many times we found this tone in this Artist and Venues reviews.
                    The higher the count of a tone means it was a feeling shared with more people.
                    <br><br>
                    To find out more about how we gather this and how we do it check out our
                    FAQ page <a class="text-primary font-weight-bold" href="/faq">here</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-5">
    <div class="col-lg-6">
        <h3>Latest <?= $artist->name; ?> reviews</h3>
        <?php foreach ($artistReviews as $model) {
            echo $this->render('./partials/review-artist-view', compact('model'));
        } ?>
    </div>
    <div class="col-lg-6">
        <h3>Latest <?= $venue->name; ?> reviews</h3>
        <?php foreach ($venueReviews as $model) {
            echo $this->render('./partials/review-venue-view', compact('model'));
        } ?>
    </div>
</div>
