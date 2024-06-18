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

    /**
     * Updates the status to 1 by order ID
     *
     * @param int $orderid
     * @return int The number of rows affected
     */
    public static function updateStatusToOneByOrderId($orderid)
    {
        return self::updateAll(['status' => 1], ['orderid' => $orderid]);
    }

    /**
     * Gets related order
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['itemID' => 'orderid']);
    }

}
