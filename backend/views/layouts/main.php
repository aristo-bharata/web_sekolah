<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
$asset = AppAsset::register($this);
$baseUrl = $asset->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/x-icon" href="<?=Yii::$app->params['publicImageLink'].Yii::$app->webidentity->pageLogo()->media?>">
    <?php $this->head() ?>
</head>
<body class="hold-transition light-mode layout-fixed layout-navbar-fixed layout-footer-fixed h-100">
<?php 
    $this->beginBody();
    if(Yii::$app->user->isGuest){
?>
<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <!-- <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60"> -->
        <img class="animation__wobble" src="<?=Yii::$app->params['publicImageLink'].Yii::$app->webidentity->pageLogo()->media?>" alt="<?=Yii::$app->webidentity->pageLogo()->description?>" height="60" width="60">
    </div>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
<?= $this->render('footer.php', ['baseUrl' => $baseUrl]) ?>
</div>
<?php
    }else{
?>
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="<?=Yii::$app->params['publicImageLink'].Yii::$app->webidentity->pageLogo()->media?>" alt="<?=Yii::$app->webidentity->pageLogo()->description?>" width="25%">
    </div>
        <?= $this->render('header.php', ['baseUrl' => $baseUrl]) ?>
        <?= $this->render('leftMenu.php', ['baseUrl' => $baseUrl]) ?>
        <div class="content-wrapper">
        <?= $content ?> 
        </div>
        <?= $this->render('footer.php', ['baseUrl' => $baseUrl]) ?>
    </div>
<?php
    }
    $this->endBody(); 
?>
<script>  
    $(function(){
        $('#reservationdate').datetimepicker({
            format: 'Y-MM-DD',
        });
    });
    
</script>
</body>
</html>
<?php $this->endPage();
