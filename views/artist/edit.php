<?php

use app\models\Artist;

/** @var $this yii\web\View */
/** @var $artist app\models\Artist */

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Edit <?= $artist->name; ?></h1>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <?php if ($artist->status === Artist::STATUS_UNVERIFIED) { ?>
            <div class="alert alert-warning" role="alert">
                <strong>Warning:</strong> Your artist page is still being reviewed by admins,
                it will not be viewable to anyone on the site untill it becomes activated.
                You can still edit the information of your artist page below.
            </div>
        <?php } elseif ($artist->status === Artist::STATUS_ACTIVE) { ?>
            <div class="alert alert-success" role="alert">
                Your artist page is currently active, this means it will be shown to
                everyone who accesses <?= Yii::$app->name; ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        
    </div>
</div>