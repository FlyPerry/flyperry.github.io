<?php

namespace app\controllers;

use app\models\Items;

class ItemsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->redirect('/');
    }
    public function actionViewByTitle($id)
    {
        // Получение данных из базы данных по названию
        $item = Items::find()->where(['id' => $id])->one();

        if ($item === null) {
            throw new \yii\web\NotFoundHttpException('Товар не найден');
        }

        // Возвращаем представление или делаем что-то еще с полученными данными
        return $this->render('index', [
            'item' => $item,
        ]);
    }
}
