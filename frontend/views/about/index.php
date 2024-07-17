<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\LinkPager;
use common\models\Medias;
use common\models\MasterEmployeesMedia;

$media = new Medias();

?>
<div class="index-index p-0">
<?php
    echo $this->render('layouts/head-section');
?>
    <section class="album py-5 bg-white">
        <div class="containter">
            <div class="row row-cols-1 px-5 mb-5 text-center">
                <h1 class="display-5"><?= $model->title ?></h1>
                <div class="mt-3 article"><?= $model->article ?></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
                    <span class="display-6 bar">
                        Our Team
                    </span>
                    <hr>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
                foreach ($employees as $employee){
                    $employeeID = $employee['emp_id'];
                    $name = ucwords($employee['first_name'].' '.$employee['last_name']);
                    $employeeKey = strtolower($employee['first_name'].'-'.$employee['last_name']);
                    $description = $employee['description'];
                    $countMedia = MasterEmployeesMedia::find()->where(['employees_id' => $employeeID])->count();
                    $masterMedia = MasterEmployeesMedia::find()->where(['employees_id'=>$employeeID])->one();
                    if($countMedia != 0){
                        $image = Medias::find()->where(['id' => $masterMedia->medias_id])->one();
                    }else{
                        $image = null;
                    }
            ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                            if($countMedia != 0){
                                echo Html::img(Yii::$app->params['employeesImageLink'].'/'.$image->media, [
                                    'class' => 'card-img-top',
                                    'alt' => $name,
                                ]);
                            }else{
                               Html::img(Yii::$app->params['publicImageLink'].'/image-1.jpg', [
                                    'class' => 'card-img-top',
                                    'alt' => $name,
                                ]);
                            }
                            ?>
                        
                        <div class="card-body">
                            <h2 class="h4 mb-0 card-title title">
                                <?= Html::a($name, Yii::$app->params['homeLink'].'/about/teams/'.$employeeID.'/'.$employeeKey, [
                                    'alt' => $name,
                                ])?>
                            </h2>
                            <?= Html::tag('p', $description,[
                                'class' => 'mt-3 card-text',
                            ])?>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
            </div>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 text-center">
                <?php
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                ?>
            </div>
        </div>
    </section>
    
</div>