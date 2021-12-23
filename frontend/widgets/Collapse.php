<?php

namespace frontend\widgets;

use yii\base\Widget;

/**
 * Class ScrollToTop
 * @package frontend\widgets
 * @property string $header
 * @property string $content
 */
class Collapse extends Widget
{

    public $header = null;
    public $content = null;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('collapseView', [
            'header' => $this->header,
            'content' => $this->content
        ]);
    }

}