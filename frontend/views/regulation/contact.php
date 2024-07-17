<?php
use yii\helpers\Html;
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

//'articles' => $articles,
//'countMedias' => $countMedias,
//'countMedia' => $countMedia,
//'media' => $media,
//'countFile' => $countFile,
//'file' => $file,

$title = $model->title;


echo $this->render('layouts/head-section');
?>

<section class="py-5 px-4 bg-white">
    <div class="container">
        <div class="row row-cols-1 text-center">
            <h1 class="display-5"><?= $title ?></h1>
            <?php
                if($countMedia != 0){
                    echo Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].$media->media,[
                        'alt' => $media->description,
                        'class' => 'img-fluid',
                    ]),[
                        'class' => 'image-box',
                    ]);
                }else{
                    echo Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp',[
                        'alt' => $model->title,
                        'class' => 'img-fluid',
                    ]),[
                        'class' => 'image-box',
                    ]);
                }
            ?>
            <div class="mt-3 article"><?= $model->article ?></div>
        </div>
    </div>
</section>