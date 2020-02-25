<?php

/** @var $userData app\models\UserData */

?>
<ul class="list-group">
  <li class="list-group-item">
      <strong>First Name:</strong>
      <?= $userData->first_name; ?>
  </li>
  <li class="list-group-item">
      <strong>Last Name:</strong>
      <?= $userData->last_name; ?>
  </li>
  <li class="list-group-item">
      <strong>Date of birth:</strong>
      <?= $userData->date_of_birth; ?>
  </li>
  <li class="list-group-item">
      <strong>Location:</strong>
      <?= $userData->county->name.' - '.$userData->county->region->name; ?>
  </li>
</ul>