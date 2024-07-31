<?php
if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('/site/login');
}else if(Yii::$app->user->identity->previleges_id != 1){
    Yii::$app->response->redirect('/');
}
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

/** @var yii\web\View $this */
/** @var common\models\WebIdentity $model */

$this->title = Yii::t('app', 'Create Web Identity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Web Identities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="web-identity-index px-3">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <i class="fa-solid fa-pencil"></i> -->
                <ul class="nav">
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fas fa-edit nav-icon text-light',
                                  ]).Html::tag('span','Create',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/webidentity/create'),[
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
                                  ]), Url::to('/webidentity/draft'),[
                                      'class' => 'btn btn-sm btn-warning mx-1'
                                  ]);
                        ?>
                    </li>
                  </ul>
            </div>
            <div class="col-sm-6">
                <?php 
                    $breadcrumbLink = '';
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
        <div class="web-identity-create">

            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </section>
</div>