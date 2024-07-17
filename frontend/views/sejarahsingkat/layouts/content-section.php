<?php
use yii\helpers\Html;
use yii\helpers\Url;

$title = ucwords($model->title);
$postDate = Yii::$app->dateconverter->date($model['date']);
$miniTitle = strtoupper($model->mini_title);
$article = $model->article;
$employee = ucwords($employees->first_name.' '.$employees->last_name);
$authorLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($about).'/teams/'.$employees->id.'/'.strtolower(str_replace(' ', '-', $employee)));
$niche = strtolower(str_replace(' ', '-', $miniTitle));
$miniTitleLink = Html::a($miniTitle, Url::to('/'.Yii::$app->articleattribute->CategoriesByID($masterArticles->article_categories_id).'/niche/'.$niche),[
    'class' => 'px-2 py-1 bg-dark text-white rounded-2 index-mini-title',
    'alt' => $miniTitle,
]); 
if($countMedias > 0){
    $img = Html::img(Yii::$app->params['publicImageLink'].$medias['media'],[
        'class' => 'img-fluid',
        'alt' => $title,
    ]);
    $imgDescription = $medias['description'];
}else{
    $img = Html::img(Yii::$app->params['publicImageLink'].'image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',[
        'class' => 'img-fluid',
        'alt' => $title,
    ]);
    $imgDescription = '';
}
?>

<div class="p-3 bg-white rounded-3">
    <div class="niche">
        <span class="btn btn-dark rounded-1 mb-2"><?= $miniTitleLink ?></span>
    </div>
    <h1 class="h2 title" style="margin:0;font-weight: 500;"><?= $title?></h1>
    <span>
        <small>
        <?php
            echo Html::a($employee, $authorLink);
        ?>
        </small>
    </span>
    <span>
        <small><b><i>,</i></b>&nbsp;<?=$postDate?></small>
    </span>

    <div class="mt-2">
    <?php
    foreach ($tags as $tag){
        $keyTag = str_replace(" ", "-", $tag);
        $tagLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($masterArticles->article_categories_id).'/tag/'.$keyTag)
    ?>
        <span class="btn btn-light mx-1 my-1 border-dark rounded-1 tag">#&nbsp;
            <?= Html::a($tag, $tagLink,[
                'class' => 'text-dark',
            ])?>
        </span>
    <?php
        }
    ?>
    </div>
    <hr>
    <picture class="p-0">
        <center><?=$img?></center>
    </picture>
    <div class="text-center mt-3"><small><?=$imgDescription?></small></div>
    <div class="article">
        <?=$article?>
    </div>
</div>
<?php
/*
<div class="px-3 bg-white rounded-3">
    <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>
 * 
 */
?>