<?php

/** @var $this yii\web\View */
/** @var $user app\models\User */

use app\helpers\Html;

?>

<div class="row mb-4">
    <div class="col-sm-12">
        <h1 class="font-weight-bold">Hi <?= $user->username; ?>!</h1>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?php if ($user->artist === null && $user->userData->telephone === null) { ?>
            <div class="alert alert-warning" role="alert">
                <strong>Notice:</strong> to create or request ownership of your artist page
                you must first enter at least your telephone number into your user details.
                <br>
                This is for us to contact you to confirm you are representitive of the artist
                you are requesting to be.
                <br>
            </div>
            <?= Html::a(
                'Click here to set your telephone number',
                [
                    '/profile/edit',
                    'user_id' => $user->user_id
                ],
                ['class' => 'btn btn-primary']
            ); ?>
        <?php } elseif ($user->artist === null && $user->userData->telephone !== null) { ?>
            <div class="rounded limelight-box-shadow p-3">
                <h2>Congratulations, you can now create your artist page!</h2>
                <p class="lead">You are now on your way to gaining the full power of <?= Yii::$app->name; ?>.</p>
                <hr class="my-4">
                <p>
                    To begin, select <strong class="text-primary">Request ownership</strong> to choose to request 
                    ownership rights of an already existing artist page. Select <strong class="text-primary">Create new artist page</strong> 
                    to create your brand new artist page.
                </p>
                <?php if ($user->request !== null) { ?>
                    <div class="alert alert-primary" role="alert">
                        Your request is currently being processed by admins
                    </div>
                <?php } else { ?>
                    <?= Html::a('Create new artist page', '/artist/create', ['class' => 'btn btn-primary']); ?>
                    <?= Html::a('Request ownership of existing artist page', '/artist/request', ['class' => 'btn btn-primary']); ?>
                <?php } ?>
            </div>
        <?php } elseif ($user->artist !== null) { ?>
            <div class="rounded limelight-box-shadow p-3">
                <h2>Your artist page: <strong><?= $user->artist->name; ?></strong></h2>
                <?= Html::a('View artist page', ['/artist/view', 'artist_id' => $user->artist->artist_id], ['class' => 'btn btn-primary']); ?>
                <?= Html::a('Edit artist page', ['/artist/edit', 'artist_id' => $user->artist->artist_id], ['class' => 'btn btn-primary']); ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-8">
        <h2>Your information</h2>
    </div>
    <div class="col-sm-4 text-sm-right">
        <?= Html::a(
            'Edit Profile',
            ['/profile/edit', 'user_id' => $user->user_id],
            ['class' => 'btn btn-primary']
        ); ?>
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm-12">
        <?= $this->render('user-information', ['userData' => $user->userData]); ?>
    </div>
</div>
