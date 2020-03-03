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
            <h2 class="card-title">View Ownership requests</h2>
            <hr class="my-2">
            <p class="card-text">
                Manage requests for ownership of artist and venue pages on <?= Yii::$app->name; ?>.
                <br><br>
                Click here to view a table where you can view current pending requests for
                users to take ownership of existing artist and venue pages
            </p>
            <?= Html::a(
                'View ownership requests',
                '/admin/request',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
    <div class="col-sm-6 card">
        <div class="card-body">
            <h2 class="card-title">Create new Admin</h2>
            <hr class="my-2">
            <p class="card-text">
                Create a new admin to become apart of <?= Yii::$app->name; ?>.
                <br><br>
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
                <br><br>
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
    <div class="col-sm-6 card">
        <div class="card-body">
            <h2 class="card-title">Artists page management</h2>
            <hr class="my-2">
            <p class="card-text">
                View and manage artist pages on <?= Yii::$app->name; ?>.
                <br><br>
                This displays all the information on all the artist pages on the site. 
                From here you can view the details of the artist page and its owner if it
                has one. The status of an artist page can also be edited from here.
            </p>
            <?= Html::a(
                'View Artists',
                '/admin/artist',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
    <div class="col-sm-6 card">
        <div class="card-body">
            <h2 class="card-title">Venues page management</h2>
            <hr class="my-2">
            <p class="card-text">
                View and manage venue pages on <?= Yii::$app->name; ?>.
                <br><br>
                This displays all the information on all the venue pages on the site. 
                From here you can view the details of the venue page and its owner if it
                has one. The status of an venue page can also be edited from here.
            </p>
            <?= Html::a(
                'View Venues',
                '/admin/venue',
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
</div>
