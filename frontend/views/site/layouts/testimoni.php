<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row mt-5">
    <div class="col-md-8 col-xl-6 text-center mx-auto">
        <h2>Kesan & Pesan Alumni</h2>
        <p>Berikut berbagai testimoni dari para alumni</p>
        <hr>
    </div>
</div>
<div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-lg-3">
<?php
    foreach($testimoni as $testimon){
        $testimonTitle = ucwords($testimon['title']);
        $testimonTitleLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($testimon['article_categories_id']).'/read/'.$testimon['articles_id'].'/'.$testimon['slug']);
        $testimonPTag = array("<p>", "</p>", "<br>", "&nbsp;");
        $testimonPTagReplace = str_replace($testimonPTag, "", $testimon['article_desc']);
        $testimonDescription = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $testimonPTagReplace);
        //$testimonArticle = $testimon['article'];
        if($testimon['media'] == null){
            $testimonImage = Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
                'alt' => 'sdn2tamanbaru.sch.id property',
                'style' => "width:50px;height:50px;",
                'class' => 'rounded-circle flex-shrink-0 me-3 fit-cover',
            ]); 
        }else{
            $testimonImage = Html::img(Yii::$app->params['publicImageLink'].'/'.$testimon['media'],[
                'alt' => $testimonTitle,
                'style' => "width:50px;height:50px;",
                'class' => 'rounded-circle flex-shrink-0 me-3 fit-cover',
            ]);
        }
?>
    <div class="col">
        <div>
            <p class="bg-light border rounded border-0 border-light p-4"><?= $testimonDescription ?></p>
            <div class="d-flex"><?= $testimonImage?>
                <div>
                    <p class="fw-bold text-primary mb-0"><?= $testimonTitle ?></p>
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>
</div>