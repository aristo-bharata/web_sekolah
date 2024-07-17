<?php
namespace common\components;

use yii\base\Component;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FileExtension extends Component
{
    public function fileExtensions($fileExtension) 
    {
        return $this->extensionLib($fileExtension);
    }
    
    protected function extensionLib($fileExtension) 
    {
       $arrExtension = array(
           'pdf' => '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
           'docx' => '<i class="fa fa-file-word-o" aria-hidden="true"></i>',
           'doc' => '<i class="fa fa-file-word-o" aria-hidden="true"></i>',
           'xls' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
           'xlsx' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
           'ppt' => '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>',
           'pptx' => '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>',
       );
       
       return $arrExtension[$fileExtension];
    }
}    