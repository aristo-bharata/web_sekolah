<?php
if(Yii::$app->user->isGuest){
    Yii::$app->response->redirect('login');
}

use common\models\Previleges;

$id = Yii::$app->user->identity->previleges_id;
$previleges = new  Previleges();

$qry = Previleges::findOne($id);
$countNav = $previleges->find()->where(['id' => $id])->count();
if($countNav > 0){
    echo $this->render('leftmenu/'.$qry->nav_menu);
}else{
    echo 'Halaman Tidak di temukan';
}