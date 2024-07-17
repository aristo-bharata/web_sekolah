<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "social_medias".
 *
 * @property int $id
 * @property string $social_media
 * @property string $link_account
 *
 * @property MasterSocialMediaEmployee[] $masterSocialMediaEmployees
 * @property MasterSocialMediasWebIdentity[] $masterSocialMediasWebIdentities
 */
class SocialMedias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social_medias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'social_media', 'link_account'], 'required'],
            [['id'], 'integer'],
            [['social_media', 'link_account'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'social_media' => 'Social Media',
            'link_account' => 'Link Account',
        ];
    }

    /**
     * Gets query for [[MasterSocialMediaEmployees]].
     *
     * @return \yii\db\ActiveQuery|MasterSocialMediaEmployeeQuery
     */
    public function getMasterSocialMediaEmployees()
    {
        return $this->hasMany(MasterSocialMediaEmployee::class, ['social_medias_id' => 'id']);
    }

    /**
     * Gets query for [[MasterSocialMediasWebIdentities]].
     *
     * @return \yii\db\ActiveQuery|MasterSocialMediasWebIdentityQuery
     */
    public function getMasterSocialMediasWebIdentities()
    {
        return $this->hasMany(MasterSocialMediasWebIdentity::class, ['social_medias_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SocialMediasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SocialMediasQuery(get_called_class());
    }
}
