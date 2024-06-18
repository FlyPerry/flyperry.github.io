<?php

/* @var $this \yii\web\View */

/* @var $basketCookie mixed */

/* @var $checkoutDetails mixed */

use app\models\Items;
use yii\helpers\Html;
use yii\web\View;

$csrfToken = Yii::$app->request->csrfToken;
$checkoutDetails = json_decode($checkoutDetails, true);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/inputmask.min.js"></script>

<div class="breadcrumb">
    <span><a href="../index.htm">Главная</a> / </span>
    <span>Корзина</span>
</div>

<h1 class="shop-title">Корзина</h1>

<?php if (!empty($basketCookie)): ?>

    <div id="basket_list">
        <div class="basket_item_wrapp">
            <div class="item_in_basket_titles">
                <div class="title">Наименование товара</div>
                <div class="img"></div>
                <div class="price">Цена</div>
                <div class="quantity">Количество</div>
                <div class="total">Стоимость</div>
                <div class="remove" data-index="0"></div>
            </div>
            <?php
            $basketItems = json_decode($basketCookie, true);
            $basketSum = 0;
            // Теперь $basketItems содержит распарсенные данные из куки
            // Вы можете использовать массив $basketItems для дальнейшей обработки данных
            foreach ($basketItems as $basketItem):
                $item = Items::findOne($basketItem['id']);
                $itemSum = $basketItem['count'] * $item->amount;
                $basketSum = $basketSum + $itemSum;
                ?>
                <div class="item_in_basket">
                    <div class="image"><?= Html::img($item->getPhotoUrl()) ?></div>
                    <div class="title"><a href="/items/<?= $item->id; ?>">
                            <?= $item->itemName; ?>
                        </a><br><span class="v_code">Код товара: <?= $item->id; ?></span>
                    </div>
                    <div class="price">
                        <div></div>
                        <span class="amount"><?= $item->amount; ?> тг.<span></span></span></div>
                    <div class="quantity">
                        <div class="count">
                            <div class="count_minus">-</div>
                            <input data-index="0" type="text" name="quantity" class="number_input"
                                   value="<?= $basketItem['count'] ?>"
                                   min="1.00"
                                   step="1.00" max="<?= $item->inStock; ?>">
                            <div class="count_plus">+</div>
                        </div>
                    </div>
                    <div class="total">
                        <div class="total_new"></div>
                        <span class="amountSum"><?= $itemSum; ?> тг.</span></div>
                    <div class=""></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="basket_end">
            <div class="left">
                <div class="contacts">
                    <form id="applyContacts">
                        <input type="text" name="checkoutName" class="checkoutName" required
                               value="<?= isset($checkoutDetails['checkoutName']) ? $checkoutDetails['checkoutName'] : '' ?>"
                               placeholder="Введите ваше имя">
                        <input type="text" name="checkoutAdress" class="checkoutAdress" required
                               value="<?= isset($checkoutDetails['checkoutAdress']) ? $checkoutDetails['checkoutAdress'] : '' ?>"
                               placeholder="Введите ваш адрес">
                        <input type="text" name="checkoutPhone" class="checkoutPhone" required
                               value="<?= isset($checkoutDetails['checkoutPhone']) ? $checkoutDetails['checkoutPhone'] : '' ?>"
                               placeholder="+7(___)___-__-__" maxlength="15">
                        <button class="saveCheckOutInfoButton">Сохранить</button>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="total_basket_wrapp"><span>Итоговая сумма: </span>
                    <span id="basket_total">
                        <span class="amountCost"> <?= $basketSum; ?></span>
                        тг.</span>
                </div>

                <a class="checkout_btn" type="submit">Оплатить</a>


            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.checkoutPhone').mask('+9 (999) 999-99-99')
            $('.checkout_btn').on('click', function (event) {
                // Проверка формы
                var form = document.getElementById('applyContacts');
                if (!form.checkValidity()) {
                    event.preventDefault(); // Останавливаем переход по ссылке
                    alert('Пожалуйста, заполните все обязательные поля.');
                    form.reportValidity(); // Показываем нативные подсказки браузера о незаполненных полях
                }else{
                    $('#applyContacts').submit();
                    window.location.href = '/checkout/';
                }
            });
        });
    </script>
<?php endif;


$js = "
function updateBasketCookie(itemId, itemCount) {
        $.ajax({
            url: '/basket/update-basket',
            method: 'POST',
            data: {
                id: itemId,
                count: itemCount,
                _csrf: '" . $csrfToken . "'
            },
            success: function(response) {
                if (response.success) {
                    console.log('Basket updated:', response.basket);
                } else {
                    console.error('Failed to update basket');
                }
            },
            error: function() {
                console.error('Error updating basket');
            }
        });
    }";
$this->registerJs($js, 1);

$this->registerJs(<<<JS
        $('#applyContacts').on('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    
    // Extract form data
    var formData = {
        checkoutName: $('.checkoutName').val(),
        checkoutAdress: $('.checkoutAdress').val(),
        checkoutPhone: $('.checkoutPhone').val(),
        _csrf: yii.getCsrfToken()
    };

    // Perform AJAX request
    $.ajax({
        url: '/basket/add-checkout-details', // Adjust the URL according to your route
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                alert('Контактные данные успешно сохранены!');
                // Optionally, you can redirect the user to another page after successful submission
                // window.location.href = '/success-page';
            } else {
                alert('Произошла ошибка при сохранении контактных данных.');
            }
        },
        error: function() {
            alert('Произошла ошибка при отправке запроса.');
        }
    });
});

JS, View::POS_READY);
?>

