<?php

use app\helpers\EventHelper;

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $model app\models\Event */

?>

<a
    href="<?= Url::to(['/event/view', 'event_id' => $model->event_id]); ?>"
    class="contained-link"
>
    <div
        class="contained-image limelight-box-shadow"
        style="background-image:url(<?= EventHelper::imageUrl($model); ?>)"
    >
        <div class="contained-content">
            <div class="contained-content-inner p-3">
                <h3><?= EventHelper::eventName($model); ?></h3>
                <strong>( <?= $model->creations; ?> )</strong>
            </div>
        </div>
    </div>
</a>