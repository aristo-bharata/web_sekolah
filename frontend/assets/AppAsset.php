<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/styles.css',
        'bootstrap/css/bootstrap.min.css',
        'fonts/fontawesome-all.min.css',
        'css/Hero-Carousel-images.css',
        'css/Navbar-Right-Links-icons.css',
        '//cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css',
    ];
    public $js = [
        'bootstrap/js/bootstrap.min.js',
        'js/bs-init.js',
        '//cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js',
        'js/Lightbox-Gallery.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
