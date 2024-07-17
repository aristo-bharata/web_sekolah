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
            <div class="col-12 col-lg-12">
                <div class="card card-primary bg-light">
                    <div class="card-header">
                        <h3 class="h5 card-title">Galleries Attribute</h3>
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
                                'placeholder' => 'Title',
                            ])->label(false);
                            
                            //mini_title
                            echo $form->field($model, 'mini_title', [
                                'template' => '<div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-thumbtack"></i>
                            </span>
                        </div>{input}{error}{hint}</div>',
                            ])->textInput([
                                'class' => 'form-control form-control-md bg-white text-black',
                                'placeholder' => 'Topic',
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
                                'placeholder' => 'Keywords',
                                'aria-required' => 'true',
                            ]);
                            ?>
                        
                        <div class="row">
                            <div class="col-12 col-lg-3 col-sm-6">
                            <?php
                            //date
                            echo $form->field($model, 'date', [
                                'template' => '<div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <div class="input-group-prepend" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>{input}{error}{hint}
                                </div>',
                            ])->textInput([
                                'class' => 'form-control datetimepicker-input',
                                'data-target' => '#reservationdate',
                                'placeholder'=> 'yyyy-mm-dd',
                            ]);
                            ?>
                            </div>
                            <div class="col-12 col-lg-3 col-sm-6">
                            <?php
                            //article categories
                            $articleCategories = ArrayHelper::map(ArticleCategories::find()->where(['=', 'article_types_id', '2'])->all(), 'id', 'article_category');
                            echo $form->field($masterArticles, 'article_categories_id', [
                                'template' => '<div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-clipboard-list"></i>
                                        </span>
                                    </div>{input}{error}{hint}</div>',
                                ])->dropDownList($articleCategories, [
                                    'class' => 'form-control',
                                    'prompt' => '-- Gallery Category --',
                                ]);
                            ?>
                            </div>
                            <div class="col-12 col-lg-3 col-sm-6">
                            <?php
                            $emp = Employees::find()->all();
                            $dataEmp = array();
                            foreach ($emp as $e)
                                $dataEmp[$e->id] = ucwords($e->first_name . ' ' . $e->last_name);
                            echo $form->field($masterArticles, 'employees_id', [
                                'template' => '<div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-user-circle"></i>
                                        </span>
                                    </div>{input}{error}{hint}
                                </div>',
                            ])->dropDownList($dataEmp,[
                                'class' => 'form-control',
                                'prompt' => '-- Correspondent --',
                            ]);
                            ?>
                            </div>
                            <div class="col-12 col-lg-3 col-sm-6">
                            <?php
                            //status
                            if(Yii::$app->user->identity->previleges_id == 1){
                                $articleStatus = array(1 => 'Publish', 0 => 'Draft');
                            }else if(Yii::$app->user->identity->previleges_id == 3){
                                $articleStatus = array(1 => 'Publish', 0 => 'Draft');
                                
                            }else{
                                $articleStatus = array(0 => 'Apply/Save Draft');
                            }
                            echo $form->field($model, 'position',[
                                'template' => '<div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-toggle-on"></i>
                                        </span>
                                    </div>{input}{error}{hint}
                                </div>',
                            ])->dropDownList($articleStatus,[
                                'class' => 'form-control',
                                'prompt' => '-- Article Status --',
                            ]);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card card-primary bg-light">
                    <div class="card-header">
                        <h3 class="h5 card-title">Galleries Description</h3>
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
                        ])->label(false);
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 col-sm-12 col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="h5 card-title">Picture Attachment</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            if(isset(Yii::$app->request->get()['id'])){
                                if($countMasterMedia > 0){
                                    echo Html::img(Yii::$app->params['publicImageLink'].$medias['media'],[
                                        'class' => 'card-image img-fluid'
                                    ]);
                                    echo Html::tag('div', Html::checkbox('foro_x', false, [
                                        'label' => 'Delete Image',
                                        'onclick' => 'documen.getElementById("medias-uploadmedias").disabled=this.checked;',
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
                        <div class="info-box bg-warning">
                            <span class="info-box-icon">
                                <i class="fas fa-info-circle text-black"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Format file jpg, jpeg, png. File size less then 1Mb</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $form->field($medias, 'uploadMedias')->fileInput()->label(false) ?>
                        </div>
                    </div>
                </div>
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
