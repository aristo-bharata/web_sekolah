<?php

use common\models\Webidentity;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Profil Website');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="web-identity-index px-3">

    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <i class="fa-solid fa-pencil"></i> -->
                <ul class="nav">
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fas fa-edit nav-icon text-light',
                                  ]).Html::tag('span','Create',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/webidentity/create'),[
                                      'class' => 'btn btn-sm btn-primary mx-1'
                                  ]);
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fab fa-firstdraft nav-icon text-light',
                                  ]).Html::tag('span','Draft',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/webidentity/draft'),[
                                      'class' => 'btn btn-sm btn-warning mx-1'
                                  ]);
                        ?>
                    </li>
                  </ul>
            </div>
            <div class="col-sm-6">
                <?php 
                    $breadcrumbLink = '';
                    echo $this->render('layouts/breadcrumb',[
                        'breadcrumbLink' => $breadcrumbLink,
                    ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <p class="h4">
                    <?= Html::encode($this->title) ?>
                </p>
            </div>
        </div>
        <hr>
    </section>
    <section class="content">
        <div claa="row">
            <div class="col-12">
                <div class="card">
                    <div class="row py-3 px-2">
                        <div class="col-4 col-lg-4 col-md-4">
                            <p> test image </p>
                        </div>
                        <div class="col-8 col-lg-8 col-md-8">
                            <h2> Web Name </h2>
                            <p>web tag</p>
                            <p>web description</p>
                            <hr>
                            <h3>Social Media</h3>
                            <p>fb</p>
                            <p>ig</p>
                            <p>x</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
