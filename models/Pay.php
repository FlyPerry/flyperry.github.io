<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay".
 *
 * @property string|null $items
 * @property int|null $status
 * @property int|null $orderid
 * @property int|null $amount
 */
class Pay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['items'], 'string'], // Ensure items is stored as a string (JSON)
            [['status', 'orderid', 'amount'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'items' => 'Items',
            'status' => 'Status',
            'orderid' => 'Order ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * Creates a new payment record
     *
     * @param int $amount
     * @param array $items
     * @param int $status
     * @return bool
     */
    public static function createPayment($amount, $items, $status = 0)
    {
        $payment = new self();
        $payment->amount = $amount;
        $payment->items = json_encode($items);
        $payment->status = $status;
        return $payment->save();
    }

    /**
     * Generates a unique order ID
     *
     * @return string
     */
    public static function getlastorderid()
    {
        return self::find()->orderBy(["orderid" => SORT_DESC])->one()->orderid;
    }
}
