<?php

/**
 *
 * @var yii\web\View $this
 * @var app\models\Student $user
 */

use app\models\User;

$urlManager = Yii::$app->urlManager;
$resetLink = $urlManager->createAbsoluteUrl(['site/activate', 'token' => $user->password_reset_token]);

$timestamp = User::getTokenExpiration($user->password_reset_token, 'user.activationTokenExpire');

?>

<h1>Welcome to <?= Yii::$app->name; ?>!</h1>

<p>To log-in to your newly created account you will need this email address and a secure password</p>
<br>
<p>Please click on the following link to create your password, once this is done your account will become active.</p>
<br>
<a href="<?= $resetLink; ?>"><?= $urlManager->createAbsoluteUrl('site/activate'); ?></a>
<p>Please note if you do not set your password this link will expire by <?= date('d M Y H:i:s', $timestamp); ?></p>
