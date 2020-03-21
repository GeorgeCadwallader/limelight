<?php

/**
 *
 * @var yii\web\View $this
 * @var app\models\User $user
 */

$urlManager = Yii::$app->urlManager;
$resetLink = $urlManager->createAbsoluteUrl(['site/change-email', 'token' => $user->password_reset_token]);

?>

<h1>You have requested to change your email on <?= Yii::$app->name; ?></h1>

<p>To change your email click on the link below. From here the email you are reading this from will become your new email to log into <?= Yii::$app->name; ?> with.</p>
<br>
<p>
    If you have not requested an email change please contact an admin at
    <a href="mailto:<?= Yii::$app->params['senderEmail']; ?>">
        <?= Yii::$app->params['senderEmail']; ?>
    </a>
</p>
<br>
<a href="<?= $resetLink; ?>"><?= $urlManager->createAbsoluteUrl('site/change-email'); ?></a>
