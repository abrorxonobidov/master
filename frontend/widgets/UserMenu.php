<?php
/**
 * Created by PhpStorm.
 * User: m_mirmaksudov
 * Date: 26.12.2015
 * Time: 16:30
 */

namespace frontend\widgets;

use common\models\generated\TasksMovements;
use common\models\User;
use Yii;
use yii\bootstrap\Widget;

/**
 * @property \common\models\User $user
 */
class UserMenu extends Widget
{
    /**
     * @return array
     */
    public static function getUserMenuItems()
    {
        $items = [];
        //$items[] = ['label' => Yii::t('app', 'Асосий саҳифа'), 'url' => ['/site/index'], 'icon' => 'md md-home'];
        $items[] = ['label' => Yii::t('app', 'Сотув'), 'url' => ['/sale/index'], 'icon' => 'md md-shopping-cart'];
        $items[] = ['label' => Yii::t('app', 'Тўловлар'), 'url' => ['/payment/index'], 'icon' => 'md md-attach-money'];
        $items[] = ['label' => Yii::t('app', 'Махсулотлар кирими'), 'url' => ['/income/index'], 'icon' => 'md md-cloud-download'];
        $items[] = ['label' => Yii::t('app', 'Харажатлар'), 'url' => ['/expense/index'], 'icon' => 'md md-exposure'];
        $items[] = ['label' => Yii::t('app', 'Махсулотлар'), 'url' => ['/product/index'], 'icon' => 'md md-dns'];
        $items[] = ['label' => Yii::t('app', 'Мижозлар'), 'url' => ['/client/index'], 'icon' => 'md md-quick-contacts-dialer'];
        $items[] = ['label' => Yii::t('app', 'Иш вақти'), 'url' => ['/working-time/index'], 'icon' => 'md md-alarm'];
        $items[] = [
            'label' => Yii::t('app', 'Қўшимча созламалар'),
            'url' => '#',
            'icon' => 'md md-settings',
            'items' => [
                ['label' => Yii::t('app', 'Фойдаланувчилар'), 'url' => ['/user/index'], ],
                ['label' => Yii::t('app', 'Ўлчов бирликлари'), 'url' => ['/unit/index'], ],
                ['label' => Yii::t('app', 'Тўлов турлари'), 'url' => ['/pay-type/index'], ],
                ['label' => Yii::t('app', 'Ҳаражат турлари'), 'url' => ['/expense-type/index'], ],
                ['label' => Yii::t('app', 'Техникалар'), 'url' => ['/technic/index'], ],
            ]
        ];
        $items[] = [
            'label' => Yii::t('app', 'Ҳисоботлар'),
            'url' => '#',
            'icon' => 'md md-trending-up',
            'items' => [
                ['label' => Yii::t('app', 'Тўловлар бўйича'), 'url' => ['/report/payments'], ],
                ['label' => Yii::t('app', 'Касса ҳисоботи'), 'url' => ['/report/cashbox'], ],
                ['label' => Yii::t('app', 'Маҳсулот айланмаси'), 'url' => ['/product/stat'], ],
                ['label' => Yii::t('app', 'Мижоз бўйча'), 'url' => ['/client/stat'], ],
            ]
        ];
        return $items;
    }

}
