<?php


namespace frontend\widgets;

use kartik\grid\GridView as KartikGridView;
use yii\helpers\Html;
use yii\web\Request;
use Yii;

class GridView extends KartikGridView
{

    public $summary = '{begin}-{end} / {totalCount}';

    public $filterModel = null;

    public $striped = false;

    public $responsive = false;

    public $hover = true;

    public $layout = "{items}\n <div class='my-grid-summary'>{summary}</div>\n{pager}";

    public $tableOptions = ['class' => 'table table-bordered my-grid-table'];

    public $filterRowOptions = ['class' => 'hidden filters'];

    public function init()
    {
        $this->columns = array_merge([
            [
                'header' => Yii::t('app', 'Т/р'),
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'width:45px;']
            ]
        ], $this->columns);
        parent::init();
    }

}