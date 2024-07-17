<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MasterSocialMediaEmployees]].
 *
 * @see MasterSocialMediaEmployees
 */
class MasterSocialMediaEmployeesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasterSocialMediaEmployees[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasterSocialMediaEmployees|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
