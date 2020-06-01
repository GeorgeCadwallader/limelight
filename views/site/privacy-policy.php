<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

$this->title = 'Privacy Policy | '.Yii::$app->name;

?>
<div class="row">
    <?= Breadcrumbs::widget([
        'links' => [
            ['label' => 'Privacy Policy']
        ]
    ]); ?>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1 style="font-weight-bold">Privacy Policy</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <p>
            <?= Yii::$app->name; ?> started with the intention of being a service that works and appeals to the general user.
            <br><br>
            Aside from basic login information (username and email) we do not require any other personal details from you, we only allow
            the option of adding more information about yourself because we use this ourselves to tailor your <?= Yii::$app->name; ?> experience
            as much as possible.
            <br><br>
            We do <strong>NOT</strong> share any of this information with 3rd parties outside of <?= Yii::$app->name; ?>.
            <br><br>
            <h2 class="my-3">Cookie usage</h2>
            At <?= Yii::$app->name; ?> we do not share your cookie information with any other parties outside of our internal organisation. The only
            cookies we use are session cookies, which allow us to figure out who is currently logged into the <?= Yii::$app->name; ?> application.
            <h2 class="my-3">Contact Us</h2>
            If you have any questions about how we carry out our practises or more check out our <a href="/faq">faq page</a> or contact us <a href="/site/contact-us">here</a>.
        </p>
    </div>
</div>