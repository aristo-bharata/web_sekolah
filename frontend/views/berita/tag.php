<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Medias;
use yii\bootstrap4\LinkPager;

$media = new Medias();

?>

<div class="site-index p-0">
<?php
    //echo $this->render('/layouts/layouts/head-section');
?>
    <div class="container-fluid text-center bg-newest-article">
        <div class="row py-3">
            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                <h1 class="display-6 bar">Berita tentang "<i><b><?=$keys?></b></i>"</h1>
                <hr class="hr-custom">
                <div class="row pt-3">
                <?php
                    foreach ($articles as $article){
                        $title = ucwords($article['title']);
                        $miniTitle = strtoupper($article['mini_title']);
                        $niche = strtolower(str_replace(" ", "-", $miniTitle));
                        $postDate = new DateTime($article['date']);
                        $employeeID = $article['employees_id'];
                        $author = ucwords($article['first_name'].' '.$article['last_name']);
                        $linkAuthor = strtolower(str_replace(" ", "-", $author));
                        $pTag = array("<p>", "</p>", "<br>","&nbsp;");
                        $tagP_replace = str_replace($pTag, "", $article['article_desc']);
                        $description = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $tagP_replace);
                        
                        if($article['media'] == null){
                            $image = Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
                                'alt' => 'vacationurban.com property',
                                'style' => "width:75%;",
                                'class' => 'rounded',
                            ]),[
                                'class' => 'mt-2 thumbnail',
                                ]);    
                        }else{
                            $image = Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/'.$article['media'],[
                                'alt' => ucwords($article['media_desc']),
                                'style' => "width:75%;",
                                'class' => 'rounded',
                            ]),[
                                'class' => 'mt-2 thumbnail',
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
                                        echo Html::a($miniTitle, Url::to('/'.Yii::$app->articleattribute->CategoriesByID($article['article_categories_id']).'/niche/'.$niche),[
                                            'class' => 'p-3 index-mini-title',
                                            'alt' => $miniTitle,
                                        ]);
                                        //<a href="#"></a>
                                    ?>
                                    </span>
                                </div>
                                <h2 class="h4 mt-2 mb-0 card-title">
                                <?php
                                    echo Html::a($title, Url::to('/'.Yii::$app->articleattribute->CategoriesByID($article['article_categories_id']).'/read/'.$article['articles_id'].'/'.$article['slug']),[
                                        'class' => 'index-title',
                                    ]);
                                ?>
                                </h2>
                                
                                <?php
                                    echo '<small>';
                                    echo Html::tag('span', Html::a($author,Url::to('/'.Yii::$app->articleattribute->CategoriesByID($about).'/teams/'.$article['employees_id'].'/'.$linkAuthor),[
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
                                <p>
                                    <?= $description ?>
                                </p>
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
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <?php
                echo $this->render('layouts/right-section',[
                    //'indexBeritaTerkait' => $indexBeritaTerkait,
                    'indexBeritaTerbaru' => $indexBeritaTerbaru,
                    'indexPengumuman' => $indexPengumuman,
                ]);
            ?>
            </div>
        </div>
    </div>
</div>

