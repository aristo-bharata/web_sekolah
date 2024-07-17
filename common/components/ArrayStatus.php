<?php
namespace common\components;

use yii;
use yii\base\Component;
use common\models\Previleges;
use yii\helpers\ArrayHelper;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ArrayStatus extends Component
{
    public function arrayAgama()
    {
        $agama = array(1 => 'Islam', 2=>' Kristen Khatolik', 3 => 'Kristen Protestan', 4 => 'Hindu', 5 => 'Budha', 6 => 'Konghucu', 7 => 'Kepercayaan Lainnya');
        return $agama;
    }
    
    public function arrayStatusPernikahan()
    {
        $statusPernikahan =  array(1 => 'Belum Menikah', 2 => 'Menikah', 3 => 'Duda', 4 => 'Janda');
        return $statusPernikahan;
    }
    
    public function statusActive()
    {
        $status = array(0 => 'Tidak Aktif', 1 => 'Aktif');
        return $status;
    }
    
    public function previlEmployees($exceptPrevilegesID=null)
    {
        if($exceptPrevilegesID != NULL){
            $previlegesID = $exceptPrevilegesID;
            $previlege = ArrayHelper::map(Previleges::find()->where(['NOT IN', 'id', $previlegesID])->all(), 'id', 'previlege');
        }else{
            $previlege = ArrayHelper::map(Previleges::find()->all(),'id','previlege');
        }
        return $previlege;
    }
}