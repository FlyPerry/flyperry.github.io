<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $payments app\models\Pay[] */

$this->title = 'Список всех заказов';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-hover">
    <thead>
    <tr>
        <th>ID заказа</th>
        <th>Статус</th>
        <th>Сумма</th>
        <th>ФИО</th>
        <th>Адрес</th>
        <th>Телефон</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($payments as $payment): ?>
        <tr style="cursor: pointer" class="clickable-row" data-id="<?= Html::encode($payment->orderid) ?>">
            <td><?= Html::encode($payment->orderid) ?></td>
            <td><?= Html::encode($payment->statusTitle) ?></td>
            <td><?= Html::encode($payment->amount) ?></td>
            <td><?= Html::encode($payment->order->fio) ?></td>
            <td><?= Html::encode($payment->order->adress) ?></td>
            <td><?= Html::encode($payment->order->phone) ?></td>
            <td>
                <?php if ($payment->status == 2):?>
                <button class="btn btn-danger delete-item" data-id="<?= Html::encode($payment->orderid) ?>" <?= $payment->status == \app\models\Pay::STATUS_CANCELED ? 'disabled' : '' ?>>
                    Отменён
                </button>
                <button class="btn btn-success success-item" data-id="<?= Html::encode($payment->orderid) ?>" <?= $payment->status == \app\models\Pay::STATUS_PAYED ? 'disabled' : '' ?>>
                    Оплачено
                </button>
                <?php endif;?>
            </td>
        </tr>
        <tr class="details-row" id="details-<?= Html::encode($payment->orderid) ?>" style="display: none;">
            <td colspan="7">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Код товара</th>
                        <th>Название товара</th>
                        <th>Цена</th>
                        <th>Количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $items = json_decode($payment->items, true);
                    if (json_last_error() === JSON_ERROR_NONE):
                        ?>
                        <?php foreach ($items as $item): ?>
                        <tr data-id="<?= Html::encode($item['id']) ?>">
                            <td><?= Html::encode($item['id']) ?></td>
                            <td><?= Html::encode($item['name']) ?></td>
                            <td><?= Html::encode($item['price']) ?></td>
                            <td><?= Html::encode($item['count']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Ошибка при разборе JSON</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php
$this->registerJs(<<<JS
    $.ajaxSetup({
        data: {
            _csrf: yii.getCsrfToken()
        }
    });
    $('.clickable-row').on('click', function () {
        var id = $(this).data('id');
        $('#details-' + id).toggle();
    });

    $('.delete-item').on('click', function (e) {
        e.stopPropagation();
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/cancel',
            type: 'POST',
            data: {orderid: id},
            success: function (response) {
                if (response.success) {
                    $('#details-' + id).find('td:eq(1)').text('Отменён');
                    $('.delete-item[data-id=' + id + ']').prop('disabled', true);
                    $('.success-item[data-id=' + id + ']').prop('disabled', true);
                } else {
                    alert('Ошибка при отмене заказа.');
                }
            }
        });
    });

    $('.success-item').on('click', function (e) {
        e.stopPropagation();
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/payed',
            type: 'POST',
            data: {orderid: id},
            success: function (response) {
                if (response.success) {
                    $('#details-' + id).find('td:eq(1)').text('Оплачено');
                    $('.success-item[data-id=' + id + ']').prop('disabled', true);
                    $('.delete-item[data-id=' + id + ']').prop('disabled', true);
                } else {
                    alert('Ошибка при изменении статуса заказа.');
                }
            }
        });
    });
JS
);
?>
