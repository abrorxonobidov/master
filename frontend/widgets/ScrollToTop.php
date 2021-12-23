<?php

namespace frontend\widgets;


use yii\base\Widget;

/**
 * Class ScrollToTop
 * @package frontend\widgets
 */
class ScrollToTop extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        return $this->render('scrollToTop');
    }

}