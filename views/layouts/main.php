<?php

/** @var yii\web\View $this */

/** @var string $content
 ** @var array $categories
 */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
use app\models\Items;

use yii\web\YiiAsset;
use yii\bootstrap5\BootstrapAsset;
use yii\grid\GridViewAsset;

AppAsset::register($this);
YiiAsset::register($this);
BootstrapAsset::register($this);
GridViewAsset::register($this);

$basketCookie = Yii::$app->request->cookies->getValue('basket', '');
$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$categories = ['1' => 'Электронные сиграреты', '2' => 'Жидкости', '3' => 'Устройства']
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords"
          content="Электронка, вейп, подик, вейпы, жижка, купить жижку, купить вейп, купить электронку
          , купить подик, испарители">
    <meta name="description"
          content="Parashute - Интернет магазин электронных сигарет">
    <meta content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1" name="viewport">
    <meta name="verify-paysera" content="1bf510534e94e13d95f068d7837a52ad">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="icon" type="image/png" href="/img/64x64/1018/favicon/favikonka_15946435384164.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link href="/css/normalize.css" rel="stylesheet" type="text/css">

    <link href="/css/framework7-icons.css" rel="stylesheet">
    <link href="/css/swiper.css" rel="stylesheet" type="text/css">
    <style>

        :root {
            --mainSchemeColor: #1E3053;
            --mainContrastSchemeColor: #EAC250;
            --catalogTitleColor: #333;

            --mainSchemeColorHover: #142649;
            --mainContrastSchemeColorHover: #e0b846;

            --menuBorderDarken: #192b4e;

            --mainSchemeColor-darken10: #142649;
            --mainSchemeColor-darken20: #0a1c3f;
            --mainSchemeColor-darken30: #001235;
            --mainSchemeColor-lighten10: #283a5d;
            --mainSchemeColor-lighten20: #324467;

            --mainContrastSchemeColor-darken10: #e0b846;
            --mainContrastSchemeColor-darken20: #d6ae3c;
            --mainContrastSchemeColor-darken30: #cca432;
            --mainContrastSchemeColor-lighten10: #f4cc5a;
            --mainContrastSchemeColor-lighten20: #fed664;
        }


    </style>

    <link href="/css/shop/themes/base/style.css?ver=1711906659" rel="stylesheet" type="text/css">
    <link href="/css/shop/themes/templates/kanasi.css?ver=1710605584" rel="stylesheet" type="text/css">
    <link href="/css/shop/mobile.css?ver=1710279352" rel="stylesheet" type="text/css" media="(max-width: 1366px)">

    <script>
        window.shop_currency = 'тг.';
        window.shop_id = '1018';
        window.customer_discount = '';
        window.template_class = 'kanasi';
        window.item_img_zoom = '1';
        window.promo_discount = null;
        window.promo_title = null;
    </script>


</head>
<body class=" kanasi main_page rate_1 shop_1018" data-template="kanasi" data-color-scheme="stone">

