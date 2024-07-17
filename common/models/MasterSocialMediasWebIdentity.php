<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%master_social_medias_web_identity}}".
 *
 * @property int $id
 * @property int $web_identity_id
 * @property int $social_medias_id
 *
 * @property SocialMedia $socialMedias
 * @property WebIdentity $webIdentity
 */
class MasterSocialMediasWebIdentity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%master_social_medias_web_identity}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['web_identity_id', 'social_medias_id'], 'required'],
            [['web_identity_id', 'social_medias_id'], 'integer'],
            [['social_medias_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialMedia::class, 'targetAttribute' => ['social_medias_id' => 'id']],
            [['web_identity_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebIdentity::class, 'targetAttribute' => ['web_identity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'web_identity_id' => 'Web Identity ID',
            'social_medias_id' => 'Social Medias ID',
        ];
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
     * Gets query for [[WebIdentity]].
     *
     * @return \yii\db\ActiveQuery|WebIdentityQuery
     */
    public function getWebIdentity()
    {
        return $this->hasOne(WebIdentity::class, ['id' => 'web_identity_id']);
    }

    /**
     * {@inheritdoc}
     * @return MasterSocialMediasWebIdentityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterSocialMediasWebIdentityQuery(get_called_class());
    }
}
