<?php

namespace frontend\widgets;

use frontend\helpers\StringHelper;
use Yii;
use yii\bootstrap\Nav;
use yii\bootstrap\Widget;


class AccountMenu extends Widget
{

    /**
     * @return string
     * @throws mixed
     */
    public function run()
    {
        return Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'dropdown-menu animation-dock'],
            'items' => [
                [
                    'label' => StringHelper::iconFa('user') . ' ' . Yii::t('app', 'Менинг аккоунтим'),
                    'url' => ['/user/view', 'id' => Yii::$app->user->id],
                    'icon' => 'fa fa-user',
                    'linkOptions' => ['data-method' => 'post', 'class' => ' ink-reaction'],
                ],
                [
                    'label' => StringHelper::iconFa('sign-out') . ' ' . Yii::t('app', 'Чиқиш'),
                    'url' => ['/site/logout'],
                    'icon' => 'fa fa-sign-out',
                    'linkOptions' => ['data-method' => 'post', 'class' => ' ink-reaction'],
                ]
            ]
        ]);
    }
}
