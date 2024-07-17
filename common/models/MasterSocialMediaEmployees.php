<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%master_social_media_employees}}".
 *
 * @property int $id
 * @property int $employees_id
 * @property int $social_medias_id
 *
 * @property Employee $employees
 * @property SocialMedia $socialMedias
 */
class MasterSocialMediaEmployees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%master_social_media_employees}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employees_id', 'social_medias_id'], 'required'],
            [['employees_id', 'social_medias_id'], 'integer'],
            [['employees_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employees_id' => 'id']],
            [['social_medias_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialMedia::class, 'targetAttribute' => ['social_medias_id' => 'id']],
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
            'social_medias_id' => 'Social Medias ID',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|EmployeeQuery
     */
    public function getEmployees()
    {
        return $this->hasOne(Employee::class, ['id' => 'employees_id']);
    }

    /**
     * Gets query for [[SocialMedias]].
     *
     * @return \yii\db\ActiveQuery|SocialMediaQuery
     */
    public function getSocialMedias()
    {
        return $this->hasOne(SocialMedia::class, ['id' => 'social_medias_id']);
    }

    /**
     * {@inheritdoc}
     * @return MasterSocialMediaEmployeesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterSocialMediaEmployeesQuery(get_called_class());
    }
}
