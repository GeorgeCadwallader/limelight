<?php

/** @var $this yii\web\View */

use app\helpers\Html;

/** @var $artist app\models\Artist */

?>

<?= Html::a(
    $artist->name,
    [
        '/artist/view',
        'artist_id' => $artist->artist_id
    ],
    ['class' => 'btn btn-primary']
); ?>
