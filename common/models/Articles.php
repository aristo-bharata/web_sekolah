<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $mini_title
 * @property string $date
 * @property string $description
 * @property string|null $article
 * @property int $position
 * @property int $status
 * @property string $tags
 * @property string $created_timestamp
 * @property string $modified_timestamp
 *
 * @property MasterArticles[] $masterArticles
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritDoc}
     */
    public function behaviors() 
    {
        return[
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'immutable' => false,
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_timestamp',
                'updatedAtAttribute' => 'modified_timestamp',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'date', 'description', 'position', 'status', 'tags'], 'required'],
            [['slug', 'description', 'article'], 'string'],
            [['date', 'created_timestamp', 'modified_timestamp'], 'safe'],
            [['position', 'status'], 'integer'],
            [['title', 'mini_title', 'tags'], 'string', 'max' => 255],
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
            'slug' => 'Slug',
            'mini_title' => 'Mini Title',
            'date' => 'Date',
            'description' => 'Description',
            'article' => 'Article',
            'position' => 'Position',
            'status' => 'Status',
            'tags' => 'Tags',
            'created_timestamp' => 'Created Timestamp',
            'modified_timestamp' => 'Modified Timestamp',
        ];
    }

    /**
     * Gets query for [[MasterArticles]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMasterArticles()
    {
        return $this->hasMany(MasterArticles::className(), ['articles_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticlesQuery(get_called_class());
    }
}
