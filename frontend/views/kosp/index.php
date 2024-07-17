<div class="site-index p-0">
    <div class="container-fluid text-center bg-newest-article">
        <div class="row py-3">
            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
            <?php
                echo $this->render('layouts/index-section', [
                    'indexKosp' => $indexKosp,
                    'about' => $about,
                    'pagination' => $pagination,
                ]);
            ?>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <?php
                echo $this->render('layouts/right-section',[
                    'indexBeritaTerbaru' => $indexBeritaTerbaru,
                    'indexPengumuman' => $indexPengumuman,
                ]);
            ?>
            </div>
        </div>
    </div>
</div>