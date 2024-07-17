<?php
if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('/site/login');
}else if(Yii::$app->user->identity->previleges_id != 2){
    Yii::$app->response->redirect('/');
}
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Employees */

$this->title = 'Update Employees : '.ucwords($model->first_name .' '. $model->last_name);
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employees-create px-3">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ul class="nav">
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fas fa-edit nav-icon text-light',
                                  ]).Html::tag('span','Create',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/employees/create'),[
                                      'class' => 'btn btn-sm btn-primary mx-1'
                                  ]);
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fab fa-firstdraft nav-icon text-light',
                                  ]).Html::tag('span','Setting',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/employees/'),[
                                      'class' => 'btn btn-sm btn-warning mx-1'
                                  ]);
                        ?>
                    </li>
                  </ul>
            </div>
            <div class="col-sm-6">
                <?php 
                    $breadcrumbLink = '/employees/';
                    echo $this->render('layouts/breadcrumb',[
                        'breadcrumbLink' => $breadcrumbLink,
                    ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <p class="h4">
                    <?= Html::encode($this->title) ?>
                </p>
            </div>
        </div>
        <hr>
    </section>
    <section class="content">
        <?php

        //var_dump($medias_['media']);

        echo $this->render('_form_contentwriter_update', [
            'model' => $model,
            'user' => $user,
            'medias' => $medias,
            'medias_' => $medias_,
            'masterEmployeesMedia' => $masterEmployeesMedia,
        ]);

        ?>
    </section>
</div>
