<?php
namespace common\components;

use yii;
use yii\base\Component;
use yii\db\Query;
use common\models\Employees;
use common\models\MasterEmployeesMedia;
use common\models\Medias;

class UserShow extends Component
{
    public function viewEmployees($UID)
    {
        return $this->getEmployees($UID);
    }
    
    public function viewEmployeesMedia($UID) 
    {
        if($this->countEmployeesMedia($UID) > 0){
            return $this->getEmployeesMedia($UID);
        }else{
            $media = 'no-ava.webp';
            return $media;
        }
    }
    
    public function countEmployeesMedia($UID) 
    {
        $countMasterEmployeesMedia = MasterEmployeesMedia::find()->where(['employees_id' => $this->getMasterEmployeesID($UID)['employees_id']])->count();
        return $countMasterEmployeesMedia;
    }
    
    public function findEmployees($UID) 
    {
        return Employees::findOne($this->getMasterEmployeesID($UID)['employees_id']);
    }
    
    public function viewStudents($UID)
    {
        return $this->getStudents($UID);
    }
    
    private function getEmployees($UID)
    {
        $employees = Employees::findOne($this->getMasterEmployeesID($UID)['employees_id']);
        return $employees->first_name.' '.$employees->last_name;
    }
    
    private function getEmployeesMedia($UID) 
    {
        $masterEmployeesMedia = MasterEmployeesMedia::find()->where(['employees_id' => $this->getMasterEmployeesID($UID)['employees_id']])->one();
        $media = Medias::find()->where(['id' => $masterEmployeesMedia->medias_id])->one();
        return $media->media;
    }
    
    private function getMasterEmployeesID($UID)
    {
        $query = (new Query())
                ->select('*')
                ->from('master_employees')
                ->where(['user_id' => $UID]);
        return $query->createCommand()->queryOne();
    }
    
    private function getStudents($UID)
    {
        $students = Students::findOne($this->getMasterStudentsID($UID)['students_id']);
        return $students->first_name.' '.$students->last_name;
    }
    
    private function getMasterStudentsID($UID)
    {
        $query = (new Query())
                ->select('*')
                ->from('master_students')
                ->where(['user_id' => $UID]);
        return $query->createCommand()->queryOne();
    }
}