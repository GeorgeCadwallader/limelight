<?php

/** @var $this yii\web\View */
/** @var $user app\models\User */

use app\helpers\Html;

?>

<div class="row mb-4">
    <div class="col-sm-12">
        <h1>Hi <?= $user->username; ?>!</h1>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <?php if ($user->venue === null && $user->userData->telephone === null) { ?>
            <div class="alert alert-warning" role="alert">
                <strong>Notice:</strong> to create or request ownership of your venue page
                you must first enter at least your telephone number into your user details.
                <br>
                This is for us to contact you to confirm you are representitive of the venue
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
        <?php } elseif ($user->venue === null && $user->userData->telephone !== null) { ?>
            <div class="jumbotron">
                <h2>Congratulations, you can now create your venue page!</h2>
                <p class="lead">You are now on your way to gaining the full power of <?= Yii::$app->name; ?>.</p>
                <hr class="my-4">
                <p>
                    To begin, select <strong class="text-primary">Request ownership</strong> to choose to request 
                    ownership rights of an already existing venue page. Select <strong class="text-primary">Create new venue page</strong> 
                    to create your brand new venue page.
                </p>
                <?php if ($user->request !== null) { ?>
                    <div class="alert alert-primary" role="alert">
                        Your request is currently being processed by admins
                    </div>
                <?php } else { ?>
                    <?= Html::a('Create new venue page', '/venue/create', ['class' => 'btn btn-primary']); ?>
                    <?= Html::a('Request ownership of existing venue page', '/venue/request', ['class' => 'btn btn-primary']); ?>
                <?php } ?>
            </div>
        <?php } elseif ($user->venue !== null) { ?>
            <div class="jumbotron">
                <h2>Your venue page: <strong><?= $user->venue->name; ?></strong></h2>
                <?= Html::a('View venue page', ['/venue/view', 'venue_id' => $user->venue->venue_id], ['class' => 'btn btn-primary']); ?>
                <?= Html::a('Edit venue page', ['/venue/edit', 'venue_id' => $user->venue->venue_id], ['class' => 'btn btn-primary']); ?>
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
