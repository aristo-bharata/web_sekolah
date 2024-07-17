<div class="site-index p-0">
    <div class="container-fluid bg-newest-article">
        <div class="row py-3">
            <div class="col-sm-12 col-md-9 col-xl-9">
                <?php
                    echo $this->render('layouts/content-section',[
                        'model' => $model,
                        'masterArticles' => $masterArticles,
                        'countMedias' => $countMedias,
                        'countFiles' => $countFiles,
                        'medias' => $medias,
                        'files' => $files,
                    ]);
                ?>
            </div>
            <div class="col-sm-12 col-md-3 col-xl-3">
                <?php
                    echo $this->render('layouts/right-section',[
                        'indexPengumumanTerbaru' => $indexPengumumanTerbaru,
                        'indexBerita' => $indexBerita,
                        'about' => $about,  
                        ])
                ?>
            </div>
        </div>
    </div>
</div>