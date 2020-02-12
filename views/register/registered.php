<?php

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $user app\models\User */

$this->title = 'Thank you for registering with '.Yii::$app->name.'!';

?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h1 class="font-weight-bold"><?= $this->title; ?></h1>
            <p class="font-weight-bold mb-4">You will receive a email on "<?= $user->email; ?>" confirming your registration and information on what to do next.</p>
            <a class="btn btn-primary text-white" href="<?= Url::to('/'); ?>">Return to homepage</a>
        </div>
    </div>
</div>
