<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use app\helpers\Html;
use yii\helpers\Url;

$file = Yii::getAlias('@webroot/assets/asset-manifest-required.json');
if (is_file($file)) {
    $fileContent = json_decode(file_get_contents($file));

    foreach ($fileContent as $name => $path) {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $path = $path;
        switch ($ext) {
            case 'js':
                $this->registerJsFile($path);
                break;

            case 'css':
                $this->registerCssFile($path);
                break;
        }
    }
}

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary m-0">
    <button
        class="navbar-toggler navbar-toggler-right collapsed"
        type="button"
        data-toggle="collapse"
        data-target="#mainNavbar"
        aria-controls="mainNavbar"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="icon-bar top-bar"></span>
        <span class="icon-bar middle-bar"></span>
        <span class="icon-bar bottom-bar"></span>	
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
            <?php if (Yii::$app->user->isGuest) { ?>
                <li class="nav-item">
                    <a href="/site/login" class="nav-link">Log in</a>
                </li>
                <li class="nav-item">
                    <a href="/register" class="nav-link">Sign up</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a href="/profile" class="nav-link">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="/site/logout" class="nav-link">Log out</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
<div
    class="banner"
    style="background-image:url(<?= Url::to('@images/banner.jpg'); ?>)"
>
    <a class="banner-logo" href="<?= Yii::$app->homeUrl; ?>">
        <?= Html::img('@images/logo.png', ['class' => 'img-fluid']); ?>
    </a>
</div>
<div class="home-nav bg-white">
    <h4 class="home-nav-item m-0">
        <a href="/artist" class="text-dark">
            Artists
        </a>
    </h4>
    <h4 class="home-nav-item m-0">
        <a href="/event" class="text-dark">
            Events
        </a>
    </h4>
    <h4 class="home-nav-item m-0">
        <a href="/venue" class="text-dark">
            Venues
        </a>
    </h4>
</div>

<div class="container my-4">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>
<!-- 

<footer class="footer">
    <<div class="container-fluid">
        <p class="pull-left">&copy; Limelight</p>
    </div>

    -->
<footer id="llfooter" class="py-4 text-white-50">
    <div class="container text-center">
      <small >Copyright &copy; Limelight <?= date('Y') ?> 
    <br></br>
    </small>

      <div class="social-icons align-content-center">

        <a class="social-icon social-icon--twitter" href="https://www.facebook.com/Studiogenix" style="text-decoration: none;">
            <i class="fa fa-twitter"></i>
      <div class="tooltip">Twitter</div>
  </a>
        <a class="social-icon social-icon--instagram" href="https://www.facebook.com/Studiogenix" style="text-decoration: none;">
            <i class="fa fa-instagram"></i>
       <div class="tooltip">Instagram</div>
  </a>
        <a class="social-icon social-icon--linkedin" href="https://www.linkedin.com/company/42078791" style="text-decoration: none;">
            <i class="fa fa-linkedin"></i>
        <div class="tooltip">LinkedIn</div>
  </a>
        <a class="social-icon social-icon--facebook" href="https://www.facebook.com/Studiogenix" style="text-decoration: none;">
            <i class="fa fa-facebook"></i>
        <div class="tooltip">Facebook</div>
  </a>
</div>
    </div>
  </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
