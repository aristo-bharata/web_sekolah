<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Articles */

$this->title = 'Update Galleries: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="galleries-update px-5">
    
    <section class="content-header">
        <div clas="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
            </div>
        </div>
        
    </section>
    

    <?= $this->render('_form_contentwriter', [
        'model' => $model,
        'masterArticles' => $masterArticles,
        'masterMedias' => $masterMedias,
        'countMasterMedia' => $countMasterMedia,
        'medias' => $medias,
    ]) ?>

</div>
