<?php

if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('/site/login');
}else{
    if(Yii::$app->user->identity->previleges_id != 1){
        Yii::$app->response->redirect('/');
    }
}

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\MasterEmployees;

$this->title= 'Trash ' . $q;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="articles-index px-3">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= Html::encode($this->title) . ' ' . Html::a(Html::tag('i', '', ['class' => 'fas fa-plus-circle']), ['create'], ['class' => 'btn btn-success'])?>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <?= Html::a('Dashboard', Url::to('index')) ?>
                    </li>
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="content">
<?php
    foreach($articles as $article){
        $userID = new MasterEmployees();
        $userID->find(['user_id' => $article['employees_id']])->one();
?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-lg col-md-4">
                            <?php
                                if($article['media'] != null)
                                {
                                    echo Html::img(Yii::$app->params['publicImageLink'].$article['media'],[
                                        'class' => 'card-images img-fluid',
                                    ]);
                                }else{
                                    echo Html::img(Yii::$app->params['publicImageLink'].'no-pic.png',[
                                        'class' => 'img-fluid',
                                    ]);
                                }
                                ?>
                            </div>
                            <div class="col-8 col-lg-8 col-md-8">
                                <h2 class="lead">
                                    <?= ucwords($article['title']) ?>
                                </h2>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <?= ucwords($article['first_name'] . ' ' . $article['last_name'])?>
                                    </li>
                                    <li class="list-inline-item">
                                        <b><?= ucwords($article['article_category'])?></b>
                                    </li>
                                    <li class="list-inline-item">
                                        <?php
                                        $postDate = new DateTime($article['date']);
                                        echo $postDate->format('F d, Y');
                                        ?>
                                    </li>
                                </ul>
                                <p class="text-muted text-sm">
                                    <?= $article['articles_desc'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                        //if(Yii::$app->user->identity->getId() == $userID->user_id){
                    ?>
                    <div class="card-footer">
                        <div class="text-center">
                            <?= Html::a('Rollback', ['rollback', 'id' => $article['article_id']], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to restore this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                        </div>
                    </div>
                    <?php
                        //}else{
                          //  null;
                        //}
                    ?>
                </div>
            </div>
        </div>
<?php
}
?>
        <div class="row text-center">
            <div class="col-12">
                <?php
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                ?>
            </div>
        </div>
        </div>        
    </section>
</div>
