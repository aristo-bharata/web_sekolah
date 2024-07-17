<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="carousel slide mt-0" data-bs-ride="carousel" id="carousel-1" style="height: 678px;">
    <div class="carousel-inner h-100">
    <?php
    $countCarousel = count($carousel);
    //echo $countCarousel;
    foreach ($carousel as $slide){
        $slideTitle = ucwords($slide['title']);
        $slideTitleLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($slide['article_categories_id']).'/read/'.$slide['articles_id'].'/'.$slide['slug']);
        $pTag = array("<p>", "</p>", "<br>", "&nbsp;");
        $pTagReplace = str_replace($pTag, "", $slide['article_desc']);
        $slideDescription = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $pTagReplace);
        if($slide['media'] == null){
            $image = Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
                'alt' => 'sdn2tamanbaru.sch.id property',
                'style' => 'z-index: -1;',
                'class' => 'w-100 d-block position-absolute h-100 fit-cover',
            ]); 
        }else{
            $image = Html::img(Yii::$app->params['publicImageLink'].'/'.$slide['media'],[
                'alt' => $slideDescription,
                'style' => 'z-index: -1;',
                'class' => 'w-100 d-block position-absolute h-100 fit-cover',
            ]);
        }
    ?>
        <div class="carousel-item active h-100">
            <?= $image ?>
            <div class="container d-flex flex-column justify-content-center h-100">
                <div class="row">
                    <div class="col-md-6 col-xl-4 offset-md-2">
                        <div style="max-width: 350px;">
                            <h1 class="text-uppercase fw-bold"><?=$slideTitle?></h1>
                            <p class="my-3"><?=$slideDescription?></p>
                            <?php
                                echo Html::a('Baca', $slideTitleLink,[
                                    'class' => 'btn btn-outline-primary btn-lg',
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    </div>
    <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span></a></div>
    <ol class="carousel-indicators">
        <?php
            for($i=0 ; $i<=$countCarousel-1 ; $i++){
        ?>
            <li data-bs-target="#carousel-1" data-bs-slide-to="<?=$i?>" class="active"></li>
        <?php
            }
        ?>
    </ol>
</div>