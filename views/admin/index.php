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
    <div class="col-md-6">
        <ul class="nav nav-tabs" id="adminPanel" role="tablist">
            <li class="nav-item">
                <a class="nav-link admin-link active" id="ownership-tab" data-toggle="tab" href="#ownership" role="tab" aria-controls="ownership" aria-selected="true">
                    <img src="./images/A1.png" alt="View Ownership Requests" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="newAdmin-tab" data-toggle="tab" href="#newAdmin" role="tab" aria-controls="newAdmin" aria-selected="false">
                    <img src="./images/A2.png" alt="Create new Admin" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="locations-tab" data-toggle="tab" href="#locations" role="tab" aria-controls="locations" aria-selected="false">
                    <img src="./images/A3.png" alt="Manage Locations" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="artist-tab" data-toggle="tab" href="#artist" role="tab" aria-controls="artist" aria-selected="false">
                    <img src="./images/A4.png" alt="Manage Artists" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="venue-tab" data-toggle="tab" href="#venue" role="tab" aria-controls="venue" aria-selected="false">
                    <img src="./images/A5.png" alt="Manage Venues" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="genre-tab" data-toggle="tab" href="#genre" role="tab" aria-controls="genre" aria-selected="false">
                    <img src="./images/A6.png" alt="Manage Genres" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="member-tab" data-toggle="tab" href="#member" role="tab" aria-controls="member" aria-selected="false">
                    <img src="./images/A6.png" alt="View Member Requests" class="img-fluid">
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="tab-content" id="adminPanelContent">
            <div class="tab-pane fade show active" id="ownership" role="tabpanel" aria-labelledby="ownership-tab">
                <div class="card">
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
            </div>
            <div class="tab-pane fade" id="newAdmin" role="tabpanel" aria-labelledby="newAdmin-tab">
                <div class="card">
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
            </div>
            <div class="tab-pane fade" id="locations" role="tabpanel" aria-labelledby="locations-tab">
                <div class="card">
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
            </div>
            <div class="tab-pane fade" id="artist" role="tabpanel" aria-labelledby="artist-tab">
                <div class="card">
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
            </div>
            <div class="tab-pane fade" id="venue" role="tabpanel" aria-labelledby="venue-tab">
                <div class="card">
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
            <div class="tab-pane fade" id="genre" role="tabpanel" aria-labelledby="genre-tab">
                <div class=" card">
                    <div class="card-body">
                        <h2 class="card-title">Manage genres</h2>
                        <hr class="my-2">
                        <p class="card-text">
                            View and manage genres on <?= Yii::$app->name; ?>.
                            <br><br>
                            This displays all the available genres that members, artists and venues
                            can assign to their profile in order to discover related genres and attract
                            memebrs with similar genres.
                        </p>
                        <?= Html::a(
                            'View Genres',
                            '/admin/genre',
                            ['class' => 'btn btn-primary']
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="member" role="tabpanel" aria-labelledby="member-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">View member requests</h2>
                        <hr class="my-2">
                        <p class="card-text">
                            View and manage member requests on <?= Yii::$app->name; ?>.
                            <br><br>
                            This displays all current requests by members to add artists and venues to <?= Yii::$app->name; ?>
                            that do not currently exist on the site.
                        </p>
                        <?= Html::a(
                            'View Member Requests',
                            '/admin/member-requests',
                            ['class' => 'btn btn-primary']
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
