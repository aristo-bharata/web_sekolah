<?php
if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('/site/login');
}


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Employees */


$name = ucwords($model->first_name.' '.$model->last_name);
$this->title = 'Profile : '. ucwords($model->first_name.' '.$model->last_name);
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="employees-view px-3">
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
    <div class="employees-view px-3">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        User Data
                    </div>
                    <div class="card-body">
                        <h3 class="lead"><span class="icon"><i class="far fa-user-circle"></i></span> <b><?= $name ?></b></h3>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> Email: <?= $user['username'] ?></li>
                      </ul>

                    </div>
                </div>
                <div class="mt-2 text-center">
                    <?php
                        echo Html::a('Update Password', Url::to('/employees/contentwriter-changepass?id='.Yii::$app->user->identity->id),[
                            'class' => 'btn btn-lg btn-danger',
                        ])
                    ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        User Image
                    </div>
                    <div class="card-body">
                    <?php
                        if($medias_ != null){
                            echo Html::img(Yii::$app->params['employeesImageLink'].$medias_['media'],[
                                        'alt' => $medias_['media'],
                                        'class' => 'img-circle img-fluid center',
                                        'style' => 'display:block;margin-left:auto;margin-right:auto;width:50%',
                                    ]);
                        }else{
                            echo Html::img(Yii::$app->params['employeesImageLink'].'no-pic.png',[
                                        'alt' => $model->first_name.' '.$model->last_name,
                                        'class' => 'img-circle img-fluid center',
                                        'style' => 'display:block;margin-left:auto;margin-right:auto;width:50%',
                                    ]);
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        User About
                    </div>
                    <div class="card-body">
                        <?= $model->description ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>
                    <?= Html::a('Update', ['contentwriter-update', 'id' => $model->id], ['class' => 'btn btn-lg btn-primary']) ?>
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
    </div>
</div>
