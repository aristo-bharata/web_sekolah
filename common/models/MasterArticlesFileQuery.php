<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MasterArticlesFile]].
 *
 * @see MasterArticlesFile
 */
class MasterArticlesFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasterArticlesFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasterArticlesFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
