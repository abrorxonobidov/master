<?php
/**
 * Created by PhpStorm.
 * User: a_niyazov
 * Date: 17.08.2015
 * Time: 15:30
 */

namespace common\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumnHelper
{
    public static function standard($model, $controller, $action, $label, $iconClass, $params = null, $linkOptions = [], $data_pjax_value = 0, $dataMethod = '')
    {
        if (empty($params)) {
            $urlArray = [$controller . '/' . $action, 'id' => $model['id']];
        } else {
            array_unshift($params, $controller . '/' . $action);
            $urlArray = $params;
        }
        $options = ['title' => Yii::t('yii', $label), 'data-pjax' => $data_pjax_value, 'data-method' => $dataMethod];
        if (is_array($linkOptions))
            $options = array_merge($options, $linkOptions);
        $customUrl = Yii::$app->getUrlManager()->createUrl($urlArray);
        return Html::a('<span class="' . $iconClass . '"></span>', $customUrl, $options);
    }

    public static function view($url, $model, $controller, $linkOptions = [])
    {
        return self::standard($model, $controller, 'view', Yii::t('yii', 'View'), 'glyphicon glyphicon-eye-open', null, $linkOptions);
    }

    public static function update($url, $model, $controller, $linkOptions = [])
    {
        return self::standard($model, $controller, 'update', Yii::t('yii', 'Update'), 'glyphicon glyphicon-pencil', null, $linkOptions);
    }

    public static function delete($url, $model, $controller, $linkOptions = [])
    {
        return self::standard($model, $controller, 'delete', Yii::t('yii', 'Delete'), 'glyphicon glyphicon-trash', null, $linkOptions, 0, 'post');
    }
}