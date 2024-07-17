<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="photo-gallery py-4 py-xl-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2>Galeri Foto</h2>
                <p class="w-lg-50">Berikut Foto Rangkaian Kegiatan</p>
                <hr>
            </div>
        </div>
        <div class="row gx-2 gy-2 row-cols-1 row-cols-md-2 row-cols-xl-3 photos" data-bss-baguettebox="">
        <?php
            foreach($galeri as $galeries){
                $galeriesLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($galeries['article_categories_id']).'/read/'.$galeries['articles_id'].'/'.$galeries['slug']);
                $pTag = array("<p>", "</p>", "<br>", "&nbsp;");
                $pTagReplace = str_replace($pTag, "", $galeries['article_desc']);
                $pTagReplaceMediaDescription = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $pTagReplace);
                if($galeries['media'] == null){
                    $image = Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
                        'alt' => 'sdn2tamanbaru.sch.id property',
                        'class' => 'img-fluid',
                    ]); 
                }else{
                    $image = Html::img(Yii::$app->params['publicImageLink'].'/'.$galeries['media'],[
                        'alt' => $pTagReplaceMediaDescription,
                        'class' => 'img-fluid',
                    ]);
                }
        ?>
            <div class="col item">
            <?php
                echo Html::a($image, $galeriesLink);
            ?>
            </div>
        <?php
            }
        ?>
        </div>
    </div>
</div>