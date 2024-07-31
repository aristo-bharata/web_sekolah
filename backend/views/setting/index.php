<?php
if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('/site/login');
}else if(Yii::$app->user->identity->previleges_id != 1){
    Yii::$app->response->redirect('/');
}

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;
use common\models\ArticleCategories;
use yii\db\Query;
use common\models\MasterEmployees;

$this->title= 'Website Setting' . $q;
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="articles-index px-3">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">   
                <p class="h4"><i class="fas fa-cog nav-icon"></i> &nbsp;
                    <?= Html::encode($this->title) ?>
                </p>
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
        <hr>
    </section>
    <section class="content">
<?php
    if($countarticles == 0){
        echo Html::tag('p','Data belum dibuat',[
            'class' => 'h2 text-center',
        ]);
        echo Html::tag('p', Html::a('Create Record', Url::to('/setting/create')),[
            'class' => 'text-center',
            ]);
    }
    foreach($articles as $article){
?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-lg-4 col-md-4">
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
                        if(Yii::$app->user->identity->getId() == $article['employees_id']){
                    ?>
                    <div class="card-footer">
                        <div class="text-center">
                            <?php
                                echo Html::a('View', ['view', 'id' => $article['article_id']], [
                                    'class' => 'btn btn-md btn-success mr-2']);
                                echo Html::a('Update', ['update', 'id' => $article['article_id']], [
                                    'class' => 'btn btn-md btn-primary ml-2',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to update this item?',
                                        'method' => 'post',],
                                        ]);
                            ?>
                        </div>
                    </div>
                    <?php
                        }else{
                            null;
                        }
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
    </section>
</div>