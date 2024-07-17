<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class DateConverter extends Component
{
    public function date($date)
    {
        return $this->splitDate($date);
    }
    
    private function splitDate($date)
    {
        $strSplit = explode('-',$date);
        $newString = $strSplit[2].' - '.$this->monthID($strSplit[1]).' - '.$strSplit[0];
        return $newString;
    }
    
    private function monthID($month)
    {
        $arrMonth = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'Nopember',
            '12' => 'Desember'
        );
        return $arrMonth[$month];
    }
}
