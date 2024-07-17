<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row mt-3">
    <div class="col-md-12 col-xl-12 text-center mx-auto">
        <h2>Pengumuman</h2>
        <hr>
    </div>
</div>
<?php
    foreach($pengumuman as $info){
        $infoTitle = ucwords($info['title']);
        $infoTitleLink = Url::to('/'.Yii::$app->articleattribute->CategoriesByID($info['article_categories_id']).'/read/'.$info['articles_id'].'/'.$info['slug']);
        $pTag = array("<p>", "</p>", "<br>", "&nbsp;");
        $pTagReplace = str_replace($pTag, "", $info['article_desc']);
        $infoDescription = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $pTagReplace);
?>
<div class="card mt-1">
    <div class="card-header">
        <h5 class="mb-0">
            <?= $infoTitle ?>
        </h5>
    </div>
    <div class="card-body">
        <p class="card-text"><?=$infoDescription?></p>
    </div>
</div>
<?php
    }
?>
