<?php

namespace common\models\activeQueries;

/**
 * This is the ActiveQuery class for [[\common\models\PayType]].
 *
 * @see \common\models\PayType
 */
class PayTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\PayType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\PayType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
