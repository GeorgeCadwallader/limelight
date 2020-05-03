<?php

/** @var $this yii\web\View */
/** @var $venueDataProvider yii\data\ActiveDataProvider*/
/** @var $memberRequest app\models\MemberRequest */

use app\auth\Item;
use app\helpers\Html;
use app\models\MemberRequest;
use app\models\Venue;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Breadcrumbs;
use yii\widgets\ListView;

$venues = Venue::find()->where(['status' => Venue::STATUS_ACTIVE])->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Venues',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <h1>Venues</h1>
    </div>
</div>
<?php if (Yii::$app->user->can(Item::ROLE_MEMBER)) { ?>
    <div class="row my-3">
        <div class="col-sm-12">
            <div class="alert alert-primary" role="alert">
                <h5 class="font-weight-bold">
                    Don't see the venue you want to review?
                </h5>
                <p>Fill in the form below to request a venue page to be created</p>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'member-request-create',
                        'action' => ['/member-request/create', 'type' => MemberRequest::TYPE_VENUE_REQUEST],
                        'options' => ['method' => 'post']
                    ]
                ); ?>
                    <?= $form->field($memberRequest, 'request_name')->textInput(); ?>
                    <?= Html::submitButton(
                        'Submit',
                        ['class' => 'btn btn-primary']
                    ); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?php } ?>
<?= ListView::widget([
        'dataProvider' => $venueDataProvider,
        'itemView' => 'venue-contained',
        'options' => ['class' => 'list-view row'],
        'summaryOptions' => ['class' => 'summary w-100 px-3'],
        'itemOptions' => ['class' => 'col-lg-4 my-4'],
        'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
    ]);
?>
