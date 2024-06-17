<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $merchant_login = "demo";
    $password_1 = "password_1";
    $invid = 0;
    $description = "Техническая документация по ROBOKASSA";
    $out_sum = "8.96";
    $signature_value = md5("$merchant_login:$out_sum:$invid:$password_1");
    print "<html><script language=JavaScript ".
        "src='https://auth.robokassa.ru/Merchant/PaymentForm/FormMS.js?".
        "MerchantLogin=$merchant_login&OutSum=$out_sum&InvoiceID=$invid".
        "&Description=$description&SignatureValue=$signature_value'></script></html>";
    ?>
</div>
