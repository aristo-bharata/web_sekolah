<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_web_identity".
 *
 * @property int $id
 * @property int $web_identity_id
 * @property int $article_types_id
 *
 * @property ArticleType $articleTypes
 * @property MasterWebIdentityMedia[] $masterWebIdentityMedia
 * @property WebIdentity $webIdentity
 */
class MasterWebIdentity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_web_identity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['web_identity_id', 'article_types_id'], 'required'],
            [['web_identity_id', 'article_types_id'], 'integer'],
            [['article_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleType::class, 'targetAttribute' => ['article_types_id' => 'id']],
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
            'article_types_id' => 'Article Types ID',
        ];
    }

    /**
     * Gets query for [[ArticleTypes]].
     *
     * @return \yii\db\ActiveQuery|ArticleTypeQuery
     */
    public function getArticleTypes()
    {
        return $this->hasOne(ArticleType::class, ['id' => 'article_types_id']);
    }

    /**
     * Gets query for [[MasterWebIdentityMedia]].
     *
     * @return \yii\db\ActiveQuery|MasterWebIdentityMediaQuery
     */
    public function getMasterWebIdentityMedia()
    {
        return $this->hasMany(MasterWebIdentityMedia::class, ['master_web_identity_id' => 'id']);
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
     * @return MasterWebIdentityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterWebIdentityQuery(get_called_class());
    }
}
