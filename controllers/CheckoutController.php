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
        $basket = json_decode(Yii::$app->request->cookies->getValue('basket', []));

        $amount = 0;
        $items = [];
        foreach ($basket as $productId => $quantity) {
            $product = Items::findOne($quantity->id);
            $items[] = $quantity;
            $amount += $product->amount * $quantity->count;
        }

        Pay::createPayment($amount, $items);

        $orderid = (new Pay())->lastorderid;
        \WebToPay::redirectToPayment([
            'projectid' => 244012,
            'sign_password' => 'f6c79f4af478638c39b206ec30ab166b',
            'orderid' => $orderid,
            'amount' => $amount,
            'currency' => 'EUR',
            'country' => 'KZ',
            'accepturl' => 'https://mytestshop.kz/checkout/accept',
            'cancelurl' => 'https://mytestshop.kz/checkout/cancel',
            'callbackurl' => 'https://mytestshop.kz/checkout/callback',
            'test' => 1,
        ]);
    }

    public function actionCallback()
    {
        try {
            $response = \WebToPay::validateAndParseData(
                $_REQUEST,
                244012,
                'f6c79f4af478638c39b206ec30ab166b'
            );

            if ($response['status'] === '1' || $response['status'] === '3') {
                //@ToDo: Validate payment amount and currency, example provided in isPaymentValid method.
                //@ToDo: Validate order status by $response['orderid']. If it is not already approved, approve it.

                echo 'OK';
            } else {
                throw new \Exception('Payment was not successful');
            }
        } catch (\Exception $exception) {
            echo get_class($exception) . ':' . $exception->getMessage();
        }
    }

    public function actionAccept()
    {
        Yii::$app->response->cookies->remove('basket');
        return $this->render('accept');
    }
}