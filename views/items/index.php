<?php
/** @var yii\web\View $this
 * @var \app\models\Items $item
 */

use yii\helpers\Html;
use yii\web\View;

?>
<script>

</script>
<?= Html::tag('H1', $item->itemName, ['class' => 'item_title']) ?>

<div class="item_preview">
    <div class="right_top">
        <div class="code v_code">ID товара:
            <span class="vendor_or_id"><?= str_pad($item->id, 5, '0', STR_PAD_LEFT); ?></span>
        </div>
        <div class="availability exist"><?= $item->inStock > 0 ? 'В наличии' : 'Нет на складе'; ?></div>
    </div>
</div>

<div class="item_preview">
    <div class="left">
        <div class="extra_image"> <!--TODO:Добавить циклом вывод картинок-->
            <div class="swiper-container gallery-thumbs">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img class="elevatezoom-gallery" data-update=""
                             data-image="/img/800x0/1018/items/2_1594630017.png"
                             data-zoom-image="/img/800x0/1018/items/2_1594630017.png" data-color="0"
                             src="/img/100x100/1018/items/2_1594630017.png">
                    </div>
                    <div class="swiper-slide">
                        <img class="elevatezoom-gallery" data-update=""
                             data-image="/img/800x0/1018/items/2_1_1594630020.png"
                             data-zoom-image="/img/800x0/1018/items/2_1_1594630020.png" data-color="0"
                             src="/img/100x100/1018/items/2_1_1594630020.png">
                    </div>
                    <div class="swiper-slide">
                        <img class="elevatezoom-gallery" data-update=""
                             data-image="/img/800x0/1018/items/2_2_1594630022.png"
                             data-zoom-image="/img/800x0/1018/items/2_2_1594630022.png" data-color="0"
                             src="/img/100x100/1018/items/2_2_1594630022.png">
                    </div>
                    <div class="swiper-slide">
                        <img class="elevatezoom-gallery" data-update=""
                             data-image="/img/800x0/1018/items/2_3_1594630024.png"
                             data-zoom-image="/img/800x0/1018/items/2_3_1594630024.png" data-color="0"
                             src="/img/100x100/1018/items/2_3_1594630024.png">
                    </div>
                </div>
            </div>
            <div class="next">
                <i class="f7-icons">chevron_down</i>
            </div>
        </div>

        <div class="image">
            <div class="item_tags">
                <?= $item->hit ? Html::tag('div', 'Хит продаж', ['class' => 'bestseller']) : ''; ?>
                <?= $item->new ? Html::tag('div', 'Новинка!', ['class' => 'novelty']) : ''; ?>
            </div>
            <div class="zoom">
                <i class="f7-icons">zoom_in</i>
            </div>
            <div class="swiper-container gallery-top">
                <div class="cancel">
                    <i class="f7-icons">zoom_out</i>
                </div>
                <div class="swiper-wrapper"> <!--TODO:Добавить циклом вывод картинок-->
                    <div class="swiper-slide offer_image_0">
                        <img class="big" data-zoom-image="/img/800x0/1018/items/2_1594630017.png" data-color="0"
                             src="/img/800x0/1018/items/2_1594630017.png">
                    </div>
                    <div class="swiper-slide offer_image_0">
                        <img class="big" data-zoom-image="/img/800x0/1018/items/2_1_1594630020.png" data-color="0"
                             src="/img/800x0/1018/items/2_1_1594630020.png">
                    </div>
                    <div class="swiper-slide offer_image_0">
                        <img class="big" data-zoom-image="/img/800x0/1018/items/2_2_1594630022.png" data-color="0"
                             src="/img/800x0/1018/items/2_2_1594630022.png">
                    </div>
                    <div class="swiper-slide offer_image_0">
                        <img class="big" data-zoom-image="/img/800x0/1018/items/2_3_1594630024.png" data-color="0"
                             src="/img/800x0/1018/items/2_3_1594630024.png">
                    </div>

                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-white"></div>
                <div class="swiper-button-prev swiper-button-white"></div>
            </div>
        </div>
    </div>

    <div class="right">
        <h3 class="item_preview_title">Краткое описание товара</h3>
        <div class="item_short_description">
            <?= $item->desc; ?>
        </div>
        <div class="item_price" data-discount="0.00" data-discount-type="percent">
            <?php if ($item->inStock > 0): ?>

                <form action="/basket/add/" method="GET">
                    <div class="count">

                        <span class="details_title">Количество:</span>
                        <div class="count_minus">-</div>
                        <input type="text" name="quantity" class="number_input" value="1.00" min="1.00" step="1.00"
                               max="<?= $item->inStock; ?>">
                        <div class="count_plus">+</div>
                    </div>
                    <button class="disable">
                        <i class="f7-icons">cart_fill</i>В корзину
                    </button>
                </form>
            <?php endif; ?>


            <div class="price_one_wrapp">
                <span class="details_title">Цена:</span>
                <span class="one_price "><?= $item->amount; ?> тг.</span>
            </div>


            <div class="total_price">
                <span class="details_title">Общая сумма.:</span>
                <span class="total "><?= $item->amount; ?> тг.</span>
            </div>

        </div>

        <div class="tab tab_left" data-tab-content="properties">

            <h3 class="item_preview_title">Характеристики</h3>

            <div class="prop_row">
                <div class="prop_title">Производитель</div>
                <div class="separator_tabulator"></div>
                <div class="prop_val">
                    <a href="../../manufacturers/apple/index.htm">Apple</a>
                </div>
            </div>
            <div class="prop_row">
                <div class="prop_title">Единица измерения</div>
                <div class="separator_tabulator"></div>
                <div class="prop_val">шт.</div>
            </div>
            <div class="prop_row">
                <div class="prop_title">Конфигурация процессора</div>
                <div class="separator_tabulator"></div>
                <div class="prop_val">4x Cortex-A7 1.3 ГГц</div>
            </div>
            <div class="prop_row">
                <div class="prop_title">Объем оперативной памяти</div>
                <div class="separator_tabulator"></div>
                <div class="prop_val">512 МБ</div>
            </div>
            <div class="prop_row">
                <div class="prop_title">Количество SIM-карт</div>
                <div class="separator_tabulator"></div>
                <div class="prop_val">2 SIM</div>
            </div>
            <div class="prop_row">
                <div class="prop_title">Разрешение экрана</div>
                <div class="separator_tabulator"></div>
                <div class="prop_val">1280x600</div>
            </div>
            <div class="prop_row">
                <div class="prop_title">Емкость аккумулятора</div>
                <div class="separator_tabulator"></div>
                <div class="prop_val">1400 мА*ч</div>
            </div>
        </div>

    </div>
</div>

<div class="item_info_wrapper">
    <h3 class="item_preview_title">Описание товара</h3>
    <div class="tab tab_right" data-tab-content="description">
        <div class="item_description">
            <p>Узкие, едва заметные рамки помогают сосредоточить внимание на изображении. И поверьте, здесь есть на
                что посмотреть. Расширенное цветовое пространство DCI-P3 делает картинку по-настоящему яркой и
                реалистичной.</p>

            <p>Функция True Tone заботится о том, чтобы каждый оттенок всегда оставался естественным. Она
                автоматически корректирует тональность в соответствии с характеристиками окружающего освещения.
                Прибавьте к этому мгновенный тактильный отклик на прикосновение &mdash; и вы получите идеальный
                экран.</p>

        </div>
    </div>
</div>
