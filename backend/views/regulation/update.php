<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Articles $model */

$this->title = 'Update Articles: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="articles-update px-5">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= ucwords(Html::encode($this->title)) ?></h1>
                </div>
            </div>
        </div>
    </section>

    <?= $this->render('_form', [
        'model' => $model,
        'masterArticles' => $masterArticles,
        'masterMedias' => $masterMedias,
        'masterFiles' => $masterFiles,
        'countMasterMedia' => $countMasterMedia,
        'countMasterFile' => $countMasterFile,
        'medias' => $medias,
        'files' => $files,
    ]) ?>

</div>
