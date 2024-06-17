<?php

namespace app\models;

use yii\db\ActiveQuery;

class ItemsQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->andWhere(['deleted' => 0]);
    }


    /**
     * @inheritdoc
     * @return Items[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Items|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
