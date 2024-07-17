<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_articles_media".
 *
 * @property int $id
 * @property int $master_articles_id
 * @property int $medias_id
 *
 * @property MasterArticles $masterArticles
 * @property Medias $medias
 */
class MasterArticlesMedia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_articles_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_articles_id', 'medias_id'], 'required'],
            [['master_articles_id', 'medias_id'], 'integer'],
            [['master_articles_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterArticles::className(), 'targetAttribute' => ['master_articles_id' => 'id']],
            [['medias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medias::className(), 'targetAttribute' => ['medias_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_articles_id' => 'Master Articles ID',
            'medias_id' => 'Medias ID',
        ];
    }

    /**
     * Gets query for [[MasterArticles]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMasterArticles()
    {
        return $this->hasOne(MasterArticles::className(), ['id' => 'master_articles_id']);
    }

    /**
     * Gets query for [[Medias]].
     *
     * @return \yii\db\ActiveQuery|MediasQuery
     */
    public function getMedias()
    {
        return $this->hasOne(Medias::className(), ['id' => 'medias_id']);
    }

    /**
     * {@inheritdoc}
     * @return MasterArticlesMediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterArticlesMediaQuery(get_called_class());
    }
    
    public function saveMasterMedia($mediasID, $masterArticlesID) 
    {
        $this->medias_id = $mediasID;
        $this->master_articles_id = $masterArticlesID;
        return $this->save();
    }
}
