<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var common\models\Articles $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$postDate = new DateTime($model->date);
?>

<div class="py-5 px-4 bg-white">
    <div class="container">
        <div class="row row-cols-1 text-center">
            <h1 class="display-5"><?= ucwords($this->title) ?></h1>
            <span class="attribute mb-3">By <a href="#"><b><?= $employees->first_name.' '.$employees->last_name?></b></a> - <i><?= $postDate->format('F d, Y')?></i></span>
            <div class="tag mb-3">
                <?php
                    foreach($keywords as $keyword){
                        echo '<span class="btn btn-dark text-white rounded-3 p-2 m-1">'.$keyword.'</span>';
                    }
                ?>
            </div>
            <hr style="max-width:50%">
            <div class="image-box">
                <?php
                    if(($countMasterMedias != 0)){
                        echo Html::img(Yii::$app->params['publicImageLink'].$medias['media'], [
                            'class' => 'img-fluid',
                            'alt' => ucwords($this->title),
                        ]);
                    }else{
                        echo Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp',[
                            'class' => 'img-fluid',
                            'alt' => ucwords($this->title),                                     ]);
                    }
                        echo Html::tag('div', $model->article, [
                            'class' => 'mt-3 article',
                        ]);
                ?>
            </div>
        </div>
    </div>
</div>
<section class="footer">
    <div class="row">
        <div class="col-12 col-lg-12 text-center">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-lg btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-lg btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
</section>
