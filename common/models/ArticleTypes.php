<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_types".
 *
 * @property int $id
 * @property string $article_type
 *
 * @property ArticleCategories[] $articleCategories
 */
class ArticleTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_type'], 'required'],
            [['article_type'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_type' => 'Article Type',
        ];
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategories::className(), ['article_types_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ArticleTypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleTypesQuery(get_called_class());
    }
}
