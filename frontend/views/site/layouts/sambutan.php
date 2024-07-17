<?php

use yii\helpers\Html;
use yii\helpers\Url;

foreach($sambutan as $sambut){
    $sambutTitle = ucwords($sambut['title']);
    $sambutTitleLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($sambut['article_categories_id']).'/read/'.$sambut['articles_id'].'/'.$samnut['slug']);
    $pTag = array("<p>", "</p>", "<br>", "&nbsp;");
    $pTagReplace = str_replace($pTag, "", $sambut['article_desc']);
    $sambutDescription = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $pTagReplace);
    $pTagReplaceMediaDescription = str_replace($pTag, "", $sambut['media_desc']);
    $sambutMediaDescription = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $pTagReplaceMediaDescription);
    if($sambut['media'] == null){
        $image = Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
            'alt' => 'sdn2tamanbaru.sch.id property',
            'style' => "weight=418px;height:418px;",
            'loading' => 'lazy',
            'class' => 'img-fluid card-img-top w-100 d-block d-flex',
        ]); 
    }else{
        $image = Html::img(Yii::$app->params['publicImageLink'].'/'.$sambut['media'],[
            'alt' => $sambutMediaDescription,
            'style' => "weight=418px;height:418px;",
            'loading' => 'lazy',
            'class' => 'img-fluid card-img-top w-100 d-block d-flex',
        ]);
    }
?>

<div class="card">
    <?= $image ?>
    <div class="card-body">
        <h2 class="h4 card-title">
        <?php 
            echo Html::a($sambutTitle, $sambutTitleLink,[
                'class' => 'index-title',
            ]);
        ?>
        </h2>
        <p class="card-text"><?= $sambutDescription ?></p>
    </div>
</div>
<?php
}
?>