<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_categories".
 *
 * @property int $id
 * @property string $article_category
 * @property int $article_types_id
 *
 * @property ArticleTypes $articleTypes
 * @property MasterArticles[] $masterArticles
 */
class ArticleCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_category', 'article_types_id'], 'required'],
            [['article_types_id'], 'integer'],
            [['article_category'], 'string', 'max' => 45],
            [['article_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleTypes::className(), 'targetAttribute' => ['article_types_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_category' => 'Article Category',
            'article_types_id' => 'Article Types ID',
        ];
    }

    /**
     * Gets query for [[ArticleTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTypes()
    {
        return $this->hasOne(ArticleTypes::className(), ['id' => 'article_types_id']);
    }

    /**
     * Gets query for [[MasterArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterArticles()
    {
        return $this->hasMany(MasterArticles::className(), ['article_categories_id' => 'id']);
    }
}
