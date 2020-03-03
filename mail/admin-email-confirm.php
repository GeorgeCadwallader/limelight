<?php

/**
 *
 * @var yii\web\View $this
 * @var app\models\User $user
 */

$urlManager = Yii::$app->urlManager;
$resetLink = $urlManager->createAbsoluteUrl(['site/activate', 'token' => $user->password_reset_token]);

?>

<h1>Welcome to <?= Yii::$app->name; ?>!</h1>

<p>You have been added as an Admin on <?= Yii::$app->name; ?></p>
<p>To log-in to your newly created account you will need this email address and a secure password</p>
<br>
<p>Please click on the following link to create your password, once this is done your account will become active.</p>
<br>
<a href="<?= $resetLink; ?>"><?= $urlManager->createAbsoluteUrl('site/activate'); ?></a>
