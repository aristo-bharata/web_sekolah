<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MasterArticles]].
 *
 * @see MasterArticles
 */
class MasterArticlesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasterArticles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasterArticles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
