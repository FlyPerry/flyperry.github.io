<?php

/* @var $this \yii\web\View */

/* @var $basketCookie mixed */

use app\models\Items;
use yii\helpers\Html;

?>

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
                        <span class=""><?= $item->amount; ?> тг.<span></span></span></div>
                    <div class="quantity">
                        <div class="count">
                            <div class="count_minus">-</div>
                            <input data-index="0" type="text" name="quantity" class="number_input"
                                   value="<?= $basketItem['count'] ?>"
                                   min="1.00"
                                   step="1.00" max="<?=$item->inStock;?>">
                            <div class="count_plus">+</div>
                        </div>
                    </div>
                    <div class="total">
                        <div class="total_new"></div>
                        <span class=""><?=$itemSum;?> тг.</span></div>
                    <div class=""></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="basket_end">
            <div class="left">
                <div class="promo">
                    <form method="POST" id="apply_promo">
                        <input name="action" type="hidden" value="apply_promo">
                        <input type="text" name="promo" class="promo" value="" placeholder="Введите промокод ...">
                        <button class="get_promo">Применить</button>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="total_basket_wrapp"><span>Итоговая сумма: </span><span id="basket_total"><span class=""><?=$basketSum;?></span> тг.</span>
                </div>
                <a class="checkout_btn" href="/checkout/">Оформить заказ</a>
            </div>
        </div>
    </div>

<?php endif; ?>

