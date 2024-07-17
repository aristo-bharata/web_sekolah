
<div class="site-index p-0">
<?php
    //echo $this->render('/layouts/layouts/head-section');
    //echo $this->render('/layouts/layouts/list-contents-section');
?>
    <div class="container-fluid bg-newest-article">
        <div class="row py-3">
            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                <?php
                    echo $this->render('layouts/content-section',[
                        'model' => $model,
                        'masterArticles' => $masterArticles,
                        'countMedias' => $countMedias,
                        'countFiles' => $countFiles,
                        'medias' => $medias,
                        'files' => $files,
                        'employees' => $employees,
                        'tags' => $tags,
                        'about' => $about,
                        //'berita' => $berita,
                    ]);
                ?>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <?php
                    echo $this->render('layouts/read-right-section',[
                        'indexBeritaTerbaru' => $indexBeritaTerbaru,
                        'indexPengumuman' => $indexPengumuman,
                        'countIndexRelatedArticles' => $countIndexRelatedArticles,
                        'limitIndexRelatedArticles' => $limitIndexRelatedArticles,
                        'indexRelatedArticles' => $indexRelatedArticles,
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>