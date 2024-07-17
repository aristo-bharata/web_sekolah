<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MasterArticlesMedia]].
 *
 * @see MasterArticlesMedia
 */
class MasterArticlesMediaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasterArticlesMedia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasterArticlesMedia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
