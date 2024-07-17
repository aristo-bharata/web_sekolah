<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="site-error px-3 py-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    
    </p>
    <p>Please click here to 
    <?php
        echo Html::a('back to home',Url::home());
    ?>
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>
