<?php

/** @var $user app\models\User */

use yii\bootstrap4\Breadcrumbs;

$this->title = Yii::$app->name.' | View '.$user->username.'\'s profile';

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'View Profile: '.$user->username,
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <h1><?= $user->username; ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <p>Add profile content</p>
    </div>
</div>
