<?php

namespace app\controllers;
require_once '../web/libwebtopay/WebToPay.php';
use yii\web\Controller;

class CheckoutController extends Controller
{
    public function actionIndex(){

        \WebToPay::redirectToPayment([
            'projectid' => 244012 ,
            'sign_password' => 'f6c79f4af478638c39b206ec30ab166b',
            'orderid' => 12,
            'amount' => 1000,
            'currency' => 'EUR',
            'country' => 'KZ',
            'accepturl' => 'https://mytestshop.kz' . '/checkout/accept',
            'cancelurl' => 'https://mytestshop.kz' . '/checkout/cancel',
            'callbackurl' => 'https://mytestshop.kz' . '/checkout/callback',
            'test' => 1,
        ]);
        return $this->render('index');

    }
}