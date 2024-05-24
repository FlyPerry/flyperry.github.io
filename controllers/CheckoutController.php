<?php

namespace app\controllers;

use yii\web\Controller;

class CheckoutController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }
}