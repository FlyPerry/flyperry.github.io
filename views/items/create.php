<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'itemName')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'inStock')->textInput() ?>
    <?= $form->field($model, 'amount')->textInput() ?>
    <?= $form->field($model, 'active')->textInput() ?>
    <?= $form->field($model, 'hit')->textInput() ?>
    <?= $form->field($model, 'new')->textInput() ?>
    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
