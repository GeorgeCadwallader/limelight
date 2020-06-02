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
        <h1 class="font-weight-bold">Admin panel</h1>
    </div>
</div>
<div class="row my-4 pb-5">
    <div class="col-md-6">
        <ul class="nav nav-tabs" id="adminPanel" role="tablist">
            <li class="nav-item">
                <a class="nav-link admin-link active" id="ownership-tab" data-toggle="tab" href="#ownership" role="tab" aria-controls="ownership" aria-selected="true">
                    <img src="./images/H1.png" alt="View Ownership Requests" class="img-fluid">
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
                    <img src="./images/A7.png" alt="View Member Requests" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                    <img src="./images/A8.png" alt="Contact Messages" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="report-tab" data-toggle="tab" href="#report" role="tab" aria-controls="report" aria-selected="false">
                    <img src="./images/A9.png" alt="View Site Reports" class="img-fluid">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link admin-link" id="advert-tab" data-toggle="tab" href="#advert" role="tab" aria-controls="report" aria-selected="false">
                    <img src="./images/A10.png" alt="Manage site advers" class="img-fluid">
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="tab-content" id="adminPanelContent">
            <div class="tab-pane fade show active" id="ownership" role="tabpanel" aria-labelledby="ownership-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title font-weight-bold">View Ownership requests</h2>
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
                        <h2 class="card-title font-weight-bold">Create new Admin</h2>
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
                        <h2 class="card-title font-weight-bold">Locations page</h2>
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
                        <h2 class="card-title font-weight-bold">Artists page management</h2>
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
                        <h2 class="card-title font-weight-bold">Venues page management</h2>
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
                        <h2 class="card-title font-weight-bold">Manage genres</h2>
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
                        <h2 class="card-title font-weight-bold">View member requests</h2>
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
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title font-weight-bold">View contact messages</h2>
                        <hr class="my-2">
                        <p class="card-text">
                            View and manage contact messages on <?= Yii::$app->name; ?>.
                            <br><br>
                            This displays all contact messages sent to <?= Yii::$app->name; ?> through
                            the contact us page. From here you can send messages back to the email provided,
                            and change the status of contact messages.
                        </p>
                        <?= Html::a(
                            'View Contact Messages',
                            '/admin/contact',
                            ['class' => 'btn btn-primary']
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title font-weight-bold">View review reports</h2>
                        <hr class="my-2">
                        <p class="card-text">
                            Manage review reports on <?= Yii::$app->name; ?>
                            <br><br>
                            This displays a table of all reports that have been made by users on the site.
                            From here you are able to manage and control the reviews that have been reported by
                            doing different tasks such as:
                            <ul>
                                <li>Change review statuses</li>
                                <li>View tonality reports on the review</li>
                            </ul>
                        </p>
                        <?= Html::a(
                            'Manage review reports',
                            '/admin/reports',
                            ['class' => 'btn btn-primary']
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="advert" role="tabpanel" aria-labelledby="advert-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title font-weight-bold">View and manage adverts</h2>
                        <hr class="my-2">
                        <p class="card-text">
                            Manage and view adverts on <?= Yii::$app->name; ?>
                            <br><br>
                            Displays all adverts that have been requested to have been made on <?= Yii::$app->name; ?>.
                            From here you can activate and deactivate adverts, this is where adverts are approved after they have been created.
                        </p>
                        <?= Html::a(
                            'Manage adverts',
                            '/admin/adverts',
                            ['class' => 'btn btn-primary']
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
