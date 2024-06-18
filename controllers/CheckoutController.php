<?php

namespace app\controllers;
require_once '../web/libwebtopay/WebToPay.php';

use app\models\Items;
use Yii;
use yii\web\Controller;
use app\models\Pay;
use yii\web\Cookie;

class CheckoutController extends Controller
{
    private $mrh_login = 'jimmystobaccokz';
    private $mrh_pass1 = 'rtOva3HL2WG5jfD6hF4G';
    private $mrh_pass2 = 'su4AUOTf95K37jkXHunZ';

    private function isPaymentValid(array $order, array $response): bool
    {
        if (array_key_exists('payamount', $response) === false) {
            if ($order['amount'] !== $response['amount'] || $order['currency'] !== $response['currency']) {
                throw new \Exception('Wrong payment amount');
            }
        } else {
            if ($order['amount'] !== $response['payamount'] || $order['currency'] !== $response['paycurrency']) {
                throw new \Exception('Wrong payment amount');
            }
        }

        return true;
    }

    public function actionIndex()
    {
        $description = '';
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->has('basket')) {
            return $this->redirect(['basket/index']);
        }
        $basket = json_decode(Yii::$app->request->cookies->getValue('basket', []));

        if ($basket != NULL)
            $amount = 0;
        $items = [];
        foreach ($basket as $productId => $quantity) {
            $product = Items::findOne($quantity->id);
            $items[] = $quantity;
            $amount += $product->amount * $quantity->count;
            $description .= $product->itemName . ' | ';
        }


        Pay::createPayment($amount, $items);

        $orderid = (new Pay())->lastorderid;

        // your registration data
        $inv_id = $orderid;        // shop's invoice number
        // (unique for shop's lifetime)
        $inv_desc = $description;    // invoice desc
        $out_summ = $amount;    // invoice summ

        // build CRC value
        $crc = md5("$this->mrh_login:$out_summ:$inv_id:$this->mrh_pass1");

        // build URL
        $url =
            "https://auth.robokassa.kz/Merchant/Index.aspx?MerchantLogin=$this->mrh_login&" .

            "OutSum=$out_summ&InvId=$inv_id&Description=$inv_desc&SignatureValue=$crc&IsTest=1";

        // print URL if you need
        return $this->redirect($url);
    }

//    public function actionCallback()
//    {
//        try {
//            $response = \WebToPay::validateAndParseData(
//                $_REQUEST,
//                244012,
//                'f6c79f4af478638c39b206ec30ab166b'
//            );
//
//            if ($response['status'] === '1' || $response['status'] === '3') {
//                //@ToDo: Validate payment amount and currency, example provided in isPaymentValid method.
//                //@ToDo: Validate order status by $response['orderid']. If it is not already approved, approve it.
//
//                echo 'OK';
//            } else {
//                throw new \Exception('Payment was not successful');
//            }
//        } catch (\Exception $exception) {
//            echo get_class($exception) . ':' . $exception->getMessage();
//        }
//    }

    public function actionAccept($OutSum, $InvId, $SignatureValue)
    {
        $checkoutDetails = json_decode(Yii::$app->request->cookies->getValue('checkoutDetails', []));
        print_r($checkoutDetails);
        $sql = 'INSERT INTO orders (`itemID`, `fio`, `adress`, `phone`) 
        VALUES (:itemID, :fio, :adress, :phone)';

        $params = [
            ':itemID' => $InvId,
            ':fio' => $checkoutDetails->checkoutName,
            ':adress' => $checkoutDetails->checkoutAdress,
            ':phone' => $checkoutDetails->checkoutPhone,
        ];
        Yii::$app->db->createCommand($sql, $params)->execute();

        $result = Pay::updateStatusToOneByOrderId($InvId);
        if ($result > 0) {
            Yii::$app->session->setFlash('success', 'Заказ был успешно оформлен.');
        }
        Yii::$app->response->cookies->remove('basket');

        return $this->redirect(['site/index']);
    }
}