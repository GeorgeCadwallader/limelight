<?php

/** @var $this yii\web\View */
/** @var $artistDataProvider yii\data\ActiveDataProvider*/
/** @var $memberRequest app\models\MemberRequest */

use app\auth\Item;
use app\helpers\Html;
use app\models\Artist;
use app\models\MemberRequest;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Breadcrumbs;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$artists = Artist::find()->where(['status' => Artist::STATUS_ACTIVE])->all();

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Artists',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row my-3">
    <div class="col-sm-12">
        <h1>Artists</h1>
    </div>
</div>
<?php if (Yii::$app->user->can(Item::ROLE_MEMBER)) { ?>
    <div class="row my-3">
        <div class="col-sm-12">
            <div class="alert alert-primary" role="alert">
                <h5 class="font-weight-bold">
                    Don't see the artist you want to review?
                </h5>
                <p>Fill in the form below to request an artist page to be created</p>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'member-request-create',
                        'action' => ['/member-request/create', 'type' => MemberRequest::TYPE_ARTIST_REQUEST],
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
<?php Pjax::begin(['id'=>'artistList', 'enablePushState' => true, 'timeout' => 8000]); ?>
    <?= ListView::widget([
            'dataProvider' => $artistDataProvider,
            'itemView' => 'artist-contained',
            'options' => ['class' => 'list-view row pjax-refresh-item'],
            'summaryOptions' => ['class' => 'summary w-100 px-3'],
            'itemOptions' => ['class' => 'col-lg-4 my-4'],
            'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
        ]);
    ?>
<?php Pjax::end(); ?>
