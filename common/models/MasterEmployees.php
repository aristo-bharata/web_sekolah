<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_employees".
 *
 * @property int $id
 * @property int $employees_id
 * @property int $user_id
 * @property int $rate
 *
 * @property Employees $employees
 * @property User $user
 */
class MasterEmployees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employees_id', 'user_id', 'rate'], 'required'],
            [['employees_id', 'user_id', 'rate'], 'integer'],
            [['employees_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employees_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employees_id' => 'Employees ID',
            'user_id' => 'User ID',
            'rate' => 'Rate',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employees_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function saveMasterEmployees($userID, $employeesID, $rate) 
    {
        $this->user_id = $userID;
        $this->employees_id = $employeesID;
        $this->rate = $rate;
        return $this->save();
    }
    
}
