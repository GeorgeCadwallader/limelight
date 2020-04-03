<?php

/** @var $newReview app\models\ArtistReview */

use app\helpers\Html;

use kartik\rating\StarRating;

use yii\bootstrap4\ActiveForm;

?>

<div class="card card-body">
    <h2 class="text-primary mb-0">Create your review</h2>
    <div class="alert alert-primary alert-dismissible fade show my-4">
        We at <?= Yii::$app->name; ?> want to know what you think of this artist.
        <br><br>
        Leave a basic review by adding a paragraph about what you thought and leave
        your overall rating by leaving between 0 and 5 stars.
        <br><br>
        If you want to leave a bigger review, click the advanced button and you will
        be able to pinpoint your review into subcategories. Filling in this section will
        provide us with the ability to provide more information to our members about our
        Artists and Venues.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?= $this->render('./partials/artist-review-new', compact('newReview')); ?>
</div>
