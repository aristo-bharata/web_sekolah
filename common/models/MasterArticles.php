<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_articles".
 *
 * @property int $id
 * @property int $article_categories_id
 * @property int $articles_id
 * @property int $viewer
 * @property int $rate
 * @property int $comments
 * @property int $employees_id
 *
 * @property ArticleCategories $articleCategories
 * @property Articles $articles
 * @property Employees $employees
 * @property MasterArticlesFile[] $masterArticlesFiles
 * @property MasterArticlesMedia[] $masterArticlesMedia
 */
class MasterArticles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_categories_id', 'articles_id', 'viewer', 'rate', 'comments', 'employees_id'], 'required'],
            [['article_categories_id', 'articles_id', 'viewer', 'rate', 'comments', 'employees_id'], 'integer'],
            [['article_categories_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategories::className(), 'targetAttribute' => ['article_categories_id' => 'id']],
            [['articles_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::className(), 'targetAttribute' => ['articles_id' => 'id']],
            [['employees_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employees_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_categories_id' => 'Article Categories ID',
            'articles_id' => 'Articles ID',
            'viewer' => 'Viewer',
            'rate' => 'Rate',
            'comments' => 'Comments',
            'employees_id' => 'Employees ID',
        ];
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasOne(ArticleCategories::className(), ['id' => 'article_categories_id']);
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery|ArticlesQuery
     */
    public function getArticles()
    {
        return $this->hasOne(Articles::className(), ['id' => 'articles_id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employees_id']);
    }

    /**
     * Gets query for [[MasterArticlesFiles]].
     *
     * @return \yii\db\ActiveQuery|MasterArticlesFileQuery
     */
    public function getMasterArticlesFiles()
    {
        return $this->hasMany(MasterArticlesFile::className(), ['master_articles_id' => 'id']);
    }

    /**
     * Gets query for [[MasterArticlesMedia]].
     *
     * @return \yii\db\ActiveQuery|MasterArticlesMediaQuery
     */
    public function getMasterArticlesMedia()
    {
        return $this->hasMany(MasterArticlesMedia::className(), ['master_articles_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MasterArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterArticlesQuery(get_called_class());
    }
}
