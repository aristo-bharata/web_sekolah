<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ArticleCategories]].
 *
 * @see ArticleCategories
 */
class ArticleCategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ArticleCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ArticleCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
