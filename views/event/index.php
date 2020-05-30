<?php

/** @var $this yii\web\View */
/** @var $eventDataProvider yii\data\ActiveDataProvider*/

use app\auth\Item;
use app\helpers\Html;
use app\models\Event;

use yii\bootstrap4\Breadcrumbs;
use yii\widgets\ListView;

$this->title = 'Create and promote fantasy music events | '.Yii::$app->name;

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
    <div class="col-sm-9">
        <h1>Events</h1>
    </div>
    <div class="col-md-3 mt-3 mt-md-0 text-md-right">
        <?php if (Yii::$app->user->can(Item::ROLE_MEMBER)) { ?>
            <?= Html::a('Create Event', '/event/create', ['class' => 'btn btn-primary']); ?>
        <?php } ?>
    </div>
</div>
<div class="row my-4">
    <div class="alert alert-primary" role="alert">
        <?= Yii::$app->name; ?> events page is a place where members can create 'fantasy' events that they would like
        to see happen in real life.
        <br><br>
        To create an event you select one artist and one venue from <?= Yii::$app->name; ?>
        and a page will be automatically created for it. If you create an event that already exists this will boost the
        existing one, moving it up in the event ranking.
        <br><br>
        From here you can get informational insights into how we think this event would go. An event page will showcase
        the latest reviews of both artist and venue. Generate a tonality report of all the reviews that have been made
        for both, analysing the text content.
    </div>
</div>
<?= ListView::widget([
        'dataProvider' => $eventDataProvider,
        'pager' => Yii::$app->params['paginationConfig'],
        'itemView' => 'event-contained',
        'options' => ['class' => 'list-view row'],
        'summaryOptions' => ['class' => 'summary w-100 px-3'],
        'itemOptions' => ['class' => 'col-lg-4 my-4'],
        'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
    ]);
?>
