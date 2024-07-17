<?php
use yii\helpers\Html;
use yii\helpers\Url;

if($countIndexRelatedArticles != 0){
?>
<div class="row mb-3">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h2 class="text-center bar">
            Berita Terkait
        </h2>
        <hr class="pb-3 hr-custom">
        <div class="text-left pl-1">
        <?php
            foreach($indexRelatedArticles as $beritaTerkait){
                $titleBeritaTerkait = $beritaTerkait['title'];
                $linkTitleBeritaTerkait = Html::a($titleBeritaTerkait, Url::to('/'.Yii::$app->articleattribute->CategoriesByID($beritaTerkait['article_categories_id']).'/read/'.$beritaTerkait['articles_id'].'/'.$beritaTerkait['slug']),[
                            'class' => 'index-title',
                        ]);
        ?>
            <div>
                <h2 class="h5">
                <?php
                    echo $linkTitleBeritaTerkait;
                ?>
                </h2>
            </div>
        <?php
            }
        ?>
        </div>
    </div>
</div>
<?php
}
?>
<div class="row mb-3">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h2 class="text-center bar">
            Berita Terbaru
        </h2>
        <hr class="pb-3 hr-custom">
        <div class="text-left pl-1">
        <?php
            foreach($indexBerita as $beritaTerbaru){
                $titleBeritaTerbaru = ucwords($beritaTerbaru['title']);
                $linkTitleBeritaTerbaru = Html::a($titleBeritaTerbaru, Url::to('/'.Yii::$app->articleattribute->CategoriesByID($beritaTerbaru['article_categories_id']).'/read/'.$beritaTerbaru['articles_id'].'/'.$beritaTerbaru['slug']),[
                            'class' => 'index-title',
                        ]);
        ?>
            <div>
                <h2 class="h5">
                <?php
                    echo $linkTitleBeritaTerbaru;
                ?>
                </h2>
            </div>
        <?php
            }
        ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h2 class="text-center bar">
            Pengumuman
        </h2>
        <hr class="pb-3 hr-custom">
        <div class="text-left pl-1">
        <?php
            foreach($indexPengumumanTerbaru as $pengumuman){
                $titlePengumuman = $pengumuman['title'];
                $linkPengumuman = Html::a($titlePengumuman, Url::to('/'.Yii::$app->articleattribute->CategoriesByID($pengumuman['article_categories_id']).'/read/'.$pengumuman['articles_id'].'/'.$pengumuman['slug']),[
                            'class' => 'index-title',
                        ]);
        ?>
            <div>
                <h2 class="h5">
                <?php
                    echo $linkPengumuman;
                ?>
                </h2>
            </div>
        <?php
            }
        ?>
        </div>
    </div>
</div>