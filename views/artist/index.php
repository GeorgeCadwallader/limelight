<?php

/** @var $this yii\web\View */
/** @var $artistDataProvider yii\data\ActiveDataProvider*/

use app\models\Artist;

use yii\bootstrap4\Breadcrumbs;
use yii\widgets\ListView;

$artists = Artist::find()->where(['status' => Artist::STATUS_ACTIVE])->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Artists',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <h1>Artists</h1>
    </div>
</div>
<?= ListView::widget([
        'dataProvider' => $artistDataProvider,
        'itemView' => 'artist-contained',
        'options' => ['class' => 'list-view row'],
        'summaryOptions' => ['class' => 'summary w-100 px-3'],
        'itemOptions' => ['class' => 'col-lg-4 my-4'],
        'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
    ]);
?>
