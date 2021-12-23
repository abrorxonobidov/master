<?php

use common\models\PayType;
use yii\helpers\Html;
use kartik\grid\GridView;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\PaymentSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Тўловлар бўйича ҳисобот');
$this->params['breadcrumbs'][] = $this->title;

echo frontend\widgets\Collapse::widget([
    'content' => $this->render('_payment_search', ['model' => $searchModel]),
    'header' => Yii::t('app', 'Қидирув')
]);

echo Html::beginTag('div', ['class' => 'card-body table-responsive no-padding']);

echo GridView::widget([
    'summary' => Yii::t('app', 'Намойиш этилмоқда <b>{begin, number}-{end, number}</b> та ёзув <b>{totalCount, number}</b> тадан.'),
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => ($dataProvider->totalCount > 0) ? Yii::t('app', 'Сўнгги тўлов қилинган вақт: ') . $dataProvider->models[0]->date_time : ''
    ],
    'striped' => false,
    'hover' => true,
    'filterRowOptions' => ['class' => 'hidden'],
    'resizableColumns' => true,
    'showPageSummary' => true,
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary warning'],
    'toolbar' => ['{export}'],
    'toggleDataOptions' => [
        'maxCount' => 10000,
        'minCount' => 1000,
        'confirmMsg' => Yii::t('app', 'Ҳаммасини кўришни хохлайсизми?'),
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
        'xls' => true
    ],
    'tableOptions' => ['class' => 'table table-bordered'],
    'dataProvider' => $dataProvider,
    'options' => ['class' => 'table-responsive'],
    'filterModel' => false,
    'layout' => "{items}\n{summary}\n{pager}",
    'columns' => [
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'date_time',
            'format' => 'raw',
            'value' => function (common\models\Payment $data) {
                return date('d.m.Y', strtotime($data->date_time));
            },
            'group' => true,
            'groupEvenCssClass' => 'kv-group-odd',
            'groupOddCssClass' => 'kv-group-odd',
            'headerOptions' => [
                'class' => 'col-md-1'
            ],
            'pageSummary' => function () use ($searchModel) {
                $text = "";
                if ($searchModel->date_from)
                    $text .= date('d.m.Y', strtotime($searchModel->date_from)) . ' ' . Yii::t('app', 'дан');
                if ($searchModel->date_to) {
                    if (!empty($text))
                        $text .= " ";
                    $text .= date('d.m.Y', strtotime($searchModel->date_to)) . ' ' . Yii::t('app', 'гача');
                }
                return $text;
            },
        ],
        [
            'value' => function (common\models\Payment $data) {
                return date('H:i', strtotime($data->date_time));
            },
            'headerOptions' => [
                'class' => 'col-md-1'
            ],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'client_id',
            'value' => 'client.name',
            'headerOptions' => ['class' => 'col-sm-3'],
            'contentOptions' => ['class' => 'text-bold'],
            'pageSummary' => Yii::t('app', 'Жами'),
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'pay_type_id',
            'filter' => PayType::getList(),
            'value' => 'payType.title',
            'headerOptions' => ['class' => 'col-sm-2'],
            'pageSummary' => @$searchModel->payType->title,
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'price',
            'headerOptions' => ['class' => 'col-sm-2'],
            'format' => 'decimal',
            'pageSummary' => true,
            'contentOptions' => [
                'class' => 'text-right text-bold'
            ],
            'pageSummaryOptions' => [
                'class' => 'text-right'
            ]
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'currency',
            'headerOptions' => ['class' => 'currency-column'],
            'contentOptions' => ['class' => 'text-right'],
            'pageSummary' => 'сўм',
        ],
        'comment'
    ]
]);

echo Html::endTag('div');