<?php

/** @var $this yii\web\View */
/** @var $eventDataProvider yii\data\ActiveDataProvider*/

use app\auth\Item;
use app\helpers\Html;
use app\models\Event;

use yii\bootstrap4\Breadcrumbs;
use yii\widgets\ListView;

$events = Event::find()->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Events',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-10">
        <h1>Events</h1>
    </div>
    <div class="col-sm-2">
        <?php if (Yii::$app->user->can(Item::ROLE_MEMBER)) { ?>
            <?= Html::a('Create Event', '/event/create', ['class' => 'btn btn-primary']); ?>
        <?php } ?>
    </div>
</div>
<?= ListView::widget([
        'dataProvider' => $eventDataProvider,
        'itemView' => 'event-contained',
        'options' => ['class' => 'list-view row'],
        'summaryOptions' => ['class' => 'summary w-100 px-3'],
        'itemOptions' => ['class' => 'col-lg-4 my-4'],
        'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
    ]);
?>