<div class="wrapper">

    <?php $this->beginBody() ?>

    <header id="header">
        <div class="block top_menu">
            <div class="inner">
                <div class="center menu">
                    <ul id="menu_list">
                        <li class="catalog_title li"><a href="/categories">Каталог</a></li>
                        <li class="li"><a href="/o-kompanii" class="" title="О компании">О компании</a></li>
                        <li class="li"><a href="/dostavka-i-oplata" class="" title="Доставка и оплата">Доставка
                                и оплата</a></li>
                        <li class="li"><a href="/kontakty" class="" title="Контакты">Контакты</a></li>

                    </ul>
                </div>
                <div class="mob_menu">
                    <span>Меню</span>
                    <i class="f7-icons">line_horizontal_3</i>
                </div>
                <div class="menu_popup_mob">
                    <div class="close">
                        <i class="f7-icons">multiply</i>
                    </div>
                    <div class="categories">
                        <div class="mob-title"><i class="f7-icons">bars</i>Категории товаров</div>
                        <ul class="level_1">
                            <?php foreach ($categories as $category => $category_name): ?>
                                <li>
                                    <?= Html::a($category_name, Url::to(['catalog/' . $category]), ['title' => $category_name]) ?>
                                </li>
                            <?php endforeach; ?>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <li class="li">
                                    <form action="/site/logout" method="POST">
                                        <input id="form-token" type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                                               value="<?= Yii::$app->request->csrfToken ?>"/>
                                        <input class="btn acc_exit" name="btn_logout" type="submit"
                                               value="logout"/>
                                    </form>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="navigation">
                        <div class="mob-title"><i class="f7-icons">bars</i>Навигация по сайту</div>
                        <ul>
                            <li class="li"><a href="/o-kompanii" class="" title="О компании">О компании</a>
                            </li>
                            <li class="li"><a href="/dostavka-i-oplata" class="" title="Доставка и оплата">Доставка
                                    и оплата</a></li>
                            <li class="li"><a href="/kontakty" class="" title="Контакты">Контакты</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="block header">
            <div class="inner">
                <div class="logo_wrapper">
                    <a href="/" class="logo">
                        <img src="/img/250x0/1018/logo/logo_15946433853734.png" alt="PARASHUT">
                    </a>
                </div>
                <div class="header_right">

                    <div class="phone">
                        <a href="tel:+77074984312">+77074984312</a>
                    </div>

                    <div class="search_open">
                        <i class="f7-icons">search</i>
                    </div>
                    <div class="search_form">
                        <form method="GET" action="/search/">
                            <input type="text" name="search" id="search" required="required"
                                   placeholder="Что будем искать?" autocomplete="off" autofocus="" value="">
                            <button type="submit">
                                <i class="f7-icons">search</i>
                            </button>
                            <div id="autocomplete"></div>
                        </form>
                    </div>
                    <div class="basket">
                        <a href="/basket/">
                            <i class="f7-icons">cart_fill</i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="bottom_header">
                <div class="inner">
                    <div class="categories">
                        <ul class="level_1">
                            <?php foreach ($categories as $category => $category_name): ?>
                                <li>
                                    <?= Html::a($category_name, Url::to(['catalog/' . $category]), ['title' => $category_name]) ?>
                                </li>

                            <?php endforeach; ?>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <li class="li">
                                    <?= Html::a('Склад', Url::to(['/admin/']), ['title' => 'Склад']) ?>
                                </li>
                                <li class="li">
                                    <form action="/site/logout" method="POST">
                                        <input id="form-token" type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                                               value="<?= Yii::$app->request->csrfToken ?>"/>
                                        <input class="btn text-white acc_exit" name="btn_logout" type="submit"
                                               value="Выйти"/>
                                    </form>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="block main">
            <div class="inner">
                <div class="content nositebar ">

                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>

                <div class="triggers">
                    <div class="trigger">
                        <i class="fas fa-map-marked-alt"></i>
                        <span><p>Доставляем заказы по всей территории России</p></span>
                    </div>
                    <div class="trigger">
                        <i class="fas fa-shield-alt"></i>
                        <span><p>На всю продукцию предоставляется гарантия</p></span>
                    </div>
                    <div class="trigger">
                        <i class="fas fa-money-check"></i>
                        <span><p>Покупатель может оплатить заказ любым удобным способом</p></span>
                    </div>
                    <div class="trigger">
                        <i class="fas fa-truck-loading"></i>
                        <span><p>Широкий ассортимент устройств от крупнейших поставщиков</p></span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


<footer class="block">
    <div class="top">
        <div class="inner">
            <div class="fmenu">
                <div class="logo_wrapper">
                    <a class="logo" href="/">
                        <img src="/img/250x0/1018/logo/logo_15946433853734.png" alt="ТелеБит">
                    </a>
                </div>
                <div class="copyright">&copy;
                    2024
                    PARASHUT
                </div>
                <a class="policy" href="/politika-konfidencialnosti">Политика конфиденциальности</a>
                <a class="user_agreement_link" href="/soglasie-na-obrabotku-personalnyh-dannyh">Согласие на
                    обработку персональных данных</a>
                <div class="footer_site_info">
                    <p>Используя данный сайт, вы автоматически принимаете условия пользовательского соглашения и
                        соглашаетесь с политикой конфиденциальности.</p>
                </div>
            </div>
            <div class="fmenu">
                <div class="footer_subtitle">О магазине</div>
                <ul>
                    <li>
                        <a href="/">Главная</a>
                    </li>
                    <li>
                        <a href="/o-kompanii">О компании</a>
                    </li>
                    <li>
                        <a href="/dostavka-i-oplata">Доставка и оплата</a>
                    </li>
                    <li>
                        <a href="/kontakty">Контакты</a>
                    </li>
                    <li>

                        <a href="/news" class="" title="Новости">Новости</a>
                    </li>
                    <li>
                        <a href="/articles" class="" title="Статьи">Статьи</a>
                    </li>

                </ul>

            </div>
            <div class="fmenu catalog">
                <div class="footer_subtitle">Каталог</div>
                <ul>
                    <?php foreach ($categories as $category => $category_name): ?>
                        <li>
                            <?= Html::a($category_name, Url::to(['catalog/' . $category]), ['title' => $category_name]) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>
            <div class="fmenu contact_us">
                <div class="footer_subtitle">Свяжитесь с нами</div>
                <div class="address">101000, г.Москва, ул. Пушкина, Колотушкино 20, п. 1</div>
                <div>
                    <span class="mail_span">E-mail:</span>
                    <a href="mailto:01.alexsandr.46@gmail.com">01.alexsandr.46@gmail.com</a>
                </div>

                <a class="footer_phone" href="tel:+77074984312">+77074984312</a>


                <div class="social">
                    <a target="_blank" href="https://telegram.me/flip1124z" class="link_telegram"></a>
                    <a target="_blank" href="https://instagram.com/a.polyakov_776" class="link_instagram"></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<link rel="stylesheet" href="/modules/fontawesome/fa-free-v4-font-face.min.css">
