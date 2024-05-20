<?php

namespace app\controllers;

use app\models\Items;
use Yii;
use yii\web\Controller;
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

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // File is uploaded successfully
                $model->photo = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
