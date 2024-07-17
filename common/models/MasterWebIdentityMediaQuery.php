<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MasterWebIdentityMedia]].
 *
 * @see MasterWebIdentityMedia
 */
class MasterWebIdentityMediaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasterWebIdentityMedia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasterWebIdentityMedia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
