<?php

use app\components\ToneAnalyzer;
use app\models\ReviewTone;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $review app\models\ReviewArtist or app\models\ReviewVenue */

$this->title = 'Tonality Report | '.Yii::$app->name;

$reviewArray[] = $review;

$tones = ToneAnalyzer::generateReportData($reviewArray);

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Admin Dashboard',
                    'url' => Url::to('/admin'),
                ],
                [
                    'label' => 'Review reports',
                    'url' => Url::to('/admin/reports')
                ],
                ['label' => 'View Tonality Report']
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Review Tonality Report</h1>
    </div>
</div>
<?php if (!empty($tones)) { ?>
    <div class="row my-4">
        <div class="col-sm-12">
            <div class="rounded limelight-box-shadow p-3">
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
<?php } else { ?>
    <div class="alert alert-primary" role="alert">
        Unfortunately this review has no tonality reports. This could be because the review is too small for the
        tonality API to generate information on.
    </div>
<?php } ?>