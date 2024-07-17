<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Previleges]].
 *
 * @see Previleges
 */
class PrevilegesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Previleges[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Previleges|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
