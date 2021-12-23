<?php
/**
 * Created by PhpStorm.
 * User: m_mirmaksudov
 * Date: 26.12.2015
 * Time: 16:33
 */

/**
 * @var array $items
 */

use yii\bootstrap\Nav;
use yii\widgets\Menu;

?>
<?
//        echo "<pre>";var_dump($items); echo "</pre>";
echo Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => $items
])
?>
