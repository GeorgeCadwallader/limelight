<?php

use app\helpers\Html;

/** @var $this yii\web\View */
/** @var $genre app\models\Genre */

?>

<?= Html::a(
    $genre->name,
    [
        '/genre/view',
        'genre_id' => $genre->genre_id
    ],
    ['class' => 'btn btn-primary']
); ?>
