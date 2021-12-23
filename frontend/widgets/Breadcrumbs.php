<?php
/**
 * Created by PhpStorm.
 * User: a_isokov
 * Date: 23.09.2016
 * Time: 11:40
 */
namespace frontend\widgets;

use common\models\User;
use yii\helpers\Html;
use Yii;
use yii\widgets\Breadcrumbs as BaseBreadcrumbs;
/**
 * Class Breadcrumbs
 */
class Breadcrumbs extends BaseBreadcrumbs
{
    /**
     * Renders the widget.
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('app', 'Бош саҳифа'),
                'url' => Yii::$app->homeUrl,
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode('', $links), $this->options);
    }
}