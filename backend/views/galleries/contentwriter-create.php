<?php
if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('/site/login');
}else if(Yii::$app->user->identity->previleges_id != 2 ){
    Yii::$app->response->redirect('/');
}
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Articles */

$this->title = 'Create Galleries';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="galleries-create px-3">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <i class="fa-solid fa-pencil"></i> -->
                <ul class="nav">
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fas fa-edit nav-icon text-light',
                                  ]).Html::tag('span','Live',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/galleries/contentwriter-index'),[
                                      'class' => 'btn btn-sm btn-primary mx-1'
                                  ]);
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fab fa-firstdraft nav-icon text-light',
                                  ]).Html::tag('span','Draft',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/galleries/contentwriter-draft'),[
                                      'class' => 'btn btn-sm btn-warning mx-1'
                                  ]);
                        ?>
                    </li>
                  </ul>
            </div>
            <div class="col-sm-6">
                <?php 
                    $breadcrumbLink = '/galleries/';
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
    <?= $this->render('_form_contentwriter', [
        'model' => $model,
        'medias' => $medias,
        'masterArticles' => $masterArticles,
        'masterMedias' => $masterMedias,
    ]) ?>
    </section>
</div>
