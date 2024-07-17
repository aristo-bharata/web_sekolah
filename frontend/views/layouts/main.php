<?php
if(isset($_GET['vacationurban-cookies'])){
    setcookie('vacationurban-cookies', 'true', time() + (180 * 24 * 60 * 60));
    Yii::$app->response->redirect('/');
}
/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
//use yii\bootstrap4\Html;
use yii\helpers\Html;
use yii\helpers\Url;
use dmstr\cookieconsent\widgets\CookieConsent;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/x-icon" href="<?=Yii::$app->params['publicImageLink'].Yii::$app->webidentity->pageLogo()->media?>">
    <?php $this->head() ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LJP0VDM3KY"></script>
</head>
<body class="d-flex flex-column h-100">
<?php 
/*
    $this->beginBody();
    if(!isset($_COOKIE['vacationurban-cookies'])){
        echo $this->render('layouts/cookie-popup');
    }
 * 
 */

    $visimisi = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['visimisi']).'/');
    $sejarah = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['sejarah']).'/');
    $ketenagaan = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['ketenagaan']).'/');
    $pesertaDidik = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['pesertadidik']).'/');
    $kosp = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['kosp']).'/');
    $kurtilas = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['kurtilas']).'/');
    $ekskul = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['ekskul']).'/');
    $pLima = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['p_lima']).'/');
    $pengumuman = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['pengumuman']).'/');
    $berita = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['berita']).'/');
    $sambutan = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['sambutan']).'/');
    $sarpras = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['sarpras']).'/');
    $galeri = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['galeri']).'/');
    $carousel = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['carousel']).'/');
    $testimoni = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['testimoni']).'/');
    $privacyPolicy = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['privacy_policy']).'/');
    $toc = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['toc']).'/');
    $disclaimer = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['disclaimer']).'/');
    $about = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['about']).'/');
    $contact = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($this->params['contact']).'/');
        
?>
<main role="main" class="flex-shrink-0">
    
    <?php 
        //echo $this->params['visimisi'];
        echo $this->render('layouts/header',[
                'visimisi' => $visimisi,
                'sejarah' => $sejarah,
                'ketenagaan' => $ketenagaan,
                'pesertaDidik' => $pesertaDidik,
                'kosp' => $kosp,
                'kurtilas' => $kurtilas,
                'ekskul' => $ekskul,
                'pLima' => $pLima,
                'pengumuman' => $pengumuman,
                'berita' => $berita,
                'sambutan' => $sambutan,
                'sarpras' => $sarpras,
                'galeri' => $galeri,
                'carousel' => $carousel,
                'testimoni' => $testimoni,
                'privacyPolicy' => $privacyPolicy,
                'toc' => $toc,
                'disclaimer' => $disclaimer,
                'about' => $about,
                'contact' => $contact,
            ]); 
    ?>
    <?= $content ?>
    <?php 
        echo $this->render('layouts/footer',[
                'visimisi' => $visimisi,
                'sejarah' => $sejarah,
                'ketenagaan' => $ketenagaan,
                'pesertaDidik' => $pesertaDidik,
                'kosp' => $kosp,
                'kurtilas' => $kurtilas,
                'ekskul' => $ekskul,
                'pLima' => $pLima,
                'pengumuman' => $pengumuman,
                'berita' => $berita,
                'sambutan' => $sambutan,
                'sarpras' => $sarpras,
                'galeri' => $galeri,
                'carousel' => $carousel,
                'testimoni' => $testimoni,
                'privacyPolicy' => $privacyPolicy,
                'toc' => $toc,
                'disclaimer' => $disclaimer,
                'about' => $about,
                'contact' => $contact,
            ]); 
    ?>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
