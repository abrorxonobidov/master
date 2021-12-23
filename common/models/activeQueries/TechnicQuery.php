<?php

namespace common\models\activeQueries;

/**
 * This is the ActiveQuery class for [[\common\models\Technic]].
 *
 * @see \common\models\Technic
 */
class TechnicQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Technic[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Technic|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
