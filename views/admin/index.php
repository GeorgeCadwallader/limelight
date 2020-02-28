<?php

use app\helpers\Html;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

/** @var $this yii\web\View */

$this->title = Yii::$app->name.' | Admin panel';

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'Admin Dashboard',
                    'url' => Url::to('/admin'),
                ],
            ]
        ]); ?>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-12">
        <h1>Admin panel</h1>
    </div>
</div>
<div class="row my-4">
    <div class="col-sm-6 card">
        <div class="card-body">
            <h2 class="card-title">Create new Admin</h2>
            <hr class="my-2">
            <p class="card-text">
                Create a new admin to become apart of <?= Yii::$app->name; ?>.
                <br>
                This is the only way to add new admins to the site
            </p>
            <?= Html::a(
                'Create new Admin',
                '/admin/admin-create',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
    <div class="col-sm-6 card">
        <div class="card-body">
            <h2 class="card-title">Locations page</h2>
            <hr class="my-2">
            <p class="card-text">
                Create new and edit existing locations for <?= Yii::$app->name; ?>.
                <br>
                Add new or edit already existing regions and counties for <?= Yii::$app->name; ?> users
                to discover more about what artists and venues are in their local area
            </p>
            <?= Html::a(
                'Regions and Counties',
                '/admin/locations',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
</div>
