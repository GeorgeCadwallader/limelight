<?php

/** @var $userData app\models\UserData */

?>
<ul class="list-group">
    <li class="list-group-item">
        <strong>Username:</strong>
        <?= $userData->user->username; ?>
    </li>
    <li class="list-group-item">
        <strong>Email:</strong>
        <?= $userData->user->email; ?>
    </li>
</ul>

<ul class="list-group my-3">
    <li class="list-group-item">
        <strong>First Name:</strong>
        <?= ($userData->first_name) ? $userData->first_name : ''; ?>
    </li>
    <li class="list-group-item">
        <strong>Last Name:</strong>
        <?= ($userData->last_name) ? $userData->last_name : ''; ?>
    </li>
    <li class="list-group-item">
        <strong>Telephone:</strong>
        <?= ($userData->telephone) ? $userData->telephone : ''; ?>
    </li>
    <li class="list-group-item">
        <strong>Date of birth:</strong>
        <?= ($userData->date_of_birth) ? $userData->date_of_birth : ''; ?>
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