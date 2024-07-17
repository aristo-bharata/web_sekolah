<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MasterSocialMediasWebIdentity]].
 *
 * @see MasterSocialMediasWebIdentity
 */
class MasterSocialMediasWebIdentityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasterSocialMediasWebIdentity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasterSocialMediasWebIdentity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
