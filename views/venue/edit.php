<?php

use app\models\Venue;

/** @var $this yii\web\View */
/** @var $venue app\models\venue */

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Edit <?= $venue->name; ?></h1>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <?php if ($venue->status === Venue::STATUS_UNVERIFIED) { ?>
            <div class="alert alert-warning" role="alert">
                <strong>Warning:</strong> Your venue page is still being reviewed by admins,
                it will not be viewable to anyone on the site untill it becomes activated.
                You can still edit the information of your venue page below.
            </div>
        <?php } elseif ($venue->status === Venue::STATUS_ACTIVE) { ?>
            <div class="alert alert-success" role="alert">
                Your venue page is currently active, this means it will be shown to
                everyone who accesses <?= Yii::$app->name; ?>
            </div>
        <?php } ?>
    </div>
</div>
