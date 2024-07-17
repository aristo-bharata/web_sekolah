<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscribers".
 *
 * @property int $id
 * @property string|null $full_name
 * @property string $email
 * @property int $status
 * @property string $created
 */
class Subscribers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'status'], 'required'],
            [['status'], 'integer'],
            [['created'], 'safe'],
            [['full_name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'status' => 'Status',
            'created' => 'Created',
        ];
    }
}
