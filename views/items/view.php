<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Items $model */

$this->title = $model->itemName;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="items-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['items/update/', 'id' => $model->id], ['class' => 'btn btn-primary text-white']) ?>
        <?= Html::a('Удалить', ['items/delete/', 'id' => $model->id], [
            'class' => 'btn btn-danger text-white',
            'data' => [
                'confirm' => 'Вы дейстивительно хотите удалить этот товар со склада? (Перейдёт в неактивное)',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'itemName',
            'desc',
            'inStock',
            'amount',
            'active',
            'hit',
            'new',
            'photo',
            'fullDesc',
        ],
    ]) ?>

</div>
