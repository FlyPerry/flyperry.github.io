<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;

class BasketController extends Controller
{
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
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
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
        return $this->render("index.php", ['basketCookie' => $basketCookie]);
    }
}