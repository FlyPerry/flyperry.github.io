<?php

namespace app\controllers;

use app\models\Items;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

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

    protected function findModel($id)
    {
        if (($model = Items::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
