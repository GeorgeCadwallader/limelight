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




<!-- NAV BAR -->

            <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="/" style="width: 70%;">
          <img src="images/logo.png" alt="" style="height: 25%; width: 25%;">
        </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
          <?php if (Yii::$app->user->isGuest) { ?>
            <a class="nav-link js-scroll-trigger" href="/site/login">Log In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="/register">Sign Up</a>
          </li>
          <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="/profile">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="/site/logout">Logout</a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="/artist">Artists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="/venue">Venues</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>



<!-- HEADER (MAY BE MOVED TO GUEST INDEX) -->


<div id="center-heading" class="masthead" style="background-image:url(<?= Url::to('@images/banner.jpg'); ?>);">
    <div class="container">
      <div class="intro-text">
      <?php if (Yii::$app->user->isGuest) { ?>
        <div class="intro-lead-in">Welcome to <?= Yii::$app->name; ?>!</div>
        <div class="intro-heading">Rate Venues & Artists Live</div>
        <a class="btn btn-primary btn-lg btn-xl rounded text-uppercase js-scroll-trigger" href="/register">Get Started</a>
      </div>
    </div>
    <?php } ?>
          </div>
    </div> 
</div>


<!-- PAGE CONTENT -->

<div class="container my-4">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<!-- FOOTER -->


<footer id="llfooter" class="py-4 text-white-50">
    <div class="container text-center">
      <small >Copyright &copy; <?= Yii::$app->name; ?> <?= date('Y') ?> 
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
