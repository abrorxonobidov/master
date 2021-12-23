<?php
/**
 * Created by PhpStorm.
 * User: m_mirmaksudov
 * Date: 12.08.2016
 * Time: 13:05
 */

namespace frontend\widgets;

use common\helpers\DebugHelper;
use common\models\generated\BestCaseTasks;
use common\models\generated\ErroneousRequests;
use common\models\generated\Requests;
use common\models\generated\Tasks;
use common\models\generated\TasksMovements;
use common\models\generated\User;
use yii\bootstrap\Widget;
use yii\db\Query;
use Yii;

/**
 * Class ActionButtons
 * @package frontend\widgets
 * @property User $user
 * @property string $type
 */
class HeaderNotifications extends Widget
{
    public $user;
    public $type;
    public $arTypes;

    /**
     * @return string
     */
    public function run()
    {
        $items = false;
        if (!Yii::$app->user->isGuest) {
            foreach ($this->arTypes as $type)
                switch ($type) {
                    case 'deadline':
                        $count1 = 1;
                        $count2 = 3;
                        $count3 = 5;
                        $count = $count1 + $count2 + $count3;
                        if ($count > 0) {
                            $subItems = [];
                            if ($count1 > 0)
                                $subItems[] = [
                                    'icon' => 'fa fa-calendar',
                                    'title' => Yii::t('app', 'Сўровлар'),
                                    'url' => '/tasks/deadline',
                                    'count' => $count1,
                                ];
                            if ($count2 > 0)
                                $subItems[] = [
                                    'icon' => 'fa fa-calendar-times-o',
                                    'title' => Yii::t('app', 'Сўров рад этилган'),
                                    'url' => ['/tasks/rejecting', 'status' => 'deadline'],
                                    'count' => $count2,
                                ];
                            if ($count3 > 0)
                                $subItems[] = [
                                    'icon' => 'fa fa-calendar-check-o',
                                    'title' => Yii::t('app', 'Муддат узайтирилган'),
                                    'url' => ['/tasks/rejecting', 'status' => 'deadline_accepted'],
                                    'count' => $count3,
                                ];
                            if (count($subItems) === 1) {
                                $item = $subItems[0];
                                $items[] = [
                                    'icon' => $item['icon'],
                                    'title' => $item['title'],
                                    'url' => $item['url'],
                                    'count' => $count,
                                ];
                            } else {
                                $items[] = [
                                    'icon' => 'fa fa-calendar',
                                    'title' => Yii::t('app', 'Муддатни узайтиришлар'),
//                                'url' => '/tasks/deadline',
                                    'count' => $count,
                                    'items' => $subItems
                                ];
                            }
                        }
                        break;
                    default :
                        break;
                }
        }

        if ($items) {
            return $this->render('headerNotifications',
                [
                    'items' => $items,
                ]
            );
        }
    }
}