<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\LinkPager;

?>

<div class="site-index p-0">
<?php
    echo $this->render('/layouts/layouts/head-section');
?>
    <div>
        <div class="container-fluid text-center py-2 bg-newest-article">
            <div class="row py-3">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 cols mb-5">
                    <h1 class="display-6 bar">Search result about <i>"<?=$tag?>"</i></h1>
                    <hr class="hr-custom">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 cols">
                    <?php 
                    foreach ($articles as $article){
                        $title = $article['title'];
                        $titleLink = Url::to('/'.Yii::$app->articleattribute->categoriesByID($article['article_categories_id']).'/read/'.$article['articles_id'].'/'.$article['slug']);
                        
                        $postDate = new DateTime($article['date']);
                        $employeeID = $article['employees_id'];
                        $author = ucwords($article['first_name'].' '.$article['last_name']);
                        $authorLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($about).'/teams/'.$article['employees_id'].'/'.strtolower(str_replace(' ', '-', $author)));
                        $miniTitle = $article['mini_title'];
                        $niche = strtolower(str_replace(" ", "-", $miniTitle));
                        $miniTitleLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($article['article_categories_id']).'/niche/'.$niche);
                        $pTag = array("<p>", "</p>", "<br>","&nbsp;");
                        $tagP_replace = str_replace($pTag, "", $article['article_desc']);
                        $description = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $tagP_replace);
                        
                        if($article['media'] == null){
                            $image = Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
                                'alt' => 'vacationurban.com property',
                                'style' => "width:50%;",
                                'class' => 'img-fluid rounded',
                            ]),[
                                'class' => 'thumbnail',
                                ]);    
                        }else{
                            $image = Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/'.$article['media'],[
                                'alt' => ucwords($article['media_desc']),
                                'style' => "width:50%;",
                                'class' => 'img-fluid rounded',
                            ]),[
                                'class' => 'thumbnail',
                                ]);
                        }
                        ?>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 col-lg-3 col-xl-2">
                            <?=$image?>
                        </div>
                        <div class="col-8 col-sm-8 col-md-8 col-lg-9 col-xl-9 mb-3">
                            <h2 class="text-start lead" style="margin:0;">
                            <?php
                                echo Html::a($title, $titleLink,[
                                    'class' => 'index-title',
                                ]);
                            ?>
                            </h2>
                            <div class="d-flex flex-row bd-highlight fst-italic">
                            <?php
                                echo '<small>';
                                echo Html::tag('span', Html::a($author, $authorLink,[
                                    'class' => 'index-author',
                                ]),[
                                    'class' => 'pr-1',
                                ]);
                                echo Html::tag('span', Html::tag('i', $postDate->format('F d, Y')),[
                                   'class' => 'pl-1',
                                ]);

                                echo '</small>';
                            ?>
                            </div>
                            <p class="text-start"><?=$description?></p>
                        </div>
                    </div>
                    <?php    
                    }
                    ?>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 cols mt-5 text-center">
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>    
                </div>
        </div>
    </div>
</div>
