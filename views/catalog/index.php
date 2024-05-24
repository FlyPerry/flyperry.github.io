<?php
/**
 * @var \app\models\Items $items
 * @var \app\models\Catalog $catalog
 */

use yii\helpers\Html;

?>
<div class="items_wrapper popular">
    <h2><?= $catalog->title; ?></h2>
    <?= ($items == false) ? '<h3>В данной категории товары отсутствуют</h3>' : '' ?>
    <div class="items">
        <?php foreach ($items as $item): ?>
            <div class="item" data-discount-type="percent" data-code="<?= $item->id; ?>">

                <a class="item_link" href="/items/<?= $item->id; ?>">
                    <div class="image">
                        <div class="item_tags">
                            <?= $item->hit ? Html::tag('div', 'Хит продаж', ['class' => 'bestseller']) : ''; ?>
                            <?= $item->new ? Html::tag('div', 'Новинка!', ['class' => 'novelty']) : ''; ?>
                        </div>
                        <div class="bg_dark"></div>
                        <?= Html::img($item->getPhotoUrl(), ['alt' => $item->itemName
                            , 'style' => [
                                'height' => '250px'
                                , 'object-fit' => 'cover'
                            ]
                            , 'loading' => 'lazy'
                        ]) ?>
                    </div>
                </a>
                <div class="item_content " data-discount="">
                    <div class="descr"><a href="/items/<?= $item->id ?>"><?= $item->itemName; ?></a></div>
                    <div class="short_descr"><?= $item->desc; ?>
                    </div>
                    <div class="price ">
                        <div class="new">
                            <?= $item->amount; ?>
                            тг.
                        </div>
                    </div>
                    <div class="btn_wrapp">
                        <a class="more" href="/items/<?= $item->id ?>">Подробнее</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

