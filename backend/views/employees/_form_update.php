<?php
if(yii::$app->user->isGuest){
    yii::$app->response->redirect('/site/login');
}

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Employees;
use common\models\MasterEmployeesMedia;

/* @var $this yii\web\View */
/* @var $model common\models\Employees */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="employees-form">
    <?php
        $form= ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]);
    ?>
    <div class="containter-fluid">
        <div class="row">
            <div class="col-12 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card card-primary bg-light">
                    <div class="card-header">
                        <h3 class="h5 card-title">Employee Data</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            echo $form->field($model, 'first_name',[
                                'template' => '<div class="input-group mb-3"><div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user-circle"></i>
                                </span>
                            </div>{input}{error}{hint}</div>',
                            ])->textInput([
                                'class' => 'form-control form-control-md bg-white text-black',
                                'placeholder' => 'Nama Depan',
                            ])->label(false);
                            echo $form->field($model, 'last_name',[
                                'template' => '<div class="input-group mb-3"><div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user-circle"></i>
                                </span>
                            </div>{input}{error}{hint}</div>',
                            ])->textInput([
                                'class' => 'form-control form-control-md bg-white text-black',
                                'placeholder' => 'Nama Belakang',
                            ])->label(false);
                            echo $form->field($user, 'username',[
                                'template' => '<div class="input-group mb-3"><div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-envelope"></i>
                                </span>
                            </div>{input}{error}{hint}</div>',
                            ])->textInput([
                                'type' => 'email',
                                'class' => 'form-control form-control-md bg-white text-black',
                                'placeholder' => 'Email',
                            ])->label(false);
                            
                            echo $form->field($user, 'previleges_id',[
                                'template' => '<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user-shield"></i>
                                </span>
                            </div>
                            {input}{error}{hint}
                        </div>',
                            ])->dropDownList(Yii::$app->arraystatus->previlEmployees(),[
                                'class' => 'form-control',
                                'prompt' => '- Previleges -',
                            ])->label(false);
                            
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card card-primary bg-light">
                    <div class="card-header">
                        <h3 class="h5 card-title">Employee Picture</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            if(isset(Yii::$app->request->get()['id'])){
                                if($medias_ != null){
                                    echo Html::img(Yii::$app->params['employeesImageLink'].$medias_['media'],[
                                        'class' => 'card-images img-fluid',
                                    ]);
                                    echo Html::tag('div', Html::checkbox('foto_x', false, [
                                        'label' => 'Hapus Foto',
                                        'onclick' => 'document.getElementById("medias-uploadmedias").disabled=this.checked;',
                                    ]),[
                                        'class' => 'row',
                                        'style' => 'display:block;margin-left:auto;margin-right:auto;width:50%',
                                    ]);
                                }else{
                                    echo $medias_;
                                }

                            }
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
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card card-primary bg-light">
                    <div class="card-header">
                        <h3 class="h5 card-title">Description</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            echo $form->field($model, 'description', [
                                'template' => '{input}<div class="col-xs-12 text-right"><span id="maxContentPost">&nbsp;</span></div><div>{error}{hint}</div>'
                            ])->textarea([
                                'id' => 'summernote_employee',
                                'class' => 'bg-white text-black',
                            ])->label(false);
                        ?>
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
