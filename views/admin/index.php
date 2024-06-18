<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use app\models\Items;
use yii\helpers\Url;

/** @var yii\web\View $this */
?>
<h1>Админ панель <?= Yii::$app->name ?></h1>

<p>
    <?= Html::a('Добавить товар', ['items/create'], ['class' => 'btn btn-outline-success']) ?>
    <?= Html::a('Список заказов', ['admin/orders'], ['class' => 'btn btn-outline-secondary']) ?>
</p>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn',
            'header' => '№ п/п'],

        'id',
        'itemName',
        'desc',
        'inStock',
        'amount',
        //'active',
        //'hit',
        //'new',
        //'photo',
        //'fullDesc',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Items $model, $key, $index, $column) {
                $customUrls = [
                    'view' => Url::toRoute(['admin/view/', 'id' => $model->id]),
                    'update' => Url::toRoute(['items/update/', 'id' => $model->id]),
                    'delete' => Url::toRoute(['items/delete/', 'id' => $model->id]),
                ];

                return isset($customUrls[$action]) ? $customUrls[$action] : Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ],
]); ?>

<h1>Удалённые товары</h1>

<?= GridView::widget([
    'dataProvider' => $dataProviderDeleted,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn',
            'header' => '№ п/п'],

        'id',
        'itemName',
        'desc',
        'inStock',
        'amount',
        //'active',
        //'hit',
        //'new',
        //'photo',
        //'fullDesc',
        [
            'class' => ActionColumn::className(),
            'template' => '{restore}', // Add restore action
            'buttons' => [
                'restore' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-refresh"></i>', $url, [
                        'title' => Yii::t('yii', 'Восстановить'),
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите восстановить этот товар?',
                            'method' => 'post',
                        ],
                    ]);
                },
            ],
            'urlCreator' => function ($action, Items $model, $key, $index) {
                $customUrls = [
                    'restore' => Url::to(['items/restore/', 'id' => $model->id]), // Define restore action URL
                ];

                return $customUrls[$action] ?? '#';
            }
        ],
    ],
]); ?>
