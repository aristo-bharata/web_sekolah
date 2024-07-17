<?php

/** @var yii\web\View $this */
if(count($carousel) !== 0){
    echo $this->render('layouts/head-section',[
       'carousel' => $carousel,
    ]);
}
?>
<div class="container-fluid py-2">
    <div class="row mx-lg-3">
        <div class="col-md-6 col-xxl-8">
            <?php
                echo $this->render('layouts/berita',[
                    'beritaUmum' => $beritaUmum,
                    'about' => $about,
                ]);

                echo $this->render('layouts/testimoni',[
                    'testimoni' => $testimoni,
                ]);
            ?>
        </div>
        <div class="col-md-6 col-xxl-4">
            <?php
                echo $this->render('layouts/sambutan',[
                    'sambutan' => $sambutan,
                ]);

                echo $this->render('layouts/pengumuman',[
                    'pengumuman' => $pengumuman,
                ]);
            ?>
        </div>
    </div>
</div>
<?php

echo $this->render('layouts/list-galery-section',[
    'galeri' => $galeri,
]);

?>