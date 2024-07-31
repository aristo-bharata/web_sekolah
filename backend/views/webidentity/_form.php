<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\WebIdentity $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="web-identity-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); 
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-lg-8">
                <?php
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
                
                    echo $form->field($model, 'description',[
                        'template' => '{input}{error}{hint}<div class="col-xs-12 text-right">
                        <div>Less Words : <span id="maxContentPost">165</span></div>
                    </div>',
                    ])->textarea([
                        'class' => 'bg-white text-black',
                        'id' => 'company-description',
                    ])->label(false);
                ?>
                <?php //$form->field($model, 'description')->textarea(['rows' => 6]) ?>
            </div>
        </div>
    </div>   

    <div class="form-group">
        
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
