<?php

use yii\helpers\Html;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var common\models\Articles $model */

$this->title = 'Create Regulation';
$this->params['breadcrumbs'][] = ['label' => 'Regulation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create px-3">
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
                                  ]), Url::to('/regulation/create'),[
                                      'class' => 'btn btn-sm btn-primary mx-1'
                                  ]);
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fab fa-firstdraft nav-icon text-light',
                                  ]).Html::tag('span','Live',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/regulation/index'),[
                                      'class' => 'btn btn-sm btn-warning mx-1'
                                  ]);
                        ?>
                    </li>
                  </ul>
            </div>
            <div class="col-sm-6">
                <?php 
                    $breadcrumbLink = '/regulation/';
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
    <?= $this->render('_form', [
        'model' => $model,
        'medias' => $medias,
        'files' => $files,
        'masterArticles' => $masterArticles,
        'masterMedias' => $masterMedias,
        'masterFiles' => $masterFiles,
    ]) ?>
    </section>
</div>
