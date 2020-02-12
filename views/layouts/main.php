<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use app\helpers\Html;
use yii\widgets\Breadcrumbs;

Yii::$app->assetManager->bundles = false;

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

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <?= Html::img('@images/logo.png', ['class' => 'img-fluid']); ?>
    </a>
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#mainNavbar"
        aria-controls="mainNavbar"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
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

<div class="container-fluid my-4">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; Limelight <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
