<?php

/** @var $this yii\web\View */
/** @var $venueDataProvider yii\data\ActiveDataProvider*/

use app\models\Venue;

use yii\bootstrap4\Breadcrumbs;
use yii\widgets\ListView;

$venues = Venue::find()->where(['status' => Venue::STATUS_ACTIVE])->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Venues',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <h1>Venues</h1>
    </div>
</div>
<?= ListView::widget([
        'dataProvider' => $venueDataProvider,
        'itemView' => 'venue-contained',
        'options' => ['class' => 'list-view row'],
        'summaryOptions' => ['class' => 'summary w-100 px-3'],
        'itemOptions' => ['class' => 'col-lg-4 my-4'],
        'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
    ]);
?>
