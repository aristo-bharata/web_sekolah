<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php
/*
<div class="row mb-3">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h2 class="text-center bar">
            Berita Terkait
        </h2>
        <hr class="pb-3 hr-custom">
        <div class="text-left pl-1">
        <?php
            foreach($indexBeritaTerkait as $beritaTerkait){
                $titleBeritaTerkait = $beritaTerkait['title'];
        ?>
            <div>
                <h2 class="h4"><?= $titleBeritaTerkait ?></h2>
            </div>
        <?php
            }
        ?>
        </div>
    </div>
</div>
 * 
 */
?>
<div class="row mb-3">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h2 class="text-center bar">
            Berita Terbaru
        </h2>
        <hr class="pb-3 hr-custom">
        <div class="text-left pl-1">
        <?php
            foreach($indexBeritaTerbaru as $beritaTerbaru){
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
            foreach($indexPengumuman as $pengumuman){
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