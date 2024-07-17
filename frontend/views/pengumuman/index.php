<div class="site-index p-0">
    <div class="container-fluid text-center bg-newest-article">
        <div class="row py-3">
            <div class="col-sm-12 col-md-9 bg-newest-article">
                <?php
                    echo $this->render('layouts/index-section',[
                        'indexPengumuman' => $indexPengumuman,
                        'pagination' => $pagination,
                    ]);
                ?>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <?php
                    echo $this->render('layouts/right-section',[
                        'indexBerita' => $indexBerita,
                        'indexPengumumanTerbaru' => $indexPengumumanTerbaru,
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>