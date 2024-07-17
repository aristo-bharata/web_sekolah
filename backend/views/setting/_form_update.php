<?php
if(yii::$app->user->isGuest){
    yii::$app->response->redirect('/login');
}

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ArticleCategories;
use common\models\Employees;
use yii\helpers\ArrayHelper;
use navatech\roxymce\widgets\RoxyMceWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">

    <?php 
        $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); 
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-lg-8">
                <div class="card card-primary bg-light">
                    <div class="card-header">
                        <h3 class="h5 card-title">Your Company</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            //title
                            echo $form->field($model, 'title', [
                               'template' => '<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                            </div>
                            {input}{error}{hint}
                        </div>',
                            ])->textInput([
                                'class' => 'form-control form-control-md bg-white text-black',
                                'placeholder' => 'Your Company Name',
                            ])->label(false);
                            
                            //tags
                            echo $form->field($model, 'tags',[
                                'template' => '<div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-tags"></i>
                                </span>
                            </div>{input}{error}{hint}</div>',
                            ])->textarea([
                                'class' => 'form-control form-control-md bg-white text-black',
                                'maxlength' => '255',
                                'placeholder' => 'Your Company Keywords',
                                'aria-required' => 'true',
                            ]);
                            ?>
                    </div>
                </div>
                <div class="card card-primary bg-light">
                    <div class="card-header">
                        <h3 class="h5 card-title">Your Company Description</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    <?php
                        echo $form->field($model, 'description',[
                            'template' => '{input}{error}{hint}<div class="col-xs-12 text-right">
                            <div>Less Words : <span id="maxContentPost">165</span></div>
                        </div>',
                        ])->textarea([
                            'class' => 'bg-white text-black',
                            'id' => 'company-description',
                        ])->label(false);
                    ?>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card card-primary bg-light">
                    <div class="card-header">
                        <h3 class="h5 card-title">Your Company Logo</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon">
                                <i class="fas fa-info-circle text-black"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Format file jpg, jpeg, png. Best ratio view more than or equal to <br>600 x 600 in pixels and File size less then 1Mb</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $form->field($medias, 'uploadMedias')->fileInput()->label(false) ?>
                        </div>
                        <?php
                            if(isset(Yii::$app->request->get()['id'])){
                                if($countMedias > 0){
                                    echo Html::img(Yii::$app->params['publicImageLink'].$medias['media'],[
                                        'class' => 'card-image img-fluid'
                                    ]);
                                    echo Html::tag('div', Html::checkbox('foro_x', false, [
                                        'label' => 'Delete Image',
                                        'onclick' => 'document.getElementById("medias-uploadmedias").disabled=this.checked;',
                                    ]),[
                                        'class' => 'row',
                                        'style' => 'display:block;margin-left:auto;margin-right:auto;width:50%',
                                    ]);
                                }else{
                                    echo null;
                                }
                            }
                            echo $form->field($medias, 'description',[
                                        'template' => '{input}{error}{hint}<div class="col-xs-12 text-right">
                                        <div>Less Words : <span id="maxContentPost">165</span></div>
                                    </div>',
                                    ])->textarea([
                                        'class' => 'bg-white text-black',
                                    ])->label(false);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 col-sm-12 col-md-12">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-lg btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
