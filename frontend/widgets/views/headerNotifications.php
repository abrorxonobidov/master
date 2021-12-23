<?php
/**
 * Created by PhpStorm.
 * User: m_mirmaksudov
 * Date: 12.08.2016
 * Time: 13:16
 * @var array $items
 */

use yii\helpers\Url;

?>
<ul class="header-nav header-nav-options notifications-menu">
    <? foreach ($items

                as $item) { ?>
        <? if (!isset($item['items']) || count($item['items']) == 0) { ?>
            <li class="dropdown hidden-xs ">
                <? if (@$item['animated'] == 1) { ?>
                    <a href="<?= Url::to($item['url']) ?>" title="<?= $item['title'] ?>"
                       class="btn btn-icon-toggle btn-default my-btn">
                        <div class="my-btn-border"></div>
                        <i class="<?= $item['icon'] ?> btn-bell"></i>
                        <sup class="badge style-<?= isset($item['countStyle'])?$item['countStyle']:'danger' ?>"><?= $item['count'] ?></sup>
                    </a>
                <? } else { ?>
                    <a href="<?= Url::to($item['url']) ?>" title="<?= $item['title'] ?>"
                       class="btn btn-icon-toggle btn-default ink-reaction">
                        <i class="<?= $item['icon'] ?> "></i>
                        <sup class="badge style-<?= isset($item['countStyle'])?$item['countStyle']:'danger' ?>"><?= $item['count'] ?></sup>
                    </a>
                <? } ?>
            </li>
        <? } else { ?>
            <li class="dropdown hidden-xs">
                <? if (@$item['animated'] == 1) { ?>
                    <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default  my-btn" title="<?= $item['title'] ?>" data-toggle="dropdown" aria-expanded="false">
                        <div class="my-btn-border"></div>
                        <i class="<?= $item['icon'] ?>  btn-bell"></i>
                        <sup class="badge style-<?= isset($item['countStyle'])?$item['countStyle']:'danger' ?>"><?= $item['count'] ?></sup>
                    </a>
                <? } else { ?>
                    <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default  ink-reaction"
                       title="<?= $item['title'] ?>" data-toggle="dropdown" aria-expanded="false">
                        <i class="<?= $item['icon'] ?>"></i><sup class="badge style-<?= isset($item['countStyle'])?$item['countStyle']:'danger' ?>"><?= $item['count'] ?></sup>
                    </a>
                <? } ?>
                <ul class="dropdown-menu animation-dock">
                    <li class="dropdown-header"><?= $item['title'] ?></li>
                    <? foreach ($item['items'] as $subItem) { ?>
                        <li><a href="<?= Url::to($subItem['url']) ?>"><?= $subItem['title'] ?><span
                                        class="badge style-<?= isset($item['countStyle'])?$item['countStyle']:'danger' ?> pull-right"><?= $subItem['count'] ?></span></a></li>
                    <? } ?>
                    <li class="divider"></li>
                </ul>
            </li>
        <? }
    } ?>
</ul>
