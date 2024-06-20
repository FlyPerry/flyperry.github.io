<?php

namespace app\controllers;

use app\models\Items;
use app\models\Pay;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Items::find(),

                'pagination' => [
                    'pageSize' => 50
                ],
                'sort' => [
                    'defaultOrder' => [
                        'active' => SORT_DESC,
                    ]
                ],

            ]);

            $dataProviderDeleted = new ActiveDataProvider([
                'query' => Items::findDeleted(),

                'pagination' => [
                    'pageSize' => 50
                ],
                'sort' => [
                    'defaultOrder' => [
                        'active' => SORT_DESC,
                    ]
                ],

            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'dataProviderDeleted' => $dataProviderDeleted,
            ]);
        }
    }

    /**
     * Displays a single Items model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('/items/view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionOrders()
    {
        $payments = Pay::find()->innerJoinWith('order')->orderBy('status DESC')->all();

        // Рендеринг представления с передачей данных
        return $this->render('orders', [
            'payments' => $payments,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Items::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionCancel()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $orderid = Yii::$app->request->post('orderid');

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Обновление статуса заказа
            if (Pay::updateAll(['status' => Pay::STATUS_CANCELED], ['orderid' => $orderid])) {
                // Получение заказа
                $pay = Pay::findOne(['orderid' => $orderid]);
                if ($pay === null) {
                    throw new \Exception("Order not found.");
                }

                // Декодирование JSON с товарами
                $items = json_decode($pay->items, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception("Failed to parse items JSON.");
                }

                // Возвращение товаров на склад
                foreach ($items as $item) {
                    Items::plusItem($item['id'], $item['count']);
                }

                $transaction->commit();
                return ['success' => true];
            } else {
                throw new \Exception("Failed to update order status.");
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    public function actionPayed()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $orderid = Yii::$app->request->post('orderid');

        if (Pay::updateAll(['status' => Pay::STATUS_PAYED], ['orderid' => $orderid])) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }


}
