<?php

use kartik\grid\GridView;
use common\models\PayType;

/**
 * @var frontend\models\ClientStatSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Мижоз бўйича');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ҳисоботлар'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;

echo frontend\widgets\Collapse::widget([
    'header' => 'Параметрлар',
    'content' => $this->render('_client_search', ['model' => $searchModel])
]);

echo GridView::widget([
    'summary' => Yii::t('app', 'Намойиш этилмоқда <b>{begin, number}-{end, number}</b> та ёзув <b>{totalCount, number}</b> тадан.'),
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => $this->title
    ],
    'hover' => true,
    'striped' => false,
    'resizableColumns' => true,
    'showPageSummary' => true,
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary warning'],
    'toolbar' => [
        '{export}',
        //'{toggleData}',
    ],
    'panelTemplate' => "{panelHeading} {panelBefore} {items}",
    'filterRowOptions' => [
        'class' => 'hidden'
    ],
    'toggleDataOptions' => [
        'maxCount' => 10000,
        'minCount' => 1000,
        'confirmMsg' => Yii::t('app', 'Ҳаммасини кўришни хохлайсизми?'),
        //Yii::t('kvgrid', 'There are {totalCount} records. Are you sure you want to display them all?',
        //    ['totalCount' => number_format($this->dataProvider->getTotalCount())]),
        'all' => [
            'icon' => 'resize-full',
            'label' => Yii::t('app', 'Барчаси'),
            'class' => 'btn btn-default',
            'title' => Yii::t('app', 'Барчасини кўрсатиш')
        ],
        'page' => [
            'icon' => 'resize-small',
            'label' => Yii::t('app', 'Саҳифа'),
            'class' => 'btn btn-default',
            'title' => Yii::t('app', 'Биринчи саҳифани кўрсатиш')
        ],
    ],
    'export' => [
        'label' => Yii::t('app', 'Юклаб олиш'),
        'header' => false,
        'fontAwesome' => true,
        'target' => kartik\export\ExportMenu::TARGET_BLANK,
        'format' => 'raw',
        'showConfirmAlert' => false,
    ],
    'exportConfig' => [
        'xls' => true,
    ],
    'tableOptions' => ['class' => 'table table-bordered'],
    'dataProvider' => $dataProvider,
    'options' => ['class' => 'table-responsive'],
    //'floatHeader' => true,
    //'floatHeaderOptions' => ['top' => '300'],
    'filterModel' => $searchModel,
    'layout' => "{items}\n{summary}\n{pager}",
    'columns' => [
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'date_time',
            'group' => true,
            'groupEvenCssClass' => 'kv-group-odd',
            'groupOddCssClass' => 'kv-group-odd',
            'format' => 'raw',
            'value' => function ($data) {
                return date('d.m.Y', strtotime($data['date_time']));
            },
            'headerOptions' => [
                'class' => 'col-md-1'
            ],
            'pageSummary' => function () use ($searchModel) {
                $text = "";
                if ($searchModel->date_from)
                    $text .= date('d.m.Y', strtotime($searchModel->date_from)) . ' ' . Yii::t('app', 'дан');
                if ($searchModel->date_to)
                    $text .= date(' d.m.Y', strtotime($searchModel->date_to)) . ' ' . Yii::t('app', 'гача');
                return $text;
            },
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function ($data) {
                return date('H:i', strtotime($data['date_time']));
            },
            'headerOptions' => [
                'class' => 'col-md-1'
            ]
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'client_id',
            'value' => function ($data) {
                return $data['client_name'];
            },
            'headerOptions' => ['class' => 'col-sm-2']
        ],
        'type',
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'pay_type_id',
            'filter' => PayType::getList(),
            'value' => 'pay_type_title',
            'headerOptions' => ['class' => 'col-sm-2'],
            //'pageSummary' => @$searchModel->payType->title,
            'pageSummary' => Yii::t('app', 'Жами'),
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'price_sale',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-bold text-right'],
            'format' => 'decimal',
            'pageSummary' => true,
            'pageSummaryOptions' => ['class' => 'text-bold text-right']
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function () {
                return 'сўм';
            },
            'headerOptions' => ['class' => 'currency-column'],
            'contentOptions' => ['class' => 'text-right'],
            'pageSummary' => 'сўм',
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'price_payment',
            'headerOptions' => ['class' => 'col-sm-1'],
            'contentOptions' => ['class' => 'text-bold text-right'],
            'format' => 'decimal',
            'pageSummary' => true,
            'pageSummaryOptions' => ['class' => 'text-bold text-right']
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'value' => function () {
                return 'сўм';
            },
            'headerOptions' => ['class' => 'currency-column'],
            'contentOptions' => ['class' => 'text-right'],
            'pageSummary' => 'сўм',
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'comment',
            'pageSummary' => function () use ($dataProvider) {

                $a = (new yii\db\Query())
                    ->select('SUM(price_payment) - SUM(price_sale)')
                    ->from(['q' => $dataProvider->query])
                    ->column();

                $balance = Yii::$app->formatter->asDecimal(@$a[0]);
                return "$balance сўм";
            },
            'pageSummaryOptions' => ['class' => 'text-bold text-right']
        ],
    ],
]);