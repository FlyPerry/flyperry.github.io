<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;

class BasketController extends Controller
{
    public function actionRemoveItem()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $itemId = Yii::$app->request->post('id');
        $basketCookie = Yii::$app->request->cookies->getValue('basket');

        if ($basketCookie !== null) {
            $basketItems = json_decode($basketCookie, true);

            // Find the item index in the basket array
            $itemIndex = array_search($itemId, array_column($basketItems, 'id'));

            if ($itemIndex !== false) {
                // Remove the item from the basket array
                array_splice($basketItems, $itemIndex, 1);

                // Update the basket cookie
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'basket',
                    'value' => json_encode($basketItems),
                    'expire' => time() + 86400 * 365, // Example: 1 year expiration
                ]));

                // Check if basket is now empty and delete the cookie if it is
                if (empty($basketItems)) {
                    Yii::$app->response->cookies->remove('basket');
                }

                return ['success' => true, 'basket' => $basketItems];
            }
        }

        return ['success' => false, 'error' => 'Item not found in basket'];
    }
    public function actionAddToBasket()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $itemId = Yii::$app->request->post('id');
        $itemName = Yii::$app->request->post('name');
        $itemPrice = Yii::$app->request->post('price');
        $itemCount = Yii::$app->request->post('count');

        // Получить текущие данные корзины из локального хранилища
        $basket = json_decode(Yii::$app->request->cookies->getValue('basket', '[]'), true);

        // Проверяем, был ли уже добавлен товар в корзину
        $existingItemIndex = $this->findItemIndex($basket, $itemId);
        if ($existingItemIndex !== false) {
            // Если товар уже есть в корзине, увеличиваем его количество
            $basket[$existingItemIndex]['count'] += $itemCount;
        } else {
            // Если товара еще нет в корзине, добавляем его
            $basket[] = [
                'id' => $itemId,
                'name' => $itemName,
                'price' => $itemPrice,
                'count' => $itemCount,
            ];
        }

        // Сохранить обновленные данные корзины в локальном хранилище
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'basket',
            'value' => json_encode($basket),
        ]));

        return [
            'success' => true,
            'basket' => $basket,
        ];
    }

    public function actionAddCheckoutDetails()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $checkoutName = Yii::$app->request->post('checkoutName');
        $checkoutAdress = Yii::$app->request->post('checkoutAdress');
        $checkoutPhone = Yii::$app->request->post('checkoutPhone');

        // Получить текущие данные корзины из локального хранилища
        $checkoutDetails = json_decode(Yii::$app->request->cookies->getValue('checkoutDetails', '[]'), true);

        // Проверяем, был ли уже добавлен товар в корзину
        $checkoutDetails = [
            'checkoutName' => $checkoutName,
            'checkoutAdress' => $checkoutAdress,
            'checkoutPhone' => $checkoutPhone,
        ];
        // Сохранить обновленные данные корзины в локальном хранилище
        Yii::$app->response->cookies->add(new Cookie(['name' => 'checkoutDetails', 'value' => json_encode($checkoutDetails)]));

        return ['success' => true,
            'checkoutDetails' => $checkoutDetails];
    }

    public function actionUpdateBasket()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $itemId = Yii::$app->request->post('id');
        $itemCount = Yii::$app->request->post('count');

        // Get the current basket data from cookies
        $basket = json_decode(Yii::$app->request->cookies->getValue('basket', '[]'), true);

        // Find the item and update its count
        $existingItemIndex = $this->findItemIndex($basket, $itemId);
        if ($existingItemIndex !== false) {
            // Update the item count
            $basket[$existingItemIndex]['count'] = $itemCount;
        }

        // Save the updated basket data back to cookies
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'basket',
            'value' => json_encode($basket),
        ]));

        return [
            'success' => true,
            'basket' => $basket,
        ];
    }

// Вспомогательная функция для поиска индекса товара по его ID
    private function findItemIndex($basket, $itemId)
    {
        foreach ($basket as $index => $item) {
            if ($item['id'] == $itemId) {
                return $index;
            }
        }
        return false;
    }


    public function actionIndex()
    {
        $basketCookie = Yii::$app->request->cookies->getValue('basket', '');
        $checkoutDetails = Yii::$app->request->cookies->getValue('checkoutDetails', '');
        return $this->render("index.php", compact('basketCookie', 'checkoutDetails'));
    }
}