<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/jquery-3.6.0.min.js',

        ['src' => '/js/script-min.js', 'type' => 'text/javascript'], // Добавляем скрипт сюда

        [
            'src' => '/js/feather.min.js',
            'type' => 'module',
        ],
        ['src' => '/js/swiper-min.js', 'type' => 'text/javascript'], // Добавляем скрипт сюда
        ['src' => '/js/swiper-min.js', 'type' => 'module'], // Добавляем скрипт сюда

        'js/zoomer.js',
        'js/js.js',
        'js/mask.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
