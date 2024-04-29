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

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$categories = ['elektronka' => 'Электронные сиграреты', 'zhizha' => 'Жидкости', 'podiki' => 'Устройства']
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
        window.shop_currency = 'руб.';
        window.shop_id = '1018';
        window.customer_discount = '';
        window.template_class = 'kanasi';
        window.item_img_zoom = '1';
        window.promo_discount = null;
        window.promo_title = null;
        window.one_click_buy = 1;
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
                        <li class="catalog_title li"><a href="categories">Каталог</a></li>
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
                            <li><a href="/categories/s-emkoj-batareej" class="" title="С емкой батареей">С
                                    емкой батареей</a>
                                <ul class="level_2">
                                    <li><a href="/categories/smartfony-nokia" class="" title="Смартфоны Nokia">Смартфоны
                                            Nokia</a></li>
                                    <li><a href="/categories/smartfony-philips" class=""
                                           title="Смартфоны Philips">Смартфоны Philips</a></li>
                                    <li><a href="/categories/smartfony-bluefox" class=""
                                           title="Смартфоны BlueFox">Смартфоны BlueFox</a></li>
                                </ul>
                            </li>
                            <li><a href="/categories/s-bolshim-ekranom" class="" title="С большим экраном">С
                                    большим экраном</a>
                                <ul class="level_2">
                                    <li><a href="/categories/smartfony-samsung" class=""
                                           title="Смартфоны Samsung">Смартфоны Samsung</a></li>
                                    <li><a href="/categories/smartfony-huawei" class=""
                                           title="Смартфоны Huawei">Смартфоны Huawei</a></li>
                                </ul>
                            </li>
                            <li><a href="/categories/s-horoshej-kameroj" class="" title="С хорошей камерой">С
                                    хорошей камерой</a>
                                <ul class="level_2">
                                    <li><a href="/categories/smartfony-alcatel" class=""
                                           title="Смартфоны Alcatel">Смартфоны Alcatel</a></li>
                                    <li><a href="/categories/smartfony-apple" class="" title="Смартфоны Apple">Смартфоны
                                            Apple</a></li>
                                </ul>
                            </li>
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
                        <a href="basket">
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
                            <?= Html::a($category_name,Url::to(['catalog/'.$category]),['title'=>$category_name])?>
                            </li>
                            <?php endforeach;?>
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

            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
                </div>
            </div>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
