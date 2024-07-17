<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<span class="display-6 bar">
    Related Articles
</span>
<hr>
<div class="row">
<?php
    foreach ($relatedArticles as $relatedArticle){
        $title = ucwords($relatedArticle['title']);
        $relatedTitleLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($relatedArticle['article_categories_id']).'/read/'.$relatedArticle['articles_id'].'/'.$relatedArticle['slug']);
        $relatedDescription = $relatedArticle['article_desc'];
        if($relatedArticle['media'] == null){
            $relatedArticleImage = Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
                'alt' => 'vacationurban.com property',
                'class' => 'img-fluid rounded',
            ]),[
                'class' => 'mt-2 rounded thumbnail',
                ]);    
        }else{
            $relatedArticleImage = Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/'.$relatedArticle['media'],[
                'alt' => ucwords($relatedArticle['media_desc']),
                'class' => 'img-fluid rounded',
            ]),[
                'class' => 'mt-2 rounded thumbnail',
                ]);
        }
        

?>
    <div class="col-sm-12 col-lg-6 col-md-6 col-xl-6 mb-2">
        <div class="row">
            <div class="col-sm-12 col-lg-3 col-md-3 col-xl-3">
                <?= $relatedArticleImage ?>
            </div>
            <div class="col-sm-12 col-lg-9 col-md-9 col-xl-9">
                <h2 class="h5 p-0 mb-0" style="margin-bottom: 0px; padding: 0px;">
                    <?php
                        echo Html::a($title, $relatedTitleLink,[
                            'class' => 'index-title',
                        ]);
                    ?>  
                </h2>
                <?= $relatedDescription ?>
            </div>
        </div>
    </div>
<?php
    }
?>
</div>
