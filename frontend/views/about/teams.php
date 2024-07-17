<?php

use yii\helpers\Html;
use common\models\Medias;

$name = ucwords($model->first_name.' '.$model->last_name);
$description = $model->description;

?>
<div class="site-read p-0">
<?php
    echo $this->render('/layouts/layouts/head-section');
?>
<section class="py-5 px-4 bg-white">
    <div class="container">
            <div class="row row-cols-1 text-center">
                <h1 class="display-5"><?= $name ?></h1>
                <?php
                    if($countMedia != 0){
                        echo Html::tag('div', Html::img(Yii::$app->params['employeesImageLink'].'/'.$medias->media,[
                            'alt' => $name,
                            'class' => 'img-fluid',
                        ]),[
                            'class' => 'image-box',
                        ]);
                    }else{
                        echo Html::tag('div', Html::img(Yii::$app->params['publicImageLink'].'/image-1.jpg',[
                            'alt' => $name,
                            'class' => 'img-fluid',
                        ]),[
                            'class' => 'image-box',
                        ]);
                    }
                ?>
                <div class="mt-3 article"><?= $description ?></div>
            </div>
        </div>
</section>