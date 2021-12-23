<?php
namespace frontend\helpers;

use yii\bootstrap\Html;

class StringHelper extends Html
{

    /**
     * @param string $name
     * @return string
     */
    public static function iconFa($name)
    {
        return self::tag('i', '', ['class' => "fa fa-$name"]);
    }
}