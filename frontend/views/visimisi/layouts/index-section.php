<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<h1 class="bar">Visi dan Misi Sekolah</h1>
<hr class="hr-custom">
<div class="row pt-3">
<?php
    foreach ($indexVisimisi as $berita){
        $title = ucwords($berita['title']);
        $miniTitle = strtoupper($berita['mini_title']);
        $niche = strtolower(str_replace(" ", "-", $miniTitle));
        $postDate = new DateTime($berita['date']);
        $employeeID = $berita['employees_id'];
        $author = ucwords($berita['first_name'].' '.$berita['last_name']);
        $authorLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($about).'/teams/'.$berita['employees_id'].'/'.strtolower(str_replace(" ", "-", $author)));
        $pTag = array("<p>", "</p>", "<br>","&nbsp;");
        $tagP_replace = str_replace($pTag, "", $berita['article_desc']);
        $description = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $tagP_replace);

        if($berita['media'] == null){
            $image = Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
                'alt' => 'vacationurban.com property',
                'style' => "height:200px;",
                'class' => 'card-img-top w-100 d-block fit-cover',
            ]),[
                'class' => 'thumbnail',
                ]);    
        }else{
            $image = Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/'.$berita['media'],[
                'alt' => ucwords($berita['media_desc']),
                'style' => "height:200px;",
                'class' => 'card-img-top w-100 d-block fit-cover',
            ]),[
                'class' => 'thumbnail',
                ]);
        }
?>
    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 p-3">
        <div class="card shadow-sm">
            <div><?= $image ?></div>
            <div class="card-body">
                <div class="tag">
                    <span class="btn btn-dark rounded-1 ">
                    <?php
                        echo Html::a($miniTitle, Url::to('/'.Yii::$app->articleattribute->CategoriesByID($berita['article_categories_id']).'/niche/'.$niche),[
                            'class' => 'p-3 index-mini-title',
                            'alt' => $miniTitle,
                        ]);
                        //<a href="#"></a>
                    ?>
                    </span>
                </div>
                <h2 class="h4 mt-2 mb-0 card-title">
                <?php
                    echo Html::a($title, Url::to('/'.Yii::$app->articleattribute->CategoriesByID($berita['article_categories_id']).'/read/'.$berita['articles_id'].'/'.$berita['slug']),[
                        'class' => 'index-title',
                    ]);
                ?>
                </h2>

                <?php
                    echo '<small>';
                    echo Html::tag('span', Html::a($author,$authorLink,[
                        'class' => 'index-author',
                    ]),[
                        'class' => 'pr-1',
                    ]);
                    echo Html::tag('span','-',[
                        'class' => 'px-1',
                    ]);
                    echo Html::tag('span', Html::tag('i', $postDate->format('F d, Y')),[
                        'class' => 'pl-1',
                    ]) ;
                    echo '</small>';
                ?>
                <hr>
                <p> <?=$description?></p>
            </div>
        </div>
    </div>
<?php
    }
?>
</div>
<div class="mt-2 text-center">
<?php

    echo LinkPager::widget([
        'pagination' => $pagination,
    ]);
?>    
</div>