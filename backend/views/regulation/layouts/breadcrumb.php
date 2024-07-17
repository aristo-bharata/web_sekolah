<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>


<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item">
        <?= Html::a('Dashboard', Url::home()) ?>
    </li>
    <li class="breadcrumb-item active">
        <?= Html::a(Html::tag('i','',[
                'class' => 'fa fa-home pr-1',
                'aria-hidden' => 'true',
                ]) . 'Home', Url::to($breadcrumbLink));
        ?>
    </li>
</ol>