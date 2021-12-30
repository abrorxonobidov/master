<?php


namespace frontend\widgets;

use kartik\grid\DataColumn;
use kartik\grid\GridView as KartikGridView;

/**
 * Class StatGridView
 * @package frontend\widgets
 * @property DataColumn $columns
 * @property string $panelHeading
 */
class StatGridView extends KartikGridView
{

    public $panelHeading = '';

    public $summary = '{begin}-{end} / {totalCount}';

    public $resizableColumns = true;
    public $striped = false;
    public $hover = true;
    public $showPageSummary = true;
    public $pageSummaryRowOptions = ['class' => 'kv-page-summary warning text-bold'];

    public $toolbar = ['{export}'];
    public $panelTemplate = "{panelHeading} {panelBefore} {items}";
    public $filterRowOptions = ['class' => 'hidden'];

    public $toggleDataOptions = [
        'maxCount' => 10000,
        'minCount' => 1000,
        'confirmMsg' => 'Ҳаммасини кўришни хохлайсизми?',
        'all' => [
            'icon' => 'resize-full',
            'label' => 'Барчаси',
            'class' => 'btn btn-default',
            'title' => 'Барчасини кўрсатиш'
        ],
        'page' => [
            'icon' => 'resize-small',
            'label' => 'Саҳифа',
            'class' => 'btn btn-default',
            'title' => 'Биринчи саҳифани кўрсатиш'
        ],
    ];

    public $export = [
        'label' => 'Юклаб олиш',
        'header' => false,
        'fontAwesome' => true,
        'target' => '_blank',
        'format' => 'raw',
        'showConfirmAlert' => false,
    ];

    public $exportConfig = [
        'xls' => true,
        'pdf' => true
    ];

    public $options = ['class' => 'table-responsive'];

    public $layout = "{items}\n{summary}\n{pager}";

    public $emptyTextOptions = ['class' => 'alert alert-success'];

    public function init()
    {
        $this->panel = [
            'type' => 'primary',
            'heading' => $this->panelHeading
        ];
        parent::init();
    }

}