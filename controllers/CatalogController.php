<?php



namespace app\controllers;

use app\models\Catalog;
use app\models\Items;
use yii\web\Controller;
use Yii;


class CatalogController extends Controller
{
    public function actionIndexById($id)
    {
            /**
             * @var $catalog Catalog
             * @var $items Items
             * */
        $catalog = Catalog::find()->where(['id' => $id])->one();

        if ($catalog === null) {
            throw new \yii\web\NotFoundHttpException('Товар не найден');
        }

        $items = $catalog->findAllItemsInThisCategory();
        // Возвращаем представление или делаем что-то еще с полученными данными
        return $this->render('index', [
            'catalog' => $catalog,
            'items' => $items,
        ]);
    }

}