<?php
if(yii::$app->user->isGuest){
    yii::$app->response->redirect('/site/login');
}

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\Employees;
use common\models\MasterEmployeesMedia;

/* @var $this yii\web\View */
/* @var $model common\models\Employees */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="employees-form">
    <?php
        $form= ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'autocomplete' => 'off'],
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
                                'readonly' => true,
                            ])->label(false);
                            echo Html::tag('div', Html::tag('div',Html::tag('span',Html::tag('i','',[
                                    'class' => 'fas fa-unlock-alt',                                
                                ]),[
                                    'class' => 'input-group-text',
                                ]),[
                                    'class' => 'input-group-prepend',
                                ]).Html::input('password', 'new_password', null, [
                                    'class' => 'form-control form-control-md bg-white text-black',
                                    'placeholder' => 'Password',
                                ]), [
                                    'class' => 'input-group mb-3',
                                ]);
                            
                            echo Html::tag('div', Html::tag('div',Html::tag('span',Html::tag('i','',[
                                    'class' => 'far fa-question-circle',                                
                                ]),[
                                    'class' => 'input-group-text',
                                ]),[
                                    'class' => 'input-group-prepend',
                                ]).Html::input('text', 'new_password-hint', null, [
                                    'class' => 'form-control form-control-md bg-white text-black',
                                    'placeholder' => 'Password Reminder',
                                ]), [
                                    'class' => 'input-group mb-3',
                                ]);
                            /*echo $form->field($user, 'password',[
                                'template' => '<div class="input-group mb-3"><div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-unlock-alt"></i>
                                </span>
                            </div>{input}{error}{hint}</div>',
                            ])->passwordInput([
                                'type' => 'password',
                                'class' => 'form-control form-control-md bg-white text-black',
                                'placeholder' => 'Password',
                            ])->label(false);

                            echo $form->field($user, 'password_hint',[
                                'template' => '<div class="input-group mb-3"><div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-question-circle"></i>
                                </span>
                            </div>{input}{error}{hint}</div>',
                            ])->textInput([
                                'type' => 'text',
                                'class' => 'form-control form-control-md bg-white text-black',
                                'placeholder' => 'Password Reminder',
                            ])->label(false);
                             * 
                             */
                            
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
                                }else{
                                    echo $medias_;
                                }

                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-lg btn-danger mr-1']) ?>
                <?php
                    echo Html::a('Cancel', Url::toRoute('/employees/contentwriter-view?id='.Yii::$app->user->identity->id),[
                        'class' => 'btn btn-lg btn-primary ml-1',
                    ]);
                ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
