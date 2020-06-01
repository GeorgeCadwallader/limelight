<?php

use app\components\ToneAnalyzer;
use app\helpers\VenueHelper;
use app\models\Advert;
use app\models\ReviewVenue;

use kartik\rating\StarRating;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Inflector;

/** @var $this yii\web\View */
/** @var $venue app\models\Venue */

$this->title = $venue->name.' Dasboard | '.Yii::$app->name;

$tones = ToneAnalyzer::generateReportData($venue->reviews);

$bestReviews = ReviewVenue::find()
    ->where(['venue_id' => $venue->venue_id])
    ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE])
    ->orderBy(['upvotes' => SORT_DESC])
    ->limit(3)
    ->all();

$worstReviews = ReviewVenue::find()
    ->where(['venue_id' => $venue->venue_id])
    ->andWhere(['status' => ReviewVenue::STATUS_ACTIVE])
    ->orderBy(['downvotes' => SORT_DESC])
    ->limit(3)
    ->all();

$adverts = Advert::find()
    ->where(['fk' => $venue->venue_id])
    ->andWhere(['type' => Advert::TYPE_VENUE])
    ->andWhere(['status' => Advert::STATUS_ACTIVE])
    ->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Dashboard',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1><?= $venue->name; ?> - Dashboard</h1>
    </div>
</div>
<?php if (!empty($tones)) { ?>
    <div class="row my-4">
        <div class="col-sm-12">
            <div class="rounded limelight-box-shadow p-3">
                <h2>Tonality Report</h2>
                <div class="alert alert-primary" role="alert">
                    This is a report we have generated using our machine learning tools to understand what
                    our members are saying about your Venue page.
                    <br><br>
                    The numbers in the count column represent a single review and the Tone name column is what 
                    keyword we think relates to the review content itself. To find out more about how we do this
                    visit our FAQ page <a href="/faq" title="Find out more about how we calculate tonalities">here</a>.
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>
                            Tone Name
                        </th>
                        <th>
                            Count
                        </th>
                    </tr>
                    <?php foreach ($tones as $i => $tone) { ?>
                        <tr>
                            <td>
                                <?= ucfirst($i); ?>
                            </td>
                            <td>
                                <?= $tone; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row my-4">
    <div class="col-sm-12">
        <div class="rounded limelight-box-shadow p-3">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="font-weight-bold">Rating Insights</h2>
                    <div class="alert alert-primary" role="alert">
                        Use this section to gain insights into what members think of your venue page. When
                        users submit reviews they have an option to fill in an advanced review, which allows them
                        to enter extra and more specific data.
                        <br><br>
                        For example, if the overall rating is low for <strong>sound</strong> this might be a useful
                        insight for an aspect that needs to be improved.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 d-flex flex-column justify-content-center text-center">
                    <h2>Overall Rating</h2>
                    <?= StarRating::widget([
                        'name' => 'overall-rating-'.$venue->venue_id,
                        'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_OVERALL),
                        'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                    ]); ?>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-4 col-lg-6 d-flex">
                            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SERVICE); ?></h6>
                        </div>
                        <div class="col-sm-8 col-lg-6 text-left">
                            <?= StarRating::widget([
                                'name' => 'venue-rating-'.$venue->venue_id,
                                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_SERVICE),
                                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-lg-6 d-flex">
                            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_LOCATION); ?></h6>
                        </div>
                        <div class="col-sm-8 col-lg-6 text-left">
                            <?= StarRating::widget([
                                'name' => 'venue-rating-'.$venue->venue_id,
                                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_LOCATION),
                                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-lg-6 d-flex">
                            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_VALUE); ?></h6>
                        </div>
                        <div class="col-sm-8 col-lg-6 text-left">
                            <?= StarRating::widget([
                                'name' => 'venue-rating-'.$venue->venue_id,
                                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_VALUE),
                                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-lg-6 d-flex">
                            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_CLEANLINESS); ?></h6>
                        </div>
                        <div class="col-sm-8 col-lg-6 text-left">
                            <?= StarRating::widget([
                                'name' => 'venue-rating-'.$venue->venue_id,
                                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_CLEANLINESS),
                                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-lg-6 d-flex">
                            <h6 class="m-0 d-inline-block align-self-center"><?= Inflector::humanize(ReviewVenue::REVIEW_VENUE_SIZE); ?></h6>
                        </div>
                        <div class="col-sm-8 col-lg-6 text-left">
                            <?= StarRating::widget([
                                'name' => 'venue-rating-'.$venue->venue_id,
                                'value' => VenueHelper::averageRating($venue, ReviewVenue::REVIEW_VENUE_SIZE),
                                'pluginOptions' => Yii::$app->params['reviewVenueDisplay']
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-4">
    <div class="col-lg-6">
        <div class="rounded limelight-box-shadow p-3">
            <h2>Your most popular popular reviews</h2>
            <?php foreach ($bestReviews as $model) { ?>
                <?= $this->render('../event/partials/review-venue-view', compact('model')); ?>
            <?php } ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="rounded limelight-box-shadow p-3">
            <h2>Your least popular popular reviews</h2>
            <?php foreach ($worstReviews as $model) { ?>
                <?= $this->render('../event/partials/review-venue-view', compact('model')); ?>
            <?php } ?>
        </div>
    </div>
</div>
<?php if (!empty($adverts)) { ?>
    <div class="row my-4">
        <div class="col-sm-12 mb-3">
            <h2>Your current active adverts</h2>
        </div>
        <?php foreach ($adverts as $model) { ?>
            <div class="col-sm-4">
                <?= $this->render('../advert/partials/advert-single', compact('model')); ?>
                <p class="my-3 p-2"><strong>Remaining budget: </strong><?= '£'.$model->budget; ?></p>
            </div>
        <?php } ?>
    </div>
<?php } ?>
