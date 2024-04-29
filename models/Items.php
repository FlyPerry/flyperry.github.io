<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property string|null $itemName
 * @property string|null $desc
 * @property int $inStock
 * @property int $amount
 * @property int $active
 * @property int $hit
 * @property int $new
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inStock', 'amount', 'active', 'hit', 'new'], 'integer'],
            [['itemName', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'itemName' => 'Item Name',
            'desc' => 'Desc',
            'inStock' => 'In Stock',
            'amount' => 'Amount',
            'active' => 'Active',
            'hit' => 'Hit',
            'new' => 'New',
        ];
    }
}
