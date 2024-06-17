<?php

use yii\helpers\Html;

$this->title = 'Добавить новый товар';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/items/create', [
        'model' => $model,
    ]) ?>

</div>