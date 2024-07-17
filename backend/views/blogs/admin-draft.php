<?php
if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('/site/login');
}else if(Yii::$app->user->identity->previleges_id == 2){
    Yii::$app->response->redirect('/site/logout');
}

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;
use common\models\ArticleCategories;
use yii\db\Query;
use common\models\MasterEmployees;

$this->title= 'Draft Articles' . $q;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="articles-index px-3">
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
                                  ]), Url::to('/blogs/create'),[
                                      'class' => 'btn btn-sm btn-primary mx-1'
                                  ]);
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fab fa-firstdraft nav-icon text-light',
                                  ]).Html::tag('span','Live',[
                                      'class' => 'text-light ml-2',
                                  ]), Url::to('/blogs/admin-index'),[
                                      'class' => 'btn btn-sm btn-warning mx-1'
                                  ]);
                        ?>
                    </li>
                  </ul>
            </div>
            <div class="col-sm-6">
                <?php 
                    $breadcrumbLink = '/blogs/';
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
                                    echo Html::img(Yii::$app->params['publicImageLink'].'image-1.webp',[
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
                            <?= Html::a('View', ['view', 'id' => $article['article_id']], [
                                'class' => 'btn btn-sm btn-success']) ?>
                            <?= Html::a('Update', ['update', 'id' => $article['article_id']], [
                                'class' => 'btn btn-sm btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $article['article_id']], [
                                'class' => 'btn btn-sm btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
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