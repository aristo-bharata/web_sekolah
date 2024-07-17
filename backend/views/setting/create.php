<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Articles */

$this->title = 'Create Website Profile';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create px-3">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">   
                <p class="h4"><i class="fas fa-cog nav-icon"></i> &nbsp;
                    <?= Html::encode($this->title) ?>
                </p>
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
        <hr>
    </section>
    <section class="content">
    <?= $this->render('_form', [
        'model' => $model,
        'medias' => $medias,
        'masterArticles' => $masterArticles,
        'masterMedias' => $masterMedias,
    ]) ?>
    </section>
</div>
