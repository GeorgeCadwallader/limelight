<?php

/** @var $userData app\models\UserData */

use app\helpers\Html;

?>
<ul class="list-group">
    <li class="list-group-item">
        <strong>Username:</strong>
        <?= Html::encode($userData->user->username); ?>
    </li>
    <li class="list-group-item">
        <strong>Email:</strong>
        <?= Html::encode($userData->user->email); ?>
    </li>
</ul>

<ul class="list-group my-3">
    <li class="list-group-item">
        <strong>First Name:</strong>
        <?= ($userData->first_name) ? Html::encode($userData->first_name) : ''; ?>
    </li>
    <li class="list-group-item">
        <strong>Last Name:</strong>
        <?= ($userData->last_name) ? Html::encode($userData->last_name) : ''; ?>
    </li>
    <li class="list-group-item">
        <strong>Telephone:</strong>
        <?= ($userData->telephone) ? Html::encode($userData->telephone) : ''; ?>
    </li>
    <li class="list-group-item">
        <strong>Date of birth:</strong>
        <?= ($userData->date_of_birth) ? Yii::$app->formatter->asDate($userData->date_of_birth, 'php:d-M-Y') : ''; ?>
    </li>
    <li class="list-group-item">
        <strong>Location:</strong>
        <?= ($userData->county) ? $userData->county->name : ''; ?>
    </li>
</ul>

<ul class="list-group">
    <h4>Genres</h4>
    <?php foreach ($userData->user->genre as $genre) { ?>
        <li class="list-group-item">
            <strong><?= $genre->name; ?></strong>
        </li>
    <?php } ?>
</ul>