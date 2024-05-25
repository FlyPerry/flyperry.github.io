<?php
/** @var yii\web\View $this
 * @var \app\models\Items $item
 */

use yii\helpers\Html;
use yii\web\View;

?>
    <script>
        window.item = {};
        window.item.id = <?=$item->id;?>;
        window.item.price = <?=$item->amount?>;

        // window.basket = {}
        window.item.vendor_code = <?=$item->id;?>;
        window.item.step = 1.00;
        window.item.max_in_order = <?=$item->inStock;?>;
        window.item.min_in_order = 1.00;
    </script>
<?= Html::tag('H1', $item->itemName, ['class' => 'item_title']) ?>

    <div class="item_preview">
        <div class="right_top">
            <div class="code v_code">ID товара:
                <span class="vendor_or_id"><?= $item->id; ?></span>
            </div>

            <div class="availability exist"><?= $item->inStock > 0 ? 'В наличии' : 'Нет на складе'; ?></div>
        </div>
    </div>

    <div class="item_preview">
        <div class="left">
            <div class="extra_image">
                <div class="swiper-container gallery-thumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <?= Html::img($item->getPhotoUrl(), ['data-image' => $item->getPhotoUrl()
                                , 'class' => 'elevatezoom-gallery'
                                , 'data-zoom-image' => $item->getPhotoUrl()]) ?>
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
                    <div class="swiper-wrapper">
                        <div class="swiper-slide offer_image_0">
                            <?= Html::img($item->getPhotoUrl(), ['class' => 'big', 'data-zoom-image' => $item->getPhotoUrl()]) ?>
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

                    <form id="addToCartForm">
                        <div class="count">
                            <span class="details_title">Количество:</span>
                            <div class="count_minus">-</div>
                            <input type="text" name="quantity" class="number_input" value="1" min="1" step="1"
                                   max="<?= $item->inStock; ?>">
                            <div class="count_plus">+</div>
                        </div>
                        <button type="submit" class="addToCart">
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

                <div class="item_info_wrapper">
                    <h3 class="item_preview_title">Описание товара</h3>
                    <div class="tab tab_right" data-tab-content="description">
                        <div class="item_description">
                            <p><?= $item->fullDesc ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(
    'https://code.jquery.com/jquery-3.6.0.min.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJs(<<<JS
        $('#addToCartForm').on('submit', function(event) {
            event.preventDefault(); // Предотвращаем отправку формы по умолчанию
                var itemId = '$item->id';
                var itemName = '$item->itemName';
                var itemPrice = '$item->amount';
                var itemCount = $("[name=quantity]").val();
            $.ajax({
                url: '/basket/add-to-basket', // Укажите URL для обработки запроса
                type: 'POST',
                data: {
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    count: itemCount,
                    _csrf: yii.getCsrfToken()
                },
                success: function(response) {
                    if (response.success) {
                        alert('Товар успешно добавлен в корзину!');
                        location.reload();
                    } else {
                        alert('Произошла ошибка при добавлении товара в корзину.');
                    }
                },
                error: function() {
                    alert('Произошла ошибка при отправке запроса.');
                }
            });
        });
JS, View::POS_READY);
?>