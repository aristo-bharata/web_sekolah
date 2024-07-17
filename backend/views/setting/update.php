<?php

if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('/site/login');
}

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Articles */

$this->title = 'Update Website Profile: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="articles-update px-5">

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
        <?= $this->render('_form_update', [
            'model' => $model,
            'masterMedias' => $masterMedias,
            'countMedias' => $countMedias,
            'medias' => $medias,
        ]) ?>
    </section>
</div>
