<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Breadcrumbs;

$this->title = 'FAQ | '.Yii::$app->name;

?>

<div class="row">
    <div class="col-sm-12">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => 'FAQ',
                ]
            ]
        ]); ?>
    </div>
</div>
<div class="row mb-4">
    <div class="col-sm-12">
        <h1>Frequently Asked Questions</h1>
    </div>
</div>
<div class="accordion" id="faq">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#faq-created" aria-expanded="true" aria-controls="faq-created">
                    Why was <?= Yii::$app->name; ?> created?
                </button>
            </h2>
        </div>
        <div id="faq-created" class="collapse" data-parent="#faq">
            <div class="card-body">
                <?= Yii::$app->name; ?> was created from the idea of three members of our core team. We all shared a passion for music and going
                to live events. We felt that there wasn't a substantial platform on the market for creating and reading in-depth reviews about live
                music events.
                <br><br>
                We made <?= Yii::$app->name; ?> for the general user who wants to find out in detail information about artists or venues before they
                purchase a ticket to go and see them. Reading reviews from like-minded regular people to get the full authenticity and disclosure, without
                outsider/3rd party influence.
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#faq-use" aria-expanded="true" aria-controls="faq-use">
                    How do I use <?= Yii::$app->name; ?>
                </button>
            </h2>
        </div>
        <div id="faq-use" class="collapse" data-parent="#faq">
            <div class="card-body">
            <p>How you use <?= Yii::$app->name; ?> depends on what type of user you want to be.</p>
            <h3><strong>Regular Member</strong></h3>
                <p class="pl-3">
                    This is the standard user type for <?= Yii::$app->name; ?>. Sign up as this user type to be able to create, upvote and
                    downvote reviews. Get reward for leaving more reviews with account flair and tailored information and suggestions based
                    on your preferences that we calculate for you.
                </p>
                <h3 class="mt-4"><strong>Artist/Venue Owner</strong></h3>
                <p class="pl-3">
                    This user type allows you to create your own Artist or Venue page for <?= Yii::$app->name; ?>. Start from scratch and promote
                    yourself, band or venue; or request access to an existing page on the site to take ownership of it.

                    Most Artist and Venue pages on <?= Yii::$app->name; ?> will have been created by our admins with no offical owner of the page, if
                    you find that your page has already been created, sign up and follow the steps to take over your page (This will require you to get
                    in contact with an Admin of <?= Yii::$app->name; ?>). 
                </p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#faq-information" aria-expanded="true" aria-controls="faq-information">
                    Why can I enter information about myself and how does it get used?
                </button>
            </h2>
        </div>
        <div id="faq-information" class="collapse" data-parent="#faq">
            <div class="card-body">
                <p>
                    Your information is used on <?= Yii::$app->name; ?> for the purpose of itself only. We do not share any information with any outsider/3rd party
                    companies.
                </p>
                <p>
                    We use your information to tailor your experience on <?= Yii::$app->name; ?> as much as possible. We want to know your favourite genres and vague
                    location to show you Artists and Venues that we think you will like.
                </p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#faq-analyse" aria-expanded="true" aria-controls="faq-analyse">
                    How do we analyse review content?
                </button>
            </h2>
        </div>
        <div id="faq-analyse" class="collapse" data-parent="#faq">
            <div class="card-body">
                <p>
                    After you leave a review on <?= Yii::$app->name; ?> we analyse what has been submitted meticulously, comparing it against all the other reviews
                    that the Artist or Venue has got.
                    <br><br>
                    We do not only execute analyzation on the ratings you give the Artist or Venue, we also scan the text content you write too. Because
                    <?= Yii::$app->name; ?> is all about the user centricity we want to make sure the reviews left on the website are as validated as possible.
                    <br><br>
                    We do this by using an industry standard machine learning tool from IBM to review and analyze emotion and tone in bodies of text. We use this
                    to our advantage and greatly increases our ability to give better feedback to our users.
                    <br><br>
                    If you would like to read more information on this visit the <a href="https://www.ibm.com/watson/services/tone-analyzer/" target="_blank">IBM website</a>
                </p>
            </div>
        </div>
    </div>
</div>