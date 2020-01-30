<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

// AppAsset::register($this);

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

<body class="test-class">
<?php $this->beginBody() ?>

<div class="wrap">
    <nav class="navbar navbar-expand-lg">
        <div class="navbar-inner px-2">
            <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
