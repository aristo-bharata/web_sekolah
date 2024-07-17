<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%master_web_identity_media}}".
 *
 * @property int $id
 * @property int $master_web_identity_id
 * @property int $medias_id
 *
 * @property MasterWebIdentity $masterWebIdentity
 * @property Media $medias
 */
class MasterWebIdentityMedia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%master_web_identity_media}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_web_identity_id', 'medias_id'], 'required'],
            [['master_web_identity_id', 'medias_id'], 'integer'],
            [['master_web_identity_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterWebIdentity::class, 'targetAttribute' => ['master_web_identity_id' => 'id']],
            [['medias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::class, 'targetAttribute' => ['medias_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_web_identity_id' => 'Master Web Identity ID',
            'medias_id' => 'Medias ID',
        ];
    }

    /**
     * Gets query for [[MasterWebIdentity]].
     *
     * @return \yii\db\ActiveQuery|MasterWebIdentityQuery
     */
    public function getMasterWebIdentity()
    {
        return $this->hasOne(MasterWebIdentity::class, ['id' => 'master_web_identity_id']);
    }

    /**
     * Gets query for [[Medias]].
     *
     * @return \yii\db\ActiveQuery|MediaQuery
     */
    public function getMedias()
    {
        return $this->hasOne(Media::class, ['id' => 'medias_id']);
    }

    /**
     * {@inheritdoc}
     * @return MasterWebIdentityMediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterWebIdentityMediaQuery(get_called_class());
    }
}
