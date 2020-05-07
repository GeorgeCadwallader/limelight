<?php

use app\helpers\Html;
use app\models\User;
use app\widgets\Alert;
use yii\bootstrap\ActiveForm;

/** @var $this yii\web\View */
/** @var $user app\models\User */
/** @var $registerForm app\models\forms\RegisterForm */

$this->title = 'Register';

$userCount = User::find()
    ->where(['status' => User::STATUS_ACTIVE])
    ->count();

$userCount = ceil($userCount / 5) * 5;
    
?>

<div class="row my-4">
    <div class="col-sm-12">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
</div>

<?= Alert::widget(); ?>

<?php $form = ActiveForm::begin([
    'id' => 'register-form',
]); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($user, 'username')->textInput(['autofocus' => true]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($user, 'email')->input('email'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($registerForm, 'account_type')
                        ->dropDownList(
                            $registerForm::$accountTypes,
                            ['prompt' => '-- Select User Type --']
                        ); ?>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-sm-12">
                    <?= Html::submitButton('Register', [
                        'class' => 'btn btn-primary',
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-primary" role="alert">
                <h3 class="font-weight-bold">
                    Why should you join <?= Yii::$app->name; ?>?
                </h3>
                <p class="my-3">
                    We currently have over <?= Html::tag('span', $userCount.'+', ['class' => 'font-weight-bold']); ?> members and counting!
                </p>
                <h5 class="font-weight-bold">
                    Are you a regular user?
                </h5>
                <p class="pl-3">
                    If you do not own or are a representative of an Artist or Venue then sign
                    up as a <?= Yii::$app->name; ?> Member today!
                    <br>
                    Benefits include:
                    <ul>
                        <li>Leave reviews on your favourite Artists and Venues separetely</li>
                        <li>Gain tailored suggestions of Artists and Venues from our custom algorithms</li>
                        <li>Share your thoughts and opinions with other like-minded users</li>
                    </ul>
                </p>
                <h5 class="font-weight-bold">
                    Are you an Artist or Venue owner?
                </h5>
                <p class="pl-3">
                    If you are an Artist or a representative of an Artist or Venue sign up
                    to <?= Yii::$app->name; ?> today to get a greater understanding of your
                    audience.
                    <ul>
                        <li>View member reviews left for your Artist/Venue page</li>
                        <li>Get analytical reports on your Owner page</li>
                        <li>Gain access to running adverts on our site to attract more members</li>
                    </ul>
                    <p class="pl-3">
                        If this option fits your needs then select either 'Artist Owner' or 
                        'Venue Owner' in the registration form depending on which type suits you.
                    </p>
                </p>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
