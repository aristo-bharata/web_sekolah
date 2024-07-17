<?php
    //use Yii;
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<nav class="navbar navbar-light navbar-expand-lg sticky-top bg-warning bg-gradient">
    <div class="container mx-0"><a class="navbar-brand d-flex align-items-center" href="<?= Url::home() ?>">
                    <?php
                        echo Html::img(Yii::$app->params['publicImageLink'].Yii::$app->webidentity->pageLogo()->media, [
                                'height' => '50px',
                            ]);
                    ?>
                <span class="ml-2"><?= Yii::$app->webidentity->pageCompanyname()?></span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-2">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?=Url::home()?>"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="nav-item dropdown border-0 shadow-none">
                        <a class="dropdown-toggle nav-link fw-semibold shadow-none" aria-expanded="false" data-bs-toggle="dropdown" href="#">PROFIL</a>
                        <div class="dropdown-menu bg-light border-0">
                            <a class="dropdown-item fw-semibold" href="<?=$visimisi?>">VISI MISI</a>
                            <a class="dropdown-item fw-semibold" href="<?=$sejarah?>">SEJARAH SINGKAT</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link fw-semibold" aria-expanded="false" data-bs-toggle="dropdown" href="#">DIREKTORI</a>
                        <div class="dropdown-menu fw-semibold bg-light border-0">
                            <a class="dropdown-item fw-semibold" data-bs-toggle="tooltip" data-bss-tooltip="" href="<?=$ketenagaan?>" title="Direktori Guru dan Tenaga Kependidikan">GTK</a>
                            <a class="dropdown-item fw-semibold" data-bs-toggle="tooltip" data-bss-tooltip="" href="<?=$pesertaDidik?>" title="Direktori Peserta DIdik">PD</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link fw-semibold" aria-expanded="false" data-bs-toggle="dropdown" href="#">KURIKULUM</a>
                        <div class="dropdown-menu bg-light border-0">
                            <a class="dropdown-item fw-semibold" href="<?=$kosp?>">KURIKULUM OPERASIONAL SEKOLAH</a>
                            <a class="dropdown-item fw-semibold" href="<?=$kurtilas?>">KURIKULUM 2013</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link fw-semibold" aria-expanded="false" data-bs-toggle="dropdown" href="#">PROGRAM SEKOLAH</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item fw-semibold" href="<?=$ekskul?>">EKSTRA KURIKULER</a>
                            <a class="dropdown-item fw-semibold" href="<?=$pLima?>">P5</a>
                        </div>
                    </li>
                    <li class="nav-item fw-semibold"><a class="nav-link fw-semibold" href="<?=$sarpras?>">SARPRAS</a></li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link fw-semibold" aria-expanded="false" data-bs-toggle="dropdown" href="#">BERITA</a>
                        <div class="dropdown-menu bg-light border-0">
                            <a class="dropdown-item fw-semibold" href="<?=$pengumuman?>">PENGUMUMAN</a>
                            <a class="dropdown-item fw-semibold" href="<?=$berita?>">BERITA UMUM</a>
                            <a class="dropdown-item fw-semibold" href="<?=$galeri?>">GALERI</a>
                        </div>
                    </li>
                </ul><button class="btn btn-danger me-1 ms-2" type="button">PPDB</button><button class="btn btn-primary ms-1" type="button">LAPOR ALUMNI</button>
            </div>
        </div>
    </nav>