<link rel="stylesheet" href="/modules/fontawesome/fa-free-v4-shims.min.css">
<link rel="stylesheet" href="/modules/fontawesome/fa-free.min.css">


<?php
$this->registerJs('
    $(function () {
        feather.replace();
    });
', \yii\web\View::POS_END);
$this->registerJs("$(function() {
                $('body').on('click', '.next', function() {
                    $('.swiper-button-next').click();
                });

                switch (template_class) {
					case 'simple':
						var direction = 'horizontal';
						var sliders = 8;
						break;

					case 'michigan':
					case 'tahoe':
						var direction = 'horizontal';
						var sliders = 4;
						break;

					default: 
						var direction = 'vertical';
						var sliders = 4;
						break;
				}

				if (window.innerWidth < 670) {
					direction = 'horizontal';
					sliders = 4;
				}
				var galleryThumbs = new Swiper('.gallery-thumbs', {
					slidesPerView: sliders,
					spaceBetween: 20,
					direction: direction,
					watchSlidesVisibility: true,
				});
				var galleryTop = new Swiper('.gallery-top', {
					spaceBetween: 0,
					slidesPerView: 1,
					autoHeight: true,
					zoom: true,
					navigation: {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev'
					},
					thumbs: {
						swiper: galleryThumbs
					}
				});

                let innerHeight = $('.extra_image .swiper-wrapper').outerHeight();
                let wrapperHeight = $('.extra_image').outerHeight();
                if (innerHeight > wrapperHeight) {
                    $('.item_preview .next').css({
                        'opacity': 1
                    });
                }
                
                $('.zoom').click(function() {
                    $(this).hide();
                    setTimeout(function() {
                        galleryTop.update();
                    }, 100);
                    $('.image').addClass('active');
                    $('.gallery-top .cancel').show();
                });
                $('.gallery-top .cancel').click(function() {
                    $(this).hide();
                    $('.image .zoom').show();
                    $('.image').removeClass('active');
                    setTimeout(function() {
                        galleryTop.update();
                    }, 100);
                });

                var favorites = window.addshop.storage.getProp('favorites');
                var is_in_favorites = false;
                $.each(favorites, function(index, el) {
                    if (window.item.id == el.id) {
                        is_in_favorites = true;
                    }
                });
                if (is_in_favorites) {
                    $('.add_favorite').addClass('active');
                    $('.add_favorite span').text('В избранных');
                }
            });"
    , \yii\web\View::POS_END);
$this->endBody() ?>
<div id="basket_popup_list" class="kanasi" style="right: 186.21px; display: none;">
    <div class="close">✕</div>
    <?php if (!empty($basketCookie)): ?>

        <div class="items">
            <?php
            $basketItems = json_decode($basketCookie, true);
            $basketSum = 0;
            // Теперь $basketItems содержит распарсенные данные из куки
            // Вы можете использовать массив $basketItems для дальнейшей обработки данных
            foreach ($basketItems as $basketItem):
                $item = Items::findOne($basketItem['id']);

                $itemSum = $basketItem['count'] * $item->amount;
                $basketSum = $basketSum + $itemSum;
                ?>
                <div class="item_in_basket">
                    <a href="/items/<?= $item['id']; ?>">
                        <div class="image"><?= Html::img($item->getPhotoUrl(), ['alt' => $item->itemName
                                , 'loading' => 'lazy'
                            ]); ?></div>
                        <div class="descr">
                            <div class="title"><?= $item->itemName; ?></div>
                            <div class="quantity">Количество: <?= $basketItem['count'] ?></div>
                            <div class="price ">Цена: <?= $itemSum ?> ₸г.</div>

                        </div>
                    </a>
                </div>


            <?php endforeach; ?>
        </div>
        <div class="itogo">
            <div class="total">Итого: <span class=""><?= $basketSum; ?></span>&nbsp; ₸г.</div>
            <div class="btns"><a href="/basket/">Корзина</a> <a href="/checkout/">Оформить</a></div>
        </div>
        <script>$(function () {
                $('.pop_up_price').text('<?=$basketSum;?> тг.');
            })</script>
    <?php endif; ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
