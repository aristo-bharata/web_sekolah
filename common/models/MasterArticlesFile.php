<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_articles_file".
 *
 * @property int $id
 * @property int $master_articles_id
 * @property int $files_id
 *
 * @property Files $files
 * @property MasterArticles $masterArticles
 */
class MasterArticlesFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_articles_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_articles_id', 'files_id'], 'required'],
            [['master_articles_id', 'files_id'], 'integer'],
            [['files_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['files_id' => 'id']],
            [['master_articles_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterArticles::className(), 'targetAttribute' => ['master_articles_id' => 'id']],
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
            'files_id' => 'Files ID',
        ];
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasOne(Files::className(), ['id' => 'files_id']);
    }

    /**
     * Gets query for [[MasterArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterArticles()
    {
        return $this->hasOne(MasterArticles::className(), ['id' => 'master_articles_id']);
    }
    
    /**
     * {@inheritdoc}
     * @return MasterArticlesFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterArticlesFileQuery(get_called_class());
    }
    
    public function saveMasterFile($filesID, $masterArticlesID) 
    {
        $this->files_id = $filesID;
        $this->master_articles_id = $masterArticlesID;
        return $this->save(false);
    }
}
