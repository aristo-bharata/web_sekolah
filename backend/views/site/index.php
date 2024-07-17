                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'web sekolah';
?>
<div class="container-fluid px-5">

    <div class="jumbotron text-center bg-transparent">
        <?php
            echo Html::img(Yii::$app->params['publicImageLink'].Yii::$app->webidentity->pageLogo()->media,[
                    'alt' => Yii::$app->webidentity->pageLogo()->description, 
                    'class' => 'img-fluid mb-5', 
                    'style' => 'width:25%']);
        ?>
        <h1>Hi, <?= ucwords(Yii::$app->usershow->viewEmployees(Yii::$app->user->identity->id))?></h1>

        <p class="lead">Prepare snacks and drinks to accompany you to share your travel experiences by writing, enjoy it !!!</p>
    </div>
</div>
