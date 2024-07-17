<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$postDate = new DateTime($model->date);
//echo $cls_date->format('d-m-Y');
?>
<div class="py-5 px-4 bg-white">
    <div class="container">
        <div class="row row-cols-1 text-center">
            <div class="col-6 col-lg-8 text-center">
                <h1 class="display-5"><?= ucwords($this->title) ?></h1>
                <div class="tag mb-3">
                <?php
                    foreach($keywords as $keyword){
                        echo '<span class="btn btn-dark text-white rounded-3 p-2 m-1">'.$keyword.'</span>';
                    }
                ?>
                </div>
                <hr style="max-width:75%">
                <?php            
                    echo Html::tag('div',$model->description,[
                            'class' => 'mt-3 mb-2 font-italic text-center article',
                        ]);
                ?>
                <hr style="max-width:75%">
                <?php
                    echo Html::tag('div',$model->article, [
                            'class' => 'mt-3 article',
                        ]);
                ?>
            </div>
            <div class="col-6 col-lg-4 text-center">
                <div class="image-box" style="height-max:20%">
                    <?php
                    if($countMasterMedias != 0){
                        echo Html::img(Yii::$app->params['publicImageLink'].$medias['media'], [
                            'class' => 'img-circle elevation-2 img-thumbnail',
                            'style' => 'height:25%',
                            'alt' => ucwords($this->title),
                        ]);
                    }else{
                        echo Html::img(Yii::$app->params['publicImageLink'].'/image-1.webp', [
                            'class' => 'img-circle elevation-2 img-thumbnail',
                            'style' => 'height:25%',
                            'alt' => ucwords($this->title),
                        ]);
                    }
                    ?>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 text-center">
            <p>
                <?php 
                    echo Html::a('Update', ['update', 'id' => $model->id], [
                        'class' => 'btn btn-lg btn-primary',
                        'data' => [
                            'confirm' => 'Are you sure you want to update this item?',
                            'method' => 'post',],
                        ]); 
                ?>
            </p>
        </div>
    </div>
</div>