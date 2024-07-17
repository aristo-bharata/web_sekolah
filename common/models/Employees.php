<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string $description
 * @property int $status
 * @property string $created_timestamp
 * @property string $modified_timestamp
 *
 * @property MasterArticles[] $masterArticles
 * @property MasterEmployees[] $masterEmployees
 * @property MasterEmployeesMedia[] $masterEmployeesMedia
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['created_timestamp', 'modified_timestamp'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'description' => 'Description',
            'status' => 'Status',
            'created_timestamp' => 'Created Timestamp',
            'modified_timestamp' => 'Modified Timestamp',
        ];
    }

    /**
     * @inheritDoc
     */
     
    public function behaviors() {
        return[
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_timestamp',
                'updatedAtAttribute' => 'modified_timestamp',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * Gets query for [[MasterArticles]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMasterArticles()
    {
        return $this->hasMany(MasterArticles::className(), ['employees_id' => 'id']);
    }

    /**
     * Gets query for [[MasterEmployees]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMasterEmployees()
    {
        return $this->hasMany(MasterEmployees::className(), ['employees_id' => 'id']);
    }

    /**
     * Gets query for [[MasterEmployeesMedia]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMasterEmployeesMedia()
    {
        return $this->hasMany(MasterEmployeesMedia::className(), ['employees_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return EmployeesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeesQuery(get_called_class());
    }
}
