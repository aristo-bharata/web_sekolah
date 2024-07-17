<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_employees_media".
 *
 * @property int $id
 * @property int $medias_id
 * @property int $employees_id
 *
 * @property Employees $employees
 * @property Medias $medias
 */
class MasterEmployeesMedia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_employees_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['medias_id', 'employees_id'], 'required'],
            [['medias_id', 'employees_id'], 'integer'],
            [['employees_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employees_id' => 'id']],
            [['medias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medias::className(), 'targetAttribute' => ['medias_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medias_id' => 'Medias ID',
            'employees_id' => 'Employees ID',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employees_id']);
    }

    /**
     * Gets query for [[Medias]].
     *
     * @return \yii\db\ActiveQuery|MediasQuery
     */
    public function getMedias()
    {
        return $this->hasOne(Medias::className(), ['id' => 'medias_id']);
    }

    /**
     * {@inheritdoc}
     * @return MasterEmployeesMediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterEmployeesMediaQuery(get_called_class());
    }
    
    public function countEmployeesFoto($employeesID) 
    {
        return $this->find()->where(['employees_id' => $employeesID])->count();
    }
    
    public function getEmployeesFoto($employeesID) 
    {
        return $this->find()->where(['employees_id' => $employeesID])->one();
    }
    
    public function deleteEmployeesFoto($employeesID) 
    {
        $medias = new Medias();
        $medias->tempDeleteMedia($this->getEmployeesFoto($employeesID)['medias_id']);
        $employeesMedia = self::findOne($this->getEmployeesFoto($employeesID)['id']);
        return $employeesMedia->delete();
    }
    
    public function saveEmployeesFoto($employeesID, $mediasID) 
    {
        $this->employees_id = $employeesID;
        $this->medias_id = $mediasID;
        return $this->save();
    }
}
