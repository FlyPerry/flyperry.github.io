<?php

namespace app\controllers;

use app\models\Catalog;
use app\models\Items;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ItemsController extends Controller
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

    public function actionCreate()
    {
        $model = new Items();
        $categories = Catalog::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (!is_null($model->imageFile) && $model->upload()) {
                // File is uploaded successfully
                $model->photo = $model->imageFile->baseName . '.' . $model->imageFile->extension;

            }
            if ($model->save() && $model->validate()) {
                return $this->redirect(['/admin/view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories
        ]);
    }

    public function actionDelete($id)
    {
        $model = Items::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Товар не найден.');
        }

        // Set the active field to 0 to mark the item as inactive and deleted field to 1
        $model->active = 0;
        $model->deleted = 1; // Assuming '1' means deleted

        if ($model->save(false, ['active', 'deleted'])) { // Save only the 'active' and 'deleted' fields without validation
            // Set a flash message for successful deactivation
            Yii::$app->session->setFlash('success', 'Позиция успешно удалена.');

            // Function to find the item index in the basket
            function findItemIndex($basket, $itemId)
            {
                foreach ($basket as $key => $item) {
                    if ($item['id'] == $itemId) {
                        return $key;
                    }
                }
                return false;
            }

            // Update the basket cookie after deactivation
            $basket = json_decode(Yii::$app->request->cookies->getValue('basket', '[]'), true);
            $itemIndex = findItemIndex($basket, $id);

            if ($itemIndex !== false) {
                unset($basket[$itemIndex]);
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'basket',
                    'value' => json_encode(array_values($basket)), // Re-index the array
                ]));
            }
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось деактивировать товар.');
        }

        // Redirect to the index page or another appropriate page
        return $this->redirect(['/admin']);
    }


    public function actionUpdate($id)
    {
        $model = Items::findOne($id);
        $categories = Catalog::find()->all(); // Assuming you have a way to retrieve all categories

        $categoryIds = array_map(function ($category) {
            return $category->id;
        }, $model->categories);
        if ($model === null) {
            throw new NotFoundHttpException('The requested item does not exist.');
        }


        if ($model->load(Yii::$app->request->post())) {
            // Update category associations
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (!is_null($model->imageFile) && $model->upload()) {
                // File is uploaded successfully
                $model->photo = $model->imageFile->baseName . '.' . $model->imageFile->extension;

            }
            if (isset($postData['category_id'])) {
                $model->category_id = $postData['category_id'];
            }
            if ($model->save() && $model->validate()) {
                return $this->redirect(['/admin/view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
            'categoryIds' => $categoryIds
        ]);
    }

    public function actionRestore($id)
    {
        $model = Items::findDeleted()->andWhere(['id'=>$id])->one();
        if (!$model) {
            throw new NotFoundHttpException('Товар не найден.');
        }

        // Restore the item (set active = 1 and deleted = 0)
        $model->active = 1;
        $model->deleted = 0;

        if ($model->save(false, ['active', 'deleted'])) { // Save only the 'active' and 'deleted' fields without validation
            Yii::$app->session->setFlash('success', 'Товар успешно восстановлен.');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось восстановить товар.');
        }

        return $this->redirect(['admin/index']); // Redirect to the deleted items page
    }
}
