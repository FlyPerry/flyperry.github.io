<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <h4>Похоже на то, что вы попали на не существующую страницу, держи жижку и ступай путник</h4>
    <?= Html::a('Вернуться', 'javascript:history.back()', ['class' => 'btn btn-primary']) ?>
    <div class="backgroundError-div"></div>
</div>
