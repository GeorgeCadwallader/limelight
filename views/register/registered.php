<?php

/** @var $this yii\web\View */
/** @var $user app\models\User */

$this->title = 'Registration Complete | '.Yii::$app->name;

?>

<div class="row my-5">
    <div class="col-sm-12">
        <h1 class="my-3">Thank you for registering with <?= Yii::$app->name; ?></h1>
        <p class="my-2">
            You will receive a email on "<?= $user->email; ?>" confirming your registration 
            and information on what to do next. <br><br>You will need to activate your account 
            via the email provided before you can do anything else on <?= Yii::$app->name; ?>.
        </p>
    </div>
</div>
