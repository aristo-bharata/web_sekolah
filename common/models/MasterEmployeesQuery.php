<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MasterEmployees]].
 *
 * @see MasterEmployees
 */
class MasterEmployeesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasterEmployees[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasterEmployees|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
