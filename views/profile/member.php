<?php

use app\helpers\Html;

$this->title = Yii::$app->name.' - '.$user->username.'\'s profile';

?>

<div class="row">
    <div class="col-sm-12">
        <h1>Hi <?= $user->username; ?>!</h1>
    </div>
</div>

<?php if ($user->userData === null) { ?>
    <div class="row">
        <div class="col-sm-12">
            <?= Html::a(
                'Edit Profile',
                ['/profile/edit', 'user_id' => $user->user_id],
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
    <?php } else { ?>
    <div class="row">
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
    <div class="row">
        <div class="col-sm-12">
            <?= $this->render('user-information', ['userData' => $user->userData]); ?>
        </div>
    </div>
<?php } ?>

