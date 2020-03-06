<?php

/** @var $this yii\web\View */
/** @var $venue app\models\Venue */

use app\helpers\Html;

?>

<?= Html::a(
    $venue->name,
    [
        '/venue/view',
        'venue_id' => $venue->venue_id
    ],
    ['class' => 'btn btn-primary']
); ?>
