<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Добавление товара';

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories \app\models\Catalog */
/* @var $categoryIds \app\models\Items::getCategories */
?>

<div class="items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="items-form">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'itemName')->textInput(['maxlength' => true, 'placeholder' => 'Наименование товара'])->label(false); ?>
                <?= $form->field($model, 'category_id')->dropDownList(
                    ArrayHelper::map($categories, 'id', 'title'),
                    [
                        'prompt' => 'Выберите категорию',
                        'id' => 'category-dropdown',
                        'options' => [
                            $categoryIds[0] => ['selected' => true] // Помечаем Выбранную категорию
                        ]
                    ]
                )->label(false); ?>
                <?= $form->field($model, 'desc')->textInput(['maxlength' => true, 'placeholder' => 'Краткое описание товара'])->label(false); ?>
                <?= $form->field($model, 'fullDesc')->textarea(['maxlength' => true]); ?>
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'amount')->input('number', ['placeholder' => 'Цена'])->label(false); ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'inStock')->input('number', ['placeholder' => 'Кол-во на складе'])->label(false); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= Html::activeCheckbox($model, 'active', ['labelOptions' => ['class' => 'btn-checkbox w-100 text-center'], 'label' => 'Активно']) ?>
                        </div>
                        <div class="form-group">
                            <?= Html::activeCheckbox($model, 'hit', ['labelOptions' => ['class' => 'btn-checkbox w-100 text-center'],]) ?>
                        </div>
                        <div class="form-group">
                            <?= Html::activeCheckbox($model, 'new', ['labelOptions' => ['class' => 'btn-checkbox w-100 text-center'],]) ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Изображение</label>
                <?= Html::activeFileInput($model, 'imageFile', ['class' => 'form-control', 'id' => 'item-image', 'onchange' => 'loadPreview(this)']) ?>
                <div id="image-preview" class="text-center">
                    <?= Html::img($model->getPhotoUrl(), ['alt' => 'Изображение не выбрано']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100 mt-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>