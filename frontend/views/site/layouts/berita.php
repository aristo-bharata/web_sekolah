<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row mb-3">
    <div class="col-md-8 col-xl-6 text-center mx-auto">
        <h2>Berita Terbaru</h2>
        <hr>
    </div>
</div>
<div class="row gy-2 row-cols-1 row-cols-md-2 row-cols-xl-3">
<?php
    foreach($beritaUmum as $berita){
        $beritaTitle = ucwords($berita['title']);
        $beritaTitleLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($berita['article_categories_id']).'/read/'.$berita['articles_id'].'/'.$berita['slug']);
        $beritaDate = Yii::$app->dateconverter->date($berita['date']);
        $employeeID = $berita['employees_id'];
        $beritaAuthor = ucwords($berita['first_name'].' '.$berita['last_name']);
        $beritaAuthorLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($about).'/teams/'.$berita['employees_id'].'/'.strtolower(str_replace(' ', '-', $beritaAuthor)));
        $pTag = array("<p>", "</p>", "<br>", "&nbsp;");
        $pTagReplace = str_replace($pTag, "", $berita['article_desc']);
        $beritaDescription = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $pTagReplace);
        $pTagReplaceMediaDescription = str_replace($pTag, "", $berita['media_desc']);
        $beritaMediaDescription = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $pTagReplaceMediaDescription);
        if($berita['media'] == null){
            $image = Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
                'alt' => 'sdn2tamanbaru.sch.id property',
                'style' => "height:200px;",
                'class' => 'card-img-top w-100 d-block fit-cover',
            ]); 
        }else{
            $image = Html::img(Yii::$app->params['publicImageLink'].'/'.$berita['media'],[
                'alt' => $beritaMediaDescription,
                'style' => "height:200px;",
                'class' => 'card-img-top w-100 d-block fit-cover',
            ]);
        }
?>
    <div class="col">
        <div class="card">
        <?= $image ?>
            <div class="card-body p-3">
                <small>
                <span>
                <?php 
                    echo Html::a($beritaAuthor, $beritaAuthorLink,[
                       'class' => 'index-author', 
                    ]);
                    $beritaAuthor 
                ?>
                </span>
                <span>, </span>
                <span class="px-1"><i><?= $beritaDate ?></i></span>
                </small>
                <h2 class="h4 card-title">
                <?php 
                     echo Html::a($beritaTitle,$beritaTitleLink,[
                            'class' => 'index-title',
                         ]);
                ?>
                </h2>
                <p class="card-text"><?= $beritaDescription ?></p>
            </div>
        </div>
    </div>
<?php
    }
?>
</div>