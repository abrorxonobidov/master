<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ChartsAsset extends AssetBundle
{
    public $sourcePath = '@frontend/web/themes/adminlte/bower_components/chart.js/';

    public $js = [
        'Chart.min.js'
    ];
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
//    public $css = [
//        'css/site.css',
//    ];
//    public $js = [
//        'js/jquery.color.js',
//    ];
//    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap4\BootstrapAsset',
//    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
