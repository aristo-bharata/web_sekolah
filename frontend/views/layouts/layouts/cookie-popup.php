<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="cookie-banner">
    <div class="container">
        <p>
            This site uses cookies to analyze traffic and for ads measurement purposes.
            <?= Html::a('Learn more about how we use cookies', Url::home().'privacy-policy/') ?>
        </p>
    </div>
    <div class="agree"><?= Html::a('Got it !','?vacationurban-cookies',['class' => 'btn btn-warning','data'=>['method'=>'post','value' => 'vacationurban-cookies']])?></div>
</div>