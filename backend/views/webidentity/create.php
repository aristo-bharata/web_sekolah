<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\WebIdentity $model */

$this->title = Yii::t('app', 'Create Web Identity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Web Identities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="web-identity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
