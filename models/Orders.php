<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int|null $itemID
 * @property string|null $fio
 * @property string|null $adress
 * @property string|null $phone
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['itemID'], 'integer'],
            [['fio'], 'string', 'max' => 255],
            [['adress'], 'string', 'max' => 2555],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'itemID' => 'Item ID',
            'fio' => 'Fio',
            'adress' => 'Adress',
            'phone' => 'Phone',
        ];
    }
}
