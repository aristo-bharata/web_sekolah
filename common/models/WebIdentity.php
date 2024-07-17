<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_identity".
 *
 * @property int $id
 * @property string $title
 * @property string $tags
 * @property string $description
 * @property string $create_timestamp
 * @property string $modified_timestamp
 *
 * @property MasterSocialMediasWebIdentity[] $masterSocialMediasWebIdentities
 * @property MasterWebIdentity[] $masterWebIdentities
 */
class WebIdentity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'web_identity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'tags', 'description'], 'required'],
            [['tags', 'description'], 'string'],
            [['create_timestamp', 'modified_timestamp'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'tags' => 'Tags',
            'description' => 'Description',
            'create_timestamp' => 'Create Timestamp',
            'modified_timestamp' => 'Modified Timestamp',
        ];
    }

    /**
     * Gets query for [[MasterSocialMediasWebIdentities]].
     *
     * @return \yii\db\ActiveQuery|MasterSocialMediasWebIdentityQuery
     */
    public function getMasterSocialMediasWebIdentities()
    {
        return $this->hasMany(MasterSocialMediasWebIdentity::class, ['web_identity_id' => 'id']);
    }

    /**
     * Gets query for [[MasterWebIdentities]].
     *
     * @return \yii\db\ActiveQuery|MasterWebIdentityQuery
     */
    public function getMasterWebIdentities()
    {
        return $this->hasMany(MasterWebIdentity::class, ['web_identity_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return WebIdentityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WebIdentityQuery(get_called_class());
    }
}
