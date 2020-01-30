<?php

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $user app\models\User */

$this->title = 'Thank you for registering with Limelight!';

?>

<div class="site-login row align-items-center full-height justify-content-center">
    <div class="col-sm-12 text-center">
        <h1 class="font-weight-bold"><?= $this->title; ?></h1>
        <p class="mt-4 mb-3 font-weight-bold">Thank you for registering with Limelight!</p>
        <p class="font-weight-bold mb-4">You will receive a email on "<?= $user->email; ?>" confirming your registration and information on what to do next.</p>
        <a class="btn btn-secondary text-white" href="<?= Url::to('/'); ?>">RETURN TO HOMEPAGE</a>
    </div>
</div>
