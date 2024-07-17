<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "previleges".
 *
 * @property int $id
 * @property string $previlege
 * @property string $nav_menu
 *
 * @property User[] $users
 */
class Previleges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'previleges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['previlege', 'nav_menu'], 'required'],
            [['previlege', 'nav_menu'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'previlege' => 'Previlege',
            'nav_menu' => 'Nav Menu',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['previleges_id' => 'id']);
    }
}
