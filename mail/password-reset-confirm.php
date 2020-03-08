<?php

/**
 *
 * @var yii\web\View $this
 * @var app\models\User $user
 */

$urlManager = Yii::$app->urlManager;
$resetLink = $urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

?>

<h1>You have requested to reset your password on <?= Yii::$app->name; ?></h1>

<p>To reset your password click on the link below. From here you can fill out a form which will reset your password for you.</p>
<br>
<p>
    If you have not requested a password reset please contact an admin at
    <a href="mailto:<?= Yii::$app->params['senderEmail']; ?>">
        <?= Yii::$app->params['senderEmail']; ?>
    </a>
</p>
<br>
<a href="<?= $resetLink; ?>"><?= $urlManager->createAbsoluteUrl('site/reset-password'); ?></a>
