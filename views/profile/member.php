<?php

use app\helpers\Html;

$this->title = Yii::$app->name.' - '.$user->username.'\'s profile';

?>

<h1>Hi <?= $user->username; ?>!</h1>

<?php if ($user->userData === null) {
    echo Html::a(
        'Edit Profile',
        ['/profile/edit', 'user_id' => $user->user_id],
        ['class' => 'btn btn-primary']
    );
} else {
    echo $this->render('user-information', ['user' => $user]);
    echo Html::a(
        'Edit Profile',
        ['/profile/edit', 'user_id' => $user->user_id],
        ['class' => 'btn btn-primary']
    );
} ?>